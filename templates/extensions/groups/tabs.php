<?php

use function DHT\Helpers\dht_print_r;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

$group = $args[ 'group' ] ?? [];
//used to call the render method on
$registered_options = $args[ 'registered_options' ] ?? [];

dht_print_r( $group );
?>
<!-- field - tabs -->
<div class="dht-field-wrapper">

    <div class="dht-title"><?php echo esc_html( $group[ 'title' ] ); ?></div>

    <div class="dht-field-child-wrapper dht-field-child-tabs">

        <div class="dht-field-tabs">

            <ul class="dht-tab-links">
                <li class="active"><a href="#tab1">Tab 1</a></li>
                <li><a href="#tab2">Tab 2</a></li>
                <li><a href="#tab3">Tab 3</a></li>
            </ul>

            <div class="dht-tab-content active" id="tab1">
                <div class="dht-field-wrapper">
                    <div class="dht-field-child-wrapper dht-field-child-textarea">
                        <label for="textarea">Textarea</label>
                        <textarea class="dht-textarea dht-field" id="textarea" name="textarea" placeholder="Textarea"
                                  rows="6"></textarea>
                        <div class="dht-description">Field description</div>
                    </div>
                </div>
            </div>

            <div class="dht-tab-content" id="tab2">
                <div class="dht-field-wrapper">
                    <div class="dht-field-child-wrapper dht-field-child-textarea">
                        <label for="textarea">Textarea</label>
                        <textarea class="dht-textarea dht-field" id="textarea" name="textarea" placeholder="Textarea"
                                  rows="6"></textarea>
                        <div class="dht-description">Field description</div>
                    </div>
                </div>
            </div>

            <div class="dht-tab-content" id="tab3">Tab 3 content</div>

        </div>

        <?php if ( !empty( $group[ 'description' ] ) ): ?>
            <div class="dht-description"><?php echo esc_html( $group[ 'description' ] ); ?></div>
        <?php endif; ?>

    </div>

    <?php if ( !empty( $group[ 'tooltip' ] ) ): ?>
        <div class="dht-info-help dashicons dashicons-info"
             data-tooltips="<?php echo esc_html( $group[ 'tooltip' ] ); ?>"
             data-position="OnLeft">
        </div>
    <?php endif; ?>

</div>

<?php if ( isset( $group[ 'divider' ] ) && $group[ 'divider' ] ): ?>
    <div class="dht-divider"></div>
<?php endif; ?>

<style>
    .dht-wrapper .dht-field-child-tabs .dht-tab-content {
        display: none;
    }

    .dht-wrapper .dht-field-child-tabs .dht-tab-content.active {
        display: block;
    }

    .dht-wrapper .dht-field-child-tabs .dht-tab-links li a {
        display: inline-block;
        padding: 12px 15px;
        margin-top: 1px;
        margin-right: 5px;
        margin-bottom: -1px;
        position: relative;
        text-decoration: none;
        color: #444;
        font-weight: 600;
        border: 1px solid #ccd0d4;
        background-color: #f3f3f3;
        -webkit-transition: all .2s;
        transition: all .2s;
    }

    .dht-wrapper .dht-field-child-tabs .dht-tab-links li.active a {
        background-color: #fff;
        border-bottom-color: #fff;
    }

    .dht-wrapper .dht-field-child-tabs .dht-field-tabs .dht-tab-content {
        border: 1px solid #ccd0d4;
        background-color: #fff;
        -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.04);
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.04);
    }

    .dht-wrapper .dht-field-child-tabs ul.dht-tab-links {
        display: flex;
        margin-bottom: 0;
    }

    .dht-wrapper .dht-field-child-tabs .dht-field-tabs .dht-tab-content {
        padding: 20px;
    }

    .dht-wrapper .dht-field-child-tabs .dht-tab-links li {
        margin-bottom: 0;
    }

    .dht-wrapper .dht-field-child-tabs .dht-field-wrapper {
        display: block;
        padding: 0;
    }
</style>
<script>
    jQuery(document).ready(function($) {
        $(".dht-field-tabs .dht-tab-links a").click(function(e) {
            e.preventDefault(); // Prevent default anchor behavior

            // Get the target tab ID from the href attribute
            let tabId = $(this).attr("href");

            // Hide all tab contents and remove 'active' class from all tabs
            $(".dht-tab-content").removeClass("active");
            $(".dht-tab-links li").removeClass("active");

            // Show the target tab content and add 'active' class to the clicked tab
            $(tabId).addClass("active");
            $(this).parent().addClass("active");
        });
    });
</script>