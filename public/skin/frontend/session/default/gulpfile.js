/* set theme name and paths */

var themeName = 'session',
    themeURL = 'mast.dev',
    publicJsDir = '../../../../js/',
    toolsDir = '../../../../../tools/',
    patternLabDir = 'pattern-lab/'
;

/* global module, require */

var gulp = require('gulp'),
    $ = require('gulp-load-plugins')({
        pattern: ['gulp-*']
    }),
    webpack = require('webpack'),
    browserSync = require('browser-sync'),
    reload = browserSync.reload;

/** serve **/

gulp.task('serve', ['build'], function() {

    browserSync.init({
        proxy: themeURL,
        notify: false,
        startPath: '/style-guide'
    });

    gulp.watch('./css/**/*.scss', ['sass', 'sass-print']);

    gulp.watch([
        './js/**/*.js',
        '!./js/dist/*.js'
    ], ['build-theme-scripts']);

    gulp.watch('./images-original/**/*', ['images']);

    gulp.watch([
        patternLabDir + '**/*'
    ], ['styleguide']);

});

/** sass **/

gulp.task('sass', function() {
    return gulp.src([
        './css/sass/*.scss',
        '!./css/sass/print/*.scss'])
        .pipe($.sass({
            includePaths: [
                './bower_components/bourbon/app/assets/stylesheets',
                './bower_components/neat/app/assets/stylesheets'
            ],
            outputStyle: 'compressed'
        }))
        .pipe(gulp.dest('./css'))
        .pipe(reload({stream: true}));
});
gulp.task('sass-print', function() {
    return gulp.src(['./css/sass/print/*.scss'])
        .pipe($.sass({
            outputStyle: 'compressed'
        }))
        .pipe(gulp.dest('./css'))
        .pipe(reload({stream: true}));
});

/** scripts **/

gulp.task('build-lib-scripts', function () {
    // reduces and concatenates library files into a single file request
    gulp.src([
        publicJsDir + 'prototype/prototype.js',
        publicJsDir + 'lib/ccard.js',
        publicJsDir + 'prototype/validation.js',
        publicJsDir + 'scriptaculous/builder.js',
        publicJsDir + 'scriptaculous/effects.js',
        publicJsDir + 'scriptaculous/dragdrop.js',
        publicJsDir + 'scriptaculous/controls.js',
        publicJsDir + 'scriptaculous/slider.js',
        publicJsDir + 'varien/js.js',
        publicJsDir + 'varien/form.js',
        publicJsDir + 'varien/menu.js',
        publicJsDir + 'mage/translate.js',
        publicJsDir + 'mage/cookies.js',
        './bower_components/jquery/dist/jquery.min.js'
        ])
        .pipe($.concat('core.min.js'))
        .pipe($.uglify({mangle: false}))
        .pipe(gulp.dest(publicJsDir + themeName + '/'));

    // third party libraries that can be lazy loaded
    gulp.src([
        './js/lib/**/*.js',
        '!./js/lib/polyfills/*.js'
    ])
        .pipe($.concat('dist/vendor.min.js'))
        .pipe($.uglify())
        .pipe(gulp.dest('./js/'));

    //IE8 Polyfills!
    gulp.src([
        './js/lib/polyfills/*.js'
    ])
        .pipe($.concat('dist/ie8.min.js'))
        .pipe($.uglify())
        .pipe(gulp.dest('./js/'));

    //IE9 Polyfills
    gulp.src([
        './js/lib/polyfills/media.match.min.js'
    ])
        .pipe($.concat('dist/ie9.min.js'))
        .pipe($.uglify())
        .pipe(gulp.dest('./js/'));
});

/**
 * Theme-specific scripts
 * All first-party code written by Session is bundled by
 * WebPack.
 * WebPack auto-loads re-usable modules from session_modules
 * and outputs them as page-specific bundles for use in
 * sites.
 **/
gulp.task('build-theme-scripts', function () {
    /* jshint */
    gulp.src([
        './js/*.js',
        './js/session_modules/*.js'
    ])
        .pipe($.jshint())
        .pipe($.jshint.reporter('jshint-stylish'));

    /**
     * WebPack configuration
     * See: http://webpack.github.io/docs/configuration.html
     */
    webpack({
        /**
         * Entry file bundles
         * Split into page-specific scripts to reduce file weight
         * Create as many of these as you need
         */
        entry: {
            global: './js/global',
        },

        /**
         * Processed files for use on site
         * output to js/dist.
         * [name] is placeholder for entry property name
         */
        output: {
            path: 'js/dist',
            filename: '[name].min.js'
        },

        /**
         * Environment variables imported implicitly into modules
         * e.g. $ is overwritten as jQuery instead of prototype
         */
        module: {
            loaders: [
                {
                    test: /\.js$/,
                    loader: "imports?$=jquery"
                }
            ]
        },

        plugins: [
            // Comment out the following line to turn off script minimising
            new webpack.optimize.UglifyJsPlugin()
        ],

        /**
         * Module aliases for imported global variables
         * e.g. require('jquery') returns global jQuery object
         */
        externals: {
            'jquery': 'jQuery'
        }
    }, function(err, stats) {

    });

});

/** style guide **/

gulp.task('styleguide', $.shell.task([
    'php ' + toolsDir + 'pattern-lab/core/builder.php -g'
]));

/** images **/

gulp.task('images', function() {
    'use strict';

    return gulp.src('./images-original/**/*')
        .pipe($.cache($.imagemin({
            optimizationLevel: 5,
            progressive: true,
            interlaced: true
        })))
        .pipe(gulp.dest('./images'))
        .pipe(browserSync.reload({stream: true}));
});

/** default - runs serve for development work (serve calls build initially) **/
gulp.task('default', ['serve']);

/** build - prepares and updates all assets **/
gulp.task('build', ['build-lib-scripts', 'build-theme-scripts', 'images', 'sass', 'sass-print', 'styleguide']);

/** deploy - builds and does anything else necessary before deploying **/
gulp.task('deploy', ['build']);
