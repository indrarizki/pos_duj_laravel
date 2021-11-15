@extends('layouts.app')

@section('content')

<manager-transaction-edit-component base-url="{{ $base_url }}" token="{{ $token }}" transaction-id="{{ $id }}"></manager-transaction-edit-component>

@endsection
