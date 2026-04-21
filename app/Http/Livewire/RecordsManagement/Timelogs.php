<?php

namespace App\Http\Livewire\RecordsManagement;

use Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Carbon\Carbon;


class Timelogs extends Component
{
    use WithPagination;

    public $pageSize = 15; // Default page size
    public $offices; // Variable to hold offices
    public $departments; // Variable to hold departments
    public $search = ''; // Search input variable
    public $fTLOffice = ''; // Office filter variable
    public $fTLDept = ''; // Office filter variable
    public $fTLdtFrom = ''; //Date From filter variable
    public $fTLdtTo = ''; // Date To filter variable
    // public $roleType = Auth::user()->role_type;

    protected $listeners = ['pageSizeChanged'];


    public function mount()
    {
        $this->loadDropdowns();
    }

    public function render()
    {
        $timeLogs = $this->fetchTimeLogs();
        $this->loadDropdowns();

        return view('livewire.records-management.timelogs', [
            'timeLogs' => $timeLogs,
            'offices' => $this->offices,
            'departments' => $this->departments,
        ]);
    }


    private function loadDropdowns()
    {
        $this->offices = DB::table('offices')->orderBy('company_name')->get();
        $this->departments = DB::table('departments')->orderBy('department')->get();
    }


    public function clearDateFilters()
    {
        $this->fTLdtFrom = null;
        $this->fTLdtTo = null;
    }

    private function fetchTimeLogs()
    {
        /*if (empty($this->fTLdtTo) && !empty($this->fTLdtFrom)) {
	        $this->fTLdtTo = $this->fTLdtFrom;
	    }*/
        $timeLogs = DB::table('time_logs_header as th')
            ->select(
                'th.id',
                'th.full_name',
                'th.employee_id',
                'o.company_name as office',
                'd.department',
                'th.log_date',
                'th.time_in',
                'th.time_out',
                'th.supervisor'
            )
            ->leftJoin('users as u', 'th.employee_id', '=', 'u.employee_id')
            ->leftJoin('departments as d', 'th.department', '=', 'd.department_code')
            ->leftJoin('offices as o', 'th.office', '=', 'o.id')
            ->where(function ($query) {
                // Apply office filter if selected
                if (!empty($this->fTLOffice)) {
                    $query->where('th.office', $this->fTLOffice);
                }

                // Apply department filter if selected
                if (!empty($this->fTLDept)) {
                    $query->where('th.department', $this->fTLDept);
                }

                // Apply search query if search term is provided
                if (Auth::user()->role_type == 'SUPER ADMIN' || Auth::user()->role_type == 'ADMIN') {
                    if (!empty($this->search)) {
                        $searchTerms = explode(' ', trim($this->search));
                        $query->where(function ($q) use ($searchTerms) {

                            $q->where(function ($nameQuery) use ($searchTerms) {
                                foreach ($searchTerms as $term) {
                                    $nameQuery->where('th.full_name', 'like', '%' . $term . '%');
                                }
                            });
                            $q->orWhere('th.employee_id', 'like', '%' . implode(' ', $searchTerms) . '%');
                        });
                    }
                }


                // Filter by date range
                if (!empty($this->fTLdtFrom) && !empty($this->fTLdtTo)) {
                    $query->whereBetween('th.log_date', [$this->fTLdtFrom, $this->fTLdtTo]);
                } elseif (!empty($this->fTLdtFrom)) {
                    $query->where('th.log_date', $this->fTLdtFrom);
                } elseif (!empty($this->fTLdtTo)) {
                    $query->where('th.log_date', $this->fTLdtTo);
                }

                // Additional conditional check for user role
                if (Auth::user()->role_type != 'SUPER ADMIN' && Auth::user()->role_type != 'ADMIN') {
                    $query->where(function ($q) {
                        $q->where('th.employee_id', Auth::user()->employee_id)
                            ->orWhere('u.supervisor', Auth::user()->employee_id);
                    });
                }

                // Exclude specific user IDs
                if (Auth::user()->id != 1 && Auth::user()->id != 2) {
                    $query->where('u.id', '!=', 1);
                }

                if (Auth::user()->is_head == 1) {
                    if (Auth::user()->id != 1) {

                        $userAccess = DB::table('m_authorize_users')
                            ->where('u_id', Auth::user()->id)
                            ->first();

                        if (!$userAccess) {
                            $query->where(function ($q) {
                                $q->where('u.employee_id', Auth::user()->employee_id)
                                    ->orWhere('u.supervisor', Auth::user()->employee_id);
                            });
                        } else {
                            if (is_null($userAccess->assigned_office)) {
                                $query->where(function ($q) {
                                    $q->where('u.employee_id', Auth::user()->employee_id)
                                        ->orWhere('u.supervisor', Auth::user()->employee_id);
                                });
                            } else {
                                $assignedOffices = explode('|', $userAccess->assigned_office);

                                $query->where(function ($q) use ($assignedOffices) {
                                    $q->where('u.office', Auth::user()->office)
                                        ->orWhereIn('u.office', $assignedOffices)
                                        ->orWhere('u.supervisor', Auth::user()->employee_id);
                                });
                            }
                        }
                    }
                } else {
                    $query->where('u.id', Auth::user()->id);
                }

                // Filter by deleted users
                $query->where(function ($q) {
                    $q->where('u.is_deleted', 0)
                        ->orWhereNull('u.is_deleted');
                });
            })
            ->orderBy('th.log_date', 'desc')
            ->orderBy('th.full_name', 'asc')
            ->paginate($this->pageSize);

        return $timeLogs;
    }



