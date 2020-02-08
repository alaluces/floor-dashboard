<?php
include ("db.php");  
include ("model.php");

$Monitoring = new class_monitoring();

$sip_id    = $_GET['sip_id'] ;
$layout_id = ereg_replace("[^0-9]", "", $_GET['layout_id']);
if(strlen($layout_id)==0){$layout_id = "10001";}
$timestamp = date("Y-m-d H:i:s"); 

if ($_GET['colorize_stations']) { 
    echo $Monitoring->colorize_stations($timestamp);      
}   

if ($_GET['get_details']) { 
    echo $Monitoring->get_station_details($timestamp,$sip_id);     
} 
?>