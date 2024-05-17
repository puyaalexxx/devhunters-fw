<?php
if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use function DHT\Helpers\dht_parse_option_attributes;

$args = $args ?? [];
?>
<!-- field - input -->
<div class="dht-field-wrapper">

    <div class="dht-title"><?php echo esc_html( $args[ 'title' ] ); ?></div>

    <div class="dht-field-child-wrapper dht-field-child-input">

        <label for="<?php echo esc_attr( $args[ 'id' ] ); ?>"><?php echo esc_html( $args[ 'label' ] ); ?></label>

        <input
            class="dht-input dht-field <?php echo isset( $args[ 'attr' ][ 'class' ] ) ? esc_attr( $args[ 'attr' ][ 'class' ] ) : ''; ?>"
            id="<?php echo esc_attr( $args[ 'id' ] ); ?>"
            type="<?php echo !empty( $args[ 'subtype' ] ) ? esc_attr( $args[ 'subtype' ] ) : esc_attr( $args[ 'type' ] ); ?>"
            name="<?php echo esc_attr( $args[ 'id' ] ); ?>"
            value="<?php echo esc_html( $args[ 'value' ] ); ?>"
            <?php echo dht_parse_option_attributes( $args[ 'attr' ] ); ?>/>

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
