<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExportDetail extends Model
{
    use HasFactory;
    public function export()
    {
        return $this->belongsTo(Export::class, 'input_id');
    }
    public function categorychildren()
    {
        return $this->belongsTo(Category_Child::class, 'categorychildren_id');
    }
}
