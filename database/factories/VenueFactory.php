<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Venue;
use App\Models\VenueImage;

class VenueFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Venue::class;

    protected $venueData = [
        [
            'name' => 'Carthage Activity Center',
            'location' => 'LCUP Main Campus',
            'capacity' => 100,
            'description' => "The Carthage Activity Center is a historic building that serves as the hub for various university activities and events.",
            'images' => [
                'images/venues/1/activity-center-1.jpg',
                'images/venues/1/activity-center-2.jpg',
                'images/venues/1/activity-center-3.jpg',
                'images/venues/1/activity-center-4.jpg',
            ]
        ],
        [
            'name' => 'BARCIE Atis Hall',
            'location' => 'LCUP Main Campus',
            'capacity' => 500,
            'description' => "The BARCIE Atis Hall is a modern building that serves as the main venue for university events and ceremonies.",
            'images' => [
                'images/venues/2/atis-hall-1.jpg',
                'images/venues/2/atis-hall-2.jpg',
                'images/venues/2/atis-hall-3.jpg',
            ]
        ],
        [
            'name' => 'BARCIE Rambutan Hall',
            'location' => 'LCUP Main Campus',
            'capacity' => 100,
            'description' => "The BARCIE Rambutan Hall is a historic building that serves as the hub for various university activities and events.",
            'images' => [
                'images/venues/3/rambutan-hall-1.jpg',
                'images/venues/3/rambutan-hall-2.jpg',
                'images/venues/3/rambutan-hall-3.jpg',
                'images/venues/3/rambutan-hall-4.jpg',
            ]
        ],
        [
            'name' => 'Cassiciacum',
            'location' => 'LCUP Main Campus',
            'capacity' => 200,
            'description' => "Cassiciacum is a modern building that serves as the main venue for university events and ceremonies.",
            'images' => [
                'images/venues/4/cassiciacum-1.jpg',
                'images/venues/4/cassiciacum-2.jpg',
                'images/venues/4/cassiciacum-3.jpg',
                'images/venues/4/cassiciacum-4.jpg',
            ]
        ],
        [
            'name' => 'Computer AVR',
            'location' => 'LCUP Main Campus',
            'capacity' => 20,
            'description' => "The Computer AVR is a modern building that serves as the main venue for university events and ceremonies.",
            'images' => [
                'images/venues/5/avr-1.jpg',
            ]
        ],
        [
            'name' => 'Kalinangan Auditorium',
            'location' => 'LCUP Main Campus',
            'capacity' => 800,
            'description' => "The Kalinangan Auditorium is a modern building that serves as the main venue for university events and ceremonies.",
            'images' => [
                'images/venues/6/kalinangan-1.jpg',
                'images/venues/6/kalinangan-2.jpg',
                'images/venues/6/kalinangan-3.jpg',
                'images/venues/6/kalinangan-4.jpg',
            ]
        ],
        [
            'name' => 'Mother Rita Hall',
            'location' => 'LCUP Main Campus',
            'capacity' => 40,
            'description' => "The Mother Rita Hall is a modern building that serves as the main venue for university events and ceremonies.",
            'images' => [
                'images/venues/7/mother-rita-1.jpg',
                'images/venues/7/mother-rita-2.jpg',
                'images/venues/7/mother-rita-3.jpg',
                'images/venues/7/mother-rita-4.jpg',
            ]
        ],
        [
            'name' => 'Open Stage',
            'location' => 'LCUP Main Campus',
            'capacity' => 900,
            'description' => "The Open Stage is a modern building that serves as the main venue for university events and ceremonies.",
            'images' => [
                'images/venues/8/open-stage-1.jpg',
                'images/venues/8/open-stage-2.jpg',
                'images/venues/8/open-stage-3.jpg',
            ]
        ],
        [
            'name' => 'St. Agustin AVR',
            'location' => 'LCUP Main Campus',
            'capacity' => 100,
            'description' => "The St. Agustin AVR is a modern building that serves as the main venue for university events and ceremonies.",
            'images' => [
                'images/venues/9/st-agustin-1.jpg',
                'images/venues/9/st-agustin-2.jpg',
                'images/venues/9/st-agustin-3.jpg',
            ]
        ]
    ];

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        // Get a random venue data set
        $venueData = array_shift($this->venueData);

        return [
            'name' => $venueData['name'],
            'location' => $venueData['location'],
            'capacity' => $venueData['capacity'],
            'description' => $venueData['description'],
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Venue $venue) {
            // Find the venue data that matches this venue's name
            $venueData = collect($this->venueData)
                ->firstWhere('name', $venue->name);

            // Create primary image
            VenueImage::factory()
                ->primary()
                ->create([
                    'venue_id' => $venue->id,
                    'path' => $venueData['images'][0] ?? "default/noimage.jpg",
                ]);

            // Create additional images
            foreach (array_slice($venueData['images'], 1) as $index => $path) {
                VenueImage::factory()
                    ->create([
                        'venue_id' => $venue->id,
                        'path' => $path,
                        'sort_order' => $index + 1
                    ]);
            }
        });
    }
}
