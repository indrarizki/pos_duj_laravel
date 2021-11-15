@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-6 img">
      <img src="{{ asset('staff/' . $data->photo)}}"  alt="Circle Image" class="img-raised rounded-circle img-fluid" width="300" >
    </div>
    <div class="col-md-6 details">
      <blockquote>
        <h5>{{ $data->name }}</h5>
        <small><cite title="Source Title">{{ $data->id }} <i class="icon-map-marker"></i></cite></small>
      </blockquote>
      <p>
        <dt> Alamat           : </dt> <dd> {{ $data->address }} </dd>
        <dt> Nomer Telepon       : </dt> <dd> {{ $data->phone}} </dd> <br>
      </p>
    </div>
  </div>
  <br><br>
  <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"></div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Customer</th> 
                            <th scope="col">Transaction ID</th>
                            <th scope="col">Produk</th>
                            <th scope="col">Lunas / Tidak Lunas</th> 
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                        <tr>
                            <th scope="row">{{ $loop->index + 1 }}</th>
                            <td> {{ $transaction->customers->name}}</td>
                            <td>{{ $transaction->id}}</td>
                            @php ($names = [])
                            @foreach ($transaction->products as $product)
                             @php ($names[] = $product->name)
                            @endforeach
                            <td>{{ implode(', ', $names) }}</td>
                            @if ($transaction->is_paid_off ?? null)
                            <td>Ya</td>
                            @else
                            <td>Tidak</td>
                            @endif
                            
                            {{-- <td></td> --}}
                          
                        </tr>

                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

@endsection