<?php
    #$cn = mysql_connect("localhost","aries","1234");  
    #$cn = mysql_connect("192.168.5.37","aries","1234");
    $cn = mysql_connect("localhost","agiweb","agiweb123");
    if (!$cn) {die('Could not connect: ' . mysql_error());}
    mysql_select_db("agiweb", $cn); 
    
    /*
    $cn_vici = mysql_connect("localhost","aries","1234");        
    #$cn_vici = mysql_connect("192.168.5.37","cron","1234");
    if (!$cn_vici) {die('Could not connect: ' . mysql_error());}
    mysql_select_db("asterisk", $cn_vici); 
    */
?>
