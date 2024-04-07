<?php

namespace App\Http\Controllers;

use App\Models\LoggedActivities;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LoggedActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store($user, $description, $type, bool $status)
    {
       $actvity = LoggedActivities::create(['user_id'=>$user,'description'=>$description,'created_at'=>Carbon::now()]);
       return $actvity;
    }

    /**
     * Store a newly created resource in storage.
     */
    

}
