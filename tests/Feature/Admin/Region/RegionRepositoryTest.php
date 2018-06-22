<?php

namespace Tests\Feature\Admin\Region;

use App\Models\Region;
use App\Repositories\RegionRepository;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegionRepositoryTest extends TestCase
{
    private $region;

    private $regionPayload;

    private $regionRepository;

    public function setUp()
    {
        parent::setUp();

        $this->region = Region::find(1);
        $this->regionRepository = new RegionRepository;
    }

    public function testGetDropDownList()
    {
        $regions = $this->regionRepository->getDropDownList();

        $this->assertTrue(array_has($regions[0], 'regions'));
        $this->assertNotEquals(count($regions), 0);
    }

    public function testGetRegions()
    {
        $regions = $this->regionRepository->getRegions();

        $this->assertTrue(array_has($regions[0], 'regions'));
        $this->assertNotEquals(count($regions), 0);
    }

    public function testStore()
    {
        $region = $this->regionRepository->store([
            'name' => 'RegionTestStore',
            'parent_id' => 0
        ]);

        $this->assertInstanceOf(Region::class, $region);
    }

    public function testUpdate()
    {
        $region = $this->regionRepository->update(1, [
            'name' => 'RegionTestUpdate',
            'parent_id' => 0
        ]);

        $this->assertInstanceOf(Region::class, $region);
    }
}
