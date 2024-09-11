<?php

if( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use function DHT\Helpers\dht_parse_option_attributes;
use function DHT\Helpers\dht_render_group;

$group = $args[ 'group' ] ?? [];
//used to call the render method on
$registered_options_classes = $args[ 'registered_options_classes' ] ?? [];
?>
<!-- field - accordion -->

<?php do_action( 'dht_template_groups_accordion_before_area' ); ?>

<div class="dht-field-wrapper dht-group-type <?php echo isset( $group[ 'attr' ][ 'class' ] ) ? esc_attr( $group[ 'attr' ][ 'class' ] ) : ''; ?>" <?php echo dht_parse_option_attributes( $group[ 'attr' ] ); ?>>

    <div class="dht-title"><?php echo esc_html( $group[ 'title' ] ); ?></div>

    <div class="dht-field-child-wrapper dht-field-child-accordion">

        <div class="dht-accordion">
            
            <?php if( !empty( $group[ 'options' ] ) ): ?>
                
                <?php $cnt = 0;
                foreach( $group[ 'options' ] as $group_toggle ) : $cnt++; ?>

                    <div class="dht-accordion-item">

                        <div class="dht-accordion-title">

                            <div class="dht-accordion-arrow">
                                <span class="dht-accordion-arrow-item dashicons dashicons-plus-alt"></span>
                                <span class="dht-accordion-arrow-item-close dashicons dashicons-dismiss"></span>
                            </div>

                            <span class="dht-accordion-title-text">
                                    <?php echo !empty( $group_toggle[ 'title' ] ) ? esc_html( $group_toggle[ 'title' ] ) : sprintf( _x( 'Toggle %d', 'options', DHT_PREFIX ), $cnt ); ?>
                                </span>

                        </div>

                        <div class="dht-accordion-content">
                            
                            <?php if( !empty( $group_toggle[ 'options' ] ) ): ?>
                                
                                <?php foreach( $group_toggle[ 'options' ] as $toggle_option ) : ?>
                                    
                                    <?php
                                    //get saved value
                                    $saved_value = $group[ 'value' ][ $toggle_option[ 'id' ] ] ?? [];
                                    
                                    echo dht_render_group( $group[ 'id' ], $toggle_option, $saved_value, $registered_options_classes );
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
        <div class="dht-info-help dashicons dashicons-info"
             data-tooltips="<?php echo esc_html( $group[ 'tooltip' ] ); ?>"
             data-position="OnLeft">
        </div>
    <?php endif; ?>

</div>

<?php if( isset( $group[ 'divider' ] ) && $group[ 'divider' ] ): ?>
    <div class="dht-divider"></div>
<?php endif; ?>

<?php do_action( 'dht_template_groups_accordion_after_area' ); ?>
