@extends('layouts.app')

@section('content')
    <div class="container">
        <parking-component :parking_place="{{$parkingPlace}}"></parking-component>
    </div>
@endsection
