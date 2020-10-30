const gulp = require('gulp');
const browserSync = require('browser-sync').create();
const sass = require('gulp-sass');
const notify = require('gulp-notify');
const autoprefixer = require('gulp-autoprefixer');

gulp.task('sass', function(done) {
    gulp.src("../universal-theme/assets/sass/*.sass", "../universal-theme/assets/sass/*.scss")
        .pipe(sass())
        .on('error', notify.onError('Error: <%= error.message %>'))
        .pipe(autoprefixer({
            cascade: false,
            overrideBrowserslist : [
                "last 20 version"
            ]
        }))
        .pipe(gulp.dest("../universal-theme/assets/css/"))
        .pipe(browserSync.stream())
    done();
});

gulp.task('serve', function(done) {

    browserSync.init({
        proxy: 'http://universal.local',
        host: 'universal.local',
        open: 'external'
    });

    gulp.watch("../universal-theme/assets/sass/*.sass", gulp.parallel('sass'));
    gulp.watch("../universal-theme/assets/sass/*.scss", gulp.parallel('sass'));
    gulp.watch("../universal-theme/*.*").on('change', () => {
        browserSync.reload();
        done();
    });

    done();
});

gulp.task('default', gulp.parallel('sass', 'serve'));