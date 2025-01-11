<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Department;
use App\Models\Event;
use App\Models\Venue;
use App\Models\Speaker;
use Carbon\Carbon;

class EventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Event::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        // Adjust status weights to favor upcoming events
        $status = $this->faker->randomElement([
            'Upcoming',
            'Upcoming',
            'Upcoming',
            'Ongoing',
            'Completed',
            'Upcoming',
            'Upcoming',
            'Upcoming',
            'Upcoming'
        ]);

        // Adjust date ranges
        switch ($status) {
            case 'Completed':
                $startDate = $this->faker->dateTimeBetween('-2 months', '-1 day'); // Past events
                break;
            case 'Ongoing':
                $startDate = $this->faker->dateTimeBetween('-1 day', 'now');
                break;
            case 'Upcoming':
            default:
                $startDate = $this->faker->dateTimeBetween('+1 day', '+3 months'); // Next 3 months
                break;
        }

        $startTime = $this->faker->dateTimeBetween('08:00', '20:00')->format('H:i:s');
        $endTime = (new \DateTime($startTime))->add(new \DateInterval('PT' . $this->faker->numberBetween(1, 3) . 'H'))->format('H:i:s');

        return [
            'name' => $this->faker->randomElement([
                'Senior Highschool Graduation',
                'Semester Orientation',
                'Coding Workshop',
                'Career Conference',
                'Sports Day',
                'Art Exhibition',
                'Science Fair',
                'Music Festival'
            ]),
            'description' => $this->faker->randomElement([
                "The annual cultural festival brings together students from various departments, filling the campus courtyard with vibrant booths showcasing art, music, and traditional cuisine.",
                "The auditorium buzzes with excitement as students gather for the highly anticipated guest lecture, with rows of chairs neatly arranged in front of the large projection screen.",
                "The charity marathon kicks off early in the morning, with participants warming up along the campus pathways, marked by colorful banners and hydration stations.",
                "The outdoor concert on the central lawn features local bands, with students lounging on blankets under string lights, enjoying the cool evening breeze.",
                "The science fair displays innovative student projects, with each booth equipped with detailed posters and interactive demos, attracting curious visitors throughout the day.",
                "The annual sports day features a variety of athletic events, with students cheering from the sidelines and vendors selling refreshments.",
                "The art exhibition showcases student artwork, with each piece displayed in a designated area, attracting art enthusiasts and potential buyers.",
                "The music festival features local and international bands, with students dancing in the aisles, enjoying the diverse music lineup.",
            ]),
            'start_date' => $startDate->format('d-m-Y'),
            'end_date' => $startDate->format('d-m-Y'),
            'start_time' => $startTime,
            'end_time' => $endTime,
            'image' => 'https://picsum.photos/seed/' . Str::uuid() . '/640/480',
            'status' => $status,
            'speaker_id' => function () {
                return Speaker::query()->inRandomOrder()->first()?->id
                    ?? Speaker::factory()->create()->id;
            },
        ];
    }
}