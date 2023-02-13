<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\PDFController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Arr;

class PageController extends Controller {

   public function index(){
      return view('/test/index');
   }

   public function uploadFile(Request $request){
    // return var_dump($request->all());
   		// return $request->file('file')->getSize();
    // return $request->file('file');

      $data = array();

      $validator = Validator::make($request->all(), [
         'file' => 'required|mimes:png,jpg,jpeg,csv,txt,pdf,docx,doc,gif|max:2048'
      ]);

      if ($validator->fails()) {

         $data['success'] = 0;
         $data['error'] = $validator->errors()->first('file');// Error response

      }else{
         if($request->file('file')) {

             $file = $request->file('file');

             // $filename = time().'_'.$file->getClientOriginalName();
             $filename = date('Ymd').'_'.Auth::user()->employee_id.'_new-memo.'.$file->getClientOriginalExtension();
             // if ($file->getClientOriginalExtension()=='doc') {
             // 	$filename = 'memo.docx';
             // }
             $newfilename = date('Ymd').'_'.Auth::user()->employee_id.'_new-memo.pdf';

             // File extension
             $extension = $file->getClientOriginalExtension();

             // File upload location
             $location = 'files';

             $this->encryptFile($request->file('file'), public_path('tmp/'.$filename), config('app.key'));

             // Upload file
	        //Store File in Storage Folder
	        // $request->file->storeAs('uploads', $filename);//uncomment if this is the storage location
	        // storage/app/uploads/file.png
	   
			// Store File in S3 ( AWS Simple Storage Service )
			// $request->file->storeAs('uploads', $filename, 's3');//uncomment if this is the storage location

             // $uploadedfile = $file->move(public_path('tmp'),$filename);
             // $newfile = public_path('storage/tmp/sample.pdf');

             
             // File path
          //    $filepath = url(public_path('tmp/'.$filename));
             
          //    if ($extension=='png' || $extension=='jpg' || $extension=='jpeg'){
          //    	$convertImage = new PDFController;
          //    	$convertImage->convertImagesToPDF($filename,$newfilename, public_path('tmp/'));
          //    }
          //    if ($extension=='docx'){
          //    	$convert = new PDFController;
          //    	$convert->convertWordToPDF($filename,$newfilename,public_path('tmp/'));
	         // }

/*===============================*/

        /*$fileName = $_FILES['userfile']['name'];
        $tmpName  = $_FILES['userfile']['tmp_name'];
        $fileSize = $_FILES['userfile']['size'];
        $fileType = $_FILES['userfile']['type'];
        $fileType=mysqli_real_escape_string($con,
        stripslashes ($fileType));
        $fp      = fopen($tmpName, 'r');
        $content = fread($fp, filesize($tmpName));
        $content = addslashes($content);
        fclose($fp);
        $fileName = addslashes($fileName);
        
        if($con){
        $query = "INSERT INTO upload (name, size, type, content ) ".
        "VALUES ('$fileName', '$fileSize', '$fileType', '$content')";
        mysqli_query($con,$query) or die('Error, query failed'); 
        mysqli_close($con);
        header('location:Success.php');
        }
        else { 
         header('location:../View/View.php');   
        }*/
/*========================================*/

             // Response
             $data['success'] = 1;
             $data['message'] = 'Uploaded Successfully!';
             $data['filepath'] = $filepath;
             $data['extension'] = $extension;
             $data['uploaded_file'] = $uploadedfile;
             // return $uploadedfile;
         }else{
             // Response
             $data['success'] = 2;
             $data['message'] = 'File not uploaded.'; 
         }
      }
      // return response()->json($data);
   }


