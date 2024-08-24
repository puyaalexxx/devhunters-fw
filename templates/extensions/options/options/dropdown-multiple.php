<?php
if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use function DHT\Helpers\dht_parse_option_attributes;

$option = $args[ 'option' ] ?? [];
?>
<!-- field - dropdown-multiple -->
<div
    class="dht-field-wrapper <?php echo isset( $option[ 'attr' ][ 'class' ] ) ? esc_attr( $option[ 'attr' ][ 'class' ] ) : ''; ?>" <?php echo dht_parse_option_attributes( $option[ 'attr' ] ); ?>>

    <div class="dht-title"><?php echo esc_html( $option[ 'title' ] ); ?></div>

    <div class="dht-field-child-wrapper dht-field-child-dropdown">

        <?php if ( !empty( $option[ 'choices' ] ) ): ?>

            <label
                for="<?php echo esc_attr( $option[ 'id' ] ); ?>"><?php echo esc_attr( $option[ 'title' ] ); ?></label>

            <select class="dht-dropdown dht-field" name="<?php echo esc_attr( $option[ 'id' ] ); ?>[]"
                    id="<?php echo esc_attr( $option[ 'id' ] ); ?>" multiple
                    size="<?php echo esc_attr( (int)$option[ 'size' ] ); ?>">

                <?php foreach ( $option[ 'choices' ] as $key => $val ): ?>

                    <!--optgroup-->
                    <?php if ( is_array( $val ) ): ?>

                        <?php foreach ( $val as $group ): ?>

                            <optgroup label="<?php echo esc_attr( $group[ 'label' ] ); ?>">

                                <?php foreach ( $group[ 'choices' ] as $group_value => $group_label ): ?>
                                    <option
                                        value="<?php echo esc_attr( $group_value ); ?>" <?php echo ( in_array( $group_value, $option[ 'value' ] ) ) ? 'selected' : ''; ?>>
                                        <?php echo esc_html( $group_label ); ?>
                                    </option>
                                <?php endforeach; ?>

                            </optgroup>

                        <?php endforeach; ?>

                        <!--simple option-->
                    <?php else: ?>

                        <option
                            value="<?php echo esc_attr( $key ); ?>" <?php echo ( in_array( $key, $option[ 'value' ] ) ) ? 'selected' : ''; ?>>
                            <?php echo esc_html( $val ); ?>
                        </option>

                    <?php endif; ?>

                <?php endforeach; ?>

            </select>

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
