<?php
if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use function DHT\Helpers\dht_parse_option_attributes;
use function DHT\Helpers\dht_print_r;

$args = $args ?? [];

// Function to fetch Google Fonts
function getGoogleFonts() {

    $data = file_get_contents( DHT_ASSETS_DIR . 'fonts/google-fonts/google-fonts.json' );
    $fonts = json_decode( $data, true );

    return $fonts[ 'items' ];
}

// Get Google Fonts
$google_fonts = getGoogleFonts();

dht_print_r( $google_fonts );

//font weights
$font_weight = [
    '300' => 'Light',
    '400' => 'Regular',
    '600' => 'Semi Bold',
    '700' => 'Bold',
    '800' => 'Ultra Bold'
];

//fonts styles
$font_style = [
    'normal' => 'Normal',
    'italic' => 'Italic',
];

// text transform
$text_transform = [
    'capitalize' => 'Capitalize',
    'uppercase' => 'Uppercase',
    'lowercase' => 'Lowercase',
    'small-caps' => 'Small Caps',
];

// text decoration
$text_decoration = [
    'underline' => 'Underline',
    'overline' => 'Overline',
    'line-through' => 'Line Through'
];
?>
<!-- field - typography -->
<div class="dht-field-wrapper">

    <div class="dht-title"><?php echo esc_html( $args[ 'title' ] ); ?></div>

    <div
        class="dht-field-child-wrapper dht-field-child-typography <?php echo isset( $args[ 'attr' ][ 'class' ] ) ? esc_attr( $args[ 'attr' ][ 'class' ] ) : ''; ?>"
        <?php echo dht_parse_option_attributes( $args[ 'attr' ] ); ?>>

        <p class="dht-field-child-typography-preview">
            A B C D E F G H I J K L M N O P Q R S T U V W X Y Z a b c d e f g h i j k l m n o p q r
            s t u v w x y z 1 2 3 4 5 6 7 8 9 0
        </p>

        <div class="dht-field-child-typography-group">

            <div class="dht-field-child-typography-dropdown">

                <label
                    for="<?php echo esc_attr( $args[ 'id' ] ); ?>-font-family"><?php echo _x( 'Font Family', 'options', DHT_PREFIX ) ?></label>

                <!--font family-->
                <select class="dht-typography dht-field"
                        name="<?php echo esc_attr( $args[ 'id' ] ); ?>[font-family]"
                        id="<?php echo esc_attr( $args[ 'id' ] ); ?>-font-family"
                        data-placeholder="Font family">

                    <option></option>

                    <optgroup label="Custom Fonts">

                    </optgroup>

                    <optgroup label="Standard Fonts">
                        <option value="Arial, Helvetica, sans-serif" data-google-font="no">Arial, Helvetica,
                            sans-serif
                        </option>
                        <option value="'Arial Black', Gadget, sans-serif" data-google-font="no">'Arial Black', Gadget,
                            sans-serif
                        </option>
                        <option value="'Bookman Old Style', serif" data-google-font="no">'Bookman Old Style', serif
                        </option>
                        <option value="'Comic Sans MS', cursive" data-google-font="no">'Comic Sans MS', cursive</option>
                        <option value="Courier, monospace" data-google-font="no">Courier, monospace</option>
                        <option value="Garamond, serif" data-google-font="no">Garamond, serif</option>
                        <option value="Georgia, serif" data-google-font="no">Georgia, serif</option>
                        <option value="Impact, Charcoal, sans-serif" data-google-font="no">Impact, Charcoal,
                            sans-serif
                        </option>
                        <option value="'Lucida Console', Monaco, monospace" data-google-font="no">'Lucida Console',
                            Monaco, monospace
                        </option>
                        <option value="'Lucida Sans Unicode', 'Lucida Grande', sans-serif" data-google-font="no">'Lucida
                            Sans Unicode', 'Lucida Grande', sans-serif
                        </option>
                        <option value="'MS Sans Serif', Geneva, sans-serif" data-google-font="no">'MS Sans Serif',
                            Geneva, sans-serif
                        </option>
                        <option value="'MS Serif', 'New York', sans-serif" data-google-font="no">'MS Serif', 'New York',
                            sans-serif
                        </option>
                        <option value="'Palatino Linotype', 'Book Antiqua', Palatino, serif" data-google-font="no">
                            'Palatino Linotype', 'Book Antiqua', Palatino, serif
                        </option>
                        <option value="Tahoma,Geneva, sans-serif" data-google-font="no">Tahoma,Geneva, sans-serif
                        </option>
                        <option value="'Times New Roman', Times,serif" data-google-font="no">'Times New Roman',
                            Times,serif
                        </option>
                        <option value="'Trebuchet MS', Helvetica, sans-serif" data-google-font="no">'Trebuchet MS',
                            Helvetica, sans-serif
                        </option>
                        <option value="Verdana, Geneva, sans-serif" data-google-font="no">Verdana, Geneva, sans-serif
                        </option>
                    </optgroup>

                    <optgroup label="Google Fonts" data-google-font="yes">

                        <?php foreach ( $google_fonts as $font ): ?>

                            <!--grab google font subsets-->
                            <?php $font_subset = isset( $font[ 'subsets' ] ) ? json_encode( $font[ 'subsets' ] ) : json_encode( [] ); ?>

                            <option value='<?php echo esc_attr( $font[ 'family' ] ); ?>'
                                    data-google-font="yes"
                                    data-font-subsets='<?php echo esc_attr( $font_subset ); ?>'
                                    data-font-weights='<?php //echo esc_attr( $font_subset ); ?>'>
                                <?php echo esc_html( $font[ 'family' ] ); ?>
                            </option>

                        <?php endforeach; ?>

                    </optgroup>

                </select>
            </div>

            <!--font weight-->
            <div class="dht-field-child-typography-dropdown">

                <label
                    for="<?php echo esc_attr( $args[ 'id' ] ); ?>-font-weight"><?php echo _x( 'Font Weight', 'options', DHT_PREFIX ) ?></label>

                <select class="dht-typography-weight dht-field"
                        name="<?php echo esc_attr( $args[ 'id' ] ); ?>[font-weight]"
                        id="<?php echo esc_attr( $args[ 'id' ] ); ?>-font-weight"
                        data-placeholder="Font Weight">

                    <option></option>

                    <?php foreach ( $font_weight as $font_weight_value => $font_weight_name ): ?>
                        <option
                            value="<?php echo esc_attr( $font_weight_value ); ?>"><?php echo esc_html( $font_weight_name ); ?></option>
                    <?php endforeach; ?>

                </select>
            </div>

            <!--font style-->
            <div class="dht-field-child-typography-dropdown">

                <label
                    for="<?php echo esc_attr( $args[ 'id' ] ); ?>-font-style"><?php echo _x( 'Font Style', 'options', DHT_PREFIX ) ?></label>

                <select class="dht-typography-style dht-field"
                        name="<?php echo esc_attr( $args[ 'id' ] ); ?>[font-style]"
                        id="<?php echo esc_attr( $args[ 'id' ] ); ?>-font-style"
                        data-placeholder="Font Style">

                    <option></option>

                    <?php foreach ( $font_style as $font_style_value => $font_style_name ): ?>
                        <option
                            value="<?php echo esc_attr( $font_style_value ); ?>"><?php echo esc_html( $font_style_name ); ?></option>
                    <?php endforeach; ?>
                </select>

            </div>

            <!--font subsets-->
            <div class="dht-field-child-typography-dropdown">

                <label
                    for="<?php echo esc_attr( $args[ 'id' ] ); ?>-font-subsets"><?php echo _x( 'Font Subsets', 'options', DHT_PREFIX ) ?></label>

                <select class="dht-typography-subsets dht-field"
                        name="<?php echo esc_attr( $args[ 'id' ] ); ?>[font-subsets]"
                        id="<?php echo esc_attr( $args[ 'id' ] ); ?>-font-subsets"
                        data-placeholder="Font Subsets">

                    <option></option>

                </select>

            </div>

            <!--text transform-->
            <div class="dht-field-child-typography-dropdown">

                <label
                    for="<?php echo esc_attr( $args[ 'id' ] ); ?>-text-transform"><?php echo _x( 'Text Transform', 'options', DHT_PREFIX ) ?></label>

                <select class="dht-typography-transform dht-field"
                        name="<?php echo esc_attr( $args[ 'id' ] ); ?>[text-transform]"
                        id="<?php echo esc_attr( $args[ 'id' ] ); ?>-text-transform"
                        data-placeholder="Text Transform">

                    <option></option>

                    <?php foreach ( $text_transform as $text_transform_value => $text_transform_name ): ?>
                        <option
                            value="<?php echo esc_attr( $text_transform_value ); ?>"><?php echo esc_html( $text_transform_name ); ?></option>
                    <?php endforeach; ?>

                </select>

            </div>

            <!--text decoration-->
            <div class="dht-field-child-typography-dropdown">

                <label
                    for="<?php echo esc_attr( $args[ 'id' ] ); ?>-text-decoration"><?php echo _x( 'Text Decoration', 'options', DHT_PREFIX ) ?></label>

                <select class="dht-typography-decoration dht-field"
                        name="<?php echo esc_attr( $args[ 'id' ] ); ?>[text-decoration]"
                        id="<?php echo esc_attr( $args[ 'id' ] ); ?>-text-decoration"
                        data-placeholder="Text Decoration">

                    <option></option>

                    <?php foreach ( $text_decoration as $text_decoration_value => $text_decoration_name ): ?>
                        <option
                            value="<?php echo esc_attr( $text_decoration_value ); ?>"><?php echo esc_html( $text_decoration_name ); ?></option>
                    <?php endforeach; ?>

                </select>

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

