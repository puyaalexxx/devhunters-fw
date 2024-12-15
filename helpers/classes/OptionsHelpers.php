<?php
declare( strict_types = 1 );

namespace DHT\Helpers\Classes;

use function DHT\Helpers\dht_load_view;

if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

/**
 * Helper methods for framework options use only
 */
final class OptionsHelpers {
	
	/**
	 * render all group, toggle and field option types
	 *
	 * @param array  $options                    options array
	 * @param string $options_id                 options prefix id
	 * @param mixed  $saved_values               all options saved values
	 * @param array  $registered_options_classes registered framework groups, toggles, and field classes
	 *
	 * @return string
	 * @since     1.0.0
	 */
	public static function renderOptions( array $options, string $options_id, mixed $saved_values, array $registered_options_classes ) : string {
		
		ob_start();
		
		foreach ( $options as $option ) {
			
			//get option saved value by its id
			$saved_value = $saved_values[ $option[ 'id' ] ] ?? [];
			
			//if it is a group type
			if( isset( $option[ 'type' ] ) && array_key_exists( $option[ 'type' ], $registered_options_classes[ 'groupsClasses' ] ) ) {
				//render the respective option group class
				echo $registered_options_classes[ 'groupsClasses' ][ $option[ 'type' ] ]->render( $option, $saved_value, $options_id );
			} //if it is a toggle type
            elseif( isset( $option[ 'type' ] ) && array_key_exists( $option[ 'type' ], $registered_options_classes[ 'togglesClasses' ] ) ) {
				//render the respective option toggle class
				echo $registered_options_classes[ 'togglesClasses' ][ $option[ 'type' ] ]->render( $option, $saved_value, $options_id );
			}
			else {
				//render the respective option type class
				echo self::renderFieldIfExists( $option, $saved_value, $options_id, $registered_options_classes[ 'fieldsClasses' ] );
			}
		}
		
		return ob_get_clean();
	}
	
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
	public static function renderGroup( string $group_id, array $group_option, mixed $saved_value, array $registered_options_classes ) : string {
		
		//render the respective option toggle class
		if( array_key_exists( $group_option[ 'type' ], $registered_options_classes[ 'togglesClasses' ] ) ) {
			return $registered_options_classes[ 'togglesClasses' ][ $group_option[ 'type' ] ]->render( $group_option, $saved_value, $group_id );
		} //render the specific field type
		else {
			return self::renderFieldIfExists( $group_option, $saved_value, $group_id, $registered_options_classes[ 'fieldsClasses' ] );
		}
	}
	
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
	public static function renderFieldIfExists( array $option, mixed $saved_value, string $options_id, array $registered_field_classes ) : string {
		
		if( isset( $option[ 'type' ] ) && array_key_exists( $option[ 'type' ], $registered_field_classes ) ) {
			
			//render the respective option type class
			return $registered_field_classes[ $option[ 'type' ] ]->render( $option, $saved_value, $options_id );
			
		}
		else {
			//display no option template if no match
			return dht_load_view( DHT_VIEWS_DIR . 'core/options/fields/', 'no-option.php' );
		}
	}
	
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
	public static function displayBoxItem( array $group, mixed $saved_values, array $registered_options_classes, int $cnt ) : string {
		
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
                    data-default-title="<?php echo esc_attr( $group[ "box-title" ] ); ?>">
                    <?php echo !empty( $saved_values[ 'box-title' ] ) ? esc_html( $saved_values[ 'box-title' ] ) : $group[ "box-title" ]; ?>
                </span>

            </div>

            <div class="dht-addable-box-content">
				<?php echo self::renderBoxItemContent( $group, $saved_values, $registered_options_classes, $cnt ); ?>
            </div>

        </div>
		<?php
		return ob_get_clean();
	}
	
