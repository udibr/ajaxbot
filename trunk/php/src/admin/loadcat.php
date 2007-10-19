<?php

/*
    Program E
	
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
* The general preferences and database details.
*/
require_once "dbprefs.php";

/**
* Contains the actual functions used in this file to load the AIML files into MySQL.
*/
require_once "botloaderfuncs.php";

ss_timing_start("all");

$fp = "";

$templatesinserted=0;

$depth = array();
$whaton = "";

$pattern = "";
$topic = "";
$that = "";
$template = "";

$startupwhich = "";
$splitterarray = array();
$inputarray = array();
$genderarray = array();
$personarray = array();
$person2array = array();

/**
 * Determines whether or not to show to sign-up form
 * based on whether the form has been submitted, if it
 * has, check the database for consistency and create
 * the new account.
 */
$message="";
if(isset($_POST['subjoin'])){
   /* Make sure all fields were entered */
	if(!$_POST['aimlstring']){
		$message='You didn\'t fill in a required field.';
	} else {
		$aimlstring = $_POST['aimlstring'];
		$bot="TestBot";

		if (!botexists($bot)) {
			$message = "No such bot".$bot;
		} else {
			$botid = getbotid($bot);
			loadaimlcategory($aimlstring,$botid);
			$path="./".basename($HTTP_SERVER_VARS[PHP_SELF]); // protect against cases in which the server root is not the same as the file-system root
			echo "<meta http-equiv=\"Refresh\" content=\"0;url=$path\">";
			return;
		}
   }
}
/**
 * This is the page with the sign-up form, the names
 * of the input fields are important and should not
 * be changed.
 */
?>

<html>
<title>Add AIML</title>
<body>
<h1>Add AIML text</h1>
<? echo $message; ?>
<form action="" method="post">
<textarea rows="40" cols="40" name="aimlstring">
</textarea>
<tr><td colspan="2" align="right"><input type="submit" name="subjoin" value="Enter text"></td></tr>
</table>
</form>
</body>
</html>
