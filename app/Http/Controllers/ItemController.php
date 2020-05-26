<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /** Get data */
    public function index(Request $request) {
        $item = Item::all();

        /** Include user data */
        if ($request->has('user')) {
            $item = Item::with('user')->get();
        }

        return $item;
    }

    /** Show specific data */
    public function show($id) {
        $item = Item::find($id);

        return $item;
    }

    /** Store data */
    public function store(Request $request) {
        $item = new Item;

        $item->user_id = $request->user_id;
        $item->category_id = $request->category_id;
        $item->title = $request->title;
        $item->author = $request->author;
        $item->publish_date = $request->publish_date;
        $item->cover = $request->cover;
        $item->save();

        return $request;
    }

    /** Update data */
    public function update(Request $request, $id) {
        $item = Item::find($id);

        $item->user_id = $request->user_id;
        $item->category_id = $request->category_id;
        $item->title = $request->title;
        $item->author = $request->author;
        $item->publish_date = $request->publish_date;
        $item->cover = $request->cover;
        $item->save();

        return $request;
    }

    public function destroy($id) {
        Item::destroy($id);

        return $id;
    }
}
