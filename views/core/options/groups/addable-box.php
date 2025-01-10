<?php

use DHT\Helpers\Classes\OptionsHelpers;
use function DHT\Helpers\dht_parse_option_attributes;

if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

$group = $args[ 'group' ] ?? [];
//used to call the render method on
$registered_options_classes = $args[ 'registered_options_classes' ] ?? [];
//get saved values
$saved_values = !empty( $group[ 'value' ] ) ? $group[ 'value' ] : [];
?>
<!-- field - addable box -->

<?php do_action( 'dht:options:view:groups:addable_box_before_area' ); ?>

<div
    class="dht-field-wrapper dht-field-wrapper-addable-box dht-group-type <?php echo $group[ 'sortable' ] ? 'dht-field-wrappers-sortable' : ''; ?>
    <?php echo isset( $group[ 'attr' ][ 'class' ] ) ? esc_attr( $group[ 'attr' ][ 'class' ] ) : ''; ?>"
	<?php echo dht_parse_option_attributes( $group[ 'attr' ] ); ?> <?php echo OptionsHelpers::liveOptionSelectors( $group[ 'live' ] ?? [] ); ?>>
	
	<?php if( !empty( $group[ 'title' ] ) ): ?>
        <div class="dht-title"><?php echo esc_html( $group[ 'title' ] ); ?></div>
	<?php endif; ?>

    <div
        class="dht-field-child-wrapper dht-field-child-addable-box <?php echo $group[ 'sortable' ] ? 'dht-field-child-addable-box-sortable' : ''; ?>">

        <div class="dht-addable-box dht-addable-box-repeater">
			
			<?php if( !empty( $group[ 'options' ] ) ): ?>

                <input type="hidden" class="dht-box-item-options"
                       value='<?php echo json_encode( [
					       'id'        => $group[ 'id' ],
					       'box-title' => $group[ 'box-title' ],
					       'options'   => $group[ 'options' ]
				       ], JSON_UNESCAPED_UNICODE ) ?>' />

                <div class="dht-addable-box-items"
                     data-max-box-items="<?php echo esc_attr( $group[ 'limit' ] ); ?>">
					
					<?php if( !empty( $saved_values ) ): ?>
						
						<?php $count = 0; ?>
						<?php foreach ( $saved_values as $key => $saved_value ): ?>
							
							<?php if( $count == (int) $group[ 'limit' ] ) {
								break;
							} ?>
							
							<?php echo OptionsHelpers::displayBoxItem( $group, $saved_value, $registered_options_classes, $key ); ?>
							
							<?php $count ++; ?>
						<?php endforeach; ?>
					
					<?php else: ?>
						
						<?php echo OptionsHelpers::displayBoxItem( $group, [], $registered_options_classes, 1 ); ?>
					
					<?php endif; ?>

                </div>

                <a href=""
                   class="button button-primary dht-add-box-item"><?php echo _x( 'Add', 'options', 'dht' ); ?></a>
                <span class="spinner"></span>
                <div
                    class="dht-box-remove-text"><?php echo _x( 'Can\'t remove the only item', 'options', 'dht' ); ?></div>
                <div
                    class="dht-max-box-items"><?php echo sprintf( _x( 'Can\'t add more than %d items', 'options', 'dht' ), (int) $group[ 'limit' ] ); ?></div>
			
			<?php endif; ?>
        </div>
		
		<?php if( !empty( $group[ 'description' ] ) ): ?>
            <div class="dht-description"><?php echo esc_html( $group[ 'description' ] ); ?></div>
		<?php endif; ?>

    </div>
	
	<?php if( !empty( $group[ 'tooltip' ] ) ): ?>
        <div class="dht-info-help dashicons dashicons-info">
            <div class="dht-tooltips"><p class="OnLeft"><?php echo esc_html( $group[ 'tooltip' ] ); ?></p></div>
        </div>
	<?php endif; ?>

</div>

<?php if( isset( $group[ 'divider' ] ) && $group[ 'divider' ] ): ?>
    <div class="dht-divider"></div>
<?php endif; ?>

<?php do_action( 'dht:options:view:groups:addable_box_after_area' ); ?>
