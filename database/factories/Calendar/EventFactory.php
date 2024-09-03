<?php

namespace Database\Factories\Calendar;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Calendar\Status;
use App\Models\Calendar\Type;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Calendar\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = Type::all(['id'])->toArray();
        $statuses = Status::all(['id'])->toArray();

        return [
            'title' => fake()->sentence(5, true),
            'start' => fake()->time('H:i'),
            'duration' => $this->getDuration(),
            'type_id' => fake()->randomElement($types)['id'],
            'status_id' => fake()->randomElement($statuses)['id'],
            'description' => fake()->paragraph(2, true),
            'date' => fake()->dateTimeThisMonth()
        ];
    }


    public function getDuration()
    {
        // Minimal duration (15 minutes in seconds)
        $minDuration = 15 * 60;

        // Maximal duration (4 hours in seconds)
        $maxDuration = 4 * 60 * 60;

        // Get random duration in seconds
        $randomDurationInSeconds = rand($minDuration, $maxDuration);

        // Get duration in Hour:minutes format
        return Carbon::now()->startOfDay()->addSeconds($randomDurationInSeconds)->format('H:i');
    }
}
