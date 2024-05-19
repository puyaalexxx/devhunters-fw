<?php
if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use function DHT\Helpers\dht_parse_option_attributes;

$args = $args ?? [];

$icons = [
    "dashicons" => 'DashIcons', "fontawesome" => 'Font Awesome', "divi" => 'Divi',
    "elusive" => 'Elusive', "line" => 'Line Icons', "dev" => 'Dev Icons',
    /*"material" => 'Material Icons',*/
    "bootstrap" => 'Bootstrap'
];
?>
    <div class="dht-field-wrapper">

        <div class="dht-title"><?php echo esc_html( $args[ 'title' ] ); ?></div>

        <div
            class="dht-field-child-wrapper dht-field-child-icons <?php echo isset( $args[ 'attr' ][ 'class' ] ) ? esc_attr( $args[ 'attr' ][ 'class' ] ) : ''; ?>"
            <?php echo dht_parse_option_attributes( $args[ 'attr' ] ); ?>>

            <!--icon preview added here-->
            <span
                class="dht-icon-select-preview <?php echo !empty( $args[ 'value' ] ) ? 'dht-icon-select-preview-show' : ''; ?>">
        <i class="<?php echo !empty( $args[ 'value' ] ) ? esc_attr( $args[ 'value' ][ 'icon-class' ] ) : ''; ?>"></i>
    </span>

            <!--button to trigger the icons popup-->
            <a href="#TB_inline?width=600&height=500&inlineId=<?php echo esc_attr( $args[ 'id' ] ); ?>"
               class="button button-primary dht-thickbox thickbox"><?php echo _x( 'Add Icon', 'options', DHT_PREFIX ) ?></a>

            <!--remove selected icon-->
            <a href=""
               class="button button-primary dht-btn-remove <?php echo !empty( $args[ 'value' ] ) ? 'dht-btn-show' : ''; ?>">
                <?php echo _x( 'Remove Icon', 'options', DHT_PREFIX ) ?>
            </a>

            <!--save icon in this input to pass via $_POST-->
            <input class="dht-icon-select-value"
                   type="hidden"
                   name="<?php echo esc_attr( $args[ 'name' ] ); ?>"
                   value='<?php echo !empty( $args[ 'value' ] ) ? json_encode( $args[ 'value' ] ) : ''; ?>' />

            <!-----------------popup with icons---------------------->
            <div id="<?php echo esc_attr( $args[ 'id' ] ); ?>" class="dht-modal-icons" style="display:none">

                <div class="dht-icons-preview-group" data-popup-id="<?php echo esc_attr( $args[ 'id' ] ); ?>">

                    <label
                        for="<?php echo esc_attr( $args[ 'id' ] ); ?>"><?php echo esc_html( $args[ 'label' ] ); ?></label>

                    <span class="spinner"></span>

                    <div class="dht-icons-type-group">

                        <label
                            for="<?php echo esc_attr( $args[ 'id' ] ); ?>-search-select" style="display:none;"></label>
                        <select class="dht-icons-type dht-field"
                                id="<?php echo esc_attr( $args[ 'id' ] ); ?>-search-select">

                            <?php foreach ( $icons as $icon_key => $icon ): ?>

                                <option
                                    value="<?php echo esc_attr( $icon_key ); ?>"><?php echo esc_html( $icon ); ?></option>

                            <?php endforeach; ?>

                        </select>

                        <label
                            for="<?php echo esc_attr( $args[ 'id' ] ); ?>-search-icon" style="display:none;"></label>
                        <input class="dht-input dht-field dht-search-for-icon"
                               type="text"
                               id="<?php echo esc_attr( $args[ 'id' ] ); ?>-search-icon"
                               placeholder="<?php echo _x( 'Search Icon', 'options', DHT_PREFIX ) ?>" />

                    </div>

                    <!--icons loaded here via ajax-->
                    <div class="dht-icons-preview">
                        <!--Ajax content loaded here-->
                    </div>

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