<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\InputDetail;
use App\Models\Customer;
use App\Models\Employees;


class Input extends Model
{
    use HasFactory;
    protected $table="inputs";

    public function inputdetail()
    {
        return $this->hasMany(InputDetail::class, 'input_id', 'id');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function importer()
    {
        return $this->belongsTo(Employees::class, 'importer_id');
    }
    public function carrier()
    {
        return $this->belongsTo(Employees::class, 'carrier_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
   
}
