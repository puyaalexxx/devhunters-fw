<?php

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

$group = $args[ 'group' ] ?? [];
//used to call the render method on
$registered_options = $args[ 'registered_options' ] ?? [];
?>
<!-- field - addable box -->

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

<?php if ( isset( $group[ 'divider' ] ) && $group[ 'divider' ] ): ?>
    <div class="dht-divider"></div>
<?php endif; ?>

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