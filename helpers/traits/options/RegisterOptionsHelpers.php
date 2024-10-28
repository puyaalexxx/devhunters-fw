<?php
declare( strict_types = 1 );

namespace DHT\Helpers\Traits\Options;

if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

use DHT\Core\Options\Containers\Containers\SideMenu;
use DHT\Core\Options\Containers\Containers\Simple;
use DHT\Core\Options\Containers\Containers\TabsMenu as TabsContainer;
use DHT\Core\Options\Fields\Fields\AceEditor;
use DHT\Core\Options\Fields\Fields\Borders;
use DHT\Core\Options\Fields\Fields\Checkbox;
use DHT\Core\Options\Fields\Fields\ColorPicker;
use DHT\Core\Options\Fields\Fields\DatePicker;
use DHT\Core\Options\Fields\Fields\DateTimePicker;
use DHT\Core\Options\Fields\Fields\Dropdown;
use DHT\Core\Options\Fields\Fields\DropdownMultiple;
use DHT\Core\Options\Fields\Fields\Icon;
use DHT\Core\Options\Fields\Fields\Input;
use DHT\Core\Options\Fields\Fields\MultiInput;
use DHT\Core\Options\Fields\Fields\MultiOptions;
use DHT\Core\Options\Fields\Fields\Radio;
use DHT\Core\Options\Fields\Fields\RadioImage;
use DHT\Core\Options\Fields\Fields\RangeSlider;
use DHT\Core\Options\Fields\Fields\Spacing;
use DHT\Core\Options\Fields\Fields\SwitchField;
use DHT\Core\Options\Fields\Fields\Text;
use DHT\Core\Options\Fields\Fields\Textarea;
use DHT\Core\Options\Fields\Fields\TimePicker;
use DHT\Core\Options\Fields\Fields\Typography;
use DHT\Core\Options\Fields\Fields\Upload;
use DHT\Core\Options\Fields\Fields\UploadGallery;
use DHT\Core\Options\Fields\Fields\UploadImage;
use DHT\Core\Options\Fields\Fields\WpEditor;
use DHT\Core\Options\Groups\Groups\Accordion;
use DHT\Core\Options\Groups\Groups\AddableBox;
use DHT\Core\Options\Groups\Groups\Group;
use DHT\Core\Options\Groups\Groups\Panel;
use DHT\Core\Options\Groups\Groups\Tabs;
use DHT\Core\Options\Toggles\Toggles\Toggle;

trait RegisterOptionsHelpers {
	
	/**
	 * register framework option containers (container options can contain group, toggle options and simple options)
	 *
	 * @return void
	 * @since     1.0.0
	 */
	private function _registerFWOptionContainers() : void {
		
		//instantiate the option container classes
		$sidemenu = new SideMenu( $this->_optionGroupsClasses, $this->_optionTogglesClasses, $this->_optionFieldsClasses );
		$simple   = new Simple( $this->_optionGroupsClasses, $this->_optionTogglesClasses, $this->_optionFieldsClasses );
		$tabs     = new TabsContainer( $this->_optionGroupsClasses, $this->_optionTogglesClasses, $this->_optionFieldsClasses );
		
		//add class instance to the _optionContainerClasses array to use throughout the Container class methods
		$this->_optionContainerClasses[ $sidemenu->getContainer() ] = $sidemenu;
		$this->_optionContainerClasses[ $simple->getContainer() ]   = $simple;
		$this->_optionContainerClasses[ $tabs->getContainer() ]     = $tabs;
	}
	
