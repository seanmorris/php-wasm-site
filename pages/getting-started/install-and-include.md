---
title: Install & Import
---
# Install & Import php-wasm

Include the module in your preferred format:

## from a cdn

***Note: This does not require npm.***

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

### Latest Alpha

Installing the latest php-wasm alpha with npm:

```sh
$ npm i php-wasm@alpha
```

Installing php-cgi-wasm:

```sh
$ npm i php-cgi-wasm@alpha
```

### Latest Stable

```sh
$ npm i php-wasm
```

Installing php-cgi-wasm:

```sh
$ npm i php-cgi-wasm
```

#### Pre-Packaged Static Assets:

If you're using a bundler, use the vendor's documentation to learn how to move the files matching the following pattern to your public directory:

```bash
node_modules/php-wasm/php-web.mjs.wasm
```

For php-cgi-wasm:
```bash
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
