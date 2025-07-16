<style>
    .submenu { display: none; }
    .submenu.show { display: block; }
</style>


    <div class="d-flex">
        <div class="text-white p-2" style="width: 250px; min-height: 100vh;">
            <div>
                <h4 class="mb-4 bg-white">
                    <img src="{{ asset('/img/company/onedoc-logo.png') }}" />
                </h4>
            </div>

            <div class="items-center justify-center text-center">
                @if ($timeIn)
                <x-jet-button type="button" disabled>
                    <!-- <i class="fa-regular fa-clock"></i>&nbsp; -->Time-In
                </x-jet-button>
                @else
                <x-jet-button type="button" id="btnTimeIn" name="btnTimeIn">
                    <!-- <i class="fa-regular fa-clock"></i>&nbsp; -->Time-In
                </x-jet-button>
                @endif

                @if ($timeOut)
                <x-jet-button type="button" disabled>
                    <!-- <i class="fa-solid fa-clock"></i>&nbsp; -->Time-Out
                </x-jet-button>
                @else
                <x-jet-button type="button" id="btnTimeOut" name="btnTimeOut">
                    <!-- <i class="fa-solid fa-clock"></i>&nbsp; -->Time-Out
                </x-jet-button>
                @endif
            </div>
            <ul class="nav flex-column font-weight-bold" id="sidebarMenu">
                <li class="nav-item">
                    <a href="#" class="nav-link text-white" onclick="toggleMenu(event, 'homeMenu')">Home</a>
                    <ul class="nav flex-column ms-3 submenu" id="homeMenu">
                        <li class="nav-item"><a href="{{ route('dashboard') }}" class="nav-link text-white">Dashboard</a></li>
                        <li class="nav-item"><a href="#" class="nav-link text-white">Reports</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-white" onclick="toggleMenu(event, 'eformMenu')">E-Leave</a>
                    <ul class="nav flex-column ms-3 submenu" id="eformMenu">
                        <li class="nav-item"><a href="{{ route('hris.leave.eleave') }}" class="nav-link text-white">E-Leave Form</a></li>
                        <li class="nav-item"><a href="{{ route('eforms.leaves-listing') }}" class="nav-link text-white">View Leaves</a></li>
                        <li class="nav-item"><a href="{{ route('calendar') }}" class="nav-link text-white">Leave Calendar</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-white" onclick="toggleMenu(event, 'recMgtMenu')">Records Management</a>
                    <ul class="nav flex-column ms-3 submenu" id="recMgtMenu">
                        <li class="nav-item"><a href="{{ route('hr.management.employees') }}" class="nav-link text-white">Employee Management</a></li>
                        <li class="nav-item"><a href="{{ route('timelogs-listing') }}" class="nav-link text-white">Timekeeping</a></li>
                        <li class="nav-item"><a href="{{ route('attendance-monitoring') }}" class="nav-link text-white">Attendance Monitoring</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-white" onclick="toggleMenu(event, 'profileMenu')">Profile</a>
                    <ul class="nav flex-column ms-3 submenu" id="profileMenu">
                        <li class="nav-item"><a href="{{ route('profile.show') }}" class="nav-link text-white">View Profile</a></li>
                        <!-- <li class="nav-item"><a href="#" class="nav-link text-white">Edit Profile</a></li> -->
                    </ul>
                </li>
                <!-- <li class="nav-item"><a href="" class="nav-link text-white">Settings</a></li> -->

                <li class="nav-item">
                    <a href="#" class="nav-link text-white" onclick="toggleMenu(event, 'setupMenu')">Set-Up</a>
                    <ul class="nav flex-column ms-3 submenu" id="setupMenu">
                        <li class="nav-item"><a href="{{ route('hr.management.offices') }}" class="nav-link text-white">Offices</a></li>
                        <li class="nav-item"><a href="{{ route('hr.management.departments') }}" class="nav-link text-white">Departments</a></li>
                        <li class="nav-item"><a href="{{ route('employee-benefits') }}" class="nav-link text-white">Benefits</a></li>
                        <li class="nav-item"><a href="{{ route('hr.management.offices') }}" class="nav-link text-white">Offices</a></li>
                        <li class="nav-item"><a href="{{ route('authorize.user.list') }}" class="nav-link text-white">User Authorization</a></li>
                        <li class="nav-item"><a href="{{ route('server-status') }}" class="nav-link text-white">Server Status</a></li>

                          <!-- <a id="navServerStatus" href="{{ route('server-status') }}" class="dropdown-item hover font-weight-bold {{ $serverStatus ? 'text-success' : 'text-danger' }}">
                              {{ __('Server Status') }}
                          </a> -->
                        <!-- <li class="nav-item"><a href="#" class="nav-link text-white">Edit Profile</a></li> -->
                    </ul>
                </li>
                <li class="nav-item"><a href="" class="nav-link text-white">Logout</a></li>
            </ul>
        </div>



        <!-- <div class="flex-grow-1 p-3">
            <h3>
                <i id="toggleFullMenu" class="fa-solid fa-xmark"></i>
                &nbsp;Home
            </h3>
            <p>This is the main content area.</p>
        </div> -->
    </div>


