<?php
if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use function DHT\Helpers\dht_parse_option_attributes;

$option = $args[ 'option' ] ?? [];
?>
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.12/ace.js" type="text/javascript" charset="utf-8"></script>-->

    <!-- field - aceeditor - type -> css / js -->
    <div
        class="dht-field-wrapper <?php echo isset( $option[ 'attr' ][ 'class' ] ) ? esc_attr( $option[ 'attr' ][ 'class' ] ) : ''; ?>" <?php echo dht_parse_option_attributes( $option[ 'attr' ] ); ?>>

        <div class="dht-title"><?php echo esc_html( $option[ 'title' ] ); ?></div>

        <div
            class="dht-field-child-wrapper dht-field-child-code-editor">

            <label
                for="<?php echo esc_attr( $option[ 'id' ] ); ?>"><?php echo esc_html( $option[ 'title' ] ); ?></label>

            <textarea class="dht-ace-editor dht-field" id="<?php echo esc_attr( $option[ 'id' ] ); ?>"
                      name="<?php echo esc_attr( $option[ 'id' ] ); ?>"
                      style="display:none;"><?php echo esc_html( $option[ 'value' ] ); ?></textarea>

            <div class="dht-ace-editor-area" id="dht-<?php echo esc_attr( $option[ 'id' ] ); ?>"
                 style="height: <?php echo !empty( $option[ 'height' ] ) ? esc_attr( $option[ 'height' ] ) : 300; ?>px;"
                 data-editor-mode="<?php echo esc_attr( $option[ 'mode' ] ); ?>">
            </div>

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