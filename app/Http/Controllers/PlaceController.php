<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePlaceRequest;
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

    public function store(StorePlaceRequest $request)
    {
        $place = Place::create([
            'name' => $request->input('name'),
            'longitude' => $request->input('longitude'),
            'latitude' => $request->input('latitude')
        ]);

        return response()->json([
            'data' => [
                'message' => 'Место отдыха успешно создано',
                'place' => $place
            ]
        ]);
    }
}
