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
php phpDocumentor.phar

echo "Analyzing code for PSR2 incompatibilities."
phpcs --standard=ruleset.xml
echo "Running PHPCBF to automatically fix violations"
phpcbf --standard=ruleset.xml
echo "Re-Analyzing code for PSR2 incompatibilities."
phpcs --standard=ruleset.xml

echo "Running tests. This may take a few seconds."
(
cd /mnt/d/dev/Laravel/Sites/LaradocgenTests/ && php artisan test
)


echo "Copying static site to docs/package/"
cp -r /mnt/d/dev/Laravel/Sites/LaradocgenTests/public/docs/. /mnt/d/Dev/Laravel/Packages/Laradocgen/docs

echo "Modifying sidebar footer link to link to API Docs"
sed 's/href="\/">Back to App/href="api\/index.html">API Documentation/g' docs/404.html -i
sed 's/href="\/">Back to App/href="api\/index.html">API Documentation/g' docs/contributing.html -i
sed 's/href="\/">Back to App/href="api\/index.html">API Documentation/g' docs/getting-started.html -i
sed 's/href="\/">Back to App/href="api\/index.html">API Documentation/g' docs/index.html -i
sed 's/href="\/">Back to App/href="api\/index.html">API Documentation/g' docs/changelog.html -i
sed 's/href="\/">Back to App/href="api\/index.html">API Documentation/g' docs/how-it-works.html -i
sed 's/href="\/">Back to App/href="api\/index.html">API Documentation/g' docs/license.html -i
sed 's/href="\/">Back to App/href="api\/index.html">API Documentation/g' docs/readme.html -i


endTime=$(date +%s);
totalTime=$(($endTime-$startTime));

echo "Done"

echo "Finished in $totalTime seconds"
