---
title: Home
pagetitle: Documentation Home
weight: -1000
---
# Home

## Getting Started

If you'd like to install php-wasm with npm, see [INSTALLING](/getting-started/install-and-include.html).

If you'd like to use PHP inside of JS scripts, see [PHP In Javascript](/getting-started/php-in-js.html).

If you'd write pure frontend PHP and skip the JS entirely, see [PHP In Static HTML](/getting-started/php-in-static-html.html).

If you'd like to spin up a webserver right in your browser, see [PHP-CGI In Service Workers](/getting-started/cgi-service-worker.html).

If you'd like to serve websites from Node, see [PHP-CGI In NodeJs](/getting-started/cgi-in-nodeJs.html).

## Demo

<iframe class="video" src="https://www.youtube.com/embed/rQ-_KMgUtFg?si=mPylUsIqa1FTwSjP" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
</iframe>

## Updates

**v0.0.9 - Aiming for the (GitHub) Stars**

* Adding PHP-CGI support!
* Runtime extension loading!
* libicu, freetype, zlib, gd, libpng, libjpeg, openssl, & phar support.
* php-wasm, php-cgi-wasm, & php-wasm-builder are now separate packages.
* Vrzno now facilitates url fopen via the fetch() api.
* pdo_cfd1 is now a separate extension from Vrzno.
* pdo_pglite adds local Postgres support.
* SQLite is now using version 3.46.
* Demos for CodeIgniter, CakePHP, Laravel & Laminas.
* Drupal & all other demos now use standard build + zip install.
* Modules are now webpack-compatible out of the box.
* Exposing FS methods w/queueing & locking to sync files between tabs & workers.
* Fixed the bug with POST requests under Firefox.
* Adding support for PHP 8.3.7
* Automatic CI testing for PHP 8.0, 8.1, 8.2 & 8.3.
