<?
include("inc-database.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<html>
	<head>
		<title>The Big What if?</title>
<script>var width = document.documentElement.clientWidth; var width = document.documentElement.clientHeight;</script>
	</head>
		<body>
			<div class='header'>
				<div class='slogan'>The Big What If...</div>
					<div class='logo'><a href='index_v1.php'><img src='images/logo.png'></a></div>
					<div class='login'>Username: <input type='text'><br><br>Password:&nbsp;&nbsp;<input type='text'><br><br><input type='submit' value='Sign Up'><br><br>
					Can't Login? <a href=''>Help Me!</a></div>
			</div>
<p class='left'>Find Out What Would Happen<br>Sign Up Now</p><br><br>
<div class='signup_name'>	
	<input height='20px' type='text' name='first_name' value='<?echo "First Name";?>'>&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='last_name' value='<?echo "Last Name";?>'><br><br>
</div>
<div class='signup_rest'>	
	<input type='text' name='email' size='51px' value='<?echo "Email";?>'><br><br>
	<input type='text' name='password' size='51px' value='<?echo "Password";?>'><br><br>
	<input type='text' name='password_re' size='51px' value='<?echo "Re-Enter Password";?>'><br><br><input type='submit' value='Sign Up'>
</div>

<p class='right'>Want to know what would happen if you were stranded on a desert island with your boss, or better yet your crush from school? <a href=''>Join</a> The Big What If?&copy; today to find out! The newest, most interactive social network around!</p>

		</body>
<div class='footer'>
<p>footer content</p>
</div>		
</html>
