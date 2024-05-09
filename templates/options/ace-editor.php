<?php
if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use function DHT\Helpers\dht_parse_option_attributes;

$args = $args ?? [];
?>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.12/ace.js" type="text/javascript" charset="utf-8"></script>-->

<!-- field - aceeditor - type -> css / js -->
<div class="dht-field-wrapper">

    <div class="dht-title"><?php echo esc_html( $args[ 'title' ] ); ?></div>

    <div class="dht-field-child-wrapper dht-field-child-code-editor <?php echo isset( $args[ 'attr' ][ 'class' ] ) ? esc_attr( $args[ 'attr' ][ 'class' ] ) : ''; ?>"
        <?php echo dht_parse_option_attributes( $args[ 'attr' ] ); ?>>

        <label for="<?php echo esc_attr( $args[ 'id' ] ); ?>"><?php echo esc_html( $args[ 'label' ] ); ?></label>

        <textarea class="dht-ace-editor dht-field" id="<?php echo esc_attr( $args[ 'id' ] ); ?>" name="<?php echo esc_attr( $args[ 'id' ] ); ?>" style="display:none;"><?php echo esc_html( $args[ 'value' ] ); ?></textarea>

        <div class="dht-ace-editor-area" id="dht-<?php echo esc_attr( $args[ 'id' ] ); ?>"
             style="height: <?php echo !empty( $args[ 'height' ] ) ? esc_attr( $args[ 'height' ] ) : 300; ?>px;"
             data-editor-mode="<?php echo esc_attr( $args[ 'mode' ] ); ?>"
        >
        </div>
        
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