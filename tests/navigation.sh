#!/usr/bin/env bash

set -euo pipefail

ROOT_DIR=$(cd -- "$(dirname -- "${BASH_SOURCE[0]}")/.." && pwd)
cd "${ROOT_DIR}"

./build.sh >/dev/null

page=docs/index.html
docs_page=docs/getting-started/home.html

for expected in \
	'data-menu="primary"' \
	'href="/"' \
	'>Home</span>' \
	'href="/demos.html"' \
	'href="/getting-started/home.html"' \
	'href="/contact.html"' \
	'menu-link-icon--github' \
	'menu-link--cta' \
	'data-menu="footer-resources"' \
	'data-menu="footer-contact"'
do
	grep -Fq -- "${expected}" "${page}"
done

grep -Fq -- 'data-menu="sidebar"' "${docs_page}"
grep -Fq -- 'aria-current="page"' "${docs_page}"
! grep -Fq -- 'nag-bar.js' "${page}"
! grep -Fq -- 'archive.css' "${page}"
! test -e docs/nag-bar.js

git diff --check
printf 'PASS: php-wasm-site navigation\n'
