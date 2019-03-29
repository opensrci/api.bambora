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

require_once 'functions.php';

//sample data
$eft_pay[]['bank'] = '003';
$eft_pay[]['transit'] = '00005';
$eft_pay[]['acc'] = '09400313371';
$eft_pay[]['amt'] = '100';    //1.00
$eft_pay[]['ref'] = '0001';
$eft_pay[]['name'] = 'Joe';
$eft_pay[]['code'] = '123';
$eft_pay[]['desc'] = 'test 1';

$eft_pay[]['bank'] = '005';
$eft_pay[]['transit'] = '00012';
$eft_pay[]['acc'] = '09400313372';
$eft_pay[]['amt'] = '200';    //1.00
$eft_pay[]['ref'] = '0002';
$eft_pay[]['name'] = 'Tom';
$eft_pay[]['code'] = '456';
$eft_pay[]['desc'] = 'test 2';


//$eft_pay is array of payment array records
$response = eft_submit($eft_pay);
print_r( $response );

//$eft_rpt is array of report requests
$eft_rpt['rptFilterValue1'] = '10000069'; //test batch number
$response = eft_reports($eft_rpt);
print_r( $response );
 
?>