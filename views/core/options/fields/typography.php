<?php
if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

use DHT\Helpers\Classes\TypographyHelpers;
use function DHT\Helpers\{dht_fw_get_css_units,
	dht_fw_live_option_selectors,
	dht_get_typography_field_css_properties,
	dht_parse_option_attributes,
	dht_remove_font_name_prefix};

$args = $args ?? [];

//get field array info
$field = $args[ 'field' ];

//get standard typography values
[
	$standard_fonts,
	$standard_font_weights,
	$standard_font_styles,
	$text_decoration,
	$text_transform,
	$text_align
] = $args[ 'additional_args' ];

// Get Google Fonts
[
	'google-fonts' => $google_fonts,
	'font-weights' => $google_font_weights,
	'font-subsets' => $google_font_subsets,
] = TypographyHelpers::getGoogleFonts();

//get Divi fonts
$et_fonts = TypographyHelpers::getDiviFonts();

//get saved or default values
[
	$font_value,
	$font_type_value,
	$font_path_value,
	$font_weight_value,
	$font_subsets_value,
	$font_style_value,
	$text_transform_value,
	$text_decoration_value,
	$text_align_value,
	$font_size_value,
	$line_height_value,
	$letter_spacing_value,
	$text_color_value
] = TypographyHelpers::getOptionValues( $field[ 'value' ] );

//styles used for preview area
$preview_styles = dht_get_typography_field_css_properties( $field[ 'value' ] );

$font_type = TypographyHelpers::getFontType( $font_value, $google_fonts, $et_fonts );
?>
<!-- field - typography -->

<?php do_action( 'dht:options:view:fields:typography_before_area' ); ?>

