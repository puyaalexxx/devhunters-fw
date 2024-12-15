import { errorLoadingModule } from "@helpers/general";

/**
 * Modal Component (Plugin)
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

    let pluginName: string = dhtVBModal.name;

    let d = 0;
    const $moDialog = $(this);
    // Set fixed dimensions
    const modalFixedWidth = 400; // Set your desired width
    const modalFixedHeight = 500; // Set your desired height

    /////////////// initialize modal code - helper function ///////////////
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

        let $moDialogHeader = $(this).children(".dht-vb-modal-header");
        let $moDialogContent = $(this).children(".dht-vb-modal-content");
        let $moDialogContentOptionsArea = $moDialogContent.children(".dht-vb-modal-content-options");
        let $moDialogFooter = $(this).children(".dht-vb-modal-footer");

        /////////////// close modal ///////////////
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

        /////////////// adjust modal position on window resize ///////////////
        function adjustModalPosition() {

            const windowWidth = $(window).width() || 0;
            const windowHeight = $(window).height() || 0;
            const adminBarHeight = $("#wpadminbar").outerHeight() || 0;

            // Get modal dimensions
            const modalWidth = $moDialog.outerWidth() || 0;
            const modalHeight = $moDialog.outerHeight() || 0;

            // Adjust the modal size if it exceeds the viewport
            let newWidth = modalWidth;
            let newHeight = modalHeight;

            if (modalWidth > windowWidth) {
                newWidth = modalFixedWidth; // Set to fixed width
            }

            if (modalHeight > windowHeight) {
                newHeight = modalFixedHeight; // Set to fixed height
            }

            // Apply new dimensions if they have changed
            if (newWidth !== modalWidth || newHeight !== modalHeight) {
                $moDialog.css("width", newWidth + "px");
                $moDialog.css("height", newHeight + "px");
            }

            // Get updated modal dimensions after resizing
            const updatedModalWidth = $moDialog.outerWidth() || 0;
            const updatedModalHeight = $moDialog.outerHeight() || 0;

            // Get current modal position
            const modalLeft = parseFloat($moDialog.css("left")) || 0;
            const modalTop = parseFloat($moDialog.css("top")) || 0;

            // Ensure the modal stays within bounds horizontally
            let newLeft = Math.min(Math.max(modalLeft, 0), windowWidth - updatedModalWidth);
            // Ensure the modal stays within bounds vertically
            let newTop = Math.min(Math.max(modalTop, adminBarHeight), windowHeight - updatedModalHeight);

            // If modal is outside the visible area, adjust its position
            if (newLeft !== modalLeft || newTop !== modalTop) {
                $moDialog.css({
                    "left": newLeft + "px",
                    "top": newTop + "px",
                });
            }
        }

        /////////////// on window resize ///////////////
        $(window).on("resize", function() {
            adjustModalPosition();
        });

        /////////////// stop changing the modal position on scroll ///////////////
        let isScrolling = false; // Flag to track scrolling state
        // Set up a scroll event listener
        $(window).on("scroll", function() {
            isScrolling = true; // Set flag when scrolling
        });
        // Reset the scrolling flag after a short delay to detect scrolling completion
        let scrollTimeout: any;
        $(window).on("scroll", function() {
            clearTimeout(scrollTimeout);
            scrollTimeout = setTimeout(function() {
                isScrolling = false; // Reset scrolling flag
            }, 50); // Adjust timeout duration as needed
        });

        /////////////// set modal values on some events ///////////////
        if (dialog_touch_outside_close === "true") {
            $(document).on("mouseup", function(e: JQuery.MouseUpEvent) {
                const target = e.target as HTMLElement;
                if (modal_box === "rest" && !$moDialog.is(target) && $moDialog.has(target).length === 0) {
                    closeModal();
                }
            });
        }
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

        /////////////// mouse events ///////////////
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

        // move/resize modal on screen
        $(document).on("mousemove", function(e) {

            // Check if a scroll is happening
            if (isScrolling) {
                return; // Don't start dragging if scrolling is active
            }

            // move modal on screen
            if (modal_box === "move") {

                // Get window dimensions
                const windowWidth = $(window).width() || 0;
                const windowHeight = $(window).height() || 0;
                const adminBarHeight = $("#wpadminbar").outerHeight() || 0;
                let newLeft = e.pageX - modal_box_new_left;
                let newTop = e.pageY - modal_box_new_top;
                // Ensure the modal stays within bounds
                const modalWidth = $moDialog.outerWidth() || 0;
                const modalHeight = $moDialog.outerHeight() || 0;

                // Adjust horizontal position
                newLeft = Math.min(Math.max(newLeft, 0), windowWidth - modalWidth);
                // Adjust vertical position with admin bar consideration
                if (newTop < adminBarHeight) {
                    newTop = adminBarHeight; // Don't allow above admin bar
                } else {
                    newTop = Math.min(Math.max(newTop, 0), windowHeight - modalHeight);
                }

                // Update the modal position
                $moDialog.css({
                    "left": newLeft + "px",
                    "top": newTop + "px",
                });

            }
            // resize modal on screen
            else if (modal_box === "bottom_right_resize") {
                // Calculate temporary dimensions based on mouse movement
                dialog_resizing_height_tmp = (e.pageY - modal_box_top + modal_box_bottom_dust);
                dialog_resizing_height = (dialog_resizing_height_tmp > dialog_header_height) ? dialog_resizing_height_tmp : dialog_header_height;

                dialog_resizing_width_tmp = (e.pageX - modal_box_left + modal_box_right_dust);
                dialog_resizing_width = (dialog_resizing_width_tmp > dialog_header_width) ? dialog_resizing_width_tmp : dialog_header_width;

                // Get current window dimensions
                const windowWidth = $(window).width() || 0;
                const windowHeight = $(window).height() || 0;

                // Get the height of the WordPress admin bar
                const adminBarHeight = $("#wpadminbar").outerHeight() || 0;

                // Calculate maximum allowed dimensions based on current position
                const maxWidth = windowWidth - modal_box_left; // Limit width to available space on the right
                const maxHeight = windowHeight - modal_box_top; // Limit height to available space below the admin bar

                // Define minimum dimensions
                const minWidth = 400;  // Minimum width in pixels
                const minHeight = 400;  // Minimum height in pixels

                // Apply restrictions based on current position
                dialog_resizing_width = Math.min(Math.max(dialog_resizing_width, minWidth), maxWidth);
                dialog_resizing_height = Math.min(Math.max(dialog_resizing_height, minHeight), maxHeight);

                // Adjust height to account for the modal header and footer
                let paddingTop = parseInt($moDialogContentOptionsArea.css("padding-top")) || 0;
                let paddingBottom = parseInt($moDialogContentOptionsArea.css("padding-bottom")) || 0;
                let $moDialogHeaderHeight = $moDialogHeader.outerHeight() || 0;
                let $moDialogFooterHeight = $moDialogFooter.outerHeight() || 0;

                // Update classes based on width
                if (dialog_resizing_width <= 768) {
                    $moDialog.addClass("dht-modal-small").removeClass("dht-modal-medium dht-modal-large");
                } else if (dialog_resizing_width >= 769 && dialog_resizing_width <= 1366) {
                    $moDialog.addClass("dht-modal-medium").removeClass("dht-modal-small dht-modal-large");
                } else {
                    $moDialog.addClass("dht-modal-large").removeClass("dht-modal-small dht-modal-medium");
                }

                // Apply the final dimensions
                $moDialog.css({
                    "width": dialog_resizing_width + "px",
                    "height": dialog_resizing_height + "px",
                });
                $moDialogContent.css({
                    "height": (dialog_resizing_height - $moDialogHeaderHeight - $moDialogFooterHeight) + "px",
                });
                $moDialogContentOptionsArea.css({
                    "height": (dialog_resizing_height - $moDialogHeaderHeight - $moDialogFooterHeight - paddingTop - paddingBottom) + "px",
                });
                $(document).css({
                    "cursor": "se-resize",
                });
            }
        });

        //close/save modal on click
        $moDialog.find(".dht-vb-modal-close, .dht-vb-modal-save").on("click", function() {
            //remove disabled class to show the edit icons
            $(".dht-vb-enabled .dht-vb-module").removeClass("dht-vb-disabled");
        });

        //close modal on click
        $(this).find(".dht-vb-modal-close").on("click", function() {
            closeModal();

            //remove modal element
            $moDialog.remove();
        });

        //save modal on click
        $moDialog.find(".dht-vb-modal-save").on("click", function() {
            dhtAjaxSaveOptions($moDialog, closeModal);
        });
    };

    /////////////// open modal code - helper function ///////////////
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

    /////////////// close modal code - helper function ///////////////
    let closeModal = function(this: JQuery, data: IVBModalData) {
        let dialog_id = $(this).attr("data-dialogId");
    };

    /////////////// modal methods to use outside ///////////////
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
                            width: modalFixedWidth, // Set a default width
                            height: modalFixedHeight, // Set a default height
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

    /////////////// calling methods outside ///////////////
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

/**
 * Modal HTML Code
 *
 * Call this method first to append the modal HTML
 * to the specified container selector
 *
 * @param moduleInfo All module required info
 *
 * @return void
 */
