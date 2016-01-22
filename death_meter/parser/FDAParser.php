<?php
date_default_timezone_set('America/New_York');
require_once 'XmlStringStreamer.php';
require_once 'XmlStringStreamer/ParserInterface.php';
require_once 'XmlStringStreamer/StreamInterface.php';
require_once 'XmlStringStreamer/Stream/File.php';
require_once 'XmlStringStreamer/Parser/StringWalker.php';

function parseFAERSData($file, $source = '', $defaultDate = NULL, $category = 'drug'){
    if(!file_exists($file)){
        return [false, "The file does not exist"];
    }
    if(!isset($defaultDate)) $defaultDate = time();

    /**
     * Outcomes
     *  1 = death
     *  2 = life threatening
     *  4 = hospitalization
     *  8 = disabling
     *  16 = other
     */
    $outcomeTable = ['seriousnessdeath'=>1,'seriousnesslifethreatening'=>2,'seriousnesshospitalization'=>4,'seriousnessdisabling'=>8,'seriousnessother'=>16];

    $streamer = \Prewk\XmlStringStreamer::createStringWalkerParser($file);
    $data = [];
    global $wpdb;
    $pdo = new PDO('mysql:dbname=zsmith;host=webserver01.efsnetworks.com','zsmith','aPNnM7SubbFG2JPN');

    for($i=0; $node = $streamer->getNode(); $i++){
        $nodeObj = simplexml_load_string($node);
        if(!isset($nodeObj->safetyreportid)) continue;
        if(isset($nodeObj->receiptdate)){
            $date = substr($nodeObj->receiptdate,0,4) . '-' . substr($nodeObj->receiptdate,4,2) . '-' . substr($nodeObj->receiptdate,6,2);
        }else $date = date("Y-m-d", $defaultDate);



        $outcome = 0;
        foreach($outcomeTable as $o=>$v){
            if(isset($nodeObj->{$o}) && $nodeObj->{$o} == 1){
                $outcome |= $v;
                //echo $v;
            }
        }
        if($outcome > 0) $data[] = '("' . implode('","',[$nodeObj->safetyreportid,$date, $category, $source, $outcome]) . '")';

        echo $outcome;

        if($i >= 5000){
            $qry = "REPLACE INTO `death-meter-data` (`external-id`, `date`, `category`, `source`, `outcome`) VALUES ";
            $qry .= implode(',', $data);
            $pdo->exec($qry);
            //$wpdb->query($qry);
            $data = [];
            $i = 0;
        }
    }
    if(count($data) > 0){
        $qry = "REPLACE INTO `death-meter-data` (`date`, `category`, `source`, `outcome`) VALUES ";
        $qry .= implode(',', $data);
        $pdo->exec($qry);
        //$wpdb->query($qry);
    }

    return true;
}