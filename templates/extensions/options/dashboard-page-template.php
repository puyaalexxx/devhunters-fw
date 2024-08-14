<?php

$args = $args ?? [];
?>

<script>
    jQuery(function($) {

        $(".cosidebar >ul >li:not(.line)").hover(function() {
            if (!$(".sub-menu:visible", this).length) {
                $(".dropdown-menu", this).show();
                $(this).addClass("hover");
            }
        }, function() {
            $(".dropdown-menu", this).hide();
            $(this).removeClass("hover");
        });

        $("[dropdown] >li").hover(function() {
            $("ul", this).show();
            $(this).addClass("active");
        }, function() {
            $("ul", this).hide();
            $(this).removeClass("active");
        });

        $(".cosidebar >ul >li").each(function() {
            if ($(".sub-menu", this).length) {
                const html = $(".sub-menu", this).html();
                $(this).append("<ul dropdown class=\"dropdown-menu\">" + html + "</ul>");
            }
        });
    });

</script>
<style>
    .cosidebar a {
        text-decoration: none;
    }

    .cosidebar a:hover {
        text-decoration: none;
    }

    .cosidebar :focus {
        outline: 0;
        box-shadow: none !important;
    }

    .cosidebar {
        width: 160px;
        background: #1D2327;
        box-sizing: border-box;
        padding-top: 12px;
        float: left;
        position: relative;
        z-index: 20;
    }

    .cosidebar > ul > li {
        position: relative;
    }

    .cosidebar > ul > li > a {
        display: block;
        line-height: 35px;
        color: #eee;
        font-size: 14px;
    }

    .cosidebar > ul > li > a .fa {
        color: #9ca1a6;
        width: 30px;
        text-align: center;
        font-size: 16px;
        position: relative;
        top: 1px;
    }

    .cosidebar > ul > li > a:hover {
        background-color: #191e23;
        color: #72aee6;
    }

    .cosidebar > ul > li > a:hover span {
        color: #72aee6;
    }

    .cosidebar > ul > li.hover {
        background-color: #191e23;
        color: #72aee6;
    }

    .cosidebar > ul > li.hover span {
        color: #72aee6;
    }

    .cosidebar > ul > li.active .sub-menu {
        display: block;
    }

    .cosidebar > ul > li.active > a {
        background-color: #2271b1;
        color: #fff;
        position: relative;
    }

    .cosidebar > ul > li > a:hover {
        box-shadow: inset 4px 0 0 0 #72aee6;
        transition: box-shadow .1s linear;
    }

    .cosidebar > ul > li.active > a:hover {
        box-shadow: inset 4px 0 0 0 #fff;
        transition: box-shadow .1s linear;
    }

    .cosidebar > ul > li.active > a:before {
        content: "";
        border: 8px solid transparent;
        border-right-color: #f1f1f1;
        position: absolute;
        top: 50%;
        margin-top: -8px;
        right: 0;
    }

    .cosidebar > ul > li.active > a span {
        color: #fff;
    }

    .cosidebar > ul > li.line {
        line-height: 10px;
        padding-bottom: 10px;
    }

    .cosidebar > ul > li.line span {
        height: 1px;
        background-color: rgba(255, 255, 255, 0.1);
        display: inline-block;
        width: 100%;
    }

    .cosidebar > ul > li .dropdown-menu {
        display: none;
        position: absolute;
        top: 0;
        left: 160px;
        width: 160px;
        background-color: #32373c;
        padding: 10px 15px;
        box-shadow: 2px 2px 7px rgba(0, 0, 0, 0.40);
    }

    .cosidebar > ul > li .dropdown-menu:before {
        content: "";
        border: 8px solid transparent;
        border-right-color: #32373c;
        position: absolute;
        top: 11px;
        left: -16px;
    }

    .cosidebar > ul > li .dropdown-menu li a {
        display: block;
        line-height: 30px;
        font-size: 14px;
        color: #b4b9be;
    }

    .cosidebar > ul > li .dropdown-menu li a:hover {
        color: #fff;
    }

    .cosidebar > ul .sub-menu {
        padding: 7px 15px;
        background-color: #32373c;
        display: none;
    }

    .cosidebar > ul .sub-menu li a {
        display: block;
        line-height: 30px;
        font-size: 13px;
        color: #eee;
    }

    .cosidebar > ul .sub-menu li a:hover {
        color: #72aee6;
    }

    .cosidebar > ul .sub-menu li.active a {
        font-weight: bold;
        color: #fff;
    }

    .cosidebar.fix {
        width: 50px;
    }

    .cosidebar.fix .title {
        display: none;
    }

    .cosidebar .title {
        position: relative;
    }

    .cosidebar.fix .fa {
        width: 50px;
        font-size: 20px;
        text-indent: -3px;
    }

    .cosidebar.fix > ul > li > a {
        padding: 5px 0;
    }

    .cosidebar.fix > ul > li .dropdown-menu {
        left: 50px;
    }

    .cosidebar.fix > ul > li .dropdown-menu:before {
        top: 15px;
    }

    @media all and (max-width: 900px) {

        .conavbar > ul > li > a {
            line-height: 50px;
            font-size: 22px;
        }

        .conavbar > ul > li > a .fa {
            font-size: 25px;
        }

        .conavbar > ul > li > a .title {
            display: none;
        }

        .conavbar > ul > li ul {
            top: 50px;
        }

        .cosidebar {
            height: calc(100% - 50px);
            height: -webkit-calc(100% - 50px);
        }

        .cosidebar {
            width: 50px !important;
        }

        .cosidebar .title {
            display: none !important;
        }

        .cosidebar .fa {
            width: 50px !important;
            font-size: 20px !important;
            text-indent: -3px !important;
        }

        .cosidebar > ul > li > a {
            padding: 5px 0 !important;
        }

        .cosidebar > ul > li .sub-menu {
            display: none !important;
        }

        .cosidebar > ul > li .dropdown-menu {
            left: 50px !important;
        }

        .cosidebar > ul > li .dropdown-menu:before {
            top: 15px !important;
        }
    }

