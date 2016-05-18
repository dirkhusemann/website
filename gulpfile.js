'use strict';

// Global configuration
const config = require('./package.json').config;

// Dependancies
const autoprefixer = require('gulp-autoprefixer');
const del = require('del');
const gulp = require('gulp');
const imagemin = require('gulp-imagemin');
const postcss = require('gulp-postcss');
const sass = require('gulp-sass');
const sassGlob = require('gulp-sass-glob');
const sourcemaps = require('gulp-sourcemaps');

// Tasks
function clean() {
  return del([config.dist.assets]);
}

function icons() {
  return gulp.src(config.src.assets + 'icons/**/*')
    .pipe(imagemin())
    .pipe(gulp.dest(config.dist.assets));
}

function styles() {
  return gulp.src(config.src.assets + 'styles/*.scss')
    .pipe(sourcemaps.init())
    .pipe(sassGlob())
    .pipe(sass({
      outputStyle:'expanded',
      includePaths: ['./node_modules']
    }).on('error', sass.logError))
    .pipe(postcss([
      autoprefixer({
        browsers: ['> 5%'],
      })
    ]))
    .pipe(sourcemaps.write('./'))
    .pipe(gulp.dest(config.dist.assets));
}

function watch() {
  gulp.watch(config.src.assets + 'icons', icons);
  gulp.watch('**/*.scss', styles);
}

// Task sets
var compile = gulp.series(clean, gulp.parallel(icons, styles));

gulp.task('default', compile);
gulp.task('dev', gulp.series(compile, watch));
