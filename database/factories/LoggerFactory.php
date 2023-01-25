<?php

namespace Database\Factories;

use App\Models\Logger;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Logger>
 */
class LoggerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Logger::class;

    public function definition()
    {
        return[
            'user_id' => User::where('name', 'admin2')->first()->id,
            'ip' => $this->faker->name,
            'country' => $this->faker->name,
            'city' => $this->faker->name,
            'browser' => $this->faker->name,
            'browser_version' => $this->faker->name,
            'platform' => $this->faker->name,
            'platform_version' => $this->faker->name,
            'agent' => $this->faker->name,
            'host' => $this->faker->name,
        ];
    }
}
