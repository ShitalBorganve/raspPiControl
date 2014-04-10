<?php
require_once('_session.inc.php');
//Sysinfo & Prozesse
exec('TERM=xterm /usr/bin/top n 1 b 2>&1', $returnvalue);
$line1 = $returnvalue[0];
$line4 = $returnvalue[2];
$line1split = explode(',', $line1);
$line1split2 = explode(' ', $line1);
$len = count($line1split2);
$systemtime = $line1split2[2];
$uptime = $line1split2[4];
if(strlen($uptime) < 4)
{
	$uptime .= ' ' . $line1split2[5];
}
$uptime = str_replace(',', '', $uptime);
$load1 = str_replace(',', '', $line1split2[$len - 3]);
$load2 = str_replace(',', '', $line1split2[$len - 2]);
$load3 = str_replace(',', '', $line1split2[$len - 1]);

$text = preg_replace('/\040{1,}/',' ',$line4); 
$line4split = explode(',', $text);
$cpu1 = explode(' ', $line4split[0]);
$cpu2 = explode(' ', $line4split[1]);
$cpu3 = explode(' ', $line4split[2]);
$cpu4 = explode(' ', $line4split[3]);
$cpu5 = explode(' ', $line4split[4]);
$cpu6 = explode(' ', $line4split[5]);
$cpu7 = explode(' ', $line4split[6]);

$line5 = $returnvalue[3];
$line5 = preg_replace('/\040{1,}/',' ',$line5); 
$line5split = explode(' ', $line5);
$percent = round($line5split[6] / ($line5split[2] / 100), 1);

exec('TERM=xterm  cat /sys/class/thermal/thermal_zone0/temp 2>&1', $temperature);
$temp = round($temperature[0] / 1000, 1);
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<meta name="author" content="Twitter @RevUnix" />
	<title>raspPiControl</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/raspPiControl.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>


</head>
<body>
    <div class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <a href="../" class="navbar-brand"><img src="/img/logo.png" width="50px" height="50px" alt=""> raspPiControl <3</a>
        </div>
      </div>
    </div>
