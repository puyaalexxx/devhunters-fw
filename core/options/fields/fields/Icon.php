<?php
declare( strict_types = 1 );

namespace DHT\Core\Options\Fields\Fields;

use DHT\Core\Options\Fields\BaseField;
use DHT\Helpers\Classes\Environment;
use DHT\DHT;
use function DHT\Helpers\dht_get_icon_style_by_type;
use function DHT\Helpers\dht_get_variables_from_file;

if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

final class Icon extends BaseField {
	
	//field type
	protected string $_field = 'icon';
	
	/**
	 * @since     1.0.0
	 */
	public function __construct() {
		
		parent::__construct();
		
		add_action( 'wp_ajax_getOptionIcons', [ $this, 'getOptionIcons' ] );
		add_action( 'wp_ajax_nopriv_getOptionIcons', [ $this, 'getOptionIcons' ] ); // For non-logged in users
	}
	
	/**
	 * Enqueue input scripts and styles
	 *
	 * @param array $field
	 *
	 * @return void
	 * @since     1.0.0
	 */
	public function enqueueOptionScripts( array $field ) : void {
		
		// Enqueue Thickbox scripts
		wp_enqueue_script( 'thickbox' );
		wp_enqueue_style( 'thickbox' );
		
		//libraries icons css
		$icon_style_links = dht_get_icon_style_by_type();
		foreach ( $icon_style_links as $icon_type => $icon_link ) {
			wp_register_style( DHT_PREFIX_CSS . '-' . $icon_type . '-icon', esc_url( $icon_link ), array(), DHT::$version );
			wp_enqueue_style( DHT_PREFIX_CSS . '-' . $icon_type . '-icon' );
		}
		
		if( Environment::isDevelopment() ) {
			wp_register_style( DHT_PREFIX_CSS . '-icon-field', DHT_ASSETS_URI . 'dist/css/icon.css', array(), DHT::$version );
			wp_enqueue_style( DHT_PREFIX_CSS . '-icon-field' );
			
			wp_enqueue_script_module( DHT_PREFIX_JS . '-icon-field', DHT_ASSETS_URI . 'dist/js/icon.js', array( 'jquery' ), DHT::$version );
		}
	}
	
	/**
	 * ajax action to retrieve all icons and display then in the popup
	 *
	 * @return void
	 * @since     1.0.0
	 */
	public function getOptionIcons() : void {
		
		if( isset( $_POST[ 'action' ] ) && $_POST[ 'action' ] == "getOptionIcons" && isset( $_POST[ 'data' ][ 'icon_type' ] ) ) {
			
			//retrieve icon type
			$icon_type = $_POST[ 'data' ][ 'icon_type' ];
			$icon      = !empty( $_POST[ 'data' ][ 'icon' ] ) ? $_POST[ 'data' ][ 'icon' ] : '';
			
			$icons = [];
			
			if( $icon_type == 'dashicons' ) {
				$icons = dht_get_variables_from_file( DHT_OPTIONS_DIR . 'fields/fields/icons/dashicons.php', 'dashicons' );
			}
			
			if( $icon_type == 'fontawesome' ) {
				$icons = dht_get_variables_from_file( DHT_OPTIONS_DIR . 'fields/fields/icons/font-awesome.php', 'font_awesome_icons' );
			}
			
			if( $icon_type == 'divi' ) {
				$icons = dht_get_variables_from_file( DHT_OPTIONS_DIR . 'fields/fields/icons/divi.php', 'divi_icons' );
			}
			
			if( $icon_type == 'elusive' ) {
				$icons = dht_get_variables_from_file( DHT_OPTIONS_DIR . 'fields/fields/icons/elusive.php', 'elusive_icons' );
			}
			
			if( $icon_type == 'line' ) {
				$icons = dht_get_variables_from_file( DHT_OPTIONS_DIR . 'fields/fields/icons/line.php', 'line_icons' );
			}
			
			if( $icon_type == 'dev' ) {
				$icons = dht_get_variables_from_file( DHT_OPTIONS_DIR . 'fields/fields/icons/devicon.php', 'devicon_icons' );
			}
			
			if( $icon_type == 'bootstrap' ) {
				$icons = dht_get_variables_from_file( DHT_OPTIONS_DIR . 'fields/fields/icons/bootstrap.php', 'bootstrap_icons' );
			}
			
			if( !empty( $icons ) ) {
				
				ob_start();
				
				foreach ( $icons as $icon_class => $icon_code ) {
					
					//set active icon
					$active_icon = $icon == $icon_class ? 'dht-active-icon="true"' : '';
					
					echo '<i class="' . $icon_class . '" data-code="' . $icon_code . '" ' . $active_icon . ' ></i>';
				}
				
				$icon_templates = ob_get_clean();
				
			}
			else {
				
				$icon_templates = _x( 'No icons provided for this icon type', 'options', 'dht' );
			}
			
			wp_send_json_success( $icon_templates );
			
			die();
		}
	}
	
	/**
	 * add prefix id for field id to display it in the form as array values
	 * (used to retrieve the $_POST['prefix_id'] values)
	 *
	 * @param array  $field
	 * @param string $options_id
	 *
	 * @return array
	 * @since     1.0.0
	 */
	public function addIDPrefix( array $field, string $options_id ) : array {
		
		if( !empty( $options_id ) ) {
			$field[ 'name' ] = $options_id . '[' . $field[ 'id' ] . ']';
			$field[ 'id' ]   = str_replace( [
				'[',
				']'
			], '-', $options_id . '-' . $field[ 'id' ] );
		}
		else {
			$field[ 'name' ] = $field[ 'id' ];
		}
		
		return $field;
	}
	
	/**
	 *  In this method you receive $field_post_value (from form submit or whatever)
	 *  and must return correct and safe value that will be stored in database.
	 *
	 *  $field_post_value can be null.
	 *  In this case you should return default value from $field['value']
	 *
	 * @param array $field            - field
	 * @param mixed $field_post_value - $field $_POST value passed on save
	 *
	 * @return mixed mixed - changed field value
	 * mixed - changed field value
	 * @since     1.0.0
	 */
	public function saveValue( array $field, mixed $field_post_value ) : mixed {
		
		if( empty( $field_post_value ) ) {
			return $field[ 'value' ];
		}
		
		if( is_array( $field_post_value ) ) {
			return $field_post_value;
		}
		else {
			//if it is a json object without escaped characters
			$data = json_decode( $field_post_value, true );
			
			if( json_last_error() !== JSON_ERROR_NONE ) {
				$data = json_decode( stripslashes( $field_post_value ), true );
			}
			
			return $data;
		}
	}
	
}
