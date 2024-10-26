<?php
if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

use function DHT\Helpers\dht_fw_live_option_selectors;
use function DHT\Helpers\dht_parse_option_attributes;

$field = $args[ 'field' ] ?? [];

$rows = !empty( $field[ 'row' ] ) ? esc_attr( $field[ 'row' ] ) : 10;

$editor_id = 'my_custom_editor_id_' . esc_attr( $field[ 'id' ] );

$settings = array(
	'editor_id'     => esc_attr( $editor_id ),
	'textarea_name' => esc_attr( $field[ 'name' ] ),
	'textarea_rows' => $rows,
	'quicktags'     => true,
	'tinymce'       => array(
		'toolbar1' => 'formatselect bold italic bullist numlist blockquote alignleft aligncenter alignright link wp_more wp_adv',
		//'toolbar2' => 'strikethrough hr forecolor pastetext removeformat charmap outdent indent undo redo wp_help',
		//'plugins' => 'charmap colorpicker compat3x directionality fullscreen hr image lists media paste tabfocus textcolor wordpress wpautoresize wpdialogs wpeditimage wpemoji wpgallery wplink wptextpattern wpview',
	),
	'mediaButtons'  => true
);
?>
<!-- field - wpeditor - type -> nomedia -->

<?php do_action( 'dht:options:view:fields:wpeditor_before_area' ); ?>

<div
    class="dht-field-wrapper dht-field-wrapper-editor <?php echo isset( $field[ 'attr' ][ 'class' ] ) ? esc_attr( $field[ 'attr' ][ 'class' ] ) : ''; ?>"
	<?php echo dht_parse_option_attributes( $field[ 'attr' ] ?? [] ); ?>
	<?php echo dht_fw_live_option_selectors( $field[ 'live' ] ?? "" ); ?>>

    <div class="dht-title"><?php echo esc_html( $field[ 'title' ] ); ?></div>

    <div class="dht-field-child-wrapper dht-field-child-editor">
		
		<?php wp_editor( $field[ 'value' ], $editor_id, $settings ); ?>
		
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

<?php do_action( 'dht:options:view:fields:wpeditor_after_area' ); ?>
