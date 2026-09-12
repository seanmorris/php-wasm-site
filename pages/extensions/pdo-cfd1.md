---
title: pdo-cfd1
---
# pdo-cfd1

`pdo-cfd1` connects PHP's PDO interface to actual Cloudflare D1 bindings.
The dedicated **`php-cloud-wasm`** profile statically includes the supported
prepared-query subset for PHP 8.0–8.5, including an explicit PHP 8.0 ABI backport.
It does not require a browser/Node extension loader.

Start with [PHP in Cloudflare](/getting-started/php-in-cloudflare.html) for the
complete build, raw Wasm module upload, Pages configuration and deployment guide.
An ordinary `PhpWorker` build is not interchangeable with this Cloudflare profile.

## Runtime setup

Import a version-bound entry from the complete package and create the PHP
instance inside each Worker request:

```javascript
import { PhpCloudflare } from './php-cloud-wasm/php8.5-cloudflare.mjs';

const php = new PhpCloudflare({
  cfd1: { mainDb: env.DB },
});
```

The example assumes a copied package beside your Worker entry. `env.DB` is the
Worker's configured D1 binding; `mainDb` is the PHP-facing name. The generated
entry supplies the matching precompiled Wasm module and runtime factory.

## Query D1 through PDO

Use `cfd1:<mapKey>` and positional prepared-statement parameters:

```javascript
await php.run(`<?php
  $pdo = new PDO('cfd1:mainDb', null, null, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  ]);
  $query = $pdo->prepare('SELECT ? AS answer');
  $query->bindValue(1, 42, PDO::PARAM_INT);
  $query->execute();
  echo json_encode($query->fetch(PDO::FETCH_ASSOC));
`);
```

This query needs no schema. Capture the runtime's `output` event to form the
HTTP response, as shown in the setup guide. Use numeric typed `bindValue` or
`bindParam` when the parameter type matters; values passed through
`execute([...])` follow PDO's parameter conventions.

## Supported scope and errors

- Positional `?` prepared queries, numeric `bindValue` and `bindParam`.
- Repeated `execute`, associative `fetch`/`fetchAll`, scalar and NULL parameters.
- SELECT, INSERT, UPDATE and DELETE; write `rowCount()` uses D1's changes count.
- Missing bindings and failed queries report PDO errors. Exception mode raises
  `PDOException`; silent mode exposes `errorInfo()`.

Named or numbered placeholders, transactions, direct PDO `exec`, `quote` and
`lastInsertId` are unsupported and fail explicitly. This is not full PDO or D1
API parity. Do not accept arbitrary SQL or binding names from public requests.

The Cloudflare build selects the pinned driver source and compatibility patch;
simply enabling an extension in an older generic build is not an equivalent
runtime. The [legacy php-static PDO example](https://github.com/seanmorris/php-static/blob/cdcaa8540cd7fcdeb445e65dba35a9882acefa7d/pdo.php)
uses a `vrzno:` DSN, which must be migrated to the binding map and `cfd1:` API
above.

See the [PDO-CFD1 integration guide](https://github.com/seanmorris/php-wasm/blob/master/packages/pdo-cfd1/README.md),
[upstream driver](https://github.com/seanmorris/pdo-cfd1), and
[Cloudflare D1 bindings](https://developers.cloudflare.com/pages/functions/bindings/#d1-databases).
