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
        $saveData = [];

        array_push($saveData, 'FABLE');
        array_push($saveData, 'HORROR');
        array_push($saveData, 'ROMANCE');
        array_push($saveData, 'FANTASY');
        array_push($saveData, 'SAINS');
        array_push($saveData, 'ECONOMY');
        array_push($saveData, 'FICTION');
        array_push($saveData, 'OTHER');

        $category->saveMany($saveData);
    }
}
