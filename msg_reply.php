<?php 

	require_once("models/config.php");
	
if(!isset($loggedInUser)){
		
		header("Location: index_v2.php");
	}
$user=$loggedInUser->display_username;
?>
<?include("header.php");?>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-4 col-xs-4 pull-left"></div>
			<div class="col-sm-4 col-xs-4 pull-left" style="background-color:#FFF;border:1px solid black;">
<?
if(isset($_GET["u"])){
	$username=mysql_real_escape_string($_GET["u"]);
	$SQL_profile=mysql_query("SELECT * FROM users WHERE username='$username'");
	if(mysql_num_rows($SQL_profile)==1){
	$post=mysql_fetch_assoc($SQL_profile);
	$username = $post["username"];
	$email = $post["email"];
	$profile_pic = $post["profile_pic"];
		
	if ($username != $user) {
       if (isset($_POST['submit'])) {
            $msg_title = strip_tags(@$_POST['msg_title']);
            $msg_body = "<pre>";
            $msg_body .= strip_tags(@$_POST['msg_body']);
            $msg_body .= "</pre>";
            $date = date("Y-m-d");
            $opened = "no";
            $deleted = "no";
            
            if(strlen($msg_title) > 40){
				echo "Please no more than 20 characters in your title.";
			}
			elseif ($msg_title == "Enter the message title here ...") {
             echo "Please give your message a title.";
            }
            elseif (strlen($msg_title) < 3) {
             echo "Your message title cannot be less than 3 characters in length!";
            }
            elseif ($msg_body == "Enter the message you wish to send ...") {
             echo "Please write a message.";
            }
            elseif (strlen($msg_body) < 3) {
             echo "Your message cannot be less than 3 characters in length!";
            }
            else
            {
				
			$SQL_msg="INSERT INTO
						pvt_messages
					  SET
						user_from='$user',
						user_to='$username',
						msg_title='$msg_title',
						msg_body='$msg_body',
						date='$date',
						opened='$opened',
						deleted='$deleted'";	
            $send_msg = mysql_query($SQL_msg);
            
           echo "<br><p style='color:#000;font-size:14px;'>Your message has been sent!</p>";
            }
          }
        echo "<form action='send_msg.php?u=$username' method='POST'>
			<h2 style='color:#000;'>Compose a Message: ($username)</h2>
			<input type='text' name='msg_title' size='30' onClick=\"value=''\" value='Enter the message title here ...'><p />
			<textarea cols='50' rows='12' name='msg_body'></textarea><p />
			<input type='submit' name='submit' value='Send Message'>
			</form>";
        }
        else
        {
         echo "<script>window.location.href = 'http://www.thebigwhatif.com/userpage.php;</script>";
        }
}
}
?>
	</div>
	<div class="col-sm-4 col-xs-4 pull-left"></div>
	</body>
</html>
