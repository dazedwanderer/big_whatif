<?
include("header.php");

$uid=$loggedInUser->user_id;
$username=$loggedInUser->display_username;

if(!isset($_POST["submit"])){
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
}
?>
	<div class="container" style="background-color:#fff;border:1px solid black;height:1000px;max-height:2000px;">
		<div class="row">
			<div class="col-sm-12 col-xs-12">
				<br>
				<div class="pull-left">
					<h3 style="text-color:#000;font-weight:bold;text-align:center;"><u>Here at The Big What If, we encourage everyone to give as much or as little information as you feel SAFE providing to us.
					   The keyword here is Safe. We will not share any of the information you have provided to us. 	
					</u></h3>
				</div>
				<div>
					<img style="display: block;margin-left: auto;margin-right: auto;" src="images/logo.png"><br>
				</div>
				<div>
					<p style="text-color:#000;font-size:20px;text-align:center;font-weight:bold;"><u>Please provide any information you would like below.</u></p><br>
				</div>
				<form name="edit" action="edit_profile.php" method="POST">
				<div>
				<span><strong>First Name: </strong></span><input type="text" name="first_name" placeholder="<?if($first_name!=NULL){echo $first_name;}?>">
				<span><strong>Last Name: </strong></span><input type="text" name="last_name" placeholder="<?if($last_name!=NULL){echo $last_name;}?>"><br>
				<span><strong>DOB: </strong></span>
				<?
 
echo "
<td>
<Select name='month'><option value=''> Select a Month </option>
<option value='01'> January </option>
<option value='02'> February </option>
<option value='03'> March </option>
<option value='04'> April </option>
<option value='05'> May </option>
<option value='06'> June</option>
<option value='07'> July </option>
<option value='08'> August </option>
<option value='09'> September </option>
<option value='10'> October </option>
<option value='11'> November </option>
<option value='12'> December</option>
</select></td>

<td>
<Select name='day'><option value=''> Select a Day </option>
<option value='01'>1 </option>
<option value='02'>2 </option>
<option value='03'>3 </option>
<option value='04'>4 </option>
<option value='05'>5 </option>
<option value='06'>6 </option>
<option value='07'>7 </option>
<option value='08'>8 </option>
<option value='09'>9 </option>
<option value='10'>10 </option>
<option value='11'>11 </option>
<option value='12'>12 </option>
<option value='13'>13 </option>
<option value='14'>14 </option>
<option value='15'>15 </option>
<option value='16'>16 </option>
<option value='17'>17 </option>
<option value='18'>18</option>
<option value='19'>19 </option>
<option value='20'>20 </option>
<option value='21'>21 </option>
<option value='22'>22 </option>
<option value='23'>23 </option>
<option value='24'>24</option>
<option value='25'>25 </option>
<option value='26'>26 </option>
<option value='27'>27 </option>
<option value='28'>28 </option>
<option value='29'>29 </option>
<option value='30'>30</option>
<option value='31'>31 </option>
</select>

</td>

<td>";
$currentyear=date("Y");

$years = range(1900, $currentyear);

echo "<select name='year'>";
echo "<option value=''>Select a Year</option>";
foreach ($years as $value) { 
echo "<option value=\"$value\">$value</option>\n"; 
} 
echo "</select> 
</td>";


