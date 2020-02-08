<style>
a.info{
    position:relative; /*this is the key*/
    z-index:24;     
    color:#000;
    text-decoration:none
}

a.info:hover{z-index:25; background-color:#ff0}

a.info span{display: none}

a.info:hover span{ /*the span will display just on :hover state*/
    display:block;
    position:absolute;
    top:25px; left:0px; width:200px;
    border:1px solid #0cf;
    background-color:#cff; color:#000;
    text-align: left;
    font-family:verdana;
    font-size:11px;
}

</style>

<script>
<!--

/*
Auto Refresh Page with Time script
By JavaScript Kit (javascriptkit.com)
Over 200+ free scripts here!
*/

//enter refresh time in "minutes:seconds" Minutes should range from 0 to inifinity. Seconds should range from 0 to 59
var limit="0:05"

if (document.images){
    var parselimit=limit.split(":")
    parselimit=parselimit[0]*60+parselimit[1]*1
}
function beginrefresh(){
    if (!document.images)
    return
    if (parselimit==1)
    window.location.reload()
    else{ 
        parselimit-=1
        curmin=Math.floor(parselimit/60)
        cursec=parselimit%60
        if (curmin!=0)
        curtime=curmin+" minutes and "+cursec+" seconds left until page refresh!"
        else
        curtime=cursec+" seconds left until page refresh!"
        window.status=curtime
        setTimeout("beginrefresh()",1000)
    }
}

window.onload=beginrefresh
//-->
</script>
<?php

/*
Live Call Monitoring (Vicidial & Manual Dial)
Author: Aries Laluces
100723 - initial CODE
       - javascript auto refresh
       - css tooltip 
       - can monitor manual dial for now
100704 - 


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

$timestamp = date("Y-m-d H:i:s"); 

$cn = mysql_connect("localhost","llcc","1234");
if (!$cn) {die('Could not connect: ' . mysql_error());}
mysql_select_db("llcc_ast_web", $cn); 

if (isset($_POST['btnSave'])){
    #note: cleanup array vars after you assign them, not before
    $arr_values      = $_POST['values'];    
    $arr_coordinates = $_POST['coordinates'];
     
     #clear table first
     mysql_query("DELETE FROM layout_grid",$cn);    
    for ($i=0;$i<count($arr_coordinates);$i++){
        $arr_coordinates2 = explode(":",$arr_coordinates[$i]);
        #populate values again
        mysql_query("INSERT INTO layout_grid VALUES ('$arr_values[$i]','$arr_coordinates2[0]','$arr_coordinates2[1]')",$cn);
        #echo "c=$arr_coordinates[$i]<br />v=$arr_values[$i]<br />";     
    
    }

} 

$nrows = 17;
$ncols = 25; 
echo"
<br />
<form action='index.php' method='POST'>

<table align='center'>
";

$total_calls_manual          = 0;
$total_calls_vicidial_paused = 0;
$total_calls_vicidial_live   = 0;

for ($r=1;$r<=$nrows;$r++){
    echo"<tr>";
    for ($c=1;$c<=$ncols;$c++){
        
        # set default values        
        $bgcolor = "white";
        $border  = "none";
        $info    = "";
        
        # lets just get the sip_ids first
        $result_sip = mysql_query("SELECT item_id FROM layout_grid WHERE ROW='$r' AND col='$c'",$cn);  
        if (mysql_num_rows($result_sip) > 0){
            $row_sip = mysql_fetch_row($result_sip);
            if(strlen($row_sip[0])>0){                
                $sip_id = $row_sip[0]; 
                
                # compute ip address
                $ip = $sip_id - 60;
                $station_ip = "192.168.5." . $ip;            
                                                        
                $bgcolor = "gray";
                $border  = "solid thin black";
                $info = "
                <a class='info' href='#'>
                    $sip_id 
                    <span>
                        ID:$sip_id                           
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
                        WHERE RIGHT(extension,3) = '$sip_id'
                ",$cn_vici);                

                if (mysql_num_rows($result_vici) > 0){
                    $row_vici = mysql_fetch_row($result_vici);
                    $username    = $row_vici[0];
                    $call_status = $row_vici[1];  
                    $call_start  = $row_vici[2];  
                    $total_calls = $row_vici[3];
                    $campaign_id = $row_vici[4];
                    
                    #echo"$sip_id $username<br />";
                    
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
                    <a class='info' href='#'>
                        $sip_id 
                        <span>
                            ID:$sip_id                           
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
                    sip_id,channel,phone_number,call_start,campaign_id,server_id 
                    FROM call_sessions 
                    WHERE sip_id = '$sip_id'
                ",$cn);
                if (mysql_num_rows($result_manual) > 0){
                    # there is a live call, get call details
                    $row_manual   = mysql_fetch_row($result_manual);                      
                    $sip_id       = $row_manual[0];
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
                    
                    $info = "
                    <a class='info' href='#'>
                        $sip_id 
                        <span>
                            ID:$sip_id
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
        
        echo"
            <td>
                <div style='text-align:center;width:30px;background:$bgcolor;border:$border;height:15px;font-size:9px;font-family:verdana'>
                $info
                </div>
                <input type='hidden' value='$r:$c' name='coordinates[]'>  
            </td>                   
        "; 
    }# END FOR $c
    echo"</tr>"; 
}# END FOR $r

$total_calls_report = $total_calls_manual + $total_calls_vicidial_live + $total_calls_vicidial_paused;

echo"
</table>
    
</form>
<table align='center' style='font-size:9px;font-family:verdana;' rules='all' border=1>
<tr><td colspan=3>Total Calls: $total_calls_report</td></tr>
<tr><td>Manual dial: $total_calls_manual</td><td>Vicidial (Live): $total_calls_vicidial_live</td><td>Vicidial (Paused) : $total_calls_vicidial_paused</td></tr>
</table>

<table align='center' style='font-size:9px;font-family:verdana;'>
    <tr><td>LEGEND:</td></tr>
    <tr>
        <td><div style='width:50px;height:10px;background:grey;'></div></td><td>NO CALLS</td>
    </tr>    
    <tr>       
        <td><div style='width:50px;height:10px;background:#ADDFFF;'></div></td><td>MANUAL DIAL - Live calls less than 1 minute</td>
        <td><div style='width:50px;height:10px;background:#FDEEF4;'></div></td><td>VICIDIAL - Live calls less than 1 minute</td>
        <td><div style='width:50px;height:10px;background:#FAF8CC;'></div></td><td>VICIDIAL - Paused agents less than 1 minute</td>
    </tr>        
    <tr>
        <td><div style='width:50px;height:10px;background:#3BB9FF;'></div></td><td>MANUAL DIAL - Live calls greater than 1 minute</td>    
        <td><div style='width:50px;height:10px;background:#C38EC7;'></div></td><td>VICIDIAL - Live calls greater than 1 minute</td>
        <td><div style='width:50px;height:10px;background:#EDDA74;'></div></td><td>VICIDIAL - Paused agents greater than 1 minute</td>
        
    </tr>
    <tr>
        <td><div style='width:50px;height:10px;background:#1569C7;'></div></td><td>MANUAL DIAL - Live calls greater than 5 minutes</td>
        <td><div style='width:50px;height:10px;background:#B93B8F;'></div></td><td>VICIDIAL - Live calls greater than 5 minutes</td>
        <td><div style='width:50px;height:10px;background:#FDD017;'></div></td><td>VICIDIAL - Paused agents greater than 5 minutes</td>
    </tr>
    <tr>
        <td><div style='width:50px;height:10px;background:#153E7E;'></div></td><td>MANUAL DIAL - Live calls greater than 1 Hour</td>
        <td><div style='width:50px;height:10px;background:#7E587E;'></div></td><td>VICIDIAL - Live calls greater than 1 Hour</td>
        <td><div style='width:50px;height:10px;background:#AF7817;'></div></td><td>VICIDIAL - Paused agents greater than 1 Hour</td>
    </tr>
 
</table>
";  

#<input style='text-align:center;width:25px;background:$bgcolor;border:$border;height:15px;font-size:9px;' type='text' value='$dur' name='values[]'>
# <input style='text-align:center;width:25px;background:$bgcolor;border:$border;height:15px;font-size:9px;' type='text' value='$sip_id' name='values[]'>
# <input type='submit' value='Save' name='btnSave'>  
?>
