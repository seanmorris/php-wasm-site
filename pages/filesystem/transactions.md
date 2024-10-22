# Transactions

**Note: This feature is available for Web and Worker environments only!**

The web and worker builds utilize `navigator.locks.request` to request a lock named `php-wasm-fs-lock` before performing filesystem operations. This ensures that multiple tabs and the service worker can interact with the filesystem without overwriting each other's work.

Before any filesystem operation occurs, the entire filesystem is loaded from IDBFS, and before releasing the lock, the entire filesystem is loaded back into IDBFS.

The operations are enqueued asynchronously, meaning that **if multiple requests are generated before one transaction closes, they will be automatically batched.** This also applies to multiple requests generated before the lock is acquired. Generally, there is no need to take explicit control of filesystem mirroring.

## Manual Control of FS Mirroring

If you prefer to suppress this automatic behavior and take explicit control over filesystem mirroring, you can pass the `{autoTransaction: false}` option to the constructor. In this case, you will need to call `php.startTransaction()` before any filesystem operations, and then `php.commitTransaction()` when you are done. **Using this incorrectly may leave your filesystem in a corrupted state.**

### php.startTransaction

```javascript
await php.startTransaction();
```

### php.commitTransaction

```javascript
await php.commitTransaction();
```
