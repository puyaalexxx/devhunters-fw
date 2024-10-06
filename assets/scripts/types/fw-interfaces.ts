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