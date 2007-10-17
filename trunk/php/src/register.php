<?
/* Adapted from http://www.evolt.org/article/comment/17/60265/index.html */
session_start();

/**
* The general preferences and database details.
*/
require_once "admin/dbprefs.php";

/**
 * Returns true if the username has been taken
 * by another user, false otherwise.
 */
function usernameTaken($username){
   global $conn;
   if(!get_magic_quotes_gpc()){
      $username = addslashes($username);
   }
   $q = "select username from users where username = '$username'";
   $result = mysql_query($q,$conn);
   return (mysql_numrows($result) > 0);
}

/**
 * Get a new good random unique ID to identify the user
 */
function getUCookie() {
   global $conn;
   $ucookie="";
   $q = "select cookie from users";
   $result = mysql_query($q,$conn);
   if($result && (mysql_numrows($result) > 0)){
   	while ($r = mysql_fetch_array($result)){
   		$ucookie.=$r[0];
	}
   }
   $ucookie.=mt_rand();
   return md5($ucookie);
}

/**
 * Inserts the given (username, password) pair
 * into the database. Returns true on success,
 * false otherwise.
 */
function addNewUser($username, $password){
   global $conn;
   $ucookie=getUCookie();
   $q = "INSERT INTO users VALUES ('$username', '$password', '$ucookie')";
   return mysql_query($q,$conn);
}

/**
 * Displays the appropriate message to the user
 * after the registration attempt. It displays a 
 * success or failure status depending on a
 * session variable set during registration.
 */
function displayStatus(){
   $uname = $_SESSION['reguname'];
   if($_SESSION['regresult']){
?>

<h1>Registered!</h1>
<p>Thank you <b><? echo $uname; ?></b>, your information has been added to the database, you may now <a href="talk.php" title="Login">log in</a>.</p>

<?
   }
   else{
?>

<h1>Registration Failed</h1>
<p>We're sorry, but an error has occurred and your registration for the username <b><? echo $uname; ?></b>, could not be completed.<br>
Please try again at a later time.</p>

<?
   }
   unset($_SESSION['reguname']);
   unset($_SESSION['registered']);
   unset($_SESSION['regresult']);
}

if(isset($_SESSION['registered'])){
/**
 * This is the page that will be displayed after the
 * registration has been attempted.
 */
?>

<html>
<title>Registration Page</title>
<body>

<? displayStatus(); ?>

</body>
</html>

<?
   return;
}

/**
 * Determines whether or not to show to sign-up form
 * based on whether the form has been submitted, if it
 * has, check the database for consistency and create
 * the new account.
 */
$message="";
if(isset($_POST['subjoin'])){
   /* Make sure all fields were entered */
   if(!$_POST['user'] || !$_POST['pass']){
      $message='You didn\'t fill in a required field.';
   } else {

      /* Spruce up username, check length */
      $_POST['user'] = trim($_POST['user']);
      if(strlen($_POST['user']) > 30){
         $message = "Sorry, the username is longer than 30 characters, please shorten it.";
      } elseif(usernameTaken($_POST['user'])){
         /* Check if username is already in use */
         $use = $_POST['user'];
         $message = "Sorry, the username: <strong>$use</strong> is already taken, please pick another one.";
      } else {

         /* Add the new account to the database */
         $md5pass = md5($_POST['pass']);
         $_SESSION['reguname'] = $_POST['user'];
         $_SESSION['regresult'] = addNewUser($_POST['user'], $md5pass);
         $_SESSION['registered'] = true;
         echo "<meta http-equiv=\"Refresh\" content=\"0;url=$HTTP_SERVER_VARS[PHP_SELF]\">";
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
<title>Registration Page</title>
<body>
<h1>Register</h1>
<? echo $message; ?>
<form action="<? echo $HTTP_SERVER_VARS['PHP_SELF']; ?>" method="post">
<table align="left" border="0" cellspacing="0" cellpadding="3">
<tr><td>Username:</td><td><input type="text" name="user" maxlength="30"></td></tr>
<tr><td>Password:</td><td><input type="password" name="pass" maxlength="30"></td></tr>
<tr><td colspan="2" align="right"><input type="submit" name="subjoin" value="Join!"></td></tr>
</table>
</form>
</body>
</html>

