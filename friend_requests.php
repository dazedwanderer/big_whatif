<? require_once("models/config.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
 	<head>
 		<title>The Big What If...?</title>
 		<meta name="viewport" content="width=device-width, initial-scale=1.0">
 		<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
 		<link href="css/style.css" rel="stylesheet" type="text/css"/>
 		<link href="assets/css/bootstrap.css" rel="stylesheet" type="text/css" />
		<script  type="text/javascript"  src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		<script type="text/javascript" src="assets/js/bootstrap.min.js"></script> 
		<script src="assets/js/bootstrap-carousel.js"></script> 
		<script src="assets/js/bootstrap-transition.js"></script>
		<script>
		form.acceptrequest.disabled = true;
		return true;
		</script>
	</head>
<body style='background-color:#5f5f5f;'>
	<header>
		<div class="page-header">
	<div class="col-sm-4 col-xs-6 pull-right">		

		</div>
	<div class="col-sm-8 col-xs-6 pull-right">
		<img class="pull-left" src="images/logo.png" style="padding-top:30px;">
		<span><h2 style="color:#fff;padding-top:55px;">The Big What If...</h2></span>
		</div>
	</div>
	<?include("inc-nav_top.php");?>
	</header>
	<div class="container" style="background-color:#fff;border:1px solid black;height:500px;max-height:1000px;">
		<div class="row">
			<div class="col-sm-12 col-xs-12">
				<br>
<?
$user=$loggedInUser->display_username;
//Find Friend Requests
$friendRequests = mysql_query("SELECT * FROM friend_requests WHERE user_to='$user'");
$numrows = mysql_num_rows($friendRequests);
if ($numrows == 0) {
 echo "You have no friend Requests at this time.";
 $user_from = "";
}
else
{
 while ($get_row = mysql_fetch_assoc($friendRequests)) {
  $id = $get_row['id']; 
  $user_to = $get_row['user_to'];
  $user_from = $get_row['user_from'];
  $user_to_space = str_replace(" ","_",$user_to);
  $user_from_space = str_replace(" ","_",$user_from);
  
  $SQL_profile_pic="SELECT profile_pic FROM users WHERE username='$user_from'";
  $get_pic=mysql_query($SQL_profile_pic);
  $pic=mysql_fetch_assoc($get_pic);
  
  echo "<img style='height:110px;width:110px;' src=uploads/" . $pic["profile_pic"] . "><br>" . $user_from . " wants to be friends!"."<br><br>";

?>
<?
if (isset($_POST['acceptrequest'.$user_from_space])) {
	
	$SQL_sel_id_logged="SELECT user_id FROM users WHERE username='$user'";
     $sel_logged=mysql_query($SQL_sel_id_logged);
     $row=mysql_fetch_array($sel_logged);
     $logged_id=$row["user_id"];
     
     $SQL_sel_id_prof="SELECT user_id FROM users WHERE username='$user_from'";
     $sel_prof=mysql_query($SQL_sel_id_prof);
     $row2=mysql_fetch_array($sel_prof);
     $prof_id=$row2["user_id"];
     
     
     $SQL_insert_rel="INSERT INTO friend_relationship (user_id, friend_id) VALUES ('$logged_id', '$prof_id')";
	 $q1=mysql_query($SQL_insert_rel);
	 //echo $SQL_insert_rel;

		 $SQL_insert_rel2="INSERT INTO friend_relationship (user_id, friend_id) VALUES ('$prof_id', '$logged_id')";
		  mysql_query($SQL_insert_rel2);
		  //echo $SQL_insert_rel2;

  $delete_request = mysql_query("DELETE FROM friend_requests WHERE user_to='$user_to'AND user_from='$user_from'");
  echo "You are now friends!";
  echo "<script>window.location.reload();</script>";
  
  /*Get friend array for logged in user
  $SQL_get_friends="SELECT friend_array FROM users WHERE username='$user'";
  $get_friend_check = mysql_query($SQL_get_friends);
  $get_friend_row = mysql_fetch_assoc($get_friend_check);
  $friend_array = $get_friend_row['friend_array'];
  $friendArray_explode = explode(",",$friend_array);
  $friendArray_count = count($friendArray_explode);

  //Get friend array for person who sent request
  $SQL_get_friends_from="SELECT friend_array FROM users WHERE username='$user_from'";
  $get_friend_check_friend = mysql_query($SQL_get_friends_from);
  $get_friend_row_friend = mysql_fetch_assoc($get_friend_check_friend);
  $friend_array_friend = $get_friend_row_friend['friend_array'];
  $friendArray_explode_friend = explode(",",$friend_array_friend);
  $friendArray_count_friend = count($friendArray_explode_friend);

  if ($friend_array == NULL) {
     $friendArray_count = count(NULL);
  }
  if ($friend_array_friend == NULL) {
     $friendArray_count_friend = count(NULL);
  }
  if ($friendArray_count == NULL) {
   $SQL_add_friend="UPDATE users SET friend_array = '$user_from_space' WHERE username='$user'";
   $add_friend_query = mysql_query($SQL_add_friend);

  }
  if ($friendArray_count_friend == NULL) {  
   $SQL_add_friend="UPDATE users SET friend_array = '$user_to_space' WHERE username='$user_from'";
   $add_friend_query = mysql_query($SQL_add_friend);
   echo $SQL_add_friend;

  }
  if ($friendArray_count >= 1) {
   $SQL_add_friend="UPDATE users SET friend_array = CONCAT(friend_array, ',$user_from_space') WHERE username='$user'";
   $add_friend_query = mysql_query($SQL_add_friend);

  }
  if ($friendArray_count_friend >= 1) {
   $SQL_add_friend="UPDATE users SET friend_array = CONCAT(friend_array, ',$user_to_space') WHERE username='$user_from'";
   $add_friend_query = mysql_query($SQL_add_friend);

  }

}
*/
}
if (isset($_POST['ignorerequest'.$user_from_space])) {
$ignore_request = mysql_query("DELETE FROM friend_requests WHERE user_to='$user_to' AND user_from='$user_from'");
  echo "Request Ignored!";
  echo "<script>window.location.reload();</script>";
}
?>
<form action="friend_requests.php" method="POST" onsubmit="acceptrequest.disabled = true; return true;">
<input type="submit" class="btn btn-success" name="acceptrequest<? echo $user_from_space; ?>" value="Accept Request">
<input type="submit" class="btn btn-danger" name="ignorerequest<? echo $user_from_space; ?>" value="Ignore Request">
</form>
<?
  }
  }

?>
				
				</div>
			</div>
		</div>
	</body>
</html>	