<div class="container">
    <div class="wrap-content">
        <div class="wrap-content-inner">
                
                <!-- Nav tabs -->
                <ul class="nav nav-tabs">
                  <li class="active">
                  <a href="#dashboard"      data-toggle="tab">Dashboard</a></li>
                  <li><a href="#prozesse"   data-toggle="tab">Prozesse</a></li>
                  <li><a href="#hdd"        data-toggle="tab">Laufwerke</a></li>
                  <li><a href="#tools"      data-toggle="tab">Einstellungen</a></li>
                </ul>
                
                <!-- Tab panes -->
                <div class="tab-content">
                  <div class="tab-pane active" id="dashboard">
                  
                    <h5><b>UpTime:</b> <?php echo $uptime . " @ " . $temp; ?> °C</h5>
					<h5><b>Systemzeit:</b> <?php echo $line1split2[2]; ?></h5>
					<h5><b>Systemload:</b> <?php echo $load1 . ', ' . $load2 . ', ' . $load3; ?></h5>
                    
                    <hr />
                    
                    <h5>CPU:</h5>
                    
                    <h6>Auslastung <span class="pull-right"><?php echo $cpu1[1] ?>%</span></h6>
                    <div class="progress progress-striped active">
                      <div class="progress-bar" style="width: <?php echo $cpu1[1] ?>%"></div>
                    </div>
                    
                    <h6>System <span class="pull-right"><?php echo $cpu2[1] ?>%</span></h6>
                    <div class="progress progress-striped active">
                      <div class="progress-bar" style="width: <?php echo $cpu2[1] ?>%"></div>
                    </div>
                    
                    <h6>Prio &gt; 0 <span class="pull-right"><?php echo $cpu3[1] ?>%</span></h6>
                    <div class="progress progress-striped active">
                      <div class="progress-bar" style="width: <?php echo $cpu3[1] ?>%"></div>
                    </div>
                    
                    <h6>Bereitschaft <span class="pull-right"><?php echo $cpu4[1] ?>%</span></h6>
                    <div class="progress progress-striped active">
                      <div class="progress-bar" style="width: <?php echo $cpu4[1] ?>%"></div>
                    </div>
                    
                    <h6>Wartend <span class="pull-right"><?php echo $cpu5[1] ?>%</span></h6>
                    <div class="progress progress-striped active">
                      <div class="progress-bar" style="width: <?php echo $cpu5[1] ?>%"></div>
                    </div>
                    
                    <h6>Hardware unterbr. <span class="pull-right"><?php echo $cpu6[1] ?>%</span></h6>
                    <div class="progress progress-striped active">
                      <div class="progress-bar" style="width: <?php echo $cpu6[1] ?>%"></div>
                    </div>
                    
                   <h6>Software unterbr. <span class="pull-right"><?php echo $cpu7[1] ?>%</span></h6>
                    <div class="progress progress-striped active">
                      <div class="progress-bar" style="width: <?php echo $cpu7[1] ?>%"></div>
                    </div>
                    
                    <hr />
                    
                    <h5>RAM:</h5>
                    
                    <h6>Auslastung <span class="pull-right"><?php echo $percent ?>%</span></h6>
                    <div class="progress progress-striped active">
                      <div class="progress-bar" style="width: <?php echo $percent ?>%"></div>
                    </div>
                    
                    

                  </div>
                  <div class="tab-pane" id="prozesse">
                  
                  <b style="font-size: 14px;">Aktuell laufende Prozesse:</b><br />
				<br />
				<form method="get" action="">
					<input type="checkbox" value="1" id="hideroot" name="hideroot" checked="checked" /><label for="hideroot">Verstecke root-Prozesse</label>
				</form>
				<table cellspacing="0" id="myTable" class="tablesorter">
				<thead>
					<tr>
						<th>PID</th>
						<th>Benutzer</th>
						<th>Eltern PID</th>
						<th>NI</th>
						<th>VIRT</th>
						<th>RES</th>
						<th>SHR</th>
						<th>S</th>
						<th>CPU</th>						
						<th>RAM</th>
						<th>Laufzeit</th>
						<th>Task</th>
					</tr>
				</thead> 
				<?php
				$size = count($returnvalue);
				$processcount = 0;
				for($i = 7; $i<$size; $i++)
				{
					$data = array();
					$returnvalue[$i] = ' ' . $returnvalue[$i];
					$text = preg_replace('/\040{1,}/',' ',$returnvalue[$i]); 
					$exp = explode(' ', $text, 13);
					if($exp['2'] == 'root')
					{
				?>
					<tr class="root">
				<?php		
					}
					else
					{
				?>
					<tr>
				<?php
					}
					for($j = 1; $j<count($exp); $j++)
					{
						$processcount++;
						if($exp[$j] != '')
						{
				?>							
						<td><?php echo $exp[$j]; ?></td>
				<?php							
						}
					}
				?>
					</tr>	
				<?php
				}
				?>
				</table>
				<br />
				Aktuell laufen <?php echo $processcount ?> Prozesse.
                  
                  </div>
                  <div class="tab-pane" id="hdd">
                  
                  <?php
                //HDD
                $returnvalue = null;
                exec('TERM=xterm df 2>&1', $returnvalue);
                ?>
        
                <?php
                for($i = 1; $i < count($returnvalue); $i++)
                {
                	$data = array();
                	$text = preg_replace('/\040{1,}/',' ',$returnvalue[$i]); 
                	$exp = explode(' ', $text, 13);
                	$gib = round($exp[3] / 1024 / 1024, 2);
                ?>
                <h6><?php echo $exp[5]; ?> <span class="pull-right"><?php echo $gib ?> GB frei</span></h6>
                    <div class="progress progress-striped active">
                      <div class="progress-bar" style="width: <?php echo $exp[4]; ?>%"></div>
                    </div>
              
                
   
                <?php
                }
                ?>
                  
                  </div>
                  <div class="tab-pane" id="tools">
                  
                  <h5>Tools:</h5>
                  
                    <!-- Modal -->
                    <a class="btn btn-danger btn-sm" href="#reboot" data-toggle="modal"><i class="glyphicon glyphicon-eye-open"></i> Neustarten</a>
                    <!-- Modal -->
                    <div class="modal fade" id="reboot" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header modal-header-danger">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h4><i class="glyphicon glyphicon-thumbs-up"></i> Soll der Pi wirklich neugestartet werden?</h4>
                                </div>
                                <div class="modal-body">
                                Es können Daten verloren gehen!
                                </div>
                                <div class="modal-footer">
                                <a href="restartpie.php" class="btn btn-default pull-left">Jetzt neustarten</a>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                    <!-- Modal -->
                  </div>             
                </div>
            </div> 
        </div>
        <br />  
    <footer>
    <a href="https://github.com/RevUnix/raspPiControl" target="_blank">raspPiControl</a> by <a href="https://twitter.com/RevUnix/" target="_blank">@Revunix</a> - &copy; 2014
    </footer>
    <br />  
    </div>
</div>
            
                
</body>
</html>
