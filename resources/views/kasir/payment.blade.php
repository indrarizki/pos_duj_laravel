@extends('layouts.app')

@section('content')

<kasir-payment-component base-url="{{ $base_url }}" token="{{ $token }}">
</kasir-payment-component>


@endsection