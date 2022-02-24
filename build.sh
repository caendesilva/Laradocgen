#!/bin/bash -x

echo "Building package"

cp README.md resources/docs/readme.md
cp LICENSE.md resources/docs/license.md
cp CHANGELOG.md resources/docs/changelog.md
cp CONTRIBUTING.md resources/docs/contributing.md

echo "Publishing assets"

php ../../../artisan vendor:publish --tag="docgen" --force

echo "Done"