<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class VehicleTest extends TestCase
{
    
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAllVehicle()
    {
        $header = [ 'HTTP_Authorization' => 'bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODAwMFwvbG9naW4iLCJpYXQiOjE2NjE0MDQwODksImV4cCI6MTY2MTQwNzY4OSwibmJmIjoxNjYxNDA0MDg5LCJqdGkiOiI1dVVhOE1qRHdibUZuclJsIiwic3ViIjoiNjMwNmYyNTYwYTY4MjZiZjY3MDFjNmQyIiwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.ex0c5B5yVraVHH5ygTSBzbgwsZygexXqAwivZPa1HSc'];
        $this->get("api/vehicle", $header);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'response' => 
            ['data' => [ "*" =>
                [
                    'name',
                    'brand',
                    'created_at',
                    'updated_at',
                    'cc'
                ]
                ],
            ]
        ]);
    }
    public function testCreateVehicle(){
        $header = [ 'HTTP_Authorization' => 'bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODAwMFwvbG9naW4iLCJpYXQiOjE2NjE0MDQwODksImV4cCI6MTY2MTQwNzY4OSwibmJmIjoxNjYxNDA0MDg5LCJqdGkiOiI1dVVhOE1qRHdibUZuclJsIiwic3ViIjoiNjMwNmYyNTYwYTY4MjZiZjY3MDFjNmQyIiwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.ex0c5B5yVraVHH5ygTSBzbgwsZygexXqAwivZPa1HSc'];
        $parameters = [
            "name" => "akabe",
            "brand" => "toyota",
            "cc" => 2500
        ];
        $this->post("api/vehicle", $parameters, $header);
        $this->seeStatusCode(200);
    }
    public function testUpdateVehicle(){
        $header = [ 'HTTP_Authorization' => 'bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODAwMFwvbG9naW4iLCJpYXQiOjE2NjE0MDQwODksImV4cCI6MTY2MTQwNzY4OSwibmJmIjoxNjYxNDA0MDg5LCJqdGkiOiI1dVVhOE1qRHdibUZuclJsIiwic3ViIjoiNjMwNmYyNTYwYTY4MjZiZjY3MDFjNmQyIiwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.ex0c5B5yVraVHH5ygTSBzbgwsZygexXqAwivZPa1HSc'];
        $parameters = [
            "name" => "akabe",
            "brand" => "toyota",
            "cc" => 2500
        ];
        $this->put("api/vehicle/63070191e44deaaa2d0c7be3", $parameters, $header);
        $this->seeStatusCode(200);
    }
}
