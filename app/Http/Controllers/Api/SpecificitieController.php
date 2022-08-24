<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Specificities\SpecificitiesRepositoryInterface;
use App\Http\Resources\SpecificitieResource;
// use App\Models\Code;
use App\Http\Requests\SpecificitiesRequest;
use Illuminate\Support\Facades\DB;

class SpecificitieController extends Controller
{
    protected $SpecificitiesRepository;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(SpecificitiesRepositoryInterface $SpecificitiesRepository)
    {
        $this->SpecificitiesRepository = $SpecificitiesRepository;
    }
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $limit = $request->limit;
        $list = $this->SpecificitiesRepository->findBy($keyword)->paginate($limit);
        return SpecificitieResource::collection($list);
    }
    
    public function store(SpecificitiesRequest $request)
    {
        $req = $request->validated();
        DB::beginTransaction();
        try {
            $this->SpecificitiesRepository->insertGetId([
                'name' => $req['name'],
            ]);
            DB::commit();
            return response()->json(['status' => true], 200);  
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => false], 422);
        }
    }
    public function update(SpecificitiesRequest $request, $id)
    {
        $req = $request->validated();
        DB::beginTransaction();
        try {
            $this->SpecificitiesRepository->update($id,[
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

       $resp = $this->SpecificitiesRepository->delete($id);

        if($resp) {
            return response()->json(['stat
            us' => true], 200);    
        }else {
            return response()->json(['status' => false], 422);
        }
    
    }
}
