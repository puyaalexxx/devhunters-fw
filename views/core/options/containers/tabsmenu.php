<?php

use DHT\Helpers\Classes\OptionsHelpers;

if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

$container = $args[ 'container' ] ?? [];
//get saved values
$saved_values = $container[ 'value' ] ?? [];
//used to call the render method on
$registered_options_classes = $args[ 'registered_options_classes' ] ?? [];
?>
    <!-- container - tabsmenu -->

<?php do_action( 'dht:options:view:container:tabsmenu_before_area' ); ?>

    <div
        class="dht-tabsmenu-container <?php echo isset( $container[ 'attr' ][ 'class' ] ) && !isset( $container[ 'area' ] ) ? esc_attr( $container[ 'attr' ][ 'class' ] ) : ''; ?>">
		
		<?php if( !empty( $container[ 'options' ] ) ): ?>

            <div class="dht-field-tabsmenu">

                <ul class="dht-tabsmenu-links">
					
					<?php $cnt = 0;
					foreach ( $container[ 'options' ] as $tabsmenu ) : $cnt ++; ?>

                        <li class="<?php echo $cnt == 1 ? 'active' : '' ?>">
                            <a href="#<?php echo esc_attr( $tabsmenu[ 'id' ] ); ?>-<?php echo esc_attr( $cnt ); ?>">
								<?php echo !empty( $tabsmenu[ 'title' ] ) ? esc_html( $tabsmenu[ 'title' ] ) : sprintf( _x( 'Tab %d', 'options', 'dht' ), $cnt ); ?>
                            </a>
                        </li>
					
					<?php endforeach; ?>

                </ul>
				
				<?php $count = 0;
				foreach ( $container[ 'options' ] as $tabsmenu ) : $count ++; ?>

                    <div class="dht-tabsmenu-content <?php echo $count == 1 ? 'active' : '' ?>"
                         id="<?php echo esc_attr( $tabsmenu[ 'id' ] ); ?>-<?php echo esc_attr( $count ); ?>">
						
						<?php if( !empty( $tabsmenu[ 'options' ] ) ): ?>
							
							<?php
							//get specific page group/option saved value
							$saved_value = $saved_values[ $container[ 'id' ] ] ?? [];
							
							echo OptionsHelpers::renderOptions( $tabsmenu[ 'options' ], $container[ 'id' ], $saved_value, $registered_options_classes );
							?>
						
						<?php endif; ?>

                    </div>
				
				<?php endforeach; ?>

            </div>
		
		<?php endif; ?>

    </div>

<?php do_action( 'dht:options:view:container:tabsmenu_after_area' ); ?>