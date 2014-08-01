/*global module, require */
//test
module.exports = function(grunt) {
    'use strict';

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        var: {
            bowerDir: 'bower_components/',
            publicJsDir: 'public/js/',
            theme: 'session/default/',
            appDir: 'public/app/design/frontend/<%= var.theme %>',
            skinDir: 'public/skin/frontend/<%= var.theme %>',
            skinCssDir: '<%= var.skinDir %>css/',
            skinJsDir: '<%= var.skinDir %>js/',
            skinImagesDir: '<%= var.skinDir %>images/'
        },
        watch: {
            scss: {
                files: ['<%= var.skinCssDir %>**/*.{scss,sass}'],
                tasks: ['sass:dist']
            },
            css: {
                options: {
                    livereload: true
                },
                files: [
                    '<%= var.skinCssDir %>**/*.css'
                ]
            },
            scripts: {
                files: ['<%= var.skinJsDir %>_*.js'],
                tasks: ['uglify'],
                options: {
                    livereload: true
                }
            },
            //html: {
            //    options: {
            //        livereload: true
            //    },
            //    files: [
            //        '<%= var.appDir %>**/*.{phtml,xml}'
            //    ]
            //},
            //images: {
            //    files: ['<%= var.skinImagesDir %>/**/*.{png,jpg,jpeg,gif}'],
            //    tasks: ['newer:imagemin']
            //}
        },
        sass: {
            dist: {
                options: {
                    loadPath: '<%= var.skinCssDir %>sass',
                    style: 'compressed'
                },
                files: {
                    '<%= var.skinCssDir %>styles.css': '<%= var.skinCssDir %>styles.scss'
                }
            }
        },
        uglify: {
            dist: {
                options: {
                    compress: true,
                    mangle: false,
                    beautify: false,
                    report: 'min'
                },
                files: {
                    'public/js/session/core.min.js': [
                        '<%= var.publicJsDir %>prototype/prototype.js',
                        '<%= var.publicJsDir %>lib/ccard.js',
                        '<%= var.publicJsDir %>prototype/validation.js',
                        '<%= var.publicJsDir %>scriptaculous/builder.js',
                        '<%= var.publicJsDir %>scriptaculous/effects.js',
                        '<%= var.publicJsDir %>scriptaculous/dragdrop.js',
                        '<%= var.publicJsDir %>scriptaculous/controls.js',
                        '<%= var.publicJsDir %>scriptaculous/slider.js',
                        '<%= var.publicJsDir %>varien/js.js',
                        '<%= var.publicJsDir %>varien/form.js',
                        '<%= var.publicJsDir %>varien/menu.js',
                        '<%= var.publicJsDir %>mage/translate.js',
                        '<%= var.publicJsDir %>mage/cookies.js',
                        '<%= var.bowerDir %>jquery/dist/jquery.min.js',
                        '<%= var.publicJsDir %>jquery/noconflict.js'
                    ],
                    '<%= var.skinJsDir %>scripts.min.js': [
                        '<%= var.skinJsDir %>lib/*.js',
                        '!<%= var.skinJsDir %>lib/modernizr.custom.js',
                        '<%= var.skinJsDir %>session.js'
                    ]
                }
            }
        },
        imagemin: {
            options: {
                cache: false
            },
            dynamic: {
                files: [{
                    expand: true,
                    cwd: '<%= var.skinImagesDir %>',
                    src: ['**/*.{png,jpg,jpeg,gif}'],
                    dest: '<%= var.skinImagesDir %>'
                }]
            }
        },
        modernizr: {
            dist: {
                devFile: '<%= var.skinJsDir %>lib/modernizr.custom.js',
                outputFile: '<%= var.skinJsDir %>lib/modernizr.custom.js',
                extra: {
                    printshiv: true
                },
                files : {
                    src: [
                        '<%= var.skinCssDir %>**/*.css',
                        '<%= var.skinJsDir %>**/*.js'
                    ]
                }
            }
        }

    });

    // measures the time each task takes
    require('time-grunt')(grunt);
    require('jit-grunt')(grunt);

    // Register tasks
    grunt.registerTask('dev', ['watch']);
    grunt.registerTask('production', ['imagemin'])

};
