<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FreeResource;
use App\Repositories\Payment\PaymentRepositoryInterface;
use App\Repositories\Customer\CustomerRepositoryInterface;
use App\Repositories\Input\InputRepositoryInterface;
use Illuminate\Support\Collection;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
   protected $paymentRepository;
   protected $customerRepository;
   public function __construct(
       PaymentRepositoryInterface $paymentRepository,
       CustomerRepositoryInterface $customerRepository,
       InputRepositoryInterface  $InputRepository
       )
    {
        $this->paymentRepository = $paymentRepository;     
        $this->customerRepository = $customerRepository;     
        $this->InputRepository = $InputRepository;
    }
    public function thanhtoanvau(Request $request)
    {
        $status = $request->status;
        $dateFrom = $request->dateFrom;
        $dateTo = $request->dateTo;
        $customer_id = $request->customer_id;
        $list = $this->paymentRepository->findBy($customer_id,$dateFrom,$dateTo,$status)->get();
        $customer = $this->customerRepository->find($customer_id)->first();
        $input = $this->InputRepository->findByCustomerId($dateFrom, $dateTo,$customer_id,$status)->get();
        $collection = collect($input);
        return response()->json([
            'status' => true,
            'data'=>$list,
            'customer'=>$customer->name,
            'prepay'=>$collection->sum('prepay'),
            'totalmoney'=>$collection->sum('totalmoney'),
    ], 200);  
    }
}
