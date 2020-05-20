<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request) {
        $category = Category::all();

        return $category;
    }

    /** Store data */
    public function store(Request $request) {
        $category = new Category;

        $category->lable = $request->lable;
        $category->save();

        return $category;
    }

    /** Update data */
    public function update(Request $request, $id) {
        $category = Category::find($id);

        $category->lable = $request->lable;
        $category->save();

        return $category;
    }

    /** Destroy data */
    public function destroy($id) {
        Category::destroy($id);

        return $id;
    }
}