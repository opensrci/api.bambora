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

// API Customized Params
// need change to your own credentials
define("MID","300206397",TRUE);                                 //need change

define("APIKEY","13E07AeeBF32411DBEB15E413eCDbAbA",TRUE);       //need change to your **Batch File Upload API Key *** 


//Debug control
define("MY_DEBUG",TRUE,TRUE); 

//eft boundary string
define ("BOUNDARY_STRING", "WebKitFormBoundaryeeBF32411");


//eft_params in array 
global $my_eft_records;
$my_eft_records = array (
        array(
                'type'=> 'E',       //Transaction type - The type of transaction.E - EFT
                'credit-debit'=>'D',//Transaction type ,C – Credit recipient bank accounts,D – Debit an outside bank account and depositing funds into your own
                'bank'=>'000',         //Financial institution number - The 3 digit financial institution number
                'transit'=>'00000',      //Bank transit number - The 5 digit bank transit number
                'acc'=>'0000000000',          //Account number - The 5-12 digit account number
                'amt'=>'0',          //Amount - Transaction amount in pennies
                'ref'=>'',          //Reference number - An optional reference number of up to 19 digits. If you don't want a reference number, enter "0" (zero).
                'name'=>'',         //Recipient name - Full name of the bank account holder
                'code'=>'',          //Customer code - The 32-character customer code located in the Payment Profile. Do not populate bank account fields in the file when processing against a Payment Profile.
                'desc'=>'',     
            ),                
        );

//eft processing,1- now, otherwise $process_date is the date to process, Format YYYYMMDD,    
$process_now = 1;
$process_date = '';

?>