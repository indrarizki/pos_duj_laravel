@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Transaksi</h5>
                    <div class="form-group">
                        <div class="mx-2 my-auto d-inline w-100">
                            <form action="{{ route('manager_center.transactions.search.ui')  }}">
                                
                                <div class="input-group">
                                    <input value="{{ $customer_id  }}" name="customer_id" type="text" class="form-control" placeholder="NIK">
                                     <span class="input-group-append">
                                     <button  class="btn btn-outline-secondary" type="submit">Cari</button>
                                     </span>
                                  </div>
                                  <br>
                                  <div class="input-group">
                                    <input value="{{ $date_time }}" id="date_time" type="date" name="date_time" class="form-control">
                                     <span class="input-group-append">
                                     <button onclick="reset_date()" class="btn btn-outline-secondary" type="button">Reset</button>
                                     </span>
                                  </div>
                             
                                  <br>
                                  Filter
                                  <select name="is_paid_off" class="form-control">
                                    @if ($is_paid_off  == "all")
                                    <option selected value="all">Semua</option>
                                    <option value="1">Lunas</option>
                                    <option value="0">Tidak Lunas</option>
                                    @elseif($is_paid_off  ==1)
                                    <option value="all">Semua</option>
                                    <option selected value="1">Lunas</option>
                                    <option value="0">Tidak Lunas</option>
                                    @elseif($is_paid_off  == 0)
                                    {{ $is_paid_off }}
                                    <option value="all">Semua</option>
                                    <option value="1">Lunas</option>
                                    <option selected value="0">Tidak Lunas</option>
                                    @else
                                    <option selected value="all">Semua</option>
                                    <option value="1">Lunas</option>
                                    <option value="0">Tidak Lunas</option>
                                    @endif
                                </select>
                               <br>
                                <select name="sort_type" class="form-control">
                                  @if ($sort_type == "asc")
                                  <option selected value="asc">ASC</option>
                                  <option value="desc">DESC</option>
                                  @else
                                  <option value="asc">ASC</option>
                                  <option selected value="desc">DESC</option>
                                  @endif
                                </select>
                                 <br>
                                 
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
                                    <th scope="col">Dibuat</th>
                                    <th scope="col">Diperbarui</th>
                                    <th scope="col">Refund</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactions as $transaction)
                                <tr onclick="window.location.href='{{ route("manager_center.transactions.edit.ui" , $transaction->id) }}'">
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
                                    <td>{{ $transaction->updated_at ?? null}}</td>
                                    <td>{{$transaction->refund_transactions->is_refund_off ?? null}}</td>
                                </tr>
                                {{-- <tr>
                                    
                                </tr> --}}
                                @endforeach
                            </tbody>


                        </table>
                      {{-- {{$transaction }} --}}
                        {{ $transactions->appends([
                            'customer_id' => $customer_id, 
                            'is_paid_off' => $is_paid_off,
                            'sort_type'=>$sort_type,
                            'date_time'=>$date_time
                            ])->links()}}
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

<script>
       function reset_date() {
           document.getElementById("date_time").valueAsDate = null;
        };  
    window.addEventListener('load', function() {
     
    })


</script>



@endsection
