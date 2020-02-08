<head>
<style  type='text/css'>@import url(css/layout.css);</style>


<script type='text/javascript' src='js/jquery-1.9.1.min.js'> </script>
<script type="text/javascript" src="js/jquery-ui-1.10.0.custom.min.js"></script>  


<!--
<script type='text/javascript' src='js/jquery-1.6.min.js'> </script>
<script type="text/javascript" src="js/jquery-ui-1.8.12.custom.min.js"></script>  
--> 
<title>Workstation Monitoring</title>
</head>
  

<div id='header' class='header'>                        
    <span style='position:absolute;top:10px;left:20px;' id='header_text'>Workstation Monitoring</span>
</div>

<div id='floor_map'>
<?php echo $Monitoring->generate_floor($layout_id); //this cannot be loaded via ajax, needs html output ?>
</div>
<div id='test'></div>

<br />    

<table align='center' style='font-size:9px;font-family:verdana;' rules='all' border=1>
<tr><td colspan=3>Total Calls: <span id='total_calls'></span></td></tr>
<tr><td>Manual dial: <span id='total_calls_manual'></td><td>Vicidial: <span id='total_calls_vicidial'></td><td>Vicidial (Paused) : <span id='total_calls_paused'></td></tr>
</table>

<table align='center' style='font-size:9px;font-family:verdana;'>
    <tr><td>LEGEND:</td></tr>    
    <tr>       
 
        <td><div style='width:50px;height:10px;background:#F9B7FF;'></div></td><td>VICIDIAL - Agent on call less than 1 minute</td>
        <td><div style='width:50px;height:10px;background:#FAF8CC;'></div></td><td>VICIDIAL - Paused agents less than 1 minute</td>
    </tr>        
    <tr>
        
        <td><div style='width:50px;height:10px;background:#E6A9EC;'></div></td><td>VICIDIAL - Agent on call greater than 1 minute</td> 
        <td><div style='width:50px;height:10px;background:#EDDA74;'></div></td><td>VICIDIAL - Paused agents greater than 1 minute</td>
        
    </tr>
    <tr>

        <td><div style='width:50px;height:10px;background:#C38EC7;'></div></td><td>VICIDIAL - Agent on call greater than 5 minutes</td>
        <td><div style='width:50px;height:10px;background:#FDD017;'></div></td><td>VICIDIAL - Paused agents greater than 5 minutes</td> 
    </tr>   
    <tr>
        <!-- <td><div style='width:50px;height:10px;background:#153E7E;'></div></td><td>MANUAL DIAL - Agent on call greater than 1 Hour</td> -->
        <!-- <td><div style='width:50px;height:10px;background:white;border: solid 2px red;'></div></td><td>QA Monitoring</td> -->                        
        <td><div style='width:50px;height:10px;background:#7E587E;'></div></td><td>VICIDIAL - Agent on call greater than 1 Hour</td>  
        <td><div style='width:50px;height:10px;background:#AF7817;'></div></td><td>VICIDIAL - Paused agents greater than 1 Hour</td>  
    </tr>
         
    <tr>
        <!-- <td><div style='width:50px;height:10px;background:yellow;'></div></td><td>You can now click on the stations to monitor calls</td> -->
	    <!-- <td><div style='width:50px;height:10px;background:green;'></div></td><td>INBOUND TOLLFREE</td>-->
        <td><div style='width:50px;height:10px;background:black;'></div></td><td>Offline PC (Updates every 5 minutes)</td>
        <!-- <td><div style='width:50px;height:10px;background:red;'></div></td><td>Agent calling IT Support Hotline (5522)</td>-->
    </tr>
           

                    
</table>