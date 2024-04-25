<?php

?>

<!-- field - input -->
<div class="dht-field-wrapper">
    <div class="dht-title">Text Input</div>
    <div class="dht-field-child-wrapper dht-field-child-input">
        <label for="test-input">Input</label>
        <input class="dht-input dht-field" id="test-input" type="text" name="test-input" value="" title="title" />
        <div class="dht-description">Field description</div>
    </div>
    <div class="dht-info-help dashicons dashicons-info"
         data-tooltips="A little box to something to make it longer"
         data-position="OnLeft">
    </div>
</div>
<div class="dht-divider"></div>

<!-- https://www.w3schools.com/html/html_form_input_types.asp-->

<!-------------------------------------------------------------------------------------->

<!-- field - textarea -->
<div class="dht-field-wrapper">
    <div class="dht-title">Textarea</div>
    <div class="dht-field-child-wrapper dht-field-child-textarea">
        <label for="textarea">Textarea</label>
        <textarea class="dht-textarea dht-field" id="textarea" name="textarea" placeholder="Textarea"
                  rows="6"></textarea>
        <div class="dht-description">Field description</div>
    </div>
    <div class="dht-info-help dashicons dashicons-info"
         data-tooltips="A little box to something to make it longer"
         data-position="OnLeft">
    </div>
</div>
<div class="dht-divider"></div>

<!-------------------------------------------------------------------------------------->

<!-- field - checkbox -->
<div class="dht-field-wrapper">
    <div class="dht-title">Checkbox</div>
    <div class="dht-field-child-wrapper dht-field-child-checkbox">
        
        <div class="dht-checkbox-wrapper">
            <input class="dht-checkbox dht-field" type="checkbox" name="checkbox[]" id="checkbox-1"
                   value="1" checked="checked" />
            <label for="checkbox-1">Option 1</label>
        </div>
        
        <div class="dht-description">Field description</div>
    </div>
    <div class="dht-info-help dashicons dashicons-info"
         data-tooltips="A little box to something to make it longer"
         data-position="OnLeft">
    </div>
</div>
<div class="dht-divider"></div>

<div class="dht-field-wrapper">
    <div class="dht-title">Checkboxes</div>
    <div class="dht-field-child-wrapper dht-field-child-checkbox">
        
        <div class="dht-checkbox-wrapper">
            <input class="dht-checkbox dht-field" type="checkbox" name="checkbox[]" id="checkbox-1"
                   value="1" checked="checked" />
            <label for="checkbox-1">Option 1</label>
        </div>
        
        <div class="dht-checkbox-wrapper">
            <input class="dht-checkbox dht-field" type="checkbox" name="checkbox[]" id="checkbox-2"
                   value="2" />
            <label for="checkbox-2">Option 2</label>
        </div>
        
        <div class="dht-checkbox-wrapper">
            <input class="dht-checkbox dht-field" type="checkbox" name="checkbox[]" id="checkbox-3"
                   value="3" />
            <label for="checkbox-3">Option 3</label>
        </div>
        
        <div class="dht-description">Field description</div>
    </div>
    <div class="dht-info-help dashicons dashicons-info"
         data-tooltips="A little box to something to make it longer"
         data-position="OnLeft">
    </div>
</div>
<div class="dht-divider"></div>

<style>
    /*checkbox styles*/
    .dht-field-child-wrapper .dht-checkbox:first-child {
        margin-top: 0px;
    }
    .dht-field-child-wrapper .dht-checkbox {
        margin-top: 10px;
    }
    .dht-field-child-wrapper .dht-checkbox-wrapper .dht-checkbox {
        float: left;
    }
    .dht-field-child-wrapper .dht-checkbox-wrapper label {
        display: block;
    }
    .dht-checkbox-wrapper {
        clear: both;
    }
    .dht-checkbox-wrapper {
        margin-bottom: 10px;
    }
    .dht-checkbox-wrapper:last-child {
        margin-bottom: 0px;
    }
</style>

<!-------------------------------------------------------------------------------------->


<!-- field - radio -->
<div class="dht-field-wrapper">
    <div class="dht-title">Radio Boxes</div>
    <div class="dht-field-child-wrapper dht-field-child-radio">
        
        <div class="dht-radio-wrapper">
            <input class="dht-radio dht-field" type="radio" name="radio[]" id="radio-1" value="1"
                   checked="checked" />
            <label for="radio-1">Option 1</label>
        </div>
        
        <div class="dht-radio-wrapper">
            <input class="dht-radio dht-field" type="radio" name="radio[]" id="radio-2" value="2" />
            <label for="radio-2">Option 2</label>
        </div>
        
        <div class="dht-radio-wrapper">
            <input class="dht-radio dht-field" type="radio" name="radio[]" id="radio-3" value="3" />
            <label for="radio-3">Option 3</label>
        </div>
        
        <div class="dht-description">Field description</div>
    </div>
    <div class="dht-info-help dashicons dashicons-info"
         data-tooltips="A little box to something to make it longer"
         data-position="OnLeft">
    </div>
</div>
<div class="dht-divider"></div>

<style>
    /*radio styles*/
    .dht-field-child-wrapper .dht-radio:first-child {
        margin-top: 0px;
    }
    
    .dht-field-child-wrapper .dht-radio {
        margin-top: 10px;
    }
    
    .dht-field-child-wrapper .dht-radio-wrapper .dht-radio {
        float: left;
    }
    
    .dht-field-child-wrapper .dht-radio-wrapper label {
        display: block;
    }
    
    .dht-radio-wrapper {
        clear: both;
    }
    
    .dht-radio-wrapper {
        margin-bottom: 10px;
    }
    
    .dht-radio-wrapper:last-child {
        margin-bottom: 0px;
    }
</style>

<!-------------------------------------------------------------------------------------->

<!-- field - simple text -->
<div class="dht-field-wrapper">
    <div class="dht-title">some text</div>
    <div class="dht-field-child-wrapper dht-field-child-text">
        
        <div class="dht-description">Field description</div>
    </div>
    <div class="dht-info-help dashicons dashicons-info"
         data-tooltips="A little box to something to make it longer"
         data-position="OnLeft">
    </div>
</div>
<div class="dht-divider"></div>

<!-------------------------------------------------------------------------------------->

<!-- field - wpeditor - type -> nomedia -->
<div class="dht-field-wrapper">
    <div class="dht-title">WP Editor No Media</div>
    <div class="dht-field-child-wrapper dht-field-child-editor">
        <?php wp_editor( '', 'my_editor_id', [ 'media_buttons' => false, 'textarea_rows' => 10 ] ); ?>
        <div class="dht-description">Field description</div>
    </div>
    
    <div class="dht-info-help dashicons dashicons-info"
         data-tooltips="A little box to something to make it longer"
         data-position="OnLeft">
    </div>
</div>
<div class="dht-divider"></div>

<!-- field - wpeditor -->
<div class="dht-field-wrapper">
    <div class="dht-title">WP Editor</div>
    <div class="dht-field-child-wrapper dht-field-child-editor">
        <?php wp_editor( '', 'editor_id', [ 'textarea_rows' => 10 ] ); ?>
        <div class="dht-description">Field description</div>
    </div>
    <div class="dht-info-help dashicons dashicons-info"
         data-tooltips="A little box to something to make it longer"
         data-position="OnLeft">
    </div>
</div>
<div class="dht-divider"></div>

<!-------------------------------------------------------------------------------------->

