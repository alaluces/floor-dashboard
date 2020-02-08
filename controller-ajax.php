<script type='text/javascript'> 

$(document).ready(function(){ 
    // Display version 
    $.ajaxSetup({ cache: false });      
    $("#header_text").append(" <?php echo"$version";?>");

    
    var refreshId = setInterval(function() {
        
        $.get(
            "controller-php.php",
            {colorize_stations:"true"},
            function(data){
                var sip_id          = data.sip_id;
                var call_type       = data.call_type;    
                var phone_number    = data.phone_number;        
                var hours           = data.hours;   
                var minutes         = data.minutes;  
                var dial_status     = data.dial_status;
                var dial_method     = data.dial_method;   
                var online_pc       = data.online;      
                var arr_sip_id      = sip_id.split("|"); 
                var arr_call_type   = call_type.split("|"); 
                var arr_phone_number = phone_number.split("|");                  
                var arr_hours       = hours.split("|");  
                var arr_minutes     = minutes.split("|");
                var arr_dial_status = dial_status.split("|");   
                var arr_dial_method = dial_method.split("|");  
                var arr_online      = online_pc.split("|");  
                var bgcolor         = "";
                var fcolor          = "black";  
                var total_calls          = 0;
                var total_calls_manual   = 0;
                var total_calls_vicidial = 0;
                var total_calls_paused   = 0;
                
                //alert( dial_method);                                
                
                $(".sip").css({"border": "none"});                           
                for (i=0;i<=arr_sip_id.length;i=i+1){
                    fcolor          = "black";                      
                                              
                    if (arr_dial_status[i] == "INCALL" && arr_dial_method[i] == "VICIDIAL"){                                        
                        if (arr_minutes[i] == 0)                        {bgcolor = "#F9B7FF";}
                        if (arr_minutes[i] >= 1 && arr_minutes[i] <= 5) {bgcolor = "#E6A9EC";}
                        if (arr_minutes[i] >= 6 && arr_minutes[i] <= 60){bgcolor = "#C38EC7";}
                        if (arr_hours[i] > 0)                           {bgcolor = "#B93B8F";} 
                        total_calls_vicidial++;                            
                    }                                                 
                
                    if ((arr_dial_status[i] == "PAUSED"|| arr_dial_status[i] == "DISPO" || arr_dial_status[i] == "CLOSER") && arr_dial_method[i] == "VICIDIAL"){                                        
                        if (arr_minutes[i] == 0)                        {bgcolor = "#FAF8CC";}
                        if (arr_minutes[i] >= 1 && arr_minutes[i] <= 5) {bgcolor = "#EDDA74";}
                        if (arr_minutes[i] >= 6 && arr_minutes[i] <= 60){bgcolor = "#FDD017";}
                        if (arr_hours[i] > 0)                           {bgcolor = "#AF7817";}   
                        total_calls_paused++;                          
                    }     
                    
                    if (arr_dial_status[i] == "INCALL" && arr_dial_method[i] == "MANUAL"){ 
                        if (arr_online[i] == "1" && arr_minutes[i] == "X"){bgcolor = "#736F6E";} 
                        if (arr_online[i] == "0" && arr_minutes[i] == "X"){bgcolor = "black";  fcolor = "white";}                                                                                    
                        if (arr_minutes[i] == 0)                          {bgcolor = "#ADDFFF";}                           
                        if (arr_minutes[i] >= 1 && arr_minutes[i] <= 5)   {bgcolor = "#3BB9FF"; fcolor = "white";}
                        if (arr_minutes[i] >= 6 && arr_minutes[i] <= 60)  {bgcolor = "#1569C7"; fcolor = "white";}
                        if (arr_hours[i] > 0)                             {bgcolor = "#153E7E"; fcolor = "white";} 
                        if (arr_call_type[i] == "IT")                     {bgcolor = "red";     fcolor = "white";} 
                        if (arr_call_type[i] == "QA")                     {fcolor  = "white";   $("#" + arr_phone_number[i]).css({"border": "solid 2px red"});    }  
                        if (arr_call_type[i] == "IN")                     {bgcolor = "green";   fcolor = "white";}     
                        if ($("#" + arr_sip_id[i]).html() == arr_sip_id[i] && arr_minutes[i] != "X"){total_calls_manual++;}                             
                    }         
                    
                    total_calls = total_calls_manual + total_calls_vicidial;
                    
                    $("#total_calls").html(total_calls);
                    $("#total_calls_manual").html(total_calls_manual);
                    $("#total_calls_vicidial").html(total_calls_vicidial);
                    $("#total_calls_paused").html(total_calls_paused);                 
                    
                    $("#" + arr_sip_id[i]).animate({ backgroundColor:bgcolor, color: fcolor },2000);                                    
                    //$("#" + arr_sip_id[i]).css({"background-color": bgcolor,"color": fcolor}); 
                    //$("#" + arr_sip_id[i]).fadeIn("5000");         
                                                               
                                         
                }    
            },'json'
         );  
                
                                                                   
    }, 5000);                        
    
    
    $("#floor_map").hover(
        function(){
            $(".details").hide();     
        }    
    );
    
    $(".details").click(
        function(){
            $(".details").hide();     
        }    
    );
    
    $(".sip").hover(    
        function(){  
            id = $(this).html(); 
            $.get(
                "controller-php.php",
                {get_details:"true",sip_id:id},
                function(data){
                    $(".details").hide();   
                    $("#detail_" + id).html(data).fadeIn("3000"); 
                }                                 
                //,'json'     
            );                                                             
            //alert("#detail_" + id);                             
        },function(){    
            $(".details").hide();                
        }
    ); 
    
    $(".sip").click(    
        function(){  
            id = $(this).html(); 
            self.location = 'SIP:99'+id;
        }
    );      
                                                           
}); 




</script>  

<?php 




?>
