<?php

namespace App\Http\Controllers;

use App\Description;
use Illuminate\Http\Request;

class DescriptionController extends Controller
{
    /** Show specific data */
    public function show($id) {
        $description = Description::find($id);

        return $description;
    }

    /** Update data */
    public function update(Request $request, $id) {
        $description = Description::find($id);

        $description->content = $request->content;
        $description->save();

        return $request;
    }
}