<!-- field - switch  -->
<div class="dht-field-wrapper">
    <div class="dht-title">Switch Buttons</div>
    <div class="dht-field-child-wrapper dht-field-child-switch">
        
        <label class="dht-switch">
            <input type="checkbox" name="switch" value="newsletter">
            <span class="dht-slider">
                            <span class="dht-slider-yes">Enable</span>
                            <span class="dht-slider-no">Disable</span>
                        </span>
        </label>
        
        <div class="dht-description">Field description</div>
    </div>
    
    <div class="dht-info-help dashicons dashicons-info"
         data-tooltips="A little box to something to make it longer"
         data-position="OnLeft">
    </div>
</div>
<div class="dht-divider"></div>

<style>
    /* switch button styles*/
    label.dht-switch {
        display: block;
    }
    .dht-switch {
        position: relative;
        display: inline-block;
        width: 125px;
        height: 34px;
    }
    
    .dht-switch input {
        opacity: 0;
        width: 0;
        height: 0;
        border-radius: 3px;
    }
    
    .dht-switch .dht-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
        border-radius: 3px;
    }
    
    .dht-switch .dht-slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 60px;
        left: -25px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
        z-index: 9;
    }
    
    .dht-switch input:checked + .dht-slider  {
        background-color: rgb(99, 91, 255);
    }
    
    .dht-switch input:focus +  .dht-slider  {
        box-shadow: 0 0 1px rgb(99, 91, 255);
    }
    
    .dht-switch input:checked + .dht-slider:before {
        -webkit-transform: translateX(85px);
        -ms-transform: translateX(85px);
        transform: translateX(85px);
    }
    .dht-switch input + .dht-slider:before {
        -webkit-transform: translateX(30px);
        -ms-transform: translateX(30px);
        transform: translateX(30px);
    }
    .dht-switch .dht-slider span {
        color: #fff;
        position: relative;
        top: 7px;
        font-weight: 600;
        font-size: 15px;
    }
    span.dht-slider-yes {
        left: 7px;
    }
    span.dht-slider-no {
        right: -20px;
    }
    @media (max-width: 980px) {
        label.dht-switch {
            margin: auto;
        }
    }
</style>

<!-------------------------------------------------------------------------------------->

<!-- field - dropdown - type-> group-->
<div class="dht-field-wrapper">
    <div class="dht-title">Dropdown Group Multiple</div>
    <div class="dht-field-child-wrapper dht-field-child-dropdown">
        <label for="cars4">Choose cars:</label>
        <select class="dht-dropdown dht-field" name="cars4" id="cars4" multiple  size="6">
            <optgroup label="Swedish Cars">
                <option value="volvo">Volvo</option>
                <option value="saab">Saab</option>
            </optgroup>
            <optgroup label="German Cars">
                <option value="mercedes">Mercedes</option>
                <option value="audi">Audi</option>
            </optgroup>
        </select>
        <div class="dht-description">Field description</div>
    </div>
    <div class="dht-info-help dashicons dashicons-info"
         data-tooltips="A little box to something to make it longer"
         data-position="OnLeft">
    </div>
</div>
<div class="dht-divider"></div>

<!-- field - dropdown - type-> group-->
<div class="dht-field-wrapper">
    <div class="dht-title">Dropdown Group</div>
    <div class="dht-field-child-wrapper dht-field-child-dropdown">
        <label for="cars3">Choose a car:</label>
        <select class="dht-dropdown dht-field" name="cars3" id="cars3" >
            <optgroup label="Swedish Cars">
                <option value="volvo">Volvo</option>
                <option value="saab">Saab</option>
            </optgroup>
            <optgroup label="German Cars">
                <option value="mercedes">Mercedes</option>
                <option value="audi">Audi</option>
            </optgroup>
        </select>
        <div class="dht-description">Field description</div>
    </div>
    <div class="dht-info-help dashicons dashicons-info"
         data-tooltips="A little box to something to make it longer"
         data-position="OnLeft">
    </div>
</div>
<div class="dht-divider"></div>

<!-- field - dropdown - type-> multipleselect-->
<div class="dht-field-wrapper">
    <div class="dht-title">Dropdown Multiple</div>
    <div class="dht-field-child-wrapper dht-field-child-dropdown">
        <label for="cars2">Choose cars:</label>
        <select class="dht-dropdown dht-field" name="cars2" id="cars2" multiple  size="6">
            <option value="volvo">Volvo</option>
            <option value="saab">Saab</option>
            <option value="mercedes">Mercedes</option>
            <option value="audi">Audi</option>
        </select>
        <div class="dht-description">Field description</div>
    </div>
    <div class="dht-info-help dashicons dashicons-info"
         data-tooltips="A little box to something to make it longer"
         data-position="OnLeft">
    </div>
</div>
<div class="dht-divider"></div>

<!-- field - dropdown -->
<div class="dht-field-wrapper">
    <div class="dht-title">Dropdown</div>
    <div class="dht-field-child-wrapper dht-field-child-dropdown">
        <label for="cars">Choose a car:</label>
        <select class="dht-dropdown dht-field" name="cars" id="cars">
            <option value="volvo">Volvo</option>
            <option value="saab">Saab</option>
            <option value="mercedes">Mercedes</option>
            <option value="audi">Audi</option>
        </select>
        <div class="dht-description">Field description</div>
    </div>
    <div class="dht-info-help dashicons dashicons-info"
         data-tooltips="A little box to something to make it longer"
         data-position="OnLeft">
    </div>
</div>
<div class="dht-divider"></div>

<style>
    /* dropdown styles*/
    .dht-dropdown.dht-field {
        max-width: 100%;
    }
</style>

<!-------------------------------------------------------------------------------------->

<!-- field - multiinput -->
<div class="dht-field-wrapper">
    <div class="dht-title">MultiText Input</div>
    <div class="dht-field-child-wrapper dht-field-child-multiinput">
        <label for="multi-input">Label</label>
        
        <div class="dht-multiinput-child-wrapper">
            <input class="dht-multi-input dht-field" id="multi-input" type="text" name="multi-input[optionid][]" title="title" value="" />
            <a href="javascript:void(0);" class="dht-multiinput-remove">Remove</a>
        </div>
        
        <a href="javascript:void(0);" class="dht-button dht-btn-small dht-multiinput-add">Add More</a>
        
        <div class="dht-description">Field description</div>
        
        <div class="dht-multiinput-remove-text">Can't remove the only field</div>
    </div>
    <div class="dht-info-help dashicons dashicons-info"
         data-tooltips="A little box to something to make it longer"
         data-position="OnLeft">
    </div>
</div>
<div class="dht-divider"></div>

<style>
    /* multiinput styles*/
    .dht-multiinput-child-wrapper {
        margin-bottom: 10px;
    }
    a.dht-multiinput-remove {
        text-align: right;
        display: block;
        color: rgb(99, 91, 255);
    }
    .dht-multiinput-child-wrapper + .dht-button + .dht-description {
        margin-top: 12px;
    }
    .dht-multiinput-remove-text{
        display:none;
    }
    .dht-multi-input {
        margin-bottom: 5px;
    }
</style>

