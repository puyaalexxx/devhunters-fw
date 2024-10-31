<?php
if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

use function DHT\Helpers\dht_fw_live_option_selectors;
use function DHT\Helpers\dht_fw_render_group;
use function DHT\Helpers\dht_parse_option_attributes;

$group = $args[ 'group' ] ?? [];

//see if the tabs should be fullwidth
$fullwidth_panel = $group[ 'fullwidth' ] ?? false;

//used to call the render method on
$registered_options_classes = $args[ 'registered_options_classes' ] ?? [];
?>
<!-- field - panel -->

<?php do_action( 'dht:options:view:groups:panel_before_area' ); ?>

<div
    class="dht-field-wrapper dht-field-wrapper-panel dht-group-type <?php echo $fullwidth_panel ? 'dht-field-panel-fullwidth' : ''; ?>
    <?php echo isset( $group[ 'attr' ][ 'class' ] ) ? esc_attr( $group[ 'attr' ][ 'class' ] ) : ''; ?>"
	<?php echo dht_parse_option_attributes( $group[ 'attr' ] ); ?> <?php echo dht_fw_live_option_selectors( $group[ 'live' ] ?? [] ); ?>>
	
	<?php if( !$fullwidth_panel && !empty( $group[ 'title' ] ) ): ?>
        <div class="dht-title"><?php echo esc_html( $group[ 'title' ] ); ?></div>
	<?php endif; ?>

    <div class="dht-field-child-wrapper dht-field-child-panel">

        <div class="dht-panel">
			
			<?php if( !empty( $group[ 'options' ] ) ): ?>
				
				<?php $cnt = 0;
				foreach ( $group[ 'options' ] as $group_panel ) : $cnt ++; ?>

                    <div class="dht-panel-item">

                        <div class="dht-panel-title">

                            <div class="dht-panel-arrow">
                                <span class="dht-panel-arrow-item dashicons dashicons-plus-alt"></span>
                                <span class="dht-panel-arrow-item-close dashicons dashicons-dismiss"></span>
                            </div>

                            <span class="dht-panel-title-text">
                                <?php echo !empty( $group_panel[ 'panel_title' ] ) ? esc_html( $group_panel[ 'panel_title' ] ) : _x( 'Panel', 'options', DHT_PREFIX ); ?>
                            </span>

                        </div>

                        <div class="dht-panel-content">
							
							<?php if( !empty( $group_panel[ 'options' ] ) ): ?>
								
								<?php foreach ( $group_panel[ 'options' ] as $panel_option ) : ?>
									
									<?php
									//get saved value
									$saved_value = $group[ 'value' ][ $panel_option[ 'id' ] ] ?? [];
									
									echo dht_fw_render_group( $group[ 'id' ], $panel_option, $saved_value, $registered_options_classes );
									?>
								
								<?php endforeach; ?>
							
							<?php endif; ?>

                        </div>

                    </div>
				
				<?php endforeach; ?>
			
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

<?php do_action( 'dht:options:view:groups:panel_after_area' ); ?>
