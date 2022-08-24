<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Export extends Model
{
    use HasFactory;
    public function exportdetail()
    {
        return $this->hasMany(ExportDetail::class, 'export_id', 'id');
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
