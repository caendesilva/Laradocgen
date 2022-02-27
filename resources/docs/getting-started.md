# Creating a static documentation site blazingly fast and stupidly simple with DeSilva/Laradocgen for Laravel

<p class="subheading">
Hey! I'm Caen! I created this package to practice package development. It is still very much in beta, but please do send me any feedback you have! I'd love to get some PRs as well.
</p>

## Quickstart
> Want to get started fast? Follow this Quickstart guide. <br>
> Need more detail? Follow the step-by-step guide below.

### Installation
```bash
# Include the package as a dev dependency
composer require desilva/laradocgen --dev

# Publish the assets. 
php artisan vendor:publish --tag="laradocgen"
```
Publishing the assets is required as it creates the necessary directories and scaffolds the files. It also publishes the stylesheet.

### Creating documentation pages
Save your documentation as Markdown files resources/docs directory.
Example: `<laravel-project>/resources/docs/<your-markdown-file>.md` 

### Building the static site
Building the site is a breeze. Simply start your development server and run the Artisan build command
```bash
# Ensure your site is accessible at http://localhost:8000/ [tl! autolink]
php artisan serve

# Run the static site builder
php artisan laradocgen:build
```

The generated static site saved in `<laravel-project>/public/docs`. You can keep it there to automatically serve them from the /docs URI path. Or, you can also upload them to your static site host.

**That's it! Have fun building your documentation!**

### What's next?
I recommend that you read the rest of the article to learn more about how the package works.


## Step by Step Installation Guide

### Speedrun
If you know your way around Laravel you can skip to the [summary](#summary) 

This guide assumes you are familiar with the basics of Laravel and will not go into detail on the installation.
The guide uses Laravel 9.

### Install Laravel

Let's start by creating a new project. I will be using Composer. If you already have a site you can skip this step.

```bash
composer create-project laravel/laravel laradocgen-demo
 
cd laradocgen-demo
 
php artisan serve

# Now you can visit http://localhost:8000/ in your browser to verify the install. [tl! autolink]
```

### Install the package

Next, we need to install the Composer package. Since this is a static site generator we don't need it in production, thus we are adding the --dev flag.

```bash
composer require desilva/laradocgen --dev
```

### Publish the assets

Next, you need to publish the assets using
```bash
php artisan vendor:publish --tag="laradocgen"
```
This publishes the stylesheet, config, and also creates some sample files for you to get started quickly with.

![Screenshot of the files created](https://cdn.desilva.se/static/media/screenshots/gssh1.png)

#### About the assets
Here is a quick explanation about what they do

The main folder is in `resources/docs`. This is where we store all the markdown files. As you can see there is currently an `index.md` file. This will be converted into the `index.html`.

We also have a media directory that stores images and the default stylesheet. 
> If you want to add custom styles, create a file called `custom.css` inside the media directory. The compiler will automatically merge and include it.

Next, we have the `linkIndex.yml` which contains a simple list of the markdown filenames (without the extension). The order of these files determine the order they appear in the sidebar.

```yaml
# The sidebar will be arranged according to the order of the slugs in the list.
# Indentation matters. Each entry must start with 2 spaces,
# followed by a dash, and then another space, then the slug.
Links:
  - index            # this gets index 0 
  - getting-started  # this gets index 1
  - digging-deeper   # this gets index 2
```
Note that the index file is normally hidden from the sidebar as it is accessed by the brand name. The 404 page is also hidden.
Files that don't have an entry in the index gets the order 999.

### Visiting the preview
The package comes with a real-time viewer of the pages. You can see it at `http://localhost:8000/realtime-docs/`.

### Creating new pages
Creating new pages is dead simple. You simply create a markdown file in the resources/docs directory.
There are some conventions you must follow though. All files should be in lowercase kebab-case and end in .md.

> All documentation sites should include an index.md and a 404.md file. When you publish the package assets they are automatically created for you to modify as you wish.

Let's create a page for this document I am writing now.

Simply create a file named `getting-started.md`
```bash
# I'm using Nano but you can use any text editor you'd like
nano resources/docs/getting-started.md
```

After you've written down some markdown, save the file `Ctrl+O`, `enter`, `Ctrl+X` (if using Nano) and hit refresh on the webpage. You should now see that a new entry has been created in the sidebar
Click on the link, and you should now see your beautifully formatted Markdown!
![Screenshot of the rendered Markdown page](https://cdn.desilva.se/static/media/screenshots/gssh2.png)

### Adding images
Adding images is easy, just put them in the resources/docs/media directory, reference them using the following code
```markdown
![Example Image](media/example-image.jpg "Image by Picjumbo.com")
```
When the static site is built the images will be copied automatically. When using the realtime viewer, the image markdown is intercepted by the preprocessor and changes the path to a resource route. 

> You can of course also use an external CDN to host the images by entering the full URI instead of the relative filepath. The screenshot above uses this method.

### Generating the static site
This package is intended to be used to generate static HTML so it can be hosted on services such as GitHub pages.

Compiling the site is a breeze.

Just run
```bash
php artisan laradocgen:build
```
and the files will be saved in `public/docs`. You can keep it there to automatically serve them from the /docs route. You can also upload them to your static site host.

If you feel done with the documentation package you can safely remove it.



## Summary
Simply put, the steps to create your documentation is as follows
- Install the composer package as a dev dependency and publish the assets.
- Create your markdown files in `resources/docs`. The files must be in kebab-case and end in .md.
- You can create a simple YAML list named linkIndex.yml to change the order the files appear in the sidebar.
- Store images in `resources/docs/media`.
- You can preview the pages with the route `/realtime-docs`.
- Compile into static HTML using the artisan command `php artisan laradocgen:build`. The files are stored in `public/docs`.
- That's it!

## Next steps

### Torchlight
The package comes with out of the box support for Torchlight. To get started run
```bash
php artisan torchlight:install # Run the installation command

php artisan vendor:publish --tag="config" # Publish the configs
```

Next, create an account at Torchlight.dev, generate an API token, and enter the token in your project .env file
```env
TORCHLIGHT_TOKEN=torch_ # Replace with your token
```

And enable the feature in the `config/laradocgen.php`

<small class="filepath" title="Filepath relative to your Laravel installation">config/laradocgen.php</small>

[!!filepath]::config/laradocgen.php

```php
<?php
return [
    /** Should Torchlight be used? Default: false */
    'useTorchlight' => true, # Set this to true // [tl! highlight]
];
```