<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CodeRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\CodeResource;
use App\Repositories\Code\CodeRepositoryInterface;
use App\Http\Controllers\Api\CmdController;
use Illuminate\Support\Facades\Auth;

class CodeController extends Controller
{
    protected $codeRepository;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(CodeRepositoryInterface $codeRepository)
    {
        $this->codeRepository = $codeRepository;
    }
    public function index(Request $request)
    {
        // dd( $request);
        // return $request;
        $keyword = $request->keyword;
        $status = $request->isUsed;
        $limit = $request->limit;
        
        $list = $this->codeRepository->findBy($status,$keyword)->paginate($limit);
        return CodeResource::collection($list);
    }
    
    public function store()
    {
        // Transaction DB
        
        DB::beginTransaction();
        try {
            $resp = $this->codeRepository->insertGetId([
                'name' => CmdController::getCode(),
                'isUsed'=> false
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

       $resp = $this->codeRepository->delete($id);

        if($resp) {
            return response()->json(['status' => true], 200);    
        }else {
            return response()->json(['status' => false], 422);
        }
    
    }
}
