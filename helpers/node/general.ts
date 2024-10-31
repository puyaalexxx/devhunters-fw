export function errorLoadingModule(message: string, module = "") {
    if (module.length) {
        console.error(`Error loading module ${module}:`, message);
    } else {
        console.error(`Error loading module:`, message);
    }
}