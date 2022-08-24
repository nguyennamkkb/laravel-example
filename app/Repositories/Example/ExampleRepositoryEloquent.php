<?php

namespace App\Repositories\Example;

use App\Repositories\Eloquent\RepositoryEloquent;
use App\Repositories\Example\ExampleRepositoryInterface;
use App\Models\Example;
use App\Traits\ResponseAPI;
use App\Http\Resources\CodeResource;


class ExampleRepositoryEloquent extends RepositoryEloquent implements ExampleRepositoryInterface
{
    public function model()
    {
        return Example::class;
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
