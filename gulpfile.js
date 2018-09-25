/**
 * Gulpfile.
 *
 *
 * Implements:
 *      1. Live reloads browser with BrowserSync.
 *      2. CSS: Sass to CSS conversion, error catching, Autoprefixing, Sourcemaps,
 *         CSS minification, and Merge Media Queries.
 *      3. JS: Concatenates & uglifies vendors and Custom JS files.
 *      4. Images: Minifies PNG, JPEG, GIF and SVG images.
 *      5. Watches files for changes in CSS or JS.
 *      6. Watches files for changes in PHP.
 *      7. Corrects the line endings.
 *      8. InjectCSS instead of browser page reload.
 *      9. Generates .pot file for i18n and l10n.
 *
 * @author Ahmad Awais (@ahmadawais)
 * @version 1.0.3
 * @author Edited by Alexandre Disdier (@alexdisdier)
 */

/**
 * Configuration.
 *
 * Project Configuration for gulp tasks.
 *
 * In paths you can add <<glob or array of globs>>. Edit the variables as per your project requirements.
 */

// START Editing Project Variables.
// Project related.
var project                 = 'starter_theme'; // Project Name.
var projectURL              = 'localhost:8888/personal_websites/vcard/'; // Local project URL of your already running WordPress site. Could be something like local.dev or localhost:8888.
var productURL              = './'; // Theme/Plugin URL. Leave it like it is, since our gulpfile.js lives in the root folder.

// Translation related.
var text_domain             = 'WPGULP'; // Your textdomain here.
var translationFile         = 'WPGULP.pot'; // Name of the transalation file.
var translationDestination  = './languages'; // Where to save the translation files.
var packageName             = 'WPGULP'; // Package name.
var bugReport               = 'https://AhmadAwais.com/contact/'; // Where can users report bugs.
var lastTranslator          = 'Ahmad Awais <your_email@email.com>'; // Last translator Email ID.
var team                    = 'WPTie <your_email@email.com>'; // Team's Email ID.

// Style related.
var styleSRC                = './application/www/assets/scss/style.scss'; // Path to main .scss file.
var styleDestination        = './application/www/'; // Path to place the compiled CSS file.
// Default set to root folder.

// Edited by alexdisdier
var dist                    = './dist/'; // Path to Production Folder
var assetsURL               = './application/www/assets/'; // Path to assets

// PHP related
var phpSRC                  = './**/*.php'; // Path to source PHP files
// var phpDestination          = './dist/'; // Path to destination directory

var phtmlSRC                  = './**/*.phmtl'; // Path to source PHP files
// var phtmlDestination          = './dist/'; // Path to destination directory

// JS vendors related.
var jsvendorsRC = './application/www/assets/js/vendors/*.js'; // Path to JS vendors folder.
var jsvendorsDestination = './application/www/assets/js/'; // Path to place the compiled JS vendors file.
var jsvendorsFile = 'vendors'; // Compiled JS vendors file name.
// Default set to vendors i.e. vendors.js.

// JS Custom related.
var jsCustomSRC = './application/www/assets/js/custom/*.js'; // Path to JS custom scripts folder.
var jsCustomDestination = './application/www/assets/js/'; // Path to place the compiled JS custom scripts file.
var jsCustomFile = 'custom'; // Compiled JS custom file name.
// Default set to custom i.e. custom.js.

// Images related.
var imagesSRC = './application/www/assets/images/raw/**/*.{png,jpg,gif,svg}'; // Source folder of images which should be optimized.
var imagesDestination = './application/www/assets/images/'; // Destination folder of optimized images. Must be different from the imagesSRC folder.

// Watch files paths.
var styleWatchFiles = './application/www/assets/scss/**/*.scss'; // Path to all *.scss files inside scss folder and inside them.
var vendorsJSWatchFiles = './application/www/assets/js/vendors/*.js'; // Path to all vendors JS files.
var customJSWatchFiles = './application/www/assets/js/custom/*.js'; // Path to all custom JS files.
var indexVueWatch = './application/www/assets/js/index.js'; // Path to all custom JS files.

var projectPHPWatchFiles = './**/*.php'; // Path to all PHP files.
var projectPhtmlWatchFiles = './**/*.phtml'; // Path to all PHP files.


// Browsers you care about for autoprefixing.
// Browserlist https        ://github.com/ai/browserslist
const AUTOPREFIXER_BROWSERS = [
  'last 2 version',
  '> 1%',
  'ie >= 9',
  'ie_mob >= 10',
  'ff >= 30',
  'chrome >= 34',
  'safari >= 7',
  'opera >= 23',
  'ios >= 7',
  'android >= 4',
  'bb >= 10'
];

// STOP Editing Project Variables.

/**
 * Load Plugins.
 *
 * Load gulp plugins and passing them semantic names.
 */
var gulp = require('gulp'); // Gulp of-course

// CSS related plugins.
var sass = require('gulp-sass'); // Gulp pluign for Sass compilation.
var minifycss = require('gulp-uglifycss'); // Minifies CSS files.
var autoprefixer = require('gulp-autoprefixer'); // Autoprefixing magic.
var mmq = require('gulp-merge-media-queries'); // Combine matching media queries into one media query definition.

