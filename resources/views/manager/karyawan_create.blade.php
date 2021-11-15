@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Karyawan</div>
                <form action="{{ route('manager.karyawan.create') }}" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input name="name" type="text" class="form-control">
                            <label>Email</label>
                            <input name="email" type="text" class="form-control">
                            <label>Password</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            <label>Confirmation Password</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">

                            <label>Role</label>
                            <select class="form-control" name="role">
                                @foreach ($roles as $role)
                                <option value="{{ $role }}">
                                    {{ $role }}
                                </option>
                                @endforeach
                            </select>
                            <label>Address</label>
                            <input name="address" type="text" class="form-control">

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