<script>
    /* multiinput field */
    jQuery(document).ready(function() {
        
        jQuery('.dht-multiinput-add').on('click', function() {
            let $this =  jQuery(this);
            
            let $field = $this.prev('.dht-multiinput-child-wrapper').clone();
            
            $field.insertBefore($this);
        });
        
        jQuery('body').on('click', '.dht-multiinput-remove', function() {
            let $this =  jQuery(this);
            
            if($this.parents('.dht-field-child-wrapper').children('.dht-multiinput-child-wrapper').length === 1)
            {
                confirm(jQuery(this).parents('.dht-field-multiinput-child-wrapper').find('.dht-multiinput-remove-text').text());
                
                return;
            }
            
            $this.parent('.dht-multiinput-child-wrapper').remove();
        });
    })
</script>

<!-------------------------------------------------------------------------------------->

<!-- field - sortable -->
<div class="dht-field-wrapper">
    <div class="dht-title">Sortable</div>
    <div class="dht-field-child-wrapper dht-field-child-sortable">
        
        <div class="dht-sortable-fields">
            
            <div class="dht-sortable-field">
                <label for="sortable-input">Sortable</label>
                <input class="dht-sortable dht-field" id="sortable-input" type="text" name="sortable-input" value="" title="title" placeholder="text 1" />
                <span class="dht-drag"><i class="dashicons dashicons-menu icon-large"></i></span>
            </div>
            
            <div class="dht-sortable-field">
                <label for="sortable2-input">Sortable 2</label>
                <input class="dht-sortable dht-field" id="sortable2-input" type="text" name="sortable2-input" value="" placeholder="text 2" title="title" />
                <span class="dht-drag"><i class="dashicons dashicons-menu icon-large"></i></span>
            </div>
            
            <div class="dht-sortable-field">
                <label for="textarea-sortable">Textarea</label>
                <textarea class="dht-textarea dht-field" id="textarea-sortable" name="textarea" placeholder="Textarea"
                          rows="6"></textarea>
                <span class="dht-drag"><i class="dashicons dashicons-menu icon-large"></i></span>
            </div>
        </div>
        
        <div class="dht-description">Field description</div>
    </div>
    <div class="dht-info-help dashicons dashicons-info"
         data-tooltips="A little box to something to make it longer"
         data-position="OnLeft">
    </div>
</div>
<div class="dht-divider"></div>

<style>
    /* sortable styles*/
    .dht-sortable-field {
        margin-bottom: 10px;
    }
    .dht-sortable-field {
        display: flex;
        align-items: center;
    }
    span.dht-drag {
        margin-left: 10px;
        cursor: pointer;
    }
</style>

<script>
    //sortable field
    jQuery(document).ready(function() {
        jQuery( ".dht-sortable-fields" ).sortable();
    });
</script>

<?php

// field - datepicker_sortable
add_action( 'admin_enqueue_scripts', 'datepicker_sortable' );
function datepicker_sortable() {
    
    wp_register_style( 'dht-jquery-ui-css', DHT_ASSETS_URI . 'styles/libraries/jquery-ui.min.css', array(), '1.0' );
    wp_enqueue_style( 'dht-jquery-ui-css' );
    
    wp_enqueue_script( 'dht-jquery-ui', DHT_ASSETS_URI . 'scripts/libraries/jquery-ui.min.js', array(), '1.0', true );
}

// field - timepicker_sortable
add_action( 'admin_enqueue_scripts', 'timepicker' );
function timepicker() {
    
    wp_register_style( 'dht-jquery-ui-timepicker-css', DHT_ASSETS_URI . 'styles/libraries/jquery-ui-timepicker-addon.min.css', array(), '1.0' );
    wp_enqueue_style( 'dht-jquery-ui-timepicker-css' );
    
    wp_enqueue_script( 'dht-jquery-ui-timepicker', DHT_ASSETS_URI . 'scripts/libraries/jquery-ui-timepicker-addon.min.js', array( 'dht-jquery-ui' ), '1.0', true );
}

?>

<!-------------------------------------------------------------------------------------->

<!-- field - colorpicker -->
<script>
    jQuery(document).ready(function($){
        
        jQuery( ".dht-alphacolorpicker" ).wpColorPicker({ });
        
        let $delete_btn = jQuery('#dht-default-color-btn11');
        
        $delete_btn.insertAfter(jQuery('.dht-alphacolorpicker').parent('label'));
        
        $delete_btn.on('click', function() {
            let defaultColor = 'rgb(238, 238, 34, 0.5)'; // Set your default color here
            jQuery('.dht-alphacolorpicker').wpColorPicker('color', defaultColor);
        });
    });
</script>
<div class="dht-field-wrapper">
    <div class="dht-title">Alpha Colorpicker</div>
    <div class="dht-field-child-wrapper dht-field-child-colorpicker">
        <label for="colorpicker-input"></label>
        <input class="dht-alphacolorpicker dht-field" id="alphacolorpicker-input" type="text"
               data-alpha="true" data-reset="true"
               name="alphacolorpicker-input" value="rgb(238, 238, 34, 0.5)" title="title" />
        <input type="button" id="dht-default-color-btn11" class="dht-default-color-btn button button-small" value="Default">
        <div class="dht-description">Field description</div>
    </div>
    <div class="dht-info-help dashicons dashicons-info"
         data-tooltips="A little box to something to make it longer"
         data-position="OnLeft">
    </div>
</div>
<div class="dht-divider"></div>

<style>
    /* wp-color-picker-alpha.css */
    .dht-field-child-wrapper .wp-picker-input-wrap label {
        display: block;
    }
    .wp-core-ui .dht-field-child-wrapper .wp-picker-active .button.hidden {
        display: block;
    }
    .dht-field-child-wrapper .wp-picker-open + span.wp-picker-input-wrap {
        width: 210px;
        display: flex !important;
    }
    .dht-default-color-btn{
        display:none !important;
        margin-left: 6px !important;
    }
    .wp-picker-container.wp-picker-active .dht-default-color-btn {
        display:block !important;
    }
</style>

<?php
// field - colorpicker - opacity
add_action( 'admin_enqueue_scripts', 'alpha_picker' );
function alpha_picker(){
    
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script( 'wp-color-picker' );
    
    wp_enqueue_script( 'wp-color-picker-alpha',DHT_ASSETS_URI . 'scripts/libraries/wp-color-picker-alpha.min.js', array( 'wp-color-picker' ));
    /*wp_add_inline_script(
        'wp-color-picker-alpha',
        'jQuery( function() { jQuery( ".dht-alphacolorpicker" ).wpColorPicker(); } );'
    );*/
    
}
?>

<!-------------------------------------------------------------------------------------->

<!-- field - aceeditor - type -> css / js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.12/ace.js" type="text/javascript" charset="utf-8"></script>

<script>
    jQuery(document).ready(function(){
        let textarea = jQuery('#ace-editor2');
        
        //init ace editor
        let editor = ace.edit("dht-editor2");
        
        //set option value to ace editor
        editor.session.setValue(textarea.val());
        
        editor.setTheme("ace/theme/monokai");
        editor.session.setMode("ace/mode/javascript");
        
        // Sync changes from Ace Editor back to textarea
        editor.getSession().on('change', function(){
            textarea.val(editor.session.getValue());
        });
    });
</script>

<div class="dht-field-wrapper">
    <div class="dht-title">Ace Javascript editor</div>
    <div class="dht-field-child-wrapper dht-field-child-code-editor">
        
        <label for="ace-editor2"></label>
        <textarea class="dht-ace-editor dht-field" id="ace-editor2" name="aceeditor2" style="display:none;"></textarea>
        <div id="dht-editor2" style="height: 300px;"></div>
        
        <div class="dht-description">Field description</div>
    </div>
    <div class="dht-info-help dashicons dashicons-info"
         data-tooltips="A little box to something to make it longer"
         data-position="OnLeft">
    </div>
