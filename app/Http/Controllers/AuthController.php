<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use App\Models\User as Users;
use Tymon\JWTAuth\JWTAuth;
use Hash;

class AuthController extends Controller
{
    protected $jwt;

    public function __construct(JWTAuth $jwt)
    {
        $this->jwt = $jwt;
    }

/**
 * @OA\Post(
 * path="/login",
 * summary="Sign in",
 * description="Login by email, password",
 * operationId="authLogin",
 * tags={"auth"},
 * @OA\RequestBody(
 *    required=true,
 *    description="Pass user credentials",
 *    @OA\JsonContent(
 *       required={"email","password"},
 *       @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
 *       @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
 *    ),
 * ),
 * @OA\Response(
 *    response=401,
 *    description="Wrong credentials response",
 *    @OA\JsonContent(
 *       @OA\Property(property="message", type="string", example="Username Atau Password Tidak Sesuai")
 *        )
 *     )
 * )
**
 * @OA\Post(
 * path="/register",
 * summary="Register",
 * description="Add user",
 * tags={"auth"},
 * @OA\RequestBody(
 *    required=true,
 *    description="Pass user credentials",
 *    @OA\JsonContent(
 *       required={"email","password"},
 *       @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
 *       @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
 *    ),
 * ),
 * @OA\Response(
 *    response=422,
 *    description="If Field is empty",
 *    @OA\JsonContent(
 *       @OA\Property(property="message", type="string", example="Attribute .... cannot empty")
 *        )
 *     )
 * )
 **
 * @OA\Get(
 *     path="/api/logout",
 *     tags={"auth"},
 *     description="Logout user",
 *     @OA\Response(response="200", description="user Logout"),
 *      security={{ "bearerAuth": {} }}
 * )
 */   
    public function login(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'email' => 'required|min:4',
            'password' => 'required|min:6'
        ],
        [
            'required'  => ':attribute harus diisi',
            'min'       => ':attribute minimal :min karakter',
        ]);

        if ($validator->fails()) {
            $resp = [
                'metadata' => [
                        'message' => $validator->errors()->first(),
                        'code'    => 422
                    ]
                ];
            return response()->json($resp, 422);
            die();
        }

        $user = Users::where('email', $request->email)->first();
        if($user)
        {
            if( Crypt::decrypt($user->password) == $request->password)
            {
                
                $token = \Auth::login($user);
                $resp = [
                    'response' => [
                        'token'=> $token  
                    ],
                    'metadata' => [
                        'message' => 'OK',
                        'code'    => 200
                    ]
                ];

                return response()->json($resp);
            }else{

                $resp = [
                    'metadata' => [
                        'message' => 'Username Atau Password Tidak Sesuai',
                        'code'    => 401
                    ]
                ];

                return response()->json($resp, 401);
            }
        }else{
            $resp = [
                'metadata' => [
                    'message' => 'Username Atau Password Tidak Sesuai',
                    'code'    => 401
                ]
            ];

            return response()->json($resp, 401);
        }

    }
    public function register (Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|min:4',
            'password' => 'required|min:6',
        ],
        [
            'required'  => ':attribute harus diisi',
            'numeric'  => ':attribute harus angka',
            'min'       => ':attribute minimal :min karakter',
        ]);
        if ($validator->fails()) {
            $resp = [
                'metadata' => [
                        'message' => $validator->errors()->first(),
                        'code'    => 422
                    ]
                ];
            return response()->json($resp, 422);
            die();
        }
        $user = Users::create([
            'name' => $request->name,
            'email' => $request->get('email'),
            'password'=> Crypt::encrypt($request->get('password'))
        ]);
        return response()->json(['status' => "success", "user_id" => $user->id], 201);
    }
    public function logout(){
        // Pass true as the first param to force the token to be blacklisted "forever".
        // The second parameter will reset the claims for the new token
        $token = $this->jwt->getToken();
        if($this->jwt->invalidate($token)){
                return response()->json([
                    'message' => 'User logged off successfully!'
                ], 200);
        } else {
                return response()->json([
                    'message' => 'Failed to logout user. Try again.'
                ], 500);
        }

    }

}