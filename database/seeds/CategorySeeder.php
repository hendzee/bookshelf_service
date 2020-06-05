<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $saveData = [
            'FABLE', 
            'HORROR', 
            'ROMANCE', 
            'FANTASY', 
            'SAINS', 
            'ECONOMY', 
            'FICTION', 
            'OTHER'
        ];

        for ($i=0; $i<count($saveData); $i++) {
            DB::table('categories')->insert([
                'lable' => $saveData[$i]
            ]);
        }
    }
}
