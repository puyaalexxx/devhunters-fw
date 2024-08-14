<?php
if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use DHT\Helpers\Classes\TypographyHelpers;
use function DHT\Helpers\{dht_parse_option_attributes, dht_remove_font_name_prefix};

$args = $args ?? [];

//get option array info
$option = $args[ 'option' ];

//get standard typography values
[
    $standard_fonts,
    $standard_font_weights, $standard_font_styles,
    $text_decoration, $text_transform
] = $args[ 'additional_args' ];

// Get Google Fonts
[
    'google-fonts' => $google_fonts, 'font-weights' => $google_font_weights,
    'font-subsets' => $google_font_subsets,
] = TypographyHelpers::getGoogleFonts();

//get Divi fonts
$et_fonts = TypographyHelpers::getDiviFonts();

//get saved or default values
[
    $font_value, $font_type_value,
    $font_path_value, $font_weight_value,
    $font_subsets_value, $font_style_value,
    $text_transform_value, $text_decoration_value
] = TypographyHelpers::getOptionValues( $option[ 'value' ] );

//styles used for preview area
$preview_styles = TypographyHelpers::buildPreviewStyles( $option[ 'value' ], [
    'font_value' => $font_value, 'font_weight_value' => $font_weight_value,
    'font_style_value' => $font_style_value, 'text_transform_value' => $text_transform_value,
    'text_decoration_value' => $text_decoration_value
] );


