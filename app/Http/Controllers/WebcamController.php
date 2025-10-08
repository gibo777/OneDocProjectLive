<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\TimeLogs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Http\Response;
use Carbon\Carbon;


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

        Storage::put($file, $image_base64);

        $webcamPhotoLocation = asset("storage/" . $file);

        return $webcamPhotoLocation;
        // dd($webcamPhotoLocation);

        // dd('Image uploaded successfully: '.$fileName);
    }

    function generateRandomString($length = 13)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function timeLogs(Request $reqeust)
    {
        return view('time_logs/time-logs');
    }

    protected function checkTimeLogExists($empId, $curDate)
    {
        $logDate = $curDate->format('Y-m-d');
        $checkExists = DB::table('time_logs_header')
            ->where('employee_id', $empId)
            ->where('log_date', $logDate)
            ->exists();

        return $checkExists ? 1 : 0;
    }

    function saveTimeLogs(Request $request)
    {
        // return var_dump($request->all());
        // return $request->ip();
        try {
            $curDate = Carbon::now('Asia/Manila');
            $exists = $this->checkTimeLogExists(Auth::user()->employee_id, $curDate);
            $empID = Auth::user()->employee_id;

            \Log::channel('timelogs')->info("Emp.#: {$empID} | Log: {$request->logEvent} | Date: {$curDate} | Received latitude: {$request->latitude}, longitude: {$request->longitude}");

            if ($exists) { // If exist, new time log will only update time_in (if NULL) /time_out (latest)
                // return "Log Date Exists...";
                $updateLog = DB::table('time_logs_header');
                if ($request->logEvent == 'TimeIn') {
                    $updateLog->where('employee_id', Auth::user()->employee_id)
                        ->where('log_date', $curDate->format('Y-m-d'))
                        ->whereNull('time_in')
                        ->update([
                            'time_in' => $curDate->format('H:i:s'),
                            'updated_at' => $curDate
                        ]);
                } else {
                    $updateLog->where('employee_id', Auth::user()->employee_id)
                        ->where('log_date', $curDate->format('Y-m-d'))
                        ->update([
                            'time_out' => $curDate->format('H:i:s'),
                            'updated_at' => $curDate
                        ]);
                }
                $logId = DB::table('time_logs_header')
                    ->select('id')
                    ->where('employee_id', Auth::user()->employee_id)
                    ->whereDate('log_date', $curDate->format('Y-m-d'))->first();

                ($logId) ? $logId = $logId->id : $logId = null;
            } else { // Insert new header for time logs if not existing yet.
                // return "New Log Date...";
                $supervisor = DB::table('users')
                    ->where('employee_id', Auth::user()->supervisor)
                    ->first();

                $header = [
                    'full_name'     => Auth::user()->last_name
                        . (empty(Auth::user()->suffix) ? ', ' : ' ' . Auth::user()->suffix . ', ')
                        . Auth::user()->first_name
                        . (empty(Auth::user()->middle_name) ? '' : ' ' . Auth::user()->middle_name),
                    'employee_id'   => Auth::user()->employee_id,
                    'office'        => Auth::user()->office,
                    'department'    => Auth::user()->department,
                    'supervisor'    => $supervisor ? $supervisor->last_name
                        . (empty($supervisor->suffix) ? ', ' : ' ' . $supervisor->suffix . ', ')
                        . $supervisor->first_name
                        . (empty($supervisor->middle_name) ? '' : ' ' . $supervisor->middle_name)
                        : '',
                    'log_date'      => $curDate->format('Y-m-d'),
                    'created_at'    => $curDate,
                    'updated_at'    => $curDate
                ];

                if ($request->logEvent == 'TimeIn') {
                    $header['time_in'] = $curDate->format('H:i:s');
                } else {
                    $header['time_out'] = $curDate->format('H:i:s');
                }

                $logId = DB::table('time_logs_header')->insertGetId($header);
            }

            // return $logId;
            // return response(['isSuccess' => true,'message'=>$logId]);


            // $ip = request()->server('SERVER_ADDR');
            // $details = GeoLocation::lookup($ip);
            $storagePath = public_path('storage/timelogs');

            if (!File::isDirectory($storagePath)) {
                File::makeDirectory($storagePath, 0755, true);
            }

            $now = now()->format('Ymd');
            $fileName = Auth::user()->id . '_' . $now . substr(md5(uniqid('', true)), 0, 12);
            $file = $fileName . '.txt';

            $image = $request->image;
            $uploadStorage = Storage::disk('public')->put('/timelogs/' . $file, $image);


            // return $request->latitude.','.$request->longitude;
            // \Log::channel('hris-api-timelogs')->info("Latitude: {$request->latitude}, Longitude: {$request->longitude}");

            $data = [
                'ref_id'                => $logId,
                'employee_id'           => Auth::user()->employee_id,
                // 'profile_photo_path'    => $request->image,
                'image_path'            => $fileName,
                'ip_address'            => $request->ip(),
                // 'ip_address_server'     => $details->getIp(),
                'office'                => Auth::user()->office,
                'department'            => Auth::user()->department,
                'supervisor'            => Auth::user()->supervisor,
                'latitude'              => (float) $request->latitude,
                'longitude'             => (float) $request->longitude,
                // 'country_name' => ,
                // 'country_code' => ,
                // 'region_name' => ,
                // 'region_code' => ,
                // 'city_name' => ,
                // 'zip_code' => ,
                'created_at'            => now(),
                'updated_at'            => now()
            ];

            if ($request->logEvent == 'TimeIn') {
                $data['time_in'] = now();
            } else {
                $data['time_out'] = now();
            }
            // return var_dump($data);
            $id = DB::table('time_logs')->insertGetId($data);
            if ($id) {
                return response(['isSuccess' => true, 'tID' => $id, 'message' => 'Timelog Successful!']);
            } else {
                return response(['isSuccess' => false, 'message' => 'Timelog Failed!']);
            }
        } catch (\Error $e) {
            return response(['isSuccess' => false, 'message' => $e]);
        }
    }

    function createNewImagePath()
    {
        try {
            $storagePath = public_path('storage/timelogs');

            if (!File::isDirectory($storagePath)) {
                File::makeDirectory($storagePath, 0755, true);
            }

            $batchSize = 100; // You can adjust this value based on your needs

            DB::table('time_logs as t')
                ->select('u.id as uID', 't.id', 't.profile_photo_path')
                ->leftJoin('users as u', 't.employee_id', '=', 'u.employee_id')
                ->where(function ($query) {
                    $query->where('t.image_path', null)
                        ->orWhere('t.image_path', '');
                })
                ->orderBy('t.id')->take(500)
                ->chunk($batchSize, function ($userTimeLogs) use ($storagePath) {
                    foreach ($userTimeLogs as $value) {
                        $fileName = $value->uID . '_' . substr(md5(uniqid('', true)), 0, 12);
                        $file = $fileName . '.txt';

                        echo "[ ID: $value->uID ] [ File Name: $fileName] ";
                        echo "[ File Name: " . $fileName . " ] [ File: " . $file . " ] ";

                        $updateImagePath = DB::table('time_logs')
                            ->where('id', $value->id)
                            ->update(['image_path' => $fileName]);

                        if ($updateImagePath) {
                            $image = $value->profile_photo_path;


                            // Assuming $base64Image contains your base64-encoded image string
                            $base64Image = $value->profile_photo_path;

                            // Extract the image data
                            list($type, $data) = explode(';', $base64Image);
                            list(, $data) = explode(',', $data);

                            // Decode the base64 image data
                            $decodedImage = base64_decode($data);

                            // Set the percentage for resizing
                            $percentage = 50; // 50% of the original dimensions

                            // Create a new image from the decoded data
                            $sourceImage = imagecreatefromstring($decodedImage);

                            // Get the original dimensions
                            $sourceWidth = imagesx($sourceImage);
                            $sourceHeight = imagesy($sourceImage);

                            // Calculate the new dimensions based on the percentage
                            $targetWidth = $sourceWidth * ($percentage / 100);
                            $targetHeight = $sourceHeight * ($percentage / 100);

                            // Create a new image with the new dimensions
                            $resizedImage = imagecreatetruecolor($targetWidth, $targetHeight);

                            // Resize the image
                            imagecopyresampled($resizedImage, $sourceImage, 0, 0, 0, 0, $targetWidth, $targetHeight, $sourceWidth, $sourceHeight);

                            // Output the resized image as base64
                            ob_start();
                            imagejpeg($resizedImage, null, 80);
                            $resizedImageData = ob_get_clean();
                            $resizedBase64Image = 'data:image/jpeg;base64,' . base64_encode($resizedImageData);

                            // Now $resizedBase64Image contains the resized image in base64 format
                            // echo $resizedBase64Image;

                            $uploadStorage = Storage::disk('public')->put('/timelogs/' . $file, $resizedBase64Image);
                            echo "[ Status: Success ]<br>=====<br>";
                        }
                    }
                });

            return response(['isSuccess' => true, 'message' => 'Successfully Logged!']);
        } catch (\Error $e) {
            return response(['isSuccess' => false, 'message' => $e]);
        }
    }
}
