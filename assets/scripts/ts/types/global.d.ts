declare var tinymce: any;
declare var quicktags: any;

//this is added to be able to import .pcss files from the main.ts file
declare module "*.pcss" {
    const content: { [className: string]: string };
    export default content;
}
