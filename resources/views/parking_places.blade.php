@extends('layouts.app')

@section('content')
    <div class="container">
        <parking-places-component :parking_places="{{json_encode($parkingPlaces)}}"></parking-places-component>
    </div>
@endsection
