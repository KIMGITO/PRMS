<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Casetype;
use App\Models\File;
use App\Services\GenerateColors;
use App\Models\Transaction;
use Carbon\Carbon;
use App\Models\Message;
use App\Events\ActivityProcessed;
use App\Models\LoggedActivities;
use App\Models\User;

class DashboardController extends Controller
{

    protected $colors;

    public function __construct(GenerateColors $colors){
        $this->colors = $colors;
    }


    /**
     * @param mixed $null
     * Display admin dashboard
     * @return mixed
     */
        public function adminDash(){
        $caseTypes = Casetype::all();

        $total = File::all()->count();
        $popCount = [];
        $popInitials = [];
        $popNames = [];

        foreach($caseTypes as $caseType){
            $count = File::where('casetype_id', $caseType->id)->count();
            $popCount[]= $count;
            $popInitials[] = $caseType->initials;
            $popNames[] = $caseType->case_type;


        }
        $popMap = array_combine($popInitials, $popNames);

        $transactionAnalysis = $this->transactionAnalysis();
        $messages = $this->newMessage();
        $message_count = count($messages);
        $logged_activities = $this->getActivities();
        
        // return $messages;
        $popColors = $this->colors->getVisualization($popInitials);
        return view('admin.home', [
            'pop_colors' => $popColors,
            'pop_initials' => $popInitials,
            'pop_names' => $popNames,
            'pop_count' => $popCount,
            'pop_map' => $popMap,
            'pop_totals' => $total,
            'transactions' => $transactionAnalysis,
            'message_count'=>$message_count,
            'messages'=>$messages,
            'logged_activities' => $logged_activities,
        ])->with('success', 'Welcome ' . auth()->user()->first_name);

    }

    /**
     * Display user dashboard
     * @param string $null
     * @return mixed
     */

     public function userDash() {
        $files = $this->getFiles();
        $messages = $this->newMessage();
        $message_count = count($messages);
        return view('user.home',[
            'files'=>$files,
            'message' => '',
            'query'=>'',
            'message_count'=>$message_count,
            'messages' =>$messages
            ])->with('success','Welcome '.auth()->user()->first_name);
    }

    /**
     * @param $ null
     * Get transaction data from DB.
     *
     * @return array
     */
    public function transactionAnalysis()
    {
        $endDate = Carbon::today();
        $startDate = $endDate->copy()->subDays(7);

        $datesInRange = [];
        $currentDate = $startDate->copy();

        while ($currentDate <= $endDate) {
            $datesInRange[$currentDate->format('Y-m-d')] = [
                'issuedCount' => 0,
                'returnCount' => 0
            ];
            $currentDate->addDay();
        }

        $issuedTransactions = Transaction::whereBetween('issuedDate', [$startDate, $endDate])
            ->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->issuedDate)->format('Y-m-d');
            });

        $returnTransactions = Transaction::whereBetween('dateBack', [$startDate, $endDate])
            ->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->dateBack)->format('Y-m-d');
            });

        foreach ($issuedTransactions as $date => $transactionGroup) {
            $datesInRange[$date]['issuedCount'] = $transactionGroup->count();
        }

        foreach ($returnTransactions as $date => $transactionGroup) {
            if (isset($datesInRange[$date])) {
                $datesInRange[$date]['returnCount'] = $transactionGroup->count();
            } else {
                $datesInRange[$date] = [
                    'issuedCount' => 0,
                    'returnCount' => $transactionGroup->count()
                ];
            }
        }

        $dates = array_keys($datesInRange);
        $date = array_map(function($date) {
            return Carbon::parse($date)->format('d/m');
        }, $dates);

        $issuedCounts = array_column($datesInRange, 'issuedCount');
        $returnCounts = array_column($datesInRange, 'returnCount');

        return [
            'dates' => $dates,
            'issuedCounts' => $issuedCounts,
            'returnCounts' => $returnCounts
        ];
    }

    /**
 * Returns the new messages or fetches 5 previous messages if empty
 *
 * @return array
 */
    public function newMessage(){
        $messages = Message::whereNull('red')->orderBy('created_at','asc')->with('client')->get();
        if ($messages->isEmpty()) {
            $messages = Message::orderBy('created_at', 'desc')->with('client')->get();
            if ($messages->count() > 10) {
                $messagesToDelete = Message::orderBy('created_at', 'asc')->take($messages->count() - 10)->get();
                foreach ($messagesToDelete as $message) {
                    event(new ActivityProcessed(auth()->user()->id, 'System automatically Delete excess messages '.$message->id, 'delete', false));
                    $message->delete();
                }
                $messages = Message::where('red','!=',null)->orderBy('created_at','asc')->with('client')->get();
            }
        }
        return $messages;
    }

    public function getActivities(){
        $activities = LoggedActivities::orderBy('created_at','desc')->take(4)->get();
        foreach($activities as $activity) {
            if ($activity->user_id!== 0) {
                $user = User::find($activity->user_id);
                try{
                    $activity->first_name = $user->first_name;
                    $activity->last_name =  $user->last_name;
                }catch(\Throwable $e){
                    $activity->user_name = '( User Does Not Exist )';
                }
            } else {
                $activity->user_name = 'N/A';
            }
        }
        return  $activities;
    }

    public function getFiles(){
    $endDate = Carbon::today();
    $startDate = $endDate->copy()->subDays(14);

    $fileIds = Transaction::whereBetween('created_at', [$startDate, $endDate])
        ->select('file_id')
        ->groupBy('file_id')
        ->orderByRaw('COUNT(*) DESC')
        ->limit(5)
        ->pluck('file_id');

    if ($fileIds->isEmpty()) {
        $fileIds = File::orderBy('created_at', 'desc')->limit(5)->pluck('id');
    }

    $files = File::whereIn('id', $fileIds)->get();

    foreach($files as $file){
        $data = Transaction::where('file_id', $file->id)->orderBy('created_at', 'desc')->first();
        if(!empty($data)){
            $file->status = $data->dateBack ? 'available' : 'on Loan';
        } else {
            $file->status = 'available';
        }
    }

    return $files;
}
}