// JS related plugins.
var concat = require('gulp-concat'); // Concatenates JS files
var uglify = require('gulp-uglify'); // Minifies JS files

// Image realted plugins.
var imagemin = require('gulp-imagemin'); // Minify PNG, JPEG, GIF and SVG images with imagemin.

// Utility related plugins.
var rename = require('gulp-rename'); // Renames files E.g. style.css -> style.min.css
var lineec = require('gulp-line-ending-corrector'); // Consistent Line Endings for non UNIX systems. Gulp Plugin for Line Ending Corrector (A utility that makes sure your files have consistent line endings)
var filter = require('gulp-filter'); // Enables you to work on a subset of the original files by filtering them using globbing.
var sourcemaps = require('gulp-sourcemaps'); // Maps code in a compressed file (E.g. style.css) back to it’s original position in a source file (E.g. structure.scss, which was later combined with other css files to generate style.css)
var notify = require('gulp-notify'); // Sends message notification to you
var browserSync = require('browser-sync').create(); // Reloads browser and injects CSS. Time-saving synchronised browser testing.
var reload = browserSync.reload; // For manual browser reload.
var wpPot = require('gulp-wp-pot'); // For generating the .pot file.
var sort = require('gulp-sort'); // Recommended to prevent unnecessary changes in pot-file.

// Edits alexdisdier
var packageSite  = require('gulp-copy');
var zip = require('gulp-zip');
var gulpSequence = require('gulp-sequence');
var del = require('del');


/**
 * Task: `browser-sync`.
 *
 * Live Reloads, CSS injections, Localhost tunneling.
 *
 * This task does the following:
 *    1. Sets the project URL
 *    2. Sets inject CSS
 *    3. You may define a custom port
 *    4. You may want to stop the browser from openning automatically
 */
gulp.task('browser-sync', function() {
  browserSync.init({

    // For more options
    // @link http://www.browsersync.io/docs/options/

    // Project URL.
    proxy: projectURL,

    // `true` Automatically open the browser with BrowserSync live server.
    // `false` Stop the browser from automatically opening.
    open: true,

    // Inject CSS changes.
    // Commnet it to reload browser for every CSS change.
    injectChanges: true,

    // Use a specific port (instead of the one auto-detected by Browsersync).
    // port: 7000,

  });
});

/**
 * Task: `styles`.
 *
 * Compiles Sass, Autoprefixes it and Minifies CSS.
 *
 * This task does the following:
 *    1. Gets the source scss file
 *    2. Compiles Sass to CSS
 *    3. Writes Sourcemaps for it
 *    4. Autoprefixes it and generates style.css
 *    5. Renames the CSS file with suffix .min.css
 *    6. Minifies the CSS file and generates style.min.css
 *    7. Injects CSS or reloads the browser via browserSync
 */
gulp.task('styles', function() {
  gulp.src(styleSRC)
    .pipe(sourcemaps.init())
    .pipe(sass({
      errLogToConsole: true,
      outputStyle: 'compact',
      // outputStyle: 'compressed',
      // outputStyle: 'nested',
      // outputStyle: 'expanded',
      precision: 10
    }))
    .on('error', console.error.bind(console))
    .pipe(sourcemaps.write({
      includeContent: false
    }))
    .pipe(sourcemaps.init({
      loadMaps: true
    }))
    .pipe(autoprefixer(AUTOPREFIXER_BROWSERS))

    .pipe(sourcemaps.write('./'))
    .pipe(lineec()) // Consistent Line Endings for non UNIX systems.
    .pipe(gulp.dest(styleDestination))

    .pipe(filter('**/*.css')) // Filtering stream to only css files
    .pipe(mmq({
      log: true
    })) // Merge Media Queries only for .min.css version.

    .pipe(browserSync.stream()) // Reloads style.css if that is enqueued.

    .pipe(rename({
      suffix: '.min'
    }))
    .pipe(minifycss({
      maxLineLen: 10
    }))
    .pipe(lineec()) // Consistent Line Endings for non UNIX systems.
    .pipe(gulp.dest(styleDestination))

    .pipe(filter('**/*.css')) // Filtering stream to only css files
    .pipe(browserSync.stream()) // Reloads style.min.css if that is enqueued.
    .pipe(notify({
      message: 'TASK: "styles" Completed! 💯',
      onLast: true
    }))
});


/**
 * Task: `vendorsJS`.
 *
 * Concatenate and uglify vendors JS scripts.
 *
 * This task does the following:
 *     1. Gets the source folder for JS vendors files
 *     2. Concatenates all the files and generates vendors.js
 *     3. Renames the JS file with suffix .min.js
 *     4. Uglifes/Minifies the JS file and generates vendors.min.js
 */
