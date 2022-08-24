<?php

namespace App\Http\Controllers\Api;
use App\Repositories\Export\ExportRepositoryInterface;
use App\Repositories\ExportDetail\ExportDetailRepositoryInterface;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Price\PriceRepositoryInterface;
use App\Repositories\Employee\EmployeeRepositoryInterface;
use App\Repositories\Customer\CustomerRepositoryInterface;
use App\Repositories\Unit\UnitRepositoryInterface;
use App\Repositories\Input\InputRepositoryInterface;
use App\Repositories\InputDetail\InputDetailRepositoryInterface;
use App\Http\Resources\ExportResource;
use App\Models\Code;
use App\Http\Requests\ExportRequest;
use App\Http\Resources\FreeResource;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\Api\CmdController;

class ExportController extends Controller
{
    protected $ExportRepository;
    protected $categoryRepository;
    protected $PriceRepository;
    protected $EmployeeRepository;
    protected $CustomerRepository;
    protected $UnitRepository;
    protected $ExportDetailRepository;
    protected $InputRepository;
    protected $InputDetailRepository;
    // protected $ExportRepository;
    // protected $ExportRepository;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(
        ExportRepositoryInterface $ExportRepository,
        PriceRepositoryInterface $PriceRepository,
        EmployeeRepositoryInterface $EmployeeRepository,
        CustomerRepositoryInterface $CustomerRepository,
        CategoryRepositoryInterface $categoryRepository,
        UnitRepositoryInterface $UnitRepository,
        ExportDetailRepositoryInterface $ExportDetailRepository,
        InputRepositoryInterface $InputRepository,
        InputDetailRepositoryInterface $InputDetailRepository
    ) {
        $this->ExportRepository = $ExportRepository;
        $this->ExportDetailRepository = $ExportDetailRepository;
        $this->PriceRepository = $PriceRepository;
        $this->EmployeeRepository = $EmployeeRepository;
        $this->CustomerRepository = $CustomerRepository;
        $this->categoryRepository = $categoryRepository;
        $this->UnitRepository = $UnitRepository;
        $this->InputRepository = $InputRepository;
        $this->InputDetailRepository = $InputDetailRepository;
    }
    public function index(Request $request)
    {
       
        $dateFrom = $request->from;
        $dateTo = $request->to;
        $category_id = $request->category_id;
        $status = $request->status;
        $limit = $request->limit;
        $list = $this->ExportRepository->findBy($dateFrom, $dateTo,$category_id, $status)->paginate($limit);
        return ExportResource::collection($list);
    }
    public function getlistValueExport()
    {
        // $input = FreeResource::collection($this->ExportRepository->all());
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
            $input = $this->ExportRepository->insertGetId([
                'date' => $request['date'],
                'customer_id' => $request['customer_id'],
                'importer_id' => $request['importer_id'],
                'carrier_id' => $request['carrier_id'],
                'category_id' => $request['category_id'],
                'note' => $request['note'],
                'prepay' => $request['prepay'],
                'totalmoney' => $request['totalmoney'],
                'freight' => $request['freight'],
            ]);
            if (!empty($request['item']) && $input != NULL) {
                foreach ($request['item'] as $value) {
                    $this->ExportDetailRepository->insertGetId([
                        'export_id' => $input,
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
            return response()->json(['status' => $e], 422);
        }
    }
    public function exportFromInput(Request $request)
    {
        $export = $this->InputRepository->find($request->id);
        $inputDetail = $this->InputDetailRepository->where('input_id','=',$request->id)->get();
        
        
        DB::beginTransaction();

        try {
             $inputupdate =  $this->InputRepository->update($request->id,[
                'status_export'=> '2'
             ]);
             if(!empty($inputupdate)){
                 
                    $input = $this->ExportRepository->insertGetId([
                    'date' => $export->date,
                    'customer_id' => $request->customer_id,
                    'importer_id' => $export->importer_id,
                    'carrier_id' => $export->carrier_id,
                    'category_id' =>$export->category_id,
                    'note' => $request->note,
                    'prepay' => 0,
                    'totalmoney' => CmdController::replaceNumberFormat( $request->totalmoney),
                    // 'freight' => $request['freight'],
                    
                ]);
                
                if (!empty($inputDetail) && $input != NULL) {
                    $index=0;
                    $data="";
                     
                    // dd($request->item[0]['categorychildren']);
                    foreach ($inputDetail as $value) {
                       
                         $this->ExportDetailRepository->insertGetId([
                            'export_id' => $input,
                            'customer_id' => $request->customer_id,
                            'categorychildren_id' =>$value['categorychildren_id'],
                            'weight' => $value['weight'],
                            'unit' => $value['unit'],
                            'price' => CmdController::replaceNumberFormat( $request->item[$index]['price']),
                            'total' => CmdController::replaceNumberFormat( $request->item[$index]['total']),
                        ]);
                        $index++;
                    }
                }
            }
            DB::commit();
            return response()->json(['status' => true], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => $e], 422);
        }
    }
    public function update(ExportRequest $request, $id)
    {
        $req = $request->validated();
        DB::beginTransaction();
        try {
            $this->ExportRepository->update($id, [
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

        $resp = $this->ExportRepository->delete($id);

        if ($resp) {
            return response()->json(['status' => true], 200);
        } else {
            return response()->json(['status' => false], 422);
        }
    }
}
