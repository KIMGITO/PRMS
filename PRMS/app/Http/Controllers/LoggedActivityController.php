<?php

namespace App\Http\Controllers;

use App\Models\LoggedActivities;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;

class LoggedActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
public function index()
{
    $activities = LoggedActivities::orderBy('action')->get();
    $activities->each(function ($activity) {
        if ($activity->user_id !== 0) {
            $user = User::find($activity->user_id);
            $activity->user_name = $user->first_name.' '.$user->last_name;
        } else {
            $activity->user_name = 'N/A';
        }
        $activity->date = Carbon::parse($activity->created_at)->format('d/m/Y');
        $activity->time = Carbon::parse($activity->created_at)->format('H:i:s');
    });
    return view('system.activities.logged-activities', ['activities' => $activities]);
}

    /**
     * Show the form for creating a new resource.
     */
    public function store($user, $description, $type, bool $status)
    {
        $actvity = LoggedActivities::create(['user_id'=>$user,'description'=>$description,'action'=>$type,'status'=>$status]);
        return $actvity;
    }

   // In your controller file Import the LoggedActivity model

public function deleteSelectedActivities(Request $request)
{
    // dd($selectedIds = json_decode($request->input('selectedActivities')));
    $selectedIds = $request->input('selectedActivities');

    LoggedActivities::whereIn('id', $selectedIds)->delete();

    return redirect()->back()->with('success', 'Selected activities deleted successfully');
}
    

}
