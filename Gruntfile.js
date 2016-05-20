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
				jshintrc: '<%= pkg.dirs.js %>/.jshintrc'
			},
			all: [
				'Gruntfile.js',
				'<%= pkg.dirs.js %>/main.js'
			]
		},

		// uglify to concat and minify
		uglify: {
			dist: {
				files: {
					'<%= pkg.dirs.js %>/main.min.js': [
						'<%= pkg.dirs.js %>/bower.js', // external vendor/plugins
						'<%= pkg.dirs.js %>/main.js' // custom javaScript
					]
				},
				options: {
					banner: '/*!\n' +
				            ' * <%= pkg.title %> v<%= pkg.version %> (<%= pkg.homepage %>)\n' +
				            ' * Updated <%= grunt.template.today("yyyy-mm-dd") %> <%= pkg.author %>\n' +
				            ' */\n'
			    }
			},
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
			}
		},

		// clean directories and files
		clean: {
			options: {
				force: true
			},
			bower: [
				// bower
				'<%= pkg.dirs.bower %>/**',
				// bootstrap
				'<%= pkg.dirs.sass %>/vendor/bootstrap/',
				'<%= pkg.dirs.fonts %>/bootstrap/',
				// animate.css
				'<%= pkg.dirs.sass %>/vendor/animate.css/'
			]
		},

		// copy css, scss, fonts or others files of dependencies bower for assets
		copy: {
			bower: {
				files: [
					// bootstrap
					{ expand: true, cwd: '<%= pkg.dirs.bower %>/bootstrap-sass/assets/stylesheets/', src: '**', dest: '<%= pkg.dirs.sass %>/vendor/bootstrap/' },
					{ expand: true, cwd: '<%= pkg.dirs.bower %>/bootstrap-sass/assets/fonts/bootstrap/', src: '**', dest: '<%= pkg.dirs.fonts %>/bootstrap/' },
					// animate.css
					{ expand: true, cwd: '<%= pkg.dirs.bower %>/animate.css/', src: 'animate.css', dest: '<%= pkg.dirs.sass %>/vendor/animate.css/', rename: function(path){ return path + 'animate.scss'; } }
				]
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
					'../**/*.php'
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
					src: '../',
					dest: '~/PATH/wp-content/themes/odin',
					host: 'user@host.com'
				}
			},
			production: {
				options: {
					src: '../',
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
					authPath: '../.ftppass',
					authKey: 'key_for_deploy'
				},
				src: '../',
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
	      bowerInstall: {
	        command: 'bower install'
	      },
	      npmUpdate: {
	        command: 'ncu -u' // install global ncu https://www.npmjs.com/package/npm-check-updates
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
	grunt.registerTask( 'default', [
		'jshint',
		'sass',
		'uglify'
	] );

	// Bower Update Task
	grunt.registerTask( 'bower', [
		'clean:bower',
		'exec:bowerInstall',
		'copy:bower',
		'sass',
		'uglify'
	] );

	// Optimize Images Task
	grunt.registerTask( 'optimize', ['imagemin'] );

	// Deploy Tasks
	grunt.registerTask( 'ftp', ['ftp-deploy'] );

	// Npm Update
	grunt.registerTask( 'npm-update', ['exec:npmUpdate'] );

	// Compress
	grunt.registerTask( 'zip-theme', [
		'default',
		'zip'
	] );

	// Short aliases
	grunt.registerTask( 'w', ['watch'] );
	grunt.registerTask( 'o', ['optimize'] );
	grunt.registerTask( 'f', ['ftp'] );
	grunt.registerTask( 'r', ['rsync'] );
	grunt.registerTask( 'z', ['zip'] );
};
