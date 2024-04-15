<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class department extends Model
{
    protected $table='departments';
    protected $primaryKey='id';
    protected $fillable = [
        'name',
        'description',
         
        // Add more columns here...
    ];



    use HasFactory;


    
   public function items()
   {
       return $this->hasMany(items::class,'department_id');
   }
}
