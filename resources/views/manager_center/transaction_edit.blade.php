@extends('layouts.app')

@section('content')

<manager-center-transaction-edit-component base-url="{{ $base_url }}" token="{{ $token }}" transaction-id="{{ $id }}"></manager-center-transaction-edit-component>

@endsection
