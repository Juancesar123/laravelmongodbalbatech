<?php

namespace App\Http\Controllers;
// use App\Models\Vehicle as Users;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /**
 * @OA\Get(
 *     path="/api/blog",
 *     tags={"Blog"},
 *     description="Get Blog Data",
 *     @OA\Response(response="200", description="display all Blog data"),
 *     security={{ "bearerAuth": {} }}
 * )
 * @OA\Post(
 *     path="/api/blog",
 *     tags={"Blog"},
 *     description="Create Data Blog",
 *   @OA\RequestBody(
 *    required=true,
 *    description="Create Data Blog",
 *    @OA\JsonContent(
 *       required={"title,description,category,tag"},
 *       @OA\Property(property="title", type="string", format="text", example="IT"),
 *       @OA\Property(property="description", type="string", format="text", example="Blog ini adalah ....."),
 *       @OA\Property(property="category", type="string", format="text", example="cat_id"),
 *       @OA\Property(property="tag", type="array", format="array",
 *                  @OA\Items(
 *                      @OA\Property(
 *                         property="name",
 *                         type="string",
 *                         example="hiburan"
 *                      ),
 *                ),
 *      )
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
 *     path="/api/blog/{id}",
 *     tags={"Blog"},
 *     description="Update Data Blog",
 *   @OA\RequestBody(
 *    required=true,
 *    description="Update Data Blog",
 *    @OA\JsonContent(
 *       required={"title, description, category, tag"},
 *       @OA\Property(property="title", type="string", format="text", example="IT"),
 *       @OA\Property(property="description", type="string", format="text", example="Blog ini adalah ....."),
 *       @OA\Property(property="category", type="string", format="text", example="cat_id"),
 *       @OA\Property(property="tag", type="array", format="array",
 *                  @OA\Items(
 *                      @OA\Property(
 *                         property="name",
 *                         type="string",
 *                         example="hiburan"
 *                      ),
 *                ),
 *      )
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
 *     path="/api/blog/{id}",
 *     tags={"Blog"},
 *     description="Delete Blog by Id",
 *     @OA\Response(response="200", description="Delete Blog By Id"),
 *      security={{ "bearerAuth": {} }}
 * )
 **/
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        $data = Post::with(['tag','category'])->paginate(5);
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
            'title' => 'required|min:4',
            'tag' => 'required|array',
            'category' => 'required|min:4'
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
        $blog = new Post();
        $blog->title = $request->title;
        $blog->description = $request->description;
        $blog->category_id = $request->category;
        $blog->save();
        foreach ($request->tag as $key => $value) {
            $data = Tag::Where('name','like','%' . $value['name'] . '%')->first();
            if($data){
                $blog->tag()->attach($data->id);
            }else{
                //dd($value);
                $tag = new Tag();
                $tag->name = $value['name'];
                $tag->save();
                $blog->tag()->attach($tag->id);
            }
        }
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
            'name' => 'required|min:4',
            'brand' => 'required|min:6',
            'cc' => 'required|numeric|min:6'
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
        $vehicle = Vehicle::find($id);
        $vehicle->name = $request->name;
        $vehicle->brand = $request->brand;
        $vehicle->cc = $request->cc;
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
        Vehicle::find($id)->delete();
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
