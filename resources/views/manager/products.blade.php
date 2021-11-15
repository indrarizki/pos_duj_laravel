@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Products</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">No</th>

                                <th scope="col">Nama</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Jumlah</th>
                                <th scope="col">Dibuat</th>
                                <th scope="col">Diperbarui</th>
                                <th scope="col">
                                    <a href="{{ route('manager.stores.products.create.ui', $products[0]['store_id'])}}">Tambah jenis barang</a>
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                            <tr>
                                <th scope="row">{{ $loop->index + 1 }}</th>

                                <td>{{ $product->warehouse_products->name }}</td>
                                <td>{{ $product->price }}</td>
                                <td>{{ $product->quantity }}</td>
                                <td>{{ $product->created_at }}</td>
                                <td>{{ $product->updated_at }}</td>
                                <td> <a href="{{ route('manager.products.edit.ui', $product->id) }}">Tambah Jumlah</a> </td>

                                <!-- <td>
                                <form action="{{ route('manager.products.delete', $product->id) }}" method="post">
                                    <button type="submit" class="btn btn-primary btn-sm">Hapus</button>
                                    @method('delete')
                                    @csrf
                                </form>
                            </td> -->
                                <!-- <td>
                                    <form action="" method="post">
                                        <button type="submit" class="btn btn-primary btn-sm">Pindahkan jumlah barang ke gudang</button>
                                        @method('put')
                                        @csrf
                                    </form>
                                </td> -->
                                <td>
                                    <form action="{{route('manager.products.update', $product->id)}}" method="post">
                                        <input type="hidden" name="job" value="delete_product">
                                        <button type="submit" class="btn btn-primary btn-sm">Hapus</button>
                                        @method('put')
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
</div>


@endsection
