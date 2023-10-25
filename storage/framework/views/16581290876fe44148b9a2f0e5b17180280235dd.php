

<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, [] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\AppLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

     <?php $__env->slot('header', null, []); ?> 
            <?php echo e(__('TIME-LOGS IMAGE CAPTURE')); ?>

     <?php $__env->endSlot(); ?>
    <div>
		<div id="image-capture-container">
		  <video id="video-element"></video>
		  <canvas id="canvas-element"></canvas>
		  <button id="capture-btn">Capture</button>
		</div>
	</div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?>

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

</script><?php /**PATH C:\xampp\htdocs\OneDocProjectLive\resources\views/time_logs/time-logs.blade.php ENDPATH**/ ?>