</style>
<form action="" method="post" enctype="multipart/form-data">

    <?php wp_nonce_field( $args[ 'nonce' ][ 'action' ], $args[ 'nonce' ][ 'name' ] ); ?>

    <div class="dht-field-wrapper-main">
        <button class="dht-button dht-btn-big dht-submit">
            <span><?php echo _x( 'Save Changes', 'options', DHT_PREFIX ) ?></span></button>
    </div>

    <div class="dht-divider"></div>

    <!-------------------------------------------------------------------------------------->

    <div class="dht-container-form">

        <div class="cosidebar">
            <ul>
                <li>
                    <a href="index.html">
                        <span class="fa fa-tachometer"></span>
                        <span class="title">
        General Settings
        </span>
                    </a>
                </li>
                <li class="active">
                    <a href="#">
                        <span class="fa fa-thumb-tack"></span>
                        <span class="title">
        Posts
                    </span>
                    </a>
                    <ul class="sub-menu">
                        <li class="active">
                            <a href="posts.html">
                                All Posts
                            </a>
                        </li>
                        <li>
                            <a href="new-post.html">
                                Add New
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Categories
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Tags
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#">
                        <span class="fa fa-plug"></span>
                        <span class="title">
        Plugins
                </span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a href="#">
                                Installed Plugins
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Add New
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Editor
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#">
                        <span class="fa fa-wrench"></span>
                        <span class="title">
        Tools
                </span>
                    </a>
                </li>
            </ul>

        </div>

        <!--this wrapper will be used for ajax to load content inside-->
        <div class="dht-container-options">

            <?php if ( !empty( $args[ 'options' ] ) ): ?>

                <?php echo do_shortcode( $args[ 'options' ] ); ?>

            <?php else: ?>

                <?php echo _x( 'No options provided', 'options', DHT_PREFIX ); ?>

            <?php endif; ?>

        </div>
    </div>

    <!-------------------------------------------------------------------------------------->
    <div class="dht-divider"></div>
    <div class="dht-field-wrapper-main">
        <button class="dht-button dht-btn-big dht-submit">
            <span><?php echo _x( 'Save Changes', 'options', DHT_PREFIX ) ?></span></button>
    </div>

</form>
