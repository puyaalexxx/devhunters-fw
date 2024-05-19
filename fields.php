<!-- field - typography -->
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
                var fontWeights = {}; // Object to store font weights

                //include the font link for preview
                //const fontLink = 'https://fonts.googleapis.com/css?family=' + font_family.replace(/\s+/g, '+');
                var fontLink = "https://fonts.gstatic.com/s/abeezee/v22/esDT31xSG-6AGleN2tCklZUCGpG-GQ.ttf";
                $("<link href=\"" + fontLink + "\" rel=\"stylesheet\">").appendTo("head");

                //add Google font - font weights
                $font_weight_dropdown.empty();
                // Filter font weights for selected font
                $.each(fontWeights[font_family], function(index, weight) {
                    console.log(weight);

                    $font_weight_dropdown.append("<option value=\"" + weight + "\">" + weight + "</option>");
                });

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
    });
</script>

<?php
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
$standard_font_weight = [
    '300' => 'Light',
    '400' => 'Regular',
    '600' => 'Semi Bold',
    '700' => 'Bold',
    '800' => 'Ultra Bold'
];

//prepopulated from Google Fonts
$font_weight = [];

$font_weight = empty( $font_weight ) ? $standard_font_weight : $font_weight;

//fonts styles
$standard_font_style = [
    'normal' => 'Normal',
    'italic' => 'Italic',
    'oblique' => 'Oblique'
];

//prepopulated from Google Fonts
$font_style = [];

$font_style = empty( $font_style ) ? $standard_font_style : $font_style;
?>

<div class="dht-field-wrapper">
    <div class="dht-title">Typography</div>
    <div class="dht-field-child-wrapper dht-field-child-typography">

        <p class="dht-field-child-typography-preview">
            1 2 3 4 5 6 7 8 9 0 A B C D E F G H I J K L M N O P Q R S T U V W X Y Z a b c d e f g h i j k l m n o p q r
            s t u v w x y z
        </p>

        <div class="dht-field-child-typography-group">

            <div class="dht-field-child-typography-dropdown">
                <label for="cars3">Font Family</label>
                <select class="dht-typography dht-field" name="fonts" id="cars3" data-placeholder="Font family">
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
                            <option value='<?php echo esc_attr( $font[ 'family' ] ); ?>'
                                    data-google-font="yes"><?php echo esc_html( $font[ 'family' ] ); ?></option>
                        <?php endforeach; ?>
                    </optgroup>
                </select>
            </div>

            <div class="dht-field-child-typography-dropdown">
                <label for="aaaa">Font Weight</label>
                <select class="dht-typography-weight dht-field" name="cars" id="aaaa" data-placeholder="Font Weight">
                    <option></option>

                    <?php foreach ( $font_weight as $font_weight_value => $font_weight_name ): ?>
                        <option
                            value="<?php echo esc_attr( $font_weight_value ); ?>"><?php echo esc_html( $font_weight_name ); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="dht-field-child-typography-dropdown">
                <label for="ccc">Font Style</label>
                <select class="dht-typography-style dht-field" name="cars" id="ccc" data-placeholder="Font Style">
                    <option></option>

                    <?php foreach ( $font_style as $font_style_value => $font_style_name ): ?>
                        <option
                            value="<?php echo esc_attr( $font_style_value ); ?>"><?php echo esc_html( $font_style_name ); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="dht-field-child-typography-dropdown">
                <label for="bbbb">Font Subsets</label>
                <select class="dht-typography-subsets dht-field" name="cars" id="bbbb" data-placeholder="Font Subsets">
                    <option></option>
                </select>
            </div>
        </div>

        <div class="dht-description">Field description</div>
    </div>
    <div class="dht-info-help dashicons dashicons-info"
         data-tooltips="A little box to something to make it longer"
         data-position="OnLeft">
    </div>
</div>
<div class="dht-divider"></div>

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


<!-------------------------------------------------------------------------------------->
<!-------------------------------------------------------------------------------------->
<!-------------------------------------------------------------------------------------->
<!-------------------------------------------------------------------------------------->
<!-------------------------------------------------------------------------------------->
<!-------------------------------------------------------------------------------------->
<!-------------------------------------------------------------------------------------->


