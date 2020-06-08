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
        $covers = [
            'item_photo1.jpeg',
            'item_photo2.jpeg',
            'item_photo3.jpeg',
            'item_photo4.jpeg',
            'item_photo5.jpeg',
        ];

        $categories = [
            'FABLE', 
            'HORROR', 
            'ROMANCE', 
            'FANTASY', 
            'SAINS', 
            'ECONOMY', 
            'FICTION', 
            'OTHER'
        ];

        $endpoint = 'http://192.168.1.13/bookshelf_service/storage/app/images/';

        for ($i=0; $i<20; $i++) {
            $cover = $covers[rand(0, 4)];

            DB::table('items')->insert([
                'user_id' => rand(1, 5),
                'category' => $categories[rand(0, 7)],
                'title' => $faker->firstName . ' Biography',
                'author' => $faker->firstName . ' ' . $faker->lastName,
                'publish_date' => '2020-03-01',
                'cover' => $endpoint . $cover
            ]);
        }
    }
}
