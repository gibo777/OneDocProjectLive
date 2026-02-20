<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Employees;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Carbon\Carbon;


use Illuminate\Support\Facades\Mail;
use App\Mail\PendingRequestNotification;

use Illuminate\Support\Facades\Log;

class CronController extends Controller
{
    /**
     * Auto Compute Leave Credits
     *
     * @return \Illuminate\Http\Response
     * @author Gilbert L. Retiro
     */
    public function cronAutoComputeLeaveCredits()
    {

        // Get the current month and day
        $curMonth = Carbon::now()->month;
        $curDay = Carbon::now()->day;

        // Get user's id based on the day of regularization
        $userIDs = DB::table('users')
            ->select(
                'id',
                'date_regularized',
                DB::raw('DAY(date_regularized) as day_regularized'),
                DB::raw('MONTH(date_regularized) as month_regularized')
            )
            ->whereDate('date_regularized', '<=', DB::raw('CURDATE()'));

        // Apply conditions based on the current month
        // Check if day of regularized is 29 to 31 to make sure that even the month is February or (April, June, September, November where only up to 30 days, and assuming July 31 regularized), leave credits will be added accrodingly.
        switch ($curMonth) {
            case 2:
                $userIDs->whereRaw('DAY(date_regularized) = ? OR DAY(date_regularized) IN (29,30,31)', [$curDay]);
                break;
            case 4:
            case 6:
            case 9:
            case 11:
                $userIDs->whereRaw('DAY(date_regularized) = ? OR DAY(date_regularized) = 31', [$curDay]);
                break;
            default:
                $userIDs->whereRaw('DAY(date_regularized) = ?', [$curDay]);
                break;
        }

        // Execute the query
        $userIDs = $userIDs->get();

        // return '<pre>'.var_dump($userIDs).'</pre>';

        $string = '<link rel="shortcut icon" href="' . asset('img/all/onedoc-favicon.png') . '">';

        foreach ($userIDs as $key => $value) {
            // Check Current Date vs Date Regularized (if 0 to 3years, 3years to 6years, and 6years up)
            // Check if already added monthly leave credits for VL, SL, and EL
            // Calculate VL, SL, and EL based on the Year/s of Service
            // (0 to 3 years)
            // VL = 10/12 per month,
            // SL = 10/12 * month/s remaining until December,
            // EL = 5/12 * month/s remaining until December)

            $string .= $value->date_regularized . " === " . $value->month_regularized . " / " . $value->day_regularized . " | Current Day: " . $curDay . "<br>";

            $select = DB::table('users')
                ->select(
                    'id',
                    'employee_id',
                    'name',
                    'first_name',
                    'middle_name',
                    'last_name',
                    'suffix',
                    'date_regularized',
                    DB::raw('NOW() as server_datetime'),
                    DB::raw('DATE_FORMAT(NOW(),"%Y-%m-%d") as server_date'),
                    DB::raw('DATE_FORMAT(NOW(),"%H:%i:%s") as server_time'),
                    DB::raw('TIMESTAMPDIFF(YEAR, date_regularized, CURDATE()) AS years_since_regularized'),
                    DB::raw('TIMESTAMPDIFF(MONTH, date_regularized, CURDATE()) % 12 AS months_since_regularized')
                )
                ->where('id', $value->id)
                ->where('date_regularized', '!=', NULL)
                ->where('date_regularized', '!=', '1970-01-01')
                ->whereDate('date_regularized', '<=', DB::raw('CURDATE()'))
                ->orderBy('first_name')
                ->orderBy('last_name')
                ->get();

            foreach ($select as $key => $value) {

                $regularDate    = Carbon::parse($value->date_regularized);
                $serverDate     = Carbon::parse($value->server_date);
                $diff           = $regularDate->diffInYears($serverDate);
                $yearsTenure    = intval($value->years_since_regularized);

                /*if ($value->employee_id == '2022-0314') {
                    return var_dump($value);
                }*/
                /*if (url('/') == 'http://localhost' && $value->id != 1 && $value->id != 2) {
                    $string .= "Name: " . implode(' ', ['Xxx', 'X', 'Xxx', ucwords(strtolower($value->suffix))]);
                } else {*/
                $string .= "Name: " . implode(' ', [ucwords(strtolower($value->first_name)), ucwords(strtolower($value->middle_name)), ucwords(strtolower($value->last_name)), ucwords(strtolower($value->suffix))]);
                // }

                $string .= " | Employee ID: " . $value->employee_id;
                $string .= " | Date Regularized: " . $regularDate->format('M d, Y');
                if ($value->years_since_regularized == 0) {
                    $string .= " | Regularized Tenure: " . $value->months_since_regularized . " Month/s";
                } else {
                    $string .= " | Regularized Tenure: " . $value->years_since_regularized . " Year/s and " . $value->months_since_regularized . " Month/s";
                }

                if ($yearsTenure > 6) {
                    $string .= " (More than 6 years)";
                    $string .= " | VL Credit Added: " . number_format((15 / 12), 4);
                } elseif ($yearsTenure >= 3 && $yearsTenure < 6) {
                    $string .= " <b style='color:#03C03C'>(3 years to 6 years)</b>";
                    $string .= " | VL Credit Added: " . number_format((12 / 12), 4);
                } else {
                    $string .= " <b style='color:#007FFF'>(Below 3 years)</b>";
                    $string .= " | VL Credit Added: " . number_format((10 / 12), 4);
                }

                $string .= "<br>";
                for ($i = 0; $i < 125; $i++) {
                    $string .= "=";
                }
                $string .= "<br>";
            }
        }

        // $string .= "<script>alert('❤️ I miss you my 345 partner ❤️');</script>";
        return $string;
    }

