<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class suppliers extends Model
{
    use HasFactory;

    protected $table='suppliers';
    protected $primaryKey='id';
    protected $fillable = [
        'name',
        'contact',
         'email',
        'address',
        // Add more columns here...
    ];
}
