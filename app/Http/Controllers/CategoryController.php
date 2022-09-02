<?php

namespace App\Http\Controllers;
// use App\Models\Vehicle as Users;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
    /**
 * @OA\Get(
 *     path="/api/category",
 *     tags={"Category"},
 *     description="Get Category Data",
 *     @OA\Response(response="200", description="display all category data")
 * )
 * @OA\Post(
 *     path="/api/category",
 *     tags={"Category"},
 *     description="Create Data Category",
 *   @OA\RequestBody(
 *    required=true,
 *    description="Create Data Category",
 *    @OA\JsonContent(
 *       required={"name"},
 *       @OA\Property(property="name", type="string", format="text", example="IT")
 *    ),
 * ),
 * @OA\Response(
 *    response=422,
 *    description="Field is null",
 *    @OA\JsonContent(
 *       @OA\Property(property="message", type="string", example="Attribute ... harus di isi")
 *        )
 *     ),
 *      security={{ "bearerAuth": {} }}
 * )
 * @OA\Put(
 *     path="/api/category/{id}",
 *     tags={"Category"},
 *     description="Update Data Category",
 *   @OA\RequestBody(
 *    required=true,
 *    description="Update Data Category",
 *    @OA\JsonContent(
 *       required={"name"},
 *       @OA\Property(property="name", type="string", format="text", example="IT")
 *    ),
 * ),
 * @OA\Response(
 *    response=422,
 *    description="Field is null",
 *    @OA\JsonContent(
 *       @OA\Property(property="message", type="string", example="Attribute ... harus di isi")
 *        )
 *     ),
 *      security={{ "bearerAuth": {} }}
 * )
 * @OA\Delete(
 *     path="/api/category/{id}",
 *     tags={"Category"},
 *     description="Delete Category by Id",
 *     @OA\Response(response="200", description="Delete Category By Id"),
 *      security={{ "bearerAuth": {} }}
 * )
 **/
class CategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request){
        $limit = 5;
        if($request->query('limit')){
            $limit = $request->query('limit');
        }
        $data = Category::paginate($limit);
        $resp = [
            'response' => [
                'message' => 'OK',
                'code' => 200,
                'data' => $data
            ],
        ];

        return response()->json($resp);
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:4'
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
        $vehicle = new Category();
        $vehicle->name = $request->name;
        $vehicle->save();
        $resp = [
            'response' => [
                'message' => 'Data sukses disimpan',
                'code' => 200,
            ],
        ];
        return response()->json($resp);
    }
    public function update($id, Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:4'
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
        $vehicle = Category::find($id);
        $vehicle->name = $request->name;
        $vehicle->save();
        $resp = [
            'response' => [
                'message' => 'Data sukses diubah',
                'code' => 200,
            ],
        ];
        return response()->json($resp);
    }
    public function destroy($id){
        Category::find($id)->delete();
        $resp = [
            'response' => [
                'message' => 'Data sukses dihapus',
                'code' => 200,
            ],
        ];
        return response()->json($resp);
    }
    //
}