gulp.task('vendorsJs', function() {
  gulp.src(jsvendorsRC)
    .pipe(concat(jsvendorsFile + '.js'))
    .pipe(lineec()) // Consistent Line Endings for non UNIX systems.
    .pipe(gulp.dest(jsvendorsDestination))
    .pipe(rename({
      basename: jsvendorsFile,
      suffix: '.min'
    }))
    .pipe(uglify())
    .pipe(lineec()) // Consistent Line Endings for non UNIX systems.
    .pipe(gulp.dest(jsvendorsDestination))
    .pipe(notify({
      message: 'TASK: "vendorsJs" Completed! 💯',
      onLast: true
    }));
});


/**
 * Task: `customJS`.
 *
 * Concatenate and uglify custom JS scripts.
 *
 * This task does the following:
 *     1. Gets the source folder for JS custom files
 *     2. Concatenates all the files and generates custom.js
 *     3. Renames the JS file with suffix .min.js
 *     4. Uglifes/Minifies the JS file and generates custom.min.js
 */
gulp.task('customJS', function() {
  gulp.src(jsCustomSRC)
    .pipe(concat(jsCustomFile + '.js'))
    .pipe(lineec()) // Consistent Line Endings for non UNIX systems.
    .pipe(gulp.dest(jsCustomDestination))
    .pipe(rename({
      basename: jsCustomFile,
      suffix: '.min'
    }))
    .pipe(uglify())
    .pipe(lineec()) // Consistent Line Endings for non UNIX systems.
    .pipe(gulp.dest(jsCustomDestination))
    .pipe(notify({
      message: 'TASK: "customJs" Completed! 💯',
      onLast: true
    }));
});


/**
 * Task: `images`.
 *
 * Minifies PNG, JPEG, GIF and SVG images.
 *
 * This task does the following:
 *     1. Gets the source of images raw folder
 *     2. Minifies PNG, JPEG, GIF and SVG images
 *     3. Generates and saves the optimized images
 *
 * This task will run only once, if you want to run it
 * again, do it with the command `gulp images`.
 */
gulp.task('images', function() {
  gulp.src(imagesSRC)
    .pipe(imagemin({
      progressive: true,
      optimizationLevel: 3, // 0-7 low-high
      interlaced: true,
      svgoPlugins: [{
        removeViewBox: false
      }]
    }))
    .pipe(gulp.dest(imagesDestination))
    .pipe(notify({
      message: 'TASK: "images" Completed! 💯',
      onLast: true
    }));
});


/**
 * WP POT Translation File Generator.
 *
 * * This task does the following:
 *     1. Gets the source of all the PHP files
 *     2. Sort files in stream by path or any custom sort comparator
 *     3. Applies wpPot with the variable set at the top of this file
 *     4. Generate a .pot file of i18n that can be used for l10n to build .mo file
 */
gulp.task('translate', function() {
  return gulp.src(projectPHPWatchFiles)
    .pipe(sort())
    .pipe(wpPot({
      domain: text_domain,
      package: packageName,
      bugReport: bugReport,
      lastTranslator: lastTranslator,
      team: team
    }))
    .pipe(gulp.dest(translationDestination + '/' + translationFile))
    .pipe(notify({
      message: 'TASK: "translate" Completed! 💯',
      onLast: true
    }))

});

/** Edited by alexdisdier
 * Task: `packageSite`.
 *
 */

gulp.task('packageReady', function () {
   return gulp.src([
     phpSRC,
     productURL + 'README.md',
     productURL + '**/*.phtml',
     productURL + 'application/www/*.css',
     productURL + 'application/www/*.map',
     jsCustomDestination + 'vendors.min.js',
     jsCustomDestination + 'custom.min.js',
     jsCustomDestination + 'vendors.js',
     jsCustomDestination + 'custom.js',
     assetsURL + 'fonts/**',
     imagesDestination + '*.{png,jpg,gif,svg}',
   ], {
       base: productURL,
   })
   .pipe(gulp.dest(dist))
   .pipe( notify( { message: 'TASK: "packageSite" Completed! 💯', onLast: true } ) );
 });

 gulp.task('zip', () =>
    gulp.src([
          '!dist/install-vcard.php', // <== !
          'dist/**'
        ])
         .pipe(zip('vcard_archive.zip'))
         .pipe(gulp.dest(productURL + 'dist/'))
         .pipe( notify( { message: 'TASK: "Zipppppp" Completed! 💯', onLast: true } ) )
 );

 gulp.task('packageSite', gulpSequence('packageReady', 'zip'));
/**
 * Watch Tasks.
 *
 * Watches for file changes and runs specific tasks.
 */
gulp.task('default', ['styles', 'vendorsJs', 'customJS', 'images', 'browser-sync'], function() {
  gulp.watch(projectPHPWatchFiles, reload); // Reload on PHP file changes.
  gulp.watch(projectPhtmlWatchFiles, reload); // Reload on Phtml file changes.
  gulp.watch(styleWatchFiles, ['styles']); // Reload on SCSS file changes.
  gulp.watch(vendorsJSWatchFiles, ['vendorsJs', reload]); // Reload on vendorsJs file changes.
  gulp.watch(customJSWatchFiles, ['customJS', reload]); // Reload on customJS file changes.
  gulp.watch(indexVueWatch, [reload]); // Reload on indexVue file changes.
});
