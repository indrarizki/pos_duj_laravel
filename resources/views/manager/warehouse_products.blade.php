@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Warehouse Product</div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">ID</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Harga Dasar</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">Dibuat</th>
                            <th scope="col">Diperbarui</th>
                            <th scope="col">
                                <a href="{{ route('manager.warehouse.products.create.ui')}}">Buat Baru</a>
                            </th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                        <tr>
                            <th scope="row">{{ $loop->index + 1 }}</th>
                            <td> {{ $product->id}} </td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->quantity }}</td>
                            <td>{{ $product->created_at }}</td>
                            <td>{{ $product->updated_at }}</td>
                            <td> <a href="{{ route('manager.warehouse.products.edit.ui', $product->id) }}">Edit</a> </td>

                            <td>
                                <form action="{{ route('manager.warehouse.products.delete', $product->id) }}" method="post">
                                    <button type="submit" class="btn btn-primary btn-sm">Hapus</button>
                                    @method('delete')
                                    @csrf
                                </form>
                            </td>
                        </tr>

                        @endforeach

                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>


@endsection