<!-- MODAL -->
<div class="modal fade" id="modalTimeLogCam" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header banner-blue">
            <h4 class="modal-title text-lg text-white">Capture Image for Timelog</h4>
            <button id="closeLogCamModal" type="button" class="close btn btn-primary fa fa-close" data-bs-dismiss="modal" arial-label="Close"><span aria-hidden="true"></span></button>
        </div>
      <div class="modal-body">
        <!-- content -->
        <div class="container">
            <form id="formWebCam">
                @csrf

                <div id="image-capture-container">
                  <video id="video-element" hidden></video>
                  <canvas id="canvas-element" hidden></canvas>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div id="logCamera"></div>
                        <input type="hidden" name="image" class="image-tag text-center rounded-md">
                    </div>
                    <div class="col-md-6 text-center">
                        <div id="results" class="hidden rounded-md"></div>
                    </div>
                </div>
                <div class="row my-1">
                    <div class="col-md-8 text-justify text-sm font-weight-bold font-italic text-wrap w-100 inset-shadow px-2 my-1">
                      &nbsp;&nbsp;In compliance with company policy, ensure that your picture clearly shows your office location.
                    </div>
                    <div class="col-md-4 d-flex align-items-center justify-content-center">
                        <input id="logEvent" hidden>
                        <input type="button" id="takeSnapshot" value="Take Snapshot" class="btn btn-primary ">
                    </div>
                </div>
            </form>
        </div>

      </div>
    </div>
  </div>
</div>

<!-- Loading Indicator -->
<div id="dataLoad" style="display: none">
    <img src="{{ asset('/img/misc/loading-blue-circle.gif') }}">
</div>

<div id="dataProcess" style="display: none">
    <img src="{{ asset('/img/misc/processing.gif') }}">
</div>


    <script>
        /*function toggleMenu(event, menuId) {
            event.preventDefault();
            document.querySelectorAll('.submenu').forEach(menu => {
                if (menu.id !== menuId) menu.classList.remove('show');
            });
            document.getElementById(menuId).classList.toggle('show');
        }*/



document.addEventListener('DOMContentLoaded', function() {
    let isActive = JSON.parse(document.getElementById('navServerStatus').getAttribute('data-is-active'));
    console.log(isActive); // Logs the current value of isActive
});

$(document).ready(function(){

    let has_supervisor = "{{ Auth::user()->supervisor }}";
    let role_type = "{{ Auth::user()->role_type }}";
    
    $(document).on('click', '#dNavEleave, #dNavOvertime', function(e) {
        if (has_supervisor == '' || has_supervisor == null) {
            Swal.fire({
                icon: 'error',
                title: 'NOTIFICATION',
                html: 'Kindly ask HR for the supervisor to be assigned. <br>Thank you!',
            });
            return false;
        }
    });

    /** This will capture temporary photo using webcam */
    $("#saveTempPhoto").click(function() {

        var data_uri = $("#capturedPhoto").attr("src");
        Webcam.reset( '#logCamera' );

        $('#divPhotoPreview1').addClass('hidden');
        $('#divPhotoPreview2').empty();
        $('#divPhotoPreview2').css('display','flex');
        $('#divPhotoPreview2').append('<span class="block rounded-full w-id h-id bg-cover bg-no-repeat" id="capturedPhoto text-center" style="background-image:url('+data_uri+')"></span>');
        // alert("{{ route('webcam.capture') }}"); return false;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('webcam.capture') }}",
            method: 'post',
            data: $("#formWebCam").serialize(),
            success:function(data){
                $("#modalWebCam").modal("hide");
                // alert(data); return false;
                Webcam.reset( '#logCamera' );
                $("#divPhotoPreview1").addClass("hidden");
                $("#divPhotoPreview2").addClass("hidden");
                $("#divPhotoPreview3").removeClass("hidden");
                $("#profilePhotoPreview").attr("src",data);

                // $("#modalWebCam").modal("show");

            }
        });
        return false;
    });
});


/* TIME-LOGS CAPTURE */

