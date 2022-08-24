<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Employee\EmployeeRepositoryInterface;
use App\Http\Resources\EmployeesResource;
use App\Http\Requests\EmployeeRequest;
use Illuminate\Support\Facades\DB;


class EmployeeController extends Controller
{
    protected $EmployeeRepository;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(EmployeeRepositoryInterface $EmployeeRepository)
    {
        $this->EmployeeRepository = $EmployeeRepository;
    }
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $address = $request->address;
        $phone = $request->phone;
        $employeeType_id = $request->employeeType_id;
        $limit = $request->limit;
        $list = $this->EmployeeRepository->findBy($employeeType_id,$keyword,$address, $phone)->paginate($limit);
        return EmployeesResource::collection($list);
    }
    
    public function store(EmployeeRequest $request)
    {
        $req = $request->validated();
        DB::beginTransaction();
        try {
            $this->EmployeeRepository->insertGetId([
                'name' => $req['name'],
                'address' => $req['address'],
                'phone' => $req['phone'],
                'email' => $req['email'],
                'employeeType_id' => $req['employeeType_id'],
            ]);
            DB::commit();
            return response()->json(['status' => true], 200);  
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => false], 422);
        }
    }
    public function update(EmployeeRequest $request, $id)
    {
        $req = $request->validated();
        DB::beginTransaction();
        try {
            $this->EmployeeRepository->update($id,[
                'name' => $req['name'],
                'address' => $req['address'],
                'phone' => $req['phone'],
                'email' => $req['email'],
                'employeeType_id' => $req['employeeType_id'],
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

       $resp = $this->EmployeeRepository->delete($id);

        if($resp) {
            return response()->json(['status' => true], 200);    
        }else {
            return response()->json(['status' => false], 422);
        }
    
    }
}
