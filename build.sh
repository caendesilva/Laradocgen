#!/bin/bash -x

startTime=$(date +%s);

echo "Building package"

echo "Copying markdown files"
cp README.md resources/docs/readme.md
cp LICENSE.md resources/docs/license.md
cp CHANGELOG.md resources/docs/changelog.md
cp CONTRIBUTING.md resources/docs/contributing.md


echo "Modifying Readme"
# Remove badges
sed '/\BMSTX/,/\BMETX/d' resources/docs/readme.md -i
# Replace links
sed 's/README.md/readme/g' resources/docs/readme.md -i
sed 's/LICENSE.md/license/g' resources/docs/readme.md -i
sed 's/CHANGELOG.md/changelog/g' resources/docs/readme.md -i
sed 's/CONTRIBUTING.md/contributing/g' resources/docs/readme.md -i


echo "Creating index.md"
echo -e "<!--\n This is a page required by the generator, though you are free to customize it.\n When generating the static site this will become the index.html file.\n-->\n" > resources/docs/index.md
cat resources/docs/readme.md >> resources/docs/index.md


endTime=$(date +%s);
totalTime=$(($endTime-$startTime));
echo "Finished in $totalTime seconds"

echo "What's next?"

echo "Please build your assets with 'npx tailwindcss -i ./resources/src/app.css -o ./resources/assets/app.css  --minify'"
echo "Publish the assets to your Laravel test installation with 'php artisan vendor:publish --tag=\"laradocgen\" --force'"
echo "And build the API Documentation with 'php phpDocumentor.phar  -d ./src -t ./docs/api'"