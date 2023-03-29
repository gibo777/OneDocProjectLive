<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
class PersonalDataSheetController extends Controller
{
    
    
    public function personaldatasheet(Request $request){

        $employee_id = $request->emp_id;
        

       $user_details = DB::table('users')
        ->where('employee_id','=', $employee_id)
        ->get();

        // dd($user_details[0]->profile_photo_path);
        
        $LogoF = public_path().'/img/company/onedoc-logo.jpg';
        $imageLogo = base64_encode(file_get_contents($LogoF));
        //dd( $imageLogo);
    
        
        $ProfileImage = public_path().'/storage/'.$user_details[0]->profile_photo_path;
        $PimageLogo = base64_encode(file_get_contents($ProfileImage));
        
        $data = [

            'user_details' => $user_details,
            'imageLogo'=>  $imageLogo,
            'PimageLogo'=> $PimageLogo,
        ];

         // dd($data);
  //     return view('reports.perosonal-data-sheet',compact('user_details','imageLogo'));
 
    //    dd($data);
        $pdf = PDF::setPaper('letter', 'portrait')
       ->setOptions(['dpi' => 100, 'defaultFont' => 'sans-serif', 'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true, 'isJavascriptEnabled' => true])
        ->loadView('reports.perosonal-data-sheet', ['data'=>$data])->setWarnings(false);
        
        $pdf->output();
       $dom_pdf = $pdf->getDomPDF();
        
       $canvas = $dom_pdf ->get_canvas();
       $canvas->page_text(540, 753, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 8, array(0, 0, 0));
   
        return $pdf->download('PDS-'. $employee_id .'.pdf');
    }
}
