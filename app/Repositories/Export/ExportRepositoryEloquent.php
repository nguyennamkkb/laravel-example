<?php

namespace App\Repositories\Export;

use App\Repositories\Eloquent\RepositoryEloquent;
use App\Repositories\Export\ExportRepositoryInterface;
use App\Models\Export;
use App\Traits\ResponseAPI;
use App\Http\Resources\CodeResource;
use Carbon\Carbon;

class ExportRepositoryEloquent extends RepositoryEloquent implements ExportRepositoryInterface
{
    public function model()
    {
        return Export::class;
    }

    public function findBy($dateFrom, $dateTo, $category_id, $status)
    {
        // dd($dateFrom, $dateTo, $category_id, $status);
        $query = $this->model->newQuery();
        if (!empty($category_id)) {
            // dd($category_id);
            $query = $query->where('category_id', $category_id);
        }
        if (!empty($status)) {
            $query = $query->where('status', $status);

        }
        if (!empty($dateFrom) ) {
            // dd($dateFrom, $dateTo, $category_id, $status);
            $query = $query->where('date','>=', $dateFrom);
        }
        if (!empty($dateTo) ) {
            // dd($dateFrom, $dateTo, $category_id, $status);
            $query = $query->where('date','<=', $dateTo);
        }
        // if (!empty($dateFrom) && !empty($dateTo) && !empty($status) && !empty($category_id)) {
        //     dd($dateFrom, $dateTo, $category_id, $status);
        //     $query = $this->model->whereBetween('date', [$dateFrom, $dateTo])->where('category_id', $category_id)->where('status', $status);
        // }

        
        return $query->orderBy('date', 'desc');
    }
    public function getinput()
    {
        $query = $this->model->newQuery();

        return $query;
    }
}
