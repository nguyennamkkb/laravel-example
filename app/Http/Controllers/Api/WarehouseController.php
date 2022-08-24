<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FreeResource;
use App\Http\Resources\InputResource;
use Illuminate\Http\Request;
use App\Repositories\Input\InputRepositoryInterface;


class WarehouseController extends Controller
{
    protected $InputRepository;
    public function __construct(InputRepositoryInterface $InputRepository)
    {
        $this->InputRepository = $InputRepository;
    }
    public function index(Request $request)
    {
        // dd($request);

        $dateFrom = $request->from;
        $dateTo = $request->to;
        $category_id = $request->category_id;
        $status = $request->status;
        $status_export = $request->status_export;
        $limit = $request->limit;
        $list = $this->InputRepository->findBy($dateFrom, $dateTo,$category_id, $status,$status_export)->paginate($limit);
        return InputResource::collection($list);
    }
    
    // public function store()
    // {
    //     // Transaction DB
        
    //     DB::beginTransaction();
    //     try {
    //         $resp = $this->codeRepository->insertGetId([
    //             'name' => CmdController::getCode(),
    //             'isUsed'=> false
    //         ]);
    //         DB::commit();
    //         return response()->json(['status' => true], 200);  
    //     } catch (\Exception $e) {
    //         DB::rollback();
    //         return response()->json(['status' => false], 422);
    //     }
    // }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($id)
    // {

    //    $resp = $this->codeRepository->delete($id);

    //     if($resp) {
    //         return response()->json(['status' => true], 200);    
    //     }else {
    //         return response()->json(['status' => false], 422);
    //     }
    
    // }
    
}
