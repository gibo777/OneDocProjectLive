{{-- <!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.min.css">

<!-- jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- SweetAlert2 library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.min.js"></script> --}}

<x-app-layout>

    <x-slot name="header">
            {{ __('TIME-LOGS IMAGE CAPTURE') }}
    </x-slot>
    <div>
		<div id="image-capture-container">
		  <video id="video-element"></video>
		  <canvas id="canvas-element"></canvas>
		  <button id="capture-btn">Capture</button>
		</div>
	</div>
</x-app-layout>

<script type="text/javascript">
	$(document).ready(function() {
  // Variables for video element, canvas, and media stream
  var video = document.getElementById('video-element');
  var canvas = document.getElementById('canvas-element');
  var stream = null;

  // Function to start the webcam
  function startWebcam() {
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
    if (stream !== null) {
      // Pause the video playback
      video.pause();

      // Draw the current video frame onto the canvas
      var context = canvas.getContext('2d');
      canvas.width = video.videoWidth;
      canvas.height = video.videoHeight;
      context.drawImage(video, 0, 0, canvas.width, canvas.height);

      // Convert the canvas image to a data URL
      var dataURL = canvas.toDataURL('image/png');


      // prompt('',dataURL);

      // Display the captured image using Swal
      Swal.fire({
        title: 'Captured Image',
        imageUrl: dataURL,
        imageAlt: 'Captured Image',
        showCancelButton: true,
        cancelButtonText: 'Close',
        confirmButtonText: 'Save',
      }).then(function(result) {
        if (result.isConfirmed) {
          // Handle saving the image (e.g., send to server, download, etc.)
          // You can perform your desired action here
          // ...
          // Display a success message using Swal
          Swal.fire({
            icon: 'success',
            title: 'Image saved successfully!',
          });
        } else {
          // Resume video playback
          video.play();
        }
      });
    }
  }

  // Event handler for the capture button
  $('#capture-btn').click(function() {
    captureImage();
  });

  // Start the webcam when the page loads
});

</script>