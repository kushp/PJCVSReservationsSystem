<?php
	function stripDateSymbols($str) 
	{
		$toReturn = "";
		$toReturn = str_replace(".","",$str);
		$toReturn = str_replace("/","",$toReturn);
		return $toReturn;
	}
	$startDate = $_POST['startDate'];
	if(isset($startDate))
	{
		$startDate = strtotime($startDate);
		$mySQLConn = mysql_connect("<<SQL host>>","<<SQL user>>","<<SQL password>>");
		if(!$mySQLConn)
		{
			die("MYSQL Connect Error! Please try again later!");
		}
		else
		{
			mysql_select_db("<<SQL database>>");
			for($i = 0;$i<8;$i++)
			{
				$date = date("F.d/Y", $startDate + ($i * 24 * 60 * 60));
				if(mysql_num_rows( mysql_query("SHOW TABLES LIKE '".stripDateSymbols($date)."'")))
				{
					$query = 'SELECT * FROM `'.stripDateSymbols($date).'`';
					$result = mysql_query($query);
					if($result)
					{
						$p1 = mysql_fetch_row($result);
						$p2 = mysql_fetch_row($result);
						$p3 = mysql_fetch_row($result);
						$p4 = mysql_fetch_row($result);
						echo('<div class="container">
						  <div class="content">
						  <div class="header">'.$date.'</div>
						  <table cellpadding="0" cellspacing="0" class="form" border="1" bordercolor="#FFFFFF" name="'.stripDateSymbols($date).'">
							  <tbody>
								  <tr>
									  <td>Name</td>
									  <td>Period 1</td>
									  <td>Period 2</td>
									  <td>Period 3</td>
									  <td>Period 4</td>
								  </tr>
                              <tr>
                                  <td class="alt lTD">Lab Room 103 (23)</td>
                                  <td class="alt" onclick="showInput(this);">'.$p1[1].'</td>
                                  <td class="alt" onclick="showInput(this);">'.$p2[1].'</td>
                                  <td class="alt" onclick="showInput(this);">'.$p3[1].'</td>
                                  <td class="alt" onclick="showInput(this);">'.$p4[1].'</td>
                              </tr>
                              <tr>
                                  <td class="lTD">Lab Room 105 (22)</td>
                                  <td onclick="showInput(this);">'.$p1[2].'</td>
                                  <td onclick="showInput(this);">'.$p2[2].'</td>
                                  <td onclick="showInput(this);">'.$p3[2].'</td>
                                  <td onclick="showInput(this);">'.$p4[2].'</td>
                              </tr>
                              <tr>
                                  <td class="alt lTD">Lab Room 218 (19)</td>
                                  <td class="alt" onclick="showInput(this);">'.$p1[3].'</td>
                                  <td class="alt" onclick="showInput(this);">'.$p2[3].'</td>
                                  <td class="alt" onclick="showInput(this);">'.$p3[3].'</td>
                                  <td class="alt" onclick="showInput(this);">'.$p4[3].'</td>
                              </tr>
                              <tr>
                                  <td class="lTD">Lab Room 219 (26)</td>
                                  <td onclick="showInput(this);">'.$p1[4].'</td>
                                  <td onclick="showInput(this);">'.$p2[4].'</td>
                                  <td onclick="showInput(this);">'.$p3[4].'</td>
                                  <td onclick="showInput(this);">'.$p4[4].'</td>
                              </tr>
                              <tr>
                                  <td class="alt lTD">Room 248</td>
                                  <td class="alt" onclick="showInput(this);">'.$p1[5].'</td>
                                  <td class="alt" onclick="showInput(this);">'.$p2[5].'</td>
                                  <td class="alt" onclick="showInput(this);">'.$p3[5].'</td>
                                  <td class="alt" onclick="showInput(this);">'.$p4[5].'</td>
                              </tr>
                              <tr>
                                  <td class="lTD">Library Resources</td>
                                  <td onclick="showInput(this);">'.str_replace(",","<br>",$p1[6]).'</td>
                                  <td onclick="showInput(this);">'.str_replace(",","<br>",$p2[6]).'</td>
                                  <td onclick="showInput(this);">'.str_replace(",","<br>",$p3[6]).'</td>
                                  <td onclick="showInput(this);">'.str_replace(",","<br>",$p4[6]).'</td>
                              </tr>
                              <tr>
                                  <td class="alt lTD">TV1 2nd Floor DVD</td>
                                  <td class="alt" onclick="showInput(this);">'.$p1[7].'</td>
                                  <td class="alt" onclick="showInput(this);">'.$p2[7].'</td>
                                  <td class="alt" onclick="showInput(this);">'.$p3[7].'</td>
                                  <td class="alt" onclick="showInput(this);">'.$p4[7].'</td>
                              </tr>
                              <tr>
                                  <td class="lTD">TV3 1st Floor DVD/VCR</td>
                                  <td onclick="showInput(this);">'.$p1[9].'</td>
                                  <td onclick="showInput(this);">'.$p2[9].'</td>
                                  <td onclick="showInput(this);">'.$p3[9].'</td>
                                  <td onclick="showInput(this);">'.$p4[9].'</td>
                              </tr>
                              <tr>
                                  <td class="alt lTD">TV4 1st Floor DVD/VCR</td>
                                  <td class="alt" onclick="showInput(this);">'.$p1[10].'</td>
                                  <td class="alt" onclick="showInput(this);">'.$p2[10].'</td>
                                  <td class="alt" onclick="showInput(this);">'.$p3[10].'</td>
                                  <td class="alt" onclick="showInput(this);">'.$p4[10].'</td>
                              </tr>
                              <tr>
                                  <td class="lTD">SMART Bd. 1st Flr</td>
                                  <td onclick="showInput(this);">'.$p1[11].'</td>
                                  <td onclick="showInput(this);">'.$p2[11].'</td>
                                  <td onclick="showInput(this);">'.$p3[11].'</td>
                                  <td onclick="showInput(this);">'.$p4[11].'</td>
                              </tr>
                              <tr>
                                  <td class="alt lTD">SMART Bd. 2nd Flr</td>
                                  <td class="alt" onclick="showInput(this);">'.$p1[12].'</td>
                                  <td class="alt" onclick="showInput(this);">'.$p2[12].'</td>
                                  <td class="alt" onclick="showInput(this);">'.$p3[12].'</td>
                                  <td class="alt" onclick="showInput(this);">'.$p4[12].'</td>
                              </tr>
							  <tr>
							  	  <td class="lTD">Courtyard</td>
								  <td onclick="showInput(this);">'.$p1[13].'</td>
                                  <td onclick="showInput(this);">'.$p2[13].'</td>
                                  <td onclick="showInput(this);">'.$p3[13].'</td>
                                  <td onclick="showInput(this);">'.$p4[13].'</td>
							  </tr>
							  <tr>
                                  <td class="alt lTD">Room Change</td>
                                  <td class="alt" onclick="showInput(this);">'.str_replace(",","<br>",preg_replace("/,/","",$p1[14],1)).'</td>
                                  <td class="alt" onclick="showInput(this);">'.str_replace(",","<br>",preg_replace("/,/","",$p2[14],1)).'</td>
                                  <td class="alt" onclick="showInput(this);">'.str_replace(",","<br>",preg_replace("/,/","",$p3[14],1)).'</td>
                                  <td class="alt" onclick="showInput(this);">'.str_replace(",","<br>",preg_replace("/,/","",$p4[14],1)).'</td>
                              </tr>
							  </tbody>
						  </table>
						  </div>
						  <br />
						  </div>
						  ');
					}
					else 
					{
						echo("");
					}
				}
				else
				{
					echo('<div class="container">
						  <div class="content">
						  <div class="header">'.$date.'</div>
						  <table cellpadding="0" cellspacing="0" class="form" border="1" bordercolor="#FFFFFF" name="'.stripDateSymbols($date).'">
							  <tbody>
								  <tr>
									  <td>Name</td>
									  <td>Period 1</td>
									  <td>Period 2</td>
									  <td>Period 3</td>
									  <td>Period 4</td>
								  </tr>
								  <tr>
									  <td class="alt lTD">Lab Room 103 (23)</td>
									  <td class="alt" onclick="showInput(this);"></td>
									  <td class="alt" onclick="showInput(this);"></td>
									  <td class="alt" onclick="showInput(this);"></td>
									  <td class="alt" onclick="showInput(this);"></td>
								  </tr>
								  <tr>
									  <td class="lTD">Lab Room 105 (22)</td>
									  <td onclick="showInput(this);"></td>
									  <td onclick="showInput(this);"></td>
									  <td onclick="showInput(this);"></td>
									  <td onclick="showInput(this);"></td>
								  </tr>
								  <tr>
									  <td class="alt lTD">Lab Room 218 (19)</td>
									  <td class="alt" onclick="showInput(this);"></td>
									  <td class="alt" onclick="showInput(this);"></td>
									  <td class="alt" onclick="showInput(this);"></td>
									  <td class="alt" onclick="showInput(this);"></td>
								  </tr>
								  <tr>
									  <td class="lTD">Lab Room 219 (26)</td>
									  <td onclick="showInput(this);"></td>
									  <td onclick="showInput(this);"></td>
									  <td onclick="showInput(this);"></td>									  
									  <td onclick="showInput(this);"></td>
								  </tr>
								  <tr>
									  <td class="alt lTD">Room 248</td>
									  <td class="alt" onclick="showInput(this);"></td>
									  <td class="alt" onclick="showInput(this);"></td>
									  <td class="alt" onclick="showInput(this);"></td>
									  <td class="alt" onclick="showInput(this);"></td>
								  </tr>
								  <tr>
									  <td class="lTD">Library Resources</td>
									  <td onclick="showInput(this);"></td>
									  <td onclick="showInput(this);"></td>
									  <td onclick="showInput(this);"></td>
									  <td onclick="showInput(this);"></td>
								  </tr>
								  <tr>
									  <td class="alt lTD">TV1 2nd Floor DVD</td>
									  <td class="alt" onclick="showInput(this);"></td>
									  <td class="alt" onclick="showInput(this);"></td>
									  <td class="alt" onclick="showInput(this);"></td>
									  <td class="alt" onclick="showInput(this);"></td>
								  </tr>
								  <tr>
									  <td class="lTD">TV3 1st Floor DVD/VCR</td>
									  <td onclick="showInput(this);"></td>
									  <td onclick="showInput(this);"></td>
									  <td onclick="showInput(this);"></td>
									  <td onclick="showInput(this);"></td>
								  </tr>
								  <tr>
									  <td class="alt lTD">TV4 1st Floor DVD/VCR</td>
									  <td class="alt" onclick="showInput(this);"></td>
									  <td class="alt" onclick="showInput(this);"></td>
									  <td class="alt" onclick="showInput(this);"></td>
									  <td class="alt" onclick="showInput(this);"></td>
								  </tr>
								  <tr>
									  <td class="lTD">SMART Bd. 1st Flr</td>
									  <td onclick="showInput(this);"></td>
									  <td onclick="showInput(this);"></td>
									  <td onclick="showInput(this);"></td>
									  <td onclick="showInput(this);"></td>
								  </tr>
								  <tr>
									  <td class="alt lTD">SMART Bd. 2nd Flr</td>
									  <td class="alt" onclick="showInput(this);"></td>
									  <td class="alt" onclick="showInput(this);"></td>
									  <td class="alt" onclick="showInput(this);"></td>
									  <td class="alt" onclick="showInput(this);"></td>
								  </tr>
								  <tr>
									  <td class="lTD">Courtyard</td>
									  <td onclick="showInput(this);"></td>
									  <td onclick="showInput(this);"></td>
									  <td onclick="showInput(this);"></td>
									  <td onclick="showInput(this);"></td>
								  </tr>
								  <tr>
									  <td class="alt lTD">Room Change</td>
									  <td class="alt" onclick="showInput(this);"></td>
									  <td class="alt" onclick="showInput(this);"></td>
									  <td class="alt" onclick="showInput(this);"></td>
									  <td class="alt" onclick="showInput(this);"></td>
								  </tr>
							  </tbody>
						  </table>
						  </div>
						  <br />
						  </div>
						  ');
				}
			}
		}
	}
	else
	{
		echo("");
	}
?>