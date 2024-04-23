<?php

?>

<!-- field - input -->
<div class="dht-field-wrapper">
    <div class="dht-title">Text Input</div>
    <div class="dht-field-child-wrapper">
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
<!-- field - input - type-> password -->
<div class="dht-field-wrapper">
    <div class="dht-title">Password</div>
    <div class="dht-field-child-wrapper">
        <label for="password"></label>
        <input class="dht-password dht-field" id="password" type="password" name="password"
               placeholder="Password" value="" title="title" />
        <div class="dht-description">Field description</div>
    </div>
    <div class="dht-info-help dashicons dashicons-info"
         data-tooltips="A little box to something to make it longer"
         data-position="OnLeft">
    </div>
</div>

<!-------------------------------------------------------------------------------------->

<!-- field - textarea -->
<div class="dht-field-wrapper">
    <div class="dht-title">Textarea</div>
    <div class="dht-field-child-wrapper">
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
    <div class="dht-field-child-wrapper">
        
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
    <div class="dht-field-child-wrapper">
        
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
    <div class="dht-field-child-wrapper">
        
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
    <div class="dht-field-child-wrapper">
        
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
    <div class="dht-field-child-wrapper">
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
    <div class="dht-field-child-wrapper">
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
    <div class="dht-field-child-wrapper">
        
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
    <div class="dht-field-child-wrapper">
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
    <div class="dht-field-child-wrapper">
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
    <div class="dht-field-child-wrapper">
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
    <div class="dht-field-child-wrapper">
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
    <div class="dht-field-child-wrapper dht-field-multiinput-child-wrapper">
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
    <div class="dht-field-child-wrapper">
        
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
    <div class="dht-field-child-wrapper">
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
    <div class="dht-field-child-wrapper">
        
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
    <div class="dht-field-child-wrapper">
        
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
    <div class="dht-field-child-wrapper">
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
    <div class="dht-field-child-wrapper">
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
    <div class="dht-field-child-wrapper">
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
    <div class="dht-field-child-wrapper dht-field-child-groups">
        
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
    <div class="dht-field-child-wrapper dht-field-child-groups">
        
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

