# Very short description of the package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/caendesilva/docgen.svg?style=flat-square)](https://packagist.org/packages/caendesilva/docgen)
[![Total Downloads](https://img.shields.io/packagist/dt/caendesilva/docgen.svg?style=flat-square)](https://packagist.org/packages/caendesilva/docgen)
![GitHub Actions](https://github.com/caendesilva/docgen/actions/workflows/main.yml/badge.svg)

This is where your description should go. Try and limit it to a paragraph or two, and maybe throw in a mention of what PSRs you support to avoid any confusion with users and contributors.

## Installation

You can install the package via composer:

```bash
composer require caendesilva/docgen
```

Make sure to enable the extensions in commonmark

To use images in the realtime compiler, add the following to config/filesystems.php
// Link images in the documentation
'links' => [
	public_path('docs/master/media') => resource_path('docs/src/media'),
],

and run php artisan storage:link

> If you get the error "The system cannot find the path specified." try creating the public/docs/master directories manually and then try again

**Note that you don't need to do this when you build the assets to the static site which is recommended.**

## Usage

Markdown files must in lowercase kebab-case and end in .md and must not contain spaces. In essence they must be compatible with Str::slug()

```php
// Usage description here
```

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Right now there are not very many customization options as I wanted to keep things dead simple. If you have a configuration idea please do make a PR as I want to allow for more customization down the line.

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email caen@desilva.se instead of using the issue tracker.

## Credits

-   [Caen De Silva](https://github.com/caendesilva)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).

## Frontend

The frontend is based on https://github.com/creativetimofficial/tailwind-starter-kit (MIT)