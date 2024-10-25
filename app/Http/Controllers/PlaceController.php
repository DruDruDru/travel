<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Place;

class PlaceController extends Controller
{
    public function list()
    {
        return response()->json([
            'data' => Place::all()
        ]);
    }

    public function
}
