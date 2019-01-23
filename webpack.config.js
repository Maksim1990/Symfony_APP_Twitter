var Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(! Encore.isProduction())

    // read main.js     -> output as web/build/app.js
    .addEntry('js/app', [
        './node_modules/jquery/dist/jquery.slim.js',
        './node_modules/popper.js/dist/popper.min.js',
        './node_modules/bootstrap/dist/js/bootstrap.min.js',
        './node_modules/holderjs/holder.min.js'

    ])
    // // read global.scss -> output as web/build/global.css
     .addStyleEntry('css/app', [
         './node_modules/bootstrap/dist/css/bootstrap.min.css',
         './assets/css/app.css',
     ])
    //
    // // enable features!
    // .enableSassLoader()
    // .autoProvidejQuery()
    // .enableReactPreset()
    // .enableSourceMaps(!Encore.isProduction())
    // .enableVersioning() // hashed filenames (e.g. main.abc123.js)
;

module.exports = Encore.getWebpackConfig();