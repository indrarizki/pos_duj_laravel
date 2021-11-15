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
                            {{-- <form class="" action="{{route ('resepsionist.customer.cari.ui')}}">
                            <div class="input-group">   
                                <input class="form-control" type="text" placeholder="Cari Nama / NIK" aria-label="Search" name="cari">
                                <button class="btn btn-outline-secondary" type="submit">Search</button>
                            </div>  
                            </form> --}}
                            <form action="{{ route('resepsionist.data.customer.search.ui')  }}">
                                
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
                            <th scope="col">Tanggal</th>
                            <th scope="col">Register / Absent</th>
                            <th scope="col">
                                <a href="{{route('resepsionist.customer.create.ui')}}" class="btn btn-outline-primary btn-sm">Buat Baru</a>
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
                            <td>{{ $customer->created_at }} </td>
                            @if ($customer->finger != null)
                                 <td><button onclick="login({{$customer->id}} )" class="btn btn-outline-success btn-sm">Absent</button></td>
                           @else
                                <td><button onclick="register({{$customer->id}} )" class="btn btn-outline-primary btn-sm">register</button></td>
                           @endif
                            <td><a href="{{route('resepsionist.customer.profile.ui', $customer->id)}}" class="btn btn-outline-secondary btn-sm">Data Customer</a>  </td>

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

<script>
function login(id) {
  window.open("http://localhost/flexcode/asu.php?id=" + id);
}
function register(id) {
  window.open("http://localhost/flexcode/kucing.php?id=" + id);
}

</script>


@endsection
