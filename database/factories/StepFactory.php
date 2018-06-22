<?php

use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(App\Models\Step::class, function (Faker $faker) {
	// $regions = \DB::table('regions')->select('id')->whereNotNull('parent_id')->get()->toArray();
	// array_push($regions, null);
	// $region = $faker->randomElement($regions);
	// $regionId = $region ? $region->id : null;

    return [
        'name' => $faker->word,
        'activity' => $faker->text(50),
        'description' => $faker->text(100),
        // 'region_id' => $regionId,
        'created_by' => 1,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ];
});
