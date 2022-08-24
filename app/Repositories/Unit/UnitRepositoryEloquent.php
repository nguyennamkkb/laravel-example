<?php

namespace App\Repositories\Unit;

use App\Repositories\Eloquent\RepositoryEloquent;
use App\Repositories\Unit\UnitRepositoryInterface;
use App\Models\Unit;


class UnitRepositoryEloquent extends RepositoryEloquent implements UnitRepositoryInterface
{
    public function model()
    {
        return Unit::class;
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
