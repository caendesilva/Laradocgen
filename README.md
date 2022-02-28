# Laravel Static Documentation Sites, Blazingly Fast and Stupidly Simple
> Now with Dark Mode Support!

<!-- \BMSTX BUILDMETA -->
[![Latest Version on Packagist](https://img.shields.io/packagist/v/desilva/laradocgen.svg?style=flat-square)](https://packagist.org/packages/desilva/laradocgen)
[![Total Downloads](https://img.shields.io/packagist/dt/desilva/laradocgen.svg?style=flat-square)](https://packagist.org/packages/desilva/laradocgen)
![GitHub Actions](https://github.com/desilva/laradocgen/actions/workflows/main.yml/badge.svg)
<!--  BUILDMETA \BMETX -->

## About

Hey! I'm Caen! I created this package to practice package development. It is still very much in beta, but please do send me any feedback you have! I'd love to get some PRs as well.

### Alpha Stage Software
Hey! Just a quick heads up that this is a very new package and I expect there to be bugs. If anything goes wrong, do let me know and I'd love to get feedback and PRs!

<small>
**Disclaimer**
This package is still in the alpha stage. Once it becomes stable and tested enough I will release v1.0 and I will adhere to semantic versioning. But until then I will run canary builds and I am sure there will be breaking changes. I will of course do my best to document them all in the upgrade guides, but all in all, at this stage I would not recommend it for production use. Though since it is intended to run on your local server I don't think much can go wrong as long as you have backups and Git. The only area that is really of concern to me is that since we are working with writing files to disk if something goes wrong files could be overwritten, but as it is now the paths are hardcoded to "safe" directories so it should only be able to overwrite files already created by the package.
</small>

## Installation
> The package has so far only been tested with Laravel 9

You can install the package via composer:
```bash
composer require desilva/laradocgen --dev
```

Publish the assets
```bash
php artisan vendor:publish --tag="laradocgen"
```

Build the static site
```bash
php artisan laradocgen:build
```
Your static site will be saved in `public/docs`

## Usage

### Adding pages
Pages are generated from markdown files stored in `resources/docs/`.

Markdown filenames are sanitized through Str::slug(). To prevent 404 errors the filenames must be compatible. In essence, they must be in lowercase kebab-case and end in .md and must not contain spaces.
```bash
❌ "kebab case title.markdown" # Returns 404
✔️ "kebab-case-title.md" # creates my-page-title.html and renders as "My Page Title" in the frontend
```

And store your images in `resources/docs/media/`
```markdown
![My Image](media/image.png "Image Title") # Note the relative path
```

### Build the static site
```bash
php artisan laradocgen:build
```
Your static site will be saved in `public/docs`

## Package Development

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Roadmap
- [ ] Add (automatic) versioning support
- [ ] Allow the specification of source/build directories. This can also be used for versioning.
- [ ] Allow the package to run standalone from Laravel
- [ ] Document Blade [view customization](https://laravel.com/docs/9.x/packages#views)
- [ ] Add Search feature 

Right now there are not very many customization options as I wanted to keep things dead simple. If you have a configuration idea please do make a PR or open a Ticket as I want to allow for more customization down the line.


## Security

If you discover any security-related issues, please email caen@desilva.se instead of using the issue tracker.
All vulnerabilities will be promptly addressed.

## Credits

-   [Caen De Silva](https://github.com/desilva)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Attributions
> Please see the respective authors' repositories for their license files

### Laravel Package Boilerplate

This package's scaffolding was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).

### Frontend

- The frontend is based on the [Tailwind Starter Kit](https://github.com/creativetimofficial/tailwind-starter-kit) from Creative Tim (MIT)
- The dark-mode switch is based on a component from [Flowbite](https://flowbite.com/docs/customize/dark-mode/) (MIT)

### Packages used and special mentions
- The frontend is built with [TailwindCSS](https://tailwindcss.com/)
- Syntax highlighting by [Torchlight](https://torchlight.dev/)
- Markdown is parsed with [League/Commonmark](https://github.com/thephpleague/commonmark)
- The default favicon was created using [Favicon.io](https://favicon.io/) using the ["Page" Emoji](https://github.com/twitter/twemoji/blob/master/assets/svg/1f4c4.svg) from the amazing open-source project [Twemoji](https://twemoji.twitter.com/). The graphics are copyright 2020 Twitter, Inc and other contributors and are licensed under [CC-BY 4.0](https://creativecommons.org/licenses/by/4.0/).