<?php
if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use function DHT\Helpers\dht_parse_option_attributes;

$option = $args[ 'option' ] ?? [];
?>
    <!-- field - timepicker -->
    <div
        class="dht-field-wrapper <?php echo isset( $option[ 'attr' ][ 'class' ] ) ? esc_attr( $option[ 'attr' ][ 'class' ] ) : ''; ?>" <?php echo dht_parse_option_attributes( $option[ 'attr' ] ); ?>>

        <div class="dht-title"><?php echo esc_html( $option[ 'title' ] ); ?></div>

        <div class="dht-field-child-wrapper dht-field-child-datetimepicker">

            <label
                for="<?php echo esc_attr( $option[ 'id' ] ); ?>"><?php echo esc_html( $option[ 'title' ] ); ?></label>

            <input class="dht-datetimepicker dht-field"
                   id="<?php echo esc_attr( $option[ 'id' ] ); ?>"
                   type="text"
                   name="<?php echo esc_attr( $option[ 'id' ] ); ?>"
                   value="<?php echo esc_html( $option[ 'value' ] ); ?>"
                   data-date-format="<?php echo esc_attr( $option[ 'date-format' ] ); ?>"
                   data-time-format="<?php echo esc_attr( $option[ 'time-format' ] ); ?>" />

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