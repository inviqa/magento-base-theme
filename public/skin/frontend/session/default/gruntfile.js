/*global module, require */

module.exports = function(grunt) {
    'use strict';
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        var: {
            bowerDir: 'bower_components/',
            publicJsDir: '../../../../js/',/skin/frontend/session/default/gruntfile.js
            theme: 'session/default/',
            appDir: 'app/design/frontend/<%= var.theme %>',
            skinCssDir: 'css/',
            skinJsDir: 'js/',
            skinImagesDir: 'images/'
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
                files: ['<%= var.skinJsDir %>**/*.js', '!<%= var.skinJsDir %>scripts.min.js'],
                tasks: ['uglify'],
                options: {
                    livereload: true
                }
            },
            images: {
                files: ['images-original/**/*.{png,jpg,jpeg,gif}'],
                tasks: ['newer:imagemin']
            }
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
                    '<%= var.publicJsDir %>session/core.min.js': [
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
                        '<%= var.publicJsDir %>jquery/noconflict.js',
                        '<%= var.skinJsDir %>core-overwrites.js'
                    ],
                    '<%= var.skinJsDir %>scripts.min.js': [
                        '<%= var.skinJsDir %>lib/*.js',
                        '!<%= var.skinJsDir %>lib/modernizr.custom.js',
                        '<%= var.skinJsDir %>session.js',
                        '<%= var.skinJsDir %>app/*.js'
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
                    cwd: 'images-original/',
                    src: ['**/*.{png,jpg,jpeg,gif}'],
                    dest: 'images/'
                }]
            }
        },
        modernizr: {
            dist: {
                devFile: '<%= var.skinJsDir %>lib/modernizr.custom.js',
                outputFile: '<%= var.skinJsDir %>lib/modernizr.custom.js',
                extra: {
                    printshiv: true,
                    "cssclasses" : true
                },
                files : {
                    src: [
                        '<%= var.skinCssDir %>**/*.css',
                        '<%= var.skinJsDir %>**/*.js'
                    ]
                }
            }
        },
        clean: {
            js: ['<%= var.skinJsDir %>*.js', '!<%= var.skinJsDir %>session.js'],
            css: ['<%= var.skinCssDir %>*.css']
        }

    });

    require('time-grunt')(grunt);
    require('jit-grunt')(grunt);

    // Register tasks
    grunt.registerTask('build', ['sass', 'uglify', 'imagemin']);
    grunt.registerTask('dev', ['watch']);
};
