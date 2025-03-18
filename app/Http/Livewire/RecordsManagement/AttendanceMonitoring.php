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

class AttendanceMonitoring extends Component
{
    use WithPagination;

    public $pageSize = 15; // Default page size
    public $offices; // Variable to hold offices
    public $departments; // Variable to hold departments
    public $search = ''; // Search input variable
    public $fTLOffice = ''; // Office filter variable
    public $fTLDept = ''; // Office filter variable
    public $fTLdtFrom = ''; //Date From filter variable

    protected $listeners = ['pageSizeChanged'];


    public function mount()
    {
    	$this->fTLdtFrom = now()->toDateString();
        $this->loadDropdowns();
    }

    public function render()
    {
        $timeLogs = $this->fetchTimeLogs();
        $this->loadDropdowns();

        return view('livewire.records-management.attendance-monitoring', [
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
    }

    private function fetchTimeLogs()
	{
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
    				    $searchTerms = explode(' ', $this->search);
    				    $query->where(function ($q) use ($searchTerms) {
    				        foreach ($searchTerms as $term) {
    				            $q->where('th.full_name', 'like', '%' . $term . '%');
    				        }
    				    })
    				    ->orWhere('th.employee_id', 'like', '%' . $this->search . '%');
    				}
                }

                if (!empty($this->fTLdtFrom)) {
		            $query->where('th.log_date', $this->fTLdtFrom);
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
		        		case 1: case 8: case 18: case 58: break; case 287: break;
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
                        case 174: case 290: case 315:
                            $query->where(function($q) {
                                return $q->where('u.office', Auth::user()->office);
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
}
