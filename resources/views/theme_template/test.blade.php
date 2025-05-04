@extends('layouts.master')

@section('title') TEST @endsection

@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/libs/cropperjs/cropperjs.min.css')}}">
<style type="text/css">
img {
  display: block;
  max-width: 100%;
}
.preview {
  overflow: hidden;
  width: 160px; 
  height: 160px;
  margin: 10px;
  border: 1px solid red;
}
.modal-lg{
  max-width: 1000px !important;
}
.cropper-crop-box, .cropper-view-box {
    border-radius: 50%;
}
.cropper-view-box {
    box-shadow: 0 0 0 1px #39f;
    outline: 0;
}
.cropper-face {
  background-color:inherit !important;
}

.cropper-dashed, .cropper-line {
  display:none !important;
}
.cropper-view-box {
  outline:inherit !important;
}

.cropper-point.point-se {
  top: calc(85% + 1px);
  right: 14%;
}
.cropper-point.point-sw {
  top: calc(85% + 1px);
  left: 14%;
}
.cropper-point.point-nw {
  top: calc(15% - 5px);
  left: 14%;
}
.cropper-point.point-ne {
  top: calc(15% - 5px);
  right: 14%;
}
</style>
@endsection

@section('content')
<div class="container">
    <h1>PHP Crop Image Before Upload using Cropper JS - NiceSnippets.com</h1>
    <form method="post">
    <input type="file" name="image" class="image">
    </form>
</div>

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">PHP Crop Image Before Upload using Cropper JS - NiceSnippets.com</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="img-container">
            <div class="row">
                <div class="col-md-8">
                    <img id="image" src="https://avatars0.githubusercontent.com/u/3456749">
                </div>
                <div class="col-md-4">
                    <div class="preview"></div>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="crop">Crop</button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')
<script src="{{ URL::asset('assets/libs/cropperjs/cropperjs.min.js')}}"></script>
<script>

var $modal = $('#modal');
var image = document.getElementById('image');
var cropper;


  
$(".image").on("change", function(e){
    var files = e.target.files;
    var done = function (url) {
      image.src = url;
    //   $modal.modal('show');
      $modal.modal({backdrop: 'static', keyboard: false});
    };
    var reader;
    var file;
    var url;

    if (files && files.length > 0) {
      file = files[0];

      if (URL) {
        done(URL.createObjectURL(file));
      } else if (FileReader) {
        reader = new FileReader();
        reader.onload = function (e) {
          done(reader.result);
        };
        reader.readAsDataURL(file);
      }
    }
});

$modal.on('shown.bs.modal', function () {
    cropper = new Cropper(image, {
        aspectRatio: 1 / 1,
        cropBoxResizable:false,
        viewMode: 1,
        dragMode: 1,
        highlight: true,
        //center: true,
        dragMode: 'move',
        modal: true,
        responsive: true,
        restore: true,
        checkCrossOrigin: true,
        checkOrientation: true,
        autoCrop: true,

        movable: true,
        scalable: true,
        guides: true,
        background: false,
        cropBoxMovable: false,
        cropBoxResizable: false,
        toggleDragModeOnDblclick: false,
        preview: '.preview'
    });
}).on('hidden.bs.modal', function () {
   cropper.destroy();
   cropper = null;
});

$("#crop").click(function(){
    canvas = cropper.getCroppedCanvas({
      width: 160,
      height: 160,
    });

    canvas.toBlob(function(blob) {
        url = URL.createObjectURL(blob);
        var reader = new FileReader();
         reader.readAsDataURL(blob); 
         reader.onloadend = function() {
            var base64data = reader.result;  
            
            console.log(base64data);
            // $.ajax({
            //     type: "POST",
            //     dataType: "json",
            //     url: "upload.php",
            //     data: {image: base64data},
            //     success: function(data){
            //         console.log(data);
            //         $modal.modal('hide');
            //         alert("success upload image");
            //     }
            //   });
         }
    });
})

</script>
@endsection