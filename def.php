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

//eft record class
class EFT_Class
{
        private
                $type= 'E',                     //Transaction type - The type of transaction.E - EFT
                $creditdebit='D'                //Transaction type ,C – Credit recipient bank accounts,D – Debit an outside bank account and depositing funds into your own
                ;
        public
                $bank='',                       //Financial institution number - The 3 digit financial institution number
                $transit='',                    //Bank transit number - The 5 digit bank transit number
                $acc='',                        //Account number - The 5-12 digit account number
                $amt='',                        //Amount - Transaction amount in pennies
                $ref='',                        //Reference number - An optional reference number of up to 19 digits. If you don't want a reference number, enter "0" (zero).
                $name='',                       //Recipient name - Full name of the bank account holder
                $code='',                       //Customer code - The 32-character customer code located in the Payment Profile. Do not populate bank account fields in the file when processing against a Payment Profile.
                $desc=''                        //By default the Bambora merchant company name will show on your customer's bank statement. You can override this default by populating the Dynamic Descriptor field.
                ;

        function debit(){
            $creditdebit = 'D';
        }
        
        function credit(){
            $creditdebit = 'C';
        }


};


//eft_params in array 
$my_eft_records_array = [
        [
                'type'=> 'E',               //Transaction type - The type of transaction.E - EFT
                'credit-debit'=>'D',        //Transaction type ,C – Credit recipient bank accounts,D – Debit an outside bank account and depositing funds into your own
                'bank'=>'',                 //Financial institution number - The 3 digit financial institution number
                'transit'=>'',              //Bank transit number - The 5 digit bank transit number
                'acc'=>'',                  //Account number - The 5-12 digit account number
                'amt'=>'',                  //Amount - Transaction amount in pennies
                'ref'=>'',                  //Reference number - An optional reference number of up to 19 digits. If you don't want a reference number, enter "0" (zero).
                'name'=>'',                 //Recipient name - Full name of the bank account holder
                'code'=>'',                 //Customer code - The 32-character customer code located in the Payment Profile. Do not populate bank account fields in the file when processing against a Payment Profile.
                'desc'=>'',                 //By default the Bambora merchant company name will show on your customer's bank statement. You can override this default by populating the Dynamic Descriptor field.     
           ],                
        ];


//eft_params in string 
//Note: in the following sequence
//type,credit-debit,bank,transit,acc,amt,ref,name,code,desc,
//example ( no title line):
//
//E,C,001,99001,09400313371,10000,1000070001,ACME Corp,123,desc1
//E,C,002,99002,09400313372,20000,1000070002,John Doe,234,desc2
//E,C,003,99003,09400313373,30000,1000070003,Jane Doe,345,desc3
$my_eft_records_str = '';


//eft process control !!CREDITCARD only!!

//initialization
$process_now =1;		 //**Credit card transactions** only, process now (1) or other date(0), overrides process_date parameter and processes transactions on receipt. .
$process_date = '';      //when process_now == 0,The date the transactions starts processing. Format YYYYMMDD.
$sub_merchant_id = '';   //the merchant account on which to process the transactions. Required only if request is authorized by a partner account.
$addendum = '';          //note associated with the batch file. Max length: 80 characters.

?>