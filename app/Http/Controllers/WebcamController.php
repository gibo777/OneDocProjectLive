<?php
    
namespace App\Http\Controllers;

use Auth;
use App\Models\TimeLogs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Http\Response;
use Storage;

use Adrianorosa\GeoLocation\GeoLocation;
  
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

    function timeLogs(Request $reqeust) {
        return view('time_logs/time-logs');
    }

    function saveTimeLogs (Request $request) {
        // return $request->ip();
        try{
            // $ip = request()->server('SERVER_ADDR');
            // $details = GeoLocation::lookup($ip);

            $data = [
                'employee_id'           => Auth::user()->employee_id, 
                'profile_photo_path'    => $request->image,
                'ip_address'            => $request->ip(),
                'ip_address_server'     => $details->getIp(),
                'office'                => Auth::user()->office,
                'department'            => Auth::user()->department,
                'supervisor'            => Auth::user()->supervisor,
                // 'latitude' => ,
                // 'longitude' => ,
                // 'country_name' => ,
                // 'country_code' => ,
                // 'region_name' => ,
                // 'region_code' => ,
                // 'city_name' => ,
                // 'zip_code' => ,
                'created_at'            => date('Y-m-d H:i:s'),
                'updated_at'            => date('Y-m-d H:i:s')
            ];

            if ($request->logEvent=='TimeIn') {
                $data['time_in'] = date('Y-m-d H:i:s');
            } else {
                $data['time_out'] = date('Y-m-d H:i:s');
            }
            // return var_dump($data);
            DB::table('time_logs')->insert($data);

            return response(['isSuccess' => true,'message'=>'Successfully Logged!']);

        }catch(\Error $e){
            return response(['isSuccess'=>false,'message'=>$e]);
        }
    }
}