import { errorLoadingModule } from "@helpers/general";

(function($: JQueryStatic): void {
    "use strict";

    class WPEditor {
        //wpeditor reference
        private readonly $_wpeditor;

        constructor($wpeditor: JQuery<HTMLElement>) {
            //wpeditor reference
            this.$_wpeditor = $wpeditor;

            //init live editing
            this._liveEditing().then(() => {
            }).catch(error => {
                console.error(error);
            });
        }

        /**
         * live editing
         * Ability to change other areas via changing the field
         * with the provided CSS selectors
         *
         * @return Promise<void>
         */
        private async _liveEditing(): Promise<void> {
            //no live editor attribute
            if (!(this.$_wpeditor.attr("data-live-selectors") ?? "").length) return;

            try {
                const { dhtNotKeyedSelectorsHelper } = await import("@helpers/options/live-editing");
                const editorID = this.$_wpeditor.find("textarea.wp-editor-area").attr("id") ?? "";

                //the code below depends on the editor ID
                if (editorID.length === 0) return;

                dhtNotKeyedSelectorsHelper(this.$_wpeditor, (target: string, selectors: string) => {
                    // visual tab output change
                    function updateVisualTabOutput() {
                        const content = tinymce.get(editorID).getContent();

                        if (target === "content") {
                            $(selectors).html(content);
                        }
                    }

                    // text tab output change
                    function updateTextTabOutput() {
                        const content = String($("#" + editorID).val());

                        if (target === "content") {
                            $(selectors).html(content);
                        }
                    }

                    // Use setTimeout to ensure the editor is initialized
                    setTimeout(function() {
                        const editor = tinymce.get(editorID);
                        if (editor) {
                            // Listen for input and change events in the TinyMCE editor
                            editor.on("input change", updateVisualTabOutput);

                            // Listen for changes directly on the textarea for Text mode
                            const textarea = $("#" + editorID);
                            if (textarea) {
                                $(textarea).on("input change", updateTextTabOutput); // Update on direct textarea input
                            }
                        }
                    }, 500);
                });
            } catch (error) {
                errorLoadingModule(error as string);
            }
        }
    }

    //init each wpeditor option
    function init() {
        $(".dht-field-wrapper-editor").each(function() {
            new WPEditor($(this));
        });
    }

    // Initialize on page load
    $(function() {
        init();
    });

    // Initialize after AJAX content is loaded
    $(document).on("dht_wpEditorAjaxComplete", function() {
        init();
    });
})(jQuery);
