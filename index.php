<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow"> 
<title>PJ Reservation System Revision 8!</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="css/custom-theme/jquery-ui-1.8.21.custom.css" rel="stylesheet" />	
<script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.21.custom.min.js"></script>
<script type="text/javascript" src="js/jquery.form.js"></script>
<script>
	function xmlhttpPost(strURL,theQuery,response) {
		var xmlHttpReq = false;
		var self = this;
		// Mozilla/Safari
		if (window.XMLHttpRequest) {
			self.xmlHttpReq = new XMLHttpRequest();
		} else if (window.ActiveXObject) {
			self.xmlHttpReq = new ActiveXObject("Microsoft.XMLHTTP");
		}
		self.xmlHttpReq.open('POST', strURL, true);
		self.xmlHttpReq.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		self.xmlHttpReq.onreadystatechange = function() {
			if (self.xmlHttpReq.readyState == 4) {
				response(self.xmlHttpReq.responseText);
			}
		}
		self.xmlHttpReq.send(theQuery);
	}
	
	function sendKeyCodeReq(str) {
    	xmlhttpPost("keyTest.php",str,keyCodeResponse);
	}
	
	function keyCodeResponse(result) {
		if(result == "true") {
			backupInnerHTML = ppTD.innerHTML;
			ppTD.innerHTML = '<input type="text" name="iBox" id="iBox" class="iBox" value="'+ppTD.innerHTML.replace(/<br>/g,",")+'"/><br/><input type="submit" name="iSubmit" id="iSubmit" class="iSubmit" value="Submit"/>'
				+'<input type="hidden" name="row" value='+""+ppTD.parentNode.rowIndex +""+'>'
				+'<input type="hidden" name="cell" value='+""+ppTD.cellIndex+""+'>'
				+'<input type="hidden" name="tDate" value='+""+ppTD.parentNode.parentNode.parentNode.getAttribute("name")+""+'>'
				+'<input type="hidden" name="old" value="'+backupInnerHTML+'">';
			$("input:submit").button();
			mkAjaxForm();
			document.getElementById("iBox").focus();
			lastElement = ppTD;
		} else if(result == "false") {
			displayDialog("A keycode is required to make entry into this cell. Email your request for Library to Mrs. Tice, for Lab 218 to Mr. John Macdonald, and for Lab 223 to Ms. Harris.");
		}
	}
	
	function datePickSend(queryStr) {
		xmlhttpPost("customDate.php",queryStr,datePickResponse);
	}
	
	function datePickResponse(theCode) {
		if(theCode != "" || theCode != null) {
			document.getElementById("theForm").innerHTML = theCode;
			lastElement = null;
		} else {
			displayDialog("Date picker failed! Please try again later!");
		}
	}
	
	var lastElement = null;
	var ppTD = null;
    var submittedElement = null;
	var backupInnerHTML = "";
	
	function mkAjaxForm() {
		var options = {
			beforeSubmit: showRequest,
			success: showResponse
		};
		$('#theForm').ajaxForm(options); 
	}
	
	$(document).ready(function(){
		$("input:submit").button();	
		$( "#diag" ).dialog({
				autoOpen: false,
				width: 500,
				buttons: {
					"Ok": function() { 
						$(this).dialog("close"); 
					}
			},
			modal: true
		});
		$("#tRoomChangeDiag").dialog({
			autoOpen: false,
			width:500,
			buttons: {
				"Submit": function() {
					$(this).dialog("close");
					var name = document.getElementById("txtTName").value;
					name = $.trim(name);
					var room = document.getElementById("txtTRoom").value;
					room = $.trim(room);
					if(name == "" || room == "") {
						displayDialog("The form was incomplete, please try again!");
					} else {
						submittedElement = lastElement;
						var theAction = document.getElementsByName("tOption").item(0).checked ? "added" : "removed";
						var qStr = "cell="+submittedElement.cellIndex+"&name=,"+name+" - "+room+"&tAction="+theAction+"&tDate="+submittedElement.parentNode.parentNode.parentNode.getAttribute("name");
						sendTRoomChangeRequest(qStr);
						document.getElementById("txtTName").value = "";
						document.getElementById("txtTRoom").value = "";
						document.getElementsByName("tOption").item(0).checked = true;
						document.getElementsByName("tOption").item(1).checked = false;
					}
				}
			},
			modal: true
		});
		$(".datePicker").datepicker({
			onSelect: function(dateText, inst) {
				datePickSend("startDate="+dateText);
			},
			dateFormat: 'mm/d/yy'
		});
		$("#keyCodeDiag").dialog({
			autoOpen: false,
			width:500,
			buttons: {
				"Ok": function() {
					$(this).dialog("close");
					var response = document.getElementById("txtKeyCode").value;
					document.getElementById("txtKeyCode").value = "";
					if(document.getElementById("keyContent").innerHTML.match("If you are") != null) sendKeyCodeReq("code="+response+"&row="+ppTD.parentNode.rowIndex+"&name="+ppTD.innerHTML);
					else sendKeyCodeReq("code="+response+"&row="+ppTD.parentNode.rowIndex);
				}
			},
			modal: true
		});
	});
	
	function fullTrim(s) {
		var toReturn = null;
		toReturn = $.trim(s);
		toReturn = toReturn.replace(/^ +| +$|( )+/g, "$1");
		return toReturn;
	}
	
	function locked() {
		displayDialog("Sorry, this cell is locked because there is a class in this room this period.");
	}
	
	function locked2() {
		displayDialog("Sorry, this cell is locked because this classroom is closed at the moment.");
	}

	function locked3() {
		displayDialog("Sorry, this cell is locked at the moment, contact admin to find out why.");
	}
	
	function locked4(tdEle) {
		displayDialog("Please contact " + tdEle.innerHTML + " for possible availability.");
	}
	
	function displayDialog(text) {
		document.getElementById("diag").innerHTML = text;
		$( "#diag" ).dialog("open");
	}
	
		// pre-submit callback 
	function showRequest(formData, jqForm, options) { 
   		var queryString = $.param(formData);
		submittedElement = lastElement;
		return true; 
	} 
	 
	// post-submit callback 
	function showResponse(responseText, statusText, xhr, $form)  { 
		displayDialog(responseText);
		if(responseText.match("Success") != null) {
			var r = responseText.split('"',2)[1].replace(/,/g,"<br>");
			submittedElement.innerHTML = r;
			backupInnerHTML = "";
		}
	} 
	
	function showInput(tdEle) {
		if(tdEle.innerHTML.match("input") != null && tdEle.innerHTML.match("class") || tdEle.innerHTML.match("INPUT") != null && tdEle.innerHTML.match("class")) return;
		if(lastElement != null && lastElement.parentNode.rowIndex != 13) {
			lastElement.innerHTML = lastElement.innerHTML.replace(/<br>/g,",");
			var backup = lastElement.innerHTML.split("<")[0];
			lastElement.innerHTML = "";
			backup = backup.replace(/,/g,"<br>");
			lastElement.innerHTML = backup;
			if(backupInnerHTML != "") {
				backupInnerHTML = backupInnerHTML.replace(/,/g,"<br>");
				lastElement.innerHTML = backupInnerHTML;
				backupInnerHTML = "";
			}
		}
		if(tdEle.innerHTML == "") {
			if(tdEle.parentNode.rowIndex == 6 || tdEle.parentNode.rowIndex == 3) {
				keyCodeDiag("This is a protected cell! Enter in the edit keycode to gain accesss to this cell");
				ppTD = tdEle;
			} else if(tdEle.parentNode.rowIndex == 13) {
				$("#tRoomChangeDiag").dialog("open");
				lastElement = tdEle;
			} else {
				tdEle.innerHTML = '<input type="text" name="iBox" id="iBox" class="iBox"/><br/><input type="submit" name="iSubmit" id="iSubmit" class="iSubmit" value="Submit"/>'
				+'<input type="hidden" name="row" value='+""+tdEle.parentNode.rowIndex +""+'>'
				+'<input type="hidden" name="cell" value='+""+tdEle.cellIndex+""+'>'
				+'<input type="hidden" name="tDate" value='+""+tdEle.parentNode.parentNode.parentNode.getAttribute("name")+""+'>';
				$("input:submit").button();
				mkAjaxForm();
				document.getElementById("iBox").focus();
				lastElement = tdEle;
			}
		} else {
			if(tdEle.parentNode.rowIndex == 6 || tdEle.parentNode.rowIndex == 3) {
				keyCodeDiag("This is a protected cell! Enter in the edit keycode to gain access to this cell!");
				ppTD = tdEle;
			} else if(tdEle.parentNode.rowIndex == 13) {
				$("#tRoomChangeDiag").dialog("open");
				lastElement = tdEle;
			} else {
				keyCodeDiag('This is a protected cell! If you are '+tdEle.innerHTML+', then please enter in your name exactly how it is written here in order to make a reservation change. After you click OK, highlight your name on the reservation table and hit the "Delete" key, then the SUBMIT button.');
				ppTD = tdEle;
			}
		}
	}
	
	function keyCodeDiag(message) {
		document.getElementById("keyContent").innerHTML = message;
		$( "#keyCodeDiag" ).dialog("open");
	}
	
	function sendTRoomChangeRequest(queryStr) {
		xmlhttpPost("tRoomChange.php",queryStr,tRoomChangeResponse);
	}
	
	function tRoomChangeResponse(response) {
		var announce = response.split("#")[0];
		displayDialog(announce);
		var update = response.split("#")[1];
		submittedElement.innerHTML = update;
	}
