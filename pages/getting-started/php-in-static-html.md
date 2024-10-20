---
title: PHP in Static HTML
weight: -700
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

``` { .html highlight="5" }
<script async type = "text/javascript" src = "https://cdn.jsdelivr.net/npm/php-wasm/php-tags.jsdelivr.mjs"></script>

<script id = "input" type = "text/plain">Hello, world!</script>

<script type = "text/php" data-stdin = "#input" data-stdout = "#output" data-stderr = "#error">
	<?php echo file_get_contents('php://stdin');
</script>

<div id = "output"></div>
<div id = "error"></div>
```

The `src` attribute can be used on `<script type = "text/php">` tags, as well as their input elements. For example:

``` { .html highlight="4,5" }
<html>
	<head>
		<script async type = "module" src = "https://cdn.jsdelivr.net/npm/php-wasm@0.0.9-alpha-20/php-tags.mjs"></script>
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

```{ .html numbers="true" highlight="4-6" }
<script type = "text/php"
    data-stdout = "#output"
    data-stderr = "#error"
    data-libs = '[
        {"url": "https://unpkg.com/php-wasm-yaml/php8.3-yaml.so", "ini": true},
        {"url": "https://unpkg.com/php-wasm-yaml/libyaml.so", "ini": false}]'
><?php
  print yaml_emit([1,2,3,"string",["k1" => "value", "k2" => "value2", "k3" => "value3"],"now" => date("Y-m-d h:i:s")]);
</script>
```

You can find the full list of extensions here: [extensions/using-php-extensions.html#extension-list](/extensions/using-php-extensions.html#extension-list)

Here is a less-than-trivial example that loads zlib, gd, libwebp & others:

https://codepen.io/SeanMorris227/pen/Yzbbrre

```html
<a target = "_blank" href = "https://github.com/seanmorris/php-wasm">https://github.com/seanmorris/php-wasm</a><hr />
<script async type = "module" src = "https://cdn.jsdelivr.net/npm/php-wasm@0.0.9-alpha-20/php-tags.mjs"></script>
<script
  type = "text/php"
  data-stdout = "div#output"
  data-stderr = "pre#error"
  data-libs   = '[
    {"url": "https://unpkg.com/php-wasm-zlib/php8.3-zlib.so", "ini": true},
    {"url": "https://unpkg.com/php-wasm-zlib/libz.so",        "ini": false},
    {"url": "https://unpkg.com/php-wasm-gd/php8.3-gd.so",     "ini": true},
    {"url": "https://unpkg.com/php-wasm-gd/libpng.so",        "ini": false},
    {"url": "https://unpkg.com/php-wasm-gd/libjpeg.so",       "ini": false},
    {"url": "https://unpkg.com/php-wasm-gd/libwebp.so",       "ini": false},
    {"url": "https://unpkg.com/php-wasm-gd/libfreetype.so",   "ini": false}
  ]'
  data-files  = '[{
    "name": "Montserrat-Regular.ttf",
    "parent": "/preload/",
    "url": "https://cdn.jsdelivr.net/npm/pstpn-webfont-montserrat@0.0.5/fonts/Regular/Montserrat-Regular.ttf"
  }]'
><?php
  $text = 'Hello, webp!';
  $quality = 0;
  $quality = 1000;

  // Draw an image:
  $image    = imageCreate(600,400);
  imagepalettetotruecolor($image);
  $colorOne = imageColorAllocate($image, 0xFF, 0x00, 0xFF);
  $colorTwo = imageColorAllocate($image, 0x00, 0xFF, 0x80);
  imageFilledRectangle($image, 0,  0,  600, 400, $colorOne);
  imageFilledRectangle($image, 50, 50, 550, 350, $colorTwo);
  imagettftext($image, 50, 0, 95, 212, $colorOne, '/preload/Montserrat-Regular.ttf', $text);

  // Render it as a JPEG:
  ob_start();
  imageWebp($image, null, $quality);
  $webp = ob_get_contents();
  imageDestroy($image);
  ob_end_clean();

  // Print it in an IMG tag as a data uri:
  echo '<img src = "data:image/webp;base64,'. base64_encode($webp) . '">';

?></script>
<div id = "output"></div>
<pre id = "error"></pre>

```
