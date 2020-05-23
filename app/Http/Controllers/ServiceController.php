<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /** Show specific data */
    public function show($id) {
        $service = Service::find($id);

        return $service;
    }

    /** Update data */
    public function update(Request $request, $id) {
        $service = Service::find($id);

        $service->content = $request->content;
        $service->save();

        return $request;
    }
}
