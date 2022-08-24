<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Customer\CustomerRepositoryInterface;
use App\Http\Resources\CustomersResource;
use App\Models\Code;
use App\Http\Requests\CustomerRequest;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    protected $CustomerRepository;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(CustomerRepositoryInterface $CustomerRepository)
    {
        $this->CustomerRepository = $CustomerRepository;
    }
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $address = $request->address;
        $phone = $request->phone;
        $customerType_id = $request->customerType_id;
        $limit = $request->limit;
        $list = $this->CustomerRepository->findBy($customerType_id,$keyword,$address, $phone)->paginate($limit);
        return CustomersResource::collection($list);
    }
    
    public function store(CustomerRequest $request)
    {
        $req = $request->validated();
        DB::beginTransaction();
        try {
            $this->CustomerRepository->insertGetId([
                'name' => $req['name'],
                'address' => $req['address'],
                'phone' => $req['phone'],
                'email' => $req['email'],
                'customerType_id' => $req['customerType_id'],
            ]);
            DB::commit();
            return response()->json(['status' => true], 200);  
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => false], 422);
        }
    }
    public function update(CustomerRequest $request, $id)
    {
        $req = $request->validated();
        DB::beginTransaction();
        try {
            $this->CustomerRepository->update($id,[
                'name' => $req['name'],
                'address' => $req['address'],
                'phone' => $req['phone'],
                'email' => $req['email'],
                'customerType_id' => $req['customerType_id'],
            ]);
            DB::commit();
            return response()->json(['status' => true], 200);  
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => false], 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

       $resp = $this->CustomerRepository->delete($id);

        if($resp) {
            return response()->json(['status' => true], 200);    
        }else {
            return response()->json(['status' => false], 422);
        }
    
    }
}
