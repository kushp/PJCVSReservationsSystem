<?php
	$entered = $_POST['code'];
	$name = $_POST['name'];
	$theRow = $_POST['row'];
	if($entered == "p8a51")
	{
		echo("true");
		return;
	}
	switch($theRow)
	{
		case 3:
			echo($entered == "p2e14" ? "true" : "false");
			return;
		case 6:
			echo($entered == "0418apr" ? "true" : "false");
			return;
	}
	if(isset($name))
	{
		if(strtolower($entered) == strtolower($name))
		{
			echo("true");
			return;
		}
	}
	echo("false");
?>