import jQuery from 'jquery'

;(function ($: JQueryStatic): void {
    'use strict'

    /**
     * Class used to create and delete custom sidebars
     */
    class DhtWidgetAreas {
        private _widgetArea: JQuery<HTMLElement>
        private readonly _widgetTemplate: JQuery<HTMLElement>
        private readonly _deleteButton: JQuery<HTMLElement>
        private readonly _customSidebar: JQuery<HTMLElement>

        constructor() {
            //where to attach widgets area form
            this._widgetArea = $('#widgets-right')
            //my form id
            this._widgetTemplate = $('#dht-wrap')
            // custom sidebars
            this._customSidebar = this._widgetArea.find('.sidebar-dht-custom')
            //delete area
            this._deleteButton = $('.dht-wrap-delete')

            this._addFormHtml()
            this._addDelButton()
            this._bindEvents()
            this.deleteSidebarAjax()
        }

        /**
         * Adding the widget area form below sidebars area
         *
         * @return void
         */
        private _addFormHtml(): void {
            this._widgetArea.after(this._widgetTemplate)
            this._widgetTemplate.show()
        }

        /**
         * Adding delete area to each added sidebar
         *
         * @return void
         */
        private _addDelButton(): void {
            let $this = this

            this._customSidebar.each(function () {
                let deleteForm = $this._deleteButton.clone()

                jQuery(this).find('.widgets-sortables').append(deleteForm)

                deleteForm.show()
            })
        }

        /**
         * Show confirm / cancel buttons and vice versa
         *
         * @return void
         */
        private _bindEvents() {
            //display confirm / cancel buttons
            this._customSidebar
                .find('.dht-widget-area-delete')
                .on('click', function () {
                    let parent = $(this).parents('.dht-wrap-delete')

                    parent
                        .find(
                            '.dht-widget-area-delete-cancel, .dht-widget-area-delete-confirm'
                        )
                        .show()

                    $(this).hide()
                })

            //display delete button
            this._customSidebar
                .find('.dht-widget-area-delete-cancel')
                .on('click', function () {
                    let parent = $(this).parents('.dht-wrap-delete')

                    parent.find('.dht-widget-area-delete').show()

                    $(this).hide()
                    $(this).siblings('.dht-widget-area-delete-confirm').hide()
                })
        }

        public deleteSidebarAjax() {
            //delete sidebar on clicking confirm button
            this._customSidebar
                .find('.dht-widget-area-delete-confirm')
                .on('click', function () {
                    let sidebar_container = $(this).parents(
                        '.sidebar-dht-custom'
                    )
                    let spinner = sidebar_container.find(
                        '.sidebar-name .spinner'
                    )

                    //get sidebar id
                    let sidebar_id = sidebar_container
                        .children('.widgets-sortables')
                        .attr('id')

                    $.ajax({
                        //@ts-ignore
                        url: dht_remove_sidebar_object.ajax_url,
                        type: 'POST',
                        data: {
                            action: 'deleteWidgetArea', // The name of your AJAX action
                            data: { sidebar_id: sidebar_id },
                        },
                        beforeSend: function () {
                            //show loading spinner
                            spinner.css('visibility', 'visible')
                        },
                        success: function (response) {
                            // Refresh the current page
                            if (response.success) {
                                location.reload()
                            } else {
                                console.log('Ajax Response', response)
                            }
                        },
                        error: function (error) {
                            console.error('AJAX error:', error)
                        },
                    })

                    return false
                })
        }
    }

    $(function (): void {
        new DhtWidgetAreas()
    })
})(jQuery)
