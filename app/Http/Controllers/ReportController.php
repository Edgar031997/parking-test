<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportRequest;
use App\Models\ClientParkingPlace;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function report()
    {
        return view('report');
    }

    public function reportSearch(ReportRequest $request)
    {
        $report = ClientParkingPlace::with('client','parking')->where('start_parking', '>=', Carbon::parse($request->start))
            ->where('end_parking', '<=', Carbon::parse($request->end))->paginate(5);

        return response()->json($report, 200);
    }
}
