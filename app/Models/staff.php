<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class staff extends Model
{
    use HasFactory;


    public function issue_item()
    {
        return $this->hasMany(issue_item::class,'id');
    }
   
}
