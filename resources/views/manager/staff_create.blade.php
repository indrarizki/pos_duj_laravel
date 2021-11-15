@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add Staff</div>

                <form action=" {{route('manager.staff.create')}}" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">

                            <label>Nama</label>
                            <input name="name" type="text" class="form-control" placeholder="Nama sesuai KTP">
                            <label>No Telepon</label>
                            <input name="phone" type="number" class="form-control" placeholder="No Telepon">
                            <label>Alamat</label>
                            <input name="address" type="text" class="form-control" placeholder="Alamat">
                            <label>Photo</label>
                                <div class="custom-file">
                                <input type="file" class="" name="photo">
                                <label class="">Pilih Foto</label><br>
                                <p class="font-monospace">*Foto Max 2mb</p>
                                </div>
                                {{-- <div>Click <a href="#myModal" data-toggle="modal">here</a> untuk ambil foto
                                </div> --}}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="{{route('manager.staff.ui')}}" class="btn btn-secondary">Close</a>
                        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                        <button type="submit" class="btn btn-primary">Simpan</button>
                            @method('post')
                            @csrf
                        </div>
                </form>
            </div>


            {{-- @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif --}}

        </div>
    </div>
</div>
</div>

{{-- <div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Take Photo</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
            <div id="vid-controls">
<video id="video" width="360" height="360" autoplay="true"></video>
      <input id="vid-take" type="button" value="Take Photo"/>
      <!-- <input id="vid" type="button" value="Upload Photo"/> -->
      <!-- <input type="file" accept="image/*;capture=camera"> -->
      <div id="vid-canvas" style="width:400px; height:400px; border:20px solid rgb(102, 53, 53);"></div><hr/>
    </div>
            </div>
        </div>
    </div>
</div>

<script>
    'use strict';

const video = document.querySelector('video');
const canvas = document.getElementById('canvas');
const snap = document.getElementById("snap");
const errorMsgElement = document.querySelector('span#errorMsg');
const vendorUrl=window.URL||window.webkitURL;

navigator.getMedia=navigator.getUserMedia||navigator.webkitGetUserMedia||
                    navigator.mozGetUserMedia ||
                    navigator.msGetUserMedia;

window.addEventListener("load", function(){
  // [1] GET ALL THE HTML ELEMENTS
  var video = document.getElementById("video"),
      canvas = document.getElementById("vid-canvas"),
      take = document.getElementById("vid-take"),
      upload = document.getElementById("vid");

  // [2] ASK FOR USER PERMISSION TO ACCESS CAMERA
  // WILL FAIL IF NO CAMERA IS ATTACHED TO COMPUTER
  navigator.mediaDevices.getUserMedia({ video : true })
  .then(function(stream) {
    // [3] SHOW VIDEO STREAM ON VIDEO TAG
    video.srcObject = stream;
    video.play();

    // [4] WHEN WE CLICK ON "TAKE PHOTO" BUTTON
    take.addEventListener("click", function(){
      // Create snapshot from video
      var draw = document.createElement("canvas");
      draw.width = video.videoWidth;
      draw.height = video.videoHeight;
      var context2D = draw.getContext("2d");
      context2D.drawImage(video, 0, 0, 360,360);
      // Output as file
    //   console.log(video.videoWidth);
  
    // canvas.removeChild()
    if(canvas.hasChildNodes()){
        canvas.removeChild(canvas.firstChild);
      }
            
      var anchor = document.createElement("img");
      anchor.src = draw.toDataURL("image/png");
      anchor.download = "webcam.png";
      anchor.innerHTML = "Click to download";
      canvas.innerHTML = "";
      var anchors = document.createElement("a");
      anchors.href = draw.toDataURL("image/png");
      anchors.download = "webcam.png";
      anchors.innerHTML = "Click to download";
      canvas.innerHTML = "";
        canvas.appendChild(anchors);
        
        canvas.appendChild(anchor);

    //   upload.style.display='block';
    //   console.log(canvas);
    });
  })
  .catch(function(err) {
    document.getElementById("vid-controls").innerHTML = "Please enable access and attach a camera";
  });
});

    </script> --}}



@endsection
