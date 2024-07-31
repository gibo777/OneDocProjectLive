<?php

namespace App\Http\Livewire\RecordsManagement;

use Auth;
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
		        if (!empty($this->search)) {
				    $searchTerms = explode(' ', $this->search);
				    $query->where(function ($q) use ($searchTerms) {
				        foreach ($searchTerms as $term) {
				            $q->where('th.full_name', 'like', '%' . $term . '%');
				        }
				    })
				    ->orWhere('th.employee_id', 'like', '%' . $this->search . '%');
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
		        if  (Auth::user()->is_head==1) {
		        	switch (Auth::user()->id) {
		        		case 1: case 8: case 18: case 58: break;
		        		case 124:
		        			$query->where(function($q) {
		        				return $q->where('u.office', Auth::user()->office)
		        						->orWhereIn('u.office',[6,8,12,14,15]);
		        			});
		        			break;
		        		case 86: case 126: case 222:
		        			$query->where(function($q) {
		        				return $q->where('u.office', Auth::user()->office)
		        						->orWhereIn('u.office',[8,12,14,15]);
		        			});
		        			break;
                        case 72:
                            $query->where(function($q) {
                                return $q->where('u.office', Auth::user()->office)
                                        ->orWhereIn('u.office',[12]);
                            });
                            break;
                        case 135:
                            $query->where(function($q) {
                                return $q->where('u.office', Auth::user()->office)
                                        ->orWhereIn('u.office',[8,12]);
                            });
                            break;
                        case 223:
                            $query->where(function($q) {
                                return $q->where('u.office', Auth::user()->office)
                                        ->orWhereIn('u.office',[8,14]);
                            });
                            break;
                        case 131: case 238:
                            $query->where(function($q) {
                                return $q->where('u.office', Auth::user()->office)
                                        ->orWhereIn('u.office',[14]);
                            });
                            break;
                        case 155: case 159:
                            $query->where(function($q) {
                                return $q->where('u.office', Auth::user()->office)
                                        ->orWhereIn('u.office',[15]);
                            });
                            break;
		        		default:
		        			$query->where(function($q) {
		        				return $q->where('u.employee_id', Auth::user()->employee_id)
		        						->orWhere('u.supervisor',Auth::user()->employee_id);
		        			});
		        			break;
		        	}
		        } else {
		        	$query->where('u.employee_id', Auth::user()->employee_id);
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
    public function timelogsPerday (Request $request)
    {
        $employees = DB::select(DB::raw("CALL sp_timelogs_perday('$request->id')"));
        return $employees;
    }


    /**
     * Timelogs Excel Report
     *
     * @return view to generate Excel File
     * @author Gilbert L. Retiro
     **/
    public function timeLogsExcel (Request $request)
    {
        // return var_dump($request->input());
        if ( Auth::check() && (Auth::user()->email_verified_at != NULL) 
            && (Auth::user()->role_type=='ADMIN'||Auth::user()->role_type=='SUPER ADMIN') )
        {
            $access_code = Auth::user()->access_code;
            $employee_id = Auth::user()->employee_id;
            $currentDate = Carbon::now('Asia/Manila');
            $formattedDateTime = $currentDate->format('YmdHis');

            if (Auth::user()->is_head == 1 || Auth::user()->role_type=='SUPER ADMIN' ||  Auth::user()->role_type=='ADMIN') {
                $tlSummary = DB::select("CALL sp_timelogs_header(?, ?, ?, ?, ?)", [
                    Auth::user()->id,
                    $request->office,
                    $request->department,
                    $request->timeIn,
                    $request->timeOut
                ]);

                // return var_dump($tlSummary);

                $tlDetailed = DB::select("CALL sp_timelogs_detailed_xls(?, ?, ?, ?, ?)", [
                    Auth::user()->id,
                    $request->office,
                    $request->department,
                    $request->timeIn,
                    $request->timeOut
                ]);

                // return var_dump($tlDetailed);

                
            } else {
                $tlSummary = DB::select('CALL sp_timelogs('.Auth::user()->id.','.Auth::user()->is_head.','.$employee_id.')');
            }


            return response()->json([
                'tlSummary'     => $tlSummary, 
                'tlDetailed'    => $tlDetailed, 
                'currentDate'   => $formattedDateTime
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
