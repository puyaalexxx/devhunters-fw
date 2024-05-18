<?php
if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use function DHT\Helpers\dht_parse_option_attributes;

$args = $args ?? [];
?>
<!-- field - sortable -->
<div class="dht-field-wrapper">
    <div class="dht-title">Sortable</div>
    <div class="dht-field-child-wrapper dht-field-child-sortable <?php echo isset( $args[ 'attr' ][ 'class' ] ) ? esc_attr( $args[ 'attr' ][ 'class' ] ) : ''; ?>"
        <?php echo dht_parse_option_attributes( $args[ 'attr' ] ); ?>>
        
        <div class="dht-sortable-fields">
            
            <div class="dht-sortable-field">
                <label for="sortable-input">Sortable</label>
                <input class="dht-sortable dht-field" id="sortable-input" type="text" name="sortable-input" value=""
                       title="title" placeholder="text 1" />
                <span class="dht-drag"><i class="dashicons dashicons-menu icon-large"></i></span>
            </div>
            
        </div>
        
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

<style>
    /* sortable styles*/
    .dht-wrapper .dht-field-child-sortable .dht-sortable-field {
        margin-bottom: 10px;
    }
    
    .dht-wrapper .dht-field-child-sortable .dht-sortable-field {
        display: flex;
        align-items: center;
    }
    
    .dht-wrapper .dht-field-child-sortable span.dht-drag {
        margin-left: 10px;
        cursor: pointer;
    }
</style>

<script>
    //sortable field
    jQuery(document).ready(function() {
        jQuery('.dht-wrapper .dht-field-child-sortable .dht-sortable-fields').sortable()
    })
</script>