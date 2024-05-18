<?php
if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use function DHT\Helpers\dht_parse_option_attributes;

$args = $args ?? [];
?>
    <!-- field - multiinput -->

    <div class="dht-field-wrapper">

        <div class="dht-title"><?php echo esc_html( $args[ 'title' ] ); ?></div>

        <div
            class="dht-field-child-wrapper dht-field-child-multiinput <?php echo isset( $args[ 'attr' ][ 'class' ] ) ? esc_attr( $args[ 'attr' ][ 'class' ] ) : ''; ?>"
            <?php echo dht_parse_option_attributes( $args[ 'attr' ] ); ?>>

            <label for="<?php echo esc_attr( $args[ 'id' ] ); ?>"><?php echo esc_html( $args[ 'label' ] ); ?></label>

            <?php foreach ( $args[ 'value' ] as $value ): ?>

                <div class="dht-multiinput-child-wrapper">

                    <input class="dht-multi-input dht-field"
                           id="<?php echo esc_attr( $args[ 'id' ] ); ?>"
                           type="text"
                           name="<?php echo esc_attr( $args[ 'id' ] ); ?>[]"
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
               data-limit="<?php echo (int)esc_attr( $args[ 'limit' ] ); ?>"
               data-add-text="<?php echo sprintf( _x( 'You can\'t add more than %d inputs ', 'options', DHT_PREFIX ), (int)esc_attr( $args[ 'limit' ] ) ); ?>"
            >
                <?php echo _x( 'Add More', 'options', DHT_PREFIX ) ?>
            </a>

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