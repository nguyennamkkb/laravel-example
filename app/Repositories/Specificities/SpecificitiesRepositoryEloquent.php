<?php

namespace App\Repositories\Specificities;

use App\Repositories\Eloquent\RepositoryEloquent;
use App\Repositories\Specificities\SpecificitiesRepositoryInterface;
use App\Models\Specificity;


class SpecificitiesRepositoryEloquent extends RepositoryEloquent implements SpecificitiesRepositoryInterface
{
    public function model()
    {
        return Specificity::class;
    }

    public function findBy($keyword)
    {
        $query = $this->model->newQuery();

        if (!empty($keyword)) {
            $query = $this->model->where('name', 'like', "%$keyword%");
        }

        return $query->orderBy('id', 'desc');
    }

}
