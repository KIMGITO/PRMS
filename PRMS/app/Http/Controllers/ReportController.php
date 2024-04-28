<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;

class ReportController extends Controller
{
   public function disposalFiles()
    {
       

        $currentDate = now();
        $quarter = $currentDate->quarter; // Get the current quarter directly

        if ($quarter <= 2) {
            $files = File::where('disposal_date', '<=', $currentDate->year.'-06-30')->get();
            $date = '-06-30';
            return view('reports.mature-files',['files'=>$files, 'date'=>$date]);
            
            // If we are in Q1 or Q2, collect files before the end of June
        } else {
            // If we are in Q3 or Q4, collect files before the end of December
            $files = File::all()->where('disposal_date', '>', $currentDate->year . '-06-30')
                ->where('disposal_date', '<=', $currentDate->year . '-12-31');
                $date = '-12-31';
                return view('reports.mature-files',['files'=>$files,'date'=>$date]);
        }
    
    }


public function downloadMatureFiles($date)
    {
        try{
            $date = decrypt($date);
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Invalid Request');
        }
        
        $currentDate = now();

        if($date == '-06-30'){
            // $files = File::all();
            $files = File::where('disposal_date', '<=', $currentDate->year.'-06-30')->get();
        }else{
            $files = File::all()->where('disposal_date', '>', $currentDate->year . '-06-30')
                ->where('disposal_date', '<=', $currentDate->year . '-12-31');
        }
        
        $header = 'Due Files For Disposal ';
        $title = 'Files for disposal on '.$currentDate->year.$date;
        $message = 'In compliance with Judicially policies and guidlines, 
         this disposal report documents the case files due for disposal on. '.$currentDate->year.$date.'.
        Following a comprehensive review of our inventory, it was determined 
        that the files listed below had surpassed their operational lifespan and 
        retention period and were no longer required for operation within the court. There for, this report
        was developed for presentation of the disposal files to the court admin.';

        $view = view('reports.pdf')->with('files', $files)->with('time', Carbon::now())->with('header', $header)->with('title', $title)->with('message', $message);
        $pdf = PDF::loadView('reports.pdf', $view->getData());
        return $pdf->stream('mature-files.pdf');
    }

}