    /**
     * Send Pending Request Email Notifications to Supervisors via smtp
     *
     * @return void
     */
    public function cronAutoPendingRequestNotification()
    {
        $headUsers = DB::table('users as u')
            ->whereIn('u.role_type', ['SUPER ADMIN', 'ADMIN', 'COMPANY SUPER ADMIN'])
            ->where(function ($q) {
                $q->whereNull('u.employment_status')
                    ->orWhere('u.employment_status', '<>', 'NO LONGER CONNECTED');
            })
            // ->where('u.id', 2) // This is just for testing.. Comment this when not needed for testing.
            ->get();

        foreach ($headUsers as $head) {
            /* PENDING LEAVE COUNTS */
            $pendingLeaves = DB::table('leaves as l')
                ->where('l.leave_status', 'Pending')
                ->where('l.head_id', $head->employee_id)
                ->count();

            /* PENDING OVERTIME COUNTS */
            $pendingOvertimes = DB::table('overtimes as ot')
                ->where('ot.ot_status', 'Pending')
                ->where('ot.head_id', $head->employee_id)
                ->count();

            /* PENDING LEAVES AND OVERTIME COUNTS */
            $pendingCount = [
                'pendingLeaveCount' => $pendingLeaves ?? 0,
                'pendingOvertimes'  => $pendingOvertimes ?? 0,
            ];

            // Only proceed if there is at least one pending request
            if ($pendingLeaves > 0 || $pendingOvertimes > 0) {
                Log::channel('pending-mail-notification')->info('Pending Request Summary', [
                    'head_name'         => $head->name,
                    'employee_id'       => $head->employee_id,
                    'pending_leave'     => $pendingLeaves,
                    'pending_overtime'  => $pendingOvertimes,
                ]);

                $pendingCount = [];
                if ($pendingLeaves > 0) {
                    $pendingCount['pendingLeaveCount'] = $pendingLeaves;
                }
                if ($pendingOvertimes > 0) {
                    $pendingCount['pendingOvertimes'] = $pendingOvertimes;
                }
                // Check if the default supervisor's email
                $supervisorEmail = strpos($head->email, 'jmyulo') !== false
                    ? DB::table('users')->where('id', 32)->value('email')
                    : $head->email;

                // Send email to the supervisor
                Mail::to($supervisorEmail)
                    ->send(new PendingRequestNotification(
                        $head->id,
                        $head->name,
                        $head->gender,
                        $pendingCount
                    ));
            }
        }
    }
}
