# Why not use orchestra or PHPUnit directly?
## Because I for the life of me get it to work. I'd love to get some help with this.

## For now, run tests in this Laravel installation the same way you would test an actual Laravel app.

### When running tests on your local package repo you need to move the laravel directory out of the package root as Composer does not support recursive repositories. Remember to update the tests/laravel/composer.json with the new repository. 