/**
 * gulpfile.js
 *
 * Runs a collection of tasks for this project.
 *
 * Usage:
 * 'gulp'      Starts a watcher for development.
 * 'gulp test' Runs testing tools like the a11y checker.
 * 'gulp dist' Builds the dist archives (usually for a new release).
 */





/**
 * Configurations.
 *
 * Preliminary setup work.
 */

// Gulp configuration.
var gulp        = require('gulp');
var plugins     = require('gulp-load-plugins')();
var runSequence = require('run-sequence');
var chalk       = require('chalk');
var pkg         = require('./package.json');


// Configurations for plumber.
var plumber = {

    options: {
        errorHandler: errorHandler
    }

};


// Configurations for Sass.
var sass = {

    lint: {

        input: [
            'wp-content/themes/' + pkg.name + '/sass/**/*.scss',
            '!wp-content/themes/' + pkg.name + '/sass/vendor/**/*.scss'
        ],

        options: {
            config: 'scss-lint.yml',
            maxBuffer: 1024000
        }

    },

    compile: {

        input: [
            'wp-content/themes/' + pkg.name + '/sass/**/*.scss'
        ],

        output: 'wp-content/themes/' + pkg.name + '/',

        options: {
            outputStyle: 'compressed'
        }

    }

};


// Configurations for JS.
var js = {

    lint: {

        input: [
            'wp-content/themes/'  + pkg.name + '/js/**/*.js',
            '!wp-content/themes/' + pkg.name + '/js/vendor/**/jquery*.js',
            '!wp-content/themes/' + pkg.name + '/js/vendor/**/modernizr*.js',
            '!wp-content/themes/' + pkg.name + '/js/dist/**/*.js'
        ]

    },

    compile: {

        input: [
            'wp-content/themes/'  + pkg.name + '/js/vendor/**/modernizr*.js',
            'wp-content/themes/'  + pkg.name + '/js/tools/**/*.js',
            'wp-content/themes/'  + pkg.name + '/js/plugins/**/*.js',
            'wp-content/themes/'  + pkg.name + '/js/scripts.js',
            '!wp-content/themes/' + pkg.name + '/js/tools/**/*_dev*.js'
        ],

        output: 'wp-content/themes/' + pkg.name + '/js/dist/'

    }

};


// Configurations for imagemin.
var imagemin = {

    input: [
        'wp-content/themes/'  + pkg.name + '/img/**/*.{jpg,png,gif}',
        '!wp-content/themes/'  + pkg.name + '/img/dist/**/*'
    ],

    output: 'wp-content/themes/'  + pkg.name + '/img/dist/',

    options: {
        optimizationLevel: 5
    }

};


// Configurations for Autoprefixer.
var autoprefixer = {

    options: ['last 2 versions', 'ie 9']

};


// Configurations for the a11y audit.
var a11y = {

    pages: [
        'http://www.soshal.ca'
    ]

};


// Configurations for the accessibility audit.
var wcag = {

    options: {
        urls: ['http://www.soshal.ca'],
        force: true,
        accessibilityLevel: 'WCAG2AA',
        accessibilityrc: true,
        reportLevels: {
            notice: false,
            warning: false,
            error: true
        },
        domElement: true
    }

};





/**
 * Errorhandler.
 *
 * Takes any gulp errors and outputs them to the terminal.
 *
 * @param object err The error object.
 */
function errorHandler(err) {

    console.log('');
    console.log('  ' + chalk.red('[') + 'error' + chalk.red(']') + ' · ' + chalk.red('in ') + err.plugin);
    console.log('  ' + chalk.red('[') + 'error' + chalk.red(']') + ' · ' + err.lineNumber + ':' + err.message);
    console.log('  ' + chalk.red('[') + 'error' + chalk.red(']') + ' · ' + err.fileName);
    console.log('');

    this.emit('end');

}





