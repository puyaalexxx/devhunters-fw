<?php
if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use function DHT\Helpers\dht_parse_option_attributes;

$args = $args ?? [];

?>
<!-- field - dropdown-multiple -->
<div class="dht-field-wrapper">

    <div class="dht-title"><?php echo esc_html( $args[ 'title' ] ); ?></div>

    <div
        class="dht-field-child-wrapper dht-field-child-dropdown <?php echo isset( $args[ 'attr' ][ 'class' ] ) ? esc_attr( $args[ 'attr' ][ 'class' ] ) : ''; ?>"
        <?php echo dht_parse_option_attributes( $args[ 'attr' ] ); ?>>

        <?php if ( !empty( $args[ 'choices' ] ) ): ?>

            <label for="<?php echo esc_attr( $args[ 'id' ] ); ?>"><?php echo esc_attr( $args[ 'label' ] ); ?></label>

            <select class="dht-dropdown dht-field" name="<?php echo esc_attr( $args[ 'id' ] ); ?>[]"
                    id="<?php echo esc_attr( $args[ 'id' ] ); ?>" multiple
                    size="<?php echo esc_attr( (int)$args[ 'size' ] ); ?>">

                <?php foreach ( $args[ 'choices' ] as $key => $val ): ?>

                    <!--optgroup-->
                    <?php if ( is_array( $val ) ): ?>

                        <?php foreach ( $val as $group ): ?>

                            <optgroup label="<?php echo esc_attr( $group[ 'label' ] ); ?>">

                                <?php foreach ( $group[ 'choices' ] as $group_value => $group_label ): ?>
                                    <option
                                        value="<?php echo esc_attr( $group_value ); ?>" <?php echo ( in_array( $group_value, $args[ 'value' ] ) ) ? 'selected' : ''; ?>
                                    >
                                        <?php echo esc_html( $group_label ); ?>
                                    </option>
                                <?php endforeach; ?>

                            </optgroup>

                        <?php endforeach; ?>

                        <!--simple option-->
                    <?php else: ?>

                        <option
                            value="<?php echo esc_attr( $key ); ?>" <?php echo ( in_array( $key, $args[ 'value' ] ) ) ? 'selected' : ''; ?>
                        >
                            <?php echo esc_html( $val ); ?>
                        </option>

                    <?php endif; ?>

                <?php endforeach; ?>

            </select>

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
