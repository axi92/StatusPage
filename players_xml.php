<?php

error_reporting(-1);
require __DIR__ . '/SourceQuery/SourceQuery.class.php';
require __DIR__ . '/config.php';
$Query = new SourceQuery( );

try
{
	$Query->Connect( SQ_SERVER_ADDR, SQ_SERVER_PORT, SQ_TIMEOUT, SQ_ENGINE );
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
$Query->Disconnect();





// initializing or creating array
//$playerlist = array(your array data);

// creating object of SimpleXMLElement
$xml_playerlist = new SimpleXMLElement("<?xml version=\"1.0\"?><playerlist></playerlist>");

$playerlist = array( array( Title => "rose", 
                      Price => 1.25,
                      Number => 15 
                    ),
               array( Title => "daisy", 
                      Price => 0.75,
                      Number => 25,
                    ),
               array( Title => "orchid", 
                      Price => 1.15,
                      Number => 7 
                    )
             ); 

// function call to convert array to xml
array_to_xml($playerlist,$xml_playerlist);

//saving generated xml file
$xml_playerlist->asXML('output.xml');


// function defination to convert array to xml
function array_to_xml($playerlist, &$xml_playerlist) {
	foreach($playerlist as $key => $value) {
		if(is_array($value)) {
			if(!is_numeric($key)){
				$subnode = $xml_playerlist->addChild("$key");
				array_to_xml($value, $subnode);
			}
			else{
				$subnode = $xml_playerlist->addChild("item$key");
				array_to_xml($value, $subnode);
			}
		}
		else {
			$xml_playerlist->addChild("$key",htmlspecialchars("$value"));
		}
	}
}

?>