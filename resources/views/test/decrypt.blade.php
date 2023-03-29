<?php

define('FILE_ENCRYPTION_BLOCKS', 10000);

function decryptFile($source, $dest, $key)
{
    $cipher = 'aes-256-cbc';
    $ivLenght = openssl_cipher_iv_length($cipher);

    $fpSource = fopen($source, 'rb');
    $fpDest = fopen($dest, 'w');

    $iv = fread($fpSource, $ivLenght);

    while (! feof($fpSource)) {
        $ciphertext = fread($fpSource, $ivLenght * (FILE_ENCRYPTION_BLOCKS + 1));
        $plaintext = openssl_decrypt($ciphertext, $cipher, $key, OPENSSL_RAW_DATA, $iv);
        $iv = substr($plaintext, 0, $ivLenght);

        fwrite($fpDest, $plaintext);
    }

    fclose($fpSource);
    fclose($fpDest);
}


decryptFile(public_path('storage/memo-files/memo_g_7777-7777_20220817144710.pdf'), public_path('tmp/memo_g_7777-7777_20220817144710.pdf'), config('app.key'));

?>
<iframe src="{{ asset('tmp/decrypted_file.pdf') }}" style="width: 75%; height: 100%;" scrollable />