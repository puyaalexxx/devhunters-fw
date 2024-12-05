<?php
if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

use DHT\Helpers\Classes\OptionsHelpers;
use function DHT\Helpers\dht_parse_option_attributes;

$field = $args[ 'field' ] ?? [];
?>
<!-- field - multioptions -->

<?php do_action( 'dht:options:view:fields:multioptions_before_area' ); ?>

<div
    class="dht-field-wrapper dht-field-wrapper-multioptions <?php echo isset( $field[ 'attr' ][ 'class' ] ) ? esc_attr( $field[ 'attr' ][ 'class' ] ) : ''; ?>"
	<?php echo dht_parse_option_attributes( $field[ 'attr' ] ?? [] ); ?> <?php echo OptionsHelpers::liveOptionSelectors( $field[ 'live' ] ?? [] ); ?>>
	
	<?php if( !empty( $field[ 'title' ] ) ): ?>
        <div class="dht-title"><?php echo esc_html( $field[ 'title' ] ); ?></div>
	<?php endif; ?>

    <div class="dht-field-child-wrapper dht-field-child-multioptions">

        <label for="<?php echo esc_attr( $field[ 'id' ] ); ?>"><?php echo esc_attr( $field[ 'title' ] ); ?></label>

        <select class="dht-multioptions dht-field"
                name="<?php echo esc_attr( $field[ 'id' ] ); ?>[]"
                id="<?php echo esc_attr( $field[ 'id' ] ); ?>"
                multiple="multiple"

                data-values="<?php echo !empty( $field[ 'value' ] ) ? implode( ',', $field[ 'value' ] ) : ''; ?>"
                data-ajax-enabled="<?php echo $field[ 'ajax' ] ? 'yes' : 'no'; ?>"
                data-input-text="<?php echo _x( 'Type to search...', 'options', DHT_PREFIX ); ?>"
                data-ajax-action="<?php echo isset( $field[ 'ajax-action' ] ) ? esc_attr( $field[ 'ajax-action' ] ) : ''; ?>"
                data-minimumInputLength="<?php echo isset( $field[ 'minimumInputLength' ] ) ? esc_attr( (int) $field[ 'minimumInputLength' ] ) : 2; ?>">
			
			
			<?php foreach ( $field[ 'choices' ] as $value => $label ): ?>

                <option value="<?php echo esc_attr( $value ); ?>"><?php echo esc_html( $label ); ?></option>
			
			<?php endforeach; ?>


        </select>
		
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

<?php do_action( 'dht:options:view:fields:multioptions_after_area' ); ?>
