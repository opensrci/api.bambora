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

define("MY_TIMEZONE",'America/Toronto',TRUE); 

// Batch API Customized Params
// *****need change to your own credentials*****
define("MID","300206397",TRUE);                                 //need change
define("APIKEY","13E07AeeBF32411DBEB15E413eCDbAbA",TRUE);       //need change to your **Batch File Upload API Key *** 


// Debug control
define("MY_DEBUG",TRUE,TRUE); 

// Batch Request Base URL & Version 
define("REQ_URL_BASE","https://api.na.bambora.com/",TRUE); 
define("REQ_VER","v1/",TRUE);

// Batch payments
define("EFT_REQ_FUN","batchpayments/",TRUE);
define("EFT_REQ_URL", REQ_URL_BASE.REQ_VER.EFT_REQ_FUN, TRUE);

// Batch reports
define("EFT_RPT_FUN","scripts/reporting/report.aspx/",TRUE); 
define("EFT_RPT_URL", REQ_URL_BASE.EFT_RPT_FUN, TRUE);

define("RPT_VER","2.0",TRUE);                   // Report version

// Batch reports options
// Report Service Name:
//      *BatchPaymentsEFT(EFT only)
//      BatchPaymentsACH(ACH only)
//      BatchSettlement(ACH or EFT)
define("RPT_SVC",BATCH_RPT_EFT,TRUE);           // Report Service Name
                                                
define("RPT_SS","external",TRUE);               // Report Session Source

// Report filters(total 4):
//      batch_id - Batch identifier. This is a unique identifier per merchant account.
//      transaction_id -  This is a unique identifier per transaction uploaded to a merchant account across all batch files. The unique transaction reference to a batch transaction is a combination of 'merchant_id', 'batch_id', and 'trans_id'.
//      state_id - The progress of valid transactions through the settlement process.
//      status_id - Our validation of the format of the request
//      returned_date - Date the bank has applied a return or reject against the transaction. YYYY-MM-DD
//      noc_date - ACH only
define("RPT_FILTER_BATCH","batch_id",TRUE);          // Report by batch id, other options

// Batch Request Auth
define ("AUTH",'Passcode '. base64_encode (MID.':'.APIKEY));

// Default batch EFT Action
define("BATCH_TYPE",BATCH_PAYMENT_EFT,TRUE); 

?>