# php-wasm-site

Source and generated output for <https://php-wasm.seanmorr.is>.

## Build

The site pins `smgen` in `.smgen-version`. The first build fetches that exact
Git revision into the ignored `.cache/smgen/` directory; later builds reuse it.

Required tools:

- Bash 4+
- Git
- PHP CLI with the yaml extension
- Pandoc
- [mikefarah/yq](https://github.com/mikefarah/yq#install) 4

Install these with your platform's package manager before building. In
particular, verify `yq --version` reports mikefarah/yq v4; some package indexes
also contain an unrelated Python program named `yq`.

Run:

```sh
./build.sh
```

The wrapper uses `uuid` or `uuidgen` when available and otherwise falls back to
the bundled PHP UUID helper. Set `SMGEN_BIN` to test another smgen executable
without changing the repository pin.

Generated output lives in `docs/` and is intentionally committed for GitHub
Pages. Edit `pages/`, `templates/`, or `static/`, then rebuild; do not edit
generated HTML directly.

Preview the generated site with:

```sh
./serve.sh
```
