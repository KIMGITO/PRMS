<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class File extends Model
{
    use HasFactory;
    public function casetype(){
        return $this->belongsTo(Casetype::class);
    }

    public function judge(){
        return $this->belongsTo(Judge::class);
    }

    public function court(){
        return $this->belongsTo(Court::class);
    }

    public function transaction(){
        return $this->hasMany(Transaction::class);
    }
    
}
