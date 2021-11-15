@extends('layouts.app')

@section('content')

<manager-center-payment-component base-url="{{$base_url}}" token="{{ $token }}"></manager-center-payment-component>
@endsection