<!-- field - group -->
<div class="dht-field-wrapper">
    <div class="dht-title">Group Fields</div>
    <div class="dht-field-child-wrapper dht-field-child-groups">

        <div class="dht-field-child-group">
            <label for="test-input">Group Fields</label>
            <input class="dht-input dht-field" id="test-input111" type="text" name="group[group_name][]" value=""
                   title="title" />
            <div class="dht-description">Field description</div>
        </div>

        <div class="dht-field-child-group">
            <label for="test-input">Disabled</label>
            <input class="dht-input dht-field" id="test-input111" type="text" name="group[group_name][]" value=""
                   title="title" />
            <div class="dht-description">Field description</div>
        </div>

        <div class="dht-field-child-group">
            <label for="cars4">Choose cars:</label>
            <select class="dht-dropdown dht-field" name="group[group_name][]" id="cars4" multiple size="6">
                <optgroup label="Swedish Cars">
                    <option value="volvo">Volvo</option>
                    <option value="saab">Saab</option>
                </optgroup>
                <optgroup label="German Cars">
                    <option value="mercedes">Mercedes</option>
                    <option value="audi">Audi</option>
                </optgroup>
            </select>
            <div class="dht-description">Field description</div>
        </div>

        <div class="dht-description">Group description</div>
    </div>

    <div class="dht-info-help dashicons dashicons-info"
         data-tooltips="A little box to something to make it longer"
         data-position="OnLeft">
    </div>
</div>
<div class="dht-divider"></div>

<style>
    /* group options fields */
    .dht-wrapper .dht-field-child-groups .dht-field-child-group {
        margin-bottom: 20px;
    }
</style>

<!-------------------------------------------------------------------------------------->

<!-- field - tabs -->
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

<div class="dht-field-wrapper">
    <div class="dht-title">Tabs</div>
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


        <div class="dht-description">Field description</div>
    </div>
</div>

<div class="dht-divider"></div>

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

<!-------------------------------------------------------------------------------------->

<!-- field - accordion -->

<script>

    jQuery(document).ready(function($) {
        //create accordion
        $(".dht-wrapper").on("click", ".dht-field-child-accordion .dht-accordion .dht-accordion-title", function(e) {
            e.preventDefault();

            const $this = $(this);

            if ($this.hasClass("dht-accordion-active")) return;

            const $parent = $this.parents(".dht-accordion");

            if (!$this.hasClass("dht-accordion-active")) {
                $parent.find(".dht-accordion-content").slideUp(400);
                $parent.find(".dht-accordion-title").removeClass("dht-accordion-active");
                $parent.find(".dht-accordion-arrow").removeClass("dht-accordion-icon-change");
            }

            $this.toggleClass("dht-accordion-active");
            $this.next().slideToggle();
            $(".dht-accordion-arrow", this).toggleClass("dht-accordion-icon-change");
        });

        //add new toggle in your accordion
        $(".dht-field-child-accordion .dht-accordion-repeater .dht-add-toggle").on("click", function(e) {
            e.preventDefault();

            const $this = $(this);

            let $toggle = $this.prev(".dht-accordion-item").clone();

            //if toggle opened, close it
            $toggle.children(".dht-accordion-title").removeClass("dht-accordion-active");
            $toggle.children(".dht-accordion-title").children(".dht-accordion-arrow").removeClass("dht-accordion-icon-change");
            $toggle.children(".dht-accordion-content").hide();

            //clear inout values
            dhtClearFormInputs($toggle);

            $toggle.insertBefore($this);
        });

        //remove toggle item
        $(".dht-wrapper").on("click", ".dht-field-child-accordion .dht-accordion-repeater .dht-btn-remove", function(e) {
            e.preventDefault();

            const $this = $(this);
            const $main_parent = $this.parents(".dht-accordion-repeater");

            if ($main_parent.children(".dht-accordion-item").length === 1) {
                confirm($main_parent.find(".dht-toggle-remove-text").text());

                return;
            }

            $this.parents(".dht-accordion-item").remove();

            return false;
        });

        // Function to clear form inputs
        function dhtClearFormInputs(content) {
            content.find("input[type=\"text\"], input[type=\"email\"], textarea").val("");
            content.find("input[type=\"checkbox\"], input[type=\"radio\"]").prop("checked", false);
        }
    });
</script>

<!-- field - accordion -> type - repeater -->

