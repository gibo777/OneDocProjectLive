
<?php


// define('FILE_ENCRYPTION_BLOCKS', 10000);

/**
 * @param  $source  Path of the unencrypted file
 * @param  $dest  Path of the encrypted file to created
 * @param  $key  Encryption key
 */
function encryptFile($source, $dest, $key)
{
    // $cipher = 'aes-256-cbc';
    // $ivLenght = openssl_cipher_iv_length($cipher);
    $ivLenght = openssl_cipher_iv_length(config('app.cipher'));
    $iv = openssl_random_pseudo_bytes($ivLenght);

    $fpSource = fopen($source, 'rb');
    $fpDest = fopen($dest, 'w');

    fwrite($fpDest, $iv);
    // return config('app.FILE_ENCRYPTION_BLOCKS');

    while (! feof($fpSource)) {
        $plaintext = fread($fpSource, $ivLenght * config('app.file_encryption_blocks'));
        $ciphertext = openssl_encrypt($plaintext, config('app.cipher'), $key, OPENSSL_RAW_DATA, $iv);
        $iv = substr($ciphertext, 0, $ivLenght);

        fwrite($fpDest, $ciphertext);
    }

    fclose($fpSource);
    fclose($fpDest);
}


encryptFile(public_path("img/original/SSSForms_Change_Request.pdf"), public_path('tmp/encrypted_file.pdf'), config('app.key'));

echo "File encrypted!\n";
echo 'Memory usage: ' . round(memory_get_usage() / 1048576, 2) . "M\n";

?>


<x-app-layout>

<form id="memo-form" action="{{ route('file.preview') }}" method="POST">
@csrf
    <div class="px-2 pt-3">
        <div class="input-group mb-3">

          <div class="custom-file">
            <x-jet-input type="file" class="custom-file-input" id="fileEncrypt" 
            />

            <x-jet-label class="custom-file-label" for="fileEncrypt" value="{{ __('Choose File') }}" />
          </div>
        </div>
    </div>
</form>


</x-app-layout>