export function dhtCreateVBModal(moduleInfo: ModuleInfo) {
    const { $vbModule, modalID, moduleName, modalTitle, hiddenInputClass } = moduleInfo;

    const modalHTML = `
        <div id="dht-modal-${modalID}" class="dht-vb-modal dht-modal-small" data-module-id="${modalID}" data-module-name="${moduleName}" data-module-input="${hiddenInputClass}">
        
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
    if ($("#dht-modal-" + modalID).length === 0) {
        $vbModule.append(modalHTML);
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
    const hiddenInputClass = modal.attr("data-module-input");

    $.ajax({
        // @ts-ignore
        url: dht_framework_info.ajax_url,
        type: "POST",
        dataType: "json",
        data: {
            action: "getModalOptions", // The name of your AJAX action
            //post id is used to add it to the ajax $_POST
            post_id: $("#post_ID[name=\"post_ID\"]").val(),
            data: {
                moduleName: modal.attr("data-module-name"),
                moduleID: modal.attr("data-module-id"),
                formSavedData: modal.siblings("." + hiddenInputClass).val(),
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
                //remove the modal content before load
                $optionsArea.empty();

                //add options to the modal
                $optionsArea.append(response.data);

                // Initialize options so they could work as expected
                setTimeout(function() {
                    import("@helpers/options/ajax-options-reload")
                        .then(module => {
                            const { dhtReinitializeOptions } = module;
                            dhtReinitializeOptions($optionsArea);
                        })
                        .catch(error => {
                            errorLoadingModule(error as string);
                        });
                }, 200);

            } else {
                console.error("Ajax Response: ", response);
            }
        },
        error: function(error) {
            console.error("AJAX error: ", error);
        },
        complete: function() {
            setTimeout(function() {
                //hide loading spinner
                $spinner.toggleClass("dht-hidden");
            }, 500);
        },
    });
}

/**
 * Save modal form options via ajax in a hidden input
 *
 * This input value will be used by get modal options method to apply
 * them to each options
 *
 * @param modal Modal element
 * @param closeModal Close modal callback
 *
 * @return void
 */
function dhtAjaxSaveOptions(modal: JQuery<HTMLElement>, closeModal: () => void): void {
    const $form = modal.find("form");
    const $formFooter = modal.children(".dht-vb-modal-footer");
    const $spinner = modal.find(".dht-preloader");
    const hiddenInputClass = modal.attr("data-module-input");

    $.ajax({
        // @ts-ignore
        url: dht_framework_info.ajax_url,
        type: "POST",
        dataType: "json",
        data: {
            action: "saveModalOptions", // The name of your AJAX action
            //post id is used to add it to the ajax $_POST
            post_id: $("#post_ID[name=\"post_ID\"]").val(),
            data: {
                moduleName: modal.attr("data-module-name"),
                moduleID: modal.attr("data-module-id"),
                formData: $form.serialize(),
            },
        },
        beforeSend: function() {
            //show loading spinner
            $spinner.toggleClass("dht-hidden");
            $formFooter.toggleClass("dht-vb-modal-footer-disabled");
        },
        success: function(response) {
            if (response.success) {
                //save form values to the input
                modal.siblings("." + hiddenInputClass).val(response.data);

                //hide loading spinner
                $spinner.toggleClass("dht-hidden");
                $formFooter.toggleClass("dht-vb-modal-footer-disabled");

                closeModal();

                //remove modal element
                modal.remove();
            } else {
                console.error("Ajax Response: ", response);
            }
        },
        error: function(error) {
            console.error("AJAX error: ", error);
        },
        complete: function() {
        },
    });


}