</div>
<div class="dht-divider"></div>

<script>
    jQuery(document).ready(function(){
        let textarea = jQuery('.dht-ace-editor');
        
        //init ace editor
        let editor = ace.edit("dht-editor1");
        
        //set option value to ace editor
        editor.session.setValue(textarea.val());
        
        editor.setTheme("ace/theme/monokai");
        editor.session.setMode("ace/mode/css");
        
        // Sync changes from Ace Editor back to textarea
        editor.getSession().on('change', function(){
            textarea.val(editor.session.getValue());
        });
    });
</script>

<div class="dht-field-wrapper">
    <div class="dht-title">Ace CSS editor</div>
    <div class="dht-field-child-wrapper dht-field-child-code-editor">
        
        <label for="ace-editor"></label>
        <textarea class="dht-ace-editor dht-field" id="ace-editor" name="aceeditor" style="display:none;"></textarea>
        <div id="dht-editor1" style="height: 300px;"></div>
        
        <div class="dht-description">Field description</div>
    </div>
    <div class="dht-info-help dashicons dashicons-info"
         data-tooltips="A little box to something to make it longer"
         data-position="OnLeft">
    </div>
</div>
<div class="dht-divider"></div>

<!-------------------------------------------------------------------------------------->

<!-- field - datepicker -->
<script>
    jQuery(document).ready(function(){
        jQuery( ".dht-datepicker" ).datepicker({
            dateFormat: "yy-mm-dd"
        });
    });
</script>

<div class="dht-field-wrapper">
    <div class="dht-title">Datepicker Input</div>
    <div class="dht-field-child-wrapper dht-field-child-datepicker">
        <label for="test-input">Datepicker</label>
        <input class="dht-datepicker dht-field" id="datepicker-input" type="text" name="datepicker-input" value="" title="title" />
        <div class="dht-description">Field description</div>
    </div>
    <div class="dht-info-help dashicons dashicons-info"
         data-tooltips="A little box to something to make it longer"
         data-position="OnLeft">
    </div>
</div>
<div class="dht-divider"></div>

<style>
    /* datepicker field */
    div#ui-datepicker-div {
        z-index: 99 !important;
    }
    .ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active,
    a.ui-button:active, .ui-button:active, .ui-button.ui-state-active:hover {
        border: 1px solid rgb(99, 91, 255);
        background: rgb(99, 91, 255);
        color: #fff;
    }
    .ui-datepicker .ui-datepicker-header {
        background: rgb(99, 91, 255);
        color: #fff;
    }
    .ui-datepicker .ui-datepicker-prev, .ui-datepicker .ui-datepicker-next {
        background: #fff;
    }
    .ui-widget-header .ui-icon {
        background-image: url(<?php echo DHT_ASSETS_URI . 'images/ui-icons_454545_256x240.png'; ?>);
    }
</style>


<!-- field - timepicker -->
<script>
    jQuery(document).ready(function(){
        jQuery( ".dht-timepicker" ).timepicker({
            timeFormat: 'HH:mm:ss',
            interval: 15,
            /* minTime: '10:00am',
            maxTime: '6:00pm',
            startTime: '10:00am',*/
            dynamic: false,
            dropdown: true,
            scrollbar: true
        });
    });
</script>

<div class="dht-field-wrapper">
    <div class="dht-title">Timepicker</div>
    <div class="dht-field-child-wrapper dht-field-child-datepicker">
        <label for="test-input">Timepicker</label>
        <input class="dht-timepicker dht-field" id="timepicker-input" type="text" name="timepicker-input" value="" title="title" />
        <div class="dht-description">Field description</div>
    </div>
    <div class="dht-info-help dashicons dashicons-info"
         data-tooltips="A little box to something to make it longer"
         data-position="OnLeft">
    </div>
</div>
<div class="dht-divider"></div>

<style>
    /* timepicker field */
    .ui-timepicker-div .ui-widget-header {
        background: rgb(99, 91, 255);
        color: #fff;
    }
    .ui-timepicker-div span.ui-slider-handle.ui-corner-all.ui-state-default {
        position: absolute;
        z-index: 2;
        width: 1.2em;
        height: 1.2em;
        cursor: default;
        -ms-touch-action: none;
        touch-action: none;
        top: -6px;
    }
    .ui-timepicker-div .ui-slider-horizontal.ui-widget.ui-widget-content {
        height: 0.5em;
        position: relative;
        top: 5px;
        margin-bottom: 25px;
    }
</style>

<!-- field - datetimepicker -->
<script>
    jQuery(document).ready(function(){
        jQuery( ".dht-datetimepicker" ).datetimepicker({
            dateFormat: "yy-mm-dd",
            timeFormat: 'HH:mm:ss',
            interval: 15,
            /* minTime: '10:00am',
            maxTime: '6:00pm',
            startTime: '10:00am',*/
            dynamic: false,
            dropdown: true,
            scrollbar: true
        });
    });
</script>

<div class="dht-field-wrapper">
    <div class="dht-title">DateTimepicker</div>
    <div class="dht-field-child-wrapper dht-field-child-datepicker">
        <label for="test-input">DateTimepicker</label>
        <input class="dht-datetimepicker dht-field" id="datetimepicker-input" type="text" name="datetimepicker-input" value="" title="title" />
        <div class="dht-description">Field description</div>
    </div>
    <div class="dht-info-help dashicons dashicons-info"
         data-tooltips="A little box to something to make it longer"
         data-position="OnLeft">
    </div>
</div>
<div class="dht-divider"></div>

<?php
// field - datepicker_sortable
add_action( 'admin_enqueue_scripts', 'datepicker_sortable' );
function datepicker_sortable(){
    wp_register_style( 'dht-jquery-ui-css', DHT_ASSETS_URI . 'styles/libraries/jquery-ui.min.css', array(), '1.0' );
    wp_enqueue_style( 'dht-jquery-ui-css' );
    
    wp_enqueue_script( 'dht-jquery-ui',DHT_ASSETS_URI . 'scripts/libraries/jquery-ui.min.js', array(), '1.0', true);
}

// field - timepicker_sortable
add_action( 'admin_enqueue_scripts', 'timepicker' );
function timepicker(){
    wp_register_style( 'dht-jquery-ui-timepicker-css', DHT_ASSETS_URI . 'styles/libraries/jquery-ui-timepicker-addon.min.css', array(), '1.0' );
    wp_enqueue_style( 'dht-jquery-ui-timepicker-css' );
    
    wp_enqueue_script( 'dht-jquery-ui-timepicker',DHT_ASSETS_URI . 'scripts/libraries/jquery-ui-timepicker-addon.min.js', array( 'dht-jquery-ui' ), '1.0', true);
}
?>

<!-------------------------------------------------------------------------------------->

<!-- field - disabled -->
<div class="dht-field-wrapper">
    <div class="dht-title">Disabled Input</div>
    <div class="dht-field-child-wrapper dht-disabled">
        
        <div class="dht-field-child-group">
            <label for="test-input">Disabled</label>
            <input class="dht-input dht-field" id="test-input111" type="text" name="test-input11" value="" title="title" />
        </div>
        
        <div class="dht-field-child-group">
            <label for="test-input">Disabled</label>
            <input class="dht-input dht-field" id="test-input111" type="text" name="test-input11" value="" title="title" />
        </div>
        <div class="dht-description">Field description</div>
    </div>
    <div class="dht-info-help dashicons dashicons-info"
         data-tooltips="A little box to something to make it longer"
         data-position="OnLeft">
    </div>
