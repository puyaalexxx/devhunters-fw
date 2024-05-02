<?php
if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );
?>
<!-- field - input -->
<div class="dht-field-wrapper">
    
    <div class="dht-title"><?php echo esc_html($args['title']);?></div>
    
    <div class="dht-field-child-wrapper dht-field-child-input">
        
        <label for="<?php echo esc_attr($args['id']);?>"><?php echo esc_html($args['label']);?></label>
        
        <input class="dht-input dht-field" id="<?php echo esc_attr($args['id']);?>"
               type="<?php echo esc_attr($args['subtype']);?>"
               name="<?php echo esc_attr($args['id']);?>"
               value="<?php echo esc_attr($args['default']);?>"
               title="<?php echo esc_attr($args['label']);?>" />
        
        <?php if(!empty($args['description'])): ?>
            <div class="dht-description"><?php echo esc_html($args['description']);?></div>
        <?php endif; ?>
    </div>
    
    <?php if(!empty($args['tooltip'])): ?>
        <div class="dht-info-help dashicons dashicons-info"
             data-tooltips="<?php echo esc_html($args['tooltip']);?>"
             data-position="OnLeft">
        </div>
    <?php endif; ?>
    
</div>

<?php if($args['divider']): ?>
    <div class="dht-divider"></div>
<?php endif; ?>
