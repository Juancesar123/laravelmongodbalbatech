<?php

namespace App\Http\Controllers;

class CurlApiController extends Controller
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
        $file_path = realpath(__DIR__ . '/../../../public/data.json');
      //  dd($file_path);
        $json = json_decode(file_get_contents($file_path,null), true);

       // dd($json['data']['response']['billdetails'] );
        $dataresult = array();
        foreach ($json['data']['response']['billdetails'] as $key => $value) {
            $array = explode(': ', $value['body'][0], 2);
            $string = end($array);
           // 
            if ((int)$string >= 100000 ) {
                $dataresult[] = (int)$string;
            }
        }
        var_dump($dataresult);
        // $endpoint = "https://gist.github.com/Loetfi/fe38a350deeebeb6a92526f6762bd719#file-filter-data-json";
        // $client = new \GuzzleHttp\Client();


        // $client->setDefaultOption('verify', false);
        // $response = $client->get($endpoint,[
        //     'auth' => ['user', 'pass']
        // ]);

        // // url will be: http://my.domain.com/test.php?key1=5&key2=ABC;

        // $statusCode = $response->getStatusCode();
        // $content = $response->getBody();
       // dd($content);
    }
    //
}