?> <br>
				<span><strong>Location: </strong></span>
				<select name="country">
					<option value="">Select Country</option>
					<option value="United States" <?if($country=="United States"){echo 'selected="selected"';}?>>United States</option>
					<option value="Uk" <?if($country=="Uk"){echo 'selected="selected"';}?>>UK</option>
				</select>
				<select name="state">
					<option value="">Select State</option>
					<option value="Tennessee" <?if($state=="Tennessee"){echo 'selected="selected"';}?>>Tennessee</option>
				</select>
				<select name="city">
					<option value="">Select City</option>
					<option value="Sevierville" <?if($city=="Sevierville"){echo 'selected="selected"';}?>>Sevierville</option>
					<option value="Knoxville" <?if($city=="Knoxville"){echo 'selected="selected"';}?>>Knoxville</option>
				</select> <br>
				<span><strong>Job Type: </strong></span><input type="text" name="job_type" placeholder="<?if($job_type!=NULL){echo $job_type;}?>">
				<span><strong>Job Title: </strong></span><input type="text" name="job_title" placeholder="<?if($job_title!=NULL){echo $job_title;}?>"><br>
				<span><strong>Education Level: </strong></span>
				<select name="education_level">
					<option value="">Select Your Education</option>
					<option value="Some High School" <?if($education_level=="Some High School"){echo 'selected="selected"';}?>>Some High School</option>	
					<option value="High School Diploma or GED" <?if($education_level=="High School Diploma or GED"){echo 'selected="selected"';}?>>High School Diploma or GED</option>
					<option value="Some College" <?if($education_level=="Some College"){echo 'selected="selected"';}?>>Some College</option>
					<option value="Associate" <?if($education_level=="Associate"){echo 'selected="selected"';}?>>College Associate Degree</option>
					<option value="Bachelors" <?if($education_level=="Bachelors"){echo 'selected="selected"';}?>>College Bachelors Degree</option>
					<option value="Masters" <?if($education_level=="Masters"){echo 'selected="selected"';}?>>College Masters Degree</option>
					<option value="Doctorate" <?if($education_level=="Doctorate"){echo 'selected="selected"';}?>>Colege Doctors Degree</option>
				</select><br>
				<span><strong>Which Way Do You Swing?: </strong></span>
				<select name="sexual_preference">
					<option value="">Sexual Preference</option>
					<option value="Straight" <?if($sexual_preference=="Straight"){echo 'selected="selected"';}?>>Straight</option>
					<option value="Gay" <?if($sexual_preference=="Gay"){echo 'selected="selected"';}?>>Gay</option>
					<option value="Lesbian" <?if($sexual_preference=="Lesbian"){echo 'selected="selected"';}?>>Lesbian</option>
					<option value="Bisexual" <?if($sexual_preference=="Bisexual"){echo 'selected="selected"';}?>>I Dig It All</option>
					<option value="Transgender" <?if($sexual_preference=="Transgender"){echo 'selected="selected"';}?>>Transsexual</option>
				</select>
				<span><strong>Relationship Status: </strong></span>
				<select name="relationship_status">
					<option value="" >Relationship Status</option>
					<option value="Single" <?if($relationship_status=="Single"){echo 'selected="selected"';}?>>Single</option>
					<option value="Married" <?if($relationship_status=="Married"){echo 'selected="selected"';}?>>Married</option>
					<option value="Partnership" <?if($relationship_status=="Partnership"){echo 'selected="selected"';}?>>Partnership</option>
					<option value="Super Complex" <?if($relationship_status=="Super Complex"){echo 'selected="selected"';}?>>Super Complex</option>
					<option value="Open" <?if($relationship_status=="Open"){echo 'selected="selected"';}?>>Open Relationships</option>
				</select><br>
				<span><strong>About Me: </strong></span><textarea rows="4" style="width:600px;" name="about" placeholder="<?if($about!=NULL){echo $about;}?>"></textarea><br>
				<input type="submit" class="btn btn-success" name="submit" value="Update Information">
				</div>
<?
if(isset($_POST["submit"])){
$first_name=$_POST["first_name"];
$last_name=$_POST["last_name"];
$city=$_POST["city"];
$state=$_POST["state"];
$country=$_POST["country"];
$job_title=$_POST["job_title"];
$job_type=$_POST["job_type"];
$education_level=$_POST["education_level"];
$sexual_preference=$_POST["sexual_preference"];
$relationship_status=$_POST["relationship_status"];
$about=$_POST["about"];
$month=$_POST["month"];
$day=$_POST["day"];
$year=$_POST["year"];
	$SQL_insert_info="UPDATE 
						users
					  SET
						first_name='$first_name',
						last_name='$last_name',
						dob='$month-$day-$year',
						country='$country',
						state='$state',
						city='$city',
						job_type='$job_type',
						job_title='$job_title',
						education_level='$education_level',
						sexual_preference='$sexual_preference',
						relationship_status='$relationship_status',
						about='$about'
					  WHERE
						username='$username'";
	mysql_query($SQL_insert_info);
	
	echo "<script>window.location='userpage.php';</script>";
}

?>
</form>											
				</div>
			</div>
		</div>				
	</body>
</html>
