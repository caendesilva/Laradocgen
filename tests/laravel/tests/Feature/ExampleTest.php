<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_the_server_is_live()
    {
        $url = "http://127.0.0.1:8000";
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        
        $resp = curl_exec($curl);
        curl_close($curl);
        
        $code = (curl_getinfo($curl)['http_code']);
         
        $this->assertEquals(200, $code, 'Is the webserver down?');
    }
}
