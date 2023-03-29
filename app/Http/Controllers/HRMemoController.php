<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\HRMemo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use App\Events\FormSubmitted;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PDFController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Arr;


class HRMemoController extends Controller
{
    //
    public function view_memos () {
        if ( Auth::check() && (Auth::user()->email_verified_at != NULL))
        {
            $employees = DB::table('users')->orderBy('last_name')->get();
            $departments = DB::table('departments');
            $departments = $departments->where('is_deleted',0)->orWhereNull('is_deleted')->get();
            // $memos = DB::table('hr_memo as m');
            // $memos = $memos->leftJoin('hr_memo_employees as e', 'm.id', 'e.memo_id');
            // $memos = $memos->where('e.employee_id', Auth::user()->employee_id);
            // $memos = $memos->get();
            $memos = $this->memo_data();

            // return count($memo);

            // $memo_counts = DB::table('hr_memo as m');
            // $memo_counts = $memo_counts->select(
            //     'm.memo_send_option',
            //     DB::raw('count(*) as "memo_count"')
            // );
            // $memo_counts = $memo_counts->leftJoin('hr_memo_employees as e', 'm.id', 'e.memo_id');
            // $memo_counts = $memo_counts->where('e.employee_id', Auth::user()->employee_id);
            // $memo_counts = $memo_counts->groupBy('m.memo_send_option');
            // $memo_counts = $memo_counts->get();

            $memo_counts = $this->memo_counter();

            return view('/hris/hr-management/hr-memos', 
            [
                'employees'     => $employees, 
                'departments'   => $departments,
                'memos'         => $memos,
                'memo_counts'   => $memo_counts
            ]);
        } else {
            return redirect('/');
            // return view('/auth/login');
        }
    }

    public function memo_data() {
            $memos = DB::table('hr_memo as m');
            $memos = $memos->leftJoin('hr_memo_employees as e', 'm.id', 'e.memo_id');
            $memos = $memos->select(
                'm.memo_send_option',
                DB::raw("DATE_FORMAT(m.uploaded_at, '%m/%d/%Y') as uploaded_at"), 
                'm.file_name', 
                'm.memo_subject',
                DB::raw('(CASE WHEN e.is_viewed is NULL THEN 0 ELSE 1 END) as is_viewed'),
                'e.id'
            );
            $memos = $memos->where('e.employee_id', Auth::user()->employee_id);
            $memos = $memos->orderBy('m.uploaded_at', 'desc');
            $memos = $memos->get();
            return $memos;
    }

    public function memo_counter() {
            $memo_counts = DB::table('hr_memo as m');
            $memo_counts = $memo_counts->leftJoin('hr_memo_employees as e', 'm.id', 'e.memo_id');
            $memo_counts = $memo_counts->select(
                'm.memo_send_option',
                DB::raw('count(*) as "memo_count"')
            );
            $memo_counts = $memo_counts->where('e.employee_id', Auth::user()->employee_id);
            // $memo_counts = $memo_counts->where('e.is_viewed',0)->orWhereNull('e.is_viewed');
            $memo_counts = $memo_counts->groupBy('m.memo_send_option');
            $memo_counts = $memo_counts->get();
            return $memo_counts;
    }

    public function memo_viewed (Request $request) {
        // return $request->id;

        if($request->ajax()){
            try {
                $data_array = array(
                    'is_viewed'   => 1,
                    'viewed_at'   => date('Y-m-d H:i:s')
                );

                $update = DB::table('hr_memo_employees');
                $update = $update->where('id',$request->id);
                $update = $update->update($data_array);
            }
            catch(Exception $e){
                return redirect(route('hr.management.memos'))->with('failed',"operation failed");
            }
        }
    }

