<?php

namespace App\Console\Modules;

use App\Console\Base;
use App\Console\IBase;
use App\Enums\ReviewTypesEnum;
use App\Models\Review;
use App\Wrappers\Env;
use Faker\Generator;

/**
 * DB Seeder for testing.
 */
class SeederModule extends Base implements IBase
{
    private const int NUM_PROFANITIES = 10;

    /**
     * @link http://localhost:8000/redirect?target=ce4ca780-b501-45b7-9443-5c5acd4cacd3&type=0
     */
    private const string DEFAULT_TEACHER = 'ce4ca780-b501-45b7-9443-5c5acd4cacd3';

    /**
     * @link http://localhost:8000/redirect?target=5389;55683&type=1
     */
    private const string DEFAULT_SUBJECT = '5389;55683';

    private Generator $faker;
    private array $profanities;

    public function __construct(\League\CLImate\CLImate $cli)
    {
        parent::__construct($cli);
        $this->faker = \Faker\Factory::create();
        $this->profanities = include __DIR__ . '/../../../misc/profanities.php';
    }

    /**
     * {@inheritdoc}
     */
    public function entrypoint(): void
    {
        $this->cli->bold()->out('Seeder');
        if (!Env::app_debug()) {
            $this->cli->backgroundRed()->error('This command only runs on debug mode.');
            return;
        }

        $review_teacher = new Review([
            'target' => self::DEFAULT_TEACHER,
            'username' => $this->faker->optional()->userName(),
            'note' => $this->faker->numberBetween(0, 10),
            'message' => $this->faker->text(200),
            'votes' => $this->faker->numberBetween(0, 100),
            'type' => ReviewTypesEnum::TEACHER,
        ]);
        $review_teacher->save();

        $review_subject = new Review([
            'target' => self::DEFAULT_SUBJECT,
            'username' => $this->faker->optional()->userName(),
            'note' => $this->faker->numberBetween(0, 10),
            'message' => $this->faker->text(200),
            'votes' => $this->faker->numberBetween(0, 100),
            'type' => ReviewTypesEnum::SUBJECT,
        ]);
        $review_subject->save();

        $this->cli->backgroundGreen()->out('Done!');
    }
}
