<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class issue_item extends Model
{
    use HasFactory;

    protected $table='issue_items';
    protected $primaryKey='id';
    protected $fillable = ['name','item_id','quantity','staff_id'];

  // public function items()
   // {
     //   return $this->belongsTo(items::class, 'item_id');
   // }

    

    public function staff()
    {
        return $this->belongsTo(staff::class, 'staff_id');
    }


    //public function myitems()
   // {
     //   return $this->hasMany(items::class,'item_id');
   //}

   public function items()
{
    return $this->belongsTo(items::class, 'item_id');
}
  
}
