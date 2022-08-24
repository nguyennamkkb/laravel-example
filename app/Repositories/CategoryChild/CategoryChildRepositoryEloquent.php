<?php

namespace App\Repositories\CategoryChild;

use App\Repositories\Eloquent\RepositoryEloquent;
use App\Repositories\CategoryChild\CategoryChildRepositoryInterface;
use App\Models\Category_Child;
use App\Traits\ResponseAPI;
use App\Http\Resources\CodeResource;


class CategoryChildRepositoryEloquent extends RepositoryEloquent implements CategoryChildRepositoryInterface
{
    public function model()
    {
        return Category_Child::class;
    }

    public function findBy($categoryid,$keyword)
    {
        $query = $this->model->newQuery();
        // dd($status);
        if (!empty($categoryid)) {

            $query = $this->model->where('category_id',$categoryid);
        }
        if (!empty($keyword)) {
            $query = $this->model->where('name', 'like', "%$keyword%");
        }

        return $query->orderBy('id', 'desc');
    }
    public function findByCategoryid($categoryid)
    {
        $query = $this->model->newQuery();
      
        if (!empty($categoryid)) {
            $query = $this->model->where('category_id','=',$categoryid);
        }
        return $query;
    }

}
