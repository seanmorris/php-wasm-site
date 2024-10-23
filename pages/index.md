---
title: Php-Wasm by Sean Morris
noprefix: true
template: source/with-hero.php
hero: intro.html
leftBarLink: false
leftBarShow: false
itemtype: schema.org/SoftwareSourceCode
microdata:
    name: php-wasm
    description: Php-Wasm is an implementation of PHP running in Web Assembly.
    alternateName: php-cgi-wasm
    programmingLanguage: php, javascript, webassembly
    runtimePlatform: webassembly
    codeRepository: https://github.com/seanmorris/php-wasm
    copyrightHolder: Sean Morris
    copyrightYear: 2020-2024
    countryOfOrigin: USA
    headline: PHP powered by WebAssembly.
    isAccessibleForFree: true
    isBasedOn: php
    isFamilyFriendly: true
    keywords: php, javascript, webassembly
    license: https://www.apache.org/licenses/LICENSE-2.0.txt
    maintainer: Sean Morris
    additionalType: https://schema.org/ComputerLanguage
---
<p class = "strong">Php Wasm puts PHP right in the browser.</p>
PHP can now run in the browser as a counterpart to Javascript, and can either be invoked from Javascript code or static HTML, where it's got full access to JS APIs as well as the DOM. Or, it can run a service worker, where it mimics a CGI webserver like Apache or nginx. And yea, it can serve whole websites.

<aside>
	<ul>
		<li>Embeds directly in HTML.</li>
		<li>Full Access to JS APIs.</li>
		<li>Runs in the Browser, Node, & CloudFlare.</li>
		<li>Supports 17 of the top PHP Extensions.</li>
	</ul>
	<p>Why even write Javascript anymore?</p>
</aside>

<p class = "strong">Standard PDO Database Connectors.</p>
Php Wasm supports Sqlite, PostgreSQL, and CloudFlare's D1 SQL, all via PDO, so you can query your database just like you've always done it.

<p class = "strong">A Full Bridge To Javascript Code</p>
The Vrzno extension allows PHP to gain access to any APIs available to Javascript. Objects, functions, and even classes can be imported from Javascript and used in PHP  as if they were native code. That opens up things like DOM APIs, or anything else the browser expose to Javascript. On the desktop, NodeJS packages like NodeGTK can be used to build desktop applications in PHP.

You can see a simple demo of the Curvature framework being used to generate some dynamic html [here](https://seanmorris.github.io/php-wasm/?demo=curvature.php), or a node-based version that allows PHP to access GTK [here](https://github.com/seanmorris/php-gtk).

<aside class = "centered">
	<a target = "_blank" alt = "Drupal Logo" href = "https://drupal-cms-project-9c0022e0ec6f0d7d0acfffa4583f8606955183fe7716.pages.drupalcode.org/">
		<img class = "downstream-logo" src = "drupal-logo.svg" /></a>
	<p>
		<a target = "_blank" alt = "WordPress Logo" href = "https://drupal-cms-project-9c0022e0ec6f0d7d0acfffa4583f8606955183fe7716.pages.drupalcode.org/">Drupal Playground</a>
	</p>
	<a target = "_blank" href = "https://playground.wordpress.net/">
		<img class = "downstream-logo" src = "wordpress-logo.svg" />
	</a>
	<p>
		<a target = "_blank" href = "https://playground.wordpress.net/">Wordpress Playground</a>
	</p>
</aside>

<p class = "strong">Field Tested.</p>

Php Wasm is already powering cutting-edge frontend PHP applications like WordPress-Playground, Drupal-Playground, and PlayWithLaravel. You can also find it featured on [3v4l.org](https://3v4l.org).

<p class = "strong">Fully Loaded with Batteries Included.</p>

Php Wasm comes with support for **17** of the most commonly used PHP extensions, like LibXML, OpenSSL, Intl, ICU, GD, mbString + oniguruma, & zLib. Most of them can be loaded dynamically as shared objects, or compiled statically if your use case requires it. You can view the whole list [here](/getting-started/README.html#extensions).

Extensions can even be loaded in from a CDN like jsdelivr or unpkg, since they're wrapped in JS modules. You can learn how to do all that and more in the [docs](/getting-started/README.html#loading-dynamic-extensions-as-js-modules).

<p class = "strong">Isomorphic PHP.</p>

Write code that runs on the backend, the frontend, the edge and the service worker. You can even include classes directly from Packagist with a cloud-based autoloader.

<p class = "strong">And, of course, its Open Source.</p>

Php Wasm is published 100% for free under the Apache License, Version 2.0. This means Php Wasm is and always will be 100% free. Php Wasm is committed to maintaining the free and open nature of the web, and all the tools the project is based on.

<p class = "strong">Want to Reach Out?</p>

If you'd like to get involved and contribute code or sponsorship, head over to the [GitHub repo](https://github.com/seanmorris/php-wasm), and don't hesitate to say hi on [Discord](https://discord.com/invite/j8VZzju7gJ)!
