<?php

namespace App\Repositories\Payment;

use App\Repositories\Eloquent\RepositoryEloquent;
use App\Repositories\Payment\PaymentRepositoryInterface;
use App\Models\InputDetail;

use App\Traits\ResponseAPI;
use App\Http\Resources\CodeResource;


class PaymentRepositoryEloquent extends RepositoryEloquent implements PaymentRepositoryInterface
{
    public function model()
    {
        return InputDetail::class;
    }

    public function findBy($customer,$dateFrom,$datoTo, $status)
    {
        $query = $this->model->newQuery();
        $query = $query->select('inputs.date','input_details.weight','input_details.price','input_details.total')
                        ->join('customers','customers.id','input_details.customer_id')
                        ->join('inputs','inputs.id','input_details.input_id')
                        ->where([
                            ['customers.id', '=', $customer],
                            ['inputs.category_id',3],
                            ['inputs.status', '=', $status],
                            ['inputs.date', '>=', $dateFrom],
                            ['inputs.date', '<=', $datoTo],
                        ]);
        return $query->orderBy('date', 'desc');
    }

}
