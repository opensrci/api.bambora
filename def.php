<?php
/*MIT License

Copyright (c) 2019 OpenSRCi

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

require_once 'common.php';

// *** rely on def_eft.php, def_ach.php and/or def_cc.php 
//
require_once 'def_eft.php';

//eft record class (Currently N/A, it will be supported in the future )
class Batch_Req_Class
{
        private
                $type= BATCH_TYPE,              //Transaction type - The type of transaction.E - EFT
                $creditdebit=BATCH_ACT_DEBIT    //Transaction type , C – Credit recipient bank accounts,D – Debit an outside bank account and depositing funds into your own
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
            $creditdebit = BATCH_ACT_DEBIT;
        }
        
        function credit(){
            $creditdebit = BATCH_ACT_CREDIT;
        }


};


//eft request in array 
$my_eft_records_array = [
        [
                'type'=> BATCH_TYPE,              //Transaction type - The type of transaction:E - EFT,A - ACH (coming soon) ,C - Credit card (coming soon) 
                'credit-debit'=>BATCH_ACT_DEBIT,  //Transaction Action, C – Credit recipient bank accounts, D – *Debit an outside bank account and depositing funds into your own
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


//eft request in string 
//Note: in the following sequence
//type,credit-debit,bank,transit,acc,amt,ref,name,code,desc,
//example ( no title line):
//
//E,C,001,99001,09400313371,10000,1000070001,ACME Corp,123,desc1
//E,C,002,99002,09400313372,20000,1000070002,John Doe,234,desc2
//E,C,003,99003,09400313373,30000,1000070003,Jane Doe,345,desc3
$my_eft_records_str = '';



//eft request process control
$process_now =1;        //**Credit card transactions** only, process now (1) or other date(0), overrides process_date parameter and processes transactions on receipt. .
$process_date = '';     //when process_now == 0,The date the transactions starts processing. Format YYYYMMDD.
$sub_merchant_id = '';  //the merchant account on which to process the transactions. Required only if request is authorized by a partner account.
$addendum = '';         //note associated with the batch file. Max length: 80 characters.


//Batch reports request array
$my_batch_records_array = [
                // Predefined Params
                'rptVersion'=>RPT_VER,            //Report version number
                'merchantId'=>MID,                //merchant Id
                'passCode'=>APIKEY,               //api Key for REPORT API
                'sessionSource'=>RPT_SS,          //Session source
                
                //Service Name:
                //      BATCH_RPT_EFT ("BatchPaymentsEFT") - EFT only
                //      BATCH_RPT_ACH ("BatchPaymentsACH") - ACH only
                //      BATCH_RPT_ALL ("BatchSettlement")  - ACH or EFT
                'serviceName'=>'',                //Report service name
                
                //Report Response Format
                'rptFormat'=>'JSON',              //*JSON, XMl, TSV, CSV, or XLS formats
                
                'rptFromDateTime'=>'',            //report start date time yyyy-mm-dd 00:00:00
                'rptToDateTime'=>'',              //report end date time yyyy-mm-dd 23:59:59
                
                //Report Filters
                /*
                Filter/Search by("rptFilterBy1"):
                        batch_id - Batch identifier. This is a unique identifier per merchant account.
                        trans_id - Batch transaction id. This is a unique identifier per transaction uploaded to a merchant account across all batch files. The unique transaction reference to a batch transaction is a combination of 'merchant_id', 'batch_id', and 'trans_id'.
                        state_id - The progress of valid transactions through the settlement process.
                        status_id - Our validation of the format of the request
                        returned_date - Date the bank has applied a return or reject against the transaction. YYYY-MM-DD
                        noc_date - ACH only
                Operations("rptOperationType1"):
                        EQ - Equal to
                        LT - Less than
                        GT - Greater than
                        LE - Less than or equal to
                        GE - Greater than or equal to
                        NE - Not equal to
                Conditions:
                        AND
                        OR
                */
                'rptFilterBy1'=>RPT_FILTER_BATCH, //Filter/Search by 1
                'rptOperationType1'=>'EQ',        //Operations	1			
                'rptFilterValue1'=>'',            //Value 1
		'rptAddCondition1'=>'',		  //Condition 1
                
                'rptFilterBy2'=>'',               //Filter/Search by 2
                'rptOperationType2'=>'',          //Operations 2
                'rptFilterValue2'=>'',            //Value 2
		'rptAddCondition2'=>'',		  //Condition 2
                
                'rptFilterBy3'=>'',               //Filter/Search by 3
                'rptOperationType3'=>'',          //Operations 3
                'rptFilterValue3'=>'',            //Value 3
		'rptAddCondition3'=>'',		  //Condition 3
                
                'rptFilterBy4'=>'',               //Filter/Search by 4
                'rptOperationType4'=>'',          //Operations 4
                'rptFilterValue4'=>'',            //Value 4
		'rptAddCondition4'=>'',		  //Condition 4
		
                //Sort by: batch_id,trans_id,merchant_id,state_id,status_id,returned_date, noc_date
		'rptSortBy1'=>'',		  //Sort by 1
		'rptSortBy2'=>'',		  //Sort by 2
		
                //Start/End row 
		'rptStartRow'=>'',		  //starting row
		'rptEndRow'=>'',		  //ending row
		
		//(Reserved)Partners only. The sub-merchant ID to report against. Enum or number.
		//      "All", "AllLive" or merchant ID
	        //'rptMerchantId'=>'' 
		
 
           ];

//Batch reports class
class Batch_Rpt_Class
{
        private
                $merchantId=MID,                //merchant Id
                $passCode=APIKEY                //api Key for REPORT API
                ;
        public
                $sessionSource=RPT_SS,          //Session source
                $rptOperationType1=RPT_OPR,     //report operation type
                $rptVersion=RPT_VER,            //Report version number
                $serviceName=RPT_SVC,           //Report service name
                $rptFormat='',                  //JSON, XMl, TSV, CSV, or XLS formats
                $rptFromDateTime='',            //report start date time yyyy-mm-dd 00:00:00
                $rptToDateTime='',              //report end date time yyyy-mm-dd 23:59:59
                $rptFilterBy1='',               //report batch id for
                $rptFilterValue1=''             //Batch number/id
                ;
        function setEFT(){
                $serviceName = BATCH_RPT_EFT;
        }
        
        function setACH(){
                $serviceName = BATCH_RPT_ACH;
                
        }
        
        function setALL(){
                $serviceName = BATCH_RPT_ALL;
                
        }
        
        
};



?>