	/**
	 * render box item content (addable group option)
	 *
	 * @param array $group                      group options to be rendered
	 * @param mixed $saved_values               Saved values
	 * @param array $registered_options_classes registered option type classes
	 * @param int   $cnt                        The box item number
	 *
	 * @return mixed
	 * @since     1.0.0
	 */
	public static function renderBoxItemContent( array $group, mixed $saved_values, array $registered_options_classes, int $cnt ) : string {
		
		ob_start(); ?>
        <div class="dht-field-wrapper">
            <div class="dht-field-box-wrapper dht-field-child-input">
                <label
                    for="<?php echo esc_attr( $group[ 'id' ] ); ?>[<?php echo esc_attr( $cnt ); ?>][box-title]">
					<?php echo !empty( $saved_values[ 'box-title' ] ) ? esc_html( $saved_values[ 'box-title' ] ) : $group[ "box-title" ] ?>
                </label>
                <input
                    class="dht-input dht-field dht-box-title"
                    id="<?php echo esc_attr( $group[ 'id' ] ); ?>[<?php echo esc_attr( $cnt ); ?>][box-title]"
                    type="text"
                    name="<?php echo esc_attr( $group[ 'id' ] ); ?>[<?php echo esc_attr( $cnt ); ?>][box-title]"
                    value="<?php echo !empty( $saved_values[ 'box-title' ] ) ? esc_html( $saved_values[ 'box-title' ] ) : ''; ?>"
                    placeholder="<?php echo esc_attr( $group[ 'box-title' ] ); ?>" />
            </div>
        </div>

        <div class="dht-divider"></div>

        <!--box fields-->
		<?php foreach ( $group[ 'options' ] as $option ) : ?>
			
			<?php
			$group_id = $group[ 'id' ] . '[' . esc_attr( $cnt ) . ']';
			//get option saved value if exists
			$saved_value = array_key_exists( $option[ 'id' ], $saved_values ) ? $saved_values[ $option[ 'id' ] ] : [];
			
			echo OptionsHelpers::renderGroup( $group_id, $option, $saved_value, $registered_options_classes );
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
	
	/**
	 * Function to render the content of the header link area
	 *
	 * @param string $page_link Page link where to redirect or anchor id
	 * @param array  $page      Page options
	 *
	 * @return void The processed value to be saved.
	 * @since     1.0.0
	 */
	public static function renderLinkArea( string $page_link, array $page ) : void { ?>

        <a href="<?php echo !empty( $page_link ) ? esc_url( $page_link ) : '#' . $page[ 'id' ]; ?>">
        <span class="dht-cosidebar-icon">
            
            <?php if( filter_var( $page[ 'icon' ], FILTER_VALIDATE_URL ) ): ?>

                <img src="<?php echo esc_url( $page[ 'icon' ] ); ?>" alt="<?php echo esc_attr( $page[ 'title' ] ); ?>">
            
            <?php else: ?>

                <span class="<?php echo esc_attr( $page[ 'icon' ] ); ?>"></span>
            
            <?php endif; ?>
            
        </span>
            <span class="title"><?php echo esc_html( $page[ 'title' ] ); ?></span>
        </a>
		<?php
	}
	
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
	public static function renderSubpageLiArea( string $active_class, string $page_link, array $page ) : void { ?>

        <li class="<?php echo esc_attr( $active_class ); ?>">
            <a href="<?php echo !empty( $page_link ) ? esc_url( $page_link ) : '#' . $page[ 'id' ]; ?>">
				
				<?php echo esc_html( $page[ 'title' ] ); ?>

            </a>
        </li>
		<?php
	}
	
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
	public static function renderSidebarContent( array $ids, array $options, mixed $saved_values, array $registered_options_classes, int $count ) : string {
		
		$is_active_class = ( $count == 1 ) ? 'dht-cosidebar-active' : '';
		
		//get specific page group/option saved value
		$saved_value = $saved_values[ $ids[ 'menu_id' ] ] ?? [];
		
		//id used for tabs options
		$content_id = !empty( $ids[ 'subpage_id' ] ) ? $ids[ 'subpage_id' ] : ( !empty( $ids[ 'page_id' ] ) ? $ids[ 'page_id' ] : '' );
		
		ob_start(); ?>

        <div id="<?php echo esc_attr( $content_id ); ?>"
             class="dht-cosidebar-content <?php echo esc_attr( $is_active_class ); ?> ">
			
			<?php echo OptionsHelpers::renderOptions( $options, $ids[ 'menu_id' ], $saved_value, $registered_options_classes ) ?>

        </div>
		
		<?php
		return ob_get_clean();
	}
	
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
	public static function ifParentMenuIsActive( array $page, string $current_page ) : bool {
		
		$active_parent_class = false;
		if( isset( $page[ 'pages' ] ) ) {
			// Iterate through the array to check if the link exists
			foreach ( $page[ 'pages' ] as $item ) {
				if( isset( $item[ 'page_link' ] ) && $item[ 'page_link' ] == $current_page ) {
					$active_parent_class = true;
					break;
				}
			}
		}
		
		return $active_parent_class;
	}
	
	/**
	 * add live data attributes with the css selectors
	 * and their targets that need to be changed on live
	 * editing via js
	 * Some sort of one way data binding
	 *
	 * @param array $selectors Live attributes
	 *
	 * @return string
	 * @since     1.0.0
	 */
	public static function liveOptionSelectors( array $selectors ) : string {
		
		if( !empty( $selectors ) ) {
			
			return 'data-live-selectors="' . htmlspecialchars( json_encode( $selectors ), ENT_QUOTES ) . '"';
		}
		
		return "";
	}
	
}