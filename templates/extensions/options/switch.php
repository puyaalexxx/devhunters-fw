<?php
if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

$args = $args ?? [];

$on_off_class = in_array( $args[ 'value' ], $args[ 'left-choice' ] ) ? 'dht-slider-on' : 'dht-slider-off';
?>
<!-- field - switch  -->
<div class="dht-field-wrapper">
    <div class="dht-title"><?php echo esc_html( $args[ 'title' ] ); ?></div>
    <div class="dht-field-child-wrapper dht-field-child-switch">

        <label class="dht-switch <?php echo esc_attr( $on_off_class ); ?>"
               for="<?php echo esc_attr( $args[ 'id' ] ); ?>">

            <input type="hidden" name="<?php echo esc_attr( $args[ 'id' ] ); ?>"
                   value="<?php echo esc_attr( $args[ 'value' ] ); ?>" />

            <span class="dht-slider">
                <span class="dht-slider-yes"
                      data-value="<?php echo esc_attr( $args[ 'left-choice' ][ 'value' ] ); ?>"><?php echo esc_attr( $args[ 'left-choice' ][ 'label' ] ); ?></span>
                <span class="dht-slider-no"
                      data-value="<?php echo esc_attr( $args[ 'right-choice' ][ 'value' ] ); ?>"><?php echo esc_attr( $args[ 'right-choice' ][ 'label' ] ); ?></span>
            </span>

        </label>

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