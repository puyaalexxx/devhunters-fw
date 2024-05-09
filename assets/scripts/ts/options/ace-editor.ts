import jQuery from 'jquery'
import ace from 'ace-builds/src-min-noconflict/ace'
import 'ace-builds/src-min-noconflict/theme-monokai'
import 'ace-builds/src-min-noconflict/mode-javascript'
import 'ace-builds/src-min-noconflict/mode-css'
//import 'ace-builds/src-min-noconflict/worker-css'
;(function ($: JQueryStatic): void {
    'use strict'

    // @ts-ignore
    //variable is passed from wp_localize_script AceEditor class
    const dht_ace_files_path = dht_ace_editor_path.path

    $('.dht-field-child-code-editor').each(function () {
        const $ace_editor_container = $(this)

        //because the ace editor does not find this files correctly, we need to set them explicitly
        ace.config.setModuleUrl(
            'ace/mode/css_worker',
            dht_ace_files_path + 'src-min-noconflict/worker-css.js'
        )
        ace.config.setModuleUrl(
            'ace/mode/javascript_worker',
            dht_ace_files_path + 'src-min-noconflict/worker-javascript.js'
        )
        //textarea to send value via $_POST
        const $ace_textarea = $ace_editor_container.children('.dht-ace-editor')

        //editor area where the editor is displayed
        const $ace_editor_area = $ace_editor_container.children(
            '.dht-ace-editor-area'
        )

        const $ace_editor_mode = $ace_editor_area.attr('data-editor-mode')

        //init ace editor
        const ace_editor = ace.edit($ace_editor_area.attr('id'))

        //set option value to ace editor
        ace_editor.session.setValue($ace_textarea.val())

        ace_editor.setTheme('ace/theme/monokai')
        ace_editor.session.setMode('ace/mode/' + $ace_editor_mode)

        // Sync changes from Ace Editor back to textarea
        ace_editor.getSession().on('change', function () {
            $ace_textarea.val(ace_editor.session.getValue())
        })
    })
})(jQuery)
