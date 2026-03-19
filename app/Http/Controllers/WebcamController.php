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

    /**
     * Resolve timezone, country name, and country code from GPS coordinates.
     *
     * Strategy (in order of preference):
     *   1. timezonedb.com API — returns timezone + country in one call.
     *      Add to .env:                TIMEZONEDB_KEY=your_key_here
     *                                  TIMEZONEDB_URL=https://api.timezonedb.com/v2.1/get-time-zone
     *      Add to config/services.php: 'timezonedb_key' => env('TIMEZONEDB_KEY', ''),
     *                                  'timezonedb_url' => env('TIMEZONEDB_URL', ''),
     *
     *   2. BigDataCloud reverse geocode (no API key required).
     *      Timezone is estimated from longitude math since free tier omits it.
     *
     *   3. Longitude-based UTC offset math → nearest PHP timezone.
     *      Zero dependencies, no network call, cannot determine country.
     *
     *   4. Hard fallback: Asia/Manila, Philippines, PH.
     *
     * @param  float|null  $latitude
     * @param  float|null  $longitude
     * @return array{ timezone: string, country_name: string|null, country_code: string|null }
     */
    private function getGeoInfoFromCoords($latitude, $longitude): array
    {
        $fallback = [
            'timezone'     => 'Asia/Manila',
            'tz_abbr'      => 'PST',
            'country_name' => 'Philippines',
            'country_code' => 'PH',
        ];

        // No coordinates provided — use server default.
        if (is_null($latitude) || is_null($longitude)) {
            return $fallback;
        }

        // --- Strategy 1: timezonedb.com API (timezone + country in one request) ---
        $apiKey  = config('services.timezonedb_key', '');
        $baseUrl = config('services.timezonedb_url', '');

        if (!empty($apiKey) && !empty($baseUrl)) {
            try {
                $url = "{$baseUrl}?key={$apiKey}&format=json&by=position&lat={$latitude}&lng={$longitude}";

                $response = \Http::timeout(5)->get($url);

                if ($response->ok()) {
                    $body = $response->json();
                    if (isset($body['status']) && $body['status'] === 'OK') {
                        $result = [
                            'timezone'     => $body['zoneName']     ?? $fallback['timezone'],
                            'tz_abbr'      => $body['abbreviation'] ?? null,
                            'country_name' => $body['countryName']  ?? $fallback['country_name'],
                            'country_code' => $body['countryCode']  ?? $fallback['country_code'],
                        ];
                        \Log::channel('timelogs')->info(
                            "GeoInfo via timezonedb: TZ={$result['timezone']} | " .
                                "Country={$result['country_name']} ({$result['country_code']})"
                        );
                        return $result;
                    }
                }
            } catch (\Exception $e) {
                \Log::channel('timelogs')->warning(
                    "timezonedb API failed: {$e->getMessage()} — trying BigDataCloud fallback."
                );
            }
        }

        // --- Strategy 2: BigDataCloud reverse geocode (no API key needed) ---
        // Returns country name and country code.
        // Timezone is derived from longitude math since the free tier does not return it.
        try {
            $geoUrl = "https://api.bigdatacloud.net/data/reverse-geocode-client"
                . "?latitude={$latitude}"
                . "&longitude={$longitude}"
                . "&localityLanguage=en";

            $geoResponse = \Http::timeout(5)->get($geoUrl);

            $countryName = $fallback['country_name'];
            $countryCode = $fallback['country_code'];

            if ($geoResponse->ok()) {
                $geo         = $geoResponse->json();
                $countryName = $geo['countryName'] ?? $fallback['country_name'];
                $countryCode = $geo['countryCode'] ?? $fallback['country_code'];
            }

            // Derive timezone from longitude since BigDataCloud free tier omits it.
            $timezone = $this->getTimezoneFromLongitude($longitude, $fallback['timezone']);

            $result = [
                'timezone'     => $timezone,
                'tz_abbr'      => null, // BigDataCloud free tier does not return abbreviation
                'country_name' => $countryName,
                'country_code' => $countryCode,
            ];

            \Log::channel('timelogs')->info(
                "GeoInfo via BigDataCloud: TZ={$result['timezone']} | " .
                    "Country={$result['country_name']} ({$result['country_code']})"
            );

            return $result;
        } catch (\Exception $e) {
            \Log::channel('timelogs')->warning(
                "BigDataCloud fallback failed: {$e->getMessage()} — using longitude math only."
            );
        }

        // --- Strategy 3: Longitude math only (no country info available) ---
        return [
            'timezone'     => $this->getTimezoneFromLongitude($longitude, $fallback['timezone']),
            'tz_abbr'      => null,
            'country_name' => null,
            'country_code' => null,
        ];
    }

    /**
     * Derive a best-guess IANA timezone from longitude using UTC offset math.
     *
     * Every 15° of longitude ≈ 1 hour of UTC offset.
     * This is a fast, dependency-free approximation. It works well for most cases
     * but may be off by 1 hour near timezone boundary edges.
     *
     * @param  float   $longitude
     * @param  string  $fallback
     * @return string  IANA timezone identifier e.g. Asia/Manila
     */
    private function getTimezoneFromLongitude(float $longitude, string $fallback = 'Asia/Manila'): string
    {
        try {
            $utcOffsetSeconds = (int) round($longitude / 15) * 3600;

            $identifiers = \DateTimeZone::listIdentifiers(\DateTimeZone::ALL);
            $bestMatch   = $fallback;
            $bestDiff    = PHP_INT_MAX;
            $now         = new \DateTime('now', new \DateTimeZone('UTC'));

            foreach ($identifiers as $id) {
                $tz     = new \DateTimeZone($id);
                $offset = $tz->getOffset($now);
                $diff   = abs($offset - $utcOffsetSeconds);

                if ($diff < $bestDiff) {
                    $bestDiff  = $diff;
                    $bestMatch = $id;
                }

                // Exact match — no need to keep searching.
                if ($diff === 0) {
                    break;
                }
            }

            \Log::channel('timelogs')->info(
                "Timezone from longitude ({$longitude}°): UTC" .
                    ($utcOffsetSeconds >= 0 ? '+' : '') .
                    ($utcOffsetSeconds / 3600) . " → {$bestMatch}"
            );

            return $bestMatch;
        } catch (\Exception $e) {
            \Log::channel('timelogs')->warning("getTimezoneFromLongitude failed: {$e->getMessage()}");
            return $fallback;
        }
    }

    function saveTimeLogs(Request $request)
    {
        // return var_dump($request->all());
        // return $request->ip();
        try {
            $empID = Auth::user()->employee_id;

            // Detect local timezone AND country from GPS coordinates.
            // Falls back to Asia/Manila / Philippines if coords are missing or lookup fails.
            $geoInfo = $this->getGeoInfoFromCoords(
                $request->latitude,
                $request->longitude
            );

            $localTimezone = $geoInfo['timezone'];
            $tzAbbr        = $geoInfo['tz_abbr'];
            $countryName   = $geoInfo['country_name'];
            $countryCode   = $geoInfo['country_code'];

            // Server time — original, unchanged.
            $serverTime = Carbon::now();

            // Local time — server time converted to user's detected timezone.
            $localTime  = Carbon::now()->setTimezone($localTimezone);

            \Log::channel('timelogs')->info(
                "Emp.#: {$empID} | Log: {$request->logEvent} " .
                    "| Server Time: {$serverTime} | Local Time: {$localTime} " .
                    "| Timezone: {$localTimezone} ({$tzAbbr}) | Country: {$countryName} ({$countryCode}) " .
                    "| Received latitude: {$request->latitude}, longitude: {$request->longitude}"
            );

            $exists = $this->checkTimeLogExists(Auth::user()->employee_id, $localTime);

            if ($exists) { // If exist, new time log will only update time_in (if NULL) /time_out (latest)
                // return "Log Date Exists...";
                $updateLog = DB::table('time_logs_header');
                if ($request->logEvent == 'TimeIn') {
                    $updateLog->where('employee_id', Auth::user()->employee_id)
                        ->where('log_date', $localTime->format('Y-m-d'))
                        ->whereNull('time_in')
                        ->update([
                            'time_in'    => $localTime->format('H:i:s'),
                            'updated_at' => $localTime
                        ]);
                } else {
                    $updateLog->where('employee_id', Auth::user()->employee_id)
                        ->where('log_date', $localTime->format('Y-m-d'))
                        ->update([
                            'time_out'   => $localTime->format('H:i:s'),
                            'updated_at' => $localTime
                        ]);
                }
                $logId = DB::table('time_logs_header')
                    ->select('id')
                    ->where('employee_id', Auth::user()->employee_id)
                    ->whereDate('log_date', $localTime->format('Y-m-d'))->first();

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
                    'log_date'      => $localTime->format('Y-m-d'),
                    'created_at'    => $localTime,
                    'updated_at'    => $localTime
                ];

                if ($request->logEvent == 'TimeIn') {
                    $header['time_in'] = $localTime->format('H:i:s');
                } else {
                    $header['time_out'] = $localTime->format('H:i:s');
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
                'ref_id'        => $logId,
                'employee_id'   => Auth::user()->employee_id,
                // 'profile_photo_path' => $request->image,
                'image_path'    => $fileName,
                'ip_address'    => $request->ip(),
                // 'ip_address_server' => $details->getIp(),
                'office'        => Auth::user()->office,
                'department'    => Auth::user()->department,
                'supervisor'    => Auth::user()->supervisor,
                'latitude'      => (float) $request->latitude,
                'longitude'     => (float) $request->longitude,
                'server_time'  => $serverTime->format('Y-m-d H:i:s'), // Original server time — unchanged
                'timezone'     => $localTimezone,   // IANA timezone e.g. Asia/Manila
                'tz_abbr'      => $tzAbbr,          // Timezone abbreviation e.g. PST, ICT
                'country_name' => $countryName,     // e.g. Philippines
                'country_code' => $countryCode,     // e.g. PH
                // 'region_name' => ,
                // 'region_code' => ,
                // 'city_name'   => ,
                // 'zip_code'    => ,
                'created_at'   => $serverTime,      // server time — original
                'updated_at'   => $serverTime       // server time — original
            ];

            if ($request->logEvent == 'TimeIn') {
                $data['time_in'] = $localTime;      // converted local time
            } else {
                $data['time_out'] = $localTime;     // converted local time
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
