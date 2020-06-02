<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        $pass = 'PASSWORD123';
        $photo = 'Photo.jpg';
        $rating = 5;

        for ($i=0; $i<50; $i++) {
            DB::table('users')->insert([
                'email' => $faker->email,
                'phone' => $faker->phoneNumber,
                'password' => $pass,
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'photo' => $photo,
                'rating' => $rating
            ]);
        }
    }
}