</div>
<div class="dht-divider"></div>

<style>
    /* disabled field */
    .dht-disabled {
        pointer-events: none;
        background: rgba(0, 0, 0, 0.25);
        opacity: 0.45;
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        padding: 20px 10px !important;
        position: relative;
    }
    .dht-disabled::before {
        color: #fff;
        font-family: dashicons;
        content: "\f160";
        font-size: 60px;
        position: absolute;
        z-index: 1000;
        text-shadow: 2px 2px #0e0e0e;
        left: 50%;
        top: 50%;
        margin-left: -25px;
        transform: translate(-50%, -50%);
    }
</style>

<!-------------------------------------------------------------------------------------->

<!-- field - group -->
<div class="dht-field-wrapper">
    <div class="dht-title">Group Fields</div>
    <div class="dht-field-child-wrapper dht-field-child-groups">
        
        <div class="dht-field-child-group">
            <label for="test-input">Group Fields</label>
            <input class="dht-input dht-field" id="test-input111" type="text" name="group[group_name][]" value="" title="title" />
            <div class="dht-description">Field description</div>
        </div>
        
        <div class="dht-field-child-group">
            <label for="test-input">Disabled</label>
            <input class="dht-input dht-field" id="test-input111" type="text" name="group[group_name][]" value="" title="title" />
            <div class="dht-description">Field description</div>
        </div>
        
        <div class="dht-field-child-group">
            <label for="cars4">Choose cars:</label>
            <select class="dht-dropdown dht-field" name="group[group_name][]" id="cars4" multiple  size="6">
                <optgroup label="Swedish Cars">
                    <option value="volvo">Volvo</option>
                    <option value="saab">Saab</option>
                </optgroup>
                <optgroup label="German Cars">
                    <option value="mercedes">Mercedes</option>
                    <option value="audi">Audi</option>
                </optgroup>
            </select>
            <div class="dht-description">Field description</div>
        </div>
        
        <div class="dht-description">Group description</div>
    </div>
    
    <div class="dht-info-help dashicons dashicons-info"
         data-tooltips="A little box to something to make it longer"
         data-position="OnLeft">
    </div>
</div>
<div class="dht-divider"></div>

<style>
    /* group options fields */
    .dht-field-child-group {
        margin-bottom: 20px;
    }
</style>

<!-------------------------------------------------------------------------------------->

<!-- field - rangeslider -->
<script>
    jQuery(document).ready(function($){
        jQuery( "#dht-rangeslider11" ).slider({
            range: true,
            value: 5,
            min: 1,
            max: 200,
            values: [ 25, 100 ],
            slide: function( event, ui ) {
                jQuery( "#test-000000" ).val( ui.values[ 0 ] );
                jQuery( "#test-111111" ).val( ui.values[ 1 ] );
            }
        });
        jQuery( "#test-000000" ).val(jQuery( "#dht-rangeslider11" ).slider( "values", 0 ));
        jQuery( "#test-111111" ).val(jQuery( "#dht-rangeslider11" ).slider( "values", 1 ));
    });
</script>
<div class="dht-field-wrapper">
    <div class="dht-title">Range Slider field</div>
    <div class="dht-field-child-wrapper dht-field-child-rangeslider">
        
        <div class="dht-slider-group">
            <label for="test-input">Range Sldier field</label>
            <input class="dht-range-slider dht-field" id="test-000000" type="text" name="rangeslider[]" value="" title="title" />
            -
            <label for="test-input">Range Sldier field</label>
            <input class="dht-range-slider dht-field" id="test-111111" type="text" name="rangeslider" value="" title="title" />
        </div>
        <div id="dht-rangeslider11" class="dht-slider-slider"></div>
        
        <div class="dht-description">Field description</div>
    </div>
    
    <div class="dht-info-help dashicons dashicons-info"
         data-tooltips="A little box to something to make it longer"
         data-position="OnLeft">
    </div>
</div>
<div class="dht-divider"></div>

<!-- field - slider -->
<script>
    jQuery(document).ready(function($){
        jQuery( "#dht-slider11" ).slider({
            range: "min",
            value: 5,
            min: 1,
            max: 20,
            slide: function( event, ui ) {
                jQuery( "#test-345" ).val( ui.value );
            }
        });
        jQuery( "#test-345" ).val( jQuery( "#dht-slider11" ).slider( "value" ) );
    });
</script>
<div class="dht-field-wrapper">
    <div class="dht-title">Slider field</div>
    <div class="dht-field-child-wrapper dht-field-child-rangeslider">
        
        <label for="test-input">Slider field</label>
        <input class="dht-slider dht-field" id="test-345" type="text" name="slider" value="" title="title" />
        <div id="dht-slider11" class="dht-slider-slider"></div>
        <div class="dht-description">Field description</div>
    </div>
    
    <div class="dht-info-help dashicons dashicons-info"
         data-tooltips="A little box to something to make it longer"
         data-position="OnLeft">
    </div>
</div>
<div class="dht-divider"></div>

<style>
    /* slider field */
    .dht-slider-group {
        display: flex;
        align-items: center;
    }
    .dht-slider-group .dht-range-slider {
        width: 200px;
    }
    .dht-slider-group .dht-range-slider:last-child {
        margin-right: 0;
        margin-left: 10px;
    }
    .dht-slider-group .dht-range-slider {
        margin-right: 10px;
    }
    .dht-slider {
        width: 200px !important;
    }
    .dht-slider-slider {
        margin-top: 20px;
        height: 15px;
    }
    .dht-slider-slider span.ui-slider-handle {
        height: 25px;
        width: 25px;
        top: -6px;
        border: 1px solid #c5c5c5;
        background: #ffff;
    }
    .dht-slider-slider .ui-slider-range.ui-corner-all {
        background: rgb(99, 91, 255);
    }
</style>

<!-------------------------------------------------------------------------------------->

