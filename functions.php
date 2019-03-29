<?php
/*MIT License
Copyright (c) 2019 leontang8911
Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:
The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.
THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
*/
require 'vendor/autoload.php';
require 'def.php';
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Stream\Stream;

//*Basci Functions */
/**
 * @param array $array the array to be converted
 * @param string? $rootElement if specified will be taken as root element, otherwise defaults to 
 *                <root>
 * @param SimpleXMLElement? if specified content will be appended, used for recursion
 * @return string XML version of $array
 */
function arrayToXml($array, $rootElement = null, $xml = null) {
  $_xml = $xml;
 
  if ($_xml === null) {
    $_xml = new SimpleXMLElement($rootElement !== null ? $rootElement : '<root/>');
  }
 
  foreach ($array as $k => $v) {
    if (is_array($v)) { //nested array
      arrayToXml($v, $k, $_xml->addChild($k));
    } else {
      $_xml->addChild($k, $v);
    }
  }
 
  return $_xml->asXML();
}

/*
function: eft_submit( )
input: string or array or class EFT_Class object
output: json
    {
        'StatusCode':xxx,
        'Message':xxxx
    }

*/
function __clientSubmit( $eft_request, $resp_fmt = 'JSON' ){
    
    try {
        
       $response = $eft_request->request('POST');
        if ( 200 == $response->getStatusCode() and
            "OK"== $response->getReasonPhrase() ) {
                $r_code = $response->getStatusCode();
                $r_body = $response->getBody();
        }

    } catch (RequestException $e) {
        if ($e->hasResponse()) {
                $r_code = $e->getResponse()->getStatusCode();
                $r_body = (string) $e->getResponse()->getBody();
        }
        
    }   
    
    $r =  json_encode( [   'StatusCode' => $r_code,
                            'Body' => json_decode( $r_body )
                        ] );
}


function  eft_submit( $req ){
global $process_now;             
global $process_date;            
global $sub_merchant_id;         
global $addendum;                
    
    //setup eft request body
    $eft_body = '';
    
    if ( is_array($req) ){
        foreach( $req as $r ){
            $eft_body .= implode(",",$r).PHP_EOL;
        }
    }else if ( is_a($req,'EFT_Req_Class') ){
        //to_do: to be completed
    }
    
    //format control set
    $control = '{ "process_now" :'. $process_now;
    
    if ( 1 != $process_now ){
        if (  !empty($process_date) ) {
            $control .= ', "process_date": "'. $process_date.'"';
        }
    };
    
    if ( !empty($sub_merchant_id)){
            $control .= ', "sub_merchant_id": "'. $sub_merchant_id.'"';
    }       

    if ( !empty($addendum)){
            $control .= ', "addendum": "'. $addendum.'"';
    }       
    
    $control .= '}';
    
    //send batch payment request
    //filename = timestamp
    date_default_timezone_set(MY_TIMEZONE);
    $fn = 'ref'.date("Y-m-d-His").'.txt';

    $eft_request = new Client([
        'base_uri' =>EFT_REQ_URL,
        'headers' => [
            'Authorization' => AUTH,
            'filetype'=> 'STD'
            ],
        'debug' => MY_DEBUG,
        'multipart' => [
                [
                    'name'     => 'criteria',
                    'contents' => $control,
                    'headers'  => ['Content-Type'=>'application/json']
                ],
                [
                    'name'     => 'data',
                    'contents' => $eft_body,
                    'filename' => $fn
                ]
        ]
    
    ]);
    
    return( __clientSubmit($eft_request) );
    
}

/*
function: eft_reports( )
input: string or array or class EFT_Rpt_Class object
output: json
    {
        'StatusCode':xxx,
        'Message':xxxx
    }

*/
function  eft_reports( $req, $resp_fmt = 'JSON'){

    //setup batch report body
    $eft_body = '';

    if ( is_array($req) ){
        $eft_body = arrayToXml($req,'<?xml version="1.0" encoding="UTF-8"?><request></request>');
    }else if ( is_a($req,'Batch_Rpt_Class') ){
        //to_do: to be completed
    }
    
    //send report request
    $eft_request = new Client([
        'base_uri' =>EFT_RPT_URL,
        'headers' => [
                        'Content-Type'=>'application/xml'
                    ],
        'body' => $eft_body,
        'debug' => MY_DEBUG,
    ]);
    
    try {
        
       $response = $eft_request->request('POST');
        if ( 200 == $response->getStatusCode() and
            "OK"== $response->getReasonPhrase() ) {
                $r_code = $response->getStatusCode();
                $r_body = (string) $response->getBody();
                $r_body_xml = simplexml_load_string($r_body);
                
                if ($r_body_xml){
                    //return XML
                    $r_body_xml->addChild('StatusCode',$r_code);
                    $r = json_encode($r_body_xml);
                }else{
                    //return JSON
                    
                    $r = json_encode([  'StatusCode' => $r_code,
                                        'Body' => json_decode( $r_body )
                                    ]);
                }
                
            }

    } catch (RequestException $e) {
        if ($e->hasResponse()) {
                $r_code = $e->getResponse()->getStatusCode();
                $r_body = (string) $e->getResponse()->getBody();
                $r = json_encode($r_code.$r_body);
        }
    }

    return $r;

}


?>