<?php

namespace Tests\Feature\Frontend\Process;

use App\Models\Process;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProcessRouteTest extends TestCase
{
    private $process;

    public function setUp()
    {
        parent::setUp();

        $this->process = Process::find(1);
    }

    public function testIndexApi()
    {
        $response = $this->getJson('api/process');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                    "processes"
                 ]);
    }

    public function testShowApi()
    {
        $response = $this->getJson('api/process/'.$this->process->id);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                    "process",
                    "regions"
                 ]);
    }
}
