<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $locations = ['Delhi', 'Mumbai', 'Bangalore', 'Chennai', 'Kolkata'];
        $languages = ['Hindi', 'English', 'Tamil', 'Telugu', 'Kannada'];
        $referSources = ['BookMyShow', 'District', 'LocalCinema'];
        $types = ['Action', 'Drama', 'Comedy', 'Romance', 'Thriller'];

        $data = [];

        for ($i = 0; $i < 10000; $i++) {
            $location = $locations[array_rand($locations)];
            $language = $languages[array_rand($languages)];
            $refer = $referSources[array_rand($referSources)];
            $type = $types[array_rand($types)];

            $data[] = [
                'title' => 'Movie ' . Str::random(10),
                'location' => $location,
                'release_date' => Carbon::now()->subDays(rand(0, 365))->toDateString(),
                'language' => $language,
                'refer_from' => $refer,
                'rating' => rand(1, 10),
                'author' => 'Author ' . rand(1, 50),
                'added_by' => rand(1, 5),
                'updated_by' => rand(1, 5),
                'description' => Str::random(100),
                'type' => $type,
                'url' => 'https://example.com/' . Str::slug(Str::random(10)),
                'image' => 'https://via.placeholder.com/300',
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Insert in batches of 500 to avoid memory issues
            if (count($data) === 500) {
                DB::table('movies')->insert($data);
                $data = [];
            }
        }

        // Insert remaining data
        if (!empty($data)) {
            DB::table('movies')->insert($data);
        }
    }
}
