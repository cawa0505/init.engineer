<?php

namespace App\Http\Composers\Frontend;

use Illuminate\View\View;
use GuzzleHttp\Client;

/**
 * Class UnusedPassword.
 */
class WxComposer
{

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function compose(View $view)
    {
        $token = env("CWB_TOKEN", null);

        try 
        {
            $res = $this->client->request('GET', 'https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-C0032-001', [
                'query' => [
                    'Authorization' => $token,
                    'locationName' => '宜蘭縣',
                    'elementName' => 'Wx'
                ]
            ]);

            $content = json_decode($res->getBody()->getContents());
            $weatherNow = $content->records->location[0]->weatherElement[0]->time[0]->parameter->parameterName;
        }
        catch (\Exception $e)
        {
            // TODO
        }

        $view->with('weather', $weatherNow ?? "");
    }
}