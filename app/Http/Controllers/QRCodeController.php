<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
// use QrCode;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
// use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use ZipArchive;

use Illuminate\Support\Facades\DB;

class QRCodeController extends Controller
{
    /**
     * Generate QR Code for viewing
     *
     * @return view
     * @author Gilbert L. Retiro
     **/
    public function index(Request $request)
    {
        $userQR = DB::table('users as u')->select( 
            'u.qr_code_link', 'u.employee_id',
            DB::raw('CONCAT(u.last_name, 
                (CASE WHEN u.suffix IS NOT NULL THEN CONCAT(", ", u.suffix, ", ") ELSE ", " END), 
                u.first_name,
                (CASE WHEN u.middle_name IS NOT NULL THEN CONCAT(" ", SUBSTRING(u.middle_name, 1, 1)) ELSE " " END)
            ) AS full_name')
        )
        ->where('u.id',$request->id)->first();

        // return $userQR->qr_code_link;


        // $fullName = join(' ',[$userQR->last_name.' '.$userQR->suffix.',',$userQR->first_name,$userQR->middle_name]);
        return view('modals/qr_code', ['qrLink'=>$userQR->employee_id, 'fullName'=>$userQR->full_name]);
    }

    /**
     * View Details of Employee using QR Link
     *
     * @return view
     * @author Gilbert L. Retiro
     **/
    public function qrCodeProfile($qrLink) {
        // Your code to handle the $qrLink parameter goes here
        $qrProfile = DB::table('users as u')
            ->select(
                'u.*', 
                DB::raw("DATE_FORMAT(u.date_hired, '%m/%d/%Y') as date_hired"),
                DB::raw("DATE_FORMAT(u.birthdate, '%m/%d/%Y') as birthday"),
                'p.country_name')
            ->leftJoin('provinces as p','u.country','=','p.country_code')
            ->where('u.employee_id',$qrLink)
            ->first();

        // For example, you can return a view with the $qrLink variable
        return view('profile/qr-code-profile', ['qrProfile' => $qrProfile]);
    }

    public function downloadMultipleQRCodes()
	{

        $qrLinks = DB::table('users')
        ->select([
            // DB::raw("CONCAT(last_name, ', ', first_name, ' ', middle_name) as full_name"),
            DB::raw("CONCAT(last_name, (CASE WHEN suffix IS NOT NULL AND suffix <> '' THEN CONCAT(' ',suffix, ', ') ELSE ', ' END), first_name, (CASE WHEN middle_name IS NOT NULL THEN CONCAT(' ', SUBSTRING(middle_name, 1, 1)) ELSE '' END)) as full_name"),
            DB::raw("NOW() as today"),
            'qr_code_link',
            'employee_id'
        ])
        ->orderBy('full_name')
        // ->limit(10) // Limit for testing only
        ->get();

        // dd($qrLinks);

        // Create a directory to store the QR codes
        $storagePath = public_path('storage/qrcodes');

        if (!File::isDirectory($storagePath)) {
            File::makeDirectory($storagePath, 0755, true);
        }

        // Loop through each QR code link and generate QR codes
        foreach ($qrLinks as $link) {
            // Generate the QR code image
            $qrCode = QrCode::format('png')
            ->size(300)
            ->margin(5)
            ->generate(url('/emp-val').'/'.$link->employee_id);

            // Define the file name for the QR code
            $fileName = $link->full_name . '.png';

            // Save the QR code image to the storage directory
            $qrCodePath = $storagePath . '/' . $fileName;
            file_put_contents($qrCodePath, $qrCode);
        }

 
        // Create a ZIP archive and add the QR code files to it
        $zip = new ZipArchive;
        $zipFileName = $storagePath.'/qr_codes.zip';

        if ($zip->open($zipFileName, ZipArchive::CREATE) === true) {
            foreach ($qrLinks as $link) {
                $fileName = $link->full_name . '.png';
                $filePath = url('/emp-val').'/'.$link->employee_id;
                $zip->addFile($filePath, $fileName);
            }

            $zip->close();
        }

        /*// Set the appropriate headers to trigger a download
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="qr_codes.zip"');
        header('Content-Length: ' . filesize($zipFileName));

        // Output the file to the browser
        return readfile($zipFileName);*/


        // return $zipFileName;
        // Provide a download link for the ZIP archive
        // return response()->download($zipFileName)->deleteFileAfterSend(true);
        // return '/storage/qrcodes/';
    }
}