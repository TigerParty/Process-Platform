<?php

namespace Tests;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\User;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication,
        DatabaseTransactions,
        DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        Artisan::call('db:seed', ['--class' => 'TestDatabaseSeeder']);

        $this->admin = User::find(1);
    }

    public function tearDown()
    {
        $this->beforeApplicationDestroyed(function () {
            \DB::disconnect();
        });

        parent::tearDown();
    }
}
