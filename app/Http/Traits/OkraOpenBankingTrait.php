<?php
namespace App\Http\Traits;

trait OkraOpenBankingTrait{


    public function okraAuth(){

        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', 'https://api.okra.ng/v2/income/getByDate', [
            'form_params' => [
                'from' => '01-01-2020',
                'to' => '03-03-2020',
                'version' => '2'
            ],
            'headers' => [
                'accept' => 'application/json; charset=utf-8',
                'authorization' => 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJfaWQiOiI2NGVmMDE5NTYwMDljMDYyYmVjMWRlNGQiLCJpYXQiOjE2OTMzODUxMDl9.Ihs0Co31d8wuOrSahRL_iq00ragoDEMhRZcz-XwK-yo',
                'content-type' => 'application/x-www-form-urlencoded',
            ],
        ]);

        echo $response->getBody();
    }
}
