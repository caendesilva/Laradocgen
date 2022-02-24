# Creating a static documentation site blazingly fast and stupidly simple with Caendesilva/Docgen for Laravel

## Hey! I'm Caen! I created this package to practise package development. It is still very much in beta, but please do send me any feedback you have! I'd love to get some PRs as well.

### Installation guide

#### Speedrun
If you know your way around Laravel you can skip to the [summary](#summary) 

This guide assumes you are familiar with the basics of Laravel and will not go into detail on the installation.
The guide uses Laravel 9.

#### Install Laravel

Let's start by creating a new project. I will be using Composer. If you already have a site you can skip this step.

```bash
composer create-project laravel/laravel docgen-demo
 
cd docgen-demo
 
php artisan serve

# Now you can visit http://localhost:8000/ in your browser to verify the install.
```

#### Install the package

Next, we need to install the Composer package. Since this is a static site generator we don't need it in production, thus we are adding the --dev flag.

```bash
composer require caendesilva/docgen --dev
```

#### Publish the assets

Next, publish the assets using
```bash
php artisan vendor:publish --tag="docgen"
```

Now you can see that some files and folders were created. Here is a quick explanation about what they do

##### About the assets
![Image](media/gssh1.png)

The main folder is in `resources/docs`. This is where we store all the markdown files. As you can see there is currently an `index.md` file. This will be converted into the `index.html`.

We also have a media directory that stores images.

Next, we have the `linkIndex.yml` which contains a simple list of the markdown filenames (without the extension). The order of these files determine the order they appear in the sidebar.

```yaml
# Rearrange the list items below to decide the order of navigation links in the sidebar. Indentation matters. Each entry must start with 2 spaces, followed by a dash, and then another space, then the slug.
Links:
  - index            # this gets index 0 
  - getting-started  # this gets index 1
  - digging-deeper   # this gets index 2
```
Note that the index file is normally hidden from the sidebar as it is accessed by the brand name
Files that don't have an entry in the index gets the order 999.

#### Visiting the preview
The package comes with a real-time viewer of the pages. You can see it at `http://localhost:8000/realtime-docs/`.
> If you add new images you still need to run the build command so they get copied to the public directory.
![Image](media/gssh2.png)

#### Creating new pages
Creating new pages is dead simple. You simply create a markdown file in the resources/docs directory.
There are some conventions you must follow though. All files should be in lowercase kebab-case and end in .md.

Let's create a page for this document I am writing now.

Simply create a file named `getting-started.md`
```bash
# I'm using Nano but you can use any text editor you'd like
nano resources/docs/getting-started.md
```

After you've written down some markdown, save the file `Ctrl+O`, `enter`, `Ctrl+X` (if using Nano) and hit refresh on the webpage. You should now see that a new entry has been created in the sidebar
![Image](media/gssh3.png)
Click on the link, and you should now see your beautifully formatted Markdown!

#### Adding images
Adding images is easy, just put them in the resources/docs/media directory, reference them using the following code
```markdown
![Example Image](media/example-image.jpg "Image by Picjumbo.com")
```
And run the build command

#### Generating the static site
This package is intended to be used to generate static HTML so it can be hosted on services such as GitHub pages.

Compiling the site is a breeze.

Just run
```bash
php artisan docgen:build
```
and the files will be saved in `public/docs`. You can keep it there to automatically serve them from the /docs route. You can also upload them to your static site host.

If you feel done with the documentation package you can safely remove it.



### Summary
Simply put, the steps to create your documentation is as follows
- Install the composer package as a dev dependency and publish the assets.
- Create your markdown files in `resources/docs`. The files must be in kebab-case and end in .md.
- You can create a simple YAML list named linkIndex.yml to change the order the files appear in the sidebar.
- Store images in `resources/docs/media`.
- You can preview the pages with the route `/realtime-docs`.
- Compile into static HTML using the artisan command `php artisan docgen:build`. The files are stored in `public/docs`.
- That's it!

### Next steps

#### Torchlight
The package comes with out of the box support for Torchlight. To get started run
```bash
#
php artisan torchlight:install # Run the installation command

php artisan vendor:publish --tag="config" # Publish the configs
```

Next, create an account at Torchlight.dev, generate an API token, and enter the token in your project .env file
```env
TORCHLIGHT_TOKEN=torch_ # Replace with your token
```

And enable the feature in the config/docgen.php
```php
<?php

/*
 * Docgen Configuration
 */
return [
    /**
     * Should Torchlight be used?
     * 
     * Default: false
     * 
     * @see https://torchlight.dev/docs
     * 
     * Remember to add your API token in your .env file
     */
    'useTorchlight' => true, # Set this to true // [tl! **]
];
```