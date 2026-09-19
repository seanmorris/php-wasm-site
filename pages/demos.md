---
title: Demo
template: templates/with-hero.php
hero: hero-frame.php
framed: https://seanmorris.github.io/php-wasm/select-framework.html?iframed=1&no-service-worker=1
leftBarLink: false
TOC: false
---

# Demo

Use the dialog above to launch a 100% local, user-editable site with a given framework.

## Editing files

The [Code Editor](https://seanmorris.github.io/php-wasm/code-editor.html) opens a
saveable untitled document when no file is selected. Use **File** to open an
existing path, or **Save** to choose a destination. PHP and the debugger see saved
files; draft recovery keeps unsaved edits separately. Files under `/persist` and
`/config` survive worker restarts. The editor supports file/folder operations,
uploads, downloads, ZIP transfers, quick open, and checked conflict handling.

The [VS Code example](https://seanmorris.github.io/php-wasm/vscode.html) uses the
same demo filesystem through File Bus. Directory expansion requests names and
types together when supported by both the host and runtime.

The [home page](https://seanmorris.github.io/php-wasm/home.html) lists the demos;
**More…** includes Query Workbench and PHP-CLI Preview. Interactive line input
remains available in the CLI and debugger; the standalone Waitline test link
has been removed from that menu.

## PHP Scripts

Use the editor below to write PHP scripts that run right in the page:

<iframe class = "page-demo" src = "https://seanmorris.github.io/php-wasm/embedded-php.html?iframed=1&no-service-worker=1&demo=sdl-sine.php"></iframe>
