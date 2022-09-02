<?php

namespace App\Http\Controllers;
// use App\Models\Vehicle as Users;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class VehicleController extends Controller
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
    public function index(){
        $data = Vehicle::all();
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
        $vehicle = new Vehicle();
        $vehicle->name = $request->name;
        $vehicle->brand = $request->brand;
        $vehicle->cc = $request->cc;
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
