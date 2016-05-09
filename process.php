<?php
	$theColumns = array("LabRoom103","LabRoom105","LabRoom218","LabRoom219","LabRoom248","276LibaryResources",
							"TV12ndFloorDVD","TV31stFloorDVD/VCR","TV41stFloorDVD/VCR","SMARTBd.1stFlr","SMARTBd.2nd Flr","Courtyard","TeacherRoomChange");
	$theColumns2 = array("Lab Room 103","Lab Room 105","Lab Room 218","Lab Room 219","Lab Room 248","276 Libary Resources",
							"TV1 2nd Floor DVD","TV3 1st Floor DVD/VCR","TV4 1st Floor DVD/VCR","SMART Bd.1st Flr","SMART Bd.2nd Flr","Courtyard","Teacher Room Change");
	$theName = $_POST['iBox'];
	$theRow = $_POST['row'];
	$theCell = $_POST['cell'];
	$theDate = $_POST['tDate'];
	$old = $_POST['old'];
	
	if($_POST['iSubmit'] == "Submit" && isset($theName) && isset($theRow) && isset($theCell) && isset($theDate))
	{
		$mySQLConn = mysql_connect("<<SQL host>>","<<SQL user>>","<<SQL password>>");
		if(!$mySQLConn)
		{
			die("MYSQL Connect Error! Please try again later!");
		}
		else
		{
			mysql_select_db("<<SQL database>>");
			if(mysql_num_rows( mysql_query("SHOW TABLES LIKE '".$theDate."'")))
			{
				$changeQuery = 'UPDATE `'.$theDate.'` SET `'.$theColumns[$theRow-1].'` = \''.$theName.'\' WHERE `Period`='.$theCell;
				$result = mysql_query($changeQuery);
				if($result)
				{
					$logAction = $old == "" ? "added" : "removed";
					$logName = $theName; 
					if($logAction == "removed") {
						$logName = $old;
					}
					$reservationFor = $theDate.', Period '.$theCell.', '.$theColumns2[$theRow-1];
					$logDate = date("M.d/Y");
					$logQuery = 'INSERT INTO `Logs` (`Name`, `Action`, `Type`, `RDateRoom`, `Date`) VALUES (\''.$logName.'\', \''.$logAction.'\', \'reservation for\', \''.$reservationFor.'\', \''.$logDate.'\');';
					mysql_query($logQuery);
					echo('Successfully entered reservation for "'.$theName.'"!');
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
										`Courtyard` TEXT NOT NULL,
										`TeacherRoomChange` TEXT NOT NULL
										) ENGINE = INNODB';
				$insertIntoQuery = $sql = 'INSERT INTO `'.$theDate.'` (`Period`, `LabRoom103`, `LabRoom105`, `LabRoom218`, `LabRoom219`, `LabRoom248`, `276LibaryResources`, `TV12ndFloorDVD`, `TV22ndFloorVHS`, `TV31stFloorDVD/VCR`, `TV41stFloorDVD/VCR`, `SMARTBd.1stFlr`, `SMARTBd.2nd Flr`, `Courtyard`, `TeacherRoomChange`) VALUES (\'1\', \'\', \'\',  \'\', \'\', \'\', \'\', \'\', \'\', \'\', \'\', \'\', \'\', \'\', \'\'), (\'2\', \'\',\'\', \'\', \'\', \'\', \'\', \'\', \'\', \'\', \'\', \'\', \'\', \'\', \'\'), (\'3\', \'\',  \'\', \'\', \'\', \'\', \'\', \'\', \'\', \'\', \'\', \'\', \'\', \'\', \'\'), (\'4\', \'\', \'\', \'\', \'\', \'\', \'\', \'\', \'\', \'\', \'\', \'\', \'\', \'\', \'\');';
				mysql_query($createTableQuery);
				$theResult = mysql_query($insertIntoQuery);
				if($theResult)
				{
					$changeQuery = 'UPDATE `'.$theDate.'` SET `'.$theColumns[$theRow-1].'` = \''.$theName.'\' WHERE `Period`='.$theCell;
					$result = mysql_query($changeQuery);
					if($result)
					{
						$logName = $theName; 
						$reservationFor = $theDate.', Period '.$theCell.', '.$theColumns2[$theRow-1];
						$logDate = date("M.d/Y");
						$logQuery = 'INSERT INTO `Logs` (`Name`, `Action`, `Type`, `RDateRoom`, `Date`) VALUES (\''.$logName.'\', \'added\', \'reservation for\', \''.$reservationFor.'\', \''.$logDate.'\');';
						mysql_query($logQuery);
						echo('Successfully entered reservation for "'.$theName.'"!');
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