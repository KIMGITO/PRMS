<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Casetype;
use App\Models\File;

class DashboardController extends Controller
{
    public function adminDash(){
    $caseTypes = Casetype::all();

    $caseTypeCounts = [];
    foreach($caseTypes as $caseType){
        
        $count = File::where('casetype_id', $caseType->id)->count();
        
        $caseTypeCounts[$caseType->initials] = $count;
    }
    dd($caseTypeCounts);

}
}
