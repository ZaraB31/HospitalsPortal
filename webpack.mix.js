// webpack.mix.js

let mix = require('laravel-mix');

mix.sass('resources/sass/app.scss', 'dist');
mix.sass('resources/sass/auth.scss', 'dist');
mix.js('resources/js/hiddenForm.js', 'dist');