<?php

namespace App\Http\Controllers;

use App\Http\Requests\PickUpRequest;
use App\Models\Client;
use App\Models\ClientParkingPlace;
use App\Models\ParkingPlace;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PickUpParkingController extends Controller
{
    public function index(Request $request)
    {
        $pickupParking = ClientParkingPlace::with('client','parking')->orderBy('id','desc')->paginate(5);
        $clients = Client::all();
        $parking_places = ParkingPlace::all();

        if($request->ajax()){
            return response()->json($pickupParking,200);
        }
        return view('pickup_parking',compact('pickupParking','clients','parking_places'));
    }

    public function store(PickUpRequest $request)
    {
        $ClientParkingPlaces = ClientParkingPlace::where('parking_id',$request->parking_id);
        $startDateCheck = $ClientParkingPlaces->where('start_parking', '<=', Carbon::parse($request->start_parking))
            ->where('end_parking', '>=', Carbon::parse($request->start_parking))->first();
        $endDateCheck = $ClientParkingPlaces->where('end_parking', '>=', Carbon::parse($request->end_parking))
            ->where('start_parking', '<=', Carbon::parse($request->end_parking))->first();

        if($startDateCheck || $endDateCheck){
            return response()->json([
                'message' => 'Parking is not free',
            ],500);
        }

        ClientParkingPlace::create($request->all());

        return response()->json('success', 201);
    }

    public function delete($id)
    {
        ClientParkingPlace::find($id)->delete();

        return response()->json('success', 200);

    }
}
