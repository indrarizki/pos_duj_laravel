@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Transaksi</h5>
                    <div class="form-group">
                        <label>Filter</label>
                        
                        <br>
                        <div class="mx-2 my-auto d-inline w-100">
                            <select id="filter" class="form-control">
                                <option>Pilih Filter</option>
                                <option value="{{ route('manager.transactions.ui') }}">Semua</option>
                                <option value="{{ route('manager.transactions.is.paid.off.ui', 1) }}">Lunas</option>
                                <option value="{{ route('manager.transactions.is.paid.off.ui', 0) }}">Tidak Lunas</option>
                            </select>
                            <br>
                            <form action="{{ route('manager.transactions.search.customer.id.ui')  }}">
                                <div class="input-group">
                                    <input name="customer_id" type="text" class="form-control" placeholder="NIK">
                                     <span class="input-group-append">

                                     <button  class="btn btn-outline-secondary" type="submit">Cari</button>
                                     </span>
                                  </div>
                             </form>
                        </div>
                       
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">TransactionId</th>
                                    <th scope="col">Kasir</th>
                                    <th scope="col">Customer</th>
                                    <th scope="col">Staff</th>
                                    <th scope="col">Lunas</th>
                                    <th scope="col">Tanggal</th>
                                    {{-- <th scope="col">Diperbarui</th> --}}
                                    {{-- <th scope="col">Refund</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactions as $transaction)
                                <tr onclick="window.location.href='{{ route("manager.transactions.edit.ui" , $transaction->id) }}'">
                                    <th scope="row">{{ $loop->index + 1 }}</th>
                                    <td> {{ $transaction->id}} </td>
                                    <td>{{ $transaction->users->name ?? null}}</td>
                                    <td>{{ $transaction->customers->name ?? null}}</td>
                                    <td>{{ $transaction->staffs->name ?? null}}</td>
                                    @if ($transaction->is_paid_off ?? null)
                                    <td>Ya</td>
                                    @else
                                    <td>Tidak</td>
                                    @endif
                                    <td>{{ $transaction->created_at ?? null}} </td>
                                </tr>
                                @endforeach
                            </tbody>


                        </table>
                        {{ $transactions->links()}}
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('load', function() {
        $(function() {
            // bind change event to select
            $('#filter').on('change', function() {
                var url = $(this).val(); // get selected value
                if (url && url != null) { // require a URL
                    window.location = url; // redirect
                }
                return false;
            });
        });
    })
</script>



@endsection
