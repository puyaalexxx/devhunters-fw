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
export function dhtNotKeyedSelectorsHelper($element: JQuery<HTMLElement>, applyStyles: (target: string, selectors: string) => void): void {
    const objectSelectors: ILiveEditorSelectors = dhtGetLiveEditingSelectors($element);

    //combine all selectors
    const selectors = dhtReplaceSelectorsPlaceholders(objectSelectors.selectors.join(", "), dhtGetOpenedModalID($element));

    applyStyles(objectSelectors.target, selectors);
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
export function dhtKeyedSelectorsHelper($element: JQuery<HTMLElement>, applyStyles: (key: string, target: string, selector: string) => void): void {
    const selectors: ILiveEditorSelectors = dhtGetLiveEditingSelectors($element);

    const moduleID = dhtGetOpenedModalID($element);

    //go through selectors keys
    Object.entries(selectors.selectors).forEach(([key, keySelectors]) => {
        //check for array selectors only
        if (Array.isArray(keySelectors)) {
            const joinedSelectors = dhtReplaceSelectorsPlaceholders(keySelectors.join(", "), moduleID);

            applyStyles(key.trim(), selectors.target, joinedSelectors);
        } else {
            console.error("Expected selectors to be an array", keySelectors);
        }
    });
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

    if (Object.entries(selectors).length === 0) return {} as ILiveEditorSelectors;

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

/**
 * Get opened modal id to target the specific
 * module and not all of the
 *
 * @param $element    The HTML element to manipulate.
 *
 * @return string
 */
function dhtGetOpenedModalID($element: JQuery<HTMLElement>): string {
    //get modal data-module-id (the module id also - they should match)
    return $element.parents("[data-module-name]").attr("data-module-id") || "";
}

/**
 * Replace placeholders like {{module-id}} with the current opened module id
 * to target only it instead all of them on the page
 *
 * @param moduleID    The module id
 * @param selectors   The element selectors
 *
 * @return string
 */
function dhtReplaceSelectorsPlaceholders(selectors: string, moduleID: string): string {
    if (selectors.includes("{{module-id}}")) {
        selectors = selectors.replace(/{{module-id}}/g, moduleID);
    }

    return selectors;
}