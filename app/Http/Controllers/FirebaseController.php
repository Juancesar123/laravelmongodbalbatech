<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
class FirebaseController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function index(){
        
        // $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/FirebaseKey.json');
        // $firebase = (new Factory)
        //     ->withServiceAccount($serviceAccount)
        //     ->create();
        // $database = $firebase->getDatabase();
        // $ref = $database->getReference('Subjects');
        // $key = $ref->push()->getKey();
        // $ref->getChild($key)->set([
        //     'SubjectName' => 'Laravel'
        // ]);
        // return $key;
    }
    //
}
