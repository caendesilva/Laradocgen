# Changelog

All notable changes to `laradocgen` will be documented in this file.
Once the package is tested to ensure it is stable enough for production semantic versioning (SemVer) will be used.
Until then there may be breaking changes on the Master branch.

## 1.1.X

New features:
- You can now specify the source and build directories in the config.
  - You can also, while not recommended, use absolute paths.
- You can now publish the Blade views.
  - Note that if you have previously published these assets you will have to merge the changes manually.
- The Curl builder now validates the response and sends a warning if a non-200 HTTP code is returned.

Breaking changes:
  - Stylesheet and script files have been moved. Source files are in the assets folder, and compiled files are in the media folder. **This only affects package developers.** 

## 1.0.0-Pre - 2022-03-01

- Prepare for Initial 1.0 Release 

## 0.1.0-Pre - 2022-03-01

- Version 1 Prerelease
- Contains features I deem acceptable for a Version 1 release, but that I want to be further tested before V1.
- All basic package functionality is implemented and tested (with several features tested through PHPUnit).

## 0.1.0 - 2022-02-23

- Initial Dev/Alpha Release
