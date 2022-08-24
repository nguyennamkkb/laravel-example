<?php

namespace App\Repositories\CustomerType;

use App\Repositories\Eloquent\RepositoryEloquent;
use App\Repositories\CustomerType\CustomerTypeRepositoryInterface;
use App\Models\CustomerType;


class CustomerTypeRepositoryEloquent extends RepositoryEloquent implements CustomerTypeRepositoryInterface
{
    public function model()
    {
        return CustomerType::class;
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
