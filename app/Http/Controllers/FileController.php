<?php

namespace App\Http\Controllers;
   
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
  
class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('/test/fileUpload');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	// $request->file->getClientOriginalName();
        $request->validate([
            'file' => 'required|mimes:pdf,xlx,csv,docx,doc|max:2048',
        ]);
    
        $fileName = Auth::user()->employee_id.'_preview-memo_'.time().'.'.$request->file->extension();

        //Store File in Storage Folder
        //$request->file->storeAs('uploads', $fileName);//uncomment if this is the storage location
        // storage/app/uploads/file.png

		// Store File in Public Folder
		$request->file->move(public_path('storage/tmp'), $fileName);//uncomment if this is the storage location
		// public/uploads/file.png
   
		// Store File in S3 (Simple Storage Service AWS)
		// $request->file->storeAs('uploads', $fileName, 's3');//uncomment if this is the storage location


        /*  
            Write Code Here for
            Store $fileName name in DATABASE from HERE 
        */
     
        return back()
            ->with('success',$request->file->getClientOriginalName())
            ->with('file', $fileName);
   
    }


    public function preview_memo (Request $request)
    {
    	return var_dump($request->all());
    	// return $request->file->extension();


    	// $request->file->getClientOriginalName();
        /*$request->validate([
            'file' => 'required|mimes:pdf,xlx,csv,docx,doc|max:2048',
        ]);
    
        $fileName = 'preview_memo-'.time().'.'.$request->file->extension();*/
        // $fileName = 'preview_memo-'.time().'.pdf';

        //Store File in Storage Folder
        //$request->file->storeAs('uploads', $fileName);//uncomment this is the storage location
        // storage/app/uploads/file.png

		// Store File in Public Folder
		// $request->file->move(public_path('storage/tmp'), $fileName);//uncomment this is the storage location
		// public/uploads/file.png
   
		// Store File in S3
		// $request->file->storeAs('uploads', $fileName, 's3');//uncomment this is the storage location


        /*  
            Write Code Here for
            Store $fileName name in DATABASE from HERE 
        */
     
        // return back()
        //     ->with('success',$request->file->getClientOriginalName())
        //     ->with('file', $fileName);
   
    }
}