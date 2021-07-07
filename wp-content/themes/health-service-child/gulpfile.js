import pkg from 'gulp';
const { src, dest } = pkg;

import yargs from 'yargs';
import gulpSass from "gulp-sass";
import nodeSass from "node-sass";
    
const sass = gulpSass(nodeSass);
import cleanCss from 'gulp-clean-css';
import gulpif from 'gulp-if';
const PRODUCTION = yargs.argv.prod;

export const styles = () => {
  return src('src/scss/style.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(gulpif(PRODUCTION, cleanCss({compatibility:'ie8'})))
    .pipe(dest('dist/css'));
}

// import gulp from 'gulp';
// import sass from 'gulp-sass';
// import minify from 'gulp-minify';


// gulp.task('styles',() => {
//   return gulp.src('src/scss/style.scss')
//     .pipe(sass().on('error', sass.logError))  
//     .pipe(gulp.dest('src/css'));
// });