<?php
if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use function DHT\Helpers\dht_parse_option_attributes;

$field = $args[ 'field' ] ?? [];
?>
    <!-- field - multioptions -->

    <div
        class="dht-field-wrapper <?php echo isset( $field[ 'attr' ][ 'class' ] ) ? esc_attr( $field[ 'attr' ][ 'class' ] ) : ''; ?>" <?php echo dht_parse_option_attributes( $field[ 'attr' ] ); ?>>

        <div class="dht-title"><?php echo esc_html( $field[ 'title' ] ); ?></div>

        <div class="dht-field-child-wrapper dht-field-child-multioptions">

            <label
                for="<?php echo esc_attr( $field[ 'id' ] ); ?>"><?php echo esc_attr( $field[ 'title' ] ); ?></label>

            <select class="dht-multioptions dht-field"
                    name="<?php echo esc_attr( $field[ 'id' ] ); ?>[]"
                    id="<?php echo esc_attr( $field[ 'id' ] ); ?>"
                    multiple="multiple"

                    data-values="<?php echo !empty( $field[ 'value' ] ) ? implode( ',', $field[ 'value' ] ) : ''; ?>"
                    data-ajax-enabled="<?php echo $field[ 'ajax' ] ? 'yes' : 'no'; ?>"
                    data-input-text="<?php echo _x( 'Type to search...', 'options', DHT_PREFIX ); ?>"
                    data-ajax-action="<?php echo isset( $field[ 'ajax-action' ] ) ? esc_attr( $field[ 'ajax-action' ] ) : ''; ?>"
                    data-minimumInputLength="<?php echo isset( $field[ 'minimumInputLength' ] ) ? esc_attr( (int)$field[ 'minimumInputLength' ] ) : 2; ?>">


                <?php foreach ( $field[ 'choices' ] as $value => $label ): ?>

                    <option value="<?php echo esc_attr( $value ); ?>"><?php echo esc_html( $label ); ?></option>

                <?php endforeach; ?>


            </select>

            <?php if ( !empty( $field[ 'description' ] ) ): ?>
                <div class="dht-description"><?php echo esc_html( $field[ 'description' ] ); ?></div>
            <?php endif; ?>

        </div>

        <?php if ( !empty( $field[ 'tooltip' ] ) ): ?>
            <div class="dht-info-help dashicons dashicons-info"
                 data-tooltips="<?php echo esc_html( $field[ 'tooltip' ] ); ?>"
                 data-position="OnLeft">
            </div>
        <?php endif; ?>

    </div>

<?php if ( isset( $field[ 'divider' ] ) && $field[ 'divider' ] ): ?>
    <div class="dht-divider"></div>
<?php endif; ?>