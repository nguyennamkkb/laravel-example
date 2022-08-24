<?php

namespace App\Repositories\Supplier;

use App\Repositories\Eloquent\RepositoryEloquent;
use App\Repositories\Supplier\SupplierRepositoryInterface;
use App\Models\Supplier;
use App\Http\Resources\SupplierResource;


class SupplierRepositoryEloquent extends RepositoryEloquent implements SupplierRepositoryInterface
{
    public function model()
    {
        return Supplier::class;
    }

    public function findBy($status, $keyword)
    {
        $query = $this->model->newQuery();
        // dd($status);
        if (!empty($status)) {

            $query = $this->model->where('status',$status);
        }
        if (!empty($keyword)) {
            $query = $this->model->where('name', 'like', "%$keyword%");
        }

        return $query;
    }

}
