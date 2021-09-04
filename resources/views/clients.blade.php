@extends('layouts.app')

@section('content')
    <div class="container">
        <clients-component :clients="{{json_encode($clients)}}"></clients-component>
    </div>
@endsection
