<?php
/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\MetadataDictionary;
use Faker\Generator as Faker;
use Illuminate\Support\Str;


$factory->define(MetadataDictionary::class, function (Faker $faker) {
    return [
        'vocabulary_id' => Str::random(4),
        'metadata_name' => $faker->name,
        'description' => $faker->sentence,
        'type' => $faker->word,
        'start_date' => date('Y-m-d'),
    ];
});