<script>
    jQuery(document).ready(function($) {

        //preview area div
        const $preview_area = $(".dht-field-child-typography .dht-field-child-typography-preview");

        //fonts dropdown
        const $fonts_dropdown = $(".dht-field-child-typography .dht-typography");
        //font weights dropdown
        const $font_weight_dropdown = $(".dht-field-child-typography .dht-typography-weight");
        //font styles dropdown
        const $font_style_dropdown = $(".dht-field-child-typography .dht-typography-style");
        //font subsets
        const $font_subsets_dropdown = $(".dht-field-child-typography .dht-typography-subsets");
        //text transform
        const $text_transform_dropdown = $(".dht-field-child-typography .dht-typography-transform");
        //text decoration
        const $text_decoration_dropdown = $(".dht-field-child-typography .dht-typography-decoration");

        //fonts dropdown
        $fonts_dropdown.select2({
            allowClear: true,
        });
        $fonts_dropdown.on("change", function() {
            const $selected_font = $(this);

            //check if it is a Google font
            const isGoogleFont = $selected_font.find("option:selected").attr("data-google-font");

            //get the selected font family
            const font_family = $selected_font.val();

            $preview_area.css("font-family", font_family);

            //if Google font
            if (isGoogleFont === "yes") {
                const fontWeights = {}; // Object to store font weights
                //get the selected Google font - font subsets
                const font_subsets = $selected_font.find("option:selected").attr("data-font-subsets");

                //include the font link for preview
                const fontLink = "https://fonts.googleapis.com/css?family=" + font_family.replace(/\s+/g, "+");
                //const fontLink = "https://fonts.gstatic.com/s/abeezee/v22/esDT31xSG-6AGleN2tCklZUCGpG-GQ.ttf";
                $("<link href=\"" + fontLink + "\" rel=\"stylesheet\">").appendTo("head");

                //add Google font - font weights
                $font_weight_dropdown.empty();
                // Filter font weights for selected font
                $.each(fontWeights[font_family], function(index, weight) {
                    console.log(weight);

                    $font_weight_dropdown.append("<option value=\"" + weight + "\">" + weight + "</option>");
                });

                //add Google font - font subsets to the font subsets dropdown
                $font_subsets_dropdown.empty();
                if (font_subsets.length > 0) {

                    $font_subsets_dropdown.append("<option></option>");
                    $.each(JSON.parse(font_subsets), function(index, subset) {

                        $font_subsets_dropdown.append("<option value=\"" + subset + "\">" + subset + "</option>");
                    });
                }

                // Trigger change event to update Select2
                $font_weight_dropdown.trigger("change");
            }
        });

        //font weights dropdown
        $font_weight_dropdown.select2({
            allowClear: true,
        });
        $font_weight_dropdown.on("change", function() {
            const font_weight = $(this).val();

            $preview_area.css("font-weight", font_weight);
        });

        //font styles dropdown
        $font_style_dropdown.select2({
            allowClear: true,
        });
        $font_style_dropdown.on("change", function() {
            const font_style = $(this).val();

            $preview_area.css("font-style", font_style);
        });

        //font subsets dropdown
        $font_subsets_dropdown.select2({
            allowClear: true,
        });

        //text transform dropdown
        $text_transform_dropdown.select2({
            allowClear: true,
        });
        $text_transform_dropdown.on("change", function() {
            const text_transform = $(this).val();

            //reset css
            $preview_area.css("font-variant", "");
            $preview_area.css("text-transform", "");

            if (text_transform === "small-caps") {
                $preview_area.css("font-variant", text_transform);
            } else {
                $preview_area.css("text-transform", text_transform);
            }
        });

        //text decoration dropdown
        $text_decoration_dropdown.select2({
            allowClear: true,
        });
        $text_decoration_dropdown.on("change", function() {
            const text_decoration = $(this).val();

            $preview_area.css("text-decoration", text_decoration);
        });

    });
</script>

<style>
    .dht-wrapper .dht-field-child-typography .dht-field-child-typography-group {
        display: grid;
        grid-template-columns: 1fr 1fr;
        grid-gap: 15px;
    }

    .dht-wrapper .dht-field-child-typography label {
        display: block !important;
    }

    .dht-wrapper .dht-field-child-typography .dht-field-child-typography-preview {
        width: 100%;
        border: 1px dotted #d3d3d3;
        max-width: 850px;
        padding: 10px;
        font-size: 10pt;
        height: auto;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
        overflow: hidden;
        margin: 5px 0 20px;
    }
</style>