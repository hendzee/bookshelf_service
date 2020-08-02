<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /** Get all data */
    public function index(Request $request) {
        $user = User::all();

        return $user;
    }

    /** Show specific data */
    public function show($id) {
        $user = User::find($id);
        
        return $user;
    }

    /** Store data */
    public function store(Request $request) {
        $user = new User;
        $photo = env('DB_HOST_LAN') . '/storage/app/images/profile_default/profile_default.png';

        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = $request->password;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->photo = $photo;
        $user->rating = $request->rating;
        $user->save();

        return $request;
    }

    /** Update data */
    public function update(Request $request, $id) {
        $user = User::find($id);

        /** If cover image has changed - start */
        if ($request->has('photo')) {
            $this->validate($request, [
                'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4048',
            ]);
            
            $imageName = '';
    
            if ($request->file('photo')) {
                $imagePath = $request->file('photo');
                $imageName = $request->user_id . time() . $imagePath->getClientOriginalName();
      
                $path = $request->file('photo')->storeAs('images', $imageName);
            }

            $user->photo = env('DB_HOST_LAN') . '/storage/app/images/' . $imageName;
        }
        /** If cover image has changed - end */

        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
   
        $user->save();

        return $request;
    }

    /** Destroy data */
    public function destroy($id) {
        User::destroy($id);

        return $id;
    }
}