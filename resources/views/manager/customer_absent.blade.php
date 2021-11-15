@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Data Absent</div>
                <div class="form-group">
                        <div class="mx-2 my-auto d-inline w-100">
                            <br>
                            <form action="{{ route('resepsionist.data.absent.search.ui')  }}">
                                
                               <div class="input-group">
                                    <input value="{{ $date_time }}" id="date_time" type="date" name="date_time" class="form-control">
                                     <span class="input-group-append">
                                     <button onclick="reset_date()" class="btn btn-outline-secondary" type="button">Reset</button>
                                     </span>
                                  </div>
                                  <br>
                                  Filter
                               <br>
                               <div class="input-group">
                                <select name="sort_type" class="form-control">
                                  @if ($sort_type == "asc")
                                  <option selected value="asc">ASC</option>
                                  <option value="desc">DESC</option>
                                  @else
                                  <option value="asc">ASC</option>
                                  <option selected value="desc">DESC</option>
                                  @endif
                                </select>
                                <span class="input-group-append">
                                     <button  class="btn btn-outline-secondary" type="submit">Filter / Cari</button>
                                </span>
                                </div>
                             </form>
                        </div>
                    </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($absentcusts as $absentcust)
                        <tr>
                            <th scope="row">{{ $loop->index + 1 }}</th>
                            <td> {{ $absentcust->name }} </td>
                            <td>{{ $absentcust->log_time }} </td>
                        @endforeach

                    </tbody>
                </table>
                {{ $absentcusts->appends([
                            'sort_type'=>$sort_type,
                            'date_time'=>$date_time
                            ])->links()}}
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
