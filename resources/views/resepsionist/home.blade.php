@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-header">Tools</div>
            {{-- <div class="card-header"><a href="{{route('resepsionist.absent.ui')}}" class="btn btn-primary">Absent</a></div> --}}
                <div class="card">
                    <div class="row">
                        <div class="card-body">
                            <div class="card" style="width: 16rem;" >
                                <a href="{{route('resepsionist.customer.ui')}}" class="btn btn-outline-primary">
                                    <div class="card-body">
                                        <h5 class="card-title" >Lihat Customer</h5>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card" style="width: 16rem;">
                                <a href="{{route('resepsionist.data.absent.ui')}}" class="btn btn-outline-primary">
                                    <div class="card-body">
                                        <h5 class="card-title">Data Absent</h5>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card" style="width: 16rem;">
                                <a href="{{route('resepsionist.staff.ui')}}" class="btn btn-outline-primary">
                                    <div class="card-body">
                                        <h5 class="card-title">Data Staff</h5>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>
        </div>
    </div>
</div>

@endsection
