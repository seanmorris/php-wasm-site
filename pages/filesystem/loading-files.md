---
title: Loading Files
---
# 📦 Loading Files

### Loading single files at runtime

When spawning a new instance of PHP, a `files` array can be provided to be loaded into the filesystem. For example, the `php-intl` extension requires us to load `icudt72l.dat` into the  `/preload` directory.

```javascript
const sharedLibs = [`https://unpkg.com/php-wasm-intl/php\${PHP_VERSION}-intl.so`];

const files = [
	{
		name: 'icudt72l.dat',
		parent: '/preload/',
		url: 'https://unpkg.com/php-wasm-intl/icudt72l.dat'
	}
];

const php = new PhpWeb({sharedLibs, files});
```
### Preloaded FS

Use the `PRELOAD_ASSETS` key in your `.php-wasm-rc` file to define a list of files and directories to include by default.

The files and directories will be collected into a single directory. Individual files & directories will appear in the top level, while directories will maintain their internal structure.

These files & directories will be available under `/preload` in the final package, packaged into the `.data` file that is built along with the `.wasm` file.

```bash
PRELOAD_ASSETS='/path/to/file.txt /some/directory /path/to/other_file.txt /some/other/directory'
```

### locateFile

You can provide the `locateFile` option to php-wasm as a callback to map the names of files to URLs where they're loaded from. `undefined` can be returned as a fallback to default.

You can use this if your static assets are served from a different directory than your javascript.

This applies to `.wasm` files, shared libraries, single files and preloaded FS packages in `.data` files.

```javascript
const php = new PhpWeb({locateFile: filename => `/my/static/path/${filename}`});
```

## 💾 Persistent Storage (IDBFS & NodeFS)

### IDBFS (Web & Worker)

To use IDBFS in PhpWeb, pass a `persist` object with a `mountPath` key.

`mountPath` will be used as the path to the persistent directory within the PHP environment.

```javascript
const { PhpWeb } = await import('https://cdn.jsdelivr.net/npm/php-wasm/PhpWeb.mjs');

const php = new PhpWeb({persist: {mountPath: '/persist'}});
```

### NodeFS (NodeJS Only)

To use NodeFS in PhpWeb, pass a `persist` object with `mountPath` & `localPath` keys.

`localPath` will be used as the path to the HOST directory to expose to PHP.
`mountPath` will be used as the path to the persistent directory within the PHP environment.

```javascript
const { PhpNode } = await import('https://cdn.jsdelivr.net/npm/php-wasm/PhpNode.mjs');

const php = new PhpNode({persist: {mountPath: '/persist', localPath: '~/your-files'}});
```
