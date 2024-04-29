<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable=[
        'file_id',
        'user_id',
        'department_id',
        'name',
        'issuedDate',
        'dateExpected',
        'dateBack'
    ];

    public function files(){
        return $this->belongsTo(File::class);
    }

    public function users(){
        return $this->belongsTo(User::class);
    }
    
    public function purposes(){
        return $this->belongsToMany(Purpose::class,'transaction_purpose_pivot');
    }
    public function department(){
        return $this->belongsTo(Department::class);
    }
}
