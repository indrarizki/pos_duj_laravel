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
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($staff as $staffs)
                        <tr>
                            <th scope="row">{{ $loop->index + 1 }}</th>
                            <td> {{ $staffs->name}} </td>
                            <td>{{ $staffs->phone}}</td>
                            <td>{{ $staffs->address }} </td>
                            <td><a href="{{route('resepsionist.staff.data.ui', $staffs->id)}}" class="btn btn-outline-primary btn-sm">Data Staff</a></td>
                        </tr>

                        @endforeach

                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>






@endsection
