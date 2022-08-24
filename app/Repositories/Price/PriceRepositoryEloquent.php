<?php

namespace App\Repositories\Price;

use App\Repositories\Eloquent\RepositoryEloquent;
use App\Repositories\Price\PriceRepositoryInterface;
use App\Models\Price;


class PriceRepositoryEloquent extends RepositoryEloquent implements PriceRepositoryInterface
{
    public function model()
    {
        return Price::class;
    }

    public function findBy($keyword)
    {
        $query = $this->model->newQuery();
        // dd($status);
        // if (!empty($status)) {

        //     $query = $this->model->where('isUsed',$status-1);
        // }
        if (!empty($keyword)) {
            $query = $this->model->where('name', 'like', "%$keyword%");
        }

        return $query->orderBy('id', 'desc');
    }

}
