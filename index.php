<!doctype html>
<html>
<head>
	<title>Status Page</title>
	<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
	<meta content="utf-8" http-equiv="encoding">
	<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	<link href="//bootswatch.com/yeti/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="filter_table.css" rel="stylesheet" type="text/css" />

	<script src="//code.jquery.com/jquery.min.js"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<script src="filter_table.js"></script>
	 <script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-25646959-3', 'auto');
	  ga('send', 'pageview');

	</script>
	</head>
<body>
<?php
	error_reporting(-1);
	require __DIR__ . '/SourceQuery/SourceQuery.class.php';
	define( 'SQ_SERVER_ADDR', '37.187.170.178' ); //zero one
	define( 'SQ_SERVER_PORT', 2303 );
	define( 'SQ_TIMEOUT',     1 );
	define( 'SQ_ENGINE',      SourceQuery :: SOURCE );	
	$Query = new SourceQuery( );
	
	try
	{
		$Query->Connect( SQ_SERVER_ADDR, SQ_SERVER_PORT, SQ_TIMEOUT, SQ_ENGINE );
		$players_online = $Query->GetInfo()['Players'];
		$arma_online = true;
		$playerlist = $Query->GetPlayers();

		/*
		echo '<pre>';
		//print_r( $Query->GetInfo( ) );
		echo print_r($playerlist['0']['Name']);
		echo '</pre>';
		echo $playerlist;
		*/
	}
	catch( Exception $e )
	{
		echo $e->getMessage( );
	}

	//TEAMSPEAK 3 CHECK
	$ts_ip = "ts.zero-one.cc";
	$ts_port = "10011";
	$online0 = @fsockopen($ts_ip, $ts_port, $errno, $errstr, 1);





	if($arma_online == true && $online0 >= 1):
		$systemstatus = 'All Systems Operational';
		$statuscolor = 'success';
	else:
		$systemstatus = 'Not All Systems Operational';
		$statuscolor = 'warning';
	endif;
	//ARMA 3 Label
	if($arma_online == true):
		$arma3_label = 'success';
		$arma3_label_text = 'Operational';
	else:
		$arma3_label = 'danger';
		$arma3_label_text = 'Not Operational';
	endif;	
	//TS3 Label
	if($online0 >= 1):
		$ts3_label = 'success';
		$ts3_label_text = 'Operational';
	else: 
		$ts3_label = 'danger';
		$ts3_label_text = 'Not Operational';
	endif;
?>
  
  <!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Players Online</h4>
			</div>
			<div class="modal-body">

			
				<div class="row">
					<div class="panel panel-primary filterable">
						<div class="panel-heading">
							<h3 class="panel-title">Users</h3>
							<div class="pull-right">
								<button class="btn btn-default btn-xs btn-filter"><span class="fa fa-search"></span> Filter</button>
							</div>
						</div>
						<table class="table">
							<thead>
								<tr class="filters">
									<th><input type="text" class="form-control" placeholder="#" disabled></th>
									<th><input type="text" class="form-control" placeholder="Name" disabled></th>
									<th><input type="text" class="form-control" placeholder="Playtime" disabled></th>
									<!-- <th><input type="text" class="form-control" placeholder="Username" disabled></th> -->
								</tr>
							</thead>
							<tbody>
								<?php
								/*
								*/
								foreach($playerlist as $key => $value) 
								{
									echo '<tr>';
										echo '<td>'. $key . '</td>';
										echo '<td>'. $value['Name'] . '</td>';
										echo '<td>'. $value['TimeF'] . '</td>';
									echo '</tr>';
								}
								?>
							</tbody>
						</table>
					</div>
				</div>			
			
			
			
			
			
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				<!-- <button type="button" class="btn btn-primary">Save changes</button> -->
			</div>
		</div>
	</div>
</div>  
  
  
  
  
  <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h1>Status Page <a href="http://zero-one.cc" target=_blank>ZeroOne.cc</a></h1>
        </div>
      </div>
      <div class="row clearfix">
          <div class="col-md-12 column">
              <div class="panel panel-<?php echo $statuscolor ?>">
                <div class="panel-heading">
                  <h3 class="panel-title">
                    <?php echo $systemstatus ?>
                    <!-- <small class="pull-right">Refreshed 39 minutes ago</small> -->
                  </h3>
                </div>                
              </div>
            

              <div class="row clearfix">
                  <div class="col-md-12 column">
                      <div class="list-group">
                        
                          <div class="list-group-item">
                              <h4 class="list-group-item-heading">
                                  Arma3 Server
                                  <a class="mouse_pointer" data-toggle="tooltip" data-placement="right" title="Gameserver">
                                    <i class="fa fa-question-circle"></i>
                                  </a>
                              </h4>
                              <p class="list-group-item-text">
                                  <span class="label label-<?php echo $arma3_label ?>"><?php echo $arma3_label_text; ?></span>
								  <span class="badge" data-toggle="modal" data-target="#myModal"><?php echo $players_online; ?> Players Online</span>
                              </p>
                          </div>
                        
                          <div class="list-group-item">
                              <h4 class="list-group-item-heading">
                                  Teamspeak 3 
                                  <a class="mouse_pointer" data-toggle="tooltip" data-placement="right" title="Voice communication server">
                                    <i class="fa fa-question-circle"></i>
                                  </a>
                              </h4>
                              <p class="list-group-item-text">
                                  <span class="label label-<?php echo $ts3_label ?>"><?php echo $ts3_label_text; ?></span>
                              </p>
                          </div>
                        <!--
                          <div class="list-group-item">
                              <h4 class="list-group-item-heading">
                                  Database Server 
                                  <a href="#"  data-toggle="tooltip" data-placement="bottom" title="Access database server and execute queries">
                                    <i class="fa fa-question-circle"></i>
                                  </a>
                              </h4>
                              <p class="list-group-item-text">
                                  <span class="label label-success">Operational</span>
                              </p>
                          </div>
                         --> 
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</body>
</html>