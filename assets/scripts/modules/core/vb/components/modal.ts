/**
 * Modal HTML Code
 *
 * Call this method first to append the modal HTML
 * to the specified container selector
 *
 * @param modalID
 * @param appendTo Container selector where the modal should be appended
 * @param modalTitle
 *
 * @return void
 */
export function dhtVBModalCreate(modalID: string, appendTo: JQuery<HTMLElement>, modalTitle: string) {

    const modalHTML = `
        <div id="${modalID}" class="dht-vb-modal">
        
            <div class="dht-vb-modal-header"><span class="dht-vb-modal-title">${modalTitle}</span></div>
            
            <div class="dht-vb-modal-content">
                <div class="dht-preloader dht-hidden" data-delay="500"><div class="dht-spinner-loader"></div></div>
                <div class="dht-vb-modal-content-options"></div>
            </div>
            
            <div class="dht-vb-modal-footer">
               <div class="dht-vb-modal-close">
                   <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                       <path
                           d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z" />
                   </svg>
               </div>
               <div class="dht-vb-modal-save">
                   <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                       <path
                           d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z" />
                   </svg>
               </div>
               <div class="dht-vb-modal-resize">
                   <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                       <path
                           d="M200 32L56 32C42.7 32 32 42.7 32 56l0 144c0 9.7 5.8 18.5 14.8 22.2s19.3 1.7 26.2-5.2l40-40 79 79-79 79L73 295c-6.9-6.9-17.2-8.9-26.2-5.2S32 302.3 32 312l0 144c0 13.3 10.7 24 24 24l144 0c9.7 0 18.5-5.8 22.2-14.8s1.7-19.3-5.2-26.2l-40-40 79-79 79 79-40 40c-6.9 6.9-8.9 17.2-5.2 26.2s12.5 14.8 22.2 14.8l144 0c13.3 0 24-10.7 24-24l0-144c0-9.7-5.8-18.5-14.8-22.2s-19.3-1.7-26.2 5.2l-40 40-79-79 79-79 40 40c6.9 6.9 17.2 8.9 26.2 5.2s14.8-12.5 14.8-22.2l0-144c0-13.3-10.7-24-24-24L312 32c-9.7 0-18.5 5.8-22.2 14.8s-1.7 19.3 5.2 26.2l40 40-79 79-79-79 40-40c6.9-6.9 8.9-17.2 5.2-26.2S209.7 32 200 32z" />
                   </svg>
               </div>
            </div>
        
        </div>
   `;

    //append modal to passed container
    if ($("#" + modalID).length === 0) {
        $(appendTo).append(modalHTML);
    }
}

/**
 * Load modal options via ajax
 *
 * @param modal Modal element
 *
 * @return void
 */
function dhtAjaxLoadOptions(modal: JQuery<HTMLElement>): void {

    const $contentArea = modal.children(".dht-vb-modal-content");
    const $optionsArea = $contentArea.children(".dht-vb-modal-content-options");
    const $spinner = $contentArea.children(".dht-preloader");

    $.ajax({
        // @ts-ignore
        url: dht_framework_info.ajax_url,
        type: "POST",
        dataType: "json",
        data: {
            action: "getModalOptions", // The name of your AJAX action
            data: {
                //post id is used to add it to the ajax $_POST, so I can retrieve it wherever I need
                post_id: $("#post_ID[name=\"post_ID\"]").val(),
                modalType: "yes",
            },
        },
        beforeSend: function() {
            //remove the modal content before load
            $optionsArea.empty();
            //show loading spinner
            $spinner.toggleClass("dht-hidden");
        },
        success: function(response) {
            if (response.success) {

                console.log(response);

                //add options to the modal
                $optionsArea.append(response.data);

                // Initialize options so they could work as expected
                /* setTimeout(function() {
                     $thisClass._reinitializeOptions($box_content_area);
                 }, 100);*/

            } else {
                console.error("Ajax Response", response);
            }
        },
        error: function(error) {
            console.error("AJAX error:", error);
        },
        complete: function() {
            //hide loading spinner
            $spinner.toggleClass("dht-hidden");
        },
    });
}

/**
 * Modal Component
 *
 * Methods to use to init, open or close the modal
 * The method is added as a jQuery native method to
 * bwe used on the modal selector
 *
 * @param options Options passed to methods or the method name
 *
 * @return void
 */
