<?php

namespace App\Repositories\InputDetail;

use App\Repositories\Eloquent\RepositoryEloquent;
use App\Repositories\InputDetail\InputDetailRepositoryInterface;
use App\Models\InputDetail;
use App\Traits\ResponseAPI;
use App\Http\Resources\CodeResource;


class InputDetailRepositoryEloquent extends RepositoryEloquent implements InputDetailRepositoryInterface
{
    public function model()
    {
        return InputDetail::class;
    }

    public function findBy($keyword)
    {
        $query = $this->model->newQuery();
        return $query;
    }
    public function findByInputId($id)
    {
        $query = $this->model->newQuery()->where('input_id',$id);

        return $query;
    }

}
