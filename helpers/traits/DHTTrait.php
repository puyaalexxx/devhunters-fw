<?php
declare( strict_types = 1 );

namespace DHT\Helpers\Traits;

if( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

trait DHTTrait {
	
	/**
	 * get available plugin default settings that you can override
	 *
	 * @return array
	 * @since     1.0.0
	 */
	private function _getPluginSettingsDefaults() : array {
		
		return [
			"paths"    => [
				"plugin-settings-folder" => "",
				"options"                => [
					"dashboard-pages-options-folder" => "options/dashboard-pages/",
					"post-types-options-folder"      => "options/posts/",
					"terms-options-folder"           => "options/terms/",
					"vb-modal-options-folder"        => "options/vb/",
				],
				"features"               => [
					"dash-menus-settings-file" => "dashboard-pages.php",
					"cpts-settings-file"       => "cpts.php",
					"sidebars-settings-file"   => "sidebars.php",
				],
			],
			"features" => [
				"vb-register-on-post-types" => [],
				"enable-dynamic-sidebars"   => false,
			]
		];
	}
	
	/**
	 * get plugin settings and merge them with the default ones,
	 * also apply the filters on them to be able to change them from
	 * other places
	 *
	 * @param array $plugin_settings Plugin settings to register framework features
	 *
	 * @return array
	 * @since     1.0.0
	 */
	private function _getPreparedPluginSettings( array $plugin_settings = [] ) : array {
		
		// Merge the default settings with the passed settings
		$merged_settings = array_replace_recursive( $this->_getPluginSettingsDefaults(), $plugin_settings );
		
		[
			"paths"    => $paths,
			"features" => $features,
		] = $merged_settings;
		
		//get plugin settings folder path
		$plugin_settings_folder_path = apply_filters( "dht:plugin:settings:settings_folder_path", $paths[ 'plugin-settings-folder' ] ?? "" );
		
		return [
			//options
			"dashboard_pages_options_folder_path" => apply_filters( 'dht:plugin:settings:dashboard_pages_options_folder_path', $plugin_settings_folder_path . "/options/dashboard-pages/" ),
			"post_types_options_folder_path"      => apply_filters( 'dht:plugin:settings:post_types_options_folder_path', $plugin_settings_folder_path . "/options/posts/" ),
			"terms_options_folder_path"           => apply_filters( 'dht:plugin:settings:terms_options_folder_path', $plugin_settings_folder_path . "/options/terms/" ),
			"vb_modal_options_folder_path"        => apply_filters( 'dht:plugin:settings:vb_modal_options_folder_path', $plugin_settings_folder_path . "/options/vb/" ),
			//features files
			"dash_menus_settings_file"            => apply_filters( "dht:plugin:settings:dash_menus_settings_file", $plugin_settings_folder_path . '/dashboard-pages.php' ),
			"cpts_settings_file"                  => apply_filters( "dht:plugin:settings:cpts_settings_file", $plugin_settings_folder_path . '/cpts.php' ),
			"sidebars_settings_file"              => apply_filters( "dht:plugin:settings:sidebars_settings_file", $plugin_settings_folder_path . '/sidebars.php' ),
			
			//features
			"vb_register_on_post_types"           => apply_filters( 'dht:plugin:settings:vb_register_on_post_types', $features[ 'vb-register-on-post-types' ] ?? [] ),
			"enable_dynamic_sidebars"             => apply_filters( 'dht:plugin:settings:enable_dynamic_sidebars', $features[ 'enable-dynamic-sidebars' ] ?? false )
		];
	}
	
}