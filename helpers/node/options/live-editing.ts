"use strict";

/**
 * Get live editing selectors to use further from
 * attribute and decode them
 *
 * @param $element HTML element
 *
 * @return ILiveEditorAttr
 */
export function dhtGetLiveEditingSelectors($element: JQuery<HTMLElement>): ILiveEditorSelectorTarget {

    const selectors = $element.attr("data-live-selectors") ?? "";

    if (selectors.length === 0) return {} as ILiveEditorSelectorTarget;

    return JSON.parse(selectors);
}

/**
 * Go through all selectors and apply the changes to them
 *
 * @param selectors   Selectors object
 * @param applyStyles Style that needs to be applied
 *
 * @return ILiveEditorAttr
 */
export function dhtApplyLiveChanges(selectors: ILiveEditorSelectorTarget, applyStyles: (selector: string) => void) {
    // Iterate through the selectors
    selectors.selectors.forEach((selector: string) => {
        applyStyles(selector);
    });
}

