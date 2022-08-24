<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Unit\UnitRepositoryInterface;
use App\Http\Resources\UnitResource;
use App\Http\Requests\UnitRequest;
use Illuminate\Support\Facades\DB;

class UnitController extends Controller
{
    protected $UnitRepository;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(UnitRepositoryInterface $UnitRepository)
    {
        $this->UnitRepository = $UnitRepository;
    }
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $limit = $request->limit;
        $list = $this->UnitRepository->findBy($keyword)->paginate($limit);
        return UnitResource::collection($list);
    }
    
    public function store(UnitRequest $request)
    {
        $req = $request->validated();
        DB::beginTransaction();
        try {
            $this->UnitRepository->insertGetId([
                'name' => $req['name'],
            ]);
            DB::commit();
            return response()->json(['status' => true], 200);  
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => false], 422);
        }
    }
    public function update(UnitRequest $request, $id)
    {
        $req = $request->validated();
        DB::beginTransaction();
        try {
            $this->UnitRepository->update($id,[
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

       $resp = $this->UnitRepository->delete($id);

        if($resp) {
            return response()->json(['status' => true], 200);    
        }else {
            return response()->json(['status' => false], 422);
        }
    
    }
}
