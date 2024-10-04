/******************************************
 *
 *   Modalbox v1.2 - jQuery
 *
 ******************************************/
(function($) {
    let pluginName = "myOwnDialog";

    let d = 0;

    let initModal = function(data) {
        let modal_box = "rest";
        let modal_x = 0;
        let modal_y = 0;
        let modal_box_left = 0;
        let modal_box_top = 0;
        let modal_box_width = 0;
        let modal_box_height = 0;
        let modal_box_new_left = 0;
        let modal_box_new_top = 0;

        let modal_box_bottom_from_top = 0;
        let modal_box_bottom_dust = 0;

        let modal_box_right_from_left = 0;
        let modal_box_right_dust = 0;


        let dialog_resize = $(this).attr("data-dialogResizable");
        let dialog_move = $(this).attr("data-dialogMovable");
        let dialog_touch_outside_close = $(this).attr("data-dialogTouchOutsideForClose");
        let dialog_paddingDefault = 4 * 2;
        let dialog_header_height = $(this).find(".dht-vb-modal-header").outerHeight() + dialog_paddingDefault;
        let dialog_resizing_height = 0;
        let dialog_resizing_height_tmp = 0;
        let dialog_header_width = 142;
        let dialog_resizing_width = 0;
        let dialog_resizing_width_tmp = 0;

        let $moDialog = $(this);
        let $moDialogHeader = $(this).children(".dht-vb-modal-header");
        let $moDialogContent = $(this).children(".dht-vb-modal-content");
        let $moDialogFooter = $(this).children(".dht-vb-modal-footer");

        function closeModal() {
            if (typeof data.settings.beforeCloseCallback === "function") {
                if (data.settings.beforeCloseCallback) {
                    data.settings.beforeCloseCallback();
                    $moDialog.fadeOut("400", function() {
                        if (typeof data.settings.afterClosedCallback === "function") {
                            if (data.settings.afterClosedCallback) {
                                data.settings.afterClosedCallback();
                            }
                        }
                    });

                }
            } else {
                $moDialog.fadeOut();
            }
        }

        if (dialog_touch_outside_close === "true") {
            $(document).on("mouseup", function(e) {
                if (modal_box === "rest" && !$moDialog.is(e.target) && $moDialog.has(e.target).length === 0) {
                    closeModal();
                }
            });
        }

        $(this).find(".dht-vb-modal-close").on("click", function() {
            closeModal();
        });

        if (dialog_move === "true") {
            $(this).find(".dht-vb-modal-header").on("mousedown", function(e) {
                if (modal_box === "rest") {
                    modal_x = e.pageX;
                    modal_y = e.pageY;
                    modal_box_left = $moDialog.position().left;
                    modal_box_top = $moDialog.position().top;
                    modal_box_width = $moDialog.width();
                    modal_box_height = $moDialog.height();
                    modal_box_new_left = e.pageX - modal_box_left;
                    modal_box_new_top = e.pageY - modal_box_top;
                }
                modal_box = "move";
            });
        }
        if (dialog_resize === "true") {
            $(this).find(".dht-vb-modal-resize").on("mousedown", function(e) {
                if (modal_box === "rest") {
                    modal_x = e.pageX;
                    modal_y = e.pageY;
                    modal_box_left = $moDialog.position().left;
                    modal_box_top = $moDialog.position().top;
                    modal_box_width = $moDialog.width();
                    modal_box_height = $moDialog.height();
                    modal_box_new_left = e.pageX - modal_box_left;
                    modal_box_new_top = e.pageY - modal_box_top;

                    modal_box_bottom_from_top = modal_box_top + modal_box_height;
                    modal_box_bottom_dust = modal_box_bottom_from_top - modal_y;
                    modal_box_right_from_left = modal_box_left + modal_box_width;
                    modal_box_right_dust = modal_box_right_from_left - modal_x;

                }
                modal_box = "bottom_right_resize";
            });
        }

        $(this).on("mouseup", function() {
            modal_box = "rest";
            $(document).css(
                {
                    "cursor": "default",
                });
        });
        $(document).on("mouseup", function() {
            modal_box = "rest";
            $(document).css(
                {
                    "cursor": "default",
                });
        });
        $(document).on("mousemove", function(e) {
            if (modal_box === "move") {
                $moDialog.css(
                    {
                        "left": (e.pageX - modal_box_new_left) + "px",
                        "top": (e.pageY - modal_box_new_top) + "px",

                    });
                $(document).css(
                    {
                        "cursor": "move",
                    });
            } else if (modal_box === "bottom_right_resize") {
                dialog_resizing_height_tmp = (e.pageY - modal_box_top + modal_box_bottom_dust);
                dialog_resizing_height = (dialog_resizing_height_tmp > dialog_header_height) ? dialog_resizing_height_tmp : dialog_header_height;
                dialog_resizing_width_tmp = (e.pageX - modal_box_left + modal_box_right_dust);
                dialog_resizing_width = (dialog_resizing_width_tmp > dialog_header_width) ? dialog_resizing_width_tmp : dialog_header_width;
                let paddingTop = parseInt($moDialogContent.css("padding-top"));
                let paddingBottom = parseInt($moDialogContent.css("padding-bottom"));
                $moDialog.css(
                    {
                        "width": dialog_resizing_width + "px",
                        // "height": dialog_resizing_height + "px",
                    });
                $moDialogContent.css(
                    {
                        // "width": dialog_resizing_width + "px",
                        "height": (dialog_resizing_height - $moDialogHeader.outerHeight() - $moDialogFooter.outerHeight() - paddingTop - paddingBottom) + "px",
                    });
                $(document).css(
                    {
                        "cursor": "se-resize",
                    });
            }
        });
    };

    let openModal = function(data) {
        let dialog_id = $(this).attr("data-dialogId");
        let $this = $(this);
        let dialog_auto_close = $(this).attr("data-dialogAutoClose");

        $(this).fadeIn(400, function() {
            if (typeof data.settings.afterOpenedCallback === "function") {
                if (data.settings.afterOpenedCallback) {
                    data.settings.afterOpenedCallback();
                }
            }
        });

        if (dialog_auto_close !== "false") {
            setTimeout(function() {
                closeModal.call($this, data);
            }, dialog_auto_close);
        }
    };

    let closeModal = function(data) {
        let dialog_id = $(this).attr("data-dialogId");
    };

    let methods =
        {
            init: function(options) {
                //"this" is a jquery object on which this plugin has been invoked.
                return this.each(function(index) {
                    d += 1;
                    let window_w = $(window).width();
                    let window_h = $(window).height();
                    let $this = $(this);
                    let $moDialog = $(this);
                    let data = $this.data(pluginName);
                    // If the plugin hasn't been initialized yet
                    if (!data) {
                        let settings =
                            {
                                autoClose: false,
                                pos_x: "empty",
                                pos_y: "empty",
                                movable: true,
                                resizable: true,
                                touchOutsideForClose: false,
                                beforeOpenCallback: false,
                                afterOpenedCallback: false,
                                beforeCloseCallback: false,
                                afterClosedCallback: false,
                            };

                        if (options) {
                            $.extend(true, settings, options);
                        }

                        if (settings.pos_x === "empty") {
                            settings.pos_x = (window_w - settings.width) / 2;
                        }
                        if (settings.pos_y === "empty") {
                            settings.pos_y = (window_h - settings.height) / 2;
                        }
                        let innerBody = $moDialog.html();
                        $moDialog.attr("data-dialogId", d);
                        $moDialog.attr("data-dialogResizable", settings.resizable);
                        $moDialog.attr("data-dialogMovable", settings.movable);
                        $moDialog.attr("data-dialogAutoClose", settings.autoClose);
                        $moDialog.attr("data-dialogTouchOutsideForClose", settings.touchOutsideForClose);

                        $(this).css(
                            {
                                "position": "fixed",
                                "z-index": "999",
                                "display": "none",
                                "left": settings.pos_x + "px",
                                "top": settings.pos_y + "px",
                            });

                        $this.data(pluginName,
                            {
                                target: $this,
                                settings: settings,
                            });

                        var $this2 = $(this);
                        var data2 = $this.data(pluginName);

                        initModal.call($this2, data2);
                    }
                });
            },
            open: function() {
                return this.each(function(index) {
                    var $this = $(this);
                    var data = $this.data(pluginName);
                    // response callback

                    if (typeof data.settings.beforeOpenCallback === "function") {
                        if (data.settings.beforeOpenCallback) {
                            data.settings.beforeOpenCallback();
                            openModal.call($this, data);
                        }
                    } else {
                        openModal.call($this, data);
                    }
                });
            },
            close: function() {
                return this.each(function(index) {
                    var $this = $(this);
                    var data = $this.data(pluginName);
                    closeModal.call($this, data);
                });
            },
            destroy: function() {
                return this.each(function(index) {
                    var $this = $(this);
                    var data = $this.data(pluginName);
                    $this.removeData();
                });
            },
        };

    $.fn[pluginName] = function(method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === "object" || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error("Method " + method + " does not exist in jQuery." + pluginName);
        }
    };
}(jQuery));
