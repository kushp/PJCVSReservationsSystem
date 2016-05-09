<?php
	$mySQLConn = mysql_connect("<<SQL Host>>","<<SQL user>>","<<SQL password>>");
	if(!$mySQLConn)
	{
		die("MYSQL Connect Error! Please try again later!");
	}
	else
	{
		$toEcho = "";
		$red = "<font color='#b22222'>";
		$green = "<font color='#228b22'>";
		mysql_select_db("<<SQL database>>");
		$query = "SELECT * FROM Logs ORDER BY TimeStamp DESC LIMIT 500";
		$result = mysql_query($query);
		if($result) {
			$rowCount = mysql_num_rows($result);
			for($i = 0;$i<$rowCount;$i++) {
				$row = mysql_fetch_row($result);
				$colour = $row[1] == "added" ? $green : $red;
				$toEcho = $toEcho.$row[0]." ".$colour.$row[1]."</font> ".$row[2]." ".$row[3]." on ".$row[4]."<br>";
			}
			echo($toEcho);
		} else {
			die("ERROR");
		}
	}
?>