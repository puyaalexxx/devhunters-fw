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
         * @return void
         */
        private async _liveEditing(): Promise<void> {
            try {
                const {
                    dhtGetLiveEditingSelectors,
                    dhtApplyLiveChanges,
                } = await import("@helpers/options/live-editing");

                //get option selectors
                const selectors: ILiveEditorSelectorTarget = dhtGetLiveEditingSelectors(this.$_wpeditor);
                const editorID = this.$_wpeditor.find("textarea.wp-editor-area").attr("id") ?? "";

                if (Object.entries(selectors).length === 0 || editorID.length === 0) return;

                // visual tab output change
                function updateVisualTabOutput() {
                    const content = tinymce.get(editorID).getContent();

                    dhtApplyLiveChanges(selectors, (selector) => {
                        if (selectors.target === "content") {
                            $(selector).html(content);
                        } else {
                            $(selector).css(selectors.target, content);
                        }
                    });
                }

                // text tab output change
                function updateTextTabOutput() {
                    const content = String($("#" + editorID).val());

                    dhtApplyLiveChanges(selectors, (selector) => {
                        if (selectors.target === "content") {
                            $(selector).html(content);
                        } else {
                            $(selector).css(selectors.target, content);
                        }
                    });
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
                }, 500); // Adjust the timeout as necessary
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
