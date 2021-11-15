@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><a class="btn btn-primary" href="{{route('manager_center.budgeting.ui')}}">Anggaran</a></div>
                <div class="card-header">Realisasi</div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Realisasi</th>
                            <th scope="col">Nominal</th>
                            <th scope="col">Nama Anggaran</th>
                            <th scope="col">Dibuat</th>
                            <th scope="col">Diperbarui</th>
                            

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($realization as $realizations)
                        <tr>
                            <th scope="row">{{ $loop->index + 1 }}</th>
                            <td> {{ $realizations->name}} </td>
                            <td>{{ $realizations->nominal }}</td>
                            <td>{{ $realizations->budgetings->name}}</td>
                            <td>{{ $realizations->created_at }} </td>
                            <td>{{ $realizations->updated_at }}</td>
                            

                            
                        </tr>

                        @endforeach

                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>






@endsection