<div class="dht-field-wrapper">
    <div class="dht-title">Repeater</div>
    <div class="dht-field-child-wrapper dht-field-child-accordion">

        <div class="dht-accordion dht-accordion-repeater">
            <div class="dht-accordion-item">
                <div class="dht-accordion-title">
                    <div class="dht-accordion-arrow">
                        <span class="dht-accordion-arrow-item dashicons dashicons-plus-alt"></span>
                        <span class="dht-accordion-arrow-item-close dashicons dashicons-dismiss"></span>
                    </div>
                    <span class="dht-accordion-title-text">Title 1</span>
                </div>
                <div class="dht-accordion-content">

                    <div class="dht-field-wrapper">
                        <div class="dht-title">Textarea</div>
                        <div class="dht-field-child-wrapper dht-field-child-textarea">
                            <label for="textarea">Textarea</label>
                            <textarea class="dht-textarea dht-field" id="textarea" name="textarea"
                                      placeholder="Textarea"
                                      rows="6"></textarea>
                            <div class="dht-description">Field description</div>
                        </div>
                    </div>

                    <div class="dht-divider"></div>

                    <div class="dht-field-wrapper">
                        <div class="dht-title">Radio Boxes</div>
                        <div class="dht-field-child-wrapper dht-field-child-radio">

                            <div class="dht-radio-wrapper">
                                <input class="dht-radio dht-field" type="radio" name="radio[]" id="radio-1" value="1"
                                       checked="checked" />
                                <label for="radio-1">Option 1</label>
                            </div>

                            <div class="dht-radio-wrapper">
                                <input class="dht-radio dht-field" type="radio" name="radio[]" id="radio-2" value="2" />
                                <label for="radio-2">Option 2</label>
                            </div>

                            <div class="dht-radio-wrapper">
                                <input class="dht-radio dht-field" type="radio" name="radio[]" id="radio-3" value="3" />
                                <label for="radio-3">Option 3</label>
                            </div>

                            <div class="dht-description">Field description</div>
                        </div>

                    </div>

                    <div class="dht-remove-toggle">
                        <div class="dht-divider"></div>

                        <a href="" class="button button-primary dht-btn-remove">Remove Icon</a>
                    </div>

                </div>
            </div>

            <a href="" class="button button-primary dht-add-toggle">Add</a>
            <div class="dht-toggle-remove-text">Can't remove the only item</div>
        </div>

        <div class="dht-description">Field description</div>
    </div>
    <div class="dht-info-help dashicons dashicons-info"
         data-tooltips="A little box to something to make it longer"
         data-position="OnLeft">
    </div>
</div>
<div class="dht-divider"></div>

<!-- field - accordion -->

<div class="dht-field-wrapper">
    <div class="dht-title">Accordion</div>
    <div class="dht-field-child-wrapper dht-field-child-accordion">

        <div class="dht-accordion">
            <div class="dht-accordion-item">
                <div class="dht-accordion-title">
                    <div class="dht-accordion-arrow">
                        <span class="dht-accordion-arrow-item dashicons dashicons-plus-alt"></span>
                        <span class="dht-accordion-arrow-item-close dashicons dashicons-dismiss"></span>
                    </div>
                    <span class="dht-accordion-title-text">Title 1</span>
                </div>
                <div class="dht-accordion-content">

                    <div class="dht-field-wrapper">
                        <div class="dht-title">Textarea</div>
                        <div class="dht-field-child-wrapper dht-field-child-textarea">
                            <label for="textarea">Textarea</label>
                            <textarea class="dht-textarea dht-field" id="textarea" name="textarea"
                                      placeholder="Textarea"
                                      rows="6"></textarea>
                            <div class="dht-description">Field description</div>
                        </div>
                    </div>

                    <div class="dht-divider"></div>

                    <div class="dht-field-wrapper">
                        <div class="dht-title">Radio Boxes</div>
                        <div class="dht-field-child-wrapper dht-field-child-radio">

                            <div class="dht-radio-wrapper">
                                <input class="dht-radio dht-field" type="radio" name="radio[]" id="radio-1" value="1"
                                       checked="checked" />
                                <label for="radio-1">Option 1</label>
                            </div>

                            <div class="dht-radio-wrapper">
                                <input class="dht-radio dht-field" type="radio" name="radio[]" id="radio-2" value="2" />
                                <label for="radio-2">Option 2</label>
                            </div>

                            <div class="dht-radio-wrapper">
                                <input class="dht-radio dht-field" type="radio" name="radio[]" id="radio-3" value="3" />
                                <label for="radio-3">Option 3</label>
                            </div>

                            <div class="dht-description">Field description</div>
                        </div>

                    </div>

                    <style>
                        /*radio styles*/
                        .dht-wrapper .dht-field-child-radio .dht-radio:first-child {
                            margin-top: 0px;
                        }

                        .dht-wrapper .dht-field-child-radio .dht-radio {
                            margin-top: 10px;
                        }

                        .dht-wrapper .dht-field-child-radio .dht-radio-wrapper .dht-radio {
                            float: left;
                        }

                        .dht-wrapper .dht-field-child-radio .dht-radio-wrapper label {
                            display: block;
                        }

                        .dht-wrapper .dht-field-child-radio .dht-radio-wrapper {
                            clear: both;
                        }

                        .dht-wrapper .dht-field-child-radio .dht-radio-wrapper {
                            margin-bottom: 10px;
                        }

                        .dht-wrapper .dht-field-child-radio .dht-radio-wrapper:last-child {
                            margin-bottom: 0px;
                        }

                        .dht-wrapper .dht-field-child-radio .dht-radio {
                            width: auto;
                        }
                    </style>

                </div>
            </div>
            <div class="dht-accordion-item">
                <div class="dht-accordion-title">
                    <div class="dht-accordion-arrow">
                        <span class="dht-accordion-arrow-item dashicons dashicons-plus-alt"></span>
                        <span class="dht-accordion-arrow-item-close dashicons dashicons-dismiss"></span>
                    </div>
                    <span class="dht-accordion-title-text">Title 2</span>
                </div>
                <div class="dht-accordion-content">
                    Content
                </div>
            </div>

        </div>

        <div class="dht-description">Field description</div>
    </div>
    <div class="dht-info-help dashicons dashicons-info"
         data-tooltips="A little box to something to make it longer"
         data-position="OnLeft">
    </div>