<!-- field - upload gallery -->
<script>
    jQuery(document).ready(function($){
        $('.dht-upload-gallery-button').click(function() {
            const $this = jQuery(this);
            const $hidden_input = $('.dht-upload-gallery-hidden');
            
            //open WP media popup
            const custom_uploader = wp.media({
                title: 'Choose Images',
                button: {
                    text: 'Choose Images',
                },
                library: { type: 'image' },
                multiple: true
            });
            
            //do manipulations after inserting the images
            custom_uploader.on('select', function() {
                let $gallery_div = $this.siblings('.dht-gallery-group');
                $gallery_div.empty();
                
                const attachments = custom_uploader.state().get('selection').toJSON();
                
                const image_ids = []; let gallery = []
                for (let i = 0; i < attachments.length; i++) {
                    image_ids.push(attachments[i].id);
                    
                    gallery.push({'id': attachments[i].id, 'url':  attachments[i].url});
                }
                //add attachment ids to the hidden input
                $hidden_input.val(image_ids.join(', '));
                
                //insert selected images - create a gallery view
                gallery.forEach(function(image){
                    $gallery_div.append('<span class="dht-img-remove">' +
                        '<span class="dht-img-remove-icon"></span>' +
                        '<img data-id="'+image.id+'" src="'+ image.url +'" alt="" width="100" height="100" />' +
                        '</span>');
                });
            });
            
            custom_uploader.open();
            
            //open the WP media popup with a preselected attachment ids if exist
            if ($hidden_input.val().length > 0) {
                
                const gallery_ids = $hidden_input.val().split(", ");
                
                const selection = custom_uploader.state().get('selection');
                gallery_ids.forEach(function(id) {
                    let attachment = wp.media.attachment(id);
                    attachment.fetch();
                    selection.add(attachment ? [attachment] : []);
                });
            }
        });
        
        //remove image from gallery and from the hidden input
        $('body').on('click', '.dht-gallery-group .dht-img-remove-icon', function() {
            //get the removed image id
            const $hidden_input = $(this).parents('.dht-gallery-group').siblings('.dht-upload-gallery-hidden');
            const image_id = $(this).siblings('img').attr('data-id');
            
            //get input hidden ids
            let saved_ids = $hidden_input.val();
            saved_ids = saved_ids.split(", ");
            
            //remove id from saved ids array and add the new array to the hidden input
            if(saved_ids.indexOf(image_id) > -1){
                saved_ids.splice(saved_ids.indexOf(image_id), 1);
                
                //$hidden_input
                $hidden_input.val(saved_ids.join(', '));
            }
            //remove the image container
            $(this).parent('.dht-img-remove').remove();
        });
    });
</script>
<div class="dht-field-wrapper">
    <div class="dht-title">Upload gallery field</div>
    <div class="dht-field-child-wrapper dht-field-child-upload">
        
        <div class="dht-gallery-group"></div>
        <input class="dht-upload-gallery-hidden dht-field" type="hidden" name="image_upload_field" value="" />
        <input type="button" class="dht-upload-gallery-button button"  value="Upload Gallery" />
        
        <div class="dht-description">Field description</div>
    </div>
    
    <div class="dht-info-help dashicons dashicons-info"
         data-tooltips="A little box to something to make it longer"
         data-position="OnLeft">
    </div>
</div>
<div class="dht-divider"></div>

<!-- field - upload video -->
<script>
    jQuery(document).ready(function($){
        $('.dht-upload-video-button').click(function() {
            const $this = jQuery(this);
            const $hidden_input = jQuery('.dht-upload-video-hidden');
            
            //open WP media popup
            const custom_uploader = wp.media({
                title: 'Choose Video',
                button: {
                    text: 'Choose Video',
                },
                library: { type: 'video' },
                multiple: false
            });
            
            custom_uploader.on('select', function() {
                
                const attachment = custom_uploader.state().get('selection').first().toJSON()
                $this.siblings('.dht-upload-video').val(attachment.url);
                
                //add attachment id to the hidden input
                $hidden_input.val(attachment.id);
            });
            
            custom_uploader.open();
            
            //open the WP media popup with a preselected attachment id if exist
            if ($hidden_input.val().length > 0) {
                custom_uploader.state().get('selection').add(wp.media.attachment($hidden_input.val()));
            }
        });
        //remove video if when input is cleared
        $('.dht-upload-video').on('input', function() {
            
            // Check if the input field is empty and remove the vide id
            if ($(this).val() === '') {
                jQuery('.dht-upload-video-hidden').val('');
            }
        });
    });
</script>
<div class="dht-field-wrapper">
    <div class="dht-title">Upload video field</div>
    <div class="dht-field-child-wrapper dht-field-child-upload">
        
        <label for="image_upload_field22">Upload video:</label><br />
        <input class="dht-upload-video dht-field" type="text" id="image_upload_field22" name="video_upload_field[video][]" value="" />
        <input class="dht-upload-video-hidden dht-field" type="hidden"  name="video_upload_field[video_id][]" value="" />
        <input type="button" class="dht-upload-video-button button"  value="Upload Video" />
        
        <div class="dht-description">Field description</div>
    </div>
    
    <div class="dht-info-help dashicons dashicons-info"
         data-tooltips="A little box to something to make it longer"
         data-position="OnLeft">
    </div>
</div>
<div class="dht-divider"></div>

<!-- field - upload image -->
<script>
    jQuery(document).ready(function($){
        $('.dht-upload-image-button').click(function() {
            const $this = jQuery(this);
            const $hidden_input = jQuery('.dht-upload-hidden');
            
            //open WP media popup
            const custom_uploader = wp.media({
                title: 'Choose Image',
                button: {
                    text: 'Choose Image',
                },
                library: { type: 'image' },
                multiple: false
            });
            
            custom_uploader.on('select', function() {
                const $image_input = $this.siblings('.dht-upload');
                //remove image preview before proceeding
                $image_input.siblings('img').remove();
                
                const attachment = custom_uploader.state().get('selection').first().toJSON();
                
                //add image URL
                $image_input.val(attachment.url);
                
                //add attachment ids to the hidden input
                $hidden_input.val(attachment.id);
                
                //display a preview image with the selected image url
                $image_input.before('<img src="'+attachment.url+'" alt="" width="100" height="100" />');
            });
            
            custom_uploader.open();
            
            //open the WP media popup with a preselected attachment id if exist
            if ($hidden_input.val().length > 0) {
                custom_uploader.state().get('selection').add(wp.media.attachment($hidden_input.val()));
            }
        });
        //remove image when input is cleared
        $('.dht-upload').on('input', function() {
            
            // Check if the input field is empty and remove the image id and URL
            if ($(this).val() === '') {
                $(this).siblings('img').remove();
                jQuery('.dht-upload-hidden').val('');
            }
            
            //change image when adding a new link
            if($(this).val().length > 0){
                $(this).siblings('img').remove();
                $(this).before('<img src="'+ $(this).val() +'" alt="" width="100" height="100" />');
            }
        });
    });
</script>
<div class="dht-field-wrapper">
    <div class="dht-title">Upload field</div>
    <div class="dht-field-child-wrapper dht-field-child-upload">
        
        <label for="image-upload-field111">Upload Field:</label><br />
        <input class="dht-upload dht-field" type="text" id="image-upload-field111" name="image_upload_field[image][]" value="" />
        <input class="dht-upload-hidden dht-field" type="hidden"  name="image_upload_field[image_id][]" value="" />
        <input type="button" class="dht-upload-image-button button"  value="Upload Image" />
        
        <div class="dht-description">Field description</div>
    </div>
    
    <div class="dht-info-help dashicons dashicons-info"
         data-tooltips="A little box to something to make it longer"
         data-position="OnLeft">
    </div>
</div>
<div class="dht-divider"></div>

<style>
    /* upload gallery */
    .dht-gallery-group {
        margin-bottom: 10px;
    }
    .dht-gallery-group img {
        margin-right: 5px;
    }
    .dht-gallery-group span.dht-img-remove-icon {
        border-radius: 50%;
        width: 15px;
        height: 15px;
        background: #fff;
        position: absolute;
        cursor: pointer;
        padding-left: 2px;
        padding-bottom: 2px;
    }
    .dht-gallery-group span.dht-img-remove-icon:before {
        color: red;
        content: "\f158";
        font-family: dashicons;
    }
    
    /* upload video */
    .dht-upload-video {
        margin-bottom: 10px;
    }
    
    /* upload field */
    .dht-upload {
        margin-bottom: 10px;
    }
    
    /* upload field */
    .dht-upload {
        margin-bottom: 10px;
    }
