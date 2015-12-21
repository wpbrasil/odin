/* jshint node:true */
module.exports = function( grunt ) {
	'use strict';

	require( 'load-grunt-tasks' )( grunt );

	var odinConfig = {

		// gets the package vars
		pkg: grunt.file.readJSON( 'package.json' ),

		// setting folder templates
		dirs: {
			css: '../assets/css',
			js: '../assets/js',
			sass: '../assets/sass',
			images: '../assets/images',
			fonts: '../assets/fonts',
			core: '../core',
			tmp: 'tmp'
		},

		// javascript linting with jshint
		jshint: {
			options: {
				jshintrc: '<%= dirs.js %>/.jshintrc'
			},
			all: [
				'Gruntfile.js',
				'<%= dirs.js %>/main.js'
			]
		},

		// uglify to concat and minify
		uglify: {
			dist: {
				files: {
					'<%= dirs.js %>/main.min.js': [
						'<%= dirs.js %>/libs/*.js', // External libs/plugins
						'<%= dirs.js %>/main.js'    // Custom JavaScript
					]
				}
			},
			bootstrap: {
				files: {
					'<%= dirs.js %>/libs/bootstrap.min.js': [
						'<%= dirs.js %>/bootstrap/transition.js',
						'<%= dirs.js %>/bootstrap/alert.js',
						'<%= dirs.js %>/bootstrap/button.js',
						'<%= dirs.js %>/bootstrap/carousel.js',
						'<%= dirs.js %>/bootstrap/collapse.js',
						'<%= dirs.js %>/bootstrap/dropdown.js',
						'<%= dirs.js %>/bootstrap/modal.js',
						'<%= dirs.js %>/bootstrap/tooltip.js',
						'<%= dirs.js %>/bootstrap/popover.js',
						'<%= dirs.js %>/bootstrap/scrollspy.js',
						'<%= dirs.js %>/bootstrap/tab.js',
						'<%= dirs.js %>/bootstrap/affix.js'
					]
				}
			}
		},

		// compile scss/sass files to CSS
		sass: {
			dist: {
				options: {
					style: 'compressed',
					sourcemap: 'none'
				},
				files: [{
					expand: true,
					cwd: '<%= dirs.sass %>',
					src: ['*.scss'],
					dest: '<%= dirs.css %>',
					ext: '.css'
				}]
			}
		},

		// watch for changes and trigger sass, jshint, uglify and livereload browser
		watch: {
			sass: {
				files: [
					'<%= dirs.sass %>/**'
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
					'<%= dirs.css %>/*.css',
					'<%= dirs.js %>/*.js',
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
					cwd: '<%= dirs.images %>/',
					src: '**/*.{png,jpg,gif}',
					dest: '<%= dirs.images %>/'
				}]
			}
		},

		// deploy via rsync
		rsync: {
			options: {
				args: ['--verbose'],
				exclude: [
					'**.DS_Store',
					'**Thumbs.db',
					'.editorconfig',
					'.git/',
					'.gitignore',
					'.jshintrc',
					'sass/',
					'src/',
					'README.md',
					'.ftppass'
				],
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
				exclusions: [
					'../**.DS_Store',
					'../**Thumbs.db',
					'../.git/*',
					'../*.md',
					'../.gitignore',
					'../assets/js/**bootstrap',
					'../assets/js/**libs',
					'../assets/js/plugins.js',
					'../assets/js/main.js',
					'../*.zip',
					'../*.sublime-project',
					'../*.sublime-workspace',
					'../src/**',
					'../.ftppass'
				]
			}
		},

		// zip the theme
		zip: {
			dist: {
				cwd: '../',
				src: [
					'../**',
					'!../src/**',
					'!../**.md',
					'!<%= dirs.sass %>/**',
					'!<%= dirs.js %>/bootstrap/**',
					'!<%= dirs.js %>/libs/**',
					'!../**.zip',
					'<%= dirs.js %>/main.min.js'
				],
				dest: '../<%= pkg.name %>.zip'
			}
		},

		// downloads dependencies
		curl: {
			bootstrap_sass: {
				src: 'https://github.com/twbs/bootstrap-sass/archive/master.zip',
				dest: '<%= dirs.tmp %>/bootstrap-sass.zip'
			},
			woocommerce_sass: {
				src: 'https://github.com/woothemes/woocommerce/archive/master.zip',
				dest: '<%= dirs.tmp %>/woocommerce-sass.zip'
			}
		},

		// unzip files
		unzip: {
			bootstrap_scss: {
				src: '<%= dirs.tmp %>/bootstrap-sass.zip',
				dest: '<%= dirs.tmp %>/'
			},
			woocommerce_scss: {
				src: '<%= dirs.tmp %>/woocommerce-sass.zip',
				dest: '<%= dirs.tmp %>/'
			}
		},

		// renames and moves directories and files
		rename: {
			bootstrap_scss: {
				src: '<%= dirs.tmp %>/bootstrap-sass-master/assets/stylesheets',
				dest: '<%= dirs.sass %>/bootstrap'
			},
			bootstrap_js: {
				src: '<%= dirs.tmp %>/bootstrap-sass-master/assets/javascripts/bootstrap',
				dest: '<%= dirs.js %>/bootstrap'
			},
			bootstrap_fonts: {
				src: '<%= dirs.tmp %>/bootstrap-sass-master/assets/fonts/bootstrap',
				dest: '<%= dirs.fonts %>/bootstrap'
			},
			woocommerce_scss: {
				src: '<%= dirs.tmp %>/woocommerce-master/assets/css',
				dest: '<%= dirs.sass %>/woocommerce'
			},
			woocommerce_scss_woocommerce: {
				src: '<%= dirs.sass %>/woocommerce/woocommerce.scss',
				dest: '<%= dirs.sass %>/woocommerce/_woocommerce.scss'
			},
			woocommerce_scss_woocommerce_layout: {
				src: '<%= dirs.sass %>/woocommerce/woocommerce-layout.scss',
				dest: '<%= dirs.sass %>/woocommerce/_woocommerce-layout.scss'
			},
			woocommerce_scss_woocommerce_smallscreen: {
				src: '<%= dirs.sass %>/woocommerce/woocommerce-smallscreen.scss',
				dest: '<%= dirs.sass %>/woocommerce/_woocommerce-smallscreen.scss'
			},
			woocommerce_fonts: {
				src: '<%= dirs.tmp %>/woocommerce-master/assets/fonts',
				dest: '<%= dirs.fonts %>/woocommerce'
			},
			woocommerce_images: {
				src: '<%= dirs.tmp %>/woocommerce-master/assets/images',
				dest: '<%= dirs.images %>/woocommerce'
			}
		},

		// clean directories and files
		clean: {
			options: {
				force: true
			},
			bootstrap_prepare: [
				'<%= dirs.tmp %>',
				'<%= dirs.sass %>/bootstrap/',
				'<%= dirs.js %>/bootstrap/',
				'<%= dirs.js %>/libs/bootstrap.min.js',
				'<%= dirs.fonts %>/bootstrap/'
			],
			bootstrap: [
				'<%= dirs.tmp %>'
			],
			woocommerce_prepare: [
				'<%= dirs.tmp %>',
				'<%= dirs.sass %>/woocommerce/',
				'<%= dirs.fonts %>/woocommerce/',
				'<%= dirs.images %>/woocommerce/'
			],
			woocommerce: [
				'<%= dirs.sass %>/woocommerce/{activation,admin,chosen,dashboard,menu,prettyPhoto,reports-print,select2}**',
				'<%= dirs.sass %>/woocommerce/*.css',
				'<%= dirs.tmp %>'
			]
		},

		replace: {
			woocommerce: {
				src: ['<%= dirs.sass %>/woocommerce/*.scss'],
		 		overwrite: true,
				replacements: [{
					from: /@import ".+";\n/g,
					to: ''
				},{
					from: '../fonts/',
					to: '../fonts/woocommerce/'
				},{
					from: '../images/',
					to: '../images/woocommerce/'
				}]
			}
		}

	};

	// Initialize Grunt Config
	// --------------------------
	grunt.initConfig( odinConfig );

	// Register Tasks
	// --------------------------

	// Default Task
	grunt.registerTask( 'default', [
		'jshint',
		'sass',
		'uglify'
	] );

	// Optimize Images Task
	grunt.registerTask( 'optimize', ['imagemin'] );

	// Deploy Tasks
	grunt.registerTask( 'ftp', ['ftp-deploy'] );

	// Compress
	grunt.registerTask( 'compress', [
		'default',
		'zip'
	] );

	// Bootstrap Task
	grunt.registerTask( 'bootstrap', [
		'clean:bootstrap_prepare',
		'curl:bootstrap_sass',
		'unzip:bootstrap_scss',
		'rename:bootstrap_scss',
		'rename:bootstrap_js',
		'rename:bootstrap_fonts',
		'clean:bootstrap',
		'uglify:bootstrap',
		'sass'
	] );

	// Woocommerce Task
	grunt.registerTask( 'woo', [
		'clean:woocommerce_prepare',
		'curl:woocommerce_sass',
		'unzip:woocommerce_scss',
		'rename:woocommerce_scss',
		'rename:woocommerce_scss_woocommerce',
		'rename:woocommerce_scss_woocommerce_layout',
		'rename:woocommerce_scss_woocommerce_smallscreen',
		'rename:woocommerce_fonts',
		'rename:woocommerce_images',
		'clean:woocommerce',
		'replace:woocommerce',
		'sass'
	] );

	// Short aliases
	grunt.registerTask( 'w', ['watch'] );
	grunt.registerTask( 'o', ['optimize'] );
	grunt.registerTask( 'f', ['ftp'] );
	grunt.registerTask( 'r', ['rsync'] );
	grunt.registerTask( 'c', ['compress'] );
};
