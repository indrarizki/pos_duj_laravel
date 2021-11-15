@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-header">Tools Manager</div>
            <div class="card">
                <div class="row">
                    <div class="card-body">
                        <div class="card" style="width: 16rem;">
                            <a class="btn btn-dark" href="{{ route('manager.karyawan.ui') }}">
                                <div class="card-body">
                                    <h5 class="card-title">Lihat karyawan</h5>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card" style="width: 16rem;">
                            <a class="btn btn-dark" href="{{route('manager.budgeting.ui')}}">
                                <div class="card-body">
                                    <h5 class="card-title">Lihat Anggaran</h5>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card" style="width: 16rem;">
                            <a class="btn btn-dark" href="{{route('manager.transactions.ui')}}">
                                <div class="card-body">
                                    <h5 class="card-title">Lihat Transaksi</h5>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card" style="width: 16rem;">
                            <a class="btn btn-dark" href="{{route('manager.reports.payments.ui')}}">
                                <div class="card-body">
                                    <h5 class="card-title">Lihat Pembayaran</h5>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card" style="width: 16rem;">
                            <a class="btn btn-dark" href="{{route('manager.reports.transaction.ui')}}">
                                <div class="card-body">
                                    <h5 class="card-title">Data Refund / Pindah</h5>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-header">Data Resepsionist</div>
            <div class="card">
                <div class="row">
                    <div class="card-body">
                        <div class="card" style="width: 16rem;">
                            <a class="btn btn-secondary" href="{{route('manager.staff.ui')}}">
                                <div class="card-body">
                                    <h5 class="card-title">Data Staff</h5>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card" style="width: 16rem;">
                            <a class="btn btn-secondary" href="{{route('manager.customer.ui')}}">
                                <div class="card-body">
                                    <h5 class="card-title">Lihat Customer</h5>
                                </div>
                            </a>
                        </div>
                    </div>
                     <div class="card-body">
                        <div class="card" style="width: 16rem;">
                            <a class="btn btn-secondary" href="{{route('manager.data.absent.ui')}}">
                                <div class="card-body">
                                    <h5 class="card-title">Absent Customer</h5>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
             <div class="card-header">Data Gudang</div>
            <div class="card">
                <div class="row">
                    <div class="card-body">
                        <div class="card" style="width: 16rem;">
                            <a class="btn btn-light" href="{{ route('manager.report.product.ui') }}">
                                <div class="card-body">
                                    <h5 class="card-title">Informasi Gudang</h5>
                                </div>
                            </a>
                        </div>
                    </div>
                     <div class="card-body">
                        <div class="card" style="width: 16rem;">
                            <a class="btn btn-light" href="{{ route('manager.stores.ui') }}">
                                <div class="card-body">
                                    <h5 class="card-title">Lihat Toko</h5>
                                </div>
                            </a>
                        </div>
                    </div>
                     <div class="card-body">
                        <div class="card" style="width: 16rem;">
                            <a class="btn btn-light" href="{{route('manager.warehouse.products.ui')}}">
                                <div class="card-body">
                                    <h5 class="card-title">Lihat Gudang</h5>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>     
        </div>
    </div>
</div>


@endsection
