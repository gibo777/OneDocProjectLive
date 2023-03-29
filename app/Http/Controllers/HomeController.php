<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Exception;
use TCPDF;

class HomeController extends Controller
{


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function generateDocx()
    {
        $phpWord = new \PhpOffice\PhpWord\PhpWord();


        $section = $phpWord->addSection();


        $description = "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";


        $section->addImage(asset('/img/company/onedoc-logo.png'));
        $section->addText($description);


        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        try {
            $objWriter->save(storage_path('helloWorld.docx'));
        } catch (Exception $e) {
        }


        return response()->download(storage_path('helloWorld.docx'));
    }

    public function createPDF(Request $request)
    {
        // set certificate file
        $certificate = 'file://'.base_path().'/public/tcpdf.crt';

        // set additional information in the signature
        $info = array(
            'Name' => 'TCPDF',
            'Location' => 'Office',
            'Reason' => 'Testing TCPDF',
            'ContactInfo' => 'http://www.tcpdf.org',
        );

        // set document signature
        TCPDF::setSignature($certificate, $certificate, 'tcpdfdemo', '', 2, $info);

        TCPDF::SetFont('helvetica', '', 12);
        TCPDF::SetTitle('Hello World');
        TCPDF::AddPage();

        // print a line of text
        $text = view('tcpdf');

        // add view content
        TCPDF::writeHTML($text, true, 0, true, 0);

        // add image for signature
        TCPDF::Image('tcpdf.png', 180, 60, 15, 15, 'PNG');

        // define active area for signature appearance
        TCPDF::setSignatureAppearance(180, 60, 15, 15);

        // save pdf file
        TCPDF::Output(public_path('hello_world.pdf'), 'F');

        TCPDF::reset();

        dd('pdf created');
        define('FILE_ENCRYPTION_BLOCKS', 10000);
        
    }
    

   

    /**
     * @param  $source  Path of the unencrypted file
     * @param  $dest  Path of the encrypted file to created
     * @param  $key  Encryption key
     */
    function encryptFile($source, $dest, $key)
    {
        $cipher = 'aes-256-cbc';
        $ivLenght = openssl_cipher_iv_length($cipher);
        $iv = openssl_random_pseudo_bytes($ivLenght);

        $fpSource = fopen($source, 'rb');
        $fpDest = fopen($dest, 'w');

        fwrite($fpDest, $iv);

        while (! feof($fpSource)) {
            $plaintext = fread($fpSource, $ivLenght * FILE_ENCRYPTION_BLOCKS);
            $ciphertext = openssl_encrypt($plaintext, $cipher, $key, OPENSSL_RAW_DATA, $iv);
            $iv = substr($ciphertext, 0, $ivLenght);

            fwrite($fpDest, $ciphertext);
        }

        fclose($fpSource);
        fclose($fpDest);
    }
}