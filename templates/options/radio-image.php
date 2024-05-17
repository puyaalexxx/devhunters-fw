<?php
if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use function DHT\Helpers\dht_parse_option_attributes;

$args = $args ?? [];
?>
    <!-- field - radio image -->
    <div class="dht-field-wrapper">

        <div class="dht-title"><?php echo esc_html( $args[ 'title' ] ); ?></div>

        <div
            class="dht-field-child-wrapper dht-field-child-image-select <?php echo isset( $args[ 'attr' ][ 'class' ] ) ? esc_attr( $args[ 'attr' ][ 'class' ] ) : ''; ?>"
            <?php echo dht_parse_option_attributes( $args[ 'attr' ] ); ?>>

            <div class="dht-field-child-image-select-container">

                <?php if ( !empty( $args[ 'choices' ] ) ): ?>

                    <?php $cnt = 0;
                    foreach ( $args[ 'choices' ] as $value => $radio ): ?>

                        <?php $radio_id = esc_attr( $args[ 'id' ] ) . '-' . $cnt; ?>

                        <div
                            class="dht-img-select-wrapper <?php echo ( $args[ 'value' ] == $value ) ? 'dht-img-select-wrapper-selected' : ''; ?>">
                            <input class="dht-image-select dht-field"
                                   type="radio"
                                   name="<?php echo esc_attr( $radio_id ); ?>[img]"
                                   id="<?php echo esc_attr( $radio_id ); ?>"
                                   value="<?php echo esc_attr( $value ); ?>"
                                <?php echo ( $args[ 'value' ] == $value ) ? 'checked="checked"' : ''; ?>/>
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