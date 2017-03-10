var gulp = require('gulp');
var sass = require('gulp-sass');
var concat = require('gulp-concat');
var js_minify = require('gulp-uglify');
var css_minify = require('gulp-clean-css');
var sourcemaps = require('gulp-sourcemaps');

gulp
    .task('compile:styles', function () {
        gulp.src('resources/assets/css/sass/**/*.sass')
            .pipe(sass().on('error', sass.logError))
            .pipe(gulp.dest('resources/assets/css'));
    })
    .task('watch:styles', function () {
        gulp.watch(
            'resources/assets/css/sass/**/*.sass',
            ['compile:styles']
        );
    })
    .task('final:styles', function () {
        gulp.src('resources/assets/css/*.css')
            .pipe(concat('app.css'))
            .pipe(sourcemaps.init())
            .pipe(css_minify())
            .pipe(sourcemaps.write("/"))
            .pipe(gulp.dest('public/css/'));
    })
    .task('final:scripts', function () {
        gulp.src([
            'resources/assets/js/libraries/domHelper.js',
            'resources/assets/js/libraries/alertFactory.js',
            'resources/assets/js/libraries/httpHelper.js',
            'resources/assets/js/libraries/urlHelper.js',
            'resources/assets/js/controllers/login.js'
        ])
            .pipe(concat('login.js'))
            .pipe(sourcemaps.init())
            .pipe(js_minify())
            .pipe(sourcemaps.write("/"))
            .pipe(gulp.dest('public/js/'))
    });

