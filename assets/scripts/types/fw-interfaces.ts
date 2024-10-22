interface IVBModalData {
    autoClose?: boolean; // Changed to optional
    pos_x?: string | number; // Changed to optional
    pos_y?: string | number; // Changed to optional
    movable?: boolean; // Changed to optional
    resizable?: boolean; // Changed to optional
    touchOutsideForClose?: boolean; // Changed to optional
    beforeOpenCallback?: () => void;
    afterOpenedCallback?: () => void;
    beforeCloseCallback?: () => void;
    afterClosedCallback?: () => void;
}

interface IVBModalMethods {
    init: (this: JQuery, options: IVBModalData) => JQuery;
    open: (this: JQuery) => JQuery;
    close: (this: JQuery) => JQuery;
    destroy: (this: JQuery) => JQuery;
}

interface JQuery {
    dhtVBModal(this: JQuery, options?: IVBModalData | keyof IVBModalMethods): JQuery;
}

interface IVbTranslations {
    icon_drag: string;
    icon_settings: string;
    icon_duplicate: string;
    icon_delete: string;
    icon_other_settings: string;
    modal_title: string;
}

interface ModuleInfo {
    $vbModule: JQuery<HTMLElement>; //Module container selector
    modalID: string; //Module id - must be unique
    moduleName: string; //Module Name
    modalTitle?: string; // Translated modal title
    hiddenInputClass?: string; //Hidden input class where the modal options are saved
}
