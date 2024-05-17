<?php
if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use function DHT\Helpers\dht_parse_option_attributes;

$args = $args ?? [];
?>
<!-- field - checkbox -->
<div class="dht-field-wrapper">

    <div class="dht-title"><?php echo esc_html( $args[ 'title' ] ); ?></div>

    <div
        class="dht-field-child-wrapper dht-field-child-radio <?php echo isset( $args[ 'attr' ][ 'class' ] ) ? esc_attr( $args[ 'attr' ][ 'class' ] ) : ''; ?>"
        <?php echo dht_parse_option_attributes( $args[ 'attr' ] ); ?>>

        <?php if ( !empty( $args[ 'choices' ] ) ): ?>

            <?php $cnt = 0;
            foreach ( $args[ 'choices' ] as $value => $label ): ?>

                <?php $radio_id = esc_attr( $args[ 'id' ] ) . '-' . $cnt; ?>
                <div class="dht-radio-wrapper">

                    <input
                        class="dht-radio dht-field"
                        type="radio"
                        name="<?php echo esc_attr( $args[ 'id' ] ); ?>"
                        id="<?php echo $radio_id; ?>"
                        value="<?php echo esc_attr( $value ); ?>"
                        <?php echo ( $args[ 'value' ] == $value ) ? 'checked="checked"' : ''; ?>/>

                    <label
                        for="<?php echo $radio_id; ?>"><?php echo esc_html( $label ); ?></label>

                </div>
                <?php $cnt++; endforeach; ?>

        <?php endif; ?>

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
