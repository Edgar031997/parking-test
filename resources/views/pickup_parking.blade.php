@extends('layouts.app')

@section('content')
    <div class="container">
        <pick-up-component :pick_up_parking_places="{{json_encode($pickupParking)}}"
                           :clients="{{json_encode($clients)}}"
                           :parking_places="{{json_encode($parking_places)}}"></pick-up-component>
    </div>
@endsection
