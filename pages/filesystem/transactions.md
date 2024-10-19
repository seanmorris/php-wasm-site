# Transactions

**Web and Worker only!**

The web and worker build use `navigator.locks.request` to request a lock named `php-wasm-fs-lock` before performing filesystem operations. This ensure multiple tabs & the service worker can interact with the filesystem without overwriting eachother's work. Before any FS operation takes place, the entire FS is loaded from IDBFS, and before the lock is released, the entire FS is laoded BACK into IDBFS.

The operations are enqueued asyncronously, **so if multiple requests are generated before one transaction closes, they will be batched automatically.** This also applies to multiple requests generated before the lock is acquired. There is generally no need to take explicit control of FS mirroring.

To suppress this behavior and take explicit control of the FS mirroring, you can pass the `{autoTransaction: false}` option to the constructor. Doing this will require you to call `php.startTransaction()` before any FS operations take place, and then`php.commitTransaction()` when you're done. **Using this incorrectly may leave your filesystem in a corrupted state.**

#### php.startTransaction

```javascript
await php.startTransaction();
```

#### php.commitTransaction

```javascript
await php.commitTransaction();
```
