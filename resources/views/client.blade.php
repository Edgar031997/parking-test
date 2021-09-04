@extends('layouts.app')

@section('content')
    <div class="container">
        <client-component :client="{{$client}}"></client-component>
    </div>
@endsection
