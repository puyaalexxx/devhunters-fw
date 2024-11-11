import ace from "ace-builds/src-min-noconflict/ace";
import "ace-builds/src-min-noconflict/theme-monokai";
import "ace-builds/src-min-noconflict/mode-javascript";
import "ace-builds/src-min-noconflict/mode-css";

(function($: JQueryStatic): void {
    "use strict";

    // @ts-ignore
    //variable is passed from wp_localize_script AceEditor class
    const dht_ace_files_path = dht_ace_editor_path.path;

    class AceEditor {
        private readonly $_ace_textarea;
        private $_ace_editor_area;
        private readonly $_ace_editor_mode;
        private _ace_editor: any;

        constructor($ace_editor_container: JQuery<HTMLElement>) {
            //textarea to send value via $_POST
            this.$_ace_textarea = $ace_editor_container.children(".dht-ace-editor");

            //editor area where the editor is displayed
            this.$_ace_editor_area = $ace_editor_container.children(".dht-ace-editor-area");

            this.$_ace_editor_mode = this.$_ace_editor_area.attr("data-editor-mode");

            //because the ace editor does not find this files correctly, we need to set them explicitly
            this._setModuleUrl();

            //init ace editor
            this._initEditor();

            //set option value to ace editor
            this._setValue();

            //set editor theme and mode
            this._setThemeAndNModeEditor();

            //Sync changes from Ace Editor back to textarea
            this._setTextareaValueFromEditor();
        }

        /**
         * because the ace editor does not find this files correctly, we need to set them explicitly
         *
         * @return void
         */
        private _setModuleUrl(): void {
            ace.config.setModuleUrl("ace/mode/css_worker", dht_ace_files_path + "src-min-noconflict/worker-css.js");
            ace.config.setModuleUrl("ace/mode/javascript_worker", dht_ace_files_path + "src-min-noconflict/worker-javascript.js");
        }

        /**
         * init ace editor
         *
         * @return void
         */
        private _initEditor(): void {
            this._ace_editor = ace.edit(this.$_ace_editor_area.attr("id"));
        }

        /**
         * set option value to ace editor
         *
         * @return void
         */
        private _setValue(): void {
            //set option value to ace editor
            this._ace_editor.session.setValue(this.$_ace_textarea.val());
        }

        /**
         * set editor theme and mode
         *
         * @return void
         */
        private _setThemeAndNModeEditor(): void {
            this._ace_editor.setTheme("ace/theme/monokai");
            this._ace_editor.session.setMode("ace/mode/" + this.$_ace_editor_mode);
        }

        /**
         * Sync changes from Ace Editor back to textarea
         *
         * @return void
         */
        private _setTextareaValueFromEditor(): void {
            const self = this;

            self._ace_editor.getSession().on("change", function() {
                self.$_ace_textarea.val(self._ace_editor.session.getValue());
            });
        }
    }

    //init each ace editor
    function init() {
        $(".dht-field-wrapper-code-editor").each(function() {
            new AceEditor($(this));
        });
    }

    // Initialize on page load
    $(function() {
        init();
    });

    // Initialize after AJAX content is loaded
    $(document).on("dht_aceEditorAjaxComplete", function() {
        init();
    });
})(jQuery);
