<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class items extends Model

{
    protected $table='items';
    protected $primaryKey='id';
    protected $fillable = ['name','item_no','quantity','category_id'];



    use HasFactory;


   
public function categories()
{
    return $this->belongsTo(categories::class,'category_id');
}

//department.php
    public function suppliers()
    {
        return $this->belongsTo(suppliers::class, 'supplier_id');

    }
    public function department()
    {
        return $this->belongsTo(department::class, 'department_id');

    }

   public function itemUnit()
    {
       return $this->belongsTo(itemUnit::class, 'unit_id');

   }
    
public function issue_item()
{
    return $this->hasMany(issue_item::class, 'item_id');
}

   


}

