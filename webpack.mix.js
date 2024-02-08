const mix = require('laravel-mix');

mix
  .setPublicPath('public/build/website')
  .js('assets/app.js', 'js')
  .sass('assets/scss/index.scss', 'css')
  .copyDirectory('assets/images', 'public/build/website/images')
  .copyDirectory('assets/fonts', 'public/build/website/fonts')
  .disableNotifications();