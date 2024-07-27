<?php

namespace App\Http\Livewire\EForms;

use Auth;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class LeaveApplication extends Component
{
    use WithPagination;

    public $pageSize = 15; 	// Default page size
    public $offices; 		// Variable to hold offices
    public $departments; 	// Variable to hold departments
    public $search = ''; 	// Search input variable
    public $fTLOffice = ''; // Office filter variable
    public $fTLDept = ''; 	// Office filter variable
    public $fLType = ''; 	// Office Leave Type variable
    public $fLStatus = ''; 	// Office Leave Status variable
    public $fLdtFrom = ''; // Date From filter variable
    public $fLdtTo = ''; 	// Date To filter variable

    protected $listeners = ['pageSizeChanged', 'refreshComponent'];


    public function mount()
    {
        $this->loadDropdowns();
    }

    public function render()
    {
        $leaves = $this->fetchTimeLogs();
        $this->loadDropdowns();

        return view('livewire.e-forms.leave-application', [
            'leaves' => $leaves,
            'offices' => $this->offices,
            'departments' => $this->departments,
        ]);
    }


    private function loadDropdowns()
    {
        $this->offices = DB::table('offices')->orderBy('company_name')->get();
        $this->departments = DB::table('departments')->orderBy('department')->get();
        $this->lTypes = DB::table('leave_types')->get();
        $this->lStatus = DB::table('request_statuses')->get();
    }

    
    public function clearDateFilters()
    {
        $this->fLdtFrom = null;
        $this->fLdtTo = null;
    }

    private function fetchTimeLogs()
	{

	    $leaves = DB::table('leaves as l')
	        ->select(
	            'l.id',
	            'u.id as u_id',
	            'l.leave_number',
	            'l.leave_type',
	            'l.control_number',
	            'l.name as full_name',
	            'l.employee_id',
	            'l.date_applied',
	            'l.date_from',
	            'l.date_to',
	            'l.no_of_days',
	            'o.company_name as office',
	            'd.department',
	            'd.department_code as dept',
	            'u.supervisor',
	            'l.created_at',
	            'u.supervisor',
	            DB::raw("CONCAT(u2.first_name, ' ', u2.last_name) as head_name"),
	            'l.leave_status as status',
	            'l.leave_status'
	        )
	        ->leftJoin('offices as o', 'l.office', '=', 'o.id')
	        ->leftJoin('departments as d', 'l.department', '=', 'd.department_code')
	        ->leftJoin('users as u', 'u.employee_id', '=', 'l.employee_id')
	        ->leftJoin('users as u2', 'u2.employee_id', '=', 'u.supervisor');
	    $leaves = $leaves->where(function ($query) {
		            $query->where('l.is_deleted', 0)
		                ->orWhereNull('l.is_deleted');
		        });
	    (Auth::user()->id!=1 && Auth::user()->id!=2) ? $leaves = $leaves->where('u.id', '<>', 1) : '';
		$leaves = $leaves->where(function ($query) {
		        // Apply office filter if selected
		        if (!empty($this->fTLOffice)) {
		            $query->where('l.office', $this->fTLOffice);
		        }

		        // Apply department filter if selected
		        if (!empty($this->fTLDept)) {
		            $query->where('l.department', $this->fTLDept);
		        }
		        if (!empty($this->fLType)) {
		            $query->where('l.leave_type', $this->fLType);
		        }
		        if (!empty($this->fLStatus)) {
		            $query->where('l.leave_status', $this->fLStatus);
		        }

		        // Apply search query if search term is provided
		        if (!empty($this->search)) {
				    $searchTerms = explode(' ', $this->search);
				    $query->where(function ($q) use ($searchTerms) {
				        foreach ($searchTerms as $term) {
				            $q->where('l.name', 'like', '%' . $term . '%');
				        }
				    })
				    ->orWhere('l.employee_id', 'like', '%' . $this->search . '%');
				}

		        // Filter by date range
		        if (!empty($this->fLdtFrom) && !empty($this->fLdtTo)) {
		            $query->where(function ($q) {
                          $q->where('l.date_from', '>=', $this->fLdtFrom)
                            ->where('l.date_to', '<=', $this->fLdtTo);
                      });
		        } elseif (!empty($this->fLdtFrom)) {
		            $query->where('l.date_from', $this->fLdtFrom);
		        } elseif (!empty($this->fLdtTo)) {
		            $query->where('l.date_to', $this->fLdtTo);
		        }

		        // Additional conditional check for user role
		        /*if (Auth::user()->role_type != 'SUPER ADMIN' && Auth::user()->role_type != 'ADMIN') {
		            $query->where(function ($q) {
		                $q->where('th.employee_id', Auth::user()->employee_id)
		                  ->orWhere('u.supervisor', Auth::user()->employee_id);
		            });
		        }*/

		        // Exclude specific user IDs
		        if (Auth::user()->id != 1 && Auth::user()->id != 2) {
		            $query->where('u.id', '!=', 1);
		        }
		        if  (Auth::user()->is_head==1) {
		        	switch (Auth::user()->id) {
		        		case 1: case 8: case 18: case 58: break;
		        		case 124:
		        			$query->where(function($q) {
		        				return $q->where('l.office', Auth::user()->office)
		        						->orWhere('l.office',6);
		        			});
		        			break;
		        		default:
		        			$query->where(function($q) {
		        				return $q->where('l.employee_id', Auth::user()->employee_id)
		        						->orWhere('u.supervisor', Auth::user()->employee_id);
		        			});
		        			break;
		        	}
		        } else {
		        	$query->where('l.employee_id', Auth::user()->employee_id);
		        }

		        // Filter by deleted users
		        $query->where(function ($q) {
		            return $q->where('u.is_deleted', 0)
		              ->orWhereNull('u.is_deleted');
		        });
		    });
	    $leaves = $leaves->orderBy('l.created_at', 'desc')
	        	->paginate($this->pageSize);

	    return $leaves;
	}



    // Method to handle changing page size
    public function pageSizeChanged($size)
    {
        $this->pageSize = $size;
        $this->resetPage();
    }

    public function fetchDetailedLeave (Request $request) {
    	$dLeave = DB::table('leaves as l')
    	->select(
    		'l.id',
    		'l.control_number',
    		'l.name',
    		'u.gender',
    		'l.employee_id',
    		'u.supervisor',
    		'lt.leave_type_name',
    		'l.leave_type',
    		'l.others',
    		'o.company_name as office',
    		'd.department',
    		'l.date_applied',
    		'l.date_from',
    		'l.date_to',
    		'l.no_of_days',
    		'l.reason',
    		'l.leave_status'
    	)
    	->leftJoin('users as u', 'l.employee_id', 'u.employee_id')
    	->leftJoin('offices as o', 'l.office','o.id')
    	->leftJoin('departments as d', 'l.department','d.department_code')
    	->leftJoin('leave_types as lt', 'l.leave_type', 'lt.leave_type')
    	->where('l.id',$request->id)
    	->first();

    	$leaveCredits = DB::table('leaves')
                ->select('employee_id',
                    DB::raw('COALESCE(SUM(CASE WHEN leave_type = "SL" THEN no_of_days ELSE 0 END), 0) as SL'),
                    DB::raw('COALESCE(SUM(CASE WHEN leave_type = "VL" THEN no_of_days ELSE 0 END), 0) as VL'),
                    DB::raw('COALESCE(SUM(CASE WHEN leave_type = "EL" THEN no_of_days ELSE 0 END), 0) as EL'),
                    DB::raw('COALESCE(SUM(CASE WHEN leave_type = "ML" THEN no_of_days ELSE 0 END), 0) as ML'),
                    DB::raw('COALESCE(SUM(CASE WHEN leave_type = "PL" THEN no_of_days ELSE 0 END), 0) as PL'),
                    DB::raw('COALESCE(SUM(CASE WHEN leave_type = "Others" THEN no_of_days ELSE 0 END), 0) as OTS')
                )
                ->where(function ($query) {
                    $query->whereNull('is_deleted')
                        ->orWhere('is_deleted', 0);
                })
                ->where(function ($query) {
                    $query->whereNull('is_cancelled')
                        ->orWhere('is_cancelled', 0);
                })
                ->where('is_head_approved', 1)
                ->where('employee_id', $dLeave->employee_id)
                ->where(DB::raw('YEAR(date_from)'), Carbon::now('Asia/Manila')->format('Y'))
                ->groupBy('employee_id')
                ->first();

            
		if (!$leaveCredits) {
		    $leaveCredits = (object) [
		        'SL' => '0.0',
		        'VL' => '0.0',
		        'EL' => '0.0',
		        'ML' => '0.0',
		        'PL' => '0.0',
		        'OTS' => '0.0'
		    ];
		}
    	
        $leaveTypes = DB::table('leave_types');
        ($dLeave->gender=='F') ? $leaveTypes=$leaveTypes->where('leave_type','!=', 'PL') : $leaveTypes=$leaveTypes->where('leave_type','!=', 'ML');
        $leaveTypes =$leaveTypes->get();

    	return view('modals/m-view-leave-detailed',
    		[
    			'dLeave'		=> $dLeave,
    			'leaveTypes'	=> $leaveTypes,
    			'leaveCredits'	=> $leaveCredits
    		]);
    }

    function headApproveLeave (Request $request) {
    	if($request->ajax()){
	    	$lData = $request->input('lData', []);
		    $lID = $lData['lID'] ?? '';
		    $lType = $lData['lType'] ?? '';
		    $lOthers = $lData['lOthers'] ?? '';

            try {
                $dataArray = array(
                    'leave_status'          => 'Head Approved',
                    'is_head_approved'      => 1,
                    'head_name'             => Auth::user()->first_name.' '. Auth::user()->last_name,
                    'date_approved_head'    => DB::raw('NOW()')
                );
                if ($lType!=='') {
                	$dataArray['leave_type']= $lType;
                	$dataArray['others'] 	= $lOthers;
                }

                $update = DB::table('leaves');
                $update = $update->where('id',$lID);
                $update = $update->update($dataArray);
                
                if ($update > 0) {
	                $action = "Head Approved";
	                $reason = "N/A";

                    $leaveInsert = DB::table('leaves as L')
                        ->leftJoin('leave_balances as b', 'b.employee_id','=','L.employee_id')
                        ->select(
                            'L.id', 
                            'L.leave_number', 
                            'L.control_number', 
                            'L.name', 
                            'L.department', 
                            'L.date_applied', 
                            'L.employee_id', 
                            'L.leave_type',
                            DB::raw('(CASE 
                                WHEN L.leave_type="VL" THEN 
                                    (CASE WHEN b.VL IS NULL THEN 0 ELSE b.VL END)
                                WHEN L.leave_type="SL" THEN 
                                    (CASE WHEN b.SL IS NULL THEN 0 ELSE b.SL END)
                                WHEN L.leave_type="ML" THEN 
                                    (CASE WHEN b.ML IS NULL THEN 0 ELSE b.ML END)
                                WHEN L.leave_type="PL" THEN 
                                    (CASE WHEN b.PL IS NULL THEN 0 ELSE b.PL END)
                                WHEN L.leave_type="EL" THEN 
                                    (CASE WHEN b.EL IS NULL THEN 0 ELSE b.EL END)
                                WHEN L.leave_type="Others" THEN 
                                    (CASE WHEN b.Others IS NULL THEN 0 ELSE b.Others END)
                                ELSE 0
                                END) as leave_balance'), 
                            'L.others', 
                            'L.reason', 
                            'L.date_from', 
                            'L.date_to', 
                            'L.no_of_days', 
                            'L.is_head_approved', 
                            'L.date_approved_head', 
                            'L.head_name',
                            DB::raw("'{$action}' as action"),
                            DB::raw("'{$reason}' as action_reason"),
                            DB::raw("NOW() as created_at")
                        )->where('L.id','=',$lID)
                        ->where(function ($query) {
						    $query->whereNull('b.is_deleted')
						          ->orWhere('b.is_deleted', '=', NULL);
						});

                    $history = DB::table('leave_history')
                    ->insertUsing([
                        'leave_reference', 
                        'leave_number', 
                        'control_number', 
                        'name', 
                        'department',
                        'date_applied', 
                        'employee_id', 
                        'leave_type', 
                        'leave_balance', 
                        'others', 
                        'reason', 
                        'date_from', 
                        'date_to', 
                        'no_of_days', 
                        'is_head_approved', 
                        'date_approved_head', 
                        'head_name', 
                        'action', 
                        'action_reason', 
                        'created_at'
                    ],$leaveInsert);

                    if ($history>0) {
                        return "Head Approval Successful!";
                    } else {
                        return "Failed to Approve Leave";
                        DB::rollback();
                    }
                } else {
                    return "Failed to Approve Leave";
                    DB::rollback();
                }
            }
            catch(Exception $e){
                return redirect(route('eforms.leaves-listing'))->with('failed',"Operation Failed!");
            }
    	}
    }

    function updateLeave (Request $request) {
    	if($request->ajax()){
            try {
        		$name             = $request->name;
        		$employee_number  = $request->employee_number;
        		$department       = $request->department;
                $date_applied     = date('Y-m-d',strtotime($request->date_applied)).' '.date('G:i:s');
        		$leave_type       = $request->leave_type;
        		$others_leave     = $request->others_leave;
        		$reason           = $request->reason;
        		$date_from        = date('Y-m-d',strtotime($request->date_from));
        		$date_to          = date('Y-m-d',strtotime($request->date_to));
        		$hid_no_days      = $request->hid_no_days;
        		$leave_id         = $request->leave_id;

                $data_array = array(
                            'date_applied'  => $date_applied,
                            'leave_type'    => $leave_type,
                            'reason'        => $reason,
                            'date_from'     => $date_from,
                            'date_to'       => $date_to,
                            'no_of_days'    => $hid_no_days
                        );

                if ($leave_type=="Others") {
                    $data_array['others'] = $others_leave;
                }

                // $data_array['id']=$leave_id; var_dump($data_array); die();

        		$update = DB::table('leaves');
                $update = $update->where('id',$leave_id);
                $update = $update->update($data_array);
            }
            catch(Exception $e){
                return redirect(route('hris.leave.view-leave'))->with('failed',"Operation Failed!");
            }
    	}
    }


}
