@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Karyawan</div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Email</th>
                            <th scope="col">Posisi</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">Status</th>
                            <th scope="col">Dibuat</th>
                            <th scope="col">Diperbarui</th>
                            <th scope="col"></th>
                            <th scope="col">
                                <a href="{{ route('manager.karyawan.create.ui')}}">Buat Baru</a>
                            </th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $user)
                        <tr>
                            <th scope="row">{{ $loop->index + 1 }}</th>
                            <td> {{ $user->name}} </td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role }}</td>
                            <td>{{ $user->address }}</td>
                            @if ($user->is_active == 1)
                            <td>Aktif</td>
                            @else
                            <td>Tidak Aktif</td>
                            @endif
                            <td>{{ $user->created_at }} </td>
                            <td>{{ $user->updated_at }}</td>
                            <td> <a href="{{ route('manager.karyawan.edit.ui', $user->id) }}">Edit</a> </td>

                            @if ($user->is_active == 1)
                            <td>
                                <form action="{{ route('manager.karyawan.update', $user->id) }}" method="post">
                                    <!-- $name = $request->input('name');
                                    $email = $request->input('email');
                                    $address = $request->input('address');
                                    $role = $request->input('role');
                                    $is_active = $request->input('is_active'); -->
                                    <input name="name" type="hidden" value="{{$user->name}}">
                                    <input name="email" type="hidden" value="{{$user->email}}">
                                    <input name="address" type="hidden" value="{{$user->address}}">
                                    <input name="role" type="hidden" value="{{$user->role}}">
                                    <input name="is_active" type="hidden" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">Non Aktifkan</button>
                                    @method('put')
                                    @csrf
                                </form>
                            </td>
                            @endif
                            @if ($user->is_active == 0)
                            <td>
                                <form action="{{ route('manager.karyawan.update', $user->id) }}" method="post">
                                    <input name="name" type="hidden" value="{{$user->name}}">
                                    <input name="email" type="hidden" value="{{$user->email}}">
                                    <input name="address" type="hidden" value="{{$user->address}}">
                                    <input name="role" type="hidden" value="{{$user->role}}">
                                    <input name="is_active" type="hidden" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Aktifkan</button>
                                    @method('put')
                                    @csrf
                                </form>
                            </td>
                            @endif
                        </tr>

                        @endforeach

                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>






@endsection
