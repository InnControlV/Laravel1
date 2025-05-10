<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
class NewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $locations = ['Delhi', 'Mumbai', 'Kolkata', 'Chennai', 'Bangalore'];
        $referFrom = ['Inshorts', 'Newsify'];
        $languages = ['Hindi', 'English'];
        $now = Carbon::now();

        $data = [];

        for ($i = 1; $i <= 10000; $i++) {
            $lang = $i <= 5000 ? 'Hindi' : 'English';
            $location = $locations[array_rand($locations)];

            $data[] = [
                'category' => Str::random(10),
                'title' => 'Sample News Title ' . $i,
                'image' => 'https://via.placeholder.com/150',
                'short_description' => Str::random(50),
                'details' => Str::random(200),
                'date' => $now->format('Y-m-d'),
                'time' => $now->format('H:i:s'),
                'refer_from' => $referFrom[array_rand($referFrom)],
                'language' => $lang,
                'location' => $location,
                'added_by' => 'Seeder',
                'updated_by' => 'Seeder',
                'link' => 'https://example.com/news/' . $i,
                'favourite' => rand(0, 1),
                'created_at' => $now,
                'updated_at' => $now,
            ];

            // Insert in chunks of 500 for performance
            if ($i % 500 === 0) {
                DB::table('news')->insert($data);
                $data = [];
            }
        }

        // Insert remaining data
        if (!empty($data)) {
            DB::table('news')->insert($data);
        }
    }
}




