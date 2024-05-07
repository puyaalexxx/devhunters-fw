<?php
if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use function DHT\Helpers\dht_parse_option_attributes;

$rows = !empty( $args[ 'row' ] ) ? esc_attr( $args[ 'row' ] ) : 10;
?>

    <!-- field - wpeditor - type -> nomedia -->
    <div class="dht-field-wrapper">
        <div class="dht-title"><?php echo esc_html( $args[ 'title' ] ); ?></div>
        <div
            class="dht-field-child-wrapper dht-field-child-editor <?php echo isset( $args[ 'attr' ][ 'class' ] ) ? esc_attr( $args[ 'attr' ][ 'class' ] ) : ''; ?>"
            <?php echo dht_parse_option_attributes( $args[ 'attr' ] ); ?>>

            <?php
            wp_editor( $args[ 'value' ],
                'my_custom_editor_id',
                [ 'textarea_name' => esc_attr( $args[ 'name' ] ), 'editor_id' => esc_attr( $args[ 'id' ] ),
                    'media_buttons' => $args[ 'media_button' ], 'textarea_rows' => $rows,
                    'tinymce' => esc_attr( (bool)$args[ 'tinymce' ] ) ]
            );
            ?>

            <?php if ( !empty( $args[ 'description' ] ) ): ?>
                <div class="dht-description"><?php echo esc_html( $args[ 'description' ] ); ?></div>
            <?php endif; ?>
        </div>

        <?php if ( !empty( $args[ 'tooltip' ] ) ): ?>
            <div class="dht-info-help dashicons dashicons-info"
                 data-tooltips="<?php echo esc_html( $args[ 'tooltip' ] ); ?>"
                 data-position="OnLeft">
            </div>
        <?php endif; ?>

    </div>

<?php if ( $args[ 'divider' ] ): ?>
    <div class="dht-divider"></div>
<?php endif; ?>
