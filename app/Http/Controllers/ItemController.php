<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /** Get data */
    public function index(Request $request) {
        $item = Item::all();

        /** Get data by specific condition or parameter */
        if ($request->has('user')) {
            $item = Item::orderBy('id', 'DESC')->with('user')->paginate(6);
        }elseif($request->has('user_specific')) {
            $item = Item::where('user_id', $request->user_id)
                ->orderBy('id', 'DESC')
                ->with('user')
                ->paginate(6);
        }elseif($request->has('latest')){
            $item = Item::orderBy('id', 'DESC')->with('user')->skip(0)->take(3)->get();
        }elseif($request->has('recomendation')){
            $item = Item::orderBy('id', 'DESC')->with('user')->skip(0)->take(1)->first();
        }elseif($request->has('random')){
            $item = Item::orderBy('id', 'DESC')->with('user')->skip(0)->take(1)->first();
        }elseif($request->has('search')) {
            $item = Item::where('title', 'like', '%' . $request->search . '%')
                ->orWhere('category', 'like', '%' . $request->search . '%')
                ->skip(0)
                ->take(10)
                ->get();
        }elseif($request->has('search_detail')) {
            $orderBy = 'title';
            $ASC = 'asc';
            
            if (strcmp($request->order_by, 'ORDER_BY_DATE') == 0 ) {
                $orderBy = 'publish_date';
            }
            
            if (strcmp($request->asc, 'DESC')) {
                $ASC = 'desc';
            }

            $item = Item::where('title', 'like', '%' . $request->search_detail . '%')
                ->orderBy($orderBy, $ASC)
                ->with('user')
                ->paginate(6);
        }elseif($request->has('search_with_user')){
            $item = Item::where('user_id', $request->user_id)
                ->where(function($q) use($request) {
                    $q->where('title', 'like', '%' . $request->text . '%')
                        ->orWhere('category', 'like', '%' . $request->text . '%');
                })
                ->skip(0)
                ->take(10)
                ->get();
        }elseif($request->has('search_detail_with_user')){
            $orderBy = 'title';
            $ASC = 'asc';
            
            if (strcmp($request->order_by, 'ORDER_BY_DATE') == 0 ) {
                $orderBy = 'publish_date';
            }
            
            if (strcmp($request->asc, 'DESC')) {
                $ASC = 'desc';
            }

            $item = Item::where('user_id', $request->user_id)
                ->where('title', 'like', '%' . $request->search_detail_value . '%')
                ->orderBy($orderBy, $ASC)
                ->with('user')
                ->paginate(6);
        }

        return $item;
    }

    /** Show specific data */
    public function show($id) {
        $item = Item::with('user')->find($id);

        return $item;
    }

    /** Store data */
    public function store(Request $request) {
        $this->validate($request, [
            'cover' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4048',
        ]);
        
        $imageName = '';

        if ($request->file('cover')) {
            $imagePath = $request->file('cover');
            $imageName = $request->user_id . time() . $imagePath->getClientOriginalName();
  
            $path = $request->file('cover')->storeAs('images', $imageName);
        }
        
        $item = new Item;

        $item->user_id = $request->user_id;
        $item->category = $request->category;
        $item->title = $request->title;
        $item->author = $request->author;
        $item->publish_date = $request->publish_date;
        $item->cover = env('DB_HOST_LAN') . '/storage/app/images/' . $imageName;
        $item->save();

        return $request;
    }

    /** Update data */
    public function update(Request $request, $id) {
        $item = Item::find($id);

        /** If cover image has changed - start */
        if ($request->has('cover')) {
            $this->validate($request, [
                'cover' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4048',
            ]);
            
            $imageName = '';
    
            if ($request->file('cover')) {
                $imagePath = $request->file('cover');
                $imageName = $request->user_id . time() . $imagePath->getClientOriginalName();
      
                $path = $request->file('cover')->storeAs('images', $imageName);
            }

            $item->cover = env('DB_HOST_LAN') . '/storage/app/images/' . $imageName;
        }
        /** If cover image has changed - end */
        
        $item->category = $request->category;
        $item->title = $request->title;
        $item->author = $request->author;
        $item->publish_date = $request->publish_date;
        $item->save();

        return $request;
    }

    public function destroy($id) {
        Item::destroy($id);

        return $id;
    }
}
