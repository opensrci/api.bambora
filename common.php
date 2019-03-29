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

// Request type
define("BATCH_PAYMENT_EFT",'E',TRUE); 
define("BATCH_PAYMENT_ACH",'A',TRUE); 
define("BATCH_PAYMENT_CC",'C',TRUE);

define("BATCH_RPT_EFT","BatchPaymentsEFT",TRUE);
define("BATCH_RPT_ACH","BatchPaymentsACH",TRUE);
define("BATCH_RPT_ALL","BatchSettlement",TRUE);

define("BATCH_ACT_CREDIT",'C',TRUE); 
define("BATCH_ACT_DEBIT",'D',TRUE); 


?>