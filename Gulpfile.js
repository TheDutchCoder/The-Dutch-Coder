/* --------------------------------- *
 * Gulp requires / plugins           *
 * --------------------------------- */
var gulp        = require('gulp');
var plugins     = require('gulp-load-plugins')();
var runSequence = require('run-sequence');





/* --------------------------------- *
 * Tasks                             *
 * --------------------------------- */
// Watcher.
gulp.task('watch', function() {

    plugins.livereload.listen();

    gulp.watch('index.html').on('change', plugins.livereload.changed);
    gulp.watch(['sass/**/*.scss', '!sass/style-ie8.scss'], ['css:sass']);
    gulp.watch(['js/*.js', '!js/scripts.js'], ['js:dev']);

});

// SASS.
gulp.task('css:sass', function() {

    return gulp.src('sass/style.scss')
        .pipe(plugins.rubySass({ style: 'compressed' }))
        .pipe(gulp.dest('css/'))
        .pipe(plugins.livereload());

});

// SASS for IE8.
gulp.task('css:sass-ie8', function() {

    return gulp.src('sass/style-ie8.scss')
        .pipe(plugins.rubySass())
        .pipe(gulp.dest('css/'));

});

// Autoprefix CSS.
gulp.task('css:autoprefix', function() {

    return gulp.src('css/*.css')
        .pipe(plugins.autoprefixer({
            browsers: ['last 2 versions', 'ie 9']
        }))
        .pipe(gulp.dest('dist/css/'));

});

// Autoprefix CSS for IE8.
gulp.task('css:autoprefix-ie8', function() {

    return gulp.src('css/*.css')
        .pipe(plugins.autoprefixer({
            browsers: ['ie 8']
        }))
        .pipe(gulp.dest('dist/css/'));

});

// Lint JS.
gulp.task('js:lint', function() {

    return gulp.src('js/*.js')
        .pipe(plugins.jshint())
        .pipe(plugins.jshint.reporter('jshint-stylish'));

});

// Concat JS.
gulp.task('js:concat', function() {

    return gulp.src(['js/*.js', '!js/scripts.js'])
        .pipe(plugins.concat('scripts.js'))
        .pipe(gulp.dest('js/'));

});

// Uglify JS.
gulp.task('js:uglify', function() {

    return gulp.src('js/scripts.js')
        .pipe(plugins.uglify())
        .pipe(plugins.rename('scripts.min.js'))
        .pipe(gulp.dest('dist/js/'));

});





/* --------------------------------- *
 * Sequenced dev tasks               *
 * --------------------------------- */
// CSS autoprefixing.
gulp.task('css:dev', function(done) {

    runSequence(
        'css:autoprefix',
    done);

});

// JS lint and concat.
gulp.task('js:dev', function(done) {

    runSequence(
        'js:lint',
        'js:concat',
    done);

});





/* --------------------------------- *
 * Sequenced dist tasks              *
 * --------------------------------- */
// CSS compilation and autoprefixing.
gulp.task('css:dist', function(done) {

    runSequence(
        'css:sass',
        'css:autoprefix',
    done);

});

// IE8 CSS compilation and autoprefixing.
gulp.task('css:dist-ie8', function(done) {

    runSequence(
        'css:sass-ie8',
        'css:autoprefix-ie8',
    done);

});

// JS lint, concat and uglify.
gulp.task('js:dist', function(done) {

    runSequence(
        'js:lint',
        'js:concat',
        'js:uglify',
    done);

});





/* --------------------------------- *
 * Gulp commands                     *
 * --------------------------------- */
gulp.task('default', ['watch']);
gulp.task('dev', ['css:dev', 'js:dev']);
gulp.task('dist', ['css:dist', 'css:dist-ie8', 'js:dist']);
