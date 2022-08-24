<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Price\PriceRepositoryInterface;
use App\Http\Resources\PriceResource;
use App\Http\Requests\PriceRequest;
use Illuminate\Support\Facades\DB;

class PriceController extends Controller
{
    protected $PriceRepository;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(PriceRepositoryInterface $PriceRepository)
    {
        $this->PriceRepository = $PriceRepository;
    }
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $limit = $request->limit;
        $list = $this->PriceRepository->findBy($keyword)->paginate($limit);
        return PriceResource::collection($list);
    }
    
    public function store(PriceRequest $request)
    {
        $req = $request->validated();
        DB::beginTransaction();
        try {
            $this->PriceRepository->insertGetId([
                'name' => $req['name'],
            ]);
            DB::commit();
            return response()->json(['status' => true], 200);  
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => false], 422);
        }
    }
    public function update(PriceRequest $request, $id)
    {
        $req = $request->validated();
        DB::beginTransaction();
        try {
            $this->PriceRepository->update($id,[
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

       $resp = $this->PriceRepository->delete($id);

        if($resp) {
            return response()->json(['status' => true], 200);    
        }else {
            return response()->json(['status' => false], 422);
        }
    
    }
}
