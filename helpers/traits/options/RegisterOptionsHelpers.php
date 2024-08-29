<?php
declare( strict_types = 1 );

namespace DHT\Helpers\Traits\Options;

use DHT\Extensions\Options\Containers\Containers\SideMenu;
use DHT\Extensions\Options\Groups\Groups\Accordion;
use DHT\Extensions\Options\Groups\Groups\AddableBox;
use DHT\Extensions\Options\Groups\Groups\Group;
use DHT\Extensions\Options\Groups\Groups\Tabs;
use DHT\Extensions\Options\Options\fields\AceEditor;
use DHT\Extensions\Options\Options\fields\Borders;
use DHT\Extensions\Options\Options\fields\Checkbox;
use DHT\Extensions\Options\Options\fields\ColorPicker;
use DHT\Extensions\Options\Options\fields\DatePicker;
use DHT\Extensions\Options\Options\fields\DateTimePicker;
use DHT\Extensions\Options\Options\fields\Dropdown;
use DHT\Extensions\Options\Options\fields\DropdownMultiple;
use DHT\Extensions\Options\Options\fields\Icon;
use DHT\Extensions\Options\Options\fields\Input;
use DHT\Extensions\Options\Options\fields\MultiInput;
use DHT\Extensions\Options\Options\fields\MultiOptions;
use DHT\Extensions\Options\Options\fields\Radio;
use DHT\Extensions\Options\Options\fields\RadioImage;
use DHT\Extensions\Options\Options\fields\RangeSlider;
use DHT\Extensions\Options\Options\fields\Spacing;
use DHT\Extensions\Options\Options\fields\SwitchField;
use DHT\Extensions\Options\Options\fields\Text;
use DHT\Extensions\Options\Options\fields\Textarea;
use DHT\Extensions\Options\Options\fields\TimePicker;
use DHT\Extensions\Options\Options\fields\Typography;
use DHT\Extensions\Options\Options\fields\Upload;
use DHT\Extensions\Options\Options\fields\UploadGallery;
use DHT\Extensions\Options\Options\fields\UploadImage;
use DHT\Extensions\Options\Options\fields\WpEditor;
use DHT\Extensions\Options\Toggles\Toggles\Toggle;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

trait RegisterOptionsHelpers {
    
    /**
     * register framework option containers (container options can contain group, toggle options and simple options)
     *
     * @return void
     * @since     1.0.0
     */
    private function _registerFWOptionContainers() : void {
        
        //instantiate the option group classes
        $sidemenu = new SideMenu( $this->_optionGroupsClasses, $this->_optionTogglesClasses, $this->_optionFieldsClasses );
        
        //add class instance to the _optionContainerClasses array to use throughout the Container class methods
        $this->_optionContainerClasses[ $sidemenu->getContainer() ] = $sidemenu;
    }
    
    /**
     * register framework option groups (group options can contain toggle options and simple options)
     *
     * @return void
     * @since     1.0.0
     */
    private function _registerFWOptionGroups() : void {
        
        //instantiate the option group classes
        $group = new Group( $this->_optionTogglesClasses, $this->_optionFieldsClasses );
        $tabs = new Tabs( $this->_optionTogglesClasses, $this->_optionFieldsClasses );
        $accordion = new Accordion( $this->_optionTogglesClasses, $this->_optionFieldsClasses );
        $addable_box = new AddableBox( $this->_optionTogglesClasses, $this->_optionFieldsClasses );
        
        //add class instance to the _optionGroupClasses array to use throughout the Group class methods
        $this->_optionGroupsClasses[ $group->getGroup() ] = $group;
        $this->_optionGroupsClasses[ $tabs->getGroup() ] = $tabs;
        $this->_optionGroupsClasses[ $accordion->getGroup() ] = $accordion;
        $this->_optionGroupsClasses[ $addable_box->getGroup() ] = $addable_box;
    }
    
    /**
     * register framework option toggles (toggle options can contain only simple options)
     *
     * @return void
     * @since     1.0.0
     */
    private function _registerFWOptionToggles() : void {
        
        //instantiate the option toggle classes
        $toggle = new Toggle( $this->_optionFieldsClasses );
        
        //add class instance to the _optionToggleClasses array to use throughout the Toggle class methods
        $this->_optionTogglesClasses[ $toggle->getToggle() ] = $toggle;
    }
    
    /**
     * register framework option types
     *
     * @return void
     * @since     1.0.0
     */
    private function _registerFWOptionFields() : void {
        
        //instantiate the option type classes
        $input = new Input();
        $textarea = new Textarea();
        $checkbox = new Checkbox();
        $radio = new Radio();
        $text = new Text();
        $wpeditor = new WpEditor();
        $switch_field = new SwitchField();
        $dropdown = new Dropdown();
        $dropdown_multple = new DropdownMultiple();
        $multi_input = new MultiInput();
        $ace_editor = new AceEditor();
        $colorpicker = new ColorPicker();
        $datepicker = new DatePicker();
        $timepicker = new TimePicker();
        $datetimepicker = new DateTimePicker();
        $range_slider = new RangeSlider();
        $spacing = new Spacing();
        $radio_image = new RadioImage();
        $multi_options = new MultiOptions();
        $borders = new Borders();
        $upload_image = new UploadImage();
        $upload = new Upload();
        $upload_gallery = new UploadGallery();
        $icon = new Icon();
        $typography = new Typography();
        
        //add class instance to the _optionFieldsClasses array to use throughout the Option class methods
        $this->_optionFieldsClasses[ $input->getField() ] = $input;
        $this->_optionFieldsClasses[ $textarea->getField() ] = $textarea;
        $this->_optionFieldsClasses[ $checkbox->getField() ] = $checkbox;
        $this->_optionFieldsClasses[ $radio->getField() ] = $radio;
        $this->_optionFieldsClasses[ $text->getField() ] = $text;
        $this->_optionFieldsClasses[ $wpeditor->getField() ] = $wpeditor;
        $this->_optionFieldsClasses[ $switch_field->getField() ] = $switch_field;
        $this->_optionFieldsClasses[ $dropdown->getField() ] = $dropdown;
        $this->_optionFieldsClasses[ $dropdown_multple->getField() ] = $dropdown_multple;
        $this->_optionFieldsClasses[ $multi_input->getField() ] = $multi_input;
        $this->_optionFieldsClasses[ $ace_editor->getField() ] = $ace_editor;
        $this->_optionFieldsClasses[ $colorpicker->getField() ] = $colorpicker;
        $this->_optionFieldsClasses[ $datepicker->getField() ] = $datepicker;
        $this->_optionFieldsClasses[ $timepicker->getField() ] = $timepicker;
        $this->_optionFieldsClasses[ $datetimepicker->getField() ] = $datetimepicker;
        $this->_optionFieldsClasses[ $range_slider->getField() ] = $range_slider;
        $this->_optionFieldsClasses[ $spacing->getField() ] = $spacing;
        $this->_optionFieldsClasses[ $radio_image->getField() ] = $radio_image;
        $this->_optionFieldsClasses[ $multi_options->getField() ] = $multi_options;
        $this->_optionFieldsClasses[ $borders->getField() ] = $borders;
        $this->_optionFieldsClasses[ $upload_image->getField() ] = $upload_image;
        $this->_optionFieldsClasses[ $upload->getField() ] = $upload;
        $this->_optionFieldsClasses[ $upload_gallery->getField() ] = $upload_gallery;
        $this->_optionFieldsClasses[ $icon->getField() ] = $icon;
        $this->_optionFieldsClasses[ $typography->getField() ] = $typography;
    }
    
}