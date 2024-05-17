<?php
if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use function DHT\Helpers\dht_parse_option_attributes;

$args = $args ?? [];
?>
    <!-- field - multioptions -->

    <div class="dht-field-wrapper">

        <div class="dht-title"><?php echo esc_html( $args[ 'title' ] ); ?></div>

        <div
            class="dht-field-child-wrapper dht-field-child-multioptions <?php echo isset( $args[ 'attr' ][ 'class' ] ) ? esc_attr( $args[ 'attr' ][ 'class' ] ) : ''; ?>"
            <?php echo dht_parse_option_attributes( $args[ 'attr' ] ); ?>>

            <label for="<?php echo esc_attr( $args[ 'id' ] ); ?>"><?php echo esc_attr( $args[ 'label' ] ); ?></label>

            <select class="dht-multioptions dht-field"
                    name="<?php echo esc_attr( $args[ 'id' ] ); ?>[]"
                    id="<?php echo esc_attr( $args[ 'id' ] ); ?>"
                    multiple="multiple"

                    data-values="<?php echo !empty( $args[ 'value' ] ) ? implode( ',', $args[ 'value' ] ) : ''; ?>"
                    data-ajax-enabled="<?php echo $args[ 'ajax' ] ? 'yes' : 'no'; ?>"
                    data-input-text="<?php echo _x( 'Type to search...', 'options', DHT_PREFIX ); ?>"
                    data-ajax-action="<?php echo isset( $args[ 'ajax-action' ] ) ? esc_attr( $args[ 'ajax-action' ] ) : ''; ?>"
                    data-minimumInputLength="<?php echo isset( $args[ 'minimumInputLength' ] ) ? esc_attr( (int)$args[ 'minimumInputLength' ] ) : 2; ?>">


                <?php foreach ( $args[ 'choices' ] as $value => $label ): ?>

                    <option value="<?php echo esc_attr( $value ); ?>"><?php echo esc_html( $label ); ?></option>

                <?php endforeach; ?>


            </select>

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