#!/usr/bin/env bash

set -euo pipefail

SMGEN_BIN=${SMGEN_BIN:-smgen}

exec "${SMGEN_BIN}" build "$@"
