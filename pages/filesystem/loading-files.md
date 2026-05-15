---
title: Loading Files
---
# Loading Files

### Loading Single Files

The constructor method of the php-wasm objects accepts a `files` parameter to load files into the filesystem by URL. For example, dynamic and shared `php-intl` builds require `icudt72l.dat` to be loaded into the `/preload` directory. Static `intl` builds can bundle that file into the runtime `.data` payload instead.

```javascript
const sharedLibs = [
  { name: 'libicuuc.so',   url: 'https://unpkg.com/php-wasm-intl/libicuuc.so' },
  { name: 'libicutu.so',   url: 'https://unpkg.com/php-wasm-intl/libicutu.so' },
  { name: 'libicutest.so', url: 'https://unpkg.com/php-wasm-intl/libicutest.so' },
  { name: 'libicuio.so',   url: 'https://unpkg.com/php-wasm-intl/libicuio.so' },
  { name: 'libicui18n.so', url: 'https://unpkg.com/php-wasm-intl/libicui18n.so' },
  { name: 'libicudata.so', url: 'https://unpkg.com/php-wasm-intl/libicudata.so' },
];

const files = [
	{
		name: 'icudt72l.dat',
		parent: '/preload/',
		url: 'https://unpkg.com/php-wasm-intl/icudt72l.dat'
	}
];

const php = new PhpWeb({sharedLibs, files});
```

If you use the `php-wasm-intl` module directly, it will provide both the ICU support libraries and the `icudt72l.dat` preload file for dynamic builds. Shared runtimes should use the same preload file, but only inject the `libicu*.so` support libraries, not `php8.x-intl.so`.

### Preloaded FS

Use the `PRELOAD_ASSETS` key in your `.php-wasm-rc` file to define a list of files and directories to include by default.

See [compiling/php-wasm-rc.html#preload_assets](/compiling/php-wasm-rc.html#preload_assets) for more information.

### locateFile

You can provide the `locateFile` option to php-wasm as a callback to map the names of files to URLs where they're loaded from. Returning `undefined` will fallback to the default behavior.

This option is useful if your static assets are served from a different directory than your JavaScript files. It applies to .wasm files, shared libraries, single files, and preloaded FS packages in .data files.

```javascript
const php = new PhpWeb({locateFile: filename => `/my/static/path/${filename}`});
```

## Persistent Storage

### IDBFS (Web & Worker)

To use IDBFS in PhpWeb, pass a `persist` object with a `mountPath` key. The value of `mountPath` will be used as the path to the persistent directory within the PHP environment.

```javascript
const { PhpWeb } = await import('https://cdn.jsdelivr.net/npm/php-wasm/PhpWeb.mjs');

const php = new PhpWeb({persist: {mountPath: '/persist'}});
```

### NodeFS (Node.js Only)

To use NodeFS in `PhpNode`, pass a `persist` object with `mountPath` and `localPath` keys.

`localPath` will be used as the path to the host directory to expose to PHP.
`mountPath` will be used as the path to the persistent directory within the PHP environment.

```javascript
const { PhpNode } = await import('https://cdn.jsdelivr.net/npm/php-wasm/PhpNode.mjs');

const php = new PhpNode({persist: {mountPath: '/persist', localPath: '~/your-files'}});
```
