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

function tabv($r,$t) {
	$v=$r[$t];
	if (!$v) return "&nbsp;";
	return $v;
}

/*
if(!get_magic_quotes_gpc()) {
	$username = addslashes($username);
}
*/
$q = "SELECT * FROM conversationlog ORDER BY enteredtime DESC LIMIT 0 , 30";
$result = mysql_query($q,$conn);

?>

<html>
<title>Logs</title>
<body>
<?
if(!$result || (mysql_numrows($result) < 1)){
	echo "no logs";
} else {
?>
<table border="1">
<tr><th>User</th><th>Time</th><th>Input</th><th>Response</th></tr>
<?
while($row=mysql_fetch_array($result)) {
	printf("<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>",
		tabv($row,'uid'),tabv($row,'enteredtime'),
		tabv($row,'input'),tabv($row,'response'));
}
?>
</table>
<? } ?>
</body>
</html>
