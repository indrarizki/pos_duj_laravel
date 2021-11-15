@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Tambah jumlah Product</div>
                <form action="{{ route('manager.products.update', $product->id)}}" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama</label>
                            <input name="name" type="text" disabled class="form-control" value="{{ $product->warehouse_products->name }}">
                            <label>Harga</label>
                            <input name="price" type="text" class="form-control" value="{{ $product->price }}">
                            <label>Jumlah</label>
                            <input name="quantity" type="number" class="form-control" value="">
                            <input name="job" type="hidden" value="increase_quantity_product">
                            <div>jumlah sekarang {{ $product->quantity}}</div>
                            <div>jumlah barang yang terdapat di gudang {{ $product->warehouse_products->quantity}}</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        @method('put')
                        @csrf
                    </div>
                </form>
            </div>


            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

        </div>
    </div>
</div>
</div>





@endsection
