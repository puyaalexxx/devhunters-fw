<?php
if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use function DHT\Helpers\dht_parse_option_attributes;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

$option = $args[ 'option' ] ?? [];
?>
<!-- field - checkbox -->
<div class="dht-field-wrapper">

    <div class="dht-title"><?php echo esc_html( $option[ 'title' ] ); ?></div>

    <div
        class="dht-field-child-wrapper dht-field-child-checkbox <?php echo isset( $option[ 'attr' ][ 'class' ] ) ? esc_attr( $option[ 'attr' ][ 'class' ] ) : ''; ?>"
        <?php echo dht_parse_option_attributes( $option[ 'attr' ] ); ?>>

        <?php if ( !empty( $option[ 'choices' ] ) ): ?>

            <?php foreach ( $option[ 'choices' ] as $key => $checkbox ): ?>

                <div class="dht-checkbox-wrapper">

                    <input
                        class="dht-checkbox dht-field"
                        type="checkbox"
                        name="<?php echo esc_attr( $option[ 'id' ] ); ?>[<?php echo esc_attr( $checkbox[ 'id' ] ); ?>]"
                        id="<?php echo esc_attr( $option[ 'id' ] . $checkbox[ 'id' ] ); ?>"
                        value="<?php echo esc_attr( esc_attr( $checkbox[ 'value' ] ) ); ?>"
                        <?php echo in_array( $checkbox[ 'id' ], $option[ 'value' ] ) ? 'checked="checked"' : ''; ?>/>

                    <label
                        for="<?php echo esc_attr( $option[ 'id' ] . $checkbox[ 'id' ] ); ?>"><?php echo esc_html( $checkbox[ 'label' ] ); ?></label>

                </div>
            <?php endforeach; ?>

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
