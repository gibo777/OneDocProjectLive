<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use Storage;
  
class WebcamController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        return view('utilities/webcam');
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function store(Request $request)
    {
        $img = $request->image;
        $folderPath = "profile-photos/";
        // dd($folderPath);
        
        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        
        $image_base64 = base64_decode($image_parts[1]);
        // $fileName = generateRandomString(40) . '.png';
        $fileName = $this->generateRandomString(40) . '.jpg';
        
        $file = $folderPath . $fileName;
        // dd($file);

        Storage::put($file, $image_base64);

        $webcamPhotoLocation = asset("storage/".$file);
// dd($webcamPhotoLocation);
        return $webcamPhotoLocation;
        // dd($webcamPhotoLocation);
        
        // dd('Image uploaded successfully: '.$fileName);
    }

    function generateRandomString($length = 13) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}