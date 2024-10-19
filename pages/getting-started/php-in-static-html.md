---
title: PHP in Static HTML
---
# php-wasm in Static HTML

PHP can be included in static HTML pages that are served with no dynamic processing on the backend whatsoever. Just use the `php-tags.js` script from a CDN in your page:

**JSDelivr**

```html
<script async type = "text/javascript" src = "https://cdn.jsdelivr.net/npm/php-wasm/php-tags.jsdelivr.mjs"></script>
```

**Unpkg**

```html
<script async type = "text/javascript" src = "https://www.unpkg.com/php-wasm/php-tags.unpkg.mjs"></script>
```

Once you've included that, you can start writing php within `<script type = "text/php">` tags:

```html
<script type = "text/php" data-stdout = "#output">
    <?php phpinfo();
</script>

<div id = "output"></div>
```

Inline php can use standard input, output and error with `data-` attributes. Just set the value of the attribute to a selector that will match that tag.

``` { .html highlight="4" }
<script async type = "text/javascript" src = "https://cdn.jsdelivr.net/npm/php-wasm/php-tags.jsdelivr.mjs"></script>

<script id = "input" type = "text/plain">Hello, world!</script>

<script type = "text/php" data-stdin = "#input" data-stdout = "#output" data-stderr = "#error">
	<?php echo file_get_contents('php://stdin');
</script>

<div id = "output"></div>
<div id = "error"></div>
```

The `src` attribute can be used on `<script type = "text/php">` tags, as well as their input elements. For example:

``` { .html highlight="3,4" }
<html>
	<head>
		<script async type = "text/javascript" src = "https://cdn.jsdelivr.net/npm/php-wasm/php-tags.jsdelivr.mjs"></script>
		<script id = "input" src = "/test-input.json" type = "text/json"></script>
		<script type = "text/php" src = "/test.php" data-stdin = "#input" data-stdout = "#output" data-stderr = "#error"></script>
	</head>
	<body>
		<div id = "output"></div>
		<div id = "error"></div>
	</body>
</html>
```

## Dynamic Extensions in Static Pages

Dynamic extensions can be loaded in static webpages like so:

```html
<script async type = "module" src = "https://cdn.jsdelivr.net/npm/php-wasm@0.0.9-alpha-12/php-tags.mjs"></script>

<script type = "text/php" data-stdout = "#output" data-stderr = "#error" data-libs = '[
  {"url": "https://unpkg.com/php-wasm-yaml/php8.3-yaml.so", "ini": true},
  {"url": "https://unpkg.com/php-wasm-yaml/libyaml.so", "ini": false}
]'><?php
  print yaml_emit([1,2,3,"string",["k1" => "value", "k2" => "value2", "k3" => "value3"],"now" => date("Y-m-d h:i:s")]);
</script>
```
