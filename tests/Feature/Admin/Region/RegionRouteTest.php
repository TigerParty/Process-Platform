<?php

namespace Tests\Feature\Admin\Region;

use App\Models\Region;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegionRouteTest extends TestCase
{
    private $region;

    private $regionPayload;

    public function setUp()
    {
        parent::setUp();

        $this->region = Region::find(1);
        $this->regionPayload = [
            "name" => "TestRegion",
            "parent_id" => null
         ];
    }

    public function testIndex()
    {
        $response = $this->actingAs($this->admin)
                         ->get('admin/location');

        $response->assertSuccessful();
    }

    public function testIndexApi()
    {
        $response = $this->actingAs($this->admin)
                         ->getJson('api/admin/location');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                    'regions'
                 ]);
    }

    public function testStoreApi()
    {
        $response = $this->actingAs($this->admin)
                         ->postJson('api/admin/location', $this->regionPayload);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                    'id',
                    'name',
                    'parent_id',
                    'regions'
                 ]);
    }

    public function testUpdateApi()
    {
        $response = $this->actingAs($this->admin)
                         ->putJson('api/admin/location/'.$this->region->id, $this->regionPayload);

        $response->assertStatus(200)
                     ->assertJsonStructure([
                        'id',
                        'name',
                        'parent_id',
                        'regions'
                     ]);
    }

    public function testDeleteApi()
    {
        $response = $this->actingAs($this->admin)
                         ->deleteJson('api/admin/location/'.$this->region->id);

        $response->assertStatus(200);
        $this->assertTrue($response->json());
    }
}
