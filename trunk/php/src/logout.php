<?
/* Adapted from http://www.evolt.org/article/comment/17/60265/index.html */
session_start();

/**
* The general preferences and database details.
*/
require_once "admin/dbprefs.php";

/**
 * Delete cookies - the time must be in the past,
 * so just negate what you added when creating the
 * cookie.
 */
if(isset($_COOKIE['cookname'])){
   setcookie("cookname", "", time()-60*60*24*100, "/");
}

?>

<html>
<title>Logging Out</title>
<body>

<?

/* Kill session variables */
unset($_SESSION['username']);
unset($_SESSION['password']);
unset($_SESSION['cookname']);
$_SESSION = array(); // reset session array
session_destroy();   // destroy session.

echo "<h1>Logged Out</h1>\n";
echo "You have successfully <b>logged out</b>. Back to <a href=\"talk.php\">login</a>";
?>

</body>
</html>

