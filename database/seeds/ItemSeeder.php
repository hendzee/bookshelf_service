<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        for ($i=0; $i<20; $i++) {
            DB::table('items')->insert([
                'user_id' => rand(1, 5),
                'category_id' => rand(1, 5),
                'title' => $faker->firstName . ' Biography',
                'author' => $faker->firstName . ' ' . $faker->lastName,
                'publish_date' => '2020-03-01',
                'cover' => 'Cover.jpg'
            ]);
        }
    }
}
