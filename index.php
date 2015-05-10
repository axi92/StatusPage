<?php
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
		/*
		echo '<pre>';
		print_r( $Query->GetInfo( ) );
		print_r( $Query->GetPlayers( ) );
		echo '</pre>';
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
<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="//bootswatch.com/yeti/bootstrap.min.css" rel="stylesheet" type="text/css" />

<script src="//code.jquery.com/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
  
  
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
                                  <a href="#"  data-toggle="tooltip" data-placement="bottom" title="Gameserver">
                                    <i class="fa fa-question-circle"></i>
                                  </a>
                              </h4>
                              <p class="list-group-item-text">
                                  <span class="label label-<?php echo $arma3_label ?>"><?php echo $arma3_label_text; ?></span>
								  <span class="badge"><?php echo $players_online; ?> Players Online</span>
                              </p>
                          </div>
                        
                          <div class="list-group-item">
                              <h4 class="list-group-item-heading">
                                  Teamspeak 3 
                                  <a href="#"  data-toggle="tooltip" data-placement="bottom" title="Voice communication server">
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