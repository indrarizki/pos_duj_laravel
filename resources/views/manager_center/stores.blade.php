@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Toko</div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">ID</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Dibuat</th>
                            <th scope="col">Diperbarui</th>
                        </tr>
                    </thead>
                    <tbody >
                        @foreach ($stores as $store)
                        <tr onclick="window.location.href='{{ route("manager_center.stores.products.ui" , $store->id) }}'">
                            <th scope="row">{{ $loop->index + 1 }}</th>
                            <td> {{ $store->id}} </td>
                            <td>{{ $store->name }}</td>
                            <td>{{ $store->created_at }}</td>
                            <td>{{ $store->updated_at }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


@endsection
