<title>Workstation Monitoring</title>
                              
<style  type='text/css'>@import url(layout.css);</style>
<script type='text/javascript' src='refresh.js'></script> 

<?php

/*
Live Call Monitoring (Vicidial & Manual Dial)
Author: Aries Laluces
100723 - initial CODE
       - javascript auto refresh
       - css tooltip 
       - can monitor manual dial for now
100724 - monitor vicidial
       - color legend and total calls
100725 - ping checker (crontab)
100730 - toggle auto screen update
       - 5522
100918 - v0.0.2
       - edit mode
       - multi layout

TO-DO




*/ 
          
function timeDiff($t1, $t2) {
   if($t1 > $t2)
   {
      $time1 = $t2;
      $time2 = $t1;
   }
   else
   {
      $time1 = $t1;
      $time2 = $t2;
   }
   $diff = array(   
      'hours' => 0,
      'minutes' => 0,
      'seconds' =>0
   );
   
   foreach(array('hours','minutes','seconds')
         as $unit)
   {
      while(TRUE)
      {
         $next = strtotime("+1 $unit", $time1);
         if($next < $time2)
         {
            $time1 = $next;
            $diff[$unit]++;
         }
         else
         {
            break;
         }
      }
   }
   return($diff);
}

if (!$_GET['edit']) {
    echo"<span style='position:absolute;top:9px;left:10px;color:white;'>Workstation Monitoring 0.0.2 - EDIT MODE</span>";
}

$timestamp = date("Y-m-d H:i:s"); 
$total_calls_manual          = 0;
$total_calls_vicidial_paused = 0;
$total_calls_vicidial_live   = 0;  

$cn = mysql_connect("localhost", "agiweb","agiweb123");
if (!$cn) {die('Could not connect: ' . mysql_error());}
mysql_select_db("agiweb", $cn);   

if (isset($_POST['btnSave'])){
    #note: cleanup array vars after you assign them, not before
    $layout_id       = $_POST['layout_id'];
    $arr_values      = $_POST['values'];    
    $arr_coordinates = $_POST['coordinates'];
     
     #clear table first
     mysql_query("DELETE FROM layout_grid where layout_id = '$layout_id'",$cn);    
    for ($i=0;$i<count($arr_coordinates);$i++){
        $arr_coordinates2 = explode(":",$arr_coordinates[$i]);
        #populate values again
        mysql_query("INSERT INTO layout_grid VALUES ('$layout_id','$arr_values[$i]','$arr_coordinates2[0]','$arr_coordinates2[1]')",$cn);
        #echo "c=$arr_coordinates[$i]<br />v=$arr_values[$i]<br />";     
    }
    
    die("<script> self.location='index.php?layout_id=$layout_id&pause=true&edit=99999999';</script>");  
}   

if ($_GET['layout_id']){
    $layout_id = $_GET['layout_id'];
} else {    
    die("<script> self.location='index.php?layout_id=10001';</script>"); 
    #default
} 

if (!$_GET['edit']) {
    die("<script> self.location='index.php?layout_id=$layout_id&pause=true&edit=99999999';</script>");
}

