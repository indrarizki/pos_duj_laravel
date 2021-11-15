@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="title m-b-md">
            <!-- <form >
                <div class="form-group">
                    <label for="exampleInputPassword">NIK</label>
                    <input type="number" class="form-control" name="nik" id="exampleUsername" placeholder="(Nomer Induk Keluarga) sesuai KTP">
                </div>
                <button type="submit" class="btn btn-success">Print</button>
            </form> -->
            <form action="{{ route('resepsionist.customer.barprint') }}" method="POST">
                <input type="text" name="nik" class="form-control">
                <input type="hidden" name="_token" class="form-control" value="{!! csrf_token() !!}">
                <button type="submit" name="submit" class="btn btn-info">Print</button>
            </form>
        </div>
    </div>
@endsection