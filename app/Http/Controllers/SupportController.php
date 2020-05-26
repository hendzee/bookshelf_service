<?php

namespace App\Http\Controllers;

use App\Support;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    /** Get all data */
    public function index(Request $request) {
        $support = Support::all();
    
        return $support;
    }

    /** Show specific data */
    public function show($id) {
        $support = Support::find($id);

        return $support;
    }

    /** Store data */
    public function store(Request $request) {
        $support = new Support;

        $support->content = $request->content;
        $support->save();

        return $request;
    }

    /** Destroy data */
    public function destroy($id) {
        Support::destroy($id);

        return $id;
    }
}
