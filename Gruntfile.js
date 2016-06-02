/* jshint node:true */
module.exports = function( grunt ) {
	'use strict';

	require( 'load-grunt-tasks' )( grunt );

	var odinConfig = {

		// gets the package vars
		pkg: grunt.file.readJSON( 'package.json' ),

		// javascript linting with jshint
		jshint: {
			options: {
				jshintrc: '.jshintrc'
			},
			all: [
				'Gruntfile.js',
				'<%= pkg.dirs.js %>/main.js'
			]
		},

		// uglify to concat and minify
		uglify: {
			bower: {
				files: {
					'<%= pkg.dirs.js %>/bower.js': [
						// jquery
						// '<%= pkg.dirs.bower %>/jquery/dist/jquery.min.js',
						// bootstrap
						'<%= pkg.dirs.bower %>/bootstrap-sass/assets/javascripts/bootstrap/transition.js',
						'<%= pkg.dirs.bower %>/bootstrap-sass/assets/javascripts/bootstrap/alert.js',
						'<%= pkg.dirs.bower %>/bootstrap-sass/assets/javascripts/bootstrap/button.js',
						'<%= pkg.dirs.bower %>/bootstrap-sass/assets/javascripts/bootstrap/carousel.js',
						'<%= pkg.dirs.bower %>/bootstrap-sass/assets/javascripts/bootstrap/collapse.js',
						'<%= pkg.dirs.bower %>/bootstrap-sass/assets/javascripts/bootstrap/dropdown.js',
						'<%= pkg.dirs.bower %>/bootstrap-sass/assets/javascripts/bootstrap/modal.js',
						'<%= pkg.dirs.bower %>/bootstrap-sass/assets/javascripts/bootstrap/tooltip.js',
						'<%= pkg.dirs.bower %>/bootstrap-sass/assets/javascripts/bootstrap/popover.js',
						'<%= pkg.dirs.bower %>/bootstrap-sass/assets/javascripts/bootstrap/scrollspy.js',
						'<%= pkg.dirs.bower %>/bootstrap-sass/assets/javascripts/bootstrap/tab.js',
						'<%= pkg.dirs.bower %>/bootstrap-sass/assets/javascripts/bootstrap/affix.js',
						// jquery.fitvids
						'<%= pkg.dirs.bower %>/jquery.fitvids/jquery.fitvids.js',
						// moment
						'<%= pkg.dirs.bower %>/moment/min/moment.min.js',
						'<%= pkg.dirs.bower %>/moment/locale/pt-br.js'
					]
				},
				options: {
        			beautify: true
      			}
			},
			dist: {
				files: {
					'<%= pkg.dirs.js %>/main.min.js': [
						'<%= pkg.dirs.js %>/bower.js', 	// external vendor/plugins
						'<%= pkg.dirs.js %>/main.js' 	// custom javaScript
					]
				},
				options: {
					banner: '/*!\n' +
				            ' * <%= pkg.title %> v<%= pkg.version %> (<%= pkg.homepage %>)\n' +
				            ' * Updated <%= grunt.template.today("yyyy-mm-dd") %> <%= pkg.author %>\n' +
				            ' */\n'
			    }
			}
		},

		// compile scss/sass files to CSS
		sass: {
			dist: {
				options: {
					style: 'expanded', // { compressed : expanded }
					sourcemap: 'none',
					loadPath: require( 'node-bourbon' ).includePaths
				},
				files: [{
					expand: true,
					cwd: '<%= pkg.dirs.sass %>',
					src: ['*.scss'],
					dest: '<%= pkg.dirs.css %>',
					ext: '.css'
				}]
			}
		},

		// watch for changes and trigger sass, jshint, uglify and livereload browser
		// required enable livereload.js script in inc/enqueue-scripts.php
		watch: {
			sass: {
				files: [
					'<%= pkg.dirs.sass %>/**'
				],
				tasks: ['sass']
			},
			js: {
				files: [
					'<%= jshint.all %>'
				],
				tasks: ['jshint', 'uglify']
			},
			livereload: {
				options: {
					livereload: true
				},
				files: [
					'<%= pkg.dirs.css %>/*.css',
					'<%= pkg.dirs.js %>/*.js',
					'**/*.php'
				]
			},
			options: {
				spawn: false
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
					filter: 'isFile',
					cwd: '<%= pkg.dirs.images %>/',
					src: '**/*.{png,jpg,gif}',
					dest: '<%= pkg.dirs.images %>/'
				}]
			}
		},

		// deploy via rsync
		rsync: {
			options: {
				args: ['--verbose'],
				exclude: '<%= pkg.ignoreDeploy %>',
				recursive: true,
				syncDest: true
			},
			staging: {
				options: {
					src: '/',
					dest: '~/PATH/wp-content/themes/odin',
					host: 'user@host.com'
				}
			},
			production: {
				options: {
					src: '/',
					dest: '~/PATH/wp-content/themes/odin',
					host: 'user@host.com'
				}
			}
		},

		// ftp deploy
		// ref: https://npmjs.org/package/grunt-ftp-deploy
		'ftp-deploy': {
			build: {
				auth: {
					host: 'ftp.SEU-SITE.com',
					port: 21,
					authPath: '.ftppass',
					authKey: 'key_for_deploy'
				},
				src: '/',
				dest: '/PATH/wp-content/themes/odin',
				exclusions: '<%= pkg.ignoreDeploy %>'
			}
		},

		// zip the theme
		zip: {
			dist: {
				src: '<%= pkg.zip %>',
				dest: '<%= pkg.name %>.zip'
			}
		},

		// update packages npm
		exec: {
	      'bower-install': {
	        command: 'rm -rf <%= pkg.dirs.bower %>/** && bower install'
	      },
	      'npm-update': {
	        command: 'ncu -u'
	      }
	    }

	};

	// Initialize Grunt Config
	// --------------------------
	grunt.initConfig( odinConfig );
	require('time-grunt')(grunt);

	// Register Tasks
	// --------------------------

	// Default Task
	grunt.registerTask( 'default', [ 'jshint', 'sass', 'uglify'	] );

	// Assets css/js/images Tasks
	grunt.registerTask( 'css', [ 'sass' ] );
	grunt.registerTask( 'js', [ 'jshint', 'uglify' ] );
	grunt.registerTask( 'img', ['optimize'] );

	// Bower Update Tasks ( required `npm install -g bower` before )
	// ref: https://www.npmjs.com/package/bower
	grunt.registerTask( 'bower', [ 'exec:bower-install', 'default' ] );
	grunt.registerTask( 'b', [ 'bower' ] );

	// Compress Theme Tasks
	grunt.registerTask( 'zip-theme', [ 'default', 'zip' ] );
	grunt.registerTask( 'z', [ 'zip-theme' ] );

	// Deploy FTP Tasks
	grunt.registerTask( 'ftp', ['ftp-deploy'] );
	grunt.registerTask( 'f', ['ftp'] );

	// Deploy rsync Tasks
	grunt.registerTask( 'ftp-rsync', ['rsync'] );
	grunt.registerTask( 'fr', ['ftp-rsync'] );

	// Watch Task
	grunt.registerTask( 'watch', ['watch'] );
	grunt.registerTask( 'w', ['watch'] );

	// Npm Update Task ( required `npm install -g ncu` before )
	// ref: https://www.npmjs.com/package/npm-check-updates
	grunt.registerTask( 'npm-update', ['exec:npm-update'] );
	grunt.registerTask( 'ncu', ['npm-update'] );
};
