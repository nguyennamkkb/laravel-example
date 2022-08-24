<?php

namespace App\Repositories\EmployeeType;

use App\Repositories\Eloquent\RepositoryEloquent;
use App\Repositories\EmployeeType\EmployeeTypeRepositoryInterface;
use App\Models\EmployeeType;


class EmployeeTypeRepositoryEloquent extends RepositoryEloquent implements EmployeeTypeRepositoryInterface
{
    public function model()
    {
        return EmployeeType::class;
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
