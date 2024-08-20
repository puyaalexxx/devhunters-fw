<?php

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use function DHT\Helpers\dht_parse_option_attributes;
use function DHT\Helpers\dht_render_option_if_exists;

$group = $args[ 'group' ] ?? [];
//used to call the render method on
$registered_options = $args[ 'registered_options' ] ?? [];

//see if the tabs should be fullwidth
$fullwidth_tabs = $group[ 'fullwidth' ] ?? false;

//create unique tabs id
$tabs_id = str_replace( [ '[', ']' ], '-', $group[ 'id' ] ) . 'tab';
?>
    <!-- field - tabs -->
    <div class="dht-field-wrapper <?php echo $fullwidth_tabs ? 'dht-field-tabs-fullwidth' : ''; ?>">

        <?php if ( !$fullwidth_tabs ): ?>

            <div class="dht-title"><?php echo esc_html( $group[ 'title' ] ); ?></div>

        <?php endif; ?>

        <div
            class="dht-field-child-wrapper dht-field-child-tabs <?php echo isset( $group[ 'attr' ][ 'class' ] ) ? esc_attr( $group[ 'attr' ][ 'class' ] ) : ''; ?>"
            <?php echo dht_parse_option_attributes( $group[ 'attr' ] ); ?>>

            <div class="dht-field-tabs">

                <?php if ( !empty( $group[ 'options' ] ) ): ?>

                    <ul class="dht-tab-links">

                        <?php $cnt = 0;
                        foreach ( $group[ 'options' ] as $group_tabs ) : $cnt++; ?>

                            <li class="<?php echo $cnt == 1 ? 'active' : '' ?>">
                                <a href="#<?php echo esc_attr( $tabs_id ); ?>-<?php echo esc_attr( $cnt ); ?>">
                                    <?php echo !empty( $group_tabs[ 'title' ] ) ? esc_html( $group_tabs[ 'title' ] ) : sprintf( _x( 'Tab %d', 'options', DHT_PREFIX ), $cnt ); ?>
                                </a>
                            </li>

                        <?php endforeach; ?>

                    </ul>

                    <?php $count = 0;
                    foreach ( $group[ 'options' ] as $group_tabs_content ) : $count++; ?>

                        <div class="dht-tab-content <?php echo $count == 1 ? 'active' : '' ?>"
                             id="<?php echo esc_attr( $tabs_id ); ?>-<?php echo esc_attr( $count ); ?>">

                            <?php if ( !empty( $group_tabs_content[ 'options' ] ) ): ?>

                                <?php foreach ( $group_tabs_content[ 'options' ] as $tab_option ) : ?>

                                    <?php
                                    //get saved value
                                    $saved_value = $group[ 'value' ][ $tab_option[ 'id' ] ] ?? [];

                                    //render the specific option type
                                    echo dht_render_option_if_exists( $tab_option, $saved_value, $group[ 'id' ], $registered_options );
                                    ?>

                                <?php endforeach; ?>

                            <?php endif; ?>

                        </div>

                    <?php endforeach; ?>

                <?php endif; ?>

            </div>

            <?php if ( !empty( $group[ 'description' ] ) && !$fullwidth_tabs ): ?>
                <div class="dht-description"><?php echo esc_html( $group[ 'description' ] ); ?></div>
            <?php endif; ?>

        </div>

        <?php if ( !empty( $group[ 'tooltip' ] ) && !$fullwidth_tabs ): ?>
            <div class="dht-info-help dashicons dashicons-info"
                 data-tooltips="<?php echo esc_html( $group[ 'tooltip' ] ); ?>"
                 data-position="OnLeft">
            </div>
        <?php endif; ?>

    </div>

<?php if ( isset( $group[ 'divider' ] ) && $group[ 'divider' ] ): ?>
    <div class="dht-divider"></div>
<?php endif; ?>