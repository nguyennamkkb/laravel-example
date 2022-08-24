<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CategoryChild\CategoryChildRepositoryInterface;
use App\Http\Resources\CategoryChildResource;
use App\Http\Requests\CategoryChildRequest;
use Illuminate\Support\Facades\DB;

class CategoryChildController extends Controller
{
    protected $categoryChildRepository;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(CategoryChildRepositoryInterface $categoryChildRepository)
    {
        $this->categoryChildRepository = $categoryChildRepository;
    }
    public function index(Request $request)
    {
        $keyword = $request->name;
        $catgoryId = $request->category_id;
        $limit = $request->limit;
        $list = $this->categoryChildRepository->findBy($catgoryId,$keyword)->paginate($limit);
        return CategoryChildResource::collection($list);
    }
    public function showbyCategoryId(Request $request)
    {
        $categoryId = $request->category_id;
        $list = $this->categoryChildRepository->findByCategoryid($categoryId)->get();
        return  CategoryChildResource::collection($list);
    }
    
    public function store(categoryChildRequest $request)
    {
        $req = $request->validated();
        DB::beginTransaction();
        try {
            
            $this->categoryChildRepository->insertGetId([
                'name' => $req['name'],
                'category_id' => $req['category_id'],
            ]);
            DB::commit();
            return response()->json(['status' => true], 200);  
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => $e], 200);
        }
    }
    public function update(categoryChildRequest $request, $id)
    {
        $req = $request->validated();
        DB::beginTransaction();
        try {
            $this->categoryChildRepository->update($id,[
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

       $resp = $this->categoryChildRepository->delete($id);

        if($resp) {
            return response()->json(['status' => true], 200);    
        }else {
            return response()->json(['status' => false], 422);
        }
    
    }
}