<div
    class="dht-field-wrapper dht-field-wrapper-typography <?php echo isset( $field[ 'attr' ][ 'class' ] ) ? esc_attr( $field[ 'attr' ][ 'class' ] ) : ''; ?>"
	<?php echo dht_parse_option_attributes( $field[ 'attr' ] ?? [] ); ?>>
	
	<?php if( !empty( $field[ 'title' ] ) ): ?>
        <div class="dht-title"><?php echo esc_html( $field[ 'title' ] ); ?></div>
	<?php endif; ?>

    <div
        class="dht-field-child-wrapper dht-field-child-typography" <?php echo dht_fw_live_option_selectors( $field[ 'live' ] ?? [] ); ?>>
		
		<?php if( $field[ 'preview' ] ): ?>
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
		<?php endif; ?>

        <div class="dht-field-child-typography-group">

            <div class="dht-field-child-typography-dropdown">

                <label
                    for="<?php echo esc_attr( $field[ 'id' ] ); ?>-font-family"><?php echo _x( 'Font Family', 'options', DHT_PREFIX ) ?></label>

                <!--font type-->
                <input class="dht-typography-font-type-hidden" type="hidden"
                       name="<?php echo esc_attr( $field[ 'id' ] ); ?>[font-family][font-type]"
                       value="<?php echo $font_type; ?>" />
                <!--font path-->
                <input class="dht-typography-path-hidden" type="hidden"
                       name="<?php echo esc_attr( $field[ 'id' ] ); ?>[font-family][font-path]"
                       value="<?php echo ( array_key_exists( $font_value, $et_fonts ) ) ? $font_path_value : ''; ?>" />

                <!--font family-->
                <select class="dht-typography dht-field"
                        name="<?php echo esc_attr( $field[ 'id' ] ); ?>[font-family][font]"
                        id="<?php echo esc_attr( $field[ 'id' ] ); ?>-font-family"
                        data-placeholder="Font family" data-font-prefix="<?php echo DHT_PREFIX; ?>"
                        data-saved-values='<?php echo !empty( $font_value ) ? htmlspecialchars( json_encode( array(
					        'font'      => $font_value,
					        'font_type' => $font_type_value,
					        'weight'    => $font_weight_value
				        ) ), ENT_QUOTES ) : ""; ?>'>

                    <option></option>
					
					<?php if( !empty( $et_fonts ) ): ?>

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
					
					<?php if( !empty( $google_fonts ) && apply_filters( 'dht:options:fields:typography_enable_google_fonts', true ) ): ?>

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

                <label
                    for="<?php echo esc_attr( $field[ 'id' ] ); ?>-font-weight"><?php echo _x( 'Font Weight', 'options', DHT_PREFIX ) ?></label>

                <select class="dht-typography-weight dht-field"
                        name="<?php echo esc_attr( $field[ 'id' ] ); ?>[font-weight]"
                        id="<?php echo esc_attr( $field[ 'id' ] ); ?>-font-weight"
                        data-placeholder="<?php echo _x( 'Font Weight', 'options', DHT_PREFIX ) ?>"
                        data-standard-font-weights='<?php echo json_encode( $standard_font_weights ); ?>'>

                    <option></option>

                    <!--check if the saved font is a Google font-->
					<?php if( array_key_exists( $font_value, $google_font_weights ) ): ?>
						
						<?php foreach ( $google_font_weights[ $font_value ] as $google_font_weight_key => $google_font_weight_value ): ?>

                            <option
                                value="<?php echo esc_attr( $google_font_weight_key ); ?>"
								<?php echo $font_weight_value == $google_font_weight_key ? 'selected' : ''; ?>>
								<?php echo esc_html( $google_font_weight_value ); ?>
                            </option>
						
						<?php endforeach; ?>

                        <!--check if the saved font is a Divi font-->
					<?php elseif( array_key_exists( $font_value, $et_fonts ) ): ?>
						
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
                    for="<?php echo esc_attr( $field[ 'id' ] ); ?>-font-style"><?php echo _x( 'Font Style', 'options', DHT_PREFIX ) ?></label>

                <select class="dht-typography-style dht-field"
                        name="<?php echo esc_attr( $field[ 'id' ] ); ?>[font-style]"
                        id="<?php echo esc_attr( $field[ 'id' ] ); ?>-font-style"
                        data-placeholder="<?php echo _x( 'Font Style', 'options', DHT_PREFIX ) ?>">

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
                    for="<?php echo esc_attr( $field[ 'id' ] ); ?>-font-subsets"><?php echo _x( 'Font Subsets', 'options', DHT_PREFIX ) ?></label>

                <select class="dht-typography-subsets dht-field"
                        name="<?php echo esc_attr( $field[ 'id' ] ); ?>[font-subsets]"
                        id="<?php echo esc_attr( $field[ 'id' ] ); ?>-font-subsets"
                        data-placeholder="<?php echo _x( 'Font Subsets', 'options', DHT_PREFIX ) ?>">

                    <option></option>

                    <!--check if the saved font is a Google font-->
					<?php if( array_key_exists( $font_value, $google_font_subsets ) ): ?>
						
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
                    for="<?php echo esc_attr( $field[ 'id' ] ); ?>-text-transform"><?php echo _x( 'Text Transform', 'options', DHT_PREFIX ) ?></label>

                <select class="dht-typography-transform dht-field"
                        name="<?php echo esc_attr( $field[ 'id' ] ); ?>[text-transform]"
                        id="<?php echo esc_attr( $field[ 'id' ] ); ?>-text-transform"
                        data-placeholder="<?php echo _x( 'Text Transform', 'options', DHT_PREFIX ) ?>">

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
                    for="<?php echo esc_attr( $field[ 'id' ] ); ?>-text-decoration"><?php echo _x( 'Text Decoration', 'options', DHT_PREFIX ) ?></label>

                <select class="dht-typography-decoration dht-field"
                        name="<?php echo esc_attr( $field[ 'id' ] ); ?>[text-decoration]"
                        id="<?php echo esc_attr( $field[ 'id' ] ); ?>-text-decoration"
                        data-placeholder="<?php echo _x( 'Text Decoration', 'options', DHT_PREFIX ) ?>">

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
			
			<?php if( $field[ 'text-align' ] ): ?>
                <!--text align-->
                <div class="dht-field-child-typography-dropdown">

                    <label
                        for="<?php echo esc_attr( $field[ 'id' ] ); ?>-text-align"><?php echo _x( 'Text Align', 'options', DHT_PREFIX ) ?></label>

                    <select class="dht-typography-align dht-field"
                            name="<?php echo esc_attr( $field[ 'id' ] ); ?>[text-align]"
                            id="<?php echo esc_attr( $field[ 'id' ] ); ?>-text-align"
                            data-placeholder="<?php echo _x( 'Text Align', 'options', DHT_PREFIX ) ?>">

                        <option></option>
						
						<?php foreach ( $text_align as $text_align_val => $text_align_name ): ?>

                            <option
                                value="<?php echo esc_attr( $text_align_val ); ?>"
								<?php echo $text_align_value == $text_align_val ? 'selected' : ''; ?>>
								<?php echo esc_html( $text_align_name ); ?>
                            </option>
						
						<?php endforeach; ?>

                    </select>

                </div>
			<?php endif; ?>
			
			<?php if( $field[ 'font-size' ] ): ?>
                <!--font size-->
                <div class="dht-field-child-typography-dropdown">

                    <label
                        for="<?php echo esc_attr( $field[ 'id' ] ); ?>-font-size-value"><?php echo _x( 'Font Size', 'options', DHT_PREFIX ) ?></label>

                    <div class="dht-field-child-typography-fields dht-typography-font-size">

                        <input
                            class="dht-input dht-field"
                            id="<?php echo esc_attr( $field[ 'id' ] ); ?>-font-size-value"
                            type="number" min="0"
                            name="<?php echo esc_attr( $field[ 'id' ] ); ?>[font-size][value]"
                            value="<?php echo esc_html( $font_size_value[ 'value' ] ?? 0 ); ?>" />

                        <label
                            for="<?php echo esc_attr( $field[ 'id' ] ); ?>-font-size-size"></label>

                        <select class="dht-field"
                                name="<?php echo esc_attr( $field[ 'id' ] ); ?>[font-size][size]"
                                id="<?php echo esc_attr( $field[ 'id' ] ); ?>-font-size-size">
							
							<?php $cnt = 0;
							foreach ( apply_filters( 'dht:options:typography:units_dropdown_values', dht_fw_get_css_units() ) as $size_val => $size_name ): $cnt ++; ?>
								<?php $size = $font_size_value[ 'size' ] ?? ""; ?>
                                <option
                                    value="<?php echo esc_attr( $size_val ); ?>"
									<?php echo $size == $size_val ? 'selected' : ''; ?>>
									<?php echo esc_html( $size_name ); ?>
                                </option>
							
							<?php endforeach; ?>

                        </select>
                    </div>

                </div>
			<?php endif; ?>
			
			<?php if( $field[ 'line-height' ] ): ?>
                <!--line height-->
                <div class="dht-field-child-typography-dropdown">

                    <label
                        for="<?php echo esc_attr( $field[ 'id' ] ); ?>-line-height-value"><?php echo _x( 'Line Height', 'options', DHT_PREFIX ) ?></label>

                    <div class="dht-field-child-typography-fields dht-typography-line-height">

                        <input
                            class="dht-input dht-field"
                            id="<?php echo esc_attr( $field[ 'id' ] ); ?>-line-height-value"
                            type="number" min="0"
                            name="<?php echo esc_attr( $field[ 'id' ] ); ?>[line-height][value]"
                            value="<?php echo esc_html( $line_height_value[ 'value' ] ?? 0 ); ?>" />

                        <label
                            for="<?php echo esc_attr( $field[ 'id' ] ); ?>-line-height-size"></label>

                        <select class="dht-field"
                                name="<?php echo esc_attr( $field[ 'id' ] ); ?>[line-height][size]"
                                id="<?php echo esc_attr( $field[ 'id' ] ); ?>-line-height-size">
							
							<?php $cnt = 0;
							foreach ( apply_filters( 'dht:options:typography:units_dropdown_values', dht_fw_get_css_units() ) as $size_val => $size_name ): $cnt ++; ?>
								<?php $size = $line_height_value[ 'size' ] ?? ""; ?>
                                <option
                                    value="<?php echo esc_attr( $size_val ); ?>"
									<?php echo $size == $size_val ? 'selected' : ''; ?>>
									<?php echo esc_html( $size_name ); ?>
                                </option>
							
							<?php endforeach; ?>

                        </select>
                    </div>

                </div>
			<?php endif; ?>
			
			<?php if( $field[ 'letter-spacing' ] ): ?>
                <!--letter spacing-->
                <div class="dht-field-child-typography-dropdown">

                    <label
                        for="<?php echo esc_attr( $field[ 'id' ] ); ?>-letter-spacing-value"><?php echo _x( 'Letter Spacing', 'options', DHT_PREFIX ) ?></label>

                    <div class="dht-field-child-typography-fields dht-typography-letter-spacing">

                        <input
                            class="dht-input dht-field"
                            id="<?php echo esc_attr( $field[ 'id' ] ); ?>-letter-spacing-value"
                            type="number" min="0"
                            name="<?php echo esc_attr( $field[ 'id' ] ); ?>[letter-spacing][value]"
                            value="<?php echo esc_html( $letter_spacing_value[ 'value' ] ?? 0 ); ?>" />

                        <label
                            for="<?php echo esc_attr( $field[ 'id' ] ); ?>-letter-spacing-size"></label>

                        <select class="dht-field"
                                name="<?php echo esc_attr( $field[ 'id' ] ); ?>[letter-spacing][size]"
                                id="<?php echo esc_attr( $field[ 'id' ] ); ?>-letter-spacing-size">
							
							<?php $cnt = 0;
							foreach ( apply_filters( 'dht:options:typography:units_dropdown_values', dht_fw_get_css_units( [ "%" => false ] ) ) as $size_val => $size_name ): $cnt ++; ?>
								<?php $size = $letter_spacing_value[ 'size' ] ?? ""; ?>
                                <option
                                    value="<?php echo esc_attr( $size_val ); ?>"
									<?php echo $size == $size_val ? 'selected' : ''; ?>>
									<?php echo esc_html( $size_name ); ?>
                                </option>
							
							<?php endforeach; ?>

                        </select>
                    </div>

                </div>
			<?php endif; ?>

        </div>
		
		<?php if( $field[ 'color' ] ): ?>
            <!--text color-->
            <div class="dht-field-child-typography-colorpicker">

                <label
                    for="<?php echo esc_attr( $field[ 'id' ] ); ?>-color"><?php echo _x( 'Text Color', 'options', DHT_PREFIX ) ?></label>

                <input
                    class="dht-colorpicker dht-field"
                    id="<?php echo esc_attr( $field[ 'id' ] ); ?>-color"
                    type="text"
                    data-alpha="false" data-alpha-enabled="false"
                    name="<?php echo esc_attr( $field[ 'id' ] ); ?>[color]"
                    value="<?php echo esc_html( $text_color_value ); ?>"
                    data-palette='<?php //echo !empty( $field[ 'palettes' ] ) ? json_encode( $field[ 'palettes' ] ) : ''; ?>' />

                <input type="button" id="<?php echo esc_attr( $field[ 'id' ] ) . '-btn'; ?>"
                       class="dht-default-color-btn button button-small"
                       data-default-value="<?php echo esc_html( $text_color_value ); ?>"
                       value="<?php echo _x( 'Default', 'options', DHT_PREFIX ) ?>">

            </div>
		<?php endif; ?>
		
		<?php if( !empty( $field[ 'description' ] ) ): ?>
            <div class="dht-description"><?php echo esc_html( $field[ 'description' ] ); ?></div>
		<?php endif; ?>

    </div>
	
	<?php if( !empty( $field[ 'tooltip' ] ) ): ?>
        <div class="dht-info-help dashicons dashicons-info">
            <div class="dht-tooltips"><p class="OnLeft"><?php echo esc_html( $field[ 'tooltip' ] ); ?></p></div>
        </div>
	<?php endif; ?>

</div>

<?php if( isset( $field[ 'divider' ] ) && $field[ 'divider' ] ): ?>
    <div class="dht-divider"></div>
<?php endif; ?>

<?php do_action( 'dht:options:view:fields:typography_after_area' ); ?>
