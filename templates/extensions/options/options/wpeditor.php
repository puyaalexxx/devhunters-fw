<?php
if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use function DHT\Helpers\dht_parse_option_attributes;

$option = $args[ 'option' ] ?? [];

$rows = !empty( $option[ 'row' ] ) ? esc_attr( $option[ 'row' ] ) : 10;
?>

<!-- field - wpeditor - type -> nomedia -->
<div
    class="dht-field-wrapper <?php echo isset( $option[ 'attr' ][ 'class' ] ) ? esc_attr( $option[ 'attr' ][ 'class' ] ) : ''; ?>" <?php echo dht_parse_option_attributes( $option[ 'attr' ] ); ?>>

    <div class="dht-title"><?php echo esc_html( $option[ 'title' ] ); ?></div>

    <div class="dht-field-child-wrapper dht-field-child-editor">

        <?php
        wp_editor( $option[ 'value' ],
            'my_custom_editor_id_' . esc_attr( $option[ 'id' ] ),
            [ 'textarea_name' => esc_attr( $option[ 'name' ] ), 'editor_id' => esc_attr( $option[ 'id' ] ),
                'media_buttons' => $option[ 'media_button' ], 'textarea_rows' => $rows,
                'tinymce' => esc_attr( (bool)$option[ 'tinymce' ] ) ]
        );
        ?>

        <?php if ( !empty( $option[ 'description' ] ) ): ?>
            <div class="dht-description"><?php echo esc_html( $option[ 'description' ] ); ?></div>
        <?php endif; ?>

    </div>

    <?php if ( !empty( $option[ 'tooltip' ] ) ): ?>
        <div class="dht-info-help dashicons dashicons-info"
             data-tooltips="<?php echo esc_html( $option[ 'tooltip' ] ); ?>"
             data-position="OnLeft">
        </div>
    <?php endif; ?>

</div>

<?php if ( isset( $option[ 'divider' ] ) && $option[ 'divider' ] ): ?>
    <div class="dht-divider"></div>
<?php endif; ?>
