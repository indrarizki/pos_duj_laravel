 @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Data Refund</div>
                    <div class="card text-center">
                        <div class="card-footer text-muted">Refund Belum Tervalidasi</div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">transaction ID</th>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">File</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($refund as $refunds)
                                <tr>
                                    
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td> {{ $refunds->transaction_id }} </td>
                                    <td>{{ $refunds->created_at }} </td>
                                    <td>
                                    <a class="btn btn-outline-primary" href="{{ route('manager_center.document.view', $refunds->id) }}">View</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>   
                        </table>
                    </div>
                    <div class="card text-center">
                        <div class="card-footer text-muted">Refund Tervalidasi</div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">transaction ID</th>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">File</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($refund_validation as $refund)
                                    <tr>
                                        
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td> {{ $refund->transaction_id }} </td>
                                        <td>{{ $refund->updated_at }} </td>
                                        <td>
                                        <a class="btn btn-outline-primary" href="{{ route('manager_center.document.view', $refund->id) }}">View</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                    </div>    
                </div>
            </div>
        </div>
        <br><br>
         <div class="col-md-12">
            <div class="card">
                <div class="card-header">Data Pindah</div>
                    <div class="card text-center">
                        <div class="card-footer text-muted">Pindah Produk Belum Tervalidasi</div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Transaction ID</th>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">File</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($change as $changes)
                                    <tr>
                                        
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td> {{ $changes->transaction_id }} </td>
                                        <td>{{ $changes->created_at }} </td>
                                        <td>
                                        <a class="btn btn-outline-primary" href="{{ route('manager_center.change.document.view', $changes->id) }}">View</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>   
                            </table>
                    </div>
                    <div class="card text-center">
                        <div class="card-footer text-muted">Pindah Produk Tervalidasi</div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Transaction ID</th>
                                        <th scope="col">Tanggal</th>
                                        {{-- <th scope="col">Information</th> --}}
                                        <th scope="col">File</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($change_validation as $change_validations)
                                    <tr>
                                        
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td> {{ $change_validations->transaction_id }} </td>
                                        <td>{{ $change_validations->updated_at }} </td>
                                        <td>
                                        <a class="btn btn-outline-primary" href="{{ route('manager_center.change.document.view', $changes->id) }}">View</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>   
                            </table>
                    </div>        
                </div>
            </div> 
        </div>
    </div>    
</div>

@endsection