@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-6 img">
      <img src="{{ asset('customer/' . $customer->photo)}}"  alt="" class="img-raised rounded img-fluid" >
    </div>
    <div class="col-md-6 details">
      <blockquote>
        <h5>{{ $customer->name }}</h5>
        <small><cite title="Source Title">{{ $customer->id }} <i class="icon-map-marker"></i></cite></small>
      </blockquote>
      <p>
        <dt> Alamat           : </dt> <dd> {{ $customer->address }} </dd>
        <dt> Nomer Telepon       : </dt> <dd> {{ $customer->phone}} </dd> <br>
        <dt id="my_barcode">
            <?php echo DNS1D::getBarcodeSVG($customer->id, 'C128'); ?>
        </dt>
        <p>
        <dt>
          Click <a onclick="print()" ata-toggle="modal" class="btn btn-outline-secondary">Cetak</a> untuk print barcode
        </dt>
        <br>
        <dt id="my_barcode">
          {!! QrCode::format('svg')->size(100)->generate($customer->id); !!}
        </dt>
        <p></p>
        <dt>
          Click <a  onclick="print()" ata-toggle="modal" class="btn btn-outline-secondary btn-sm">Cetak</a> untuk print barcode
        </dt>
        </p>
      </p>
    </div>
  </div>
  <br>
  <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Data absent   </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($absent as $absents)
                        <tr>
                            
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td> {{ $absents->name }} </td>
                            <td>{{ $absents->log_time }} </td>
                        </tr>
                        @endforeach
                </table>
                {{-- {{$absentcusts->links()}} --}}
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="js/JsBarcode.all.min.js"></script>
<script>

function print() {
  console.log('print')
  var mywindow = window.open('', 'PRINT', 'height=400,width=600');

    mywindow.document.write(document.getElementById('my_barcode').innerHTML);
 
    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10*/

    mywindow.print();
    mywindow.close();

    return true;
}
</script>
@endsection