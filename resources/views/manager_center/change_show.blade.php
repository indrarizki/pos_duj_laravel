@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Form Customer</div>
            </div>
        </div>
        <p></p>
        <iframe src="{{ asset('change_product/' . $data->scanner)}}" style="width: 900px; height: 800px"></iframe>
    </div>
</div>

@endsection