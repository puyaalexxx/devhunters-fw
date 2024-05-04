<?php

use function DHT\Helpers\dht_parse_option_attributes;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

?>

<style>

</style>

<!-- field - checkbox -->
<div class="dht-field-wrapper">

    <div class="dht-title"><?php echo esc_html( $args[ 'title' ] ); ?></div>
    
    <div class="dht-field-child-wrapper dht-field-child-checkbox">
        
        <?php if(!empty($args[ 'checkboxes' ])): ?>
        
            <?php foreach ($args[ 'checkboxes' ] as $key => $checkbox): ?>
                <div class="dht-checkbox-wrapper">
                    
                    <input class="dht-checkbox dht-field <?php echo isset( $args[ 'attr' ][ 'class' ] ) ? esc_attr( $args[ 'attr' ][ 'class' ] ) : ''; ?>"
                           type="checkbox"
                           name="<?php echo esc_attr( $args[ 'id' ] ); ?>[<?php echo esc_attr( $checkbox[ 'id' ] ); ?>]"
                           id="<?php echo esc_attr( $args[ 'id' ] ) . $key; ?>"
                           value="<?php echo esc_attr( $checkbox[ 'value' ] ); ?>"
                           <?php echo $checkbox[ 'checked' ] ? 'checked="checked"' : '';; ?>
                           <?php echo dht_parse_option_attributes( $args[ 'attr' ] ); ?>
                    />
                    
                    <label for="<?php echo esc_attr( $args[ 'id' ] ) . $key; ?>"><?php echo esc_html( $checkbox[ 'label' ] ); ?></label>
                </div>
            <?php endforeach; ?>
        
        <?php endif; ?>

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
