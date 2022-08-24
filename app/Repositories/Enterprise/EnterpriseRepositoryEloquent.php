<?php

namespace App\Repositories\Enterprise;

use App\Repositories\Eloquent\RepositoryEloquent;
use App\Repositories\Enterprise\EnterpriseRepositoryInterface;
use App\Models\Enterprise;
use App\Traits\ResponseAPI;
use App\Http\Resources\CodeResource;


class EnterpriseRepositoryEloquent extends RepositoryEloquent implements EnterpriseRepositoryInterface
{
    public function model()
    {
        return Enterprise::class;
    }

    public function findBy($keyword,$shortName, $phone)
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

        return $query->orderBy('name', 'desc');
    }

}
