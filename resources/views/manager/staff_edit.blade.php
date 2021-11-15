@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Staff</div>
                <form action=" {{route('manager.staff.update', $staff->id)}}" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama staff</label>
                            <input name="name" type="text" class="form-control" value="{{ $staff->name }}">
                            <label>Nomer Telepon</label>
                            <input name="phone" type="number" class="form-control" value="{{ $staff->phone }}">
                            <label>Alamat</label>
                            <input name="address" type="text" class="form-control" value="{{ $staff->address }}">
                        </div>
                    </div>
                        
                    <div class="modal-footer">
                        <a href="{{route('manager.staff.ui')}}" class="btn btn-danger">Kembali</a>
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
