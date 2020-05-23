<?php

namespace App\Http\Controllers;

use App\Policy;
use Illuminate\Http\Request;

class PolicyController extends Controller
{
     /** Show specific data */
     public function show($id) {
        $policy = Policy::find($id);

        return $policy;
    }

    /** Update data */
    public function update(Request $request, $id) {
        $policy = Policy::find($id);

        $policy->content = $request->content;
        $policy->save();

        return $policy;
    }
}
