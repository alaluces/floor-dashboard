<style>
a.info{
    position:relative; /*this is the key*/
    z-index:24; 
    
    color:#000;
    text-decoration:none}

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
     mysql_query("DELETE FROM layout_grid");    
    for ($i=0;$i<count($arr_coordinates);$i++){
        $arr_coordinates2 = explode(":",$arr_coordinates[$i]);
        #populate values again
        mysql_query("INSERT INTO layout_grid VALUES ('$arr_values[$i]','$arr_coordinates2[0]','$arr_coordinates2[1]')");
        #echo "c=$arr_coordinates[$i]<br />v=$arr_values[$i]<br />";     
    
    }

} 

$nrows = 17;
$ncols = 25; 
echo"
<form action='monitoring.php' method='POST'>

<table align='center'>
";
for ($r=1;$r<=$nrows;$r++){
    echo"<tr>";
    for ($c=1;$c<=$ncols;$c++){
        
        # set default values        
        $bgcolor = "white";
        $info    = ""; 
        $border  = "none";
        $dur     = "";
        
        #check for live calls first
        $result = mysql_query("SELECT 
                        sip_id,channel,phone_number,call_start,campaign_id,server_id 
                        FROM layout_grid AS a
                        INNER JOIN call_sessions AS b
                        ON a.item_id = b.sip_id 
                        WHERE ROW='$r' AND col='$c'
                        ");
        if (mysql_num_rows($result) > 0){
            # there is a live call, get call details
            $row_result   = mysql_fetch_row($result);                      
            $sip_id       = $row_result[0];
            $channel      = $row_result[1];       
            $phone_number = $row_result[2];       
            $call_start   = $row_result[3];       
            $campaign_id  = $row_result[4];       
            $server_id    = $row_result[5];       
            
            $diff = timeDiff(strtotime("$call_start"), strtotime("$timestamp"));                                       
            $bgcolor = "gray";
            if ($diff[minutes] == 0){$bgcolor = "#5CB3FF";}
            if ($diff[minutes] >= 1 && $diff[minutes] <= 5){$bgcolor = "#1569C7";} 
            if ($diff[minutes] >= 6 && $diff[minutes] <= 30){$bgcolor = "#153E7E";}
            if ($diff[hours] > 0){$bgcolor = "#151B54";}           
            
            $border  = "solid thin black"; 
            $info = "
            <a class='info' href='#'>
                $sip_id 
                <span>
                    ID:$sip_id
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
                                         
        }  else {
            # if no result, it means no live calls
            # lets just get the sip_id
            $result = mysql_query("SELECT item_id FROM layout_grid WHERE ROW='$r' AND col='$c'");  
            if (mysql_num_rows($result) > 0){
                $row_result = mysql_fetch_row($result);
                if(strlen($row_result[0])>0){                
                    $sip_id = $row_result[0];                                         
                    $bgcolor = "gray";
                    $border  = "solid thin black";
                    $info = $sip_id;              
                }        
            }      
                
        }
        
        echo"
            <td width='500'>

                <div style='text-align:center;width:35px;background:$bgcolor;border:$border;height:15px;font-size:9px;font-family:verdana'>
                $info
                </div>
                <input type='hidden' value='$r:$c' name='coordinates[]'>  
            </td>                   
        "; 
    }
    echo"</tr>"; 
}
echo"
</table>

</form>"; 
  

#<input style='text-align:center;width:25px;background:$bgcolor;border:$border;height:15px;font-size:9px;' type='text' value='$dur' name='values[]'>
# <input style='text-align:center;width:25px;background:$bgcolor;border:$border;height:15px;font-size:9px;' type='text' value='$sip_id' name='values[]'>
# <input type='submit' value='Save' name='btnSave'>  
?>
