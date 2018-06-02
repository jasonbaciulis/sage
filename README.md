# Sage Thrives

Sage Thrives is a fork of [Sage](https://roots.io/sage/) WordPress starter theme with a modern development workflow. Sage Thrives retains all the benefits of Sage but is more opinionated and has some additional features.

## New features

* CSS framework inspired by [ITCSS](https://www.xfive.co/blog/itcss-scalable-maintainable-css-architecture/) and combined with [Bootstrap](https://getbootstrap.com/docs/4.1/getting-started/introduction/) 4.1
* [Nav Walker](https://github.com/dupkey/bs4navwalker) for Bootstrap 4 navigation
* [lazysizes.js](https://github.com/aFarkas/lazysizes) for progressive image loading
* Responsive background images
* [Font Awesome](https://fontawesome.com/how-to-use/svg-with-js) 5 SVG icons
* [purgeCSS](https://github.com/FullHuman/purgecss-webpack-plugin) for removal of unused CSS
* [ACF](https://www.advancedcustomfields.com/) Pro options page setup with some fields
* Additional filters for theme optimization
* More blade partials

## Sage features

* [Webpack](https://webpack.github.io/) for compiling assets, optimizing images, and concatenating and minifying files
* [Browsersync](http://www.browsersync.io/) for synchronized browser testing
* [Blade](https://laravel.com/docs/5.5/blade) as a templating engine
* [Controller](https://github.com/soberwp/controller) for passing data to Blade templates

## Requirements

Make sure all dependencies have been installed before moving on:

* [WordPress](https://wordpress.org/) >= 4.7
* [PHP](https://secure.php.net/manual/en/install.php) >= 7.1.3 (with [`php-mbstring`](https://secure.php.net/manual/en/book.mbstring.php) enabled)
* [Composer](https://getcomposer.org/download/)
* [Node.js](http://nodejs.org/) >= 6.9.x
* [Yarn](https://yarnpkg.com/en/docs/install)

## Theme installation

Clone the git repo.

```shell
git clone git@github.com:jasonbaciulis/sage-thrives.git
```

Rename `sage-thrives` with the name of your theme.

Run `composer install`. This will make sure that the Composer autoload files are generated and saved to the `vendor/` directory.

## Theme setup

Edit `app/setup.php` to enable or disable theme features, setup navigation menus, post thumbnail sizes, and sidebars.

Edit `app/filters.php` to enable or disable additional theme optimization features.

## Theme development

* Run `yarn` from the theme directory to install dependencies
* Update `resources/assets/config.json` settings:
  * `devUrl` should reflect your local development hostname
  * `publicPath` should reflect your WordPress folder structure (`/wp-content/themes/sage` for non-[Bedrock](https://roots.io/bedrock/) installs)

### Build commands

* `yarn start` — Compile assets when file changes are made, start Browsersync session
* `yarn build` — Compile and optimize the files in your assets directory
* `yarn build:production` — Compile assets for production

## Sage documentation

* [Sage documentation](https://roots.io/sage/docs/)
* [Controller documentation](https://github.com/soberwp/controller#usage)

## Sage community

Keep track of development and community news.

* Participate on the [Roots Discourse](https://discourse.roots.io/)
* Follow [@rootswp on Twitter](https://twitter.com/rootswp)
* Read and subscribe to the [Roots Blog](https://roots.io/blog/)
* Subscribe to the [Roots Newsletter](https://roots.io/subscribe/)

## Contributing

Contributions are welcome from everyone.
