const mix = require('laravel-mix');
const glob = require('glob');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

// mix.js('resources/js/app.js', 'public/js')
//     .sass('resources/sass/app.scss', 'public/css');


mix.js('resources/js/scripts.js', 'public/js/scripts.js')
    .js('resources/js/dropzone.js', 'public/js/dropzone.js')
    .js('resources/js/jquery.canvasjs.min.js', 'public/js/jquery.canvasjs.min.js')
    .sass('resources/sass/style.scss', 'public/css/style.css')
    .sass('resources/sass/dropzone.scss', 'public/css/dropzone.css');

/*
 |--------------------------------------------------------------------------
 | Page specific JS files
 |--------------------------------------------------------------------------
 |
 | Specific to certain pages.
 |
 */

const fileLocation = 'resources/js';
const filesFound = glob.sync(`${fileLocation}/**/!(app|_*).js`, true);

filesFound.forEach((path) => {
  const dest = `public/js${path.replace(fileLocation, '')}`;
  mix.babel(path, dest);
});

/*
 |--------------------------------------------------------------------------
 | Add common JS libraries and common JS files here
 |--------------------------------------------------------------------------
 |
 | Common means used by most pages on the site.
 | We must put this last because extract will use the last defined output
 | path to put the vendor/manifest files
 |
 */
/**
 * Compile global scripts file
 */
// mix.babel('resources/assets/js/app.js', 'public/js/app.js');
// .extract(['bootstrap.native/dist/bootstrap-native-v4']);

mix
  .js('resources/js/app.js', 'public/js/app.js')
  .webpackConfig({
    module: {
      rules: [
        {
          test: /\.js?$/,
          exclude: /node_modules/,
          use: [
            {
              loader: 'babel-loader',
              options: mix.config.babel(),
            },
          ],
        },
      ],
    },
  });

if (mix.inProduction()) {
  mix.disableNotifications();
  mix.version();
  return;
}

mix.webpackConfig({
  devtool: 'source-map',
});
