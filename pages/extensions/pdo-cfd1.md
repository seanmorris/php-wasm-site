---
title: pdo-cfd1
---
# pdo-cfd1

*pdo driver for CloudFlare D1 & php-wasm*

<span class = "highlight">@todo:</span> Walkthrough on compiling php-wasm for cloudflare.

pdo_cfd1 requires PHP 8.1+.

## Connect & Configure

Pass the D1 object into the php-wasm constructor as a key to the `cfd1` object to enable pdo_cfd1 support.

`cfd1:` will become available as a PDO driver:

```javascript
export async function onRequest(event)
{
    const php = new PhpWorker({
        cfd1: { mainDb: event.env.mainDb }
    });

    php.run(`<?php $pdo = new PDO('cfd1:mainDb');`);
}
```

You can check `phpinfo()` to make sure that the D1 object is detected. `CloudFlare D1 SQL module detected` will display "yes" when the object has been passed in correctly:

![](https://raw.githubusercontent.com/seanmorris/pdo-cfd1/refs/heads/master/phpinfo.png)

PDO can be used with D1 just like any other SQL server:

```javascript
export async function onRequest(event)
{
    const php = new PhpWorker({
        cfd1: { mainDb: event.env.mainDb }
    });

    php.run(`<?php
        $pdo = new PDO('cfd1:main');
        $select = $pdo->prepare(
            'SELECT PageTitle, PageContent FROM WikiPages WHERE PageTitle = ?'
        );
        $select->execute([$pageTitle]);
        $page = $select->fetchObject();`
    );
}
```

## Todo

* *Named replacement tokens* - Currently only positional tokens are supported.
* *Error handling* - Error handling is currently very rudimentary and does not propagate messages.

## CloudFlare D1

`pdo_cfd1` is powered by [CloudFlare D1](https://developers.cloudflare.com/d1/).

<https://developers.cloudflare.com/d1/>
