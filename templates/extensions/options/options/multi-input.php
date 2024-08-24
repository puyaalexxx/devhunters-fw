<?php
if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use function DHT\Helpers\dht_parse_option_attributes;

$option = $args[ 'option' ] ?? [];
?>
    <!-- field - multiinput -->

    <div
        class="dht-field-wrapper <?php echo isset( $option[ 'attr' ][ 'class' ] ) ? esc_attr( $option[ 'attr' ][ 'class' ] ) : ''; ?>" <?php echo dht_parse_option_attributes( $option[ 'attr' ] ); ?>>

        <div class="dht-title"><?php echo esc_html( $option[ 'title' ] ); ?></div>

        <div class="dht-field-child-wrapper dht-field-child-multiinput">

            <label
                for="<?php echo esc_attr( $option[ 'id' ] ); ?>"><?php echo esc_html( $option[ 'title' ] ); ?></label>

            <?php foreach ( $option[ 'value' ] as $value ): ?>

                <div class="dht-multiinput-child-wrapper">

                    <input class="dht-multi-input dht-field"
                           id="<?php echo esc_attr( $option[ 'id' ] ); ?>"
                           type="text"
                           name="<?php echo esc_attr( $option[ 'id' ] ); ?>[]"
                           value="<?php echo esc_html( $value ); ?>" />

                    <!--remove input button-->
                    <a href="javascript:void(0);"
                       class="dht-multiinput-remove"
                       data-remove-text="<?php echo _x( 'Can\'t remove the only field', 'options', DHT_PREFIX ) ?>">
                        <?php echo _x( 'Remove', 'options', DHT_PREFIX ) ?>
                    </a>

                </div>

            <?php endforeach; ?>

            <!--add button-->
            <a href="javascript:void(0);"
               class="dht-button dht-btn-small dht-multiinput-add"
               data-limit="<?php echo (int)esc_attr( $option[ 'limit' ] ); ?>"
               data-add-text="<?php echo sprintf( _x( 'You can\'t add more than %d inputs ', 'options', DHT_PREFIX ), (int)esc_attr( $option[ 'limit' ] ) ); ?>"
            >
                <?php echo _x( 'Add More', 'options', DHT_PREFIX ) ?>
            </a>

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