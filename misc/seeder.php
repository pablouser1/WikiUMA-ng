<?php

use App\Enums\ReviewTypesEnum;
use App\Models\Review;
use App\Wrappers\Profanity;
use Faker\Generator;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../bootstrap.php';

const NUM_PROFANITIES = 10;

$profanities = include __DIR__ . '/profanities.php';
// Seed with test data
$faker = Faker\Factory::create();

function message_with_spice(array $profanities, Generator $faker): string
{
    $txt = $faker->text(200);

    for ($i = 0; $i < NUM_PROFANITIES; $i++) {
        $txt .= ' ' . $profanities[array_rand($profanities)];
    }

    return $txt;
}

// -- Reviews -- //
$review_teacher = new Review([
    'target' => 'ce4ca780-b501-45b7-9443-5c5acd4cacd3',
    'username' => $faker->optional()->userName(),
    'note' => $faker->numberBetween(0, 10),
    'message' => Profanity::filter(message_with_spice($profanities, $faker)),
    'votes' => $faker->numberBetween(0, 100),
    'type' => ReviewTypesEnum::TEACHER,
]);
$review_teacher->save();

$review_subject = new Review([
    'target' => '5389;55683',
    'username' => $faker->optional()->userName(),
    'note' => $faker->numberBetween(0, 10),
    'message' => Profanity::filter(message_with_spice($profanities, $faker)),
    'votes' => $faker->numberBetween(0, 100),
    'type' => ReviewTypesEnum::SUBJECT,
]);
$review_subject->save();
// -- END Reviews -- //
