@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Karyawan</div>
                <form action="{{ route('manager.karyawan.update', $user->id) }}" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input name="name" type="text" class="form-control" value="{{ $user->name }}">
                            <label>Email</label>
                            <input name="email" type="text" class="form-control" value="{{ $user->email }}">
                            <label>Role</label>
                            <input name="is_active" type="hidden" value="{{ $user->is_active }}">
                            <select class="form-control" name="role">
                                <option value="{{$user->role}}">
                                    {{ $user->role }}
                                </option>
                                @foreach ($roles as $role)
                                @if($role != $user->role)
                                <option value="{{$role}}">
                                    {{ $role }}
                                </option>
                                @endif

                                @endforeach
                            </select>
                            <label>Address</label>
                            <input name="address" type="text" class="form-control" value="{{ $user->address }}">


                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        @method('put')
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
