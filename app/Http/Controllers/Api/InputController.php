<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Input\InputRepositoryInterface;
use App\Repositories\InputDetail\InputDetailRepositoryInterface;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Price\PriceRepositoryInterface;
use App\Repositories\Employee\EmployeeRepositoryInterface;
use App\Repositories\Customer\CustomerRepositoryInterface;
use App\Repositories\Unit\UnitRepositoryInterface;
use App\Http\Resources\InputResource;
use App\Models\Code;
use App\Http\Requests\InputRequest;
use App\Http\Resources\FreeResource;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Http\Parser\InputSource;

class InputController extends Controller
{
    protected $InputRepository;
    protected $categoryRepository;
    protected $PriceRepository;
    protected $EmployeeRepository;
    protected $CustomerRepository;
    protected $UnitRepository;
    protected $InputDetailRepository;
    // protected $InputRepository;
    // protected $InputRepository;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(
        InputRepositoryInterface $InputRepository,
        PriceRepositoryInterface $PriceRepository,
        EmployeeRepositoryInterface $EmployeeRepository,
        CustomerRepositoryInterface $CustomerRepository,
        CategoryRepositoryInterface $categoryRepository,
        UnitRepositoryInterface $UnitRepository,
        InputDetailRepositoryInterface $InputDetailRepository
    ) {
        $this->InputRepository = $InputRepository;
        $this->InputDetailRepository = $InputDetailRepository;
        $this->PriceRepository = $PriceRepository;
        $this->EmployeeRepository = $EmployeeRepository;
        $this->CustomerRepository = $CustomerRepository;
        $this->categoryRepository = $categoryRepository;
        $this->UnitRepository = $UnitRepository;
    }
    public function index(Request $request)
    {
        $limit = $request->limit;
        $list = $this->InputRepository->getinput()->paginate($limit);
        return InputResource::collection($list);
    }
    public function getlistValueInput()
    {
        // $input = FreeResource::collection($this->InputRepository->all());
        $price = FreeResource::collection($this->PriceRepository->all());
        $employee = FreeResource::collection($this->EmployeeRepository->all());
        $customer = FreeResource::collection($this->CustomerRepository->all());
        $category = FreeResource::collection($this->categoryRepository->all());
        $unit = FreeResource::collection($this->UnitRepository->all());

        return response()->json(
            [
                // 'input' => $input,
                'price' => $price,
                'employee' => $employee,
                'customer' => $customer,
                'category' => $category,
                'unit' => $unit,
            ],
            200
        );
    }


    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $input = $this->InputRepository->insertGetId([
                'date' => $request['date'],
                'customer_id' => $request['customer_id'],
                'importer_id' => $request['importer_id'],
                'carrier_id' => $request['carrier_id'],
                'category_id' => $request['category_id'],
                'note' => $request['note'],
                'prepay' => $request['prepay'],
                'totalmoney' => $request['totalmoney'],
            ]);
            if (!empty($request['item']) && $input != NULL) {
                foreach ($request['item'] as $value) {
                    $this->InputDetailRepository->insertGetId([
                        'input_id' => $input,
                        'customer_id' => $request['customer_id'],
                        'categorychildren_id' => $value['categorychildren_id'],
                        'weight' => $value['weight'],
                        'unit' => $value['unit'],
                        'price' => $value['price'],
                        'total' => $value['total'],
                    ]);
                }
            }
            DB::commit();
            return response()->json(['status' => true], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => $e], 200);
        }
    }
    public function update(InputRequest $request, $id)
    {
        $req = $request->validated();
        DB::beginTransaction();
        try {
            $this->InputRepository->update($id, [
                'date' => $req['date'],
                'supplier_id' => $req['supplier_id'],
                'totalweight_id' => $req['totalweight_id'],
                'importer_id' => $req['importer_id'],
                'carrier _id' => $req['carrier_id'],
                // 'carrier _id' => $req['carrier_id'],
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

        $resp = $this->InputRepository->delete($id);

        if ($resp) {
            return response()->json(['status' => true], 200);
        } else {
            return response()->json(['status' => false], 422);
        }
    }
}
