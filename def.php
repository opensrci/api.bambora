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

//customer define parameters
require 'my_def.php';


// eft Request Base URL 
define("ReqURLBase","https://api.na.bambora.com/",TRUE); 
define("ReqVer","v1/",TRUE); 
define("eft_ReqFun","batchpayments/",TRUE); 
define("eft_ReqURL", ReqURLBase.ReqVer.eft_ReqFun, TRUE);


// Reqeust Auth
define ( 'AUTH','Passcode '. base64_encode (MID.':'.APIKEY));

//eft_params
define ( 'eft_EB_CRITERIA', BOUNDARY_STRING.'
                    Content-Disposition: form-data; name="criteria"
                    Content-Type: application/json' );
define ( 'eft_EB_DATA'  ,  BOUNDARY_STRING.'
                    Content-Disposition: form-data; name="data", filename="eft_transactions.csv"
                    Content-Type: text/plain' );



?>