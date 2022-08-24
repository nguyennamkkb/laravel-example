<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\EmployeeType\EmployeeTypeRepositoryInterface;
use App\Http\Resources\EmployeeTypeResource;
use App\Models\Code;
use App\Http\Requests\EmployeeTypeRequest;
use Illuminate\Support\Facades\DB;

class EmployeeTypeController extends Controller
{
    protected $EmployeeTypeRepository;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(EmployeeTypeRepositoryInterface $EmployeeTypeRepository)
    {
        $this->EmployeeTypeRepository = $EmployeeTypeRepository;
    }
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $limit = $request->limit;
        $list = $this->EmployeeTypeRepository->findBy($keyword)->paginate($limit);
        return EmployeeTypeResource::collection($list);
    }
    
    public function store(EmployeeTypeRequest $request)
    {
        $req = $request->validated();
        DB::beginTransaction();
        try {
            $this->EmployeeTypeRepository->insertGetId([
                'name' => $req['name'],
            ]);
            DB::commit();
            return response()->json(['status' => true], 200);  
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => false], 422);
        }
    }
    public function update(EmployeeTypeRequest $request, $id)
    {
        $req = $request->validated();
        DB::beginTransaction();
        try {
            $this->EmployeeTypeRepository->update($id,[
                'name' => $req['name'],
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

       $resp = $this->EmployeeTypeRepository->delete($id);

        if($resp) {
            return response()->json(['status' => true], 200);    
        }else {
            return response()->json(['status' => false], 422);
        }
    
    }
}
