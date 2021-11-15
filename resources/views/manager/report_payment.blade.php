@extends('layouts.app')

@section('content')

<manager-reports-payment-component base-url="{{$base_url}}" token="{{ $token }}"></manager-reports-payment-component>
@endsection
