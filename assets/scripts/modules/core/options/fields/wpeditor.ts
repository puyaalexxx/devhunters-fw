(function($: JQueryStatic): void {
    "use strict";

    class WPEditor {
        //wpeditor reference
        private $_wpeditor;

        constructor($wpeditor: JQuery<HTMLElement>) {
            //wpeditor reference
            this.$_wpeditor = $wpeditor;

            //init live editing
            this._liveEditing();
        }

        /**
         * live editing
         * Ability to change other areas via changing the field
         * with the provided CSS selectors
         *
         * @return void
         */
        private _liveEditing(): void {
            const selectors = this.$_wpeditor.attr("data-live-selectors") ?? "";
            const editorID = this.$_wpeditor.find("textarea.wp-editor-area").attr("id") ?? "";

            if (selectors.length === 0 || editorID.length === 0) return;

            // visual tab output change
            function updateVisualTabOutput() {
                const content = tinymce.get(editorID).getContent();
                $(selectors).html(content); // Update the output element
            }

            // text tab output change
            function updateTextTabOutput() {
                const content = String($("#" + editorID).val());
                $(selectors).html(content); // Update the output element
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
