---
title: Install & Import
weight: -900
---
# Install & Import php-wasm

Include the module in your preferred format:

## from a cdn

Using ESM modules, you can import php-wasm directly from a cdn:

### jsdelivr

```javascript
const { PhpWeb } = await import('https://cdn.jsdelivr.net/npm/php-wasm/PhpWeb.mjs');
const php = new PhpWeb;
```

### unpkg

```javascript
const { PhpWeb } = await import('https://www.unpkg.com/php-wasm/php-wasm/PhpWeb.mjs');
const php = new PhpWeb;
```

## Installing with npm

You can also install php-wasm with npm.

### Latest Alpha

```sh
$ npm i php-wasm@alpha
$ npm i php-cgi-wasm@alpha
```

### Latest Stable

```sh
$ npm i php-wasm
$ npm i php-cgi-wasm
```

#### Pre-Packaged Static Assets:

If you're using a bundler, use the vendor's documentation to learn how to move the files matching the following pattern to your public directory:

```bash
node_modules/php-wasm/php-web.mjs.wasm
node_modules/php-cgi-wasm/php-cgi-worker.mjs.wasm
```

## Importing the module

### ESM

```javascript
import { PhpWeb } from 'php-wasm/PhpWeb.mjs';
const php = new PhpWeb;
```

### CJS

```{ .javascript data-numbers="true" }
const { PhpWeb } = require('php-wasm/PhpWeb.js');
const php = new PhpWeb;
```
