'use strict';
module.exports = function(grunt) {

    grunt.initConfig({

        // live reload, in case you want to change the port or anything
        livereload: {
        },

        // javascript linting with jshint
        jshint: {
            options: {
                "bitwise": true,
                "eqeqeq": true,
                "eqnull": true,
                "immed": true,
                "newcap": true,
                "es5": true,
                "esnext": true,
                "latedef": true,
                "noarg": true,
                "node": true,
                "undef": true,
                "browser": true,
                "trailing": true,
                "jquery": true,
                "curly": true
            },
            all: [
                'Gruntfile.js',
                '../js/main.js'
            ]
        },

        // uglify to concat and minify
        uglify: {
            dist: {
                files: {
                    '../js/main.min.js': [
                        '../js/libs/*.js',
                        '../js/main.js'
                    ]
                }
            }
        },

        // compass and scss
        compass: {
            dist: {
                options: {
                    config: 'config.rb',
                    force: true,
                    outputStyle: 'compressed'
                }
            }
        },

        // regarde to watch for changes and trigger compass, jshint, uglify and live reload
        regarde: {
            compass: {
                files: '../scss/**/*',
                tasks: ['compass', 'livereload']
            },
            js: {
                files: '<%= jshint.all %>',
                tasks: ['jshint', 'uglify', 'livereload']
            }
        },

        // image optimization
        imagemin: {
            dist: {
                options: {
                    optimizationLevel: 7,
                    progressive: true
                },
                files: [{
                    expand: true,
                    cwd: '../images/',
                    src: '../images/**',
                    dest: '../images/'
                }]
            }
        },
    });

    // load tasks
    grunt.loadNpmTasks('grunt-contrib-livereload');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-compass');
    grunt.loadNpmTasks('grunt-contrib-imagemin');
    grunt.loadNpmTasks('grunt-regarde');
    // grunt.loadNpmTasks('grunt-filesize');

    // register task
    grunt.registerTask('default', [
        'jshint',
        'compass',
        'uglify'
    ]);

    // watch task
    grunt.registerTask('watch', [
        'livereload-start',
        'jshint',
        'compass',
        'uglify',
        'regarde'
    ]);

};
