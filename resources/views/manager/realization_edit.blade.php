@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Realisasi</div>
                <form action="{{ route('manager.realization.update', $realization->id)}}" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Realisasi</label>
                            <input name="name" type="text" class="form-control" value="{{ $realization->name }}">
                            <label>Nominal</label>
                            <input name="nominal" type="number" class="form-control" value="{{ $realization->nominal }}">
                            <label>ID Anggaran</label>
                            <input name="budgeting_id" type="number" class="form-control" value="{{ $realization->budgeting_id }}">
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
