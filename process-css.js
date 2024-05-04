//use this file when compiling css in different folders if webpack cant make it

const postcss = require('postcss')
const fs = require('fs')
const path = require('path')
const precss = require('precss')
const postcssPresetEnv = require('postcss-preset-env') // New plugin
const autoprefixer = require('autoprefixer') // New plugin
const postcssImport = require('postcss-import') // New plugin
// uncomment on production
//const cssnano = require('cssnano')

// Input and output directories
const inputDir = 'assets/styles/postcss'
const outputDir = 'assets/styles/css'

// Function to process PCSS files
function processPCSS(filePath) {
    const inputFile = filePath
    const outputFile = path.resolve(
        outputDir,
        path.relative(inputDir, filePath).replace('.pcss', '.css')
    )

    const css = fs.readFileSync(inputFile, 'utf8')

    // Process PCSS to CSS using PostCSS with precss plugin
    postcss([
        precss,
        postcssPresetEnv({ stage: 1 }),
        autoprefixer(),
        postcssImport() /*, cssnano*/,
    ])
        .process(css, { from: inputFile, to: outputFile })
        .then((result) => {
            // Ensure output directory exists
            const outputSubfolderDir = path.dirname(outputFile)
            if (!fs.existsSync(outputSubfolderDir)) {
                fs.mkdirSync(outputSubfolderDir, { recursive: true })
            }

            // Write CSS file
            fs.writeFileSync(outputFile, result.css)
            console.log(`Processed: ${inputFile} => ${outputFile}`)
        })
        .catch((error) => {
            console.error('Error processing file:', error)
        })
}

// Function to process all PCSS files recursively in a directory
function processAllPCSS(dirPath) {
    const files = fs.readdirSync(dirPath)
    files.forEach((file) => {
        const filePath = path.join(dirPath, file)
        const stat = fs.statSync(filePath)
        if (stat.isDirectory()) {
            // If it's a directory, recursively process its contents
            processAllPCSS(filePath)
        } else if (file.endsWith('.pcss')) {
            // If it's a PCSS file, process it
            processPCSS(filePath)
        }
    })
}

// Initial processing
processAllPCSS(inputDir)

// Watch for changes
fs.watch(inputDir, { recursive: true }, (eventType, filename) => {
    const filePath = path.join(inputDir, filename)
    if (filename.endsWith('.pcss')) {
        console.log(`File ${filename} changed, processing...`)
        processPCSS(filePath)
    }
})
