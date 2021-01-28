** Setup and installation **

1. composer: https://getcomposer.org/download/
2. NPM: https://www.npmjs.com/get-npm

** Get up and running **

1. composer update for pulling in PHP dependencies and run autoloader
2. npm install for pulling JS dependencies
3. npm run build for development deployment
4. npm run prod for production deployment

** Shortcodes **

You can copy the class-wpr-shortcode.php file, modify it and run composer update to create new shortcodes in WordPress.
There is also a CSS file included which will not be overwritten by React (for Designers).

** Rest routes **

You can copy the class-wpr-rest-route.php file, modify it and run composer update to create new Rest-API route in WordPress.

** Dependency management **

I tried to keep it as minimal as possible.
Install new dependencies for PHP with composer install: 