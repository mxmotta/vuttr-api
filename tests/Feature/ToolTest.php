<?php

namespace Tests\Feature;

use App\Models\Tool;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\ApiTestCase;
use Tests\TestCase;

class ToolTest extends ApiTestCase
{
    protected $last_id;
    
    public function test_add()
    {
        Storage::fake('tools');

        $response = $this->post('/tools', 
            Tool::factory(1)->hasTags(5)->makeOne()->toArray()
        );
        
        $this->last_id = $response->json()['data']['id'];

        $response->assertStatus(201);
    }

    public function test_list()
    {
        Storage::fake('tools');
        $response = $this->get('/tools');
        
        $response->assertStatus(200);
    }

    public function test_get()
    {
        Storage::fake('tools');
        $response = $this->get('/tools/'.$this->last_id);
        
        $response->assertStatus(200);
    }
}
