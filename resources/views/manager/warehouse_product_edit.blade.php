@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Product</div>
                <form action="{{ route('manager.warehouse.products.update', $product->id)}}" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama</label>
                            <input name="name" type="text" class="form-control" value="{{ $product->name }}">
                            <label>Harga</label>
                            <input name="price" type="text" class="form-control" value="{{ $product->price }}">
                            <label>Jumlah</label>
                            <input name="quantity" type="text" class="form-control" value="{{ $product->quantity }}">
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
