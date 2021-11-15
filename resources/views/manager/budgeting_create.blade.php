@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Anggaran</div>
                <form action="{{ route('manager.budgeting.create') }}" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Anggaran</label>
                            <input name="name" type="text" class="form-control">
                            <label>nominal</label>
                            <input name="nominal" type="number" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        @method('post')
                        @csrf
                    </div>
                </form>
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
