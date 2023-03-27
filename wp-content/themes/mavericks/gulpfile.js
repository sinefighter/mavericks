const gulp = require('gulp');
const del = require('del');
const sass = require('gulp-sass')(require('sass'));
const cleanCSS = require('gulp-clean-css');
const rename = require("gulp-rename");
const autoprefixer = require('gulp-autoprefixer')
const uglify = require('gulp-uglify')
const sourcemaps = require('gulp-sourcemaps')
const imagemin = require('gulp-imagemin')
const newer = require('gulp-newer')
const browserSync = require('browser-sync').create()
const replace = require('gulp-replace')
const fileinclude = require('gulp-file-include')
const fs = require('fs')
const webp = require('gulp-webp')
const webphtml = require('gulp-webp-html-nosvg')
const webpcss = require("gulp-webpcss")
const webpconverter = require('webp-converter')
const svgSprite = require('gulp-svg-sprite')
const cheerio = require('gulp-cheerio')
const imgRetina = require('gulp-img-retina');
const concat = require('gulp-concat');


const path = {
    css: {
        src: `./src/css/**/*.css`,
        dest: `./dist/css/`
    },
    scss: {
        src: `./src/scss/styles.scss`,
        dest: `./dist/css/`
    },
    scripts: {
        src: `./src/js/**/*.js`,
        dest: `./dist/js/`
    },
    images: {
        src: `./src/img/**/*`,
        dest: `./dist/img/`
    },
    html: {
        src: `./src/*.html`,
        dest: `./dist/`
    },
    fonts: {
        src: `./src/fonts/*`,
        dest: `./dist/fonts/`
    }
}

function html() {
    return gulp.src(path.html.src)
      .pipe(fileinclude())
      .pipe(replace(/@img\//g, './images/'))
      .pipe(replace(/@js\//g, './js/'))
      .pipe(replace(/@css\//g, './css/'))
      .pipe(webphtml())
	  .pipe(imgRetina())
      .pipe(gulp.dest(path.html.dest))
      .pipe(browserSync.stream())
}

function scss() {
    return gulp.src('./src/scss/styles.scss')
      .pipe(sourcemaps.init())
      .pipe(replace(/@img\//g, '../images/'))
      .pipe(sass().on('error', sass.logError))
      .pipe(autoprefixer({
        grid: true,
        overrideBrowserslist: ['last 3 version'],
        cascade: true
      }))
      .pipe(gulp.dest(path.css.dest))
      .pipe(cleanCSS({
          level: 2
      }))
      .pipe(rename({
          basename: 'style',
          suffix: '.min'
      }))
      .pipe(sourcemaps.write())
      .pipe(gulp.dest(path.css.dest))
      .pipe(browserSync.stream())
}

function css() {
    return gulp.src('./src/css/**/*.css')
      .pipe(gulp.dest(path.css.dest))
      .pipe(browserSync.stream())
}

function svg() {
    return gulp.src('./src/images/icons/*.svg')
    .pipe(cheerio({
        run: function ($) {
            $('[fill]').removeAttr('fill');
            $('[stroke]').removeAttr('stroke');
            $('[style]').removeAttr('style');
        },
        parserOptions: {xmlMode: true}
    }))
    .pipe(replace('&gt;', '>'))
      .pipe(svgSprite({
        mode: {
            stack: {
                sprite: `../icons/icons.svg`,
                // html файл с превью всех иконок
                example: false,
            }
        }
    }))
      .pipe(gulp.dest('./dist/images/'))
      .pipe(browserSync.stream())
}

function scripts() {
    return gulp.src([
        './src/js/moment.min.js', 
        './src/js/slider.js', 
        './src/js/selectorStylize.js', 
        './src/js/smoothScroll.js', 
        './src/js/main.js',
        './src/js/custom.js',
        ], {
        sourcemaps: true
    })
    // .pipe(gulp.dest(path.scripts.dest))
    .pipe(concat('scripts.min.js'))
    .pipe(uglify())
    .pipe(gulp.dest(path.scripts.dest))
    .pipe(browserSync.stream())
}

function images() {
    return gulp.src(path.images.src)
        .pipe(newer(path.images.dest))
		.pipe(imagemin({
            progressive: true,
            svgoPlugins: [{removeViewBox: false}],
            interlaced: true,
            optimizationLevel: 3,
        }))
		// .pipe(gulp.dest(path.images.dest))
        // .pipe(webp())
		.pipe(gulp.dest(path.images.dest))
        .pipe(browserSync.stream())
}

function clean() {
    return del(['dist/*', '!dist/images', '!dist/fonts'])
}

function watch() {
    browserSync.init({
        // server: {
        //     baseDir: "./dist"
        // },
        proxy: "mavericks",
		host: "mavericks",
		open: "external",
		files: ['./**/*.php'],
    })

    gulp.watch(path.scss.src, scss).on('change', browserSync.reload)
    gulp.watch(path.css.src, css).on('change', browserSync.reload)
    gulp.watch(path.scripts.src, scripts).on('change', browserSync.reload)
    gulp.watch(path.images.src, images).on('change', browserSync.reload)
    gulp.watch(path.html.src, html).on('change', browserSync.reload)
    gulp.watch(`./src/**/*.html`, html).on('change', browserSync.reload)
    gulp.watch(`./src/scss/**/*.scss`, scss).on('change', browserSync.reload)
}

const build = gulp.series(clean, gulp.parallel(html, scripts, scss, css, images, svg), watch)

exports.clean = clean
exports.scripts = scripts
exports.scss = scss
exports.watch = watch

exports.default = build