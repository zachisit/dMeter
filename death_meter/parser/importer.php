<?php
require_once 'FDAParser.php';

//parseFAERSData(dirname(__FILE__) . '/ADR07M04.SGM','FAERS',strtotime("2007-04-01"))

$files = scandir('data');
foreach($files as $file){
    $ext = strtolower(end(explode('.', $file)));
    if($ext == 'xml' || $ext == '.sgm'){
        parseFAERSData('data/' . $file, 'FAERS');
    }
}