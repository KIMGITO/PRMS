<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Casetype extends Model
{
    use HasFactory;
    public function files(){ 
        return $this->hasMany(File::class);
    }
}
