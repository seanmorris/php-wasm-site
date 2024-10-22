---
pagetitle: Php-Cgi-Wasm Methods
itemtype: schema.org/Class
microdata:
    name: PhpCgiWasm
    alternateName: PhpCgiWeb
    alternateName: PhpCgiWebView
    alternateName: PhpCgiNode
    alternateName: PhpCgiWorker
---
# Php-Cgi-Wasm Methods

## constructor

<span class = "highlight">@todo</span> Finish documenting constructor options object.

The php-cgi-wasm constructor takes an options bucket object as its single parameter. The keys are outlined below.

```javascript
const php = new PhpCgiWorker;
```

### sharedLibs

*array of objects*

```javascript
const php = new PhpCgiWorker({
    sharedLibs: [
        { url: 'https://unpkg.com/php-wasm-sqlite/php8.3-sqlite.so', ini: true  },
        { url: 'https://unpkg.com/php-wasm-sqlite/sqlite.so',        ini: false },
    ]
});
```

### files

*array of objects*

```javascript
const php = new PhpCgiWorker({
    files: [
        {
            name: 'icudt72l.dat',
            parent: '/preload/',
            url: 'https://unpkg.com/php-wasm-intl/icudt72l.dat'
        }
    ]
});
```

### actions

*objects<string, function>*

```javascript
const php = new PhpCgiWorker({
    actions: {
        helloWorld: (php, name) => {
            return `Hello, ${name}!`;
        },
    }
});
```

### locateFile

*function*

```javascript
const result = await sendMessage('hello', 'person');
```

### docroot

*string*

Tells php where to find the php source files for your website inside the emscripten filesystem.

```javascript
const php = new PhpCgiWorker({
    docroot: '/persist/public'
});
```

### entrypoint

The file within `docroot` that should be used as the application entrypoint.


```javascript
const php = new PhpCgiWorker({
});
```

### prefix

*string*

If a request is made with a pathname that starts with `prefix`, php-cgi-wasm will activate and attempt to route the request to PHP rather than allowing it to proceed to the network.

```javascript
const php = new PhpCgiWorker({
});
```

### exclude

*array of strings*

If a request matched the prefix, but the URL also matches an element of `exclude`, then PHP will ignore the request and it will be sent to the network.

```javascript
const php = new PhpCgiWorker({
});
```

### rewrite

*function(string): string*

Pass a function that will receive paths and rewrite them before PHP begins routing.

```javascript
const php = new PhpCgiWorker({
});
```

### types

*object.<string, string>*

```javascript
const php = new PhpCgiWorker({
});
```

### notFound

*function(request): response*

This callback will be called when the requested PHP script/static asset is not found, and should return a `Response` object.

```javascript
const php = new PhpCgiWorker({
});
```

### onRequest

*function(request, response): void*

Callback to run for every request.

```javascript
const php = new PhpCgiWorker({
});
```

## handleInstallEvent

In service workers, this hooks into the `install` event. This should be set up as follows:

```javascript
self.addEventListener('install', event => php.handleInstallEvent(event));
```

In service workers, this hooks into the `activate` event. This should be set up as follows:

## handleActivateEvent

```javascript
self.addEventListener('activate', event => php.handleActivateEvent(event));
```

In service workers, this hooks into the `message` event. This should be set up as follows:

## handleMessageEvent

```javascript
self.addEventListener('message', event => php.handleMessageEvent(event));
```

In service workers, this hooks into the `fetch` event, and will call the `request` method in service workers.

This should be set up as follows:

## handleFetchEvent

```javascript
self.addEventListener('fetch', event => php.handleFetchEvent(event));
```

## request

The `request` method only needs to be called manually if PHP-CGI is running under NodeJS, or inside of a webpage. When running in a service worker, `handleFetchEvent` will call `request` internally.

## refresh

This will discard the current PHP instance and spin up a brand new one.
