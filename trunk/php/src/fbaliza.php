<?php
include "respond.php";
require_once 'appinclude.php';

if (isset($_REQUEST['mockfbmltext'])) {
  $botresponse=$_REQUEST['mockfbmltext'];
  $botresponse=replybotname($botresponse,$user);
  echo $botresponse->response;
  exit;
}


echo "<p>hello $user</p>";

$fbml = <<<EndHereDoc
<fb:subtitle>Talk to Aliza1:</fb:subtitle>

<form>
<input name="mockfbmltext" type="text" size="30">
<br />
<input type="submit"
  clickrewriteurl="$appcallbackurl"
  clickrewriteid="preview" value="Enter"
/>
<br />
<div id="preview" style="border-style: solid; border-color: black;
  border-width: 1px; padding: 5px;">
</div>
</form>
EndHereDoc;

$facebook->api_client->profile_setFBML($fbml, $user);

echo "<p>the following form was added to the profile box:</p>";

echo $fbml;
