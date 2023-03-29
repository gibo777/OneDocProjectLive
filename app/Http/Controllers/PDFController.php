<?php

namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use PDF;
use Auth;
use App\Models\LeaveForm;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Arr;
  
class PDFController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function generatePDF()
    {
        $data = [
            'title' => 'Testing',
            'date' => date('m/d/Y')
        ];

        /*$holidays = DB::table('holidays')->get();
        $departments = DB::table('departments')->get();
        $leave_types = DB::table('leave_types')->get();
        $pdf = PDF::loadView('/reports/myPDF', ['holidays'=>$holidays, 'departments'=>$departments, 'leave_types'=>$leave_types, $data]);*/
          
        $pdf = PDF::loadView('/reports/myPDF', $data);
    
        return $pdf->download('Testing.pdf');
    }

    public function viewPDF () {

        $holidays = DB::table('holidays')->get();
        $departments = DB::table('departments')->get();
        $leave_types = DB::table('leave_types')->get();
        $data = [
            'title' => 'One Document Corporation',
            'date' => date('m/d/Y'),
            'holidays'=>$holidays,
            'departments'=>$departments,
            'leave_types'=>$leave_types
        ];
        return view('/reports/myPDF', $data);
    }

    public function convertWordToPDF($old_file='', $new_file='', $file_path='')
    {
            /* Set the PDF Engine Renderer Path */
        $domPdfPath = base_path('vendor/dompdf/dompdf');
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');
         
        //Load word file
        // $Content = \PhpOffice\PhpWord\IOFactory::load(public_path('storage/memo-archives/helloWorld.docx'));

        $Content = \PhpOffice\PhpWord\IOFactory::load($file_path.$old_file);
        // $Content = \PhpOffice\PhpWord\IOFactory::load(public_path('storage/tmp/memo.doc'));
 
        //Save it into PDF
        $PDFWriter = \PhpOffice\PhpWord\IOFactory::createWriter($Content,'PDF');
        // $PDFWriter->save(public_path('storage/memo-archives/new-result.pdf')); 
        $PDFWriter->save($file_path.$new_file); 
        echo 'File has been successfully converted';
    }

    public function convertImagesToPDF($old_path='', $new_path='') {
        // $file = $file_path.$old_file;
        $image = new \Imagick($old_path);

        $image->setImageFormat('pdf');

        $image->writeImage($new_path);
    }

}