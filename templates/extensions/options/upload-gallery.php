<?php
if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use function DHT\Helpers\dht_parse_option_attributes;

$args = $args ?? [];
?>
    <!--upload gallery field-->
    <div class="dht-field-wrapper">

        <div class="dht-title"><?php echo esc_html( $args[ 'title' ] ); ?></div>

        <div
            class="dht-field-child-wrapper dht-field-child-upload dht-field-child-upload-gallery <?php echo isset( $args[ 'attr' ][ 'class' ] ) ? esc_attr( $args[ 'attr' ][ 'class' ] ) : ''; ?>"
            <?php echo dht_parse_option_attributes( $args[ 'attr' ] ); ?>>

            <div class="dht-gallery-group">

                <?php if ( !empty( $args[ 'value' ] ) ): ?>

                    <?php foreach ( $args[ 'value' ] as $attachment_id ): ?>

                        <?php $attachemnt_url = wp_get_attachment_url( $attachment_id ); ?>

                        <div class="dht-img-remove">
                            <span class="dht-img-remove-icon"></span>
                            <img data-id="<?php echo (int)$attachment_id; ?>"
                                 src="<?php echo esc_url( $attachemnt_url ); ?>"
                                 alt="" width="100"
                                 height="100" />
                        </div>

                    <?php endforeach; ?>

                <?php endif; ?>

            </div>

            <input class="dht-upload-gallery-hidden dht-field"
                   type="hidden"
                   id="<?php echo esc_attr( $args[ 'id' ] ); ?>"
                   name="<?php echo esc_attr( $args[ 'id' ] ); ?>"
                   value="<?php echo !empty( $args[ 'value' ] ) ? implode( ',', $args[ 'value' ] ) : ''; ?>" />

            <span class="dht-upload-gallery-button button"
                  data-media-text="<?php echo _x( 'Choose Images', 'options', DHT_PREFIX ) ?>">
            <?php echo _x( 'Upload Gallery', 'options', DHT_PREFIX ) ?>
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