@extends('layouts.app')

@section('content')

<kasir-reports-component base-url="{{$base_url}}" token="{{$token}}"></kasir-reports-component>
@endsection
