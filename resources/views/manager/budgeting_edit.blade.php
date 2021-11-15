@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Budgeting</div>
                <form action="{{ route('manager.budgeting.update', $budgeting->id)}}" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Anggaran</label>
                            <input name="name" type="text" class="form-control" value="{{ $budgeting->name }}">
                            <label>Nominal</label>
                            <input name="nominal" type="number" class="form-control" value="{{ $budgeting->nominal }}">
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