</div>
<div class="dht-divider"></div>

<style>
    .dht-wrapper .dht-field-child-accordion .dht-accordion-item {
        margin: 5px auto;
    }

    .dht-wrapper .dht-field-child-accordion .dht-accordion-item .dht-accordion-title {
        position: relative;
        display: block;
        padding: 20px 60px 15px 20px;
        margin-bottom: 2px;
        color: #202020;
        font-size: 20px;
        text-decoration: none;
        background-color: #eaeaea;
        border-radius: 3px;
        -webkit-transition: background-color 0.2s;
        transition: background-color 0.2s;
        cursor: pointer;
        text-transform: uppercase;
    }

    .dht-wrapper .dht-field-child-accordion.dht-accordion-item .dht-accordion-title:hover {
        background-color: #e5e4e4;
        transition: all 0.5s ease-out;
    }

    .dht-wrapper .dht-field-child-accordion .dht-accordion-item .dht-accordion-active {
        background-color: #e5e4e4;
    }

    .dht-wrapper .dht-field-child-accordion .dht-accordion-item .dht-accordion-title .dht-accordion-arrow {
        position: absolute;
        top: 13px;
        right: 15px;
        display: inline-block;
        vertical-align: middle;
        text-align: center;
        -webkit-transition: all 0.2s ease-out;
        transition: all 0.2s ease-out;
    }

    .dht-wrapper .dht-field-child-accordion .dht-accordion-item .dht-accordion-content {
        padding: 30px;
        margin-bottom: 2px;
        font-size: 14px;
        display: none;
        background-color: #f3f3f3;
    }

    .dht-wrapper .dht-field-child-accordion .dht-accordion-item .dht-accordion-arrow-item,
    .dht-wrapper .dht-field-child-accordion .dht-accordion-item .dht-accordion-arrow-item-close {
        top: 3px;
        position: relative;
        font-size: 25px !important;
    }

    .dht-wrapper .dht-field-child-accordion .dht-accordion-arrow .dht-accordion-arrow-item-close,
    .dht-wrapper .dht-field-child-accordion .dht-accordion-arrow.dht-accordion-icon-change .dht-accordion-arrow-item {
        display: none;
    }

    .dht-wrapper .dht-field-child-accordion .dht-accordion-arrow.dht-accordion-icon-change .dht-accordion-arrow-item-close {
        display: block;
    }

    .dht-wrapper .dht-field-child-accordion .dht-accordion .dht-field-wrapper {
        display: block;
        padding: 0;
    }

    .dht-wrapper .dht-field-child-accordion .dht-accordion .dht-divider {
        margin: 20px 0;
    }

    .dht-wrapper .dht-field-child-accordion .dht-accordion .dht-field-wrapper .dht-title {
        margin-bottom: 10px;
    }

    .dht-wrapper .dht-field-child-accordion .dht-add-toggle {
        margin-top: 5px;
        float: right;
    }

    .dht-wrapper .dht-field-child-accordion .dht-accordion-content:after {
        content: "";
        clear: both;
        display: table;
    }

    .dht-wrapper .dht-field-child-accordion .button.button-primary.dht-btn-remove {
        background: red;
        border-color: red;
        float: right;
    }

    .dht-wrapper .dht-field-child-accordion .dht-toggle-remove-text {
        display: none;
    }
</style>


<!-------------------------------------------------------------------------------------->

<!----conditional option type----------------->

<!----addable popup option type----------------->