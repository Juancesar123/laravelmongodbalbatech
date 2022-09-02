<?php

namespace App\Http\Controllers;
// use App\Models\Vehicle as Users;
use App\Models\Tag;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
/**
 * @OA\Info(title="Albatech Test", version="0.1")
 */
/**
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="apiKey",
 *     name="Authorization",
 *     in="header",
 * )
 */
/**
 * @OA\Get(
 *     path="/api/tag",
 *     tags={"Tag"},
 *     description="Get All Tag",
 *     @OA\Response(response="200", description="display all listing tag"),
 *      security={{ "bearerAuth": {} }}
 * )
 * * @OA\Post(
 *     path="/api/tag",
 *     tags={"Tag"},
 *     description="Create Data Tag",
 *   @OA\RequestBody(
 *    required=true,
 *    description="Create Data Tag",
 *    @OA\JsonContent(
 *       required={"name"},
 *       @OA\Property(property="name", type="string", format="text", example="hiburan")
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
 * * * @OA\Put(
 *     path="/api/tags/{id}",
 *     tags={"Tag"},
 *     description="Update Data Tag",
 *   @OA\RequestBody(
 *    required=true,
 *    description="Update Data tag",
 *    @OA\JsonContent(
 *       required={"name"},
 *       @OA\Property(property="name", type="string", format="text", example="hiburan")
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
 **
 * @OA\Delete(
 *     path="/api/tag/{id}",
 *     tags={"Tag"},
 *     description="Delete Tag by Id",
 *     @OA\Response(response="200", description="Delete Tag By Id"),
 *      security={{ "bearerAuth": {} }}
 * )
 */

class TagController extends Controller
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
        $data = Tag::paginate($limit);
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
        $tag = new Tag();
        $tag->name = $request->name;
        $tag->save();
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
        $tag = Tag::find($id);
        $tag->name = $request->name;
        $tag->save();
        $resp = [
            'response' => [
                'message' => 'Data sukses diubah',
                'code' => 200,
            ],
        ];
        return response()->json($resp);
    }
    public function destroy($id){
        Tag::find($id)->delete();
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