</style>

<!-------------------------------------------------------------------------------------->

<!-- field - radio image -->
<script>
    jQuery(document).ready(function($){
        $('.dht-field-child-image-select .dht-img-select-wrapper').on('click', function() {
            //remove selected class and border
            $(this).siblings().removeClass('dht-img-select-wrapper-selected');
            $(this).siblings().children('.dht-image-select').removeAttr('checked');
            
            //add selected class and border
            $(this).addClass('dht-img-select-wrapper-selected');
            $(this).children('.dht-image-select').attr('checked', 'checked');
        });
    });
</script>

<div class="dht-field-wrapper">
    <div class="dht-title">Image select</div>
    <div class="dht-field-child-wrapper dht-field-child-image-select">
        
        <div class="dht-field-child-image-select-container">
            <div class="dht-img-select-wrapper dht-img-select-wrapper-selected">
                <input class="dht-image-select dht-field" type="radio" name="radio[img]" id="radio-1" value="1" checked="checked" />
                <img src="<?php echo PPHT_ASSETS_URI . "images/demo.png"?>" alt="title" title="title" />
                <label for="radio-1">Option 1</label>
            </div>
            
            <div class="dht-img-select-wrapper">
                <input class="dht-image-select dht-field" type="radio" name="radio[img]" id="radio-2" value="2" />
                <img src="<?php echo PPHT_ASSETS_URI . "images/demo.png"?>" alt="title" title="title" />
                <label for="radio-2">Option 2</label>
            </div>
            
            <div class="dht-img-select-wrapper">
                <input class="dht-image-select dht-field" type="radio" name="radio[img]" id="radio-3" value="3" />
                <img src="<?php echo PPHT_ASSETS_URI . "images/demo.png"?>" alt="title" title="title" />
                <label for="radio-3">Option 3</label>
            </div>
        </div>
        
        <div class="dht-description">Field description</div>
    </div>
    <div class="dht-info-help dashicons dashicons-info"
         data-tooltips="A little box to something to make it longer"
         data-position="OnLeft">
    </div>
</div>
<div class="dht-divider"></div>

<style>
    /* image select field */
    .dht-field-child-image-select .dht-image-select {
        display: none;
    }
    .dht-field-child-image-select-container {
        display: flex;
        justify-content: flex-start;
    }
    .dht-field-child-image-select .dht-img-select-wrapper {
        margin-right: 10px;
    }
    .dht-field-child-image-select .dht-img-select-wrapper {
        margin-right: 0px;
        border: 3px solid transparent;
        display: inline-flex;
    }
    .dht-field-child-image-select .dht-img-select-wrapper.dht-img-select-wrapper-selected{
        border-color: rgb(99, 91, 255);
    }
</style>

<!-------------------------------------------------------------------------------------->

