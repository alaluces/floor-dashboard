<?php
# Limit access only to the following ip's below
 
$allowed_client_ip = array(                         
"127.0.0.1",
"192.168.5.12",
"192.168.5.13",
"192.168.5.14",
"192.168.5.16",
"192.168.5.17",
"192.168.5.18",
"192.168.5.43",
"192.168.5.44",
"192.168.5.129",
"192.168.5.130",
"192.168.5.137",
"192.168.5.149",
"192.168.5.150",
"192.168.5.151",
"192.168.5.152",
"192.168.5.153",
"192.168.5.163",
"192.168.5.164",
"192.168.5.180",
"192.168.5.194",
"192.168.5.208",
"192.168.5.213",
"192.168.5.216", 
"192.168.5.175",
"201.166.25.139",
"200.79.231.94"
);

$client_ip     = $_SERVER['REMOTE_ADDR'] ;  
$redirect_path = "http://192.168.5.30:9000";

if (!in_array($client_ip,$allowed_client_ip)){
    die("<script language='javascript'> self.location='$redirect_path'; </script>");   
}  

?>