$result = mysql_query("SELECT layout_name,num_rows,num_cols 
                       FROM layout_info
                       WHERE layout_id = '$layout_id' AND active = '1';",$cn);
if (mysql_num_rows($result) <=0 ){
    die();
} else {
    $row = mysql_fetch_row($result);
    $layout_name = $row[0];
    $nrows       = $row[1];
    $ncols       = $row[2];
}

echo"<form action='index.php' method='POST'>
    <input type='hidden' value='$layout_id' name='layout_id'>
";
   
# toggle auto update
echo"<div class='header'>";
    if ($_GET['edit']) {
        echo"<span style='position:absolute;top:9px;left:10px;color:white;'>Workstation Monitoring 0.0.2 - EDIT MODE</span>";  
    } else {
        echo"<span style='position:absolute;top:9px;left:10px;color:white;'>Workstation Monitoring 0.0.2 <!-- [Maintenance in progress... Sorry for the inconvenience] --> </span>";  
    }
          

    if (!isset($_GET['pause'])){
        echo"<script type='text/javascript'> window.onload=beginrefresh  </script>";
        echo"<a class='nodeco' href='index.php?layout_id=$layout_id&pause=true'><span>[Disable auto refresh]</span></a>";  
    } else {
        echo"<a class='nodeco' href='index.php?layout_id=$layout_id'><span>[Enable auto refresh]</span></a>";  
    }
echo"</div>"; 

echo"<br /><table align='center'>"; 

for ($r=1;$r<=$nrows;$r++){
    echo"<tr>";
    for ($c=1;$c<=$ncols;$c++){
        
        # set default values        
        $bgcolor = "white";
        $fcolor  = "white";                  
        unset($info);
        unset($phone_id);
        
        if ($_GET['edit']){ $border  = "solid thin black";  } else { $border  = "none"; }                   
        
        # lets just get the phone_ids first
        $result_sip = mysql_query("
            SELECT item_id,ip_address,online FROM layout_grid AS a
            INNER JOIN phones AS b
            ON a.item_id = b.phone_id 
            WHERE layout_id = '$layout_id' 
            AND ROW='$r' AND col='$c'",$cn);  
        if (mysql_num_rows($result_sip) > 0){
            $row_sip = mysql_fetch_row($result_sip);
            
            if(strlen($row_sip[0])>0){ 
                              
                $phone_id     = $row_sip[0]; 
                $station_ip = $row_sip[1];
                $online     = $row_sip[2];   
                
                if ($_GET['edit']){
                    $border  = "solid thin black";                    
                    $bgcolor = "gray";
                } else {
                    $border  = "solid thin black";                                      
                    if (!$online){
                        $bgcolor = "black"; 
                        $fcolor  = "lime";
                    } else {
                        $bgcolor = "gray";
                        $fcolor  = "black"; 
                    } 
                }                                                       
                
                $border  = "solid thin black";
                
                $info = "
                <a  class='info' href='#'>
                    $phone_id 
                    <span>
                        ID:$phone_id                           
                        <br />
                        IP:$station_ip
                    </span>
                </a>           
                ";                            
 
                # Check if SIP_ID has live call (VICIDIAL)  
                               
                # Connect to VICIDIAL DATABASE
                $cn_vici = mysql_connect("localhost","cron","1234");
                if (!$cn_vici) {die('Could not connect: ' . mysql_error());}
                mysql_select_db("asterisk", $cn_vici); 
 
                $result_vici = mysql_query("
                        SELECT
                        USER,STATUS,last_call_time,calls_today,campaign_id
                        FROM vicidial_live_agents
                        WHERE RIGHT(extension,3) = '$phone_id'",$cn_vici);                

                if (mysql_num_rows($result_vici) > 0){
                    $row_vici = mysql_fetch_row($result_vici);
                    $username    = $row_vici[0];
                    $call_status = $row_vici[1];  
                    $call_start  = $row_vici[2];  
                    $total_calls = $row_vici[3];
                    $campaign_id = $row_vici[4];
                    
                    # Set color code
                    $diff = timeDiff(strtotime("$call_start"), strtotime("$timestamp"));

                    if ($call_status == 'PAUSED'){
                        $total_calls_vicidial_paused++;                                                              
                        if ($diff[minutes] == 0){$bgcolor = "#FAF8CC";}
                        if ($diff[minutes] >= 1 && $diff[minutes] <= 5){$bgcolor = "#EDDA74";} 
                        if ($diff[minutes] >= 6 && $diff[minutes] <= 60){$bgcolor = "#FDD017";}
                        if ($diff[hours] > 0){$bgcolor = "#AF7817";}                    
                    }

                    if ($call_status == 'DISPO'){ 
                        $total_calls_vicidial_paused++;                                                               
                        if ($diff[minutes] == 0){$bgcolor = "#FAF8CC";}
                        if ($diff[minutes] >= 1 && $diff[minutes] <= 5){$bgcolor = "#EDDA74";} 
                        if ($diff[minutes] >= 6 && $diff[minutes] <= 60){$bgcolor = "#FDD017";}
                        if ($diff[hours] > 0){$bgcolor = "#AF7817";}                    
                    }
                    
                    if ($call_status == 'INCALL'){ 
                        $total_calls_vicidial_live++;                                                               
                        if ($diff[minutes] == 0){$bgcolor = "#FDEEF4";}
                        if ($diff[minutes] >= 1 && $diff[minutes] <= 5){$bgcolor = "#C38EC7";} 
                        if ($diff[minutes] >= 6 && $diff[minutes] <= 60){$bgcolor = "#B93B8F";}
                        if ($diff[hours] > 0){$bgcolor = "#7E587E";}                    
                    }                                 
                    
                    $info = "
                    <a style='color=$fcolor;' class='info' href='#'>
                        $phone_id 
                        <span>
                            ID:$phone_id                           
                            <br />                                                    
                            IP:$station_ip
                            <br />
                            Duration: [$diff[hours]:$diff[minutes]:$diff[seconds]]
                            <br />                  
                            Call Status: $call_status                            
                            <br />                  
                            Agent: $username
                            <br />                  
                            Total Calls: $total_calls
                            <br />
                            Campaign: $campaign_id

                        </span>
                    </a>           
                    ";
                               
                
                }# END if (mysql_num_rows($result_vici) > 0)
              
                #check if sip id has live call (manual)
                $result_manual = mysql_query("
                    SELECT 
                    phone_id,channel,phone_number,call_start,campaign_id,server_id 
                    FROM call_sessions 
                    WHERE phone_id = '$phone_id'
                ",$cn);
                if (mysql_num_rows($result_manual) > 0){
                    # there is a live call, get call details
                    $row_manual   = mysql_fetch_row($result_manual);                      
                    $phone_id       = $row_manual[0];
                    $channel      = $row_manual[1];          
                    $phone_number = $row_manual[2];       
                    $call_start   = $row_manual[3];       
                    $campaign_id  = $row_manual[4];       
                    $server_id    = $row_manual[5];                           
                    
                    $total_calls_manual++;
                    
                    $diff = timeDiff(strtotime("$call_start"), strtotime("$timestamp")); 
                    # #ADDFFF                                      
                    if ($diff[minutes] == 0){$bgcolor = "#ADDFFF";}
                    if ($diff[minutes] >= 1 && $diff[minutes] <= 5){$bgcolor = "#3BB9FF";} 
                    if ($diff[minutes] >= 6 && $diff[minutes] <= 60){$bgcolor = "#1569C7";}
                    if ($diff[hours] > 0){$bgcolor = "#153E7E";}
                    
                    if ($campaign_id == '15522'){$bgcolor='red';}             
                    
                    $info = "
                    <a style='color=$fcolor;' class='info' href='#'>
                        $phone_id 
                        <span>
                            ID:$phone_id
                            <br />
                            IP:$station_ip
                            <br />
                            Phone: $phone_number
                            <br />
                            Duration: [$diff[hours]:$diff[minutes]:$diff[seconds]]
                            <br />                  
                            Channel: $channel
                            <br />
                            Campaign: $campaign_id
                            <br />
                            Server: $server_id
                        </span>
                    </a>           
                    ";
                                                 
                }# END if (mysql_num_rows($result_manual) > 0) 
                #mysql_free_result($result_manual);              
                                            
            }# END if(strlen($row_sip[0])>0)       
        }# END if (mysql_num_rows($result_sip) > 0) 
        
        if ($_GET['edit']){
            echo"
                <td>              
                    <input style='text-align:center;width:25px;background:$bgcolor;border:$border;height:15px;font-size:9px;' type='text' value='$phone_id' name='values[]'>
                    <input type='hidden' value='$r:$c' name='coordinates[]'>              
                </td>                   
            "; 
        } else {                                   
            echo"                                              
                <td>
                    <div style='text-align:center;height:13px;width:30px;background:$bgcolor;color:$fcolor;border:$border;font-size:9px;font-family:verdana'>
                    $info
                    </div>
                    <input type='hidden' value='$r:$c' name='coordinates[]'>                     
                </td>                   
            ";       
        } 
        
        
        
        
    }# END FOR $c
    echo"</tr>"; 
}# END FOR $r

if ($_GET['edit']){
    
    echo"<input type='submit' value='Save' name='btnSave'>  ";
    
}  else {
    
    $total_calls_report = $total_calls_manual + $total_calls_vicidial_live;

    echo"
    </table>     

    <table align='center' style='font-size:9px;font-family:verdana;' rules='all' border=1>
    <tr><td colspan=3>Total Calls: $total_calls_report</td></tr>
    <tr><td>Manual dial: $total_calls_manual</td><td>Vicidial: $total_calls_vicidial_live</td><td>Vicidial (Paused) : $total_calls_vicidial_paused</td></tr>
    </table>

    <table align='center' style='font-size:9px;font-family:verdana;'>
        <tr><td>LEGEND:</td></tr>    
        <tr>       
            <td><div style='width:50px;height:10px;background:#ADDFFF;'></div></td><td>MANUAL DIAL - Agent on call less than 1 minute</td>
            <td><div style='width:50px;height:10px;background:#FDEEF4;'></div></td><td>VICIDIAL - Agent on call less than 1 minute</td>
            <td><div style='width:50px;height:10px;background:#FAF8CC;'></div></td><td>VICIDIAL - Paused agents less than 1 minute</td>
        </tr>        
        <tr>
            <td><div style='width:50px;height:10px;background:#3BB9FF;'></div></td><td>MANUAL DIAL - Agent on call greater than 1 minute</td>    
            <td><div style='width:50px;height:10px;background:#C38EC7;'></div></td><td>VICIDIAL - Agent on call greater than 1 minute</td>
            <td><div style='width:50px;height:10px;background:#EDDA74;'></div></td><td>VICIDIAL - Paused agents greater than 1 minute</td>
            
        </tr>
        <tr>
            <td><div style='width:50px;height:10px;background:#1569C7;'></div></td><td>MANUAL DIAL - Agent on call greater than 5 minutes</td>
            <td><div style='width:50px;height:10px;background:#B93B8F;'></div></td><td>VICIDIAL - Agent on call greater than 5 minutes</td>
            <td><div style='width:50px;height:10px;background:#FDD017;'></div></td><td>VICIDIAL - Paused agents greater than 5 minutes</td>
        </tr>
        <tr>
            <td><div style='width:50px;height:10px;background:#153E7E;'></div></td><td>MANUAL DIAL - Agent on call greater than 1 Hour</td>
            <td><div style='width:50px;height:10px;background:#7E587E;'></div></td><td>VICIDIAL - Agent on call greater than 1 Hour</td>
            <td><div style='width:50px;height:10px;background:#AF7817;'></div></td><td>VICIDIAL - Paused agents greater than 1 Hour</td>
        </tr>
        <tr>
            <td><div style='width:50px;height:10px;background:grey;'></div></td><td>Online PC without calls (When in doubt,<br />Use VNC Viewer to double check)</td>
            <td><div style='width:50px;height:10px;background:black;'></div></td><td>Offline PC (Updates every 5 minutes)</td>
            <td><div style='width:50px;height:10px;background:red;'></div></td><td>Agent calling IT Support Hotline (5522)</td>
        </tr>
     
    </table>
    ";  

}

echo"</form>";
?>
