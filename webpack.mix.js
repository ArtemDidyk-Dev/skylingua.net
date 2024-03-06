const mix = require('laravel-mix');

mix
    .js('assets/app.js', 'js').version()
    .sass('assets/scss/index.scss', 'css').version()
    .copyDirectory('assets/images', 'public/build/website/images')
    .copyDirectory('assets/fonts', 'public/build/website/fonts')
    .disableNotifications();
