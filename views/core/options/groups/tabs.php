<?php

if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

use DHT\Helpers\Classes\OptionsHelpers;
use function DHT\Helpers\dht_parse_option_attributes;

$group = $args[ 'group' ] ?? [];
//used to call the render method on
$registered_options_classes = $args[ 'registered_options_classes' ] ?? [];

//see if the tabs should be fullwidth
$fullwidth_tabs = $group[ 'fullwidth' ] ?? false;

//create unique tabs id
$tabs_id = str_replace( [
		'[',
		']'
	], '-', $group[ 'id' ] ) . 'tab';
?>
<!-- field - tabs -->

<?php do_action( 'dht:options:view:groups:tabs_before_area' ); ?>

<div
    class="dht-field-wrapper dht-field-wrapper-tabs dht-group-type <?php echo $fullwidth_tabs ? 'dht-field-tabs-fullwidth' : ''; ?> <?php echo isset( $group[ 'attr' ][ 'class' ] ) ? esc_attr( $group[ 'attr' ][ 'class' ] ) : ''; ?>"
	<?php echo dht_parse_option_attributes( $group[ 'attr' ] ); ?> <?php echo OptionsHelpers::liveOptionSelectors( $group[ 'live' ] ?? [] ); ?>>
	
	<?php if( !$fullwidth_tabs && !empty( $group[ 'title' ] ) ): ?>
        <div class="dht-title"><?php echo esc_html( $group[ 'title' ] ); ?></div>
	<?php endif; ?>

    <div class="dht-field-child-wrapper dht-field-child-tabs">

        <div class="dht-field-tabs">
			
			<?php if( !empty( $group[ 'options' ] ) ): ?>

                <ul class="dht-tab-links">
					
					<?php $cnt = 0;
					foreach ( $group[ 'options' ] as $group_tabs ) : $cnt ++; ?>

                        <li class="<?php echo $cnt == 1 ? 'active' : '' ?>">
                            <a href="#<?php echo esc_attr( $tabs_id ); ?>-<?php echo esc_attr( $cnt ); ?>">
								<?php echo !empty( $group_tabs[ 'title' ] ) ? esc_html( $group_tabs[ 'title' ] ) : sprintf( _x( 'Tab %d', 'options', 'dht' ), $cnt ); ?>
                            </a>
                        </li>
					
					<?php endforeach; ?>

                </ul>
				
				<?php $count = 0;
				foreach ( $group[ 'options' ] as $group_tabs_content ) : $count ++; ?>

                    <div class="dht-tab-content <?php echo $count == 1 ? 'active' : '' ?>"
                         id="<?php echo esc_attr( $tabs_id ); ?>-<?php echo esc_attr( $count ); ?>">
						
						<?php if( !empty( $group_tabs_content[ 'options' ] ) ): ?>
							
							<?php foreach ( $group_tabs_content[ 'options' ] as $tab_option ) : ?>
								
								<?php
								//get saved value
								$saved_value = $group[ 'value' ][ $tab_option[ 'id' ] ] ?? [];
								
								echo OptionsHelpers::renderGroup( $group[ 'id' ], $tab_option, $saved_value, $registered_options_classes );
								?>
							
							<?php endforeach; ?>
						
						<?php endif; ?>

                    </div>
				
				<?php endforeach; ?>
			
			<?php endif; ?>

        </div>
		
		<?php if( !empty( $group[ 'description' ] ) && !$fullwidth_tabs ): ?>
            <div class="dht-description"><?php echo esc_html( $group[ 'description' ] ); ?></div>
		<?php endif; ?>

    </div>
	
	<?php if( !empty( $group[ 'tooltip' ] ) && !$fullwidth_tabs ): ?>
        <div class="dht-info-help dashicons dashicons-info">
            <div class="dht-tooltips"><p class="OnLeft"><?php echo esc_html( $group[ 'tooltip' ] ); ?></p></div>
        </div>
	<?php endif; ?>

</div>

<?php if( isset( $group[ 'divider' ] ) && $group[ 'divider' ] ): ?>
    <div class="dht-divider"></div>
<?php endif; ?>

<?php do_action( 'dht:options:view:groups:tabs_after_area' ); ?>
