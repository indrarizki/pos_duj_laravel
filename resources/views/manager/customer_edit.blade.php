@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Customer</div>
                <form action="{{ route('manager.customer.update', $customer->id)}}" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama</label>
                            <input name="name" type="text" class="form-control" value="{{ $customer->name }}">
                            <label>NIK</label>
                            <input name="nik" type="number" class="form-control" value="{{ $customer->nik }}">
                            <label>No Telepon</label>
                            <input name="phone" type="number" class="form-control" value="{{ $customer->phone }}">
                            <label>Alamat</label>
                            <input name="address" type="text" class="form-control" value="{{ $customer->address }}">
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
