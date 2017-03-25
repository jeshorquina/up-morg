var fs = require("fs");

var gulp = require('gulp');
var sass = require('gulp-sass');
var concat = require('gulp-concat');
var js_minify = require('gulp-uglify');
var css_minify = require('gulp-clean-css');
var sourcemaps = require('gulp-sourcemaps');

gulp.task('compile:css', function () {
    gulp.src('resources/assets/css/sass/**/*.sass')
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('resources/assets/css'));
});

gulp.task('watch:css', function () {
    gulp.watch(
        'resources/assets/css/sass/**/*.sass',
        ['compile:styles']
    );
});

gulp.task('build:css', ['compile:css'], function () {
    Array.from(
        JSON.parse(fs.readFileSync('resources/assets/css/source.json'))
    ).forEach(function (value) {
        gulp.src(Array.from(value.src))
            .pipe(concat(value.name))
            .pipe(sourcemaps.init())
            .pipe(css_minify())
            .pipe(sourcemaps.write("/"))
            .pipe(gulp.dest('public/css/'));
    });
});

gulp.task('build:js', function () {
    Array.from(
        JSON.parse(fs.readFileSync('resources/assets/js/source.json'))
    ).forEach(function (value) {
        gulp.src(Array.from(value.src))
            .pipe(concat(value.name))
            .pipe(sourcemaps.init())
            .pipe(js_minify())
            .pipe(sourcemaps.write("/"))
            .pipe(gulp.dest('public/js/'));
    });
});

gulp.task('build', [
    'build:css',
    'build:js'
]);
