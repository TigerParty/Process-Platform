<?php

namespace Tests\Feature\Admin\Region;

use App\Models\Region;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegionRouteGuestTest extends TestCase
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
        $response = $this->get('admin/location');

        $response->assertStatus(302);
    }

    public function testIndexApi()
    {
        $response = $this->getJson('api/admin/location');

        $response->assertStatus(401);
    }

    public function testStoreApi()
    {
        $response = $this->postJson('api/admin/location', $this->regionPayload);

        $response->assertStatus(401);
    }

    public function testUpdateApi()
    {
        $response = $this->putJson('api/admin/location/'.$this->region->id, $this->regionPayload);

        $response->assertStatus(401);
    }

    public function testDeleteApi()
    {
        $response = $this->deleteJson('api/admin/location/'.$this->region->id);

        $response->assertStatus(401);
    }
}
