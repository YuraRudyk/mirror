#!/usr/bin/env bash

# Abort on errors
set -e

# Print executed commands
set -x

ROOT_PATH="$(pwd)"

echo $BUILD_REF > web/REVISION.txt

echo "composer install"
composer install --verbose --prefer-dist --no-progress --no-interaction --optimize-autoloader --profile

echo "start build"
if [ -d build ]
  then
    rm -rf build
fi
mkdir build

if [ -d cache ]
  then
    rm -rf cache
fi
mkdir cache
cp -r web vendor cache build/

if [ -f build.tar.gz ]
  then
    rm build.tar.gz
fi
tar --exclude='vendor/*/.git' --exclude='.git' -czf build.tar.gz build