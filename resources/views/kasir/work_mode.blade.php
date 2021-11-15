@extends('layouts.app')

@section('content')

<kasir-purchase-component base-url="{{ $base_url }}" token="{{ $token }}">
</kasir-purchase-component>


@endsection
