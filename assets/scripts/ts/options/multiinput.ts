import jQuery from 'jquery'
;(function ($: JQueryStatic): void {
    'use strict'

    const $field_wrapper = $('.dht-field-wrapper')

    $field_wrapper.on(
        'click',
        '.dht-field-child-multiinput .dht-multiinput-add',
        function () {
            let $this = $(this)
            let limit: number = +$this.attr('data-limit')!

            if (
                $this
                    .parents('.dht-field-child-multiinput')
                    .children('.dht-multiinput-child-wrapper').length >= limit
            ) {
                confirm($(this).attr('data-add-text'))

                return false
            }
            let $field = $this.prev('.dht-multiinput-child-wrapper').clone()

            $field.children('input').val('')

            $field.insertBefore($this)
        }
    )

    $field_wrapper.on(
        'click',
        '.dht-field-child-multiinput .dht-multiinput-remove',
        function () {
            let $this = $(this)

            if (
                $this
                    .parents('.dht-field-child-wrapper')
                    .children('.dht-multiinput-child-wrapper').length === 1
            ) {
                confirm($(this).attr('data-remove-text'))

                return
            }

            $this.parent('.dht-multiinput-child-wrapper').remove()
        }
    )
})(jQuery)
