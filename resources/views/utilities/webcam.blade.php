
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" /> -->
    <style type="text/css">
        /*#results { padding:1px;solid; }*/
    </style>



<div class="container">
    <!-- <h1 class="text-center">Laravel webcam capture image and save from camera - ItSolutionStuff.com</h1> -->
     
    <form method="POST" action="{{ route('webcam.capture') }}">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div id="my_camera"></div>
                <input type="hidden" name="image" class="image-tag text-center rounded-md">
            </div>
            <div class="col-md-6 text-center">
                <div id="results" class="hidden rounded-md"></div>
            </div>
        </div>
        <div class="row pt-2">
            <div class="col-md-12 text-center">
                <input type="button" value="Take Snapshot" onClick="take_snapshot()" class="btn btn-primary ">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <!-- <br/> -->
                <x-jet-button>{{ __('Save') }}
                </x-jet-button>
                <!-- <button class="btn btn-success">Submit</button> -->
            </div>
        </div>

    </form>
</div>

<script type="text/javascript">
    
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('webcam.capture') }}",
            method: 'get',
            success:function(data){
                $("#modalWebCam").modal("show");
            }
        });

</script>
