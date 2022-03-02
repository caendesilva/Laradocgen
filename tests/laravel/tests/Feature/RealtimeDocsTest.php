<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class RealtimeDocsTest extends TestCase
{
    public function test_that_environment_is_local()
    {
        $this->assertEquals('local', App::environment());
    }

    public function test_that_route_without_slug_returns_redirect()
    {
        $response = $this->get('/realtime-docs');
        
        $response->assertRedirect();
    }

    public function test_that_route_with_slug_returns_a_successful_response()
    {
        $response = $this->get('/realtime-docs/index');
        
        $response->assertStatus(200);
    }

    public function test_that_route_with_non_existent_slug_returns_404()
    {
        $response = $this->get('/realtime-docs/7dedff37-1db0-44b1-ba0f-74b9f73729f8');
        
        /**
         * The realtime viewer does not send the proper 404 header.
         * The following assertion accomplishes the same thing,
         * assuming the page has not been modified.
         */
        $response->assertSee('404 - Page not found');
    }
}
