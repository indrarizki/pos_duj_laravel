@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Informasi Gudang</div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Barang</th>
                            <th scope="col">Masuk</th>
                            <th scope="col">Keluar</th>
                            <th scope="col">Sisa</th>
                            <th scope="col">Informasi</th>
                        </tr>
                    </thead>
                    <tbody >
                        @foreach ($report as $reports)
                        <tr>
                            <th scope="row">{{ $loop->index + 1 }}</th>
                            <td> {{ $reports->product_id}} </td>
                            <td>{{ $reports->in }}</td>
                            <td>{{ $reports->out }}</td>
                            <td>{{ $reports->remainder }}</td>
                            <td>{{ $reports->information }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


@endsection
