<?php

namespace Tests\Feature;

use App\Actions\ResetOutputFiles;
use DeSilva\Laradocgen\Laradocgen;
use Tests\TestCase;

/**
 * Test the static site builder.
 */
class StaticSiteBuilderTest extends TestCase
{
    /**
     * The ResourceTest may need to run before this test
     * as the build will fail if there are no files to build from.
     */
    public function test_that_resource_directory_exist()
    {
        $this->assertDirectoryExists(Laradocgen::getSourcePath());
    }

    /**
     * Reset the output directory.
     */
    public function test_that_output_directory_is_empty()
    {
        out("Preparing for static site builder test.", true);
        new ResetOutputFiles;

        $this->assertDirectoryDoesNotExist(Laradocgen::getBuildPath());
    }

    public function test_that_build_command_runs()
    {
        $this->artisan('laradocgen:build')
            ->assertSuccessful();
    }

    public function test_that_output_directory_exist()
    {
        $this->assertDirectoryExists(Laradocgen::getBuildPath());
    }

    
    public function test_that_static_site_index_file_exists()
    {
        $this->assertFileExists(Laradocgen::getBuildFilepath('index.html'));
        
        // Check that the file has more than 64 bytes.
        // Here 64 is just an arbitrary number that should fail the assertion
        // if the file is "practically empty" such as only having a newline or similar.
        $this->assertGreaterThan(64, filesize(Laradocgen::getBuildFilepath('index.html')));
    }

    public function test_that_static_site_index_file_has_contents()
    {
        $this->assertTrue(
            str_contains(
                file_get_contents(Laradocgen::getBuildFilepath('index.html')),
                '<!DOCTYPE html>'
            )
        );
    }

}