$font_type = TypographyHelpers::getFontType( $font_value, $google_fonts, $et_fonts );
?>
    <!-- field - typography -->
    <div class="dht-field-wrapper">

        <div class="dht-title"><?php echo esc_html( $option[ 'title' ] ); ?></div>

        <div
            class="dht-field-child-wrapper dht-field-child-typography <?php echo isset( $option[ 'attr' ][ 'class' ] ) ? esc_attr( $option[ 'attr' ][ 'class' ] ) : ''; ?>"
            <?php echo dht_parse_option_attributes( $option[ 'attr' ] ); ?>>

            <p class="dht-field-child-typography-preview" style="<?php echo esc_attr( $preview_styles ); ?>">
                A B C D E F G H I J K L M N O P Q R S T U V W X Y Z a b c d e f g h i j k l m n o p q r
                s t u v w x y z 1 2 3 4 5 6 7 8 9 0
            </p>
            <!-- custom fonts font face area -->
            <div id="dht-custom-style">
                <style>
                    <?php if ( !empty( $font_path_value ) ): ?>
                    @font-face {
                        font-family: <?php echo esc_html(dht_remove_font_name_prefix(  $font_value )); ?>;
                        src: url(<?php echo esc_url($font_path_value); ?>) format('truetype');
                    }

                    <?php endif; ?>
                </style>
            </div>

            <div class="dht-field-child-typography-group">

                <div class="dht-field-child-typography-dropdown">

                    <label
                        for="<?php echo esc_attr( $option[ 'id' ] ); ?>-font-family"><?php echo _x( 'Font Family', 'options', DHT_PREFIX ) ?></label>

                    <!--font type-->
                    <input class="dht-typography-font-type-hidden" type="hidden"
                           name="<?php echo esc_attr( $option[ 'id' ] ); ?>[font-family][font-type]"
                           value="<?php echo $font_type; ?>" />
                    <!--font path-->
                    <input class="dht-typography-path-hidden" type="hidden"
                           name="<?php echo esc_attr( $option[ 'id' ] ); ?>[font-family][font-path]"
                           value="<?php echo ( array_key_exists( $font_value, $et_fonts ) ) ? $font_path_value : ''; ?>" />

                    <!--font family-->
                    <select class="dht-typography dht-field"
                            name="<?php echo esc_attr( $option[ 'id' ] ); ?>[font-family][font]"
                            id="<?php echo esc_attr( $option[ 'id' ] ); ?>-font-family"
                            data-placeholder="Font family" data-font-prefix="<?php echo DHT_PREFIX; ?>"
                            data-saved-values='<?php echo !empty( $font_value ) ? json_encode( array( 'font' => $font_value, 'font_type' => $font_type_value, 'weight' => $font_weight_value ) ) : ""; ?>'>

                        <option></option>

                        <?php if ( !empty( $et_fonts ) ): ?>

                            <!--Divi fonts-->
                            <optgroup label="Divi Fonts">

                                <?php foreach ( $et_fonts as $et_font_key => $et_font ): ?>

                                    <option value="<?php echo esc_attr( $et_font_key ); ?>"
                                        <?php echo $font_value == $et_font_key ? 'selected' : ''; ?>
                                            data-font-path="<?php echo esc_url( $et_font[ 'path' ] ); ?>"
                                            data-font-type="divi"
                                            data-font-weights='<?php echo esc_attr( json_encode( $et_font[ 'weight' ] ) ); ?>'>
                                        <?php echo esc_attr( $et_font[ 'name' ] ); ?>
                                    </option>

                                <?php endforeach; ?>

                            </optgroup>

                        <?php endif; ?>

                        <!--Standard fonts-->
                        <optgroup label="Standard Fonts">

                            <?php foreach ( $standard_fonts as $standard_font_value => $standard_font ): ?>

                                <option value="<?php echo esc_attr( $standard_font_value ); ?>"
                                    <?php echo $font_value == $standard_font_value ? 'selected' : ''; ?>
                                        data-font-type="standard">
                                    <?php echo esc_attr( $standard_font ); ?>
                                </option>

                            <?php endforeach; ?>

                        </optgroup>

                        <?php if ( !empty( $google_fonts ) ): ?>

                            <!--Google fonts-->
                            <optgroup label="Google Fonts">

                                <?php foreach ( $google_fonts as $font ): ?>
                                    <?php
                                    //grab google font subsets
                                    $font_subset = !empty( $font[ 'subsets' ] ) ? json_encode( $font[ 'subsets' ] ) : json_encode( [] );
                                    ?>
                                    <?php
                                    //grab google font weights
                                    $font_weights = !empty( $font[ 'weights' ] ) ? json_encode( $font[ 'weights' ] ) : json_encode( [] );
                                    ?>

                                    <option value='<?php echo esc_attr( $font[ 'family' ] ); ?>'
                                        <?php echo $font_value == $font[ 'family' ] ? 'selected' : ''; ?>
                                            data-font-type="google"
                                            data-font-subsets='<?php echo esc_attr( $font_subset ); ?>'
                                            data-font-weights='<?php echo esc_attr( $font_weights ); ?>'>
                                        <?php echo esc_html( $font[ 'family' ] ); ?>
                                    </option>

                                <?php endforeach; ?>

                            </optgroup>

                        <?php endif; ?>

                    </select>
                </div>

                <!--font weight-->
                <div class="dht-field-child-typography-dropdown">

                    <label for="<?php echo esc_attr( $option[ 'id' ] ); ?>-font-weight">
                        <?php echo _x( 'Font Weight', 'options', DHT_PREFIX ) ?>
                    </label>

                    <select class="dht-typography-weight dht-field"
                            name="<?php echo esc_attr( $option[ 'id' ] ); ?>[font-weight]"
                            id="<?php echo esc_attr( $option[ 'id' ] ); ?>-font-weight"
                            data-placeholder="Font Weight"
                            data-standard-font-weights='<?php echo json_encode( $standard_font_weights ); ?>'>

                        <option></option>

                        <!--check if the saved font is a Google font-->
                        <?php if ( array_key_exists( $font_value, $google_font_weights ) ): ?>

                            <?php foreach ( $google_font_weights[ $font_value ] as $google_font_weight_key => $google_font_weight_value ): ?>

                                <option
                                    value="<?php echo esc_attr( $google_font_weight_key ); ?>"
                                    <?php echo $font_weight_value == $google_font_weight_key ? 'selected' : ''; ?>>
                                    <?php echo esc_html( $google_font_weight_value ); ?>
                                </option>

                            <?php endforeach; ?>

                            <!--check if the saved font is a Divi font-->
                        <?php elseif ( array_key_exists( $font_value, $et_fonts ) ): ?>

                            <?php $et_font_weight = $et_fonts[ $font_value ][ 'weight' ]; ?>

                            <option
                                value="<?php echo esc_attr( array_key_first( $et_font_weight ) ); ?>"
                                <?php echo $font_weight_value == array_key_first( $et_font_weight ) ? 'selected' : ''; ?>>
                                <?php echo esc_html( $et_font_weight[ array_key_first( $et_font_weight ) ] ); ?>
                            </option>

                        <?php else: ?>

                            <?php foreach ( $standard_font_weights as $font_weight_val => $font_weight_name ): ?>

                                <option
                                    value="<?php echo esc_attr( $font_weight_val ); ?>"
                                    <?php echo $font_weight_value == $font_weight_val ? 'selected' : ''; ?>>
                                    <?php echo esc_html( $font_weight_name ); ?>
                                </option>

                            <?php endforeach; ?>

                        <?php endif; ?>

                    </select>
                </div>

                <!--font style-->
                <div class="dht-field-child-typography-dropdown">

                    <label
                        for="<?php echo esc_attr( $option[ 'id' ] ); ?>-font-style"><?php echo _x( 'Font Style', 'options', DHT_PREFIX ) ?></label>

                    <select class="dht-typography-style dht-field"
                            name="<?php echo esc_attr( $option[ 'id' ] ); ?>[font-style]"
                            id="<?php echo esc_attr( $option[ 'id' ] ); ?>-font-style"
                            data-placeholder="Font Style">

                        <option></option>

                        <?php foreach ( $standard_font_styles as $font_style_val => $font_style_name ): ?>

                            <option
                                value="<?php echo esc_attr( $font_style_val ); ?>"
                                <?php echo $font_style_value == $font_style_val ? 'selected' : ''; ?>>
                                <?php echo esc_html( $font_style_name ); ?>
                            </option>

                        <?php endforeach; ?>
                    </select>

                </div>

                <!--font subsets-->
                <div class="dht-field-child-typography-dropdown">

                    <label
                        for="<?php echo esc_attr( $option[ 'id' ] ); ?>-font-subsets"><?php echo _x( 'Font Subsets', 'options', DHT_PREFIX ) ?></label>

                    <select class="dht-typography-subsets dht-field"
                            name="<?php echo esc_attr( $option[ 'id' ] ); ?>[font-subsets]"
                            id="<?php echo esc_attr( $option[ 'id' ] ); ?>-font-subsets"
                            data-placeholder="Font Subsets">

                        <option></option>

                        <!--check if the saved font is a Google font-->
                        <?php if ( array_key_exists( $font_value, $google_font_subsets ) ): ?>

                            <?php foreach ( $google_font_subsets[ $font_value ] as $google_font_subset_value ): ?>

                                <option
                                    value="<?php echo esc_attr( $google_font_subset_value ); ?>"
                                    <?php echo $font_subsets_value == $google_font_subset_value ? 'selected' : ''; ?>>
                                    <?php echo esc_html( $google_font_subset_value ); ?>
                                </option>

                            <?php endforeach; ?>

                        <?php endif; ?>

                    </select>

                </div>

                <!--text transform-->
                <div class="dht-field-child-typography-dropdown">

                    <label
                        for="<?php echo esc_attr( $option[ 'id' ] ); ?>-text-transform"><?php echo _x( 'Text Transform', 'options', DHT_PREFIX ) ?></label>

                    <select class="dht-typography-transform dht-field"
                            name="<?php echo esc_attr( $option[ 'id' ] ); ?>[text-transform]"
                            id="<?php echo esc_attr( $option[ 'id' ] ); ?>-text-transform"
                            data-placeholder="Text Transform">

                        <option></option>

                        <?php foreach ( $text_transform as $text_transform_val => $text_transform_name ): ?>

                            <option
                                value="<?php echo esc_attr( $text_transform_val ); ?>"
                                <?php echo $text_transform_value == $text_transform_val ? 'selected' : ''; ?>>
                                <?php echo esc_html( $text_transform_name ); ?>
                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>

                <!--text decoration-->
                <div class="dht-field-child-typography-dropdown">

                    <label
                        for="<?php echo esc_attr( $option[ 'id' ] ); ?>-text-decoration"><?php echo _x( 'Text Decoration', 'options', DHT_PREFIX ) ?></label>

                    <select class="dht-typography-decoration dht-field"
                            name="<?php echo esc_attr( $option[ 'id' ] ); ?>[text-decoration]"
                            id="<?php echo esc_attr( $option[ 'id' ] ); ?>-text-decoration"
                            data-placeholder="Text Decoration">

                        <option></option>

                        <?php foreach ( $text_decoration as $text_decoration_val => $text_decoration_name ): ?>

                            <option
                                value="<?php echo esc_attr( $text_decoration_val ); ?>"
                                <?php echo $text_decoration_value == $text_decoration_val ? 'selected' : ''; ?>>
                                <?php echo esc_html( $text_decoration_name ); ?>
                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>

            </div>

            <?php if ( !empty( $option[ 'description' ] ) ): ?>
                <div class="dht-description"><?php echo esc_html( $option[ 'description' ] ); ?></div>
            <?php endif; ?>

        </div>

        <?php if ( !empty( $option[ 'tooltip' ] ) ): ?>
            <div class="dht-info-help dashicons dashicons-info"
                 data-tooltips="<?php echo esc_html( $option[ 'tooltip' ] ); ?>"
                 data-position="OnLeft">
            </div>
        <?php endif; ?>

    </div>

<?php if ( isset( $option[ 'divider' ] ) && $option[ 'divider' ] ): ?>
    <div class="dht-divider"></div>
<?php endif; ?>