	/**
	 * register framework option groups (group options can contain toggle options and simple options)
	 *
	 * @return void
	 * @since     1.0.0
	 */
	private function _registerFWOptionGroups() : void {
		
		//instantiate the option group classes
		$group       = new Group( $this->_optionTogglesClasses, $this->_optionFieldsClasses );
		$tabs        = new Tabs( $this->_optionTogglesClasses, $this->_optionFieldsClasses );
		$accordion   = new Accordion( $this->_optionTogglesClasses, $this->_optionFieldsClasses );
		$panel       = new Panel( $this->_optionTogglesClasses, $this->_optionFieldsClasses );
		$addable_box = new AddableBox( $this->_optionTogglesClasses, $this->_optionFieldsClasses );
		
		//add class instance to the _optionGroupClasses array to use throughout the Group class methods
		$this->_optionGroupsClasses[ $group->getGroup() ]       = $group;
		$this->_optionGroupsClasses[ $tabs->getGroup() ]        = $tabs;
		$this->_optionGroupsClasses[ $accordion->getGroup() ]   = $accordion;
		$this->_optionGroupsClasses[ $panel->getGroup() ]       = $panel;
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
		$input            = new Input();
		$textarea         = new Textarea();
		$checkbox         = new Checkbox();
		$radio            = new Radio();
		$text             = new Text();
		$wpeditor         = new WpEditor();
		$switch_field     = new SwitchField();
		$dropdown         = new Dropdown();
		$dropdown_multple = new DropdownMultiple();
		$multi_input      = new MultiInput();
		$ace_editor       = new AceEditor();
		$colorpicker      = new ColorPicker();
		$datepicker       = new DatePicker();
		$timepicker       = new TimePicker();
		$datetimepicker   = new DateTimePicker();
		$range_slider     = new RangeSlider();
		$spacing          = new Spacing();
		$radio_image      = new RadioImage();
		$multi_options    = new MultiOptions();
		$borders          = new Borders();
		$upload_image     = new UploadImage();
		$upload           = new Upload();
		$upload_gallery   = new UploadGallery();
		$icon             = new Icon();
		$typography       = new Typography();
		
		//add class instance to the _optionFieldsClasses array to use throughout the Option class methods
		$this->_optionFieldsClasses[ $input->getField() ]            = $input;
		$this->_optionFieldsClasses[ $textarea->getField() ]         = $textarea;
		$this->_optionFieldsClasses[ $checkbox->getField() ]         = $checkbox;
		$this->_optionFieldsClasses[ $radio->getField() ]            = $radio;
		$this->_optionFieldsClasses[ $text->getField() ]             = $text;
		$this->_optionFieldsClasses[ $wpeditor->getField() ]         = $wpeditor;
		$this->_optionFieldsClasses[ $switch_field->getField() ]     = $switch_field;
		$this->_optionFieldsClasses[ $dropdown->getField() ]         = $dropdown;
		$this->_optionFieldsClasses[ $dropdown_multple->getField() ] = $dropdown_multple;
		$this->_optionFieldsClasses[ $multi_input->getField() ]      = $multi_input;
		$this->_optionFieldsClasses[ $ace_editor->getField() ]       = $ace_editor;
		$this->_optionFieldsClasses[ $colorpicker->getField() ]      = $colorpicker;
		$this->_optionFieldsClasses[ $datepicker->getField() ]       = $datepicker;
		$this->_optionFieldsClasses[ $timepicker->getField() ]       = $timepicker;
		$this->_optionFieldsClasses[ $datetimepicker->getField() ]   = $datetimepicker;
		$this->_optionFieldsClasses[ $range_slider->getField() ]     = $range_slider;
		$this->_optionFieldsClasses[ $spacing->getField() ]          = $spacing;
		$this->_optionFieldsClasses[ $radio_image->getField() ]      = $radio_image;
		$this->_optionFieldsClasses[ $multi_options->getField() ]    = $multi_options;
		$this->_optionFieldsClasses[ $borders->getField() ]          = $borders;
		$this->_optionFieldsClasses[ $upload_image->getField() ]     = $upload_image;
		$this->_optionFieldsClasses[ $upload->getField() ]           = $upload;
		$this->_optionFieldsClasses[ $upload_gallery->getField() ]   = $upload_gallery;
		$this->_optionFieldsClasses[ $icon->getField() ]             = $icon;
		$this->_optionFieldsClasses[ $typography->getField() ]       = $typography;
	}
	
}