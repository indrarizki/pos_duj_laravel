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
                            

                        </tr>

                        @endforeach

                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>






@endsection
