<?php

namespace App\Repositories\ExportDetail;

use App\Repositories\Eloquent\RepositoryEloquent;
use App\Repositories\ExportDetail\ExportDetailRepositoryInterface;
use App\Models\ExportDetail;
use App\Traits\ResponseAPI;
use App\Http\Resources\CodeResource;


class ExportDetailRepositoryEloquent extends RepositoryEloquent implements ExportDetailRepositoryInterface
{
    public function model()
    {
        return ExportDetail::class;
    }

    public function findBy($keyword)
    {
        $query = $this->model->newQuery();
        // if (!empty($address)) {

        //     $query = $this->model->where('address', 'like', "%$address%");
        // }
        // if (!empty($phone)) {
        //     $query = $this->model->where('phone', 'like', "%$phone%");
        // }
        // if (!empty($keyword)) {
        //     $query = $this->model->where('name', 'like', "%$keyword%");
        // }

        return $query;
    }

}
