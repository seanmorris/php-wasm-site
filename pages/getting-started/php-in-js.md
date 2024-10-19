---
title: PHP in Javascript
---
# PHP in Javascript

## 🥤 Running PHP & Taking Output

Create a PHP instance:

```javascript
const { PhpWeb } = await import('https://cdn.jsdelivr.net/npm/php-wasm/PhpWeb.mjs');
const php = new PhpWeb;
```

Add your output listeners:

```javascript
// Listen to STDOUT
php.addEventListener('output', (event) => {
	console.log(event.detail);
});

// Listen to STDERR
php.addEventListener('error', (event) => {
	console.log(event.detail);
});
```

Provide some input data on STDIN if you need to:

```javascript
php.inputString('This is a string of data provided on STDIN.');
```

... then run some PHP!

```javascript
const exitCode = await php.run('<?php echo "Hello, world!";');
```
