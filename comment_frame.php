<?php
include("models/config.php");

if(!isset($loggedInUser)){	
	header("Location: index_v2.php");
	}
$user=$loggedInUser->display_username;
$username=$_GET["u"];
?>
<style>
* {
 font-size: 12px;
 font-family: Arial, Helvetica, Sans-serif;
}
hr {
	background-color: #DCE5EE;
	height: 1px;
	border: 0px;
}
</style>
<?php

$getid = $_GET['id'];

?>
<script language="javascript">
         function toggle() {
           var ele = document.getElementById("toggleComment");
           var text = document.getElementById("displayComment");
           if (ele.style.display == "block") {
              ele.style.display = "none";
           }
           else
           {
             ele.style.display = "block";
           }
         }
</script>
<?php
if (isset($_POST['postComment' . $getid . ''])) {
 $post_body = "<p>";
 $post_body .= $_POST['post_body'];
 $post_body .= "</p>";
 $username = $_POST['username'];
 if($username == ''){
 $posted_to = $user;
}else{
	$posted_to = $username;
}
 $insertPost = mysql_query("INSERT INTO post_comments(post_body, posted_by, posted_to, post_removed, post_id) VALUES ('$post_body','$user','$posted_to','0','$getid')");
}
?>

<a href='javascript:;' onClick="javascript:toggle()"><div style='float: right; display: inline;'>Post Comment</div></a>
<div id='toggleComment'  style='display: none;'>
<form action="comment_frame.php?id=<?php echo $getid; ?>" method="POST" name="postComment<?php echo $getid; ?>">
<input type='hidden' name='username' value='<?=$username;?>'>
Enter your comment below:<p />
<textarea rows="50" cols="50" style="height: 100px;" name="post_body"></textarea>
<input type="submit" name="postComment<?php echo $getid; ?>" value="Post Comment">
</form>
</div>
<?php

//Get Relevant Comments
$get_comments = mysql_query("SELECT * FROM post_comments WHERE post_id='$getid' ORDER BY id DESC");
$count = mysql_num_rows($get_comments);
if ($count != 0) {
while ($comment = mysql_fetch_assoc($get_comments)) {

$comment_body = $comment['post_body'];
$posted_to = $comment['posted_to'];
$posted_by = $comment['posted_by'];
$removed = $comment['post_removed'];

$SQL_get_info="SELECT * FROM users WHERE username='$posted_by'";
$get_info=mysql_query($SQL_get_info);
$row=mysql_fetch_array($get_info);
$profile_pic=$row["profile_pic"];
$profile_pic="/uploads/" . $profile_pic;

echo "<div style='float: left;'><img src='$profile_pic' style='height:50px; width: 50px;'>&nbsp;</div><div><b>$posted_by said: </b><br /></div><div style='max-width:600px;'>$comment_body</div><br>";

}
}
else
{
 echo "<center><br><br><br>No comments to display!</center>";
}