$(document).ready(function() {
  // Variables for video element, canvas, and media stream
  var video = document.getElementById('video-element');
  var canvas = document.getElementById('canvas-element');
  var stream = null;
  let latitude, longitude;

    function getCoordinates(position) {
        latitude = position.coords.latitude.toFixed(7);
        longitude = position.coords.longitude.toFixed(7);
        startWebcam();
    }

    function showError(error) {
        switch(error.code) {
            case error.PERMISSION_DENIED:
                Swal.fire({ html: "User denied the request for Geolocation."});
                break;
            case error.POSITION_UNAVAILABLE:
                Swal.fire({ html: "Location information is unavailable."});
                break;
            case error.TIMEOUT:
                Swal.fire({ html: "The request to get user location timed out."});
                break;
            case error.UNKNOWN_ERROR:
                Swal.fire({ html: "An unknown error occurred."});
                break;
        } return false;
    }

  // Function to start the webcam
  function startWebcam() {

    $("#modalTimeLogCam").modal("show");

    const isMobile = window.innerWidth <= 768;
    const webcamWidth = isMobile ? 320 : 430;
    const webcamHeight = isMobile ? 240 : 350;

    Webcam.set({
        width: webcamWidth,
        height: webcamHeight,
        image_format: 'jpeg',
        jpeg_quality: 90,
        constraints: {
            video: {
                facingMode: "user",
                mirror: true
            }
        }
    });

    Webcam.attach( '#logCamera' );

    // Access the user's webcam
    navigator.mediaDevices.getUserMedia({ video: true })
      .then(function(mediaStream) {
        // Store the media stream for later use
        stream = mediaStream;
        video.srcObject = mediaStream;
        video.play();
      })
      .catch(function(error) {
        // Display an error message using Swal
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Failed to access webcam!',
        });
      });
  }

  // Function to capture an image
  function captureImage() {
    // alert('test'); return false;

    if (stream !== null) {
        // Pause the video playback
        video.pause();

        // Assuming 'video' is the video element and 'canvas' is the canvas element
        var canvas = document.createElement('canvas');
        var context = canvas.getContext('2d');

        // Set the desired percentage for the resized image
        var percentageWidth = 50; // Adjust this value as needed
        var percentageHeight = 50; // Adjust this value as needed

        // Calculate the target dimensions based on the percentages
        var targetWidth = (percentageWidth / 100) * video.videoWidth;
        var targetHeight = (percentageHeight / 100) * video.videoHeight;

        // Set the canvas dimensions to the target dimensions
        canvas.width = targetWidth;
        canvas.height = targetHeight;

        // Draw the current video frame onto the canvas with the resized dimensions
        context.drawImage(video, 0, 0, video.videoWidth, video.videoHeight, 0, 0, targetWidth, targetHeight);

        // Convert the canvas image to a data URL with a desired quality (e.g., 0.8)
        var dataURL = canvas.toDataURL('image/jpeg', 0.8);



      // Display the captured image using Swal
      Swal.fire({
        // title: 'Captured Image',
        imageUrl: dataURL,
        imageAlt: 'Captured Image',
        allowOutsideClick: false,
        showCancelButton: true,
        cancelButtonText: 'Close',
        confirmButtonText: 'Save',
      }).then(function(result) {
        if (result.isConfirmed) {
            $("#modalTimeLogCam").modal("hide");

            /*Swal.fire({ 
              allowOutsideClick: false,
              html: `Event: ${$("#logEvent").val()}<br>Coords: ${latitude},${longitude}`
            }); return false;*/

            $('#dataProcess').css({
                'display': 'flex',
                'position': 'absolute',
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('save.timelogs') }}",
                method: 'post',
                data: {
                  'logEvent'  : $("#logEvent").val(), 
                  'latitude'  : parseFloat(latitude),
                  'longitude' : parseFloat(longitude),
                  'image'     : dataURL
                },
                /*beforeSend: function() {
                    $('#dataLoad').css({
                        'display': 'flex',
                        'position': 'fixed',
                        'top': '50%',
                        'left': '50%',
                        'transform': 'translate(-50%, -50%)'
                    });

                },*/
                success:function(data){
                  $('#dataProcess').hide();
                  if (data.isSuccess==true) {
                      // Display a success message using Swal
                      Swal.fire({
                        icon: 'success',
                        title: 'Image saved successfully!',
                      });
                      video.currentTime = 0;
                      video.style.display = "none";
                      setTimeout(function() {
                        location.reload();
                      }, 5000);

                      $("#btnTimeIn").prop('disabled', true);
                      $("#btnTimeOut").prop('disabled', false);
                    } else {
                      Swal.fire({
                        icon: 'error',
                        title: data.message,
                      });
                    }
                  } 
            });


        } else {
          // Resume video playback
          video.play();
        }
      });
    }
  }


    $('#btnTimeIn').click(function() {
        $("#logEvent").val("TimeIn");
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(getCoordinates, showError);
        }
        else {
          Swal.fire({ html: "Geolocation is not supported by this browser." }); return false;
        }

    });


    $('#btnTimeOut').click(function() {

        $("#logEvent").val("TimeOut");
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(getCoordinates, showError);
        }
        else {
          Swal.fire({ html: "Geolocation is not supported by this browser." });
          location.reload();
        }
    });

    // Capture image for Time Logs
    $('#takeSnapshot').click(function() {
        captureImage();
    });

    // Closing Camera Modal
    $("#closeLogCamModal").click(function() {
      closeCam();
    });

    function closeCam() {
        Webcam.reset( '#logCamera' );
        location.reload();
    }

});


</script>