<!-- field - multioptions -> type - ajax -->
<script>
    jQuery(document).ready(function($){
        
        let $inputField = $('.dht-multioptions-ajax');
        
        // Initialize Select2 without AJAX
        $inputField.select2({
            minimumInputLength: 2, // Set minimum input length to 1 to trigger AJAX after typing
            placeholder: 'Type to search...', // Placeholder text
            allowClear: true, // Allow clearing the selection
            ajax: {
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                dataType: 'json',
                delay: 250,
                type: 'POST',
                data: function(params) {
                    return {
                        action: 'multioptions_ajax_values',
                        term: params.term
                    };
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });
        
        // Bind focus event to input field
        $inputField.on('focus', function() {
            // Reset the input field value
            $(this).val('');
        });
    });
</script>

<div class="dht-field-wrapper">
    <div class="dht-title">MultiOptions Ajax</div>
    <div class="dht-field-child-wrapper dht-field-child-multioptions">
        <label for="aaaa">Choose a car:</label>
        <select class="dht-multioptions-ajax dht-field" name="cars" id="aaaa" multiple="multiple">
        </select>
        <div class="dht-description">Field description</div>
    </div>
    <div class="dht-info-help dashicons dashicons-info"
         data-tooltips="A little box to something to make it longer"
         data-position="OnLeft">
    </div>
</div>
<div class="dht-divider"></div>

<!-- field - multioptions -->
<script>
    jQuery(document).ready(function($){
        $('.dht-multioptions').select2();
    });
</script>

<div class="dht-field-wrapper">
    <div class="dht-title">MultiOptions</div>
    <div class="dht-field-child-wrapper dht-field-child-multioptions">
        <label for="cars">Choose a car:</label>
        <select class="dht-multioptions dht-field" name="cars" id="cars" multiple="multiple">
            <option value="volvo">Volvo</option>
            <option value="saab">Saab</option>
            <option value="mercedes">Mercedes</option>
            <option value="audi">Audi</option>
        </select>
        <div class="dht-description">Field description</div>
    </div>
    <div class="dht-info-help dashicons dashicons-info"
         data-tooltips="A little box to something to make it longer"
         data-position="OnLeft">
    </div>
</div>
<div class="dht-divider"></div>

<style>
    /* multioptions field */
    .dht-field-child-multioptions span.select2.select2-container {
        width: 100% !important;
    }
    .dht-field-child-multioptions .select2-container .select2-selection--multiple .select2-selection__rendered {
        display: block;
    }
    .dht-field-child-multioptions li.select2-search.select2-search--inline {
        margin-bottom: 0;
    }
    .dht-field-child-multioptions .select2-container .select2-search--inline .select2-search__field {
        margin-top: 0;
    }
</style>

<!-------------------------------------------------------------------------------------->

<!-- field - borders -->
<div class="dht-field-wrapper">
    <div class="dht-title">Borders</div>
    <div class="dht-field-child-wrapper dht-field-child-borders">
        
        <div class="dht-field-borders-group">
            
            <div class="dht-field-borders-input">
                <label for="test-input">Top</label>
                <span class="dht-borders-top"></span>
                <input class="dht-borders dht-field" id="top" type="number" name="borders[top]" value="" title="title" />
            </div>
            
            <div class="dht-field-borders-input">
                <label for="test-input">Right</label>
                <span class="dht-borders-right"></span>
                <input class="dht-borders dht-field" id="left" type="number" name="borders[right]" value="" title="title" />
            </div>
            
            <div class="dht-field-borders-input">
                <label for="test-input">Bottom</label>
                <span class="dht-borders-bottom"></span>
                <input class="dht-borders dht-field" id="bottom" type="number" name="borders[bottom]" value="" title="title" />
            </div>
            
            <div class="dht-field-borders-input">
                <label for="test-borders">Left</label>
                <span class="dht-borders-left"></span>
                <input class="dht-borders dht-field" id="right" type="number" name="borders[left]" value="" title="title" />
            </div>
            
            <div class="dht-field-borders-input">
                <label for="test-input">Sizes</label>
                <select class="dht-borders-dropdown dht-field" name="cars" id="cars">
                    <option value="solid" selected>Solid</option>
                    <option value="dashed">Dashed</option>
                    <option value="dotted">Dotted</option>
                    <option value="double">Double</option>
                    <option value="none">None</option>
                </select>
            </div>
        </div>
        
        <div class="dht-field-borders-group-colorpicker">
            <script>
                jQuery(document).ready(function($){
                    jQuery( ".dht-borders-colorpicker" ).wpColorPicker({ });
                    
                    let $delete_btn = jQuery('.dht-default-borders-color-btn');
                    
                    $delete_btn.insertAfter(jQuery('.dht-borders-colorpicker').parent('label'));
                    
                    $delete_btn.on('click', function() {
                        let defaultColor = 'rgb(238, 238, 34, 0.5)'; // Set your default color here
                        jQuery('.dht-borders-colorpicker').wpColorPicker('color', defaultColor);
                    });
                });
            </script>
            
            <label for="colorpicker-input"></label>
            <input class="dht-borders-colorpicker dht-field" id="borders-colorpicker-input" type="text"
                   data-alpha="true" data-reset="true"
                   name="borders-colorpicker-input" value="rgb(238, 238, 34, 0.5)" title="title" />
            <input type="button" id="dht-default-color-btn11" class="dht-default-borders-color-btn button button-small" value="Default">
            
            <style>
                /* wp-color-picker-alpha.css */
                .dht-field-child-borders .wp-picker-input-wrap label {
                    display: block;
                }
                .dht-field-child-borders .wp-picker-open + span.wp-picker-input-wrap {
                    width: 210px;
                    display: flex !important;
                }
                .dht-field-child-borders.wp-picker-active .dht-default-color-btn {
                    display:block !important;
                }
                .wp-core-ui .dht-field-child-borders .dht-field-borders-group-colorpicker .wp-picker-active .button.hidden {
                    display: block !important;
                }
                .dht-field-child-borders .dht-default-borders-color-btn {
                    margin-left: 5px !important;
                }
                .dht-field-child-borders .dht-field-borders-group {
                    display: grid;
                    grid-template-columns: 1fr 1fr 1fr 1fr 1fr;
                    grid-gap: 15px;
                    margin-bottom: 10px;
                }
                .dht-field-child-borders .dht-field-borders-group span:before
                {
                    font-family: dashicons;
                    color: #000;
                }
                .dht-field-child-borders .dht-field-borders-group span.dht-borders-top:before {
                    content: "\f342";
                }
                .dht-field-child-borders .dht-field-borders-group span.dht-borders-right:before {
                    content: "\f344";
                }
                .dht-field-child-borders .dht-field-borders-group span.dht-borders-bottom:before {
                    content: "\f346";
                }
                .dht-field-child-borders .dht-field-borders-group span.dht-borders-left:before {
                    content: "\f340";
                }
                .dht-field-child-borders .dht-field-borders-group span {
                    position: absolute;
                    background: #c0c0c0;
                    background-color: #eee;
                    border: 1px solid #7e8993;
                    height: 18px;
                    padding: 5px;
                    border-radius: 4px 0 0 4px;
                }
                .dht-field-child-borders .dht-field-borders-input{
                    position:relative;
                }
                .dht-field-child-borders .dht-borders {
                    padding-left: 30px !important;
                }
                
                @media (max-width: 980px) {
                    .dht-field-child-borders .dht-field-borders-group {
                        display: block;
                    }
                    .dht-field-child-borders .dht-field-borders-group .dht-field-borders-input {
                        margin-bottom: 10px;
                    }
                    .dht-field-child-borders .dht-field-borders-input select {
                        max-width: 100%;
                    }
                }
                
                @media (max-width: 767px) {
                    .dht-field-child-borders .dht-field-borders-group span {
                        padding: 10px;
                    }
                    .dht-field-child-borders .dht-borders {
                        padding-left: 40px !important;
                    }
                }
            </style>
        </div>
        
        
        <div class="dht-description">Field description</div>
    </div>
    <div class="dht-info-help dashicons dashicons-info"
         data-tooltips="A little box to something to make it longer"
         data-position="OnLeft">
    </div>
</div>
<div class="dht-divider"></div>

<!-------------------------------------------------------------------------------------->

<!-- field - spacing -->
<div class="dht-field-wrapper">
    <div class="dht-title">Spacing</div>
    <div class="dht-field-child-wrapper dht-field-child-spacing">
        
        <div class="dht-field-spacing-group">
            
            <div class="dht-field-spacing-input">
                <label for="test-input">Top</label>
                <span class="dht-spacing-top"></span>
                <input class="dht-spacing dht-field" id="top" type="number" name="spacing[top]" value="" title="title" />
            </div>
            
            <div class="dht-field-spacing-input">
                <label for="test-input">Right</label>
                <span class="dht-spacing-right"></span>
                <input class="dht-spacing dht-field" id="left" type="number" name="spacing[right]" value="" title="title" />
            </div>
            
            <div class="dht-field-spacing-input">
                <label for="test-input">Bottom</label>
                <span class="dht-spacing-bottom"></span>
                <input class="dht-spacing dht-field" id="bottom" type="number" name="spacing[bottom]" value="" title="title" />
            </div>
            
            <div class="dht-field-spacing-input">
                <label for="test-input">Left</label>
                <span class="dht-spacing-left"></span>
                <input class="dht-spacing dht-field" id="right" type="number" name="spacing[left]" value="" title="title" />
            </div>
            
            <div class="dht-field-spacing-input">
                <label for="test-input">Sizes</label>
                <select class="dht-spacing-dropdown dht-field" name="cars" id="cars">
                    <option value="px" selected>px</option>
                    <option value="percentage">%</option>
                    <option value="em">em</option>
                    <option value="rem">rem</option>
                    <option value="vw">vw</option>
                    <option value="vh">vh</option>
                </select>
            </div>
        </div>
        
        
        <div class="dht-description">Field description</div>
    </div>
    <div class="dht-info-help dashicons dashicons-info"
         data-tooltips="A little box to something to make it longer"
         data-position="OnLeft">
    </div>
</div>
<div class="dht-divider"></div>

<style>
    /*spacing styles*/
    .dht-field-child-spacing .dht-field-spacing-group {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr 1fr 1fr;
        grid-gap: 15px;
    }
    .dht-field-child-spacing .dht-field-spacing-group span:before
    {
        font-family: dashicons;
        color: #000;
    }
    .dht-field-child-spacing .dht-field-spacing-group span.dht-spacing-top:before {
        content: "\f342";
    }
    .dht-field-child-spacing .dht-field-spacing-group span.dht-spacing-right:before {
        content: "\f344";
    }
    .dht-field-child-spacing .dht-field-spacing-group span.dht-spacing-bottom:before {
        content: "\f346";
    }
    .dht-field-child-spacing .dht-field-spacing-group span.dht-spacing-left:before {
        content: "\f340";
    }
    .dht-field-child-spacing .dht-field-spacing-group span {
        position: absolute;
        background: #c0c0c0;
        background-color: #eee;
        border: 1px solid #7e8993;
        height: 18px;
        padding: 5px;
        border-radius: 4px 0 0 4px;
    }
    .dht-field-child-spacing .dht-field-spacing-input{
        position:relative;
    }
    .dht-field-child-spacing .dht-spacing {
        padding-left: 30px !important;
    }
    
    @media (max-width: 980px) {
        .dht-field-child-spacing .dht-field-spacing-group {
            display: block;
        }
        .dht-field-child-spacing .dht-field-spacing-group .dht-field-spacing-input {
            margin-bottom: 10px;
        }
        .dht-field-child-spacing .dht-field-spacing-input select {
            max-width: 100%;
        }
    }
    
    @media (max-width: 767px) {
        .dht-field-child-spacing .dht-field-spacing-group span {
            padding: 10px;
        }
        .dht-field-child-spacing .dht-spacing {
            padding-left: 40px !important;
        }
    }
</style>