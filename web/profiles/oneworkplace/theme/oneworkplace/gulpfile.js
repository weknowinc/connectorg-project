var gulp        = require('gulp'),
    browserSync = require('browser-sync'),
    sass        = require('gulp-sass'),
    prefix      = require('gulp-autoprefixer'),
    concat      = require('gulp-concat'),
    babel       = require('gulp-babel'),
    cp          = require('child_process');

/**
 * Launch the Server
 */
 gulp.task('browser-sync', ['sass', 'scripts'], function() {
    browserSync.init({
      // Change as required, also remember to set in theme settings
      proxy: "http://raiblocks.ddev.local",
      port: 3000
    });
});

/**
 * @task sass
 * Compile files from scss
 */
gulp.task('sass', function () {
  return gulp.src('_scss/style.scss')
  .pipe(sass())
  .pipe(prefix(['last 3 versions', '> 1%', 'ie 8'], { cascade: true }))
  .pipe(gulp.dest('css'))
  .pipe(browserSync.reload({stream:true}))
});

/**
 * @task scripts
 * Compile files from js
 */
gulp.task('scripts', function() {
  return gulp.src(['_js/*.js', '_js/custom.js'])
  .pipe(babel({
    presets: ['es2015']
  }))
  .pipe(concat('scripts.js'))
  .pipe(gulp.dest('js'))
  .pipe(browserSync.reload({stream:true}))
});

/**
 * @task clearcache
 * Clear all caches
 */
gulp.task('clearcache', function(done) {
  return cp.spawn('drush', ['cache-rebuild'], {stdio: 'inherit'})
  .on('close', done);
});

/**
 * @task reload
 * Refresh the page after clearing cache
 */
gulp.task('reload', ['clearcache'], function () {
  browserSync.reload();
});

/**
 * @task watch
 * Watch scss files for changes & recompile
 * Clear cache when Drupal related files are changed
 */
gulp.task('watch', function () {
  gulp.watch(['_scss/*.scss', '_scss/**/*.scss'], ['sass']);
  gulp.watch(['_js/*.js'], ['scripts']);
  gulp.watch(['templates/*.html.twig', '**/*.yml'], ['reload']);
});

/**
 * Default task, running just `gulp` will 
 * compile Sass files, launch BrowserSync, watch files.
 */
gulp.task('default', ['browser-sync', 'watch']);