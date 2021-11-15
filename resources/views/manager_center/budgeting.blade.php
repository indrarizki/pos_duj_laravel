@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Anggaran</div>
                <div class="card-header"><a href="{{route('manager_center.realization.ui')}}">Realisasi</a></div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Anggaran</th>
                            <th scope="col">Nominal</th>
                            <th scope="col">Dibuat</th>
                            <th scope="col">Diperbarui</th>
                           

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($budgeting as $budgetings)
                        <tr>
                            <th scope="row">{{ $loop->index + 1 }}</th>
                            <td> {{ $budgetings->name}} </td>
                            <td>{{ $budgetings->nominal }}</td>
                            <td>{{ $budgetings->created_at }} </td>
                            <td>{{ $budgetings->updated_at }}</td>
                            
                        </tr>

                        @endforeach

                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>






@endsection