</script>
</head>
<body>
<div title="Teacher Room Change!" id="tRoomChangeDiag">
	Please enter your name and the room you would like to change to for the period, once you are done simply press "Submit". If you already entered a room change and would like to remove it then check "Remove" before pressing "Submit". 
    <br /><br />
	Name: <input type="text" style="width:250px; font-size:12px;margin-right:5px;" id="txtTName" />
    Room#: <input type="text" style="width:100px; font-size:12px;" id="txtTRoom" /><br /><br />
    <input name="tOption" type="radio" value="added" checked>Add</input>
    <input name="tOption" type="radio" value="removed" style="margin-left:15px;">Remove</input>
</div>
<div title="Key Code Entry!" id="keyCodeDiag">
	<div id="keyContent"></div>
    <br />
    <input type="text" style="width:350px; font-size:14px;" id="txtKeyCode"/>
</div>
<div title="Informational Dialog!" id="diag"></div>
<div class="gcontainer">
	<div class="blankContainer">
		<div class="floatContainer1">
    		<div class="floatContent">
				<div class="jumpDescriptor"><b>Jump to Date:</b><br /><i>For a date this week simply scroll down to the date. For dates beyond this week, simply click the date on the calendar.</i></div>
        		<div align="center"><div class="datePicker"></div></div>
                <div class="blank"></div>
       		</div>
    	</div>
    	<div class="floatContainer2">
        	<div class="floatHeader">© P.J.C.V.S</div>
    		<div class="floatContent">
        		<div class="logo" style="z-index:1"></div>
    		</div>
  	  	</div>
        <br style='clear:both' />
	</div>
	<form action="process.php" method="post" id="theForm">
		<?php include_once("init.php") ?>
	</form><br />
</div>
</body>
</html>