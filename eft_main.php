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

//setup eft request body
$eft_body = '--'.eft_EB_CRITERIA.PHP_EOL
            .'{'
            .' "process_now": '.$process_now
//            .',' 
//            .' "process_date":'.$process_date.','
//            .' "sub_merchant_id": "",'  // reserved
//            .' "addendum":  "",'        //reserved
            .'}'
            .PHP_EOL;
$eft_body .= '--'.eft_EB_DATA.PHP_EOL;

foreach ( $my_eft_records as $r ){
    foreach ( $r as $c ) {
    //$eft_body .= $c.',';
    }
    
    $eft_body .= PHP_EOL;
    $eft_body .= '--'.BOUNDARY_STRING.'--'.PHP_EOL;
}


$eft_request = new Client([
    'base_uri' =>eft_ReqURL,
    'headers' => [
        'Authorization' => AUTH,
        'filetype'=> 'STD',
        'content-type'=> 'multipart/form-data; boundary='.BOUNDARY_STRING,
        ],
    'timeout'  => 2.0,
    'debug' => MY_DEBUG,
    'body' => $eft_body,
]);


//debug
print_r($eft_body);
//exit("debug");


try {
    $eft_request->request('POST');
} catch (RequestException $e) {
    echo Psr7\str($e->getRequest());
    if ($e->hasResponse()) {
        echo Psr7\str($e->getResponse());
    }
}

?>