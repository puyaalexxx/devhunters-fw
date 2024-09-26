<?php
declare( strict_types = 1 );

namespace DHT\Helpers;

if ( ! defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

///////////////////////////Functions used only in the framework//////////////////////////////

if ( ! function_exists( 'dht_fw_get_font_weight_Label' ) ) {
	/**
	 * gent font weight label from its value (ex: 400, 500)
	 *
	 * @param int $font_weight
	 *
	 * @return string
	 * @since     1.0.0
	 */
	function dht_fw_get_font_weight_Label( int $font_weight ) : string {
		
		return match ( $font_weight ) {
			100 => 'Thin',
			200 => 'Extra Light',
			300 => 'Light',
			400 => 'Regular',
			500 => 'Medium',
			600 => 'Semi Bold',
			700 => 'Bold',
			800 => 'Extra Bold',
			900 => 'Black'
		};
	}
}

if ( ! function_exists( 'dht_fw_render_options' ) ) {
	/**
	 * render all group, toggle and field option types
	 *
	 * @param array  $options                    options array
	 * @param string $options_id                 options prefix id
	 * @param array  $saved_values               all options saved values
	 * @param array  $registered_options_classes registered framework groups, toggles, and field classes
	 *
	 * @return string
	 * @since     1.0.0
	 */
	function dht_fw_render_options( array $options, string $options_id, array $saved_values, array $registered_options_classes ) : string {
		
		ob_start();
		
		foreach ( $options as $option ) {
			
			//get option saved value by its id
			$saved_value = $saved_values[ $option[ 'id' ] ] ?? [];
			
			//if it is a group type
			if ( isset( $option[ 'type' ] ) && array_key_exists( $option[ 'type' ], $registered_options_classes[ 'groupsClasses' ] ) ) {
				//render the respective option group class
				echo $registered_options_classes[ 'groupsClasses' ][ $option[ 'type' ] ]->render( $option, $saved_value, $options_id );
			} //if it is a toggle type
            elseif ( isset( $option[ 'type' ] ) && array_key_exists( $option[ 'type' ], $registered_options_classes[ 'togglesClasses' ] ) ) {
				//render the respective option toggle class
				echo $registered_options_classes[ 'togglesClasses' ][ $option[ 'type' ] ]->render( $option, $saved_value, $options_id );
			} else {
				//render the respective option type class
				echo dht_fw_render_field_if_exists( $option, $saved_value, $options_id, $registered_options_classes[ 'fieldsClasses' ] );
			}
		}
		
		return ob_get_clean();
	}
}


if ( ! function_exists( 'dht_fw_render_group' ) ) {
	/**
	 * render group options (toggles and field options)
	 *
	 * @param string $group_id                   the group option id
	 * @param array  $group_option               group option settings
	 * @param mixed  $saved_value                Saved values
	 * @param array  $registered_options_classes registered framework field classes
	 *
	 * @return string
	 * @since     1.0.0
	 */
	function dht_fw_render_group( string $group_id, array $group_option, mixed $saved_value, array $registered_options_classes ) : string {
		
		//render the respective option toggle class
		if ( array_key_exists( $group_option[ 'type' ], $registered_options_classes[ 'togglesClasses' ] ) ) {
			return $registered_options_classes[ 'togglesClasses' ][ $group_option[ 'type' ] ]->render( $group_option, $saved_value, $group_id );
		} //render the specific field type
		else {
			return dht_fw_render_field_if_exists( $group_option, $saved_value, $group_id, $registered_options_classes[ 'fieldsClasses' ] );
		}
	}
}


if ( ! function_exists( 'dht_fw_render_field_if_exists' ) ) {
	/**
	 * render field option if it is registered (exists)
	 *
	 * @param array  $option                   option array
	 * @param mixed  $saved_value              saved values
	 * @param string $options_id               options prefix id
	 * @param array  $registered_field_classes registered framework field classes
	 *
	 * @return string
	 * @since     1.0.0
	 */
	function dht_fw_render_field_if_exists( array $option, mixed $saved_value, string $options_id, array $registered_field_classes ) : string {
		
		if ( isset( $option[ 'type' ] ) && array_key_exists( $option[ 'type' ], $registered_field_classes ) ) {
			
			//render the respective option type class
			return $registered_field_classes[ $option[ 'type' ] ]->render( $option, $saved_value, $options_id );
			
		} else {
			//display no option template if no match
			return dht_load_view( DHT_VIEWS_DIR . 'extensions/options/fields/', 'no-option.php' );
		}
	}
}

if ( ! function_exists( 'dht_fw_display_box_item' ) ) {
	/**
	 * render box item (addable group option)
	 *
	 * @param array $group                      group options to be rendered
	 * @param mixed $saved_values               Saved values
	 * @param array $registered_options_classes registered option type classes
	 * @param int   $cnt                        The box item number
	 *
	 * @return string
	 * @since     1.0.0
	 */
	function dht_fw_display_box_item( array $group, mixed $saved_values, array $registered_options_classes, int $cnt ) : string {
		
		$default_box_title = _x( 'Box Title', 'options', DHT_PREFIX );
		
		ob_start();
		?>
        <div class="dht-addable-box-item" data-box-item-number="<?php echo esc_attr( $cnt ); ?>">

            <div class="dht-addable-box-title">

                <div class="dht-addable-box-arrow">
                    <span class="dht-addable-box-arrow-item dashicons dashicons-plus-alt"></span>
                    <span class="dht-addable-box-arrow-item-close dashicons dashicons-dismiss"></span>
                </div>

                <span
                    class="dht-addable-box-title-text"
                    data-default-title="<?php echo esc_attr( $default_box_title ); ?>">
                    <?php echo ! empty( $saved_values[ 'box-title' ] ) ? esc_html( $saved_values[ 'box-title' ] ) : $default_box_title; ?>
                </span>

            </div>

            <div class="dht-addable-box-content">
				
				<?php echo dht_fw_render_box_item_content( $group, $saved_values, $registered_options_classes, $default_box_title, $cnt ); ?>

            </div>

        </div>
		<?php
		return ob_get_clean();
	}
}


if ( ! function_exists( 'dht_fw_render_box_item_content' ) ) {
	/**
	 * render box item content (addable group option)
	 *
	 * @param array  $group                      group options to be rendered
	 * @param mixed  $saved_values               Saved values
	 * @param array  $registered_options_classes registered option type classes
	 * @param string $default_box_title          The default bot item title
	 * @param int    $cnt                        The box item number
	 *
	 * @return mixed
	 * @since     1.0.0
	 */
	function dht_fw_render_box_item_content( array $group, mixed $saved_values, array $registered_options_classes, string $default_box_title, int $cnt ) : string {
		
		ob_start(); ?>
        <div class="dht-field-wrapper">
            <div class="dht-field-box-wrapper dht-field-child-input">
                <label
                    for="<?php echo esc_attr( $group[ 'id' ] ); ?>[<?php echo esc_attr( $cnt ); ?>][box-title]">
					<?php echo ! empty( $saved_values[ 'box-title' ] ) ? esc_html( $saved_values[ 'box-title' ] ) : _x( 'Box Title', 'options', DHT_PREFIX ); ?>
                </label>
                <input
                    class="dht-input dht-field dht-box-title"
                    id="<?php echo esc_attr( $group[ 'id' ] ); ?>[<?php echo esc_attr( $cnt ); ?>][box-title]"
                    type="text"
                    name="<?php echo esc_attr( $group[ 'id' ] ); ?>[<?php echo esc_attr( $cnt ); ?>][box-title]"
                    value="<?php echo ! empty( $saved_values[ 'box-title' ] ) ? esc_html( $saved_values[ 'box-title' ] ) : ''; ?>"
                    placeholder="<?php echo esc_attr( $default_box_title ); ?>" />
            </div>
        </div>

        <div class="dht-divider"></div>

        <!--box fields-->
		<?php foreach ( $group[ 'options' ] as $option ) : ?>
			
			<?php
			$group_id = $group[ 'id' ] . '[' . esc_attr( $cnt ) . ']';
			//get option saved value if exists
			$saved_value = array_key_exists( $option[ 'id' ], $saved_values ) ? $saved_values[ $option[ 'id' ] ] : [];
			
			echo dht_fw_render_group( $group_id, $option, $saved_value, $registered_options_classes );
			?>
		
		<?php endforeach; ?>

        <!--remove box area-->
        <div class="dht-remove-box-item">
            <div class="dht-divider"></div>

            <a href=""
               class="button button-primary dht-btn-remove-box-item"><?php _ex( 'Remove Box', 'options', DHT_PREFIX ); ?></a>
        </div>
		
		<?php
		return ob_get_clean();
	}
}


if ( ! function_exists( 'dht_fw_is_save_options_separately' ) ) {
	/**
	 * check if the options must be saved separately and not grouped under an id
	 *
	 * @param array $options
	 *
	 * @return bool
	 * @since     1.0.0
	 */
	function dht_fw_is_save_options_separately( array $options ) : bool {
		
		return isset( $options[ 'save' ] ) && $options[ 'save' ] == "separately";
	}
}


if ( ! function_exists( 'dht_fw_render_link_area' ) ) {
	/**
	 * Function to render the content of the header link area
	 *
	 * @param string $page_link Page link where to redirect or anchor id
	 * @param array  $page      Page options
	 *
	 * @return void The processed value to be saved.
	 * @since     1.0.0
	 */
	function dht_fw_render_link_area( string $page_link, array $page ) : void { ?>

        <a href="<?php echo ! empty( $page_link ) ? esc_url( $page_link ) : '#' . $page[ 'id' ]; ?>">
        <span class="dht-cosidebar-icon">
            
            <?php if ( filter_var( $page[ 'icon' ], FILTER_VALIDATE_URL ) ): ?>

                <img src="<?php echo esc_url( $page[ 'icon' ] ); ?>" alt="<?php echo esc_attr( $page[ 'title' ] ); ?>">
            
            <?php else: ?>

                <span class="<?php echo esc_attr( $page[ 'icon' ] ); ?>"></span>
            
            <?php endif; ?>
            
        </span>
            <span class="title"><?php echo esc_html( $page[ 'title' ] ); ?></span>
        </a>
		<?php
	}
}


if ( ! function_exists( 'dht_fw_render_subpage_li_area' ) ) {
	/**
	 * Function to render the content of the header supbpage li tag
	 *
	 * @param string $active_class Active class
	 * @param string $page_link    Page link where to redirect or anchor id
	 * @param array  $page         Page options
	 *
	 * @return void The processed value to be saved.
	 * @since     1.0.0
	 */
	function dht_fw_render_subpage_li_area( string $active_class, string $page_link, array $page ) : void { ?>

        <li class="<?php echo esc_attr( $active_class ); ?>">
            <a href="<?php echo ! empty( $page_link ) ? esc_url( $page_link ) : '#' . $page[ 'id' ]; ?>">
				
				<?php echo esc_html( $page[ 'title' ] ); ?>

            </a>
        </li>
		<?php
	}
}


if ( ! function_exists( 'dht_fw_render_sidebar_content' ) ) {
	/**
	 * Function to render the content of the sidebar
	 *
	 * @param array $ids                        pages ids
	 * @param array $options                    page options
	 * @param mixed $saved_values               Saved values
	 * @param array $registered_options_classes registered option type classes
	 * @param int   $count                      The box item number
	 *
	 * @return string The processed value to be saved.
	 * @since     1.0.0
	 */
	function dht_fw_render_sidebar_content( array $ids, array $options, mixed $saved_values, array $registered_options_classes, int $count ) : string {
		
		$is_active_class = ( $count == 1 ) ? 'dht-cosidebar-active' : '';
		
		//get specific page group/option saved value
		$saved_value = $saved_values[ $ids[ 'menu_id' ] ] ?? [];
		
		//id used for tabs options
		$content_id = ! empty( $ids[ 'subpage_id' ] ) ? $ids[ 'subpage_id' ] : ( ! empty( $ids[ 'page_id' ] ) ? $ids[ 'page_id' ] : '' );
		
		ob_start(); ?>

        <div id="<?php echo esc_attr( $content_id ); ?>"
             class="dht-cosidebar-content <?php echo esc_attr( $is_active_class ); ?> ">
			
			<?php echo dht_fw_render_options( $options, $ids[ 'menu_id' ], $saved_value, $registered_options_classes ) ?>

        </div>
		
		<?php
		return ob_get_clean();
	}
}


if ( ! function_exists( 'dht_fw_if_parent_menu_is_active' ) ) {
	/**
	 * see if the parent menu is also active if the sub menu is active
	 * Function to render the content of the sidebar
	 *
	 * @param array  $page         Subpages settings
	 * @param string $current_page current clicked page (menu item)
	 *
	 * @return bool The processed value to be saved.
	 * @since     1.0.0
	 */
	function dht_fw_if_parent_menu_is_active( array $page, string $current_page ) : bool {
		
		$active_parent_class = false;
		if ( isset( $page[ 'pages' ] ) ) {
			// Iterate through the array to check if the link exists
			foreach ( $page[ 'pages' ] as $item ) {
				if ( isset( $item[ 'page_link' ] ) && $item[ 'page_link' ] == $current_page ) {
					$active_parent_class = true;
					break;
				}
			}
		}
		
		return $active_parent_class;
	}
}


if ( ! function_exists( 'dht_fw_get_composer_info' ) ) {
	/**
	 * Grab composer info to use in framework manifest
	 *
	 * @param string $composer_path
	 *
	 * @return array composer info
	 * @since     1.0.0
	 */
	function dht_fw_get_composer_info( string $composer_path = DHT_DIR . 'composer.json' ) : array {
		$composer_file = DHT_DIR . '/composer.json'; // Adjust the path if necessary
		
		$composer_info = [ 'version' => '1.0.0' ];
		if ( file_exists( $composer_path ) ) {
			$composer_data = file_get_contents( $composer_file );
			$composer_json = json_decode( $composer_data, true );
			
			if ( isset( $composer_json[ 'version' ] ) ) {
				$composer_info[ 'version' ] = $composer_json[ 'version' ];
			}
			if ( isset( $composer_json[ 'name' ] ) ) {
				$composer_info[ 'package_name' ] = $composer_json[ 'name' ];
			}
			if ( isset( $composer_json[ 'description' ] ) ) {
				$composer_info[ 'description' ] = $composer_json[ 'description' ];
			}
			if ( isset( $composer_json[ 'license' ] ) ) {
				$composer_info[ 'license' ] = $composer_json[ 'license' ];
			}
			if ( isset( $composer_json[ 'author' ] ) ) {
				$composer_info[ 'author' ] = $composer_json[ 'author' ];
			}
			if ( isset( $composer_json[ 'extra' ] ) ) {
				$composer_info[ 'extra' ] = $composer_json[ 'extra' ];
			}
			if ( isset( $composer_json[ 'support' ] ) ) {
				$composer_info[ 'support' ] = $composer_json[ 'support' ];
			}
			if ( isset( $composer_json[ 'require' ] ) ) {
				$composer_info[ 'require' ] = $composer_json[ 'require' ];
			}
		}
		
		return $composer_info;
	}
}