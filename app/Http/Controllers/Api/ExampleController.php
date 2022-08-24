<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Example\exampleRepositoryInterface;
use App\Http\Resources\ExampleResource;
use App\Http\Requests\ExampleRequest;
use Illuminate\Support\Facades\DB;


class ExampleController extends Controller
{
    protected $exampleRepository;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(exampleRepositoryInterface $exampleRepository)
    {
        $this->exampleRepository = $exampleRepository;
    }
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $limit = $request->limit;
        $list = $this->exampleRepository->findBy($keyword)->paginate($limit);
        return ExampleResource::collection($list);
    }

    public function store(ExampleRequest $request)
    {
        $req = $request->validated();

        DB::beginTransaction();
        try {

            $this->exampleRepository->insertGetId([
                'name' => $req['name'],
            ]);
            DB::commit();
            return response()->json(['status' => true], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => false], 422);
        }
    }
    public function update(ExampleRequest $request, $id)
    {

        $req = $request->validated();


        DB::beginTransaction();
        try {
            $this->exampleRepository->update($id, [
                'name' => $req['name'],
            ]);
            DB::commit();
            return response()->json(['status' => true], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => $e], 200);
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

        $resp = $this->exampleRepository->delete($id);

        if ($resp) {
            return response()->json(['status' => true], 200);
        } else {
            return response()->json(['status' => false], 422);
        }
    }
}
