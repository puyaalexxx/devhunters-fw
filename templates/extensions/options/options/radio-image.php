<?php
if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use function DHT\Helpers\dht_parse_option_attributes;

$option = $args[ 'option' ] ?? [];
?>
    <!-- field - radio image -->
    <div
        class="dht-field-wrapper <?php echo isset( $option[ 'attr' ][ 'class' ] ) ? esc_attr( $option[ 'attr' ][ 'class' ] ) : ''; ?>" <?php echo dht_parse_option_attributes( $option[ 'attr' ] ); ?>>

        <div class="dht-title"><?php echo esc_html( $option[ 'title' ] ); ?></div>

        <div class="dht-field-child-wrapper dht-field-child-image-select">

            <div class="dht-field-child-image-select-container">

                <?php if ( !empty( $option[ 'choices' ] ) ): ?>

                    <?php $cnt = 0;
                    foreach ( $option[ 'choices' ] as $value => $radio ): ?>

                        <?php $radio_id = esc_attr( $option[ 'id' ] ) . '-' . $cnt; ?>

                        <div
                            class="dht-img-select-wrapper <?php echo ( $option[ 'value' ] == $value ) ? 'dht-img-select-wrapper-selected' : ''; ?>">
                            <input class="dht-image-select dht-field"
                                   type="radio"
                                   name="<?php echo esc_attr( $radio_id ); ?>[img]"
                                   id="<?php echo esc_attr( $radio_id ); ?>"
                                   value="<?php echo esc_attr( $value ); ?>"
                                <?php echo ( $option[ 'value' ] == $value ) ? 'checked="checked"' : ''; ?>/>
                            <img
                                src="<?php echo !empty( $radio[ 'image' ] ) ? esc_url( $radio[ 'image' ] ) : DHT_ASSETS_URI . "images/demo.png"; ?>"
                                alt="<?php echo esc_attr( $radio[ 'label' ] ); ?>"
                                title="<?php echo esc_attr( $radio[ 'label' ] ); ?>" />
                            <label
                                for="<?php echo esc_attr( $radio_id ); ?>"><?php echo esc_html( $radio[ 'label' ] ); ?></label>

                        </div>

                        <?php $cnt++; endforeach; ?>

                <?php endif; ?>

            </div>

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