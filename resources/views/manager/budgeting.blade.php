@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Anggaran</div>
                <div class="card-header"><a href="{{route('manager.realization.ui')}}">Realisasi</a></div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Anggaran</th>
                            <th scope="col">Nominal</th>
                            <th scope="col">Dibuat</th>
                            <th scope="col">Diperbarui</th>
                            <th scope="col"></th>
                            <th scope="col">
                                <a href="{{route('manager.budgeting.create.ui')}}">Buat Baru</a>
                            </th>

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
                            <td> <a href="{{route('manager.budgeting.edit.ui', $budgetings->id)}}">Edit</a> </td>

                            <td>
                                <form action="{{ route('manager.budgeting.delete', $budgetings->id) }}" method="post">
                                    <button type="submit" class="btn btn-primary btn-sm">Hapus</button>
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
