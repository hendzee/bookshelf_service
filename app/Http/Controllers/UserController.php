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

        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = $request->password;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->photo = $request->photo;
        $user->rating = $request->rating;
        $user->save();

        return $request;
    }

    /** Update data */
    public function update(Request $request, $id) {
        $user = User::find($id);

        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = $request->password;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->photo = $request->photo;
        $user->rating = $request->rating;
        $user->save();

        return $request;
    }

    /** Destroy data */
    public function destroy($id) {
        User::destroy($id);

        return $id;
    }
}