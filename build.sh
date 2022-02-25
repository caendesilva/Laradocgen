#!/bin/bash -x

if [ -n "${1}" ]
then
	echo "Setting directory to $1"
	echo $1 > .build/rootdir
	echo "Done. Please run the script again, without the flag."
	exit 0;
fi

startTime=$(date +%s);

echo "Building package"

echo "Getting root directory"

rootdir=$(cat .build/rootdir)

if [ -z $rootdir ]
then
	echo "Error: Root directory not found"
	exit 0;
fi

echo "Laravel root directory is $rootdir"

echo "Copying markdown files"

cp README.md resources/docs/readme.md
cp LICENSE.md resources/docs/license.md
cp CHANGELOG.md resources/docs/changelog.md
cp CONTRIBUTING.md resources/docs/contributing.md

echo "Done"

echo "Modifying Readme"

# Remove badges
sed '/\BMSTX/,/\BMETX/d' resources/docs/readme.md -i

# Replace links
sed 's/README.md/readme/g' resources/docs/readme.md -i
sed 's/LICENSE.md/license/g' resources/docs/readme.md -i
sed 's/CHANGELOG.md/changelog/g' resources/docs/readme.md -i
sed 's/CONTRIBUTING.md/contributing/g' resources/docs/readme.md -i

echo "Done"


printf "Building assets. This may take a few seconds."

while sleep 1; do printf "."; done &
npx tailwindcss -i ./resources/src/app.css -o ./resources/assets/app.css  --minify
kill $!

echo "Done"

echo "Publishing assets"
spinner=( '|' '/' '-' '\' );
while true; do
for item in ${spinner[*]}
    do
        echo -en "\r$item"
        sleep .1
        echo -en "\r              \r"
    done
done &
php ${rootdir}/artisan vendor:publish --tag="docgen" --force
kill $!
echo "Done"

endTime=$(date +%s);
totalTime=$(($endTime-$startTime));

echo "Finished in $totalTime seconds"