/**
 * Logs custom messages to the console.
 *
 * @param  string environment The environment the task is running in.
 * @param  string subject     The subject of the message.
 * @param  string message     The remainder of the message.
 */
function log(environment, subject, message) {

    console.log('');

    if (environment === 'dev') {

        console.log('  ' + chalk.cyan('[') + environment + chalk.cyan(']') + ' · ' + chalk.cyan(subject) + ' ' + message);

    } else if (environment === 'dist') {

        console.log('  ' + chalk.magenta('[') + environment + chalk.magenta(']') + ' · ' + chalk.magenta(subject) + ' ' + message);

    } else if (environment === 'test') {

        console.log('  ' + chalk.yellow('[') + environment + chalk.yellow(']') + ' · ' + chalk.yellow(subject) + ' ' + message);

    }

    console.log('');

}





/**
 * Development tasks.
 *
 * A collection of tasks that assist during development.
 */

// Main dev watcher.
gulp.task('dev:watch', function() {

    log('dev', 'watching', 'project files');

    // Let livereload listen for changes.
    plugins.livereload.listen();

    // Watch Sass files.
    gulp.watch(sass.compile.input, ['dev:sass-lint', 'dev:sass-compile']);

    // Watch JavaScript files.
    gulp.watch(js.compile.input, ['dev:js-lint', 'dev:js-compile']);

    // Watch image files.
    gulp.watch(imagemin.input, ['dev:img-compress']);

});


// Lints all Sass files that are cached.
gulp.task('dev:sass-lint', function() {

    log('dev', 'linting', 'Sass files (cache)');

    return gulp.src(sass.lint.input)
        .pipe(plugins.cached('sass-lint'))
        .pipe(plugins.plumber(plumber.options))
        .pipe(plugins.scssLint(sass.lint.options));

});


// Lints all Sass files that are uncached.
gulp.task('dev:sass-lint-nocache', function() {

    log('dev', 'linting', 'Sass files (no cache)');

    return gulp.src(sass.lint.input)
        .pipe(plugins.plumber(plumber.options))
        .pipe(plugins.scssLint(sass.lint.options));

});


// Parse Sass and autoprefix the generated CSS.
gulp.task('dev:sass-compile', function() {

    log('dev', 'compiling', 'Sass files');

    return gulp.src(sass.compile.input)
        .pipe(plugins.plumber(plumber.options))
        .pipe(plugins.sourcemaps.init())
        .pipe(plugins.sass(sass.compile.options))
        .pipe(plugins.autoprefixer(autoprefixer.options))
        .pipe(plugins.sourcemaps.write())
        .pipe(gulp.dest(sass.compile.output))
        .pipe(plugins.livereload());

});


// Lints all JavaScript files that are uncached.
gulp.task('dev:js-lint', function() {

    log('dev', 'linting', 'JS files (cache)');

    return gulp.src(js.lint.input)
        .pipe(plugins.cached('js-lint'))
        .pipe(plugins.plumber())
        .pipe(plugins.jshint())
        .pipe(plugins.jshint.reporter('jshint-stylish'))

});


// Concat and sourcemap JavaScripts.
gulp.task('dev:js-compile', function() {

    log('dev', 'compiling', 'JS files');

    return gulp.src(js.compile.input)
        .pipe(plugins.plumber())
        .pipe(plugins.sourcemaps.init())
        .pipe(plugins.uglify())
        .pipe(plugins.concat('scripts.min.js'))
        .pipe(plugins.sourcemaps.write())
        .pipe(gulp.dest(js.compile.output))
        .pipe(plugins.livereload());

});


// Compresses all images that are cached.
gulp.task('dev:img-compress', function() {

    log('dev', 'compressing', 'image files (cache)');

    return gulp.src(imagemin.input)
        .pipe(plugins.plumber())
        .pipe(plugins.imagemin(imagemin.options))
        .pipe(gulp.dest(imagemin.output));

});


// Compresses all images that are uncached.
gulp.task('dev:img-compress-nocache', function() {

    log('dev', 'compressing', 'image files (no cache)');

    return gulp.src(imagemin.input)
        .pipe(plugins.cached('img-compress'))
        .pipe(plugins.plumber())
        .pipe(plugins.imagemin(imagemin.options))
        .pipe(gulp.dest(imagemin.output));

});





/**
 * Distribution tasks.
 *
 * A collection of tasks that assist with building distribution files.
 */

// Lints all Sass files.
gulp.task('dist:sass-lint', function() {

    log('dist', 'linting', 'Sass files (no cache)');

    return gulp.src(sass.lint.input)
        .pipe(plugins.plumber(plumber.options))
        .pipe(plugins.scssLint(sass.lint.options))
        .pipe(plugins.scssLint.failReporter('E'));

});


// Parse Sass and autoprefix the generated CSS.
gulp.task('dist:sass-compile', function() {

    log('dist', 'compiling', 'Sass files');

    return gulp.src(sass.compile.input)
        .pipe(plugins.plumber(plumber.options))
        .pipe(plugins.sourcemaps.init())
        .pipe(plugins.sass(sass.compile.options))
        .pipe(plugins.autoprefixer(autoprefixer.options))
        .pipe(plugins.sourcemaps.write())
        .pipe(gulp.dest(sass.compile.output))
        .pipe(plugins.livereload());

});


// Lints all JavaScript files.
gulp.task('dist:js-lint', function() {

    log('dist', 'linting', 'JS files');

    return gulp.src(js.lint.input)
        .pipe(plugins.plumber())
        .pipe(plugins.jshint())
        .pipe(plugins.jshint.reporter('jshint-stylish'))

});


// Concat and sourcemap JavaScripts.
gulp.task('dist:js-compile', function() {

    log('dist', 'compiling', 'JS files');

    return gulp.src(js.compile.input)
        .pipe(plugins.plumber())
        .pipe(plugins.sourcemaps.init())
        .pipe(plugins.uglify())
        .pipe(plugins.concat('scripts.min.js'))
        .pipe(plugins.sourcemaps.write())
        .pipe(gulp.dest(js.compile.output))
        .pipe(plugins.livereload());

});


// Compresses all images.
gulp.task('dist:img-compress', function() {

    log('dist', 'compressing', 'image files');

    return gulp.src(imagemin.input)
        .pipe(plugins.plumber())
        .pipe(plugins.imagemin(imagemin.options))
        .pipe(gulp.dest(imagemin.output));

});





/**
 * Test tasks.
 *
 * A collection of tasks that assist with testing things like accessibility.
 */

// Check URLs against a11y standards and make a report.
gulp.task('test:a11y', function() {

    var now = Date.now();

    log('test', 'auditing', 'a11y to .tests/a11y/' + now + '_a11y_audit.txt');

    return plugins.run('a11y ' + a11y.pages.join(' ')).exec()
        .pipe(plugins.plumber())
        .pipe(plugins.rename(now + '_a11y_audit.txt'))
        .pipe(gulp.dest('.tests/a11y'));

});


// Check URLs against a11y standards and logs the result instead of generating
// a report.
gulp.task('test:a11y-log', function() {

    log('test', 'auditing', 'a11y to console');

    return plugins.run('a11y ' + a11y.pages.join(' ')).exec();

});


// Check URLs against WCAG 2.0 standards and report to the console.
gulp.task('test:wcag', function() {

    log('test', 'auditing', 'WCAG to console');

    return plugins.accessibility(wcag.options);

});





/**
 * Gulp commands.
 *
 * Expose certain tasks or sequences to the CLI.
 */
gulp.task('default', ['dev:watch']);
gulp.task('dist', ['dist:sass-lint-nocache', 'dist:sass-compile', 'dist:js-lint', 'dist:js-compile', 'dist:img-conpress']);
gulp.task('test', ['dev:sass-lint-nocache', 'dev:js-lint', 'test:a11y', 'test:wcag']);
