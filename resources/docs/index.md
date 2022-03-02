# My New Documentation Page

## About
This is a page required by the generator, though you are free to customize it.
When generating the static site this will become the index.html file.

### Documentation
Full documentation is available at [docs.desilva.se/laradocgen](https://docs.desilva.se/laradocgen/). Generated using this package of course!

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

> Have fun building your site!