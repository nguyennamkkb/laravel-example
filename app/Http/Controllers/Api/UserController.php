<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
// use App\Models\User;
// use App\Http\Requests\RegisterAuthRequest;
// use JWTAuth;
// use Tymon\JWTAuth\Exceptions\JWTException;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Code\CodeRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class UserController extends Controller
{
    protected $userRepository, $codeRepository;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(UserRepositoryInterface $userRepository, CodeRepositoryInterface  $codeRepository )
    {
        $this->userRepository = $userRepository;
        $this->codeRepository = $codeRepository;
    }
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $limit = $request->limit;

        $list = $this->userRepository->findBy($keyword)->paginate($limit);
        return UserResource::collection($list);

    }

    public function store(UserRequest $requets)
    {
        $req = $requets->validated();
        $userInfo = $this->userRepository->where('email', $req['email'])->first();
        $code = $this->codeRepository->where('code', $req['code'])->first();

        if ($userInfo != NULL) {
            return response()->json(['status' => false,'message' => 'Tài khoản đã tồn tại'], 200);
        }
        if (($code != NULL && $code->isUsed == true) ||($code == NULL)) {
            return response()->json(['status' => false,'message' => 'Mã đăng ký không thể sử dụng'], 200);
        }

        // Transaction DB
        DB::beginTransaction();
        try {

            $userStote = $this->userRepository->insertGetId([

                'name' => $req['name'],
                'email' => $req['email'],
                'password' => Hash::make($req['password']),
                'code' => $req['code'],
            ]);
            $this->codeRepository->update( $code->id, [
                'isUsed' => true,
                'user_id' => $userStote,
                'startTime' => Carbon::now()->toDateTimeString(),
                'endtime' => Carbon::now()->addYears(5)->toDateTimeString(),
            ]);
            DB::commit();
            return response()->json(['status' => true], 200);    
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => false], 200);
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

        $resp = $this->userRepository->delete($id);

        if($resp) {
            return response()->json(['status' => true], 200);    
        }else {
            return response()->json(['status' => false], 422);
        }
    
    }
    public function update(Request $request,$id)
    {
        // Transaction DB

        DB::beginTransaction();
        try {
            $this->userRepository->update( $id, [
                'name' => $request['name'],
                'email' => $request['email'],
            ]);
            
            DB::commit();
            return response()->json(['status' => true], 200);    
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => false], 200);
        }
    
    
    }
}
