<?php

namespace App\Repositories\Code;

use App\Repositories\Eloquent\RepositoryEloquent;
use App\Repositories\Code\CodeRepositoryInterface;
use App\Models\Code;
use App\Traits\ResponseAPI;
use App\Http\Resources\CodeResource;


class CodeRepositoryEloquent extends RepositoryEloquent implements CodeRepositoryInterface
{
    public function model()
    {
        return Code::class;
    }

    public function findBy($status, $keyword)
    {
        $query = $this->model->newQuery();
        // dd($status);
        if (!empty($status)) {

            $query = $this->model->where('isUsed',$status-1);
        }
        if (!empty($keyword)) {
            $query = $this->model->where('code', 'like', "%$keyword%");
        }

        return $query->orderBy('isUsed', 'asc');
    }

}
