<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purpose extends Model
{
    use HasFactory;

    public function transactions(){
        return $this->belongsToMany(Transaction::class,'transaction_purpose_pivot');
    }
}
