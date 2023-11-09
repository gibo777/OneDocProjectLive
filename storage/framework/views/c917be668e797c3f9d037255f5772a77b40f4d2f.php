
            
            

            
            
            <div >
            	<img src="data:image/png;base64, <?php echo base64_encode(QrCode::format('png')->size(140)->generate( url('/qr-code-link').'/'.$qrLink )); ?> ">
		        <a id="downloadLink" href="data:image/png;base64, <?php echo base64_encode(QrCode::format('png')->size(300)->generate( url('/qr-code-link').'/'.$qrLink )); ?> " download="<?php echo e($fullName); ?>.png">Download QR Code</a>
		    </div>

            

            
            	
        <?php /**PATH C:\xampp\OneDocProject\htdocs\OneDocProjectLive\resources\views/modals/qr_code.blade.php ENDPATH**/ ?>