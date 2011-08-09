<?php

/**************************************************************
"Learning with Texts" (LWT) is released into the Public Domain.
This applies worldwide.
In case this is not legally possible, any entity is granted the
right to use this work for any purpose, without any conditions, 
unless such conditions are required by law.
***************************************************************/

include "connect.inc.php";
include "settings.inc.php";
include "utilities.inc.php";

$x = $_REQUEST["x"];
$i = stripslashes($_REQUEST["i"]);
$t = stripslashes($_REQUEST["t"]);

// Case 1 (x=1) -> GTr translates sentence in textitem-order = i and textno = t
// Case 2 (x=2) -> translates with dict-url = i the query-term = t

if ( $x == 1 ) {
	$sql = 'select SeText, LgGoogleTranslateURI from languages, sentences, textitems where TiSeID = SeID and TiLgID = LgID and TiTxID = ' . $t . ' and TiOrder = ' . $i;
	$res = mysql_query($sql);		
	if ($res == FALSE) die("<p>Invalid query: $sql</p>");
	$num = mysql_num_rows($res);
	if ($num != 0 ) {
		$dsatz = mysql_fetch_assoc($res);
		$satz = $dsatz['SeText'];
		$trans = isset($dsatz['LgGoogleTranslateURI']) ? $dsatz['LgGoogleTranslateURI'] : "";
		if(substr($trans,0,1) == '*') $trans = substr($trans,1);
	} else {
		die("<p>Error: No results</p>"); 
	}
	mysql_free_result($res);
	if ($trans != '') {
		/*
		echo "{" . $i . "}<br />";
		echo "{" . $t . "}<br />";
		echo "{" . createTheDictLink($trans,$satz) . "}<br />";
		*/
		header("Location: " . createTheDictLink($trans,$satz));
	}	
	exit();
}	

if ( $x == 2 ) {
	/*
	echo "{" . $i . "}<br />";
	echo "{" . $t . "}<br />";
	echo "{" . createTheDictLink($i,$t) . "}<br />";
	*/
	header("Location: " . createTheDictLink($i,$t));
	exit();
}	

?>