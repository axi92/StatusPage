<?php

error_reporting(-1);
require __DIR__ . '/SourceQuery/SourceQuery.class.php';
require __DIR__ . '/config.php';
require __DIR__ . '/array2xml.php';
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

$playerlist = array(array(array("rose", 1.25, 15),
                    array("daisy", 0.75, 25),
                    array("orchid", 1.15, 7) 
                   ),
              array(array("rose", 1.25, 15),
                    array("daisy", 0.75, 25),
                    array("orchid", 1.15, 7) 
                   ),
              array(array("rose", 1.25, 15),
                    array("daisy", 0.75, 25),
                    array("orchid", 1.15, 7) 
                   )
             ); 

// function call to convert array to xml
array_to_xml($playerlist,$xml_playerlist);

//saving generated xml file
$xml_playerlist->asXML('output.xml');

//$xml = Array2XML::createXML('root_node_name', $playerlist);
//echo $xml->saveXML();

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