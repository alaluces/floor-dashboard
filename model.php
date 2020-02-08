<?php       

class class_monitoring{ 
    
 
    function generate_floor($layout_id){
        $result = mysql_query("SELECT layout_name,num_rows,num_cols 
           FROM layout_info
           WHERE layout_id = '$layout_id' AND active = '1';");
        if (mysql_num_rows($result) <=0 ){
            return false;
        } else {
            $row = mysql_fetch_row($result);
            $layout_name = $row[0];
            $nrows       = $row[1];
            $ncols       = $row[2];
        }     

        $floor_output = "";
        $floor_output.="<br /><table align='center'>"; 
        for ($r=1;$r<=$nrows;$r++){
            $floor_display .= "<tr>";
            for ($c=1;$c<=$ncols;$c++){ 
                unset($info);
                unset($phone_id);             
                $div_id    = "";  
                $div_class = "class='sip_blank'";                 

                # lets just get the sip_ids first
                $result_sip = mysql_query("
                    SELECT item_id FROM layout_grid AS a
                    INNER JOIN phones AS b
                    ON a.item_id = b.phone_id 
                    WHERE layout_id = '$layout_id' 
                    AND ROW='$r' AND col='$c'");  
                if (mysql_num_rows($result_sip) > 0){
                    $row_sip = mysql_fetch_row($result_sip);
                    if(strlen($row_sip[0])>0){                                   
                        $phone_id  = $row_sip[0];
                        $div_id    = "id=$phone_id";  
                        $div_class = "class='sip'";                                
                    }
                }                          
              $floor_output.="<td>
                    <div $div_id $div_class>$phone_id</div>               
                    <div id='detail_$phone_id' class='details'></div>                                   
                    <input type='hidden' value='$r:$c' name='coordinates[]'>                     
                </td>";

            }# END FOR $c
            $floor_output.="</tr>"; 
        }# END FOR $r
       $floor_output.="</table>";   
       
       return $floor_output;
    }
    
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
    
    function colorize_stations($timestamp){
        
       
        # GET MANUAL DIAL DETAILS
        $result_sip = mysql_query("SELECT p.phone_id,sc.call_start,p.online,sc.campaign_id,sc.call_type,sc.phone_number            
                                    FROM phones AS p 
                                    LEFT JOIN session_calls AS sc
                                    ON p.phone_id = sc.phone_id "); 
        $i = 0; 

        while($row_sip = mysql_fetch_row($result_sip)){

            $arr_hours[$i]        = "X";
            $arr_minutes[$i]      = "X"; 
            $arr_campaign_id[$i]  = "";  
            $arr_call_type[$i]    = "";  
            $arr_phone_number[$i] = "";      
            unset($arr_duration);

            $arr_sip_id[$i]       = $row_sip[0];
            $call_start           = $row_sip[1]; 
            $arr_online[$i]       = $row_sip[2]; 
            $arr_campaign_id[$i]  = $row_sip[3];  
            $arr_call_type[$i]    = $row_sip[4]; 
            $arr_phone_number[$i] = $row_sip[5];             
            $arr_dial_method[$i] = "MANUAL"; 
            $arr_dial_status[$i] = "INCALL"; 

            if ($call_start != "" || !is_null($call_start)){
                $arr_duration    = $this->timeDiff(strtotime("$call_start"), strtotime("$timestamp"));      
                $arr_hours[$i]   = $arr_duration[hours]; 
                $arr_minutes[$i] = $arr_duration[minutes];  
            }                                      
            $i++;      
        }  


        #$cn_vici = mysql_connect("192.168.5.37","aries","1234");        
        $cn_vici = mysql_connect("localhost","cron","1234");
        if (!$cn_vici) {die('Could not connect: ' . mysql_error());}
        mysql_select_db("asterisk", $cn_vici);  
        $result_vici = mysql_query("
                SELECT
                RIGHT(extension,4),last_call_time,status
                FROM vicidial_live_agents",$cn_vici);                

        while ($row_vici = mysql_fetch_row($result_vici)){
            unset($arr_duration);       

            # REPLACE EXISTING VALUES IN THE ARRAY
            $si = array_search($row_vici[0],$arr_sip_id);
            $call_start           = $row_vici[1];                
            $arr_dial_method[$si] = "VICIDIAL"; 
            $arr_dial_status[$si] = $row_vici[2]; 

            if ($call_start != "" || !is_null($call_start)){
                $arr_duration     = $this->timeDiff(strtotime("$call_start"), strtotime("$timestamp"));      
                $arr_hours[$si]   = $arr_duration[hours]; 
                $arr_minutes[$si] = $arr_duration[minutes]; 
            }                  
        }
        
        // this is not working when uploaded to server                  
        //$data['sip_id']  = implode("|",$arr_sip_id);
        //$data['hours']   = implode("|",$arr_hours);
        //$data['minutes'] = implode("|",$arr_minutes);         
        //echo json_encode($data);  
        //so i did this

        $str_sip_id       = implode("|",$arr_sip_id);
        $str_call_type    = implode("|",$arr_call_type);    
        $str_hours        = implode("|",$arr_hours);
        $str_minutes      = implode("|",$arr_minutes); 
        $str_online       = implode("|",$arr_online);   
        $str_dial_method  = implode("|",$arr_dial_method);
        $str_dial_status  = implode("|",$arr_dial_status); 
        $str_phone_number = implode("|",$arr_phone_number);     

        return "{\"sip_id\":\"$str_sip_id\",\"hours\":\"$str_hours\",\"minutes\":\"$str_minutes\",\"dial_status\":\"$str_dial_status\",\"dial_method\":\"$str_dial_method\",\"online\":\"$str_online\",\"call_type\":\"$str_call_type\",\"phone_number\":\"$str_phone_number\"}";
    }
        
    function get_station_details($timestamp,$sip_id){

        $detailed = 0; 
        
        unset($info);

        $result_manual = mysql_query("SELECT ip_address,server_id FROM phones WHERE phone_id = '$sip_id'");     
        if (mysql_num_rows($result_manual) > 0){
            $row_manual  = mysql_fetch_row($result_manual);
            $ip_address = $row_manual[0];  
            $server_id  = $row_manual[1];   
        }                    

        $result_manual = mysql_query("
            SELECT 
            phone_id,channel,phone_number,call_start,campaign_id 
            FROM session_calls
            WHERE phone_id = '$sip_id'");
        if (mysql_num_rows($result_manual) > 0){
            # there is a live call, get call details
            $detailed     = 1;
            $row_manual   = mysql_fetch_row($result_manual);                      
            $sip_id       = $row_manual[0];
            $channel      = $row_manual[1];          
            $phone_number = $row_manual[2];       
            $call_start   = $row_manual[3];       
            $campaign_id  = $row_manual[4];         
            $diff = $this->timeDiff(strtotime("$call_start"), strtotime("$timestamp"));          
        }    


        
        #$cn_vici = mysql_connect("192.168.5.37","aries","1234");        
        $cn_vici = mysql_connect("localhost","cron","1234");
        if (!$cn_vici) {die('Could not connect: ' . mysql_error());}
        mysql_select_db("asterisk", $cn_vici);  
        $result_vicidial = mysql_query("
            SELECT 
            vla.extension,vl.phone_number,vla.last_call_time,vla.campaign_id 
            FROM vicidial_live_agents AS  vla
            INNER JOIN vicidial_list AS vl
            ON vla.lead_id = vl.lead_id
            WHERE RIGHT(extension,4) = '$sip_id'",$cn_vici);
        if (mysql_num_rows($result_vicidial) > 0){
            # there is a live call, get call details
            $detailed     = 1;
            $row_vici   = mysql_fetch_row($result_vicidial);                      
            $sip_id       = $row_vici[0];
            $channel      = "";          
            $phone_number = $row_vici[1];       
            $call_start   = $row_vici[2];       
            $campaign_id  = $row_vici[3];         
            $diff = $this->timeDiff(strtotime("$call_start"), strtotime("$timestamp"));            
        }            



        if ($detailed){
                $info = " 
                ID:$sip_id
                <br />
                IP:$ip_address
                <br />
                Phone: $phone_number
                <br />
                Duration: [$diff[hours]:$diff[minutes]:$diff[seconds]]
                <br />                  
                Channel: $channel
                <br />
                Campaign: $campaign_id
                <br />    
                Server:$server_id              
            "; 
        } else {
            $info = " 
                ID:$sip_id
                <br />
                IP:$ip_address 
                <br />    
                Server:$server_id              
            ";     
        }

        return $info;
    }   
        

  
}
?>
