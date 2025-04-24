<?php

namespace App\Classes;

use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\MultipartStream;
use Illuminate\Support\Facades\Log;

class RestApi
{
    public static function getMethod($url,$body_arr=[])
    {
        $full_url=env('APP_API_URL').$url;

        
        $response = Http::withHeaders([
            'x-api-key' => 1234,
        ])->get($full_url,$body_arr);

        $response = $response->json();

        // dd($response);

        if(!is_array($response))
        {
            $response=[];
        }

        return $response;
    }

    public static function postMethod($url,$body_arr)
    {
        $full_url=env('APP_API_URL').$url;

        $response = Http::post($full_url, $body_arr);
        
        
        $response = $response->json();
        // dd($response);
        
        if(!is_array($response))
        {
            $response=[];
        }

        return $response;
    }

    public static function postMethodWithFiles($url, $body_arr,$files=[])
    {
        $full_url=env('APP_API_URL').$url;

        $full_body=[];

        foreach ($files as $index => $file) {
            if(is_iterable($file))  //for multiple file
            {
                foreach($file as $single_file)
                {
                    $data=[];
                    $data['name']=$index.'[]';
                    $data['contents'] = file_get_contents($single_file->getPathname());
                    $data['filename'] = $single_file->getClientOriginalName();
                    $full_body[]=$data;
                }
            }
            else
            {
                $data=[];
                $data['name']=$index;
                $data['contents']=file_get_contents($file->getPathname());
                $data['filename']=$file->getClientOriginalName();
                $full_body[]=$data;
            }
        }

        foreach ($body_arr as $index => $value) {
            $data=[];
            $data['name']=$index;
            $data['contents']=$value;
            $full_body[]=$data;
        }

        Log::channel('other')->info("post method full body ".json_encode($full_body));

        $client = new Client([
            'headers' => [
                'content-type' => 'multipart/form-data',
            ]
        ]);

        $api_response = $client->post($full_url, [
            'multipart' => $full_body,
        ]);

        $response = $api_response->getBody()->getContents();

        // dd($response);
            
        
        $response=(array)json_decode($response);

        if(!is_array($response))
        {
            $response=[];
        }

        return $response;
    }

    public static function putMethod($url,$body_arr,$files=[])
    {
        $full_url=env('APP_API_URL').$url;

        $response = Http::put($full_url, $body_arr);

        $response = $response->json();

        // dd($response);

        if(!is_array($response))
        {
            $response=[];
        }

        return $response;
    }



    public static function deleteMethod($url)
    {
        $full_url=env('APP_API_URL').$url;
        
        $response = Http::delete($full_url);

        $response = $response->json();

        if(!is_array($response))
        {
            $response=[];
        }

        return $response;
    }




}