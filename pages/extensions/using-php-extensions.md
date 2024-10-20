---
title: Using PHP Extensions
weight: -1000
---

# Using PHP Extensions

There are two ways to load extensions at runtime, using the `dl()` function or `php.ini`. The following code will attempt to load the .so files from the same directory the main WASM binary was loaded from, unless further configuration is provided.

```php
<?php
dl('php-8.3-xml.so');
dl('php-8.3-dom.so');
```

You can also pass an array as the `extensions` argument to the constructor from Javascript to auto-generate an ini file that loads your extensions.

```javascript
const php = new PhpWeb({sharedLibs: [
	`php8.3-xml.so`,
	`php8.3-dom.so`,
]});
```

The class used to load PHP (`PhpWeb` here) implements a phpVersion property to ensure libs can be loaded for any compatible version:

```javascript
const php = new PhpWeb({sharedLibs: [
	`php${PhpWeb.phpVersion}-xml.so`,
	`php${PhpWeb.phpVersion}-dom.so`,
]});
```

## Dynamic Extensions from Remote Servers:

You can also load extensions from remote servers with URLs:

```javascript
const php = new PhpWeb({sharedLibs: [`https://unpkg.com/php-wasm-phar/php8.3-phar.so`]});
```

The above is actually shorthand for the following code. Passing `ini: true` will automatically load the extension via `/php.ini`, passing `ini: false` will wait for a call to `dl()` to do the lookup.

```javascript
const php = new PhpWeb({sharedLibs: [
	{
		name: `php8.3-phar.so`,
		url:  `https://unpkg.com/php-wasm-phar/php8.3-phar.so`,
		ini:  true,
	}
]});
```

Strings starting with `/`, `./`, `http://` or `https://` will be treated as URLs:

```javascript
const php = new PhpWeb({sharedLibs: [
	`./php8.3-phar.so`
]});
```

Some extensions require supporting libraries. You can provide URLs for those as `sharedLibs` as well, just pass `ini: false`:

*(`name` is implied to be the last section of the URL here.)*

```javascript
const php = new PhpWeb({sharedLibs: [
	{ url: 'https://unpkg.com/php-wasm-sqlite/php8.3-sqlite.so', ini: true  },
	{ url: 'https://unpkg.com/php-wasm-sqlite/sqlite.so',        ini: false },
]});
```

## Loading Dynamic Extensions as JS Modules:

Dynamic extensions can be loaded as modules: So long as the main file of the module defines the `getLibs` and `getFiles` methods, extensions may be loaded like so:

```javascript
new PhpNode({sharedLibs:[ await import('php-wasm-intl') ]})
```

Dynamic extensions can also be loaded as modules from any static HTTP server with an ESM directory structure.

```javascript
// This will load both sqlite.so & php8.x-sqlite.so:
const php = new PhpWeb({sharedLibs: [ await import('https://cdn.jsdelivr.net/npm/php-wasm-sqlite') ]});
```

Sadly, this notation is not available for Service Workers, since they do not yet support dynamic `imports()`. Hopefully this will change soon.

## Extension List

The following extensions may be loaded at runtime. This allows the shared extension & their dependencies to be cached, re-used, and selected a-la-carte for each application.

### gd

<https://www.npmjs.com/package/php-wasm-gd>

### iconv

<https://www.npmjs.com/package/php-wasm-iconv>

### intl

<https://www.npmjs.com/package/php-wasm-intl>

### xml

<https://www.npmjs.com/package/php-wasm-libxml>

### dom

<https://www.npmjs.com/package/php-wasm-libxml>

### simplexml

<https://www.npmjs.com/package/php-wasm-libxml>

### yaml

<https://www.npmjs.com/package/php-wasm-libyaml>

### zip

<https://www.npmjs.com/package/php-wasm-libzip>

### mbstring

<https://www.npmjs.com/package/php-wasm-mbstring>

### openssl

<https://www.npmjs.com/package/php-wasm-openssl>

### phar

<https://www.npmjs.com/package/php-wasm-phar>

### sqlite

<https://www.npmjs.com/package/php-wasm-sqlite>

### pdo-sqlite

<https://www.npmjs.com/package/php-wasm-sqlite>

### zlib

<https://www.npmjs.com/package/php-wasm-zlib>


