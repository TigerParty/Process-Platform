<?php

use Illuminate\Database\Seeder;

use App\Models\RegionLabel;

class RegionLabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$regionLabels = [
    		['name' => 'provice', 'order' => 0],
        	['name' => 'district', 'order' => 1]
    	];

        \DB::table('region_label')->insert($regionLabels);
    }
}