   public function tmp_preview_memo (Request $request){
    // return var_dump($request->all());
        // return $request->file('file')->getSize();
    // return $request->file('file');

      $data = array();

      $validator = Validator::make($request->all(), [
         'file' => 'required|mimes:png,jpg,jpeg,csv,txt,pdf,docx,doc,gif|max:4096'
      ]);

      if ($validator->fails()) {

         $data['success'] = 0;
         $data['error'] = $validator->errors()->first('file');// Error response

      }else{
         if($request->file('file')) {

             $file = $request->file('file');

             // $filename = time().'_'.$file->getClientOriginalName();
             $filename = date('Ymd').'_'.Auth::user()->employee_id.'_new-memo.'.$file->getClientOriginalExtension();
             // if ($file->getClientOriginalExtension()=='doc') {
             //     $filename = 'memo.docx';
             // }
             $newfilename = date('Ymd').'_'.Auth::user()->employee_id.'_new-memo.pdf';

             // File extension
             $extension = $file->getClientOriginalExtension();

             // File upload location
             $location = 'files';

             // $this->encryptFile($request->file('file'), public_path('tmp/'.$filename), config('app.key'));

             // Upload file
            //Store File in Storage Folder
            // $request->file->storeAs('uploads', $filename);//uncomment if this is the storage location
            // storage/app/uploads/file.png
       
            // Store File in S3 ( AWS Simple Storage Service )
            // $request->file->storeAs('uploads', $filename, 's3');//uncomment if this is the storage location

             $uploadedfile = $file->move(public_path('tmp'),$filename);
             // $newfile = public_path('storage/tmp/sample.pdf');

             
             // File path
          //    $filepath = url(public_path('tmp/'.$filename));
             
             if ($extension=='png' || $extension=='jpg' || $extension=='jpeg'){
                 $convertImage = new PDFController;
                 $convertImage->convertImagesToPDF(public_path('tmp/'.$filename), public_path('tmp/'.$newfilename));
             }
             if ($extension=='docx'){
                 $convert = new PDFController;
                 $convert->convertWordToPDF(public_path('tmp/'.$filename), public_path('tmp/'.$newfilename));
             }


/*===============================*/

        /*$fileName = $_FILES['userfile']['name'];
        $tmpName  = $_FILES['userfile']['tmp_name'];
        $fileSize = $_FILES['userfile']['size'];
        $fileType = $_FILES['userfile']['type'];
        $fileType=mysqli_real_escape_string($con,
        stripslashes ($fileType));
        $fp      = fopen($tmpName, 'r');
        $content = fread($fp, filesize($tmpName));
        $content = addslashes($content);
        fclose($fp);
        $fileName = addslashes($fileName);
        
        if($con){
        $query = "INSERT INTO upload (name, size, type, content ) ".
        "VALUES ('$fileName', '$fileSize', '$fileType', '$content')";
        mysqli_query($con,$query) or die('Error, query failed'); 
        mysqli_close($con);
        header('location:Success.php');
        }
        else { 
         header('location:../View/View.php');   
        }*/
/*========================================*/

             // // Response
             // $data['success'] = 1;
             // $data['message'] = 'Uploaded Successfully!';
             // $data['filepath'] = $filepath;
             // $data['extension'] = $extension;
             // $data['uploaded_file'] = $uploadedfile;
             // // return $uploadedfile;
         }/*else{
             // Response
             $data['success'] = 2;
             $data['message'] = 'File not uploaded.'; 
         }*/
      }
      // return response()->json($data);
   }
    public function preview_memo (Request $request) {

        $path = public_path('tmp\*');

        $latest_ctime = 0;
        $latest_filename = '';

        $files = glob($path);
        // return var_dump($files);

        foreach($files as $file)
        {
            switch (pathinfo($file,PATHINFO_EXTENSION)) {
                case 'pdf': case 'gif': case 'jpg': case 'jpeg': case 'png':
                        if (is_file($file) && filectime($file) > $latest_ctime)
                        {
                                $latest_ctime = filectime($file);
                                $latest_filename = $file;
                                // echo $latest_ctime.'|'.$latest_filename.',';
                        }
                    break;
                
                default:
                    # code...
                    break;
            }
        }
        return asset('tmp/'.Arr::last(explode('\\', $latest_filename)));

        /*$files = scandir(public_path('tmp'), SCANDIR_SORT_DESCENDING);
        return var_dump($files);
        $newest_file = $files[0];

        return asset('tmp/'.$newest_file);*/
    }

    public function view_memo(Request $request) {
        // return var_dump($request->all());
        // $file = explode("/",($request->file_path));
        // return var_dump($file);

        $file = pathinfo($request->file_path);
        // return $file['basename'];
        // $dest = public_path('tmp/'.Auth::user()->employee_id.'_'.$file['basename']);
        // $this->decryptFile($request->file_path, $dest , config('app.key'));

        $this->decryptFile($request->file_path, public_path('tmp/'.$file['basename']), config('app.key'));

        return asset('tmp/'.$file['basename']);
    }


    public function remove_tmp_memo (Request $request) {

        $path = public_path('tmp\*');

        $latest_ctime = 0;
        $latest_filename = '';

        $files = glob($path);
        // return var_dump($files);

        // return var_dump($files);

        foreach($files as $file) {
            unlink($file);
        //     switch (pathinfo($file,PATHINFO_EXTENSION)) {
        //         case 'pdf': case 'gif':
        //                 if (is_file($file) && filectime($file) > $latest_ctime)
        //                 {
        //                         $latest_ctime = filectime($file);
        //                         $latest_filename = $file;
        //                         // echo $latest_ctime.'|'.$latest_filename.',';
        //                 }
        //             break;
                
        //         default:
        //             # code...
        //             break;
        //     }
        }
        // return asset('tmp/'.Arr::last(explode('\\', $latest_filename)));

        /*$files = scandir(public_path('tmp'), SCANDIR_SORT_DESCENDING);
        return var_dump($files);
        $newest_file = $files[0];

        return asset('tmp/'.$newest_file);*/
    }



   public function send_mail () {
        // \Mail::to('glretiro.1doc@gmail.com')->send(new \App\Mail\SendMail($details));

        $data = array(
        'name'=> 'Gibs',
        'email'=> env('MAIL_FROM_ADDRESS'),
        'title' => 'Gibs Testing Send Email',
        'body'=> 'This is for testing email.',
        'category'=> 'Internal Memo',
        'company'=> env('APP_NAME')/*,
        'number'=> $request->number*/
        );
        // return var_dump($data);
        // $files = $request->file('files');

        $files = [
            public_path('storage/memo-files/memo_g_7777-7777_20220830093218.pdf'),
            public_path('img/company/onedoc-logo.jpg')
        ];
        \Mail::send('utilities/send-mail', compact('data'), function ($message) use($data, $files){    
            $message->from($data['email']);
            $message->to($data['email'])->subject($data['company'] . ' - ' .$data['category']);

            if(count($files) > 0) {
                foreach($files as $file) {
                    $message->attach( str_replace('\\','/',$file) );
                }
            }
        });
        // dd("Email is Sent.");
   }

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

    function decryptFile($source, $dest, $key)
    {
        // $cipher = 'aes-256-cbc';
        $ivLenght = openssl_cipher_iv_length(config('app.cipher'));

        $fpSource = fopen($source, 'rb');
        $fpDest = fopen($dest, 'w');

        $iv = fread($fpSource, $ivLenght);

        while (! feof($fpSource)) {
            $ciphertext = fread($fpSource, $ivLenght * (config('app.file_encryption_blocks') + 1));
            $plaintext = openssl_decrypt($ciphertext, config('app.cipher'), $key, OPENSSL_RAW_DATA, $iv);
            $iv = substr($plaintext, 0, $ivLenght);

            fwrite($fpDest, $plaintext);
        }

        fclose($fpSource);
        fclose($fpDest);
    }


}