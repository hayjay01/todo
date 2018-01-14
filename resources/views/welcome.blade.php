@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
        <div class="container" id="app">
            <tasks> </tasks>
        </div>

        <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
 @endsection
