<?php

namespace App\Repositories\Input;

use App\Repositories\Eloquent\RepositoryEloquent;
use App\Repositories\Input\InputRepositoryInterface;
use App\Models\Input;
use App\Traits\ResponseAPI;
use App\Http\Resources\CodeResource;
use Carbon\Carbon;

class InputRepositoryEloquent extends RepositoryEloquent implements InputRepositoryInterface
{
    public function model()
    {
        return Input::class;
    }

    public function findBy($dateFrom, $dateTo, $category_id, $status,$status_export)
    {

        $query = $this->model->newQuery();
        if (!empty($category_id)) {
            // dd($category_id);
            $query = $query->where('category_id', $category_id);
        }
        if (!empty($status)) {
            $query = $query->where('status', $status);

        }
        if (!empty($status_export)) {
            $query = $query->where('status_export',$status_export);

        }
        if (!empty($dateFrom) ) {
            // dd($dateFrom, $dateTo, $category_id, $status);
            $query = $query->where('date','>=', $dateFrom);
        }
        if (!empty($dateTo) ) {
            // dd($dateFrom, $dateTo, $category_id, $status);
            $query = $query->where('date','<=', $dateTo);
        }

        return $query->orderBy('date', 'desc');
    }
    public function getinput()
    {
        $query = $this->model->newQuery();

        return $query;
    }
    public function findByCustomerId($dateFrom, $dateTo,$customer_id,$status)
    {
        $query = $this->model->newQuery();
        if (!empty($customer_id)) {
            // dd($category_id);
            $query = $query->where('customer_id', $customer_id);
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

        return $query;
    }
}