    // Method to handle changing page size
    public function pageSizeChanged($size)
    {
        $this->pageSize = $size;
        $this->resetPage();
    }


    /**
     * Timelogs Details
     *
     * @return view for modal
     * @author Gilbert L. Retiro
     **/
    public function timelogsPerday(Request $request)
    {
        $employees = DB::select(DB::raw("CALL sp_timelogs_perday('$request->id')"));
        return $employees;
    }


    /**
     * Sending Timelogs payload to HRIS using API
     *
     * @return
     * @author Gilbert L. Retiro
     **/
    public function sendTimelogsAPIHRIS(Request $request)
    {

        $timelog = DB::table('time_logs as t')
            ->leftJoin('users as u', 't.employee_id', 'u.employee_id')
            ->leftJoin('offices as o', 't.office', 'o.id')
            ->select(
                't.id',
                't.employee_id',
                'u.biometrics_id',
                DB::raw('(CASE WHEN t.time_in IS NOT NULL THEN t.time_in ELSE t.time_out END) as time_log'),
                'o.company_name as office',
                't.created_at',
                't.updated_at'
            )
            ->where('t.id', $request->tID)
            ->first();

        if ($timelog) {
            $payloads = [
                'employeeid'    => $timelog->employee_id,
                'biometricsid'  => $timelog->biometrics_id ?? $timelog->employee_id,
                'date'          => Carbon::parse($timelog->time_log)->format('Y-m-d'),
                'time'          => Carbon::parse($timelog->time_log)->format('H:i:s'),
                'officename'    => $timelog->office,
                'created_at'    => $timelog->created_at,
                'updated_at'    => $timelog->updated_at
            ];

            $response = Http::withHeaders([
                'x-api-key' => env('API_KEY'),
                'Accept' => 'application/json'
            ])->withOptions([
                'verify' => false
            ])->post(env('HRIS_URL') . '/api/fetchPortalTimeLogs', $payloads);

            if ($response->successful()) {
                $dataArray = array(
                    'api_sent'  => 1,
                    'api_date'  => DB::raw('NOW()'),
                    'api_refno' => $response->json('apiNo')
                );

                Log::channel('hris-api-timelogs')->info('Timelogs - HRIS API Response', [
                    'status'            => $response->status(),
                    'control_number'    => $timelog->id,
                    'body'              => $response->body()
                    // ,json'              => $response->json()
                    // ,payloads'          => json_encode($payloads)
                ]);

                $utAPI = DB::table('time_logs')
                    ->where('id', $request->tID)
                    ->update($dataArray);
            }
        }
    }


    /**
     * Timelogs Excel Report
     *
     * @return view to generate Excel File
     * @author Gilbert L. Retiro
     **/
    public function timeLogsExcel(Request $request)
    {
        // return var_dump($request->input());
        if (
            Auth::check() && (Auth::user()->email_verified_at != NULL)
            && (Auth::user()->role_type == 'ADMIN' || Auth::user()->role_type == 'SUPER ADMIN')
        ) {
            $access_code = Auth::user()->access_code;
            $employee_id = Auth::user()->employee_id;
            $currentDate = Carbon::now('Asia/Manila');
            $formattedDateTime = $currentDate->format('YmdHis');

            $fileName = 'Timelogs_';


            if (Auth::user()->is_head == 1 || Auth::user()->role_type == 'SUPER ADMIN' ||  Auth::user()->role_type == 'ADMIN') {
                $tlSummary = DB::select("CALL sp_timelogs_header(?, ?, ?, ?, ?, ?)", [
                    Auth::user()->id,
                    $request->office,
                    $request->department,
                    $request->timeIn,
                    $request->timeOut,
                    $request->search
                ]);

                $tlDetailed = DB::select("CALL sp_timelogs_detailed_xls(?, ?, ?, ?, ?, ?)", [
                    Auth::user()->id,
                    $request->office,
                    $request->department,
                    $request->timeIn,
                    $request->timeOut,
                    $request->search
                ]);
            } else {
                $tlSummary = DB::select('CALL sp_timelogs(' . Auth::user()->id . ',' . Auth::user()->is_head . ',' . $employee_id . ')');
            }

            if ($request->office) {
                $officeName = DB::table('offices')->where('id', $request->office)->value('company_name') ?? '';
                $fileName .= strtoupper($officeName) . '_';
            }
            if ($request->timeIn && $request->timeOut) {
                $dateFrom = Carbon::parse($request->timeIn);
                $dateTo   = Carbon::parse($request->timeOut);
                $fileName .= $dateFrom->format('Md') . '_' . $dateTo->format('Md_Y') . '_';
            } elseif ($request->timeIn && !$request->timeOut) {
                $dateFrom = Carbon::parse($request->timeIn);
                $fileName .= $dateFrom->format('Md_Y') . '_';
            }
            $fileName .= Carbon::now()->format('mdHi') . '.xls';

            return response()->json([
                'tlSummary'     => $tlSummary,
                'tlDetailed'    => $tlDetailed,
                'currentDate'   => $formattedDateTime,
                'fileName'      => $fileName
            ]);

            // $offices = DB::table('offices')->orderBy('company_name')->get();
            // $departments = DB::table('departments')->orderBy('department')->get();

            // return view('/reports/excel/timelogs-excel',
            //     [
            //         'employees'     => $employees,
            //         'offices'       => $offices,
            //         'departments'   => $departments,
            //         'currentDate'   => $formattedDateTime
            //     ]);
        } else {
            return redirect('/');
        }
    }
}
