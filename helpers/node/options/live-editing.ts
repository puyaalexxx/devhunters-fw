"use strict";

/**
 * Apply live changes for selectors without keys.
 *
 * Example usage:
 * const selectors = {
 *     target: 'content',
 *     selectors: ['.ppht-box .pht-box-img', '.ppht-box .pht-box-title']
 *
 * @param $element        HTML element
 * @param applyChanges    Callback to apply the live changes
 * @param revertChanges   Callback to revert the live changes to its defaults
 *
 * @return void
 */
export function dhtApplyChangesForNotKeyedSelectors($element: JQuery<HTMLElement>,
                                                    applyChanges: (target: string, selectors: string) => void,
                                                    revertChanges: (target: string, selectors: string) => void): void {

    const objectSelectors: ILiveEditorSelectors = dhtGetLiveEditingSelectors($element);

    const moduleID = dhtGetOpenedModalID($element);

    //combine all selectors
    const selectors = dhtReplaceSelectorsPlaceholders(objectSelectors.selectors.join(", "), moduleID);

    applyChanges(objectSelectors.target, selectors);

    if (objectSelectors.revert) {
        revertChanges(objectSelectors.target, selectors);
    }
}

/**
 * Apply live changes for selectors with keys.
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
 * @param applyChanges Callback to apply the live changes
 * @param revertChanges   Callback to revert the live changes to its defaults
 *
 * @return {void}
 */
export function dhtApplyChangesForKeyedSelectors($element: JQuery<HTMLElement>,
                                                 applyChanges: (key: string, target: string, selector: string) => void,
                                                 revertChanges: (key: string, target: string, selector: string) => void): void {

    const selectors: ILiveEditorSelectors = dhtGetLiveEditingSelectors($element);

    const moduleID = dhtGetOpenedModalID($element);

    //go through selectors keys
    Object.entries(selectors.selectors).forEach(([key, keySelectors]) => {
        //check for array selectors only
        if (Array.isArray(keySelectors)) {
            const joinedSelectors = dhtReplaceSelectorsPlaceholders(keySelectors.join(", "), moduleID);

            applyChanges(key.trim(), selectors.target, joinedSelectors);

            if (selectors.revert) {
                revertChanges(key.trim(), selectors.target, joinedSelectors);
            }
        } else {
            console.error("Expected selectors to be an array", keySelectors);
        }
    });
}

/**
 * Restore element initial values before live changes
 *
 * This will restore the initial values for elements on
 * clicking the modal closing button
 *
 * @param $element       The HTML element to manipulate.
 * @param restoreChanges A callback that will come from each fields with the specific code
 *
 * @return void
 */
export function dhtRestoreElementDefaultValues($element: JQuery<HTMLElement>, restoreChanges: () => void): void {
    const moduleID = dhtGetOpenedModalID($element);

    $("#" + moduleID).find(".dht-vb-modal-close").on("click", function(e: any) {
        restoreChanges();
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

/**
 * Get field default value that we need to restore
 *
 * @param $element    The HTML element to manipulate.
 *
 * @return string
 */
export function dhtGetDefaultValue($element: JQuery<HTMLElement>): string {
    return $element.attr("data-live-default-value") ?? "";
}