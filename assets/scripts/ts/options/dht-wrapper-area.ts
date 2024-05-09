// @ts-ignore
import jQuery from 'jquery'

;(function ($: JQueryStatic): void {
    'use strict'

    let tooltips = jQuery('.dht-wrapper .dht-info-help')

    jQuery(tooltips).each(function () {
        let $tooltip = jQuery(this)

        $tooltip.on('mouseenter', function () {
            let $this = jQuery(this)

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
            let $this = jQuery(this)

            $this.removeAttr('style')
            $this.html($this.html().replace(/<div[^]*?<\/div>/, ''))
        })
    })
})(jQuery)
