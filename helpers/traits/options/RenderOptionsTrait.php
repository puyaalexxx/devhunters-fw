<?php
declare( strict_types = 1 );

namespace DHT\Helpers\Traits\Options;

if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

use DHT\Helpers\Classes\OptionsHelpers;
use function DHT\Helpers\dht_load_view;

trait RenderOptionsTrait {
	
	/**
	 * Render content for dashboard pages, metaboxes and terms area.
	 *
	 * @param array  $options  Options array.
	 * @param string $location Where to save the data - dashboard/post or term
	 * @param int    $id       The post or term ID if rendering post type metabox content or term fields.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	private function _renderContent( array $options, string $location = 'dashboard', int $id = 0 ) : void {
		
		$template = apply_filters( 'dht:options:template_file', $this->_getOptionsTemplate( $location ) );
		
		$viewData = [
			'nonce'   => apply_filters( 'dht:options:get_nonce_field', $this->_nonce ),
			'options' => apply_filters( 'dht:options:view_html', $this->_getOptionsView( $options, $location, $id ) ),
		];
		
		//add 'metabox_id' if it exists
		if( isset( $options[ 'options_id' ] ) ) {
			$viewData[ 'metabox_id' ] = $options[ 'options_id' ];
		}
		
		if( $location == 'vb' ) {
			echo dht_load_view( DHT_VIEWS_DIR . 'core/vb/', $template, $viewData );
		}
		else {
			echo dht_load_view( DHT_VIEWS_DIR . 'core/options/', $template, $viewData );
		}
	}
	
	/**
	 * Generates the HTML view for the options.
	 *
	 * This method retrieves the saved options, determines the type of options being rendered,
	 * and generates the appropriate HTML output. It handles both container types and group/toggle/field types.
	 *
	 *
	 * @param array  $options
	 * @param string $location Where to save the data - dashboard/post or term
	 * @param int    $id       post id or term id
	 *
	 * @return string
	 * @since     1.0.0
	 */
	private function _getOptionsView( array $options, string $location = 'dashboard', int $id = 0 ) : string {
		
		$saved_values = apply_filters( 'dht:options:set_saved_values', $this->_getOptionsSavedValues( $options, $location, $id ) );
		
		// Start output buffering
		ob_start();
		
		// Render container options
		if( isset( $options[ 'type' ] ) && array_key_exists( $options[ 'type' ], $this->_optionContainerClasses ) ) {
			echo $this->_optionContainerClasses[ $options[ 'type' ] ]->render( $options, $saved_values );
		} // Render ungrouped option types
		else {
			echo OptionsHelpers::renderOptions( $options[ 'options' ] ?? $options, $options[ 'id' ] ?? '', $saved_values, [
				'groupsClasses'  => $this->_optionGroupsClasses,
				'togglesClasses' => $this->_optionTogglesClasses,
				'fieldsClasses'  => $this->_optionFieldsClasses,
			] );
		}
		
		// Return the generated HTML view
		return ob_get_clean();
	}
	
	/**
	 * Get the correct option template
	 *
	 * @param string $location Where the options are located (dashboard/post/term)
	 *
	 * @return string
	 * @since     1.0.0
	 */
	private function _getOptionsTemplate( string $location ) : string {
		
		if( $location == 'post' ) {
			$template = 'posts.php';
		}
		elseif( $location == 'term' ) {
			$template = 'terms.php';
		}
		elseif( $location == 'vb' ) {
			$template = 'modal.php';
		}
		else {
			$template = 'dashboard-page.php';
		}
		
		return $template;
	}
	
}