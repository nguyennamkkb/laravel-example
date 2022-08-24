<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CustomerType\CustomerTypeRepositoryInterface;
use App\Http\Resources\CustomerTypeResource;
use App\Models\Code;
use App\Http\Requests\CustomerTypeRequest;
use Illuminate\Support\Facades\DB;

class CustomerTypeController extends Controller
{
    protected $CustomerTypeRepository;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(CustomerTypeRepositoryInterface $CustomerTypeRepository)
    {
        $this->CustomerTypeRepository = $CustomerTypeRepository;
    }
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $limit = $request->limit;
        $list = $this->CustomerTypeRepository->findBy($keyword)->paginate($limit);
        return CustomerTypeResource::collection($list);
    }
    
    public function store(CustomerTypeRequest $request)
    {
        $req = $request->validated();
        DB::beginTransaction();
        try {
            $this->CustomerTypeRepository->insertGetId([
                'name' => $req['name'],
            ]);
            DB::commit();
            return response()->json(['status' => true], 200);  
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => false], 422);
        }
    }
    public function update(CustomerTypeRequest $request, $id)
    {
        $req = $request->validated();
        DB::beginTransaction();
        try {
            $this->CustomerTypeRepository->update($id,[
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

       $resp = $this->CustomerTypeRepository->delete($id);

        if($resp) {
            return response()->json(['status' => true], 200);    
        }else {
            return response()->json(['status' => false], 422);
        }
    
    }
}
