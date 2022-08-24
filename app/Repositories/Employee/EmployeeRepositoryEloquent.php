<?php

namespace App\Repositories\Employee;

use App\Repositories\Eloquent\RepositoryEloquent;
use App\Repositories\Employee\EmployeeRepositoryInterface;
use App\Models\Employees;
use App\Traits\ResponseAPI;
use App\Http\Resources\CodeResource;


class EmployeeRepositoryEloquent extends RepositoryEloquent implements EmployeeRepositoryInterface
{
    public function model()
    {
        return Employees::class;
    }

    public function findBy($employeeType_id,$keyword,$address, $phone)
    {
        $query = $this->model->newQuery();
        if (!empty($address)) {

            $query = $this->model->where('address', 'like', "%$address%");
        }
        if (!empty($phone)) {
            $query = $this->model->where('phone', 'like', "%$phone%");
        }
        if (!empty($keyword)) {
            $query = $this->model->where('name', 'like', "%$keyword%");
        }
        if (!empty($employeeType_id)) {
            $query = $this->model->where('employeeType_id', "$employeeType_id");
        }

        return $query->orderBy('name', 'desc');
    }

}
