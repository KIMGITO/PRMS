<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoggedActivities extends Model
{
    use HasFactory;

    protected $table = 'logged_activities';
    protected $fillable = ['user_id','description'];
}
