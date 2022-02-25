# Laravel Static Documentation Sites, Blazingly Fast and Stupidly Simple


## About

Hey! I'm Caen! I created this package to practise package development. It is still very much in beta, but please do send me any feedback you have! I'd love to get some PRs as well.

### Alpha Stage Software
This package is still in the alpha stage. Once it becomes stable and tested enough I will release v1.0 and I will adhere to semantic versioning. But until then I will run canary builds and I am sure there will be breaking changes. I will of course do my best to document them all in the upgrade guides, but all in all, at this stage I would not recommend it for production use. Though since it is intended to run on your local server I don't think much can go wrong as long as you have backups and Git. The only area that is really of concern to me is that since we are working with writing files to disk if something goes wrong files could be overwritten, but as it is now the paths are hardcoded to "safe" directories.

Please do contribute with PRs and bug reports!

## Installation

You can install the package via composer:
```bash
composer require caendesilva/docgen --dev
```

Publish the assets
```bash
php artisan vendor:publish --tag="docgen"
```

Build the static site
```bash
php artisan docgen:build
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

### Build static site
```bash
php artisan docgen:build
```
Your static site will be saved in `public/docs`

## Package Development

Please see [CONTRIBUTING](contributing) for details.

## Changelog

Please see [CHANGELOG](changelog) for more information on what has changed recently.

## Contributing

Right now there are not very many customization options as I wanted to keep things dead simple. If you have a configuration idea please do make a PR as I want to allow for more customization down the line.

Please see [CONTRIBUTING](contributing) for details.

### Roadmap
[ ] Add versioning support

## Security

If you discover any security-related issues, please email caen@desilva.se instead of using the issue tracker.

## Credits

-   [Caen De Silva](https://github.com/caendesilva)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](license) for more information.

## Attributions
> Please see the respective authors' repositories for their license files

### Laravel Package Boilerplate

This package's scaffolding was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).

### Frontend

The frontend is based on https://github.com/creativetimofficial/tailwind-starter-kit (MIT)