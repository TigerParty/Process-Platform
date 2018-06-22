<?php

use Faker\Generator as Faker;
use Carbon\Carbon;

use App\Models\Step;

$factory->define(App\Models\Attachment::class, function (Faker $faker) {
	$steps = Step::all(['id'])->toArray();

    $filename = $faker->uuid .'.'. $faker->fileExtension;
    $sha1 = sha1($filename);
    $path = substr($sha1, 0, 2) . '/' . $sha1;

    return [
        'name' => $filename,
        'path' => $path,
        'type' => $faker->mimeType,
        'attachable_id' => $faker->randomElement($steps)['id'],
        'attachable_type' => Step::class,
        'description' => $faker->text(50),
        'created_by' => 1,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
    ];
});
