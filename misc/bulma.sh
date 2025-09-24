#!/bin/bash
set -euo pipefail

if ! command -v sass >/dev/null 2>&1
then
    echo "dart-sass could not be found"
    exit 1
fi

SCRIPT_DIR=$( cd -- "$( dirname -- "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )

echo "Compiling bulma..."
sass -I "$SCRIPT_DIR/../vendor/npm-asset" \
    -s compressed \
    --embed-sources \
    "$SCRIPT_DIR/../scss/bulma.scss" \
    "$SCRIPT_DIR/../public/css/vendor/bulma.min.css"
echo "Done!"
