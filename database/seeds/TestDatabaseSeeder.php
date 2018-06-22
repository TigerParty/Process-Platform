<?php

use Illuminate\Database\Seeder;

class TestDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            TestSeeder\UserSeeder::class,
            TestSeeder\RegionSeeder::class,
            TestSeeder\ProcessSeeder::class,
            TestSeeder\StepSeeder::class,
        ]);
    }
}
