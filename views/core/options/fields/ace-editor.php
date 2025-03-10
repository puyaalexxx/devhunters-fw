<?php
if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

use DHT\Helpers\Classes\OptionsHelpers;
use function DHT\Helpers\dht_parse_option_attributes;

$field = $args[ 'field' ] ?? [];
?>
<!-- field - aceeditor - type -> css / js -->

<?php do_action( 'dht:options:view:fields:ace_editor_before_area' ); ?>

<div
    class="dht-field-wrapper dht-field-wrapper-code-editor <?php echo isset( $field[ 'attr' ][ 'class' ] ) ? esc_attr( $field[ 'attr' ][ 'class' ] ) : ''; ?>"
	<?php echo dht_parse_option_attributes( $field[ 'attr' ] ?? [] ); ?> <?php echo OptionsHelpers::liveOptionSelectors( $field[ 'live' ] ?? [] ); ?>>
	
	<?php if( !empty( $field[ 'title' ] ) ): ?>
        <div class="dht-title"><?php echo esc_html( $field[ 'title' ] ); ?></div>
	<?php endif; ?>

    <div class="dht-field-child-wrapper dht-field-child-code-editor">

        <label for="<?php echo esc_attr( $field[ 'id' ] ); ?>"><?php echo esc_html( $field[ 'title' ] ); ?></label>

        <textarea class="dht-ace-editor dht-field" id="<?php echo esc_attr( $field[ 'id' ] ); ?>"
                  name="<?php echo esc_attr( $field[ 'id' ] ); ?>"
                  style="display:none;"><?php echo esc_html( $field[ 'value' ] ); ?></textarea>

        <div class="dht-ace-editor-area" id="dht-<?php echo esc_attr( $field[ 'id' ] ); ?>"
             style="height: <?php echo !empty( $field[ 'height' ] ) ? esc_attr( $field[ 'height' ] ) : 300; ?>px;"
             data-editor-mode="<?php echo esc_attr( $field[ 'mode' ] ); ?>">
        </div>
		
		<?php if( !empty( $field[ 'description' ] ) ): ?>
            <div class="dht-description"><?php echo esc_html( $field[ 'description' ] ); ?></div>
		<?php endif; ?>

    </div>
	
	<?php if( !empty( $field[ 'tooltip' ] ) ): ?>
        <div class="dht-info-help dashicons dashicons-info">
            <div class="dht-tooltips"><p class="OnLeft"><?php echo esc_html( $field[ 'tooltip' ] ); ?></p></div>
        </div>
	<?php endif; ?>

</div>

<?php if( isset( $field[ 'divider' ] ) && $field[ 'divider' ] ): ?>
    <div class="dht-divider"></div>
<?php endif; ?>

<?php do_action( 'dht:options:view:fields:ace_editor_after_area' ); ?>