function dhtVBModal(this: JQuery, options?: IVBModalData | keyof IVBModalMethods): JQuery {
    "use strict";

    let pluginName: string = "dhtVBModal";

    let d = 0;

    let initModal = function(this: JQuery, data: IVBModalData) {
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
        let dialog_header_height = ($(this).find(".dht-vb-modal-header").outerHeight() || 0) + dialog_paddingDefault;
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
            if (typeof data.beforeCloseCallback === "function") {
                if (data.beforeCloseCallback) {
                    data.beforeCloseCallback();
                    $moDialog.fadeOut("400", function() {
                        if (typeof data.afterClosedCallback === "function") {
                            if (data.afterClosedCallback) {
                                data.afterClosedCallback();
                            }
                        }
                    });

                }
            } else {
                $moDialog.fadeOut();
            }
        }

        if (dialog_touch_outside_close === "true") {
            $(document).on("mouseup", function(e: JQuery.MouseUpEvent) {
                const target = e.target as HTMLElement;
                if (modal_box === "rest" && !$moDialog.is(target) && $moDialog.has(target).length === 0) {
                    closeModal();
                }
            });
        }

        $(this).find(".dht-vb-modal-close").on("click", function() {
            closeModal();
            //remove disabled class to show the edit icons
            $(".dht-vb-enabled .dht-vb-element").removeClass("dht-vb-disabled");
        });

        if (dialog_move === "true") {
            $(this).find(".dht-vb-modal-header").on("mousedown", function(e) {
                if (modal_box === "rest") {
                    modal_x = e.pageX;
                    modal_y = e.pageY;
                    modal_box_left = $moDialog.position().left;
                    modal_box_top = $moDialog.position().top;
                    modal_box_width = $moDialog.width() || 0;
                    modal_box_height = $moDialog.height() || 0;
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
                    modal_box_width = $moDialog.width() || 0;
                    modal_box_height = $moDialog.height() || 0;
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
                let $moDialogHeaderHeight = $moDialogHeader.outerHeight() || 0;
                let $moDialogFooterHeight = $moDialogFooter.outerHeight() || 0;

                $moDialog.css(
                    {
                        "width": dialog_resizing_width + "px",
                        // "height": dialog_resizing_height + "px",
                    });
                $moDialogContent.css(
                    {
                        // "width": dialog_resizing_width + "px",
                        "height": (dialog_resizing_height - $moDialogHeaderHeight - $moDialogFooterHeight - paddingTop - paddingBottom) + "px",
                    });
                $(document).css(
                    {
                        "cursor": "se-resize",
                    });
            }
        });
    };

    let openModal = function(this: JQuery, data: IVBModalData) {
        let dialog_id = $(this).attr("data-dialogId");
        let $this = $(this);
        let dialog_auto_close = $(this).attr("data-dialogAutoClose");
        // Convert dialog_auto_close to a number
        let autoCloseTime = dialog_auto_close ? parseInt(dialog_auto_close, 10) : undefined;

        $(this).fadeIn(400, function() {
            if (typeof data.afterOpenedCallback === "function") {
                if (data.afterOpenedCallback) {
                    data.afterOpenedCallback();
                }
            }
        });

        if (dialog_auto_close !== "false") {
            setTimeout(function() {
                closeModal.call($this, data);
            }, autoCloseTime);
        }
    };

    let closeModal = function(this: JQuery, data: IVBModalData) {
        let dialog_id = $(this).attr("data-dialogId");
    };

    let methods: { [key: string]: (this: JQuery, ...args: any[]) => JQuery } = {
        init: function(this: JQuery, options: IVBModalData) {
            //"this" is a jquery object on which this plugin has been invoked.
            return this.each(function() {
                d += 1;
                let window_w = $(window).width() || 0;
                let window_h = $(window).height() || 0;
                let $this = $(this);
                let $moDialog = $(this);
                let data = $this.data(pluginName);
                // If the plugin hasn't been initialized yet
                if (!data) {
                    let settings =
                        {
                            autoClose: false,
                            pos_x: 0,
                            pos_y: 0,
                            movable: true,
                            resizable: true,
                            touchOutsideForClose: false,
                            beforeOpenCallback: false,
                            afterOpenedCallback: false,
                            beforeCloseCallback: false,
                            afterClosedCallback: false,
                            width: 400, // Set a default width
                            height: 500, // Set a default height
                        };

                    if (options) {
                        $.extend(true, settings, options);
                    }

                    if (settings.pos_x === 0) {
                        settings.pos_x = (window_w - settings.width) / 2;
                    }
                    if (settings.pos_y === 0) {
                        settings.pos_y = (window_h - settings.height) / 2;
                    }
                    let innerBody = $moDialog.html();
                    $moDialog.attr("data-dialogId", d);
                    $moDialog.attr("data-dialogResizable", String(settings.resizable));
                    $moDialog.attr("data-dialogMovable", String(settings.movable));
                    $moDialog.attr("data-dialogAutoClose", String(settings.autoClose));
                    $moDialog.attr("data-dialogTouchOutsideForClose", String(settings.touchOutsideForClose));

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

                    let $this2 = $(this);
                    let data2 = $this.data(pluginName);

                    initModal.call($this2, data2);
                }
            });
        },
        open: function(this: JQuery) {
            return this.each(function() {
                let $this = $(this);
                let data = $this.data(pluginName);

                // response callback
                if (typeof data.settings.beforeOpenCallback === "function") {
                    if (data.settings.beforeOpenCallback) {
                        data.settings.beforeOpenCallback();
                        openModal.call($this, data);
                    }
                } else {
                    openModal.call($this, data);
                }

                //load the modal options inside the content area
                dhtAjaxLoadOptions($this);
            });
        },
        close: function(this: JQuery) {
            return this.each(function() {
                let $this = $(this);
                let data = $this.data(pluginName);
                closeModal.call($this, data);
            });
        },
        destroy: function(this: JQuery) {
            return this.each(function() {
                let $this = $(this);
                let data = $this.data(pluginName);
                $this.removeData();
            });
        },
    };

    if (typeof options === "string" && methods[options]) {
        return methods[options].apply(this);
    } else if (typeof options === "object" || !options) {
        return methods.init.apply(this, [options]);
    } else {
        $.error("Method " + options + " does not exist in jQuery." + pluginName);
    }

    return this;
}

// Register the plugin
$.fn.dhtVBModal = function(this: JQuery, options?: IVBModalData): JQuery {
    return dhtVBModal.call(this, options);
};