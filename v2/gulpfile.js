//npm install --save-dev gulp-sass gulp-notify gulp-livereload gulp-concat gulp-sequence gulp-uglifycss gulp-uglifyjs

var gulp = require('gulp'),
    sass = require('gulp-sass'),
    notify = require('gulp-notify'),
    livereload = require('gulp-livereload'),
    concat = require('gulp-concat'),
    gulpSequence = require('gulp-sequence'),
    uglifycss = require('gulp-uglifycss'),
    uglifyjs = require('gulp-uglifyjs');

var path = 'assets/';

gulp.task('default', ['watch', 'sequence'], function() {
    
});

gulp.task('sequence', gulpSequence('styles', 'concatcss', 'uglifyjs'));

gulp.task('styles', function() {
  gulp.src(path + 'sass/*.scss')
    .pipe(sass({'outputStyle': 'compressed'}).on('error', sass.logError))
    .pipe(gulp.dest(path + 'css/'))
    .pipe(livereload());
});

gulp.task('watch', function() {
  livereload.listen();
    gulp.watch('*.php', ['html']);
    gulp.watch(path + 'sass/*.scss',['styles']);
    gulp.watch(path + 'css/style.css',['concatcss']);
    gulp.watch(path + 'js/js.js', ['uglifyjs']);
});

gulp.task('html', function() {
  return gulp.src('**.php')
  .pipe(livereload());
});

gulp.task('uglifyjs', function () {
  gulp.src(['assets/js/*.js', '!assets/js/js.min.js', '!assets/js/jquery.js'])
    .pipe(concat('js.min.js'))
    .pipe(uglifyjs())
    .pipe(gulp.dest('assets/js/'))
    .pipe(livereload());
});

gulp.task('concatcss', function () {
  gulp.src([path + 'css/*.css', '!assets/css/style.min.css'])
    .pipe(concat('style.min.css'))
    .pipe(uglifycss())
    .pipe(gulp.dest(path + 'css/'))
    //.pipe(notify({ message: 'Styles task complete' }))
    .pipe(livereload());
});