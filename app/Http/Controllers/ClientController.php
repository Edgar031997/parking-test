<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $clients = Client::orderBy('id', 'desc')->paginate(5);

        if($request->ajax()){
            return response()->json($clients,200);
        }
        return view('clients', compact('clients'));
    }

    public function show($slug)
    {
        $client = Client::with('parkings_history')->where('slug', $slug)->first();

        return view('client', compact('client'));
    }

    public function store(CreateClientRequest $request)
    {
        Client::create($request->all());

        return response()->json('success', 201);
    }

    public function update(UpdateClientRequest $request,$id)
    {
        Client::find($id)->update($request->all());

        return response()->json('success', 200);
    }

    public function delete($id)
    {
        Client::find($id)->delete();

        return response()->json('success',200);
    }
}
