<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Casetype;
use App\Models\File;
use App\Services\GenerateColors;
use App\Models\Transaction;
use Carbon\Carbon;

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
        $popColors = $this->colors->getVisualization($popInitials);
        return view('admin.home', [
            'pop_colors' => $popColors,
            'pop_initials' => $popInitials,
            'pop_names' => $popNames,
            'pop_count' => $popCount,
            'pop_map' => $popMap,
            'pop_totals' => $total,
            'transactions' => $transactionAnalysis
        ])->with('success', 'Welcome ' . auth()->user()->first_name);

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
}
