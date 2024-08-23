<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Groups\Groups;

use DHT\Extensions\Options\Groups\BaseGroup;
use function DHT\fw;
use function DHT\Helpers\dht_load_view;
use function DHT\Helpers\dht_render_option_if_exists;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

final class AddableBox extends BaseGroup {

    //field type
    protected string $_group = 'addable-box';

    //group option
    private array $_groupOptions = [];

    /**
     * @param array $registered_options
     *
     * @since     1.0.0
     */
    public function __construct( array $registered_options ) {

        parent::__construct( $registered_options );

        add_action( 'wp_ajax_getBoxOptions', [ $this, 'getBoxOptions' ] );
        add_action( 'wp_ajax_nopriv_getBoxOptions', [ $this, 'getBoxOptions' ] ); // For non-logged in users
    }

    /**
     * Enqueue input scripts and styles
     *
     * @param array $group
     *
     * @return void
     * @since     1.0.0
     */
    public function enqueueOptionScripts( array $group ) : void {

        // Enqueue the WordPress editor scripts and styles
        wp_enqueue_editor();

        wp_register_style( DHT_PREFIX . '-addable-box-group', DHT_ASSETS_URI . 'styles/css/extensions/options/groups/addable-box-style.css', array(), fw()->manifest->get( 'version' ) );
        wp_enqueue_style( DHT_PREFIX . '-addable-box-group' );

        wp_enqueue_script( DHT_PREFIX . '-addable-box-group', DHT_ASSETS_URI . 'scripts/js/extensions/options/groups/addable-box-script.js', array( 'jquery' ), fw()->manifest->get( 'version' ), true );
        wp_localize_script( DHT_PREFIX . '-addable-box-group', DHT_PREFIX . '_addable_box_option_ajax', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
    }

    /**
     * return group template
     *
     * @param array  $group
     * @param mixed  $saved_values
     * @param string $prefix_id
     * @param array  $additional_args
     *
     * @return string
     * @since     1.0.0
     */
    public function render( array $group, mixed $saved_values, string $prefix_id, array $additional_args = [] ) : string {

        //merge default values with saved ones to display the saved ones
        $group = $this->mergeValues( $group, $saved_values );

        //add option prefix id
        $group = $this->addIDPrefix( $group, $prefix_id );

        return dht_load_view( $this->template_dir, $this->getGroup() . '.php', [
            'group' => $group,
            'additional_args' => $additional_args
        ] );
    }


    /**
     * ajax action to retrieve all icons and display then in the popup
     *
     * @return void
     * @since     1.0.0
     */
    public function getBoxOptions() : void {

        /*wp_send_json_success( $_POST );

        die();*/

        if ( isset( $_POST[ 'data' ][ 'json_data' ] ) ) {

            //retrieve box number
            $box_number = 1; //(int)$_POST[ 'data' ][ 'box_number' ];
            $group = !empty( $_POST[ 'data' ][ 'json_data' ] ) ? json_decode( stripslashes( html_entity_decode( $_POST[ 'data' ][ 'json_data' ], ENT_QUOTES, 'UTF-8' ) ), true ) : [];

            $saved_values = !empty( $group[ 'value' ] ) ? $group[ 'value' ] : [];

            //wp_send_json_success( $group );
            //die();

            ob_start();
            ?>

            <?php if ( !empty( $group ) ): ?>
                <!--box title field-->
                <div class="dht-field-wrapper">
                    <div class="dht-field-box-wrapper dht-field-child-input">
                        <label
                            for="<?php echo esc_attr( $group[ 'id' ] ); ?>[<?php echo esc_attr( $box_number ); ?>][box-title]">
                            <?php echo !empty( $saved_values[ 'box-title' ] ) ? esc_html( $saved_values[ 'box-title' ] ) : _x( 'Box Title', 'options', DHT_PREFIX ); ?>
                        </label>
                        <input
                            class="dht-input dht-field dht-box-title"
                            id="<?php echo esc_attr( $group[ 'id' ] ); ?>[<?php echo esc_attr( $box_number ); ?>][box-title]"
                            type="text"
                            name="<?php echo esc_attr( $group[ 'id' ] ); ?>[<?php echo esc_attr( $box_number ); ?>][box-title]"
                            value="<?php echo !empty( $saved_values[ 'box-title' ] ) ? esc_html( $saved_values[ 'box-title' ] ) : ''; ?>"
                            placeholder="<?php echo _x( 'Box Title Placeholder', 'options', DHT_PREFIX ); ?>" />
                    </div>
                </div>

                <div class="dht-divider"></div>

                <!--box fields-->
                <?php foreach ( $group[ 'options' ] as $option ) : ?>

                    <?php
                    //get option saved value if exists
                    $saved_value = array_key_exists( $option[ 'id' ], $saved_values ) ? $saved_values[ $option[ 'id' ] ] : '';

                    //render the specific option type
                    echo dht_render_option_if_exists( $option, $saved_value, $group[ 'id' ] . '[' . esc_attr( $box_number ) . ']', $this->_registeredOptions );
                    ?>

                <?php endforeach; ?>

                <!--remove box area-->
                <div class="dht-remove-toggle">
                    <div class="dht-divider"></div>

                    <a href=""
                       class="button button-primary dht-btn-remove-box-item"><?php _ex( 'Remove Box', 'options', DHT_PREFIX ); ?></a>
                </div>
            <?php else: ?>

                <?php echo _x( 'No options available', 'options', DHT_PREFIX ); ?>

            <?php endif; ?>

            <?php
            $content = ob_get_clean();

            wp_send_json_success( $content );

            die();
        }
    }

    /**
     *  In this method you receive $group_value (from form submit or whatever)
     *  and must return correct and safe value that will be stored in database.
     *
     *  $group_value can be null.
     *  In this case you should return default value from $group['value']
     *
     * @param array $group             - option field
     * @param mixed $group_post_values - $_POST values passed on save
     *
     * @return mixed - changed group value
     * @since     1.0.0
     */
    public function saveValue( array $group, mixed $group_post_values ) : mixed {

        if ( empty( $group_post_values ) || empty( $group[ 'options' ] ) ) {
            return $group[ 'value' ];
        }

        $sanitized_values = [];

        // Flatten options array to make it easier to access options by ID
        $options = [];
        foreach ( $group[ 'options' ] as $option ) {

            $options[ $option[ 'id' ] ] = $option;
        }

        //go through all the saved values and sanitize them
        foreach ( $group_post_values as $value_key => $values ) {

            foreach ( $values as $option_id => $value ) {

                //the box title, it is not located in the options array so we need to sanitize it separately
                if ( $option_id == 'box-title' ) {

                    $sanitized_values[ $value_key ] [ 'box-title' ] = sanitize_text_field( $value );

                    continue;
                }

                if ( isset( $options[ $option_id ] ) ) {

                    $sanitized_values[ $value_key ] [ $option_id ] = $this->_registeredOptions[ $options[ $option_id ][ 'type' ] ]->saveValue( $options[ $option_id ], $value );
                }
            }
        }

        return $sanitized_values;
    }

}
