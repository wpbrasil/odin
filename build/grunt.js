/* global module:false */

/**
 * Requirements:
 *
 * NodeJS: http://nodejs.org/
 *
 * Instalation:
 *
 * $ cd ROOT_PATH/wp-content/themes/odin/build/
 * $ sudo npm install grunt-css@0.3.2
 * $ sudo npm install grunt-compass
 */

module.exports = function(grunt) {

    // Project configuration.
    grunt.initConfig({
        meta: {
            // Default vars
            theme_name: 'Odin',
            theme_uri: 'https://github.com/wpbrasil/odin',
            description: 'Tema base para desenvolvimento em WordPress.',
            author: 'Grupo WordPress Brasil',
            author_uri: 'http://www.facebook.com/groups/wordpress.brasil/',
            version: '0.1',
            // Javascript
            banner: '/*! <%= meta.theme_name %> - v<%= meta.version %> */',
            // Wordpress style.css
            wpblock: '/*!\n' +
            'Theme Name: <%= meta.theme_name %>\n' +
            'Theme URI: <%= meta.theme_uri %>\n' +
            'Description: <%= meta.description %>\n' +
            'Author: <%= meta.author %>\n' +
            'Author URI: <%= meta.author_uri %>\n' +
            'Version: <%= meta.version %>\n' +
            '*/'
        },
        concat: {
            dist: {
                src: ['<banner:meta.banner>', '../js/libs/*.js', '../js/main.js'],
                dest: '../js/main.min.js'
            }
        },
        min: {
            dist: {
                src: ['<banner:meta.banner>', '<config:concat.dist.dest>'],
                dest: '<config:concat.dist.dest>'
            }
        },
        cssmin: {
            dist: {
                src: ['<banner:meta.wpblock>', '../style.css'],
                dest: '../style.css'
            }
        },
        watch: {
            files: ['../js/main.js', '../sass/**'],
            tasks: 'default'
        },
        jshint: {
            options: {
                curly: true,
                eqeqeq: true,
                immed: true,
                latedef: true,
                newcap: true,
                noarg: true,
                sub: true,
                undef: true,
                boss: true,
                eqnull: true,
                jquery: true,
                devel: true,
                browser: true
            },
            globals: {}
        },
        uglify: {},
        compass: {
            dist: {}
        }
    });

    // Default task.
    grunt.registerTask('default', 'concat min compass cssmin');

    // Compass tasks
    grunt.loadNpmTasks('grunt-compass');

    // CSS tasks
    grunt.loadNpmTasks('grunt-css');
};
