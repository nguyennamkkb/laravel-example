<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Enterprise\EnterpriseRepositoryInterface;
use App\Http\Resources\EnterpriseResource;
use App\Models\Code;
use App\Http\Requests\EnterpriseRequest;
use Illuminate\Support\Facades\DB;

class EnterpriseController extends Controller
{
    protected $EnterpriseRepository;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(EnterpriseRepositoryInterface $EnterpriseRepository)
    {
        $this->EnterpriseRepository = $EnterpriseRepository;
    }
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $address = $request->address;
        $phone = $request->phone;
        $limit = $request->limit;
        $list = $this->EnterpriseRepository->findBy($keyword,$address, $phone)->paginate($limit);
        return EnterpriseResource::collection($list);
    }
    
    public function store(EnterpriseRequest $request)
    {
        $req = $request->validated();
        DB::beginTransaction();
        try {
            $this->EnterpriseRepository->insertGetId([
                'name' => $req['name'],
                'shortName' => $req['shortName'],
                'employees' => $req['employees'],
            ]);
            DB::commit();
            return response()->json(['status' => true], 200);  
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => false], 422);
        }
    }
    public function update(EnterpriseRequest $request, $id)
    {
        $req = $request->validated();
        DB::beginTransaction();
        try {
            $this->EnterpriseRepository->update($id,[
                'name' => $req['name'],
                'address' => $req['address'],
                'phone' => $req['phone'],
                'email' => $req['email'],
                'EnterpriseType_id' => $req['EnterpriseType_id'],
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

       $resp = $this->EnterpriseRepository->delete($id);

        if($resp) {
            return response()->json(['status' => true], 200);    
        }else {
            return response()->json(['status' => false], 422);
        }
    
    }
}
