<?php
	$theColumns = array("LabRoom103","LabRoom105","LabRoom218","LabRoom219","LabRoom223","LabRoom248","276LibaryResources",
							"TV12ndFloorDVD","TV22ndFloorVHS","TV31stFloorDVD/VCR","TV41stFloorDVD/VCR","SMARTBd.1stFlr","SMARTBd.2nd Flr","TeacherRoomChange");
	$theName = $_POST['name'];
	$theCell = $_POST['cell'];
	$theAction = $_POST['tAction'];
	$theDate = $_POST['tDate'];
	if(isset($theName) && isset($theCell) && isset($theAction) && isset($theDate))
	{
		$mySQLConn = mysql_connect("reservations1234.db.8284687.hostedresource.com","reservations1234","Pjcvs123!");
		if(!$mySQLConn)
		{
			die("MYSQL Connect Error! Please try again later!");
		}
		else
		{
			mysql_select_db("reservations1234");
			if(mysql_num_rows( mysql_query("SHOW TABLES LIKE '".$theDate."'")))
			{
				if($theAction == "added") $changeQuery = 'UPDATE `'.$theDate.'` SET TeacherRoomChange = CONCAT(TeacherRoomChange,\''.$theName.'\') WHERE `Period`='.$theCell;
				else $changeQuery = 'UPDATE `'.$theDate.'` SET TeacherRoomChange = REPLACE(TeacherRoomChange,\''.$theName.'\',"") WHERE `Period`='.$theCell;
				$result = mysql_query($changeQuery);
				if($result)
				{
					$result = mysql_query('SELECT TeacherRoomChange FROM '.$theDate.' WHERE Period='.$theCell);
					$data = mysql_fetch_row($result);
					echo('Successfully '.$theAction.' reservation for "'.str_replace(",","",$theName).'"!'.'#'.str_replace(",","<br>",preg_replace("/,/","",$data[0],1)));
				}
				else
				{
					echo("Reservation was not entered successfully! Try again later!");
				}
			}
			else
			{
				$createTableQuery = 'CREATE TABLE `'.$theDate.'` (
										`Period` TINYINT NOT NULL,
										`LabRoom103` TEXT NOT NULL ,
										`LabRoom105` TEXT NOT NULL ,
										`LabRoom218` TEXT NOT NULL ,
										`LabRoom219` TEXT NOT NULL ,
										`LabRoom248` TEXT NOT NULL ,
										`276LibaryResources` TEXT NOT NULL ,
										`TV12ndFloorDVD` TEXT NOT NULL ,
										`TV22ndFloorVHS` TEXT NOT NULL ,
										`TV31stFloorDVD/VCR` TEXT NOT NULL ,
										`TV41stFloorDVD/VCR` TEXT NOT NULL ,
										`SMARTBd.1stFlr` TEXT NOT NULL ,
										`SMARTBd.2nd Flr` TEXT NOT NULL,
										`TeacherRoomChange` TEXT NOT NULL
										) ENGINE = INNODB';
				$insertIntoQuery = $sql = 'INSERT INTO `'.$theDate.'` (`Period`, `LabRoom103`, `LabRoom105`, `LabRoom218`, `LabRoom219`, `LabRoom248`, `276LibaryResources`, `TV12ndFloorDVD`, `TV22ndFloorVHS`, `TV31stFloorDVD/VCR`, `TV41stFloorDVD/VCR`, `SMARTBd.1stFlr`, `SMARTBd.2nd Flr`, `TeacherRoomChange`) VALUES (\'1\', \'\',  \'\', \'\', \'\', \'\', \'\', \'\', \'\', \'\', \'\', \'\', \'\', \'\'), (\'2\', \'\',\'\', \'\', \'\', \'\', \'\', \'\', \'\', \'\', \'\', \'\', \'\', \'\'), (\'3\', \'\',  \'\', \'\', \'\', \'\', \'\', \'\', \'\', \'\', \'\', \'\', \'\', \'\'), (\'4\', \'\', \'\', \'\', \'\', \'\', \'\', \'\', \'\', \'\', \'\', \'\', \'\', \'\');';
				mysql_query($createTableQuery);
				$theResult = mysql_query($insertIntoQuery);
				if($theResult)
				{
					if($theAction == "Add") $changeQuery = 'UPDATE `'.$theDate.'` SET TeacherRoomChange = CONCAT(TeacherRoomChange,\''.$theName.'\') WHERE `Period`='.$theCell;
					else $changeQuery = 'UPDATE `'.$theDate.'` SET TeacherRoomChange = REMOVE(TeacherRoomChange,\''.$theName.'\') WHERE `Period`='.$theCell;
					$result = mysql_query($changeQuery);
					if($result)
					{
						$result = mysql_query('SELECT TeacherRoomChange FROM '.$theDate.' WHERE Period='.$theCell);
						$data = mysql_fetch_row($result);
						echo('Successfully '.$theAction.' reservation for "'.str_replace(",","",$theName).'"!'.'#'.str_replace(",","<br>",preg_replace("/,/","",$data[0],1)));
					}
					else
					{
						echo("Reservation was not entered successfully!");
					}
				}
				else
				{
					echo("Error making new table. Please try again!");
				}
			}
		}
	}
	else
	{
		echo("Error posting data");
	}
?>