<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Department;
use App\Models\Event;
use App\Models\Venue;
use App\Models\Speaker;
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
        return [
            'name' => $this->faker->randomElement(['Senior Highschool Graduation', 'Semester Orientation', 'Coding Workshop', 'Career Conference', 'Sports Day', 'Art Exhibition', 'Science Fair', 'Music Festival']),
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
            'start_date' => $start_date = $this->faker->dateTimeBetween('now', '+2 years')->setTime(
                $this->faker->numberBetween(8, 20), 0, 0
            ),
            'end_date' => $this->faker->dateTimeInInterval($start_date, '+2 hours'),
            'image' => 'https://unsplash.it/640/480?random=' . Str::random(10),
            'status' => $this->faker->randomElement(['Archived', 'Upcoming', 'Ongoing', 'Completed']),
        ];
    }
}
