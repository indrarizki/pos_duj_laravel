@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Product</div>
                <form action="{{ route('manager.warehouse.products.create')}}" method="POST">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Nama</label>
                            <input name="name" type="text" class="form-control">
                            <label>Harga</label>
                            <input name="price" type="text" class="form-control">
                            <label>Jumlah</label>
                            <input name="quantity" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        @method('post')
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
