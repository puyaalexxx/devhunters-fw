<?php
if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use function DHT\Helpers\dht_parse_option_attributes;

$args = $args ?? [];

$image_url = '';
if ( !empty( $args[ 'value' ][ 'image_id' ] ) ) {

    $attachemnt_url = wp_get_attachment_url( (int)$args[ 'value' ][ 'image_id' ] );
    $image_url = $attachemnt_url;

} elseif ( !empty( $args[ 'value' ][ 'image' ] ) ) {

    $image_url = esc_url( $args[ 'value' ][ 'image' ] );
}
?>
    <!--upload image field-->
    <div class="dht-field-wrapper">

        <div class="dht-title"><?php echo esc_html( $args[ 'title' ] ); ?></div>

        <div
            class="dht-field-child-wrapper dht-field-child-upload dht-field-child-upload-image <?php echo isset( $args[ 'attr' ][ 'class' ] ) ? esc_attr( $args[ 'attr' ][ 'class' ] ) : ''; ?>"
            <?php echo dht_parse_option_attributes( $args[ 'attr' ] ); ?>>

            <label
                for="<?php echo esc_attr( $args[ 'id' ] ); ?>"><?php echo esc_html( $args[ 'label' ] ); ?></label><br />

            <!--show image preview if image link not empty -->
            <?php if ( !empty( $image_url ) ): ?>

                <img src="<?php echo esc_url( $image_url ); ?>" alt="" width="100"
                     height="100">

            <?php endif; ?>

            <input class="dht-upload dht-field"
                   type="text"
                   id="<?php echo esc_attr( $args[ 'id' ] ); ?>"
                   name="<?php echo esc_attr( $args[ 'id' ] ); ?>[image]"
                   value="<?php echo !empty( $image_url ) ? esc_url( $image_url ) : ''; ?>" />

            <input class="dht-upload-hidden dht-field"
                   type="hidden"
                   name="<?php echo esc_attr( $args[ 'id' ] ); ?>[image_id]"
                   value="<?php echo !empty( $args[ 'value' ][ 'image_id' ] ) ? esc_attr( (int)$args[ 'value' ][ 'image_id' ] ) : ''; ?>" />

            <span class="dht-upload-image-button button"
                  data-media-text="<?php echo _x( 'Choose Image', 'options', DHT_PREFIX ) ?>">
        <?php echo _x( 'Upload Image', 'options', DHT_PREFIX ) ?>
    </span>

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