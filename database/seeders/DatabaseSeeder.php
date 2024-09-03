<?php

namespace Database\Seeders;

use App\Models\Calendar\Status;
use Illuminate\Database\Seeder;
use App\Models\Calendar\Event;
use App\Models\Calendar\Type;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    protected const EVENT_TYPES = ['General', 'Event', 'Meeting', 'Conference', 'Reminder'];

    protected const EVENT_STATUSES = ['Postponed', 'Pended', 'Finished', 'Waiting', 'Pause'];

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        foreach (self::EVENT_TYPES as $type) {
            Type::create([
                'name' => $type
            ]);
        }

        foreach (self::EVENT_STATUSES as $status) {
            Status::create([
                'name' => $status
            ]);
        }

        $events = Event::factory(10)->create();

        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        foreach ($events as $event) {
            $event->user()->attach($user->id);
        }
    }
}
