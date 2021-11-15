@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Data absent   </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($absent as $absents)
                        <tr>
                            
                            <th scope="row">{{ $loop->iteration }}</th>
                            {{-- <td> {{ $absentcust->customers->id }} </td> --}}
                            <td> {{ $absents->name }} </td>
                            <td>{{ $absents->log_time }} </td>
                        </tr>
                        @endforeach
                </table>
                {{-- {{$absentcusts->links()}} --}}
            </div>
        </div>
    </div>
</div>

@endsection