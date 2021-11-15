@extends('layouts.app')

@section('content')

<manager-products-create-component store-id="{{ $store_id}}" token="{{ $token }}" base-url=" {{$base_url}}">

</manager-products-create-component>
@endsection
