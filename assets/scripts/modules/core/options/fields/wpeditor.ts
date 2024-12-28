import { errorLoadingModule } from "@helpers/general";

(function($: JQueryStatic): void {
    "use strict";

    class WPEditor {
        //wpeditor reference
        private readonly $_wpeditor;

        constructor($wpeditor: JQuery<HTMLElement>) {
            //wpeditor reference
            this.$_wpeditor = $wpeditor;

            this._initWPEditor();
        }

        /**
         * init wpEditor
         *
         * @return void
         */
        private _initWPEditor(): void {
            const $thisClass = this;
            const editorID = this.$_wpeditor.find("textarea.wp-editor-area").attr("id") ?? "";
            if (editorID.length === 0) return;

            // Use setTimeout to ensure the editor is initialized
            setTimeout(function() {
                const editor = tinymce.get(editorID);
                if (editor) {
                    $thisClass._updateTextTabValueOnChange(editorID, editor);

                    //init live editing
                    $thisClass._liveEditing(editorID, editor).then(() => {
                    }).catch(error => {
                        console.error(error);
                    });
                }
            }, 500);
        }

        /**
         * update text tab value on change
         *
         * This is done because on ajax sending form
         * the value from the visual tab is not sent
         * via POST because the one from the text tab
         * is sent
         *
         * @param editorID
         * @param editor    Editor element
         *
         * @return void
         */
        private _updateTextTabValueOnChange(editorID: string, editor: any): void {
            const $thisClass = this;
            const textarea = $("#" + editorID);

            if (textarea) {
                editor.on("input change", function() {
                    textarea.val($thisClass._getVisualTabValue(editorID));
                });
            }
        }

        /**
         * get visual tab value
         *
         * @param editorID
         *
         * @return void
         */
        private _getVisualTabValue(editorID: string): string {
            return tinymce.get(editorID).getContent();
        }

        /**
         * get text tab value
         *
         * @param editorID
         *
         * @return void
         */
        private _getTextTabValue(editorID: string): string {
            return String($("#" + editorID).val());
        }

        /**
         * live editing
         * Ability to change other areas via changing the field
         * with the provided CSS selectors
         *
         * @param editorID
         * @param editor    Editor element
         *
         * @return Promise<void>
         */
        private async _liveEditing(editorID: string, editor: any): Promise<void> {
            //no live editor attribute
            if (!(this.$_wpeditor.attr("data-live-selectors") ?? "").length) return;

            const $thisClass = this;
            try {
                const {
                    dhtApplyChangesForNotKeyedSelectors, dhtRestoreElementDefaultValues,
                } = await import("@helpers/options/live-editing");

                dhtApplyChangesForNotKeyedSelectors(
                    this.$_wpeditor,
                    // Live change handler
                    (target: string, selectors: string) => {
                        applyChangesHelper(target,
                            () => {
                                applyHTMLChange(selectors, $thisClass._getVisualTabValue(editorID));
                            },
                            () => {
                                applyHTMLChange(selectors, $thisClass._getTextTabValue(editorID));
                            });
                    },
                    //restore to defaults
                    (target: string, selectors: string) => {
                        const defaultVisualTabValue = $thisClass._getVisualTabValue(editorID);
                        const defaultTextTabValue = $thisClass._getTextTabValue(editorID);

                        applyChangesHelper(target,
                            () => {
                                dhtRestoreElementDefaultValues($thisClass.$_wpeditor, () => {
                                    applyHTMLChange(selectors, defaultVisualTabValue);
                                });
                            },
                            () => {
                                dhtRestoreElementDefaultValues($thisClass.$_wpeditor, () => {
                                    applyHTMLChange(selectors, defaultTextTabValue);
                                });
                            });
                    },
                );

                // Helper function to apply HTML change
                function applyHTMLChange(selectors: string, content: string): void {
                    $(selectors).html(content);
                }

                //helper function to apply the content changes
                function applyChangesHelper(target: string, applyVisualTabChanges: () => void, applyTextChanges: () => void): void {
                    if (target === "content") {
                        // Listen for input and change events in the TinyMCE editor
                        editor.on("input change", function() {
                            applyVisualTabChanges();
                        });

                        // Listen for changes directly on the textarea for Text mode
                        const textarea = $("#" + editorID);
                        if (textarea) {
                            $(textarea).on("input change", function() {
                                applyTextChanges();
                            }); // Update on direct textarea input
                        }
                    }
                }
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
