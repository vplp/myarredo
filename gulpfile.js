// [ БАЗОВІ НАЛАШТУВАННЯ ]
var gulp = require('gulp'), //Відповідно сам gulp
    concat = require('gulp-concat'), //Обєднання файлів
    rename = require("gulp-rename"), //Перейменування файлів
    sourcemaps = require('gulp-sourcemaps'), //Робота з переліком файлів
    watch = require('gulp-watch'); //Наглядачі

//Сервер для розробки
var cached = require('gulp-cached'), //Кешування файлів для прискорення обробки в память
    remember = require('gulp-remember'), //
    connect = require('gulp-connect'); //Livereload Server

// [ ОБРОБКА ]
// [ LESS ]
var less = require('gulp-less'); //Підключення LESS
// [ SASS ]
var compass = require('gulp-compass'), //Підключення COMPAS
    scss = require('gulp-sass'); //Підключення SASS

//Вихідна обобка файлів CSS, JS
var uglify = require('gulp-uglify'), //Архівація JS файлів
    minifyCss = require('gulp-minify-css'), //Архівація CSS файлів
    cssBase64 = require('gulp-css-base64'); //transform all resources found in a CSS into base64-encoded data URI strings
//You can ignore a resource with a comment /*base64:skip*/ in CSS file after url definition.

//var gulpif = require('gulp-if'),
var sprite = require('gulp-sprite-generator');



//Джерела
var dev_patches = {
    'js': ['./build/js/*'],
    'font': ['./build/font/*'],
    'less': ['./build/less/**/*.less'],
    'scss': ['./build/scss/**/*.scss'],
    'css': ['./build/css/main.scss.css'],
    'css-base': './build/css/',
};
//Точки слідування
var build_patches = {
    'images': './public/img/',
    'js': './public/js/',
    'css': './public/css/',
};

var build_patches_copy_list = {
    'images': './public/img/**/*',
    'js': './public/js/**/*',
    'css': './public/css/**/*',
};

//build yii patches
//Для копіювання то теми фреймворку
var yii_base_path = './frontend/themes/default/web';
var yii_patches = {
    'images': yii_base_path + '/img/',
    'js': yii_base_path + '/js/',
    'css': yii_base_path + '/css/',
    'font': yii_base_path + '/font/'
};

gulp.task('watch', function () {
    gulp.watch(dev_patches['js'], ['scripts']);
    gulp.watch(dev_patches['images'], ['images']);
    gulp.watch(dev_patches['css'], ['minify-css']);
    gulp.watch(dev_patches['scss'], ['scss']);
});


//Копіювання файлів у тему
gulp.task('yii:build', function () {
    gulp.src(build_patches_copy_list['images']).pipe(gulp.dest(yii_patches['images']));
    gulp.src(build_patches_copy_list['js']).pipe(gulp.dest(yii_patches['js']));
    gulp.src(build_patches_copy_list['css']).pipe(gulp.dest(yii_patches['css']));
    gulp.src(build_patches_copy_list['font']).pipe(gulp.dest(yii_patches['font']));
});

gulp.task('font', function () {
    gulp.src(dev_patches['font'])
        .pipe(gulp.dest(build_patches['font']));
});

gulp.task('scss', function () {
    return gulp.src(dev_patches['scss'])
        .pipe(sourcemaps.init())
        .pipe(scss())
        .pipe(rename({suffix: '.scss'}))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest(dev_patches['css-base']))
        .pipe(gulp.dest(build_patches['css']));
});


gulp.task('minify-css', function () {
    return gulp.src(dev_patches['css'])
        .pipe(cssBase64())
        .pipe(rename({
            'suffix': '.min'
        }))
        .pipe(minifyCss())
        .on('error', console.log)
        .pipe(gulp.dest(build_patches['css']))
        .pipe(connect.reload());
});


gulp.task('scripts', ['minify-js', 'lintJS'], function () {
    return gulp.src(dev_patches['js'])
        .pipe(remember('lintingJS'))
        .pipe(concat('core.js'))
        .on('error', console.log)
        .pipe(gulp.dest(build_patches['js']));
});


gulp.task('minify-js', function () {
    return gulp.src(build_patches['scripts'] + 'core.js')
        .pipe(rename(build_patches['scripts'] + 'core.min.js'))
        .pipe(uglify())
        .on('error', console.log)
        .pipe(gulp.dest('.'));
});





