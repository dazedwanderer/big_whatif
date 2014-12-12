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
<h2>My Unread Messages:</h2><p />
<?
//Grab the messages for the logged in user
$grab_messages = mysql_query("SELECT * FROM pvt_messages WHERE user_to='$user' && opened='no' && deleted='no'");
$numrows = mysql_num_rows($grab_messages);
if ($numrows != 0) {
while ($get_msg = mysql_fetch_assoc($grab_messages)) {
      $id = $get_msg['id']; 
      $user_from = $get_msg['user_from'];
      $user_to = $get_msg['user_to'];
      $msg_title = $get_msg['msg_title'];
      $msg_body = $get_msg['msg_body'];
      $date = $get_msg['date'];
      $opened = $get_msg['opened'];
      $deleted = $get_msg['deleted'];
      $timestamp = $get_msg['timestamp'];
      ?>
<script>
         function toggle<? echo $id; ?>() {
           var ele = document.getElementById("toggleText<? echo $id; ?>");
           var text = document.getElementById("displayText<? echo $id; ?>");
           if (ele.style.display == "block") {
              ele.style.display = "none";
           }
           else
           {
             ele.style.display = "block";
           }
         }
</script>
      <?
      $msg_title = $msg_title;
      $msg_body = $msg_body;
      
      if (@$_POST['setopened_' . $id . '']) {
       //Update the private messages table
       $setopened_query = mysql_query("UPDATE pvt_messages SET opened='yes' WHERE id='$id'");
      }

      echo "
      <form method='POST' action='my_messages.php' name='$msg_title'>
      <b><a href='$user_from'>$user_from</a></b>
      <input type='button' name='openmsg' value='$msg_title' onClick='javascript:toggle$id()'>
      <input type='submit' name='setopened_$id' value=\"Mark Read\">&nbsp;&nbsp;<strong>" . date('M j Y g:i A', strtotime($timestamp)) . "</strong>
      </form>
      <div id='toggleText$id' style='display: none;'>
      <br /><p style='text-align:left;overflow:auto;'>$msg_body</p>
      </div>
      <hr /><br />
      ";
if(isset($_POST["setopened_" . $id])){
	
	echo "<script>window.location.reload();</script>";
		}
	}
}
else
{
 echo "You haven't read any messages yet.";
}
?>
<h2>My Read Messages:</h2><p />
<?
//Grab the messages for the logged in user
$grab_messages = mysql_query("SELECT * FROM pvt_messages WHERE user_to='$user' && opened='yes' && deleted='no'");
$numrows_read = mysql_num_rows($grab_messages);
if ($numrows_read != 0) {
while ($get_msg = mysql_fetch_assoc($grab_messages)) {
      $id = $get_msg['id'];
      $user_from = $get_msg['user_from'];
      $user_to = $get_msg['user_to'];
      $msg_title = $get_msg['msg_title'];
      $msg_body = $get_msg['msg_body'];
      $date = $get_msg['date'];
      $opened = $get_msg['opened'];
      $deleted = $get_msg['deleted'];
      $timestamp = $get_msg['timestamp'];
      ?>
        <script language="javascript">
         function toggle<? echo $id; ?>() {
           var ele = document.getElementById("toggleText<? echo $id; ?>");
           var text = document.getElementById("displayText<? echo $id; ?>");
           if (ele.style.display == "block") {
              ele.style.display = "none";
           }
           else
           {
             ele.style.display = "block";
           }
         }
</script>
      <?
      
      if (strlen($msg_title) > 50) {
       $msg_title = substr($msg_title, 0, 50)." ...";
      }
      else
      $msg_title = $msg_title;
      
      if (strlen($msg_body) > 150) {
       $msg_body = substr($msg_body, 0, 150)." ...";
      }
      else
      $msg_body = $msg_body;
      
      if (@$_POST['delete_' . $id . '']) {
       $delete_msg_query = mysql_query("UPDATE pvt_messages SET deleted='yes' WHERE id='$id'");
      }
      if (@$_POST['reply_' . $id . '']) {
       echo "<meta http-equiv=\"refresh\" content=\"0; url=msg_reply.php?u=$user_from\">";
      }

      echo "      <form method='POST' action='my_messages.php' name='$msg_title'>
      <b><a href='$user_from'>$user_from</a></b>
      <input type='button' name='openmsg' value='$msg_title' onClick='javascript:toggle$id()'>
      <input type='submit' name='reply_$id' value=\"Reply\">
      <input type='submit' name='delete_$id' value=\"X\" title='Delete Message'>&nbsp;&nbsp;<strong>" . date('M j Y g:i A', strtotime($timestamp)) . "</strong>
      </form>
      <div id='toggleText$id' style='display: none;'>
      <br /><p style='text-align:left;overflow:auto;'>$msg_body</p>
      </div>
      <hr /><br />";

if(isset($_POST["delete_" . $id])){
	
	echo "<script>window.location.reload();</script>";
		}      

}
}
else
{
 echo "You haven't read any messages yet.";
}
?>
		</div>
		<div class="col-sm-4 col-xs-4 pull-left"></div>
	</div>
</div>
	</body>
</html>
