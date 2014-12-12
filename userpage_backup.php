<?php 

	require_once("models/config.php");
	
if(!isset($loggedInUser)){	
	header("Location: index_v2.php");
	}
$user=$loggedInUser->display_username;

if(isset($_GET["u"]) && ($_GET["u"]) == $user){
	header("Location: userpage.php");
}
?>
<?
if(isset($_GET["u"])){
	$username=mysql_real_escape_string($_GET["u"]);
	$SQL_profile=mysql_query("SELECT * FROM users WHERE username='$username'");
	if(mysql_num_rows($SQL_profile)==1){
	$post=mysql_fetch_assoc($SQL_profile);
	$username = $post["username"];
	$email = $post["email"];
	$profile_pic = $post["profile_pic"];
?>
<!--VIEWING OTHER USERS PAGE-->
<?include("header.php");?>
		<div class="container-fluid">
			<div class="row">
			<div class="col-sm-12 col-xs-12 pull-left" style="background-color:#fff;border:1px solid black;">
				<form name="search" action="<?if(isset($_GET["u"])){?>userpage.php?u=<?=$username;}else{?>userpage.php<?}?>" method="post">
				<span><strong>Search Users: </strong><input type="text" name="usersearch" id="usersearch"></span>
				<input type="submit" name="Submit" value="Search" class="btn btn-success"><br><br>
					<?
					if(isset($_POST["usersearch"])){
						$usersearch=$_POST["usersearch"];
						$SQL_search="SELECT * FROM users WHERE username LIKE '%$usersearch%' OR email LIKE '%$usersearch%'";
							$q1=mysql_query($SQL_search);
							while($row1=mysql_fetch_assoc($q1)){
								$name=$row1["username"];
								$pic=$row1["profile_pic"];
								
								echo "<a href='userpage.php?u=".$name."'><img style='height:100px;width:100px;' src='uploads/" . $pic . "'></a>";
								echo "<a href='userpage.php?u=".$name."'>" . $name . "</a>";
						}
						}else{
							//Do Nothing
						}
					?>
				</form>
					</div>
				</div>
			</div>
			<div class="container-fluid">

				<div class="row">
			<div class="col-sm-4 col-xs-12 pull-left" style="background-color:#fff;border:1px solid black;"><br>
            
            <div>
				<img style='height:180px;width:180px;' src="uploads/<?echo $profile_pic; ?>"><br><br>

<?
$errorMsg = "";
  if(isset($_POST['addfriend'])) {
	
     $friend_request = $_POST['addfriend'];
     
     $user_to = $username;
     $user_from = $user;
     
     if ($user_to == $user) {
      $errorMsg = "You can't send a friend request to yourself!<br />";
      echo $errorMsg;
     }
     else
     {		
		
	  $SQL_create_request="INSERT INTO friend_requests(user_from, user_to) VALUES('$user_from','$user_to')";
      $create_request = mysql_query($SQL_create_request);
      $errorMsg = "Your friend Request has been sent!";
      echo $errorMsg;
     }

  }
  else
  {
   //Do nothing
  }
?>
<form action="userpage.php?u=<? echo $username; ?>" method="POST">
<?
//Friend Code***
$friendArray = "";
$countFriends = "";
$friendsArray12 = "";
$addAsFriend = "";
$selectFriendsQuery = mysql_query("SELECT friend_array FROM users WHERE username='$username'");
$friendRow = mysql_fetch_assoc($selectFriendsQuery);
$friendArray = $friendRow['friend_array'];
if ($friendArray != "") {
   $friendArray = explode(",",$friendArray);
   $countFriends = count($friendArray);
   $friendArray12 = array_slice($friendArray, 0, 12);

$i = 0;
if (in_array($user,$friendArray)) {
 $addAsFriend = '<input type="submit" name="removefriend" value="De-Friend">';
 echo $addAsFriend;	
}
else
{
 $addAsFriend = '<input type="submit" name="addfriend" value="Add Friend">';
 echo $addAsFriend;
	}
}
//$user = logged in user
//$username = user who owns profile
if (@$_POST['removefriend']) {
  //Select user id of both friends
  $SQL_sel_id_logged="SELECT user_id FROM users WHERE username='$user'";
  $sel_logged=mysql_query($SQL_sel_id_logged);
  $row=mysql_fetch_array($sel_logged);
  $logged_id=$row["user_id"];
     
  $SQL_sel_id_prof="SELECT user_id FROM users WHERE username='$username'";
  $sel_prof=mysql_query($SQL_sel_id_prof);
  $row2=mysql_fetch_array($sel_prof);
  $prof_id=$row2["user_id"]; 	
  //Select and remove friend relationship from logged user
  $SQL_select_fid="SELECT id FROM friend_relationship WHERE user_id='$logged_id' and friend_id='$prof_id'";
  $sel_fid=mysql_query($SQL_select_fid);
  $row=mysql_fetch_array($sel_fid);
  $fid_logged=$row["id"];
  
  $SQL_remove_rel_logged="DELETE FROM friend_relationship WHERE id='$fid_logged'";
  mysql_query($SQL_remove_rel_logged);
  //Select and remove relationship from other user
  $SQL_select_fid2="SELECT id FROM friend_relationship WHERE user_id='$prof_id' and friend_id='$logged_id'";
  $sel_fid2=mysql_query($SQL_select_fid2);
  $row2=mysql_fetch_array($sel_fid2);
  $fid_prof=$row2["id"];
  
  $SQL_remove_rel_prof="DELETE FROM friend_relationship WHERE id='$fid_prof'";
  mysql_query($SQL_remove_rel_prof);
  
  $user_space=str_replace("_", " ", $user);
  $username_space=str_replace("_", " ", $username);
	
  //Friend array for logged in user
  $add_friend_check = mysql_query("SELECT friend_array FROM users WHERE username='$user'");
  $get_friend_row = mysql_fetch_assoc($add_friend_check);
  $friend_array = $get_friend_row['friend_array'];
  $friend_array_explode = explode(",",$friend_array);
  $friend_array_count = count($friend_array_explode);
  
  //Friend array for user who owns profile
  $add_friend_check_username = mysql_query("SELECT friend_array FROM users WHERE username='$username'");
  $get_friend_row_username = mysql_fetch_assoc($add_friend_check_username);
  $friend_array_username = $get_friend_row_username['friend_array'];
  $friend_array_explode_username = explode(",",$friend_array_username);
  $friend_array_count_username = count($friend_array_explode_username);
  
  $usernameComma = ",".$username_space;
  $usernameComma2 = $username_space.",";
  echo $usernameComma;
  
  $userComma = ",".$user;
  $userComma2 = $user.",";
  
  if (strstr($friend_array,$usernameComma)) {
   $friend1 = str_replace("$usernameComma","",$friend_array);
 
  }
  else
  if (strstr($friend_array,$usernameComma2)) {
   $friend1 = str_replace("$usernameComma2","",$friend_array);
  }
  else
  if (strstr($friend_array,$username_space)) {
   $friend1 = str_replace("$username_space","",$friend_array);
  }
  
  //Remove logged in user from other persons array
  if (strstr($friend_array_username,$userComma)) {
   $friend2 = str_replace("$userComma","",$friend_array_username);
  }
  else
  if (strstr($friend_array_username,$userComma2)) {
   $friend2 = str_replace("$userComma2","",$friend_array_username);
  }
  else
  if (strstr($friend_array_username,$user_space)) {
   $friend2 = str_replace("$user_space","",$friend_array_username);
  }

	echo $friend1;
	echo $friend2;
  $removeFriendQuery = mysql_query("UPDATE users SET friend_array='$friend1' WHERE username='$user'");
  $removeFriendQuery_username = mysql_query("UPDATE users SET friend_array='$friend2' WHERE username='$username'");
  echo "<br><br>Friend Removed ...";
  //echo "<script>window.location.reload();</script>";
}
//End***
?>
<?
if(isset($_POST["send_msg"])){
	
	echo "<script>window.location.href = 'http://www.thebigwhatif.com/send_msg.php?u=$username';</script>";
	
	//header("Location: send_msg.php?u=$username");
}

?>
<input type="submit" name="send_msg" value="Send Message">
<br><br> 
<?
if ($countFriends != 0) {
foreach ($friendArray12 as $key => $value) {

 $friend_space=str_replace("_"," ", $value);
 $i++;
 $getFriendQuery = mysql_query("SELECT * FROM users WHERE username='$friend_space' LIMIT 1");
 $getFriendRow = mysql_fetch_assoc($getFriendQuery);
 $friendUsername = $getFriendRow['username'];
 $friendProfilePic = $getFriendRow['profile_pic'];

 if ($friendProfilePic == "") {
  echo "<a href='$friendUsername'><img src='uploads/userpic.gif' alt=\"$friendUsername's Profile\" title=\"$friendUsername's Profile\" style='padding-right: 6px;height:50px;width:50px;'></a>";
 }
 else
 {
  echo "<a href='$friendUsername'><img src='uploads/$friendProfilePic' alt=\"$friendUsername's Profile\" title=\"$friendUsername's Profile\" style='padding-right: 6px;height:50px;width:50px;'></a>";
 }
}
}else{
echo $username." has no friends yet.";
}
?> 
</form>          
            </div>
            
<?
$SQL_info="SELECT * FROM users WHERE username='$username'";
$info=mysql_query($SQL_info);
$profile_info=mysql_fetch_array($info);
$first_name=$profile_info["first_name"];
$last_name=$profile_info["last_name"];
$age=$profile_info["age"];
$dob=$profile_info["dob"];
$city=$profile_info["city"];
$state=$profile_info["state"];
$country=$profile_info["country"];
$job_title=$profile_info["job_title"];
$job_type=$profile_info["job_type"];
$education_level=$profile_info["education_level"];
$sexual_preference=$profile_info["sexual_preference"];
$relationship_status=$profile_info["relationship_status"];
$about=$profile_info["about"];
$personality_type=$profile_info["personality_type"];
?> 
			<div>
			<span><strong><u>Profile Details For <?echo $username;?></u></strong></span><br>
			<span><strong style="color:#35a8db;">Friends: </strong><?echo " " . $countFriends;?> </span><br>
			<span><strong style="color:#35a8db;">What Ifs Sent?: </strong>Number of What Ifs Sent*** </span><br>
			<span><strong style="color:#35a8db;">What Ifs Received?: </strong>Number of What Ifs Received*** </span><br>
			<span><strong style="color:#35a8db;">Personality Type: </strong>
<?
if($personality_type!=NULL){
		echo $personality_type;
	}else{
		echo "Please take a personality survey to get maximum use out of The Big What If.";
	}
?>
			</span><br>
			<span><strong style="color:#35a8db;">Personality Questionnaires Taken: </strong>Number of Times Taken*** </span><br>
			</div>
			<div>
			<span><strong><u>Optional Information About <?echo $username;?></u></strong></span><br>
			<span><strong style="color:#35a8db;">Name: </strong>
<?
if($first_name!=NULL && $last_name!=NULL){
		echo $first_name . " " . $last_name;
	}elseif($first_name!=NULL){
		echo $first_name;
	}elseif($last_name!=NULL){
		echo $last_name;
	}else{
		echo $username . " has not given their name yet.";
	}
?> 
			</span><br>
			<span><strong style="color:#35a8db;">Age: </strong>
<?
 $birth_date = explode("-", $dob);
  //get age from date or birthdate
  $age = (date("md", date("U", mktime(0, 0, 0, $birth_date[0], $birth_date[1], $birth_date[2]))) > date("md")
    ? ((date("Y") - $birth_date[2]) - 1)
    : (date("Y") - $birth_date[2]));

if($dob!=NULL || $dob!="--"){
		echo $age;
	}else{
		echo $username . " has not provided their age.";
	}
?> 				
			</span><br>
			<span><strong style="color:#35a8db;">DOB: </strong>
<?
if($dob!=NULL || $dob!="--"){
		echo $dob;
	}else{
		echo $username . " has not provided their birthday.";
	}
?> 			
			</span><br>
			<span><strong style="color:#35a8db;">Location: </strong>
<?
if($city!=NULL && $state!=NULL && $country!=NULL){
		echo $city . " " . $state . ", " . $country;
	}elseif($city!=NULL && $state!=NULL && $country==NULL){
		echo $city . " " . $state;
	}elseif($city!=NULL && $state==NULL && $country==NULL){
		echo $city;
	}elseif($state!=NULL && $city==NULL && $country==NULL){
		echo $state;
	}elseif($country!=NULL && $city==NULL && $state==NULL){
		echo $country;
	}elseif($state!=NULL && $country!=NULL && $city==NULL){
		echo $state . ", " . $country;
	}elseif($city!=NULL && $country!=NULL && $state==NULL){
		echo $city . ", " . $country;
	}else{ 
		echo $username . " has not provided their location yet.";
	}
?> 
			</span><br>
			<span><strong style="color:#35a8db;">Work: </strong>
<?
if($job_type!=NULL && $job_title!=NULL){
		echo $job_type . ", " . $job_title;
	}elseif($job_type!=NULL && $job_title==NULL){
		echo $job_type;
	}elseif($job_title!=NULL && $job_type==NULL){
		echo $job_title;
	}else{
		echo $username . " had not provided any information on their employment.";
	}	
?>
			</span><br>
			<span><strong style="color:#35a8db;">Education Level: </strong>
<?
if($education_level!=NULL){
		echo $education_level;
	}else{
		echo $username . " has not provided their education.";
	}
?>			
			</span><br>
			<span><strong style="color:#35a8db;">Which Way Do You Swing?: </strong>
<?
if($sexual_preference!=NULL){
		echo $sexual_preference;
	}else{
		echo $username . " has not provided any information into their sexuality.";
	} 
?>			
			</span><br>
			<span><strong style="color:#35a8db;">Relationship Status: </strong>
<?
if($relationship_status!=NULL){
	echo $relationship_status;
}else{
	echo $username . " has not provided information into their personal life.";
}
?>			
			</span><br>
			</div>		
			<div>
			<span><strong style="color:#35a8db;">About Me: </strong>
<?
if($about!=NULL){
	echo $about;
}else{
	echo $username . " has not provided any personal information about themselves.";
}
?>
			</span><br>
			</div>	
			<div>
			<span><strong><u>Loves/Hates For <?=$username;?></u></strong></span><br>
			<span><strong style="color:#35a8db;">Activities: </strong>Area to input all activities*** </span><br>
			<span><strong style="color:#35a8db;">Music: </strong>Music Interests*** </span><br>
			<span><strong style="color:#35a8db;">Movies: </strong>Movies I Dig*** </span><br>
			<span><strong style="color:#35a8db;">TV: </strong>Shows Addicted To*** </span><br>
			<span><strong style="color:#35a8db;">Games: </strong>Games video, board, all types*** </span><br>
			<span><strong style="color:#35a8db;">Books: </strong>What I've Read or enjoy*** </span><br>
			<span><strong style="color:#35a8db;">Inspirational People: </strong>Inspired By Whom??*** </span><br>
			</div>	
				
			</div>
			<div class="col-sm-8 col-xs-12 pull-left" style="background-color:#fff;border:1px solid black;">
			<!--Smaller column for feed leaving whitespace on either side-->
				<div>Feed Content...</div>

			</div>
			<!--<div class="col-sm-2 col-xs-12 pull-right" style="background-color:#fff;border:1px solid black;">
			
				Targeted Ads...

			</div>-->
		</div>
	</div>
</body>
<?
}
	}else{
?>
<!--LOGGED IN USERS PAGE-->
<?include("header.php");?>
		<div class="container-fluid">
			<div class="row">
			<div class="col-sm-12 col-xs-12 pull-left" style="background-color:#fff;border:1px solid black;">
				<form name="name" action="<?if(isset($_GET["u"])){?>userpage.php?u=<?=$username;}else{?>userpage.php<?}?>" method="post">
				<span><strong>Search Users: </strong><input type="text" name="usersearch" id="usersearch"></span>
				<input type="submit" name="Submit" value="Search" class="btn btn-success"><br><br>
					<?
					if(isset($_POST["usersearch"])){
						$usersearch=$_POST["usersearch"];
						$SQL_search="SELECT * FROM users WHERE username LIKE '%$usersearch%' OR email LIKE '%$usersearch%'";
							$q1=mysql_query($SQL_search);
							while($row1=mysql_fetch_assoc($q1)){
								$name=$row1["username"];
								$pic=$row1["profile_pic"];
								
								echo "<a href='userpage.php?u=".$name."'><img style='height:100px;width:100px;' src='uploads/" . $pic . "'></a>";
								echo "<a href='userpage.php?u=".$name."'>" . $name . "</a>";
						}
						}else{
							//Do Nothing
						}
					?>
					</form>
					</div>
				</div>
			</div>
			<div class="container-fluid">

				<div class="row">
			<div class="col-sm-4 col-xs-12 pull-left" style="background-color:#fff;border:1px solid black;"><br>
        
        	<p>Welcome to your account page <strong><?php echo $loggedInUser->display_username; ?></strong></p>


            <p>You are a <strong><?php  $group = $loggedInUser->groupID(); echo $group['group_name']; ?></strong></p>
             <?
			$SQL_sel_group="SELECT group_id FROM users WHERE username='$user'";
			$sel=mysql_query($SQL_sel_group);
			$row=mysql_fetch_array($sel);
			if($row["group_id"]=='2'){
				echo "<p><a href='timeclock.php'>Click Here</a> to Clock In and Out.</p>";
			}
		    ?>	
          
            
            <p>You joined on <?php echo date("l \\t\h\\e jS \\o\\f M Y",$loggedInUser->signupTimeStamp()); ?> </p>
            
            <div>
				<?php
				
					$uid=$loggedInUser->user_id;
				
					$SQL_pic="SELECT
								profile_pic
							  FROM
								users
							  WHERE
								user_id='$uid'";
								
					$profile_pic=mysql_query($SQL_pic);
					$row=mysql_fetch_array($profile_pic);
					
				?>
				<?
					if($row["profile_pic"]=="userpic.gif"){
						echo "<strong>You Have No Profile Pic.</strong><br><br>";
					}
				
				?>
				<img style='height:180px;width:180px;' src="uploads/<?echo $row["profile_pic"]; ?>">
            
            </div>
            
             <form enctype="multipart/form-data" method="post" action="userpage.php">
				<label for="fileToUpload"><strong>Select a Snazzy Profile Pic: </strong></label>
					<input type="file" name="fileToUpload" id="fileToUpload">
					<input class="btn btn-success" type="submit" value="Upload"><br><br>
<?php

// include ImageManipulator class
require_once('ImageManipulator.php');
 
if ($_FILES['fileToUpload']['error'] > 0) {
    echo "Error: " . $_FILES['fileToUpload']['error'] . "<br>";
} else {
    // array of valid extensions
    $validExtensions = array('.jpg', '.jpeg', '.gif', '.png');
    // get extension of the uploaded file
    $fileExtension = strrchr($_FILES['fileToUpload']['name'], ".");
    // check if file Extension is on the list of allowed ones
    if (in_array($fileExtension, $validExtensions)) {
        $newNamePrefix = time() . '_';
        $manipulator = new ImageManipulator($_FILES['fileToUpload']['tmp_name']);
        //$width  = $manipulator->getWidth();
        //$height = $manipulator->getHeight();
        //$centreX = round($width / 2);
        //$centreY = round($height / 2);
		//our dimensions will be 200x130
		//$x1 = $centreX - 90; // 200 / 2
		//$y1 = $centreY - 90; // 130 / 2
		//$x2 = $centreX + 90; // 200 / 2
		//$y2 = $centreY + 90; // 130 / 2
 
        // center cropping to 200x130
		//$newImage = $manipulator->crop($x1, $y1, $x2, $y2);
        // saving file to uploads folder
        $manipulator->save('uploads/' . $newNamePrefix . $_FILES['fileToUpload']['name']);
        
        $filename=$newNamePrefix . $_FILES['fileToUpload']['name'];
        
        $SQL="UPDATE users SET profile_pic='$filename' WHERE user_id='$uid'";
				
					$upload_pic=mysql_query($SQL);
										
					echo "It's done! The file has been saved";
					
					echo "<script>window.location.reload();</script>";
    }
}
?>
</form>
<?
$username=$loggedInUser->display_username;
$selectFriendsQuery = mysql_query("SELECT friend_array FROM users WHERE username='$username'");
$friendRow = mysql_fetch_assoc($selectFriendsQuery);
$friendArray = $friendRow['friend_array'];

if ($friendArray != "") {
   $friendArray = explode(",",$friendArray);
   $countFriends = count($friendArray);
   $friendArray12 = array_slice($friendArray, 0, 12);
   $i=0;
   
}

if ($countFriends != 0) {
foreach ($friendArray12 as $key => $value) {
 $friend_space=str_replace("_"," ", $value);
 $i++;
 $getFriendQuery = mysql_query("SELECT * FROM users WHERE username='$friend_space' LIMIT 1");
 $getFriendRow = mysql_fetch_assoc($getFriendQuery);
 $friendUsername = $getFriendRow['username'];
 $friendProfilePic = $getFriendRow['profile_pic'];

 if ($friendProfilePic == "") {
  echo "<a href='$friendUsername'><img src='uploads/userpic.gif' alt=\"$friendUsername's Profile\" title=\"$friendUsername's Profile\" style='padding-right: 6px;height:50px;width:50px;'></a>";
 }
 else
 {
  echo "<a href='$friendUsername'><img src='uploads/$friendProfilePic' alt=\"$friendUsername's Profile\" title=\"$friendUsername's Profile\" style='padding-right: 6px;height:50px;width:50px;'></a>";
 }
}
}else{
echo "You have no friends yet. Go out there and ask some questions!";
}
?>

<?
$SQL_info="SELECT * FROM users WHERE username='$username'";
$info=mysql_query($SQL_info);
$profile_info=mysql_fetch_array($info);
$first_name=$profile_info["first_name"];
$last_name=$profile_info["last_name"];
$age=$profile_info["age"];
$dob=$profile_info["dob"];
$city=$profile_info["city"];
$state=$profile_info["state"];
$country=$profile_info["country"];
$job_title=$profile_info["job_title"];
$job_type=$profile_info["job_type"];
$education_level=$profile_info["education_level"];
$sexual_preference=$profile_info["sexual_preference"];
$relationship_status=$profile_info["relationship_status"];
$about=$profile_info["about"];
$personality_type=$profile_info["personality_type"];
?> 
			<div>
			<br><a href="edit_profile.php" class="btn btn-success">Edit Profile Details</a><br><br>	
			<span><strong><u>Profile Details For <?echo $username;?></u></strong></span><br>
			<span><strong style="color:#35a8db;">Friends: </strong><?echo " " . $countFriends;?> </span><br>
			<span><strong style="color:#35a8db;">What Ifs Sent?: </strong>Number of What Ifs Sent*** </span><br>
			<span><strong style="color:#35a8db;">What Ifs Received?: </strong>Number of What Ifs Received*** </span><br>
			<span><strong style="color:#35a8db;">Personality Type: </strong>
<?
if($personality_type!=NULL){
		echo $personality_type;
	}else{
		echo "Please take a personality survey to get maximum use out of The Big What If.";
	}
?>
			</span><br>
			<span><strong style="color:#35a8db;">Personality Questionnaires Taken: </strong>Number of Times Taken*** </span><br>
			</div>
			<div>
			<span><strong><u>Optional Information About <?echo $username;?></u></strong></span><br>
			<span><strong style="color:#35a8db;">Name: </strong>
<?
if($first_name!=NULL && $last_name!=NULL){
		echo $first_name . " " . $last_name;
	}elseif($first_name!=NULL){
		echo $first_name;
	}elseif($last_name!=NULL){
		echo $last_name;
	}else{
		echo $username . " has not given their name yet.";
	}
?> 
			</span><br>
			<span><strong style="color:#35a8db;">Age: </strong>
<?
 $birth_date = explode("-", $dob);
  //get age from date or birthdate
  $age = (date("md", date("U", mktime(0, 0, 0, $birth_date[0], $birth_date[1], $birth_date[2]))) > date("md")
    ? ((date("Y") - $birth_date[2]) - 1)
    : (date("Y") - $birth_date[2]));

if($dob!=NULL || $dob!="--"){
		echo $age;
	}else{
		echo $username . " has not provided their age.";
	}
?> 			
			</span><br>
			<span><strong style="color:#35a8db;">DOB: </strong>
<?
if($dob!=NULL || $dob!="--"){
		echo $dob;
	}else{
		echo $username . " has not provided their birthday.";
	}
?> 			
			</span><br>
			<span><strong style="color:#35a8db;">Location: </strong>
<?
if($city!=NULL && $state!=NULL && $country!=NULL){
		echo $city . " " . $state . ", " . $country;
	}elseif($city!=NULL && $state!=NULL && $country==NULL){
		echo $city . " " . $state;
	}elseif($city!=NULL && $state==NULL && $country==NULL){
		echo $city;
	}elseif($state!=NULL && $city==NULL && $country==NULL){
		echo $state;
	}elseif($country!=NULL && $city==NULL && $state==NULL){
		echo $country;
	}elseif($state!=NULL && $country!=NULL && $city==NULL){
		echo $state . ", " . $country;
	}elseif($city!=NULL && $country!=NULL && $state==NULL){
		echo $city . ", " . $country;
	}else{ 
		echo $username . " has not provided their location yet.";
	}
?> 
			</span><br>
			<span><strong style="color:#35a8db;">Work: </strong>
<?
if($job_type!=NULL && $job_title!=NULL){
		echo $job_type . ", " . $job_title;
	}elseif($job_type!=NULL && $job_title==NULL){
		echo $job_type;
	}elseif($job_title!=NULL && $job_type==NULL){
		echo $job_title;
	}else{
		echo $username . " had not provided any information on their employment.";
	}	
?>
			</span><br>
			<span><strong style="color:#35a8db;">Education Level: </strong>
<?
if($education_level!=NULL){
		echo $education_level;
	}else{
		echo $username . " has not provided their education.";
	}
?>			
			</span><br>
			<span><strong style="color:#35a8db;">Which Way Do You Swing?: </strong>
<?
if($sexual_preference!=NULL){
		echo $sexual_preference;
	}else{
		echo $username . " has not provided any information into their sexuality.";
	} 
?>			
			</span><br>
			<span><strong style="color:#35a8db;">Relationship Status: </strong>
<?
if($relationship_status!=NULL){
	echo $relationship_status;
}else{
	echo $username . " has not provided information into their personal life.";
}
?>			
			</span><br>
			</div>		
			<div>
			<span><strong style="color:#35a8db;">About Me: </strong>
<?
if($about!=NULL){
	echo $about;
}else{
	echo $username . " has not provided any personal information about themselves.";
}
?>
			</span><br>
			</div>	
			<div>
			<span><strong><u>Loves/Hates For <?echo $username;?></u></strong></span><br>
			<span><strong style="color:#35a8db;">Activities: </strong>Area to input all activities*** </span><br>
			<span><strong style="color:#35a8db;">Music: </strong>Music Interests*** </span><br>
			<span><strong style="color:#35a8db;">Movies: </strong>Movies I Dig*** </span><br>
			<span><strong style="color:#35a8db;">TV: </strong>Shows Addicted To*** </span><br>
			<span><strong style="color:#35a8db;">Games: </strong>Games video, board, all types*** </span><br>
			<span><strong style="color:#35a8db;">Books: </strong>What I've Read or enjoy*** </span><br>
			<span><strong style="color:#35a8db;">Inspirational People: </strong>Inspired By Whom??*** </span><br>
			</div>	
				
			</div>
			<div class="col-sm-8 col-xs-12 pull-left" style="background-color:#fff;border:1px solid black;">
				
				<!--Smaller column for feed leaving whitespace on either side-->
				<div>Feed Content...</div>

			</div>
			<!--<div class="col-sm-2 col-xs-12 pull-right" style="background-color:#fff;border:1px solid black;">
			
				Targeted Ads...

			</div>-->
		</div>
	</div>
</body>
<?
}
?>
</html>
