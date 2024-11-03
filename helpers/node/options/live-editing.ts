"use strict";

/**
 * Helper function for handling selectors without keys.
 *
 * Example usage:
 * const selectors = {
 *     target: 'content',
 *     selectors: ['.ppht-box .pht-box-img', '.ppht-box .pht-box-title']
 *
 * @param $element        HTML element
 * @param applyStyles
 *
 * @return void
 */
export function dhtNotKeyedSelectorsHelper($element: JQuery<HTMLElement>, applyStyles: (target: string, selector: string) => void): void {
    const selectors: ILiveEditorSelectors = dhtGetLiveEditingSelectors($element);

    if (Object.entries(selectors).length === 0) return;

    dhtApplyLiveChanges(selectors.selectors, (selector) => {
        applyStyles(selectors.target, selector);
    });
}

/**
 * Helper function for handling selectors with keys.
 *
 * Example usage:
 * const selectors = {
 *     target: 'display',
 *     selectors: {
 *         show: ['.ppht-box .pht-box-icon'],
 *         hide: ['.ppht-box .pht-box-img']
 *     }
 * };
 *
 * @param $element    The HTML element to manipulate.
 * @param applyStyles A callback that will come from each fields with the specific code
 *
 * @return {void}
 */
export function dhtKeyedSelectorsHelper($element: JQuery<HTMLElement>, /*optionValue: string,*/ applyStyles: (key: string, target: string, selector: string) => void): void {
    const selectors: ILiveEditorSelectors = dhtGetLiveEditingSelectors($element);

    if (Object.entries(selectors).length === 0) return;

    //go through selectors keys
    Object.entries(selectors.selectors).forEach(([key, keySelectors]) => {
        //check for array selectors only
        if (Array.isArray(keySelectors)) {
            dhtApplyLiveChanges(keySelectors, (selector) => {
                applyStyles(key, selectors.target, selector);
            });
        } else {
            console.error("Expected selectors to be an array", keySelectors);
        }
    });
}

/**
 * Get live editing selectors to use further from
 * attribute and decode them
 *
 * This is without PHP target attribute
 *
 * @param $element HTML element
 *
 * @return ILiveEditorAttr
 */
function dhtGetTextSelectors($element: JQuery<HTMLElement>): string[] {

    const selectors = $element.attr("data-live-selectors") ?? "";

    if (selectors.length === 0) return [];

    return Object.values(JSON.parse(selectors));
}

/**
 * Get live editing selectors to use further from
 * attribute and decode them
 *
 * This is for PHP target attribute
 *
 * @param $element HTML element
 *
 * @return ILiveEditorAttr
 */
function dhtGetLiveEditingSelectors($element: JQuery<HTMLElement>): ILiveEditorSelectors {

    const selectors = $element.attr("data-live-selectors") ?? "";

    if (selectors.length === 0) return {} as ILiveEditorSelectors;

    return JSON.parse(selectors);
}

/**
 * Go through all selectors and apply the changes to them
 *
 * @param selectors   Selectors array
 * @param applyStyles Style that needs to be applied
 *
 * @return ILiveEditorAttr
 */
function dhtApplyLiveChanges(selectors: string[], applyStyles: (selector: string) => void) {
    // Iterate through the selectors
    selectors.forEach((selector: string) => {
        applyStyles(selector);
    });
}
