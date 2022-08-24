<?php

namespace App\Repositories\Category;

use App\Repositories\Eloquent\RepositoryEloquent;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Models\Category;
use App\Traits\ResponseAPI;
use App\Http\Resources\CodeResource;


class CategoryRepositoryEloquent extends RepositoryEloquent implements CategoryRepositoryInterface
{
    public function model()
    {
        return Category::class;
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
