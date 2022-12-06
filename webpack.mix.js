/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 */

const mix = require('laravel-mix')
require('laravel-mix-polyfill')

//const proxy = "localhost"
const proxy = "http://wp.local"

const config = {
    externals: {
      jquery: "jQuery"
    }
}

const options = {
    processCssUrls: false,
    postCss: [require('autoprefixer')]
}

/*
 |--------------------------------------------------------------------------
 | CONFIGURATION
 |--------------------------------------------------------------------------
 */
mix
    .webpackConfig( config )
    .setPublicPath( "./dist" )
    .disableNotifications()
    .options( options )
    .sourceMaps( mix.inProduction(), 'source-map' )

      
/*
 |--------------------------------------------------------------------------
 | COMPILE JS & CSS
 |--------------------------------------------------------------------------
 */
mix
    .js('src/js/app.js', 'dist/js/')
    .js('src/js/customizer.js', 'dist/js/')
    .extract()
    .sass('src/scss/style.scss', 'dist/css/')
    .sass('src/scss/admin.scss', 'dist/css/admin.css')
    .sass('src/scss/adminbar.scss', 'dist/css/adminbar.css')
    .sass('src/scss/editor-styles.scss', 'dist/css/editor-styles.css')
    .sass('src/scss/editor-blocks.scss', 'dist/css/editor-blocks.css')
    .version()
  

/*
 |--------------------------------------------------------------------------
 | Polyfills
 |--------------------------------------------------------------------------
 */
mix 
    .polyfill({
      enabled: true,
      useBuiltIns: "usage",
      targets: "firefox 50, IE 11"
    })

   
/*
 |--------------------------------------------------------------------------
 | COPY ASSETS
 |--------------------------------------------------------------------------
 */
mix
    .copyDirectory("src/images", "dist/images")
    .copyDirectory("src/fonts", "dist/fonts")
    .copyDirectory("src/iconfonts", "dist/iconfonts")


/*
 |--------------------------------------------------------------------------
 | BROWSERSYNC
 |--------------------------------------------------------------------------
 */
mix
    .browserSync({
        proxy: proxy,
        open: false,
        files: [
            'dist/**/*.{css,js}',
            'template-parts/**/*.php'
        ]
    })
