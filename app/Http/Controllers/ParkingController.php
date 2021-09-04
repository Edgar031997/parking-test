<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateParkingPlaceRequest;
use App\Http\Requests\UpdateParkingPlaceRequest;
use App\Models\ParkingPlace;
use Illuminate\Http\Request;

class ParkingController extends Controller
{
    public function index(Request $request)
    {
        $parkingPlaces = ParkingPlace::orderBy('id', 'desc')->paginate(5);

        if($request->ajax()){
            return response()->json($parkingPlaces,200);
        }
        return view('parking_places', compact('parkingPlaces'));
    }

    public function show(Request $request,$id)
    {
        $parkingPlace = ParkingPlace::with('clients_history')->find($id);

        return view('parking', compact('parkingPlace'));
    }

    public function store(CreateParkingPlaceRequest $request)
    {
        $parkingPlace = ParkingPlace::create($request->all());

        return response()->json('success', 201);
    }

    public function update(UpdateParkingPlaceRequest $request,$id)
    {
        ParkingPlace::find($id)->update($request->all());

        return response()->json('success',200);

    }

    public function delete($id)
    {
        ParkingPlace::find($id)->delete();

        return response()->json('success',200);
    }
}
