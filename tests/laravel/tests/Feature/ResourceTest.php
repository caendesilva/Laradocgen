<?php

namespace Tests\Feature;

use App\Actions\ResetResourceFiles;
use DeSilva\Laradocgen\Laradocgen;
use Tests\TestCase;

/**
 * Tests relating to the creation, reading, and modification
 * of resource files such as source markdown content and stylesheets.
 * 
 * It also tests the realtime views.
 */
class ResourceTest extends TestCase
{
    /**
     * Reset the resource files.
     */
    public function test_that_resource_files_have_been_removed()
    {
        out("Preparing for resource test.", true);
        new ResetResourceFiles;
        $this->assertDirectoryDoesNotExist(Laradocgen::getSourcePath());
    }

    public function test_that_required_file_exception_is_thrown_when_using_build_command()
    {
        $this->artisan('laradocgen:build')
            ->expectsOutput('Error: Required files index.md, 404.md, linkIndex.yml, media/app.css, media/app.js could not be found. Did you publish the assets?')
            ->assertFailed();
    }
    
    public function test_that_required_file_exception_is_thrown_when_visiting_the_site()
    {
        $response = $this->get('/realtime-docs/index');
        $response->assertStatus(500);
    }

    public function test_that_files_are_published_using_vendor_publish_command()
    {
        $this->artisan('vendor:publish --tag="laradocgen"')
            ->expectsOutput('Publishing complete.')
            ->assertSuccessful();
    }

    public function test_that_resource_directory_exist()
    {
        $this->assertDirectoryExists(Laradocgen::getSourcePath());
    }

    public function test_that_visiting_site_after_publishing_assets_returns_successful_response()
    {
        $response = $this->get('/realtime-docs/index');
        $response->assertStatus(200);
    }
}
