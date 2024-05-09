// @ts-ignore
import jQuery from 'jquery'
;(function ($: JQueryStatic): void {
    'use strict'

    let tooltips = $('.dht-wrapper .dht-info-help')

    jQuery(tooltips).each(function () {
        let $tooltip = $(this)

        $tooltip.on('mouseenter', function () {
            let $this = $(this)

            $this.css('position', 'relative')
            $this.html(
                $this.html() +
                    "<div class='dh-tooltips'><p class='" +
                    $this.attr('data-position') +
                    "'>" +
                    $this.attr('data-tooltips') +
                    '</p>'
            )
        })

        $tooltip.on('mouseleave', function () {
            let $this = $(this)

            $this.removeAttr('style')
            $this.html($this.html().replace(/<div[^]*?<\/div>/, ''))
        })
    })
})(jQuery)
