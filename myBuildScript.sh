#!/bin/bash -x

# This is a script to run all building steps. It's hardcoded to work on my system.
# If you want to use this script, just swap out the paths so they work for you, and add this file to the .gitignore.

echo "Running all package builds"

startTime=$(date +%s);

bash build.sh

echo "Building assets. This may take a few seconds."
npx tailwindcss -i ./resources/src/app.css -o ./resources/assets/app.css  --minify

echo "Publishing assets. This may take a few seconds."
php /mnt/d/dev/Laravel/Sites/LaradocgenTests/artisan vendor:publish --tag="laradocgen" --force

echo "Building API Documentation. This may take a few seconds."
php phpDocumentor.phar  -d ./src -t ./docs/api

echo "Analyzing code for PSR2 incmpatabilities"
phpcs --standard=ruleset.xml

echo "Running tests. This may take a few seconds."
(
cd /mnt/d/dev/Laravel/Sites/LaradocgenTests/ && php artisan test
)

endTime=$(date +%s);
totalTime=$(($endTime-$startTime));

echo "Done"

echo "Finished in $totalTime seconds"