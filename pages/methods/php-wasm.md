---
pagetitle: php-wasm methods
weight: -1000
itemtype: schema.org/Class
microdata:
    name: PhpWasm
    alternateName: PhpWorker
    alternateName: PhpWebView
    alternateName: PhpNode
    alternateName: PhpWeb
---
# php-wasm methods

## constructor

## php.run

Run a php script. Code should start with the opening `<?php` tag and may optionally close with `?>` to allow for HTML interpolation.

Will return a non-zero value in case of error. You'll need to use [event listeners](http://localhost:8081/getting-started/php-in-js.html#running-php-taking-output) to get output.

```javascript
php.run(`<?php
    $time = strtotime('8:00pm 2 days ago');
    $date = date('Y-m-d H:i:s', $time);
    echo $date;
`);
```

## php.exec

Similar to `php.run()`, but executes a single PHP *statement* rather than an entire script. Code should ***not*** start with a `<?php` tag and should ***not*** end in a semicolon.

The return value of the PHP statement will be the return value of `php.exec`. If Vrzno is enabled and a function or object is returned, the value will be marshalled to Javascript.

To run multiple commands in a single statement, use an [IIFE](https://en.wikipedia.org/wiki/Immediately_invoked_function_expression).

```javascript
php.exec(`
    (function() {
        $time = strtotime('8:00pm 2 days ago');
        $date = date('Y-m-d H:i:s', $time);
        return $date;
    })();
`);
```

## php.r

Tagged template function companion to `php.run()`. If Vrzno is enabled, allows rich JS values to be interpolated into PHP code.

Just like `php.run()`, this will return a non-zero value in case of error.

```javascript
php.r`
    $time = strtotime('8:00pm 2 days ago');
    $date = date('Y-m-d H:i:s', $time);
    echo $date;
`;
```

## php.x

Tagged template function companion to `php.exec()`. If Vrzno is enabled, allows rich JS values to be interpolated into PHP code.

Just like `php.exec()` this value may only run a single PHP statement at a time and returns the JS value directly to PHP.

```javascript
const date = php.x`<?php
        (function() {
        $time = strtotime('8:00pm 2 days ago');
        $date = date('Y-m-d H:i:s', $time);
        return $date;
    })();
`;
```

## php.refresh

Clears the memory. If any objects, arrays or functions have been returned to JS, these will become invalid when php is refreshed.

```javascript
php.refresh();
```