    public function send_memo (Request $request) {
// return var_dump($request->recipient);
      $data = array();

      $validator = Validator::make($request->all(), [
         'file' => 'required|mimes:png,jpg,jpeg,csv,txt,pdf,docx,doc,gif|max:4096'
      ]);

      if ($validator->fails()) {

         $data['success'] = 0;
         $data['error'] = $validator->errors()->first('file');// Error response

      }else{
         if($request->file('file')) {

             $file = $request->file('file');
             // return $file;

             // $filename = time().'_'.$file->getClientOriginalName();
             $filename = 'memo_'.$request->send_option.'_'.Auth::user()->employee_id.'_'.date('YmdHis').'.'.$file->getClientOriginalExtension();
             // if ($file->getClientOriginalExtension()=='doc') {
             //     $filename = 'memo.docx';
             // }
             $newfilename = 'memo_'.$request->send_option.'_'.Auth::user()->employee_id.'_'.date('YmdHis').'.pdf';

             // File extension
             $extension = $file->getClientOriginalExtension();

             // File upload location
             $location = 'files';


             // Upload file
            //Store File in Storage Folder
            // $request->file->storeAs('memo-files', $filename);//uncomment if this is the storage location
            // storage/app/uploads/file.png
       
            // Store File in S3 (Simple Storage Service AWS)
            // $request->file->storeAs('uploads', $filename, 's3');//uncomment if this is the storage location

             // $uploadedfile = $file->move(public_path('storage/memo-files'),$filename);
             // $newfile = public_path('storage/tmp/sample.pdf');

            $encrypt = new PageController;
             if ($extension=='pdf'){
                 // $encrypt->encryptFile($request->file('file'), public_path('storage/memo-files/'.$filename), config('app.key'));
                 $encrypt->encryptFile($request->file('file'), public_path('storage/memo-files/'.$filename), env('APP_KEY'));
             }
             
             // File path
             $filepath = url(public_path('tmp/'.$filename));

             // return $request->file('file').'\n'.public_path('storage/memo-files/'.$newfilename);
             
             if ($extension=='png' || $extension=='jpg' || $extension=='jpeg'){
                $file->move(public_path('tmp'),$filename);
                $convertImage = new PDFController;
                $convertImage->convertImagesToPDF(public_path('tmp/'.$filename), public_path('tmp/'.$newfilename));
                $encrypt->encryptFile(public_path('tmp/'.$newfilename), public_path('storage/memo-files/'.$newfilename), config('app.key'));
             }
             if ($extension=='docx'){
                $file->move(public_path('tmp'),$filename);
                $convert = new PDFController;
                $convert->convertWordToPDF(public_path('tmp/'.$filename), public_path('tmp/'.$newfilename));
                $encrypt->encryptFile(public_path('tmp/'.$newfilename), public_path('storage/memo-files/'.$newfilename), config('app.key'));
             }
              /*=== Save Memo to the Database ===*/

            $data = $request->input();
            // return Auth::user()->employee_id;
            try{
                $insert = DB::table('hr_memo');
                $insert = $insert->insertGetId(
                    array(
                        'memo_send_option'  => $request->send_option,
                        'memo_subject'      => $request->memo_subject,
                        'file_name'         => $newfilename,
                        'uploaded_by'       => Auth::user()->employee_id, 
                        'uploaded_at'       => date('Y-m-d H:i:s') 
                    )
                );

                /*=== Insert Memo for Each Employees ===*/
                try{
                    if ($request->send_option=='g') {
                        $insert_all = DB::table('hr_memo_employees')
                            ->insertUsing([
                                'memo_id', 
                                'employee_id', 
                                'created_at'
                            ],
                                DB::table('users')
                                ->select(
                                    DB::raw("'{$insert}' as memo_id"),
                                    'employee_id',
                                    DB::raw("CURRENT_TIMESTAMP() as created_at")
                                )
                                ->where('is_deleted',0)->orWhereNull('is_deleted')
                            );
                    } else {
                        $recipients = explode(',',$request->recipient);
                        // return var_dump($recipients);
                        $select_all = DB::table('users');
                        $select_all = $select_all->select(
                            DB::raw("'{$insert}' as memo_id"),
                            'employee_id',
                            /*DB::raw("CURRENT_TIMESTAMP() as created_at")*/
                        );
                        $select_all = $select_all->where('is_deleted',0)->orWhereNull('is_deleted');
                        if (count($recipients)>0) {
                        // $select_all = $select_all->whereIn('employee_id', $recipients);
                            $select_all = $select_all->whereIn("employee_id", $recipients);
                        }
                        if($request->department!='') {
                            // $select_all = $select_all->where('department',$request->department);
                            $select_all = $select_all->whereRaw("department = '$request->department'");
                        }
                        $select_all = $select_all->get();
                        // return var_dump($select_all);

                        foreach ($select_all as $key => $value) {
                            // return $value->employee_id;
                            $insert_all = DB::table('hr_memo_employees')
                            ->insert(
                                array(
                                    'memo_id'=>$insert, 
                                    'employee_id'=>$value->employee_id, 
                                    'created_at'=>date('Y-m-d H:i:s')
                                )
                            );

                        }
                    }
                } catch (Exception $e) {
                    return redirect(route('hr.management.memos'))->with('failed','Operation Failed!');
                }
            } catch (Exception $e) {
                return redirect(route('hr.management.memos'))->with('failed','Operation Failed!');
            }

             // Response
             // $data['success'] = 1;
             // $data['message'] = 'Uploaded Successfully!';
             // $data['filepath'] = $filepath;
             // $data['extension'] = $extension;
             // $data['uploaded_file'] = $uploadedfile;
             // return $uploadedfile;
         } /*else {
             // Response
             $data['success'] = 2;
             $data['message'] = 'File not uploaded.'; 
         }*/
      }
      event(new FormSubmitted());
   } // End public function send_memo


}
