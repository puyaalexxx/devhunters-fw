<?php
if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use function DHT\Helpers\dht_parse_option_attributes;

$option = $args[ 'option' ] ?? [];
?>
    <!-- field - multioptions -->

    <div class="dht-field-wrapper">

        <div class="dht-title"><?php echo esc_html( $option[ 'title' ] ); ?></div>

        <div
            class="dht-field-child-wrapper dht-field-child-multioptions <?php echo isset( $option[ 'attr' ][ 'class' ] ) ? esc_attr( $option[ 'attr' ][ 'class' ] ) : ''; ?>"
            <?php echo dht_parse_option_attributes( $option[ 'attr' ] ); ?>>

            <label
                for="<?php echo esc_attr( $option[ 'id' ] ); ?>"><?php echo esc_attr( $option[ 'label' ] ); ?></label>

            <select class="dht-multioptions dht-field"
                    name="<?php echo esc_attr( $option[ 'id' ] ); ?>[]"
                    id="<?php echo esc_attr( $option[ 'id' ] ); ?>"
                    multiple="multiple"

                    data-values="<?php echo !empty( $option[ 'value' ] ) ? implode( ',', $option[ 'value' ] ) : ''; ?>"
                    data-ajax-enabled="<?php echo $option[ 'ajax' ] ? 'yes' : 'no'; ?>"
                    data-input-text="<?php echo _x( 'Type to search...', 'options', DHT_PREFIX ); ?>"
                    data-ajax-action="<?php echo isset( $option[ 'ajax-action' ] ) ? esc_attr( $option[ 'ajax-action' ] ) : ''; ?>"
                    data-minimumInputLength="<?php echo isset( $option[ 'minimumInputLength' ] ) ? esc_attr( (int)$option[ 'minimumInputLength' ] ) : 2; ?>">


                <?php foreach ( $option[ 'choices' ] as $value => $label ): ?>

                    <option value="<?php echo esc_attr( $value ); ?>"><?php echo esc_html( $label ); ?></option>

                <?php endforeach; ?>


            </select>

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