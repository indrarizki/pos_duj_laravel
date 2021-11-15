@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Customer</div>
                    <div class="form-group">
                        <div class="mx-2 my-auto d-inline w-100">
                            <br>
                            <form action="{{ route('manager.data.customer.search.ui')  }}">
                                
                                <div class="input-group">
                                    <input value="{{ $id  }}" name="id" type="text" class="form-control" placeholder="NIK">
                                     <span class="input-group-append">
                                     <button  class="btn btn-outline-secondary" type="submit">Cari</button>
                                     </span>
                                  </div>
                                  <br>
                                  Filter
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
                             </form>
                        </div>
                    </div>    
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">NIK</th>
                            <th scope="col">Nomer Telepon</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col"></th>
                            <th scope="col">

                            </th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $customer)
                        <tr>
                            <th scope="row">{{ $loop->index + 1 }}</th>
                            <td> {{ $customer->name}} </td>
                            <td>{{ $customer->id }}</td>
                            <td>{{ $customer->phone }}</td>
                            <td>{{ $customer->address }}</td>
                            <td>{{ $customer->created_at }} </td>
                            <td><a href="{{route('manager.customer.profile.ui', $customer->id)}}" class="btn btn-outline-primary btn-sm">Data Customer</a></td>
                            <td> <a href="{{route('manager.absent.cek', $customer->id)}}" class="btn btn-outline-dark btn-sm">Cek Absent</a> </td>
                            {{-- <td>
                                {{-- <form action="{{route('manager.customer.delete', $customers->id)}}" method="post">
                                    <button type="submit" class="btn btn-primary btn-sm">Hapus</button>
                                    @method('delete')
                                    @csrf --}}
                                {{-- </form> --}}
                            {{-- </td> --}} 
                        </tr>

                        @endforeach

                    </tbody>
                </table>
                {{ $customers->appends([
                            'id' => $id, 
                            'sort_type'=>$sort_type
                            ])->links()}}
            </div>
        </div>
    </div>
</div>






@endsection
