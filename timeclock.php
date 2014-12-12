<?php 

	require_once("models/config.php");
	
if(!isset($loggedInUser)){
		
		header("Location: index_v2.php");
	}
$user=$loggedInUser->display_username;

function pretty_date($date) {
  list($y,$m,$d) = split("-", $date);

  return sprintf("%d/%d/%d", $m,$d,$y);
}
?>
<?include("header.php");?>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-4 col-xs-4 pull-left"></div>
			<div class="col-sm-4 col-xs-4 pull-left" style="background-color:#FFF;border:1px solid black;">
			
			<h1><u>Timeclock</u></h1>
			<form name='timeform' method='POST' action='timeclock.php'>
			<input type='hidden' name='user' value='<?=$user;?>'>
			<input type='hidden' name='hours' value='<?=$hours;?>'>
			<h2>My Time</h2>
			<table border='2px'>
				<tr>
					<td><strong>In Date</strong></td>
					<td><strong>In Time</strong></td>
					<td><strong>Out Date</strong></td>
					<td><strong>Out Time</strong></td>
					<td><strong>Total for Period</strong></td>
				</tr>
				<tr>
				<?
				$SQL_select_time="SELECT 
									LEFT(in_timestamp, 10) as in_date, 
									RIGHT(in_timestamp, 9) as in_time, 
									LEFT(out_timestamp, 10) as out_date, 
									RIGHT(out_timestamp, 9) as out_time, 
									in_timestamp as count_in,
									out_timestamp as count_out
								FROM 
									timeclock 
								WHERE 
									username='$user' 
								ORDER BY in_timestamp ASC";
				$sel=mysql_query($SQL_select_time);
				while($row=mysql_fetch_array($sel)){
					$in=$row["count_in"];
					$out=$row["count_out"];
				?>
				<td><?=pretty_date($row["in_date"])?></td>
				<td><?=date('h:i:s A', strtotime($row["in_time"]) + 2*60*60);?></td>
				<td><?if($row["count_out"]!="0000-00-00 00:00:00"){echo pretty_date($row["out_date"]);}else{}?></td>
				<td><?if($row["count_out"]!="0000-00-00 00:00:00"){echo date('h:i:s A', strtotime($row["out_time"]) + 2*60*60);}else{}?></td>
				<?
				if($row["count_out"]!="0000-00-00 00:00:00"){
				$t1 = strtotime($out);
				$t2 = strtotime($in);
				$diff = $t1 - $t2;
				$hours = $diff / ( 60 * 60 );
				$total += $hours;
				}else{
					//Do Nothing
				}
				?>
				<td><?if($row["count_out"]!="0000-00-00 00:00:00"){ echo $hours;}else{}?></td>
				</tr>
				<?}?>
				<tr><td>Total Hours</td><td><td><td></td></td></td><td><?echo $total;?></td></tr>
			</table>

			<input type='submit' name='submit_in' value='Clock In'>
			<input type='submit' name='submit_out' value='Clock Out'>
<?
if(isset($_POST["submit_in"])){
	$SQL_update_time="INSERT INTO timeclock(username, in_timestamp) VALUES('$user', NOW())";
	mysql_query($SQL_update_time);
	echo "<script>window.location.href = 'http://www.thebigwhatif.com/userpage.php';</script>";
}elseif(isset($_POST["submit_out"])){
	$SQL_sel_id="SELECT MAX(id) as id FROM timeclock WHERE username='$user'";
	$sel_id=mysql_query($SQL_sel_id);
	$row=mysql_fetch_array($sel_id);
	$tid=$row["id"];
	$SQL_update_time="UPDATE timeclock SET out_timestamp=NOW() WHERE id='$tid'";
	mysql_query($SQL_update_time);
	echo "<script>window.location.href = 'http://www.thebigwhatif.com/userpage.php';</script>";
}
?>
			</form>
		</div>
		<div class="col-sm-4 col-xs-4 pull-left"></div>
	</div>
</div>
	</body>
</html>
