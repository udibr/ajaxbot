<?php

/*
    Program E
	Copyright 2002, Paul Rydell

	This file is part of Program E.
	
	Program E is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    Program E is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Program E; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

/**
 * HTML chat interface
 * 
 * Contains the script that outputs the HTML interface for chatting
 * @author Paul Rydell
 * @copyright 2002
 * @version 0.0.8
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @package Interpreter
 * @subpackage Responder
 */
$debug=0;

/**
* Include the guts of the program.
*/
// Start the session or get the existing session.
session_start();
include "respond.php";
include "login.php";
?>
<html>
<head>
<title>Sample talk to Program E page</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body onload="document.form1.input.focus()">
<?
displayLogin();
if($logged_in){
	if (isset($HTTP_POST_VARS['input'])){
		$numselects=0;

		// Here is where we get the reply.
		$botresponse=replybotname($HTTP_POST_VARS['input'],$_SESSION['cookname']);

		// Print the results.
		print "<BR><B>RESPONSE: " . $botresponse->response . "<BR></b>";
		//print "<BR><BR>execution time: " . $botresponse->timer;
		//print "<BR>numselects= $numselects";

		//print_r($botresponse->inputs);
		if ($debug>0) {
			foreach ($botresponse->inputs as $p){
				print "<BR>";
				print_r($p);
			}
			print "<BR>";
			foreach ($botresponse->patternsmatched as $p){
				print "<BR>";
				print_r($p);
			}
		}
	}	
	// Include a form so they can say more. Note the hidden part for people that do not have trans sid on but want non-cookie users to be able to use the system.
	?>
	<form name="form1" method="post" action="talk.php">
		Input: <input type="text" name="input" size="55">
		<input type="hidden" name="<?=session_name()?>" value="<?=session_id()?>">
		<input type="submit" name="Submit" value="Submit">
	</form>
	<?
}
?>
</body>
</html>


