<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use MongoDB\BSON\UTCDateTime;
use Illuminate\Support\Facades\DB;

class ShoppingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();
        $categories = ['Fashion', 'Electronics', 'Home', 'Beauty'];
        $subcategories = ['Men', 'Women', 'Mobiles', 'Laptops', 'Furniture', 'Skincare'];

        $batchSize = 1000;
        $total = 10000;

        for ($i = 0; $i < $total; $i += $batchSize) {
            $batch = [];

            for ($j = 0; $j < $batchSize; $j++) {
                $createdAt = $faker->dateTimeBetween('-1 year', 'now');

                $batch[] = [
                    'title' => $faker->sentence(4),
                    'name' => $faker->word,
                    'media' => $faker->imageUrl(),
                    'linkurl' => $faker->url,
                    'addedby' => rand(1, 10),
                    'updatedby' => rand(1, 10),
                    'author' => $faker->name,
                    'createdate' => new UTCDateTime($createdAt),
                    'short_description' => $faker->text(100),
                    'long_description' => $faker->text(300),
                    'isdelete' => false,
                    'category' => $faker->randomElement($categories),
                    'subcatetgory' => $faker->randomElement($subcategories),
                    'created_at' => new UTCDateTime($createdAt),
                    'updated_at' => new UTCDateTime(),
                ];
            }

            DB::table('shopping')->insert($batch);
        }
    }
}
