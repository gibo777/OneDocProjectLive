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

        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];

        $image_base64 = base64_decode($image_parts[1]);
        $fileName = $this->generateRandomString(40) . '.jpg';

        $file = $folderPath . $fileName;

        Storage::put($file, $image_base64);

        $webcamPhotoLocation = asset("storage/" . $file);

        return $webcamPhotoLocation;
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
     *      Country code is mapped to a preferred IANA timezone.
     *      Longitude math is used only when the country code has no mapping.
     *
     *   3. Longitude-based UTC offset math → nearest PHP timezone.
     *      Zero dependencies, no network call, cannot determine country.
     *      Uses a preferred-timezone map to avoid alphabetical-first matches
     *      (e.g. Asia/Brunei before Asia/Manila for UTC+8).
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
        // Country code is mapped to a preferred IANA timezone to avoid
        // relying on longitude math (which may return a wrong but same-offset
        // timezone, e.g. Asia/Brunei instead of Asia/Manila for UTC+8).
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

            // Map country code → preferred IANA timezone.
            // Falls back to longitude math only when the country has no mapping.
            $timezone = $this->getTimezoneFromCountryCode($countryCode)
                ?? $this->getTimezoneFromLongitude($longitude, $fallback['timezone']);

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
     * Map a country code to its primary IANA timezone.
     *
     * Returns null when the country is not in the map so the caller
     * can fall back to longitude math.
     *
     * @param  string|null  $countryCode  ISO 3166-1 alpha-2 e.g. "PH"
     * @return string|null  IANA timezone identifier e.g. "Asia/Manila"
     */
    private function getTimezoneFromCountryCode(?string $countryCode): ?string
    {
        if (empty($countryCode)) {
            return null;
        }

        $map = [
            // Asia
            'PH' => 'Asia/Manila',
            'JP' => 'Asia/Tokyo',
            'KR' => 'Asia/Seoul',
            'CN' => 'Asia/Shanghai',
            'HK' => 'Asia/Hong_Kong',
            'TW' => 'Asia/Taipei',
            'SG' => 'Asia/Singapore',
            'MY' => 'Asia/Kuala_Lumpur',
            'BN' => 'Asia/Brunei',
            'ID' => 'Asia/Jakarta',
            'TH' => 'Asia/Bangkok',
            'VN' => 'Asia/Ho_Chi_Minh',
            'MM' => 'Asia/Rangoon',
            'KH' => 'Asia/Phnom_Penh',
            'LA' => 'Asia/Vientiane',
            'IN' => 'Asia/Kolkata',
            'PK' => 'Asia/Karachi',
            'BD' => 'Asia/Dhaka',
            'LK' => 'Asia/Colombo',
            'NP' => 'Asia/Kathmandu',
            'AF' => 'Asia/Kabul',
            'IR' => 'Asia/Tehran',
            'AE' => 'Asia/Dubai',
            'SA' => 'Asia/Riyadh',
            'QA' => 'Asia/Qatar',
            'KW' => 'Asia/Kuwait',
            'BH' => 'Asia/Bahrain',
            'OM' => 'Asia/Muscat',
            'IQ' => 'Asia/Baghdad',
            'IL' => 'Asia/Jerusalem',
            'JO' => 'Asia/Amman',
            'LB' => 'Asia/Beirut',
            'SY' => 'Asia/Damascus',
            'TR' => 'Europe/Istanbul',
            'KZ' => 'Asia/Almaty',
            'UZ' => 'Asia/Tashkent',
            'TM' => 'Asia/Ashgabat',
            'AZ' => 'Asia/Baku',
            'AM' => 'Asia/Yerevan',
            'GE' => 'Asia/Tbilisi',
            'MN' => 'Asia/Ulaanbaatar',
            // Europe
            'GB' => 'Europe/London',
            'IE' => 'Europe/Dublin',
            'PT' => 'Europe/Lisbon',
            'ES' => 'Europe/Madrid',
            'FR' => 'Europe/Paris',
            'BE' => 'Europe/Brussels',
            'NL' => 'Europe/Amsterdam',
            'DE' => 'Europe/Berlin',
            'CH' => 'Europe/Zurich',
            'AT' => 'Europe/Vienna',
            'IT' => 'Europe/Rome',
            'PL' => 'Europe/Warsaw',
            'CZ' => 'Europe/Prague',
            'SK' => 'Europe/Bratislava',
            'HU' => 'Europe/Budapest',
            'RO' => 'Europe/Bucharest',
            'BG' => 'Europe/Sofia',
            'GR' => 'Europe/Athens',
            'HR' => 'Europe/Zagreb',
            'RS' => 'Europe/Belgrade',
            'UA' => 'Europe/Kiev',
            'BY' => 'Europe/Minsk',
            'RU' => 'Europe/Moscow',
            'FI' => 'Europe/Helsinki',
            'EE' => 'Europe/Tallinn',
            'LV' => 'Europe/Riga',
            'LT' => 'Europe/Vilnius',
            'SE' => 'Europe/Stockholm',
            'NO' => 'Europe/Oslo',
            'DK' => 'Europe/Copenhagen',
            'IS' => 'Atlantic/Reykjavik',
            // Americas
            'US' => 'America/New_York',
            'CA' => 'America/Toronto',
            'MX' => 'America/Mexico_City',
            'BR' => 'America/Sao_Paulo',
            'AR' => 'America/Argentina/Buenos_Aires',
            'CL' => 'America/Santiago',
            'CO' => 'America/Bogota',
            'PE' => 'America/Lima',
            'VE' => 'America/Caracas',
            'EC' => 'America/Guayaquil',
            'BO' => 'America/La_Paz',
            'PY' => 'America/Asuncion',
            'UY' => 'America/Montevideo',
            'CR' => 'America/Costa_Rica',
            'PA' => 'America/Panama',
            'GT' => 'America/Guatemala',
            'SV' => 'America/El_Salvador',
            'HN' => 'America/Tegucigalpa',
            'NI' => 'America/Managua',
            'CU' => 'America/Havana',
            'DO' => 'America/Santo_Domingo',
            'JM' => 'America/Jamaica',
            'TT' => 'America/Port_of_Spain',
            // Africa
            'ZA' => 'Africa/Johannesburg',
            'NG' => 'Africa/Lagos',
            'KE' => 'Africa/Nairobi',
            'GH' => 'Africa/Accra',
            'ET' => 'Africa/Addis_Ababa',
            'TZ' => 'Africa/Dar_es_Salaam',
            'UG' => 'Africa/Kampala',
            'EG' => 'Africa/Cairo',
            'MA' => 'Africa/Casablanca',
            'TN' => 'Africa/Tunis',
            'DZ' => 'Africa/Algiers',
            'SD' => 'Africa/Khartoum',
            'SN' => 'Africa/Dakar',
            // Oceania
            'AU' => 'Australia/Sydney',
            'NZ' => 'Pacific/Auckland',
            'FJ' => 'Pacific/Fiji',
            'PG' => 'Pacific/Port_Moresby',
            'WS' => 'Pacific/Apia',
            'TO' => 'Pacific/Tongatapu',
        ];

        $timezone = $map[strtoupper($countryCode)] ?? null;

        \Log::channel('timelogs')->info(
            "getTimezoneFromCountryCode: countryCode={$countryCode} → timezone=" . ($timezone ?? 'NOT FOUND (will use longitude math)')
        );

        return $timezone;
    }

    /**
     * Derive a best-guess IANA timezone from longitude using UTC offset math.
     *
     * Every 15° of longitude ≈ 1 hour of UTC offset.
     * This is a fast, dependency-free approximation. It works well for most cases
     * but may be off by 1 hour near timezone boundary edges.
     *
     * Uses a preferred-timezone map for common UTC offsets to avoid returning
     * an alphabetically-first but regionally-wrong timezone (e.g. Asia/Brunei
     * instead of Asia/Manila for UTC+8) since PHP's listIdentifiers() order
     * differs between environments.
     *
     * @param  float   $longitude
     * @param  string  $fallback
     * @return string  IANA timezone identifier e.g. Asia/Manila
     */
    private function getTimezoneFromLongitude(float $longitude, string $fallback = 'Asia/Manila'): string
    {
        try {
            $utcOffsetSeconds = (int) round($longitude / 15) * 3600;

            // Preferred timezones per UTC offset (in seconds).
            // Prevents returning an alphabetically-first but wrong timezone
            // when multiple zones share the same offset (e.g. UTC+8 returns
            // Asia/Brunei before Asia/Manila on some PHP versions).
            $preferred = [
                -43200 => 'Pacific/Baker',
                -39600 => 'Pacific/Niue',
                -36000 => 'Pacific/Honolulu',
                -34200 => 'America/Marquesas',
                -32400 => 'America/Anchorage',
                -28800 => 'America/Los_Angeles',
                -25200 => 'America/Denver',
                -21600 => 'America/Chicago',
                -18000 => 'America/New_York',
                -16200 => 'America/Caracas',
                -14400 => 'America/Halifax',
                -12600 => 'America/St_Johns',
                -10800 => 'America/Sao_Paulo',
                -7200  => 'America/Noronha',
                -3600  => 'Atlantic/Azores',
                0      => 'Europe/London',
                3600   => 'Europe/Paris',
                7200   => 'Europe/Athens',
                10800  => 'Europe/Moscow',
                12600  => 'Asia/Tehran',
                14400  => 'Asia/Dubai',
                16200  => 'Asia/Kabul',
                18000  => 'Asia/Karachi',
                19800  => 'Asia/Kolkata',
                20700  => 'Asia/Kathmandu',
                21600  => 'Asia/Dhaka',
                23400  => 'Asia/Rangoon',
                25200  => 'Asia/Bangkok',
                28800  => 'Asia/Manila',   // ← fixes Asia/Brunei vs Asia/Manila
                32400  => 'Asia/Tokyo',
                34200  => 'Australia/Adelaide',
                36000  => 'Australia/Sydney',
                39600  => 'Pacific/Noumea',
                43200  => 'Pacific/Auckland',
                46800  => 'Pacific/Tongatapu',
            ];

            if (isset($preferred[$utcOffsetSeconds])) {
                \Log::channel('timelogs')->info(
                    "Timezone from longitude ({$longitude}°): UTC" .
                        ($utcOffsetSeconds >= 0 ? '+' : '') .
                        ($utcOffsetSeconds / 3600) .
                        " → {$preferred[$utcOffsetSeconds]} (preferred map)"
                );
                return $preferred[$utcOffsetSeconds];
            }

            // Fallback: scan all identifiers for the closest offset match.
            $identifiers = \DateTimeZone::listIdentifiers(\DateTimeZone::ALL);
            $bestMatch   = $fallback;
            $bestDiff    = PHP_INT_MAX;
            $now         = new \DateTime('now', new \DateTimeZone('UTC'));

            // Log the UTC+8 identifier order once for diagnostics.
            $utc8Identifiers = array_values(array_filter($identifiers, function ($id) use ($now) {
                $tz = new \DateTimeZone($id);
                return $tz->getOffset($now) === 28800;
            }));
            \Log::channel('timelogs')->info(
                "UTC+8 identifier order on this environment: " . implode(', ', $utc8Identifiers)
            );

            foreach ($identifiers as $id) {
                $tz     = new \DateTimeZone($id);
                $offset = $tz->getOffset($now);
                $diff   = abs($offset - $utcOffsetSeconds);

                if ($diff < $bestDiff) {
                    $bestDiff  = $diff;
                    $bestMatch = $id;
                }

                if ($diff === 0) {
                    break;
                }
            }

            \Log::channel('timelogs')->info(
                "Timezone from longitude ({$longitude}°): UTC" .
                    ($utcOffsetSeconds >= 0 ? '+' : '') .
                    ($utcOffsetSeconds / 3600) . " → {$bestMatch} (identifier scan)"
            );

            return $bestMatch;
        } catch (\Exception $e) {
            \Log::channel('timelogs')->warning("getTimezoneFromLongitude failed: {$e->getMessage()}");
            return $fallback;
        }
    }

    function saveTimeLogs(Request $request)
    {
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

            if ($exists) {
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
            } else {
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

            $storagePath = public_path('storage/timelogs');

            if (!File::isDirectory($storagePath)) {
                File::makeDirectory($storagePath, 0755, true);
            }

            $now = now()->format('Ymd');
            $fileName = Auth::user()->id . '_' . $now . substr(md5(uniqid('', true)), 0, 12);
            $file = $fileName . '.txt';

            $image = $request->image;
            $uploadStorage = Storage::disk('public')->put('/timelogs/' . $file, $image);

            $data = [
                'ref_id'        => $logId,
                'employee_id'   => Auth::user()->employee_id,
                'image_path'    => $fileName,
                'ip_address'    => $request->ip(),
                'office'        => Auth::user()->office,
                'department'    => Auth::user()->department,
                'supervisor'    => Auth::user()->supervisor,
                'latitude'      => (float) $request->latitude,
                'longitude'     => (float) $request->longitude,
                'server_time'  => $serverTime->format('Y-m-d H:i:s'),
                'timezone'     => $localTimezone,
                'tz_abbr'      => $tzAbbr,
                'country_name' => $countryName,
                'country_code' => $countryCode,
                'created_at'   => $serverTime,
                'updated_at'   => $serverTime
            ];

            if ($request->logEvent == 'TimeIn') {
                $data['time_in'] = $localTime;
            } else {
                $data['time_out'] = $localTime;
            }

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

            $batchSize = 100;

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

                        \Log::channel('timelogs')->info(
                            "createNewImagePath: [ ID: {$value->uID} ] [ FileName: {$fileName} ] [ File: {$file} ]"
                        );

                        $updateImagePath = DB::table('time_logs')
                            ->where('id', $value->id)
                            ->update(['image_path' => $fileName]);

                        if ($updateImagePath) {
                            $base64Image = $value->profile_photo_path;

                            list($type, $data) = explode(';', $base64Image);
                            list(, $data) = explode(',', $data);

                            $decodedImage = base64_decode($data);

                            $percentage = 50;

                            $sourceImage = imagecreatefromstring($decodedImage);

                            $sourceWidth = imagesx($sourceImage);
                            $sourceHeight = imagesy($sourceImage);

                            $targetWidth = $sourceWidth * ($percentage / 100);
                            $targetHeight = $sourceHeight * ($percentage / 100);

                            $resizedImage = imagecreatetruecolor($targetWidth, $targetHeight);

                            imagecopyresampled($resizedImage, $sourceImage, 0, 0, 0, 0, $targetWidth, $targetHeight, $sourceWidth, $sourceHeight);

                            ob_start();
                            imagejpeg($resizedImage, null, 80);
                            $resizedImageData = ob_get_clean();
                            $resizedBase64Image = 'data:image/jpeg;base64,' . base64_encode($resizedImageData);

                            $uploadStorage = Storage::disk('public')->put('/timelogs/' . $file, $resizedBase64Image);

                            \Log::channel('timelogs')->info(
                                "createNewImagePath: [ ID: {$value->uID} ] [ Status: Success ]"
                            );
                        }
                    }
                });

            return response(['isSuccess' => true, 'message' => 'Successfully Logged!']);
        } catch (\Error $e) {
            return response(['isSuccess' => false, 'message' => $e]);
        }
    }
}
