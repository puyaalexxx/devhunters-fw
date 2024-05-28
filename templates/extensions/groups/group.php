<?php

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use function DHT\Helpers\dht_parse_option_attributes;
use function DHT\Helpers\dht_render_option_if_exists;

$group = $args[ 'group' ] ?? [];
//used to call the render method on
$registered_options = $args[ 'registered_options' ] ?? [];
?>
    <!-- field - group -->
    <div class="dht-field-wrapper">

        <div class="dht-title"><?php echo esc_html( $group[ 'title' ] ); ?></div>

        <div
            class="dht-field-child-wrapper dht-field-child-groups <?php echo isset( $group[ 'attr' ][ 'class' ] ) ? esc_attr( $group[ 'attr' ][ 'class' ] ) : ''; ?>"
            <?php echo dht_parse_option_attributes( $group[ 'attr' ] ); ?>>

            <div class="dht-field-groups">

                <?php
                foreach ( $group[ 'options' ] as $group_option ) {

                    //get saved value
                    $saved_value = $args[ 'saved_value' ][ $group_option[ 'id' ] ] ?? [];

                    //render the specific option type
                    echo dht_render_option_if_exists( $group_option, $saved_value, $group[ 'id' ], $registered_options );
                }
                ?>

            </div>

            <?php if ( !empty( $group[ 'description' ] ) ): ?>
                <div class="dht-description"><?php echo esc_html( $group[ 'description' ] ); ?></div>
            <?php endif; ?>

        </div>

        <?php if ( !empty( $group[ 'tooltip' ] ) ): ?>
            <div class="dht-info-help dashicons dashicons-info"
                 data-tooltips="<?php echo esc_html( $group[ 'tooltip' ] ); ?>"
                 data-position="OnLeft">
            </div>
        <?php endif; ?>

    </div>

<?php if ( isset( $group[ 'divider' ] ) && $group[ 'divider' ] ): ?>
    <div class="dht-divider"></div>
<?php endif; ?>