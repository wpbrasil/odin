/**
 * Gulp Packages.
 */

// General.
const gulp        = require('gulp');
const fs          = require('fs');
const del         = require('del');
const lazypipe    = require('lazypipe');
const plumber     = require('gulp-plumber');
const flatten     = require('gulp-flatten');
const tap         = require('gulp-tap');
const rename      = require('gulp-rename');
const header      = require('gulp-header');
const footer      = require('gulp-footer');
const fileinclude = require('gulp-file-include');
const ignore      = require('gulp-ignore');
const zip         = require('gulp-zip');
const browser     = require('browser-sync').create();
const package     = require('./package.json');

// Scripts and tests.
const jshint      = require('gulp-jshint');
const stylish     = require('jshint-stylish');
const concat      = require('gulp-concat');
const uglify      = require('gulp-uglify');

// Styles.
const sass        = require('gulp-sass');
const prefix      = require('gulp-autoprefixer');
const minify      = require('gulp-cssnano');
const bourbon     = require('node-bourbon');

// Media.
const imagemin    = require('gulp-imagemin');


/**
 * Config to project.
 */

const config = {
	proxy: 'local.odin',
	port: 3000
}


/**
 * Paths to project folders.
 */

const paths = {
    scripts: {
        input: 'src/js/*',
        output: 'assets/js/'
    },
    styles: {
        input: 'src/scss/**/*.{scss,sass}',
        output: 'assets/css/'
    },
    images: {
        input: 'src/img/**/*',
        output: 'assets/img/'
    },
    fonts: {
        input: 'src/fonts/**/*',
        output: 'assets/fonts/'
    },
    dist: {
		input:'**',
		ignore: ['dist/**', 'dist', '*.zip', '*.sublime-project', '*.sublime-workspace', 'node_modules/**', 'node_modules', 'bower_components/**', 'bower_components', 'src/**', 'src', 'bower.json' , 'gulpfile.js', 'package.json', 'README.md', 'yarn.lock'],
		output: 'dist/'
	}
};


/**
 * Template for banner to add to file headers.
 */

const banner = {
    full :
        '/*!\n' +
        ' * <%= package.name %> v<%= package.version %> <<%= package.homepage %>>\n'+
        ' * <%= package.title %> : <%= package.description %>\n' +
        ' * (c) ' + new Date().getFullYear() + ' <%= package.author.name %> <<%= package.author.url %>>\n' +
        ' * MIT License\n' +
        ' * <%= package.repository.url %>\n' +
        ' */\n\n',
    min :
        '/*!\n' +
        ' * <%= package.name %> v<%= package.version %> <<%= package.homepage %>>\n'+
        ' * <%= package.title %> : <%= package.description %>\n' +
        ' * (c) ' + new Date().getFullYear() + ' <%= package.author.name %> <<%= package.author.url %>>\n' +
        ' * MIT License\n' +
        ' * <%= package.repository.url %>\n' +
        ' */\n'
};


/**
 * Gulp Taks.
 */

// Lint, minify, and concatenate scripts.
gulp.task('build:scripts', function() {
    var jsTasks = lazypipe()
        .pipe(header, banner.full, { package : package })
        .pipe(gulp.dest, paths.scripts.output)
        .pipe(rename, { suffix: '.min' })
        .pipe(uglify)
        .pipe(header, banner.min, { package : package })
        .pipe(gulp.dest, paths.scripts.output);

    return gulp.src(paths.scripts.input)
        .pipe(plumber())
        .pipe(fileinclude({
            prefix: '//=',
            basepath: '@file'
        }))
        .pipe(tap(function (file, t) {
            if ( file.isDirectory() ) {
                var name = file.relative + '.js';
                return gulp.src(file.path + '/*.js')
                    .pipe(concat(name))
                    .pipe(jsTasks());
            }
        }))
        .pipe(jsTasks());
});

// Process, lint, and minify Sass files.
gulp.task('build:styles', function() {
    return gulp.src(paths.styles.input)
        .pipe(plumber())
        .pipe(sass({
            outputStyle: 'expanded',
            sourceComments: false,
            includePaths: bourbon.includePaths
        }))
        .pipe(flatten())
        .pipe(prefix({
            browsers: ['last 2 version', '> 1%'],
            cascade: true,
            remove: true
        }))
        .pipe(gulp.dest(paths.styles.output))
        .pipe(header(banner.full, { package : package }))
        .pipe(rename({ suffix: '.min' }))
        .pipe(minify({
            discardComments: {
                removeAll: true
            }
        }))
        .pipe(header(banner.min, { package : package }))
        .pipe(gulp.dest(paths.styles.output));
});

// Copy image files into output folder.
gulp.task('build:images', function() {
    return gulp.src(paths.images.input)
    	.pipe(imagemin())
        .pipe(plumber())
        .pipe(gulp.dest(paths.images.output));
});

// Copy fonts files into output folder.
gulp.task('build:fonts', function() {
    return gulp.src(paths.fonts.input)
        .pipe(plumber())
        .pipe(gulp.dest(paths.fonts.output));
});

// Lint scripts.
gulp.task('lint:scripts', function () {
    return gulp.src(paths.scripts.input)
        .pipe(plumber())
        .pipe(jshint())
        .pipe(jshint.reporter('jshint-stylish'));
});

// Remove pre-existing content from scripts output directory.
gulp.task('clean:scripts', function () {
    return del.sync(paths.scripts.output);
});

// Remove pre-existing content from styles output directory.
gulp.task('clean:styles', function () {
    return del.sync(paths.styles.output);
});

// Remove pre-existing content from images output directory.
gulp.task('clean:images', function () {
    return del.sync(paths.images.output);
});

// Remove pre-existing content from fonts output directory.
gulp.task('clean:fonts', function () {
    return del.sync(paths.fonts.output);
});

// Generate zip dist.
gulp.task('build:dist', function() {
    return gulp.src(paths.dist.input)
        .pipe(ignore.exclude(paths.dist.ignore))
        .pipe(plumber())
        .pipe(zip(package.name + '-v' + package.version + '.zip'))
        .pipe(gulp.dest(paths.dist.output));
});

// Starts a BrowerSync instance.
gulp.task('serve', function(){
  browser.init({proxy: config.proxy, port: config.port, notify: false});
});

// Watch files for changes.
gulp.task('watch', function() {
    gulp.watch(paths.styles.input, ['styles', browser.reload]);
    gulp.watch(paths.scripts.input, ['scripts', browser.reload]);
    gulp.watch(['*.php','{inc,template-parts}/**/*.php']).on('change', browser.reload);
});


/**
 * Task Runners.
 */

// Compile all files (default).
gulp.task('default', [
    'scripts',
    'styles',
    'images',
    'fonts'
]);

// Compile, init serve and watch files.
gulp.task('start', [
	'default',
	'serve',
    'watch'
]);

// Generate dist.
gulp.task('dist', [
	'build:dist'
]);

// Deploy.
gulp.task('deploy', [
	// Coming soon...
]);

// Compile scripts files.
gulp.task('scripts', [
	'clean:scripts',
    'lint:scripts',
    'build:scripts'
]);

// Compile styles files.
gulp.task('styles', [
    'clean:styles',
    'build:styles'
]);

// Compile images files.
gulp.task('images', [
    'build:images'
]);

// Compile fonts files.
gulp.task('fonts', [
    'clean:fonts',
    'build:fonts'
]);




