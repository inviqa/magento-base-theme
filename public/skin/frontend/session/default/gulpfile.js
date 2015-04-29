/*global module, require */

var gulp = require('gulp'),
    $ = require('gulp-load-plugins')({
        pattern: ['gulp-*']
    }),
    browserSync = require('browser-sync'),
    reload = browserSync.reload;

/** serve **/

gulp.task('serve', ['sass'], function() {

    browserSync.init({
        proxy: "mast.dev"
    });

    gulp.watch('./sass/*.scss', ['sass']);

    gulp.watch([
        './js/**/*.js',
        '!./js/scripts.min.js',
        '!./js/scripts-ie8.min.js',
        '!./js/scripts-ie9.min.js'
    ], ['scripts']);

    gulp.watch('./images-original/**/*', ['images']);

});

/** sass **/

gulp.task('sass', function() {
    return gulp.src("./sass/*.scss")
        .pipe($.sass({
            includePaths: [
                './bower_components/bourbon/app/assets/stylesheets',
                './bower_components/neat/app/assets/stylesheets'
            ],
            outputStyle: "compressed"
        }))
        .pipe(gulp.dest("./css"))
        .pipe(reload({stream: true}));
});

/** scripts **/

var publicJsDir = '../../../../js/',
    themeName = 'session';

gulp.task('build-scripts', function () {
    //replaces multiple calls to js files with one single one with magento core files
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
        './bower_components/jquery/dist/jquery.min.js',
        './js/lib/noconflict.js'])
        .pipe($.concat('core.min.js'))
        .pipe($.uglify({mangle: false}))
        .pipe(gulp.dest(publicJsDir + themeName + '/'));

    //IE8 Polyfills!
    gulp.src([
        './js/lib/polyfills/*.js'
    ])
        .pipe($.concat('scripts-ie8.min.js'))
        .pipe($.uglify())
        .pipe(gulp.dest('./js/'));

    //IE9 Polyfills
    gulp.src([
        './js/lib/polyfills/media.match.min.js'
    ])
        .pipe($.concat('scripts-ie9.min.js'))
        .pipe($.uglify())
        .pipe(gulp.dest('./js/'));
});

/** scripts **/

gulp.task('scripts', function () {

    /* jshint */
    gulp.src([
        './js/' + themeName + '.js',
        './js/app/*.js'
    ])
        .pipe($.jshint())
        .pipe($.jshint.reporter('jshint-stylish'));

    /* scritpts.min.js concatenate and minify */
    gulp.src([
        './js/lib/*.js',
        './js/lib/plugins/*.js',
        '!./js/lib/noconflict.js',
        '!./js/lib/modernizr.custom.js',
        './js/' + themeName + '.js',
        './js/app/*.js'
    ])
        .pipe($.concat('scripts.min.js'))
        .pipe($.uglify())
        .pipe(gulp.dest('./js/'))
        .pipe(browserSync.reload({stream: true}));

});

gulp.task('images', function() {
    "use strict";

    return gulp.src('./images-original/**/*')
        .pipe($.cache($.imagemin({
            optimizationLevel: 5,
            progressive: true,
            interlaced: true
        })))
        .pipe(gulp.dest('./images'))
        .pipe(browserSync.reload({stream: true}));
});

gulp.task('default', ['sass', 'build-scripts', 'images', 'serve']);