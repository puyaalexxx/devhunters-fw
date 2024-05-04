<?php
if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use function DHT\Helpers\dht_parse_option_attributes;
?>
    <!-- field - textarea -->
    <div class="dht-field-wrapper">

        <div class="dht-title"><?php echo esc_html( $args[ 'title' ] ); ?></div>

        <div class="dht-field-child-wrapper dht-field-child-textarea">

            <label for="<?php echo esc_attr( $args[ 'id' ] ); ?>"><?php echo esc_html( $args[ 'label' ] ); ?></label>

            <textarea class="dht-textarea dht-field <?php echo isset( $args[ 'attr' ][ 'class' ] ) ? esc_attr( $args[ 'attr' ][ 'class' ] ) : ''; ?>"
                      id="<?php echo esc_attr( $args[ 'id' ] ); ?>"
                      name="<?php echo esc_attr( $args[ 'id' ] ); ?>"
                      placeholder="<?php echo esc_attr( $args[ 'default' ] ); ?>"
                      rows="<?php echo !empty( $args[ 'row' ] ) ? esc_attr( $args[ 'row' ] ) : 6; ?>"
                      <?php echo dht_parse_option_attributes( $args[ 'attr' ] ); ?>
            ><?php echo esc_html( $args[ 'value' ] ); ?></textarea>

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