<?php
	$oldDate = date("FdY",time() - (24 * 60 * 60));
		$mySQLConn = mysql_connect("reservations1234.db.8284687.hostedresource.com","reservations1234","Pjcvs123!");
	if(!$mySQLConn)
	{
		die("MYSQL Connect Error! Please try again later!");
	}
	else
	{
		mysql_select_db("reservations1234");
		$query = 'DROP TABLE '.$oldDate;
		$result = mysql_query($query);
		if($result) echo("Successfully dropped yesterday's table!");
		else die(mysql_error());
	}
?>