var Encore = require('@symfony/webpack-encore');

Encore
    // the project directory where compiled assets will be stored
    .setOutputPath('./src/Resources/public/dist/')
    // the public path used by the web server to access the previous directory
    .setPublicPath('/')
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    // uncomment to create hashed filenames (e.g. app.abc123.css)
    // .enableVersioning(Encore.isProduction())
    .disableSingleRuntimeChunk()
    // uncomment to define the assets of the project
     .addEntry('sonata-multiupload', './src/Resources/public/js/app.js')

    // uncomment if you use Sass/SCSS files
    .enableSassLoader()

    // uncomment for legacy applications that require $/jQuery as a global variable
    // .autoProvidejQuery()
;

var config = Encore.getWebpackConfig();

config.externals = {
    jquery: 'jQuery'
};

module.exports = config;