@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Data Staff</div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Staff</th>
                            <th scope="col">Nomor Telepon</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">Data</th>
                            <th scope="col">Action</th>
                            <th scope="col">
                                <a href="{{route('manager.staff.create.ui')}}">Buat Baru</a>
                            </th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($staff as $staffs)
                        <tr>
                            <th scope="row">{{ $loop->index + 1 }}</th>
                            <td> {{ $staffs->name}} </td>
                            <td>{{ $staffs->phone}}</td>
                            <td>{{ $staffs->address }} </td>
                            <td><a href="{{route('manager.staff.data.ui', $staffs->id)}}" class="btn btn-outline-dark btn-sm">Data Staff</a></td>
                            {{-- <td>{{ $staffs->created_at }}</td> --}}
                            <td> <a href="{{route('manager.staff.edit.ui', $staffs->id)}}" class="btn btn-outline-primary btn-sm">Edit</a> </td>

                            <td>
                                <form action="{{route('manager.staff.delete', $staffs->id) }}" method="post">
                                    <button type="submit" class="btn btn-outline-danger btn-sm">Hapus</button>
                                    @method('delete')
                                    @csrf
                                </form>
                            </td>
                        </tr>

                        @endforeach

                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>






@endsection
