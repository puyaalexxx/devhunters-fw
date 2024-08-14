<?php
if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use function DHT\Helpers\dht_parse_option_attributes;

$option = $args[ 'option' ] ?? [];
?>
<!-- field - checkbox -->
<div class="dht-field-wrapper">

    <div class="dht-title"><?php echo esc_html( $option[ 'title' ] ); ?></div>

    <div
        class="dht-field-child-wrapper dht-field-child-radio <?php echo isset( $option[ 'attr' ][ 'class' ] ) ? esc_attr( $option[ 'attr' ][ 'class' ] ) : ''; ?>"
        <?php echo dht_parse_option_attributes( $option[ 'attr' ] ); ?>>

        <?php if ( !empty( $option[ 'choices' ] ) ): ?>

            <?php $cnt = 0;
            foreach ( $option[ 'choices' ] as $value => $label ): ?>

                <?php $radio_id = esc_attr( $option[ 'id' ] ) . '-' . $cnt; ?>
                <div class="dht-radio-wrapper">

                    <input
                        class="dht-radio dht-field"
                        type="radio"
                        name="<?php echo esc_attr( $option[ 'id' ] ); ?>"
                        id="<?php echo $option[ 'id' ] . $radio_id; ?>"
                        value="<?php echo esc_attr( $value ); ?>"
                        <?php echo ( $option[ 'value' ] == $value ) ? 'checked="checked"' : ''; ?>/>

                    <label
                        for="<?php echo $option[ 'id' ] . $radio_id; ?>"><?php echo esc_html( $label ); ?></label>

                </div>
                <?php $cnt++; endforeach; ?>

        <?php endif; ?>

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
