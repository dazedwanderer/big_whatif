<?
//include("inc-database.php");
?>
<?php
	require_once("models/config.php");
	
	//Prevent the user visiting the logged in page if he/she is already logged in
	if(isUserLoggedIn()) { header("Location: userpage.php"); die(); }
?>


<?php
	/* 
		Below is a very simple example of how to process a new user.
		 Some simple validation (ideally more is needed).
		
		The first goal is to check for empty / null data, to reduce workload here we let the user class perform it's own internal checks, just in case they are missed.
	*/

//Forms posted
if(!empty($_POST))
{
		$errors = array();
		$email = trim($_POST["email"]);
		$username = trim($_POST["username"]);
		$password = trim($_POST["password"]);
		$confirm_pass = trim($_POST["passwordc"]);
		$remember_choice = trim($_POST["remember_me"]);
	
		//Perform some validation
		
		if(minMaxRange(5,25,$username))
		{
			$errors[] = lang("ACCOUNT_USER_CHAR_LIMIT",array(5,25));
		}
		if(minMaxRange(8,50,$password) && minMaxRange(8,50,$confirm_pass))
		{
			$errors[] = lang("ACCOUNT_PASS_CHAR_LIMIT",array(8,50));
		}
		else if($password != $confirm_pass)
		{
			$errors[] = lang("ACCOUNT_PASS_MISMATCH");
		}
		if(!isValidemail($email))
		{
			$errors[] = lang("ACCOUNT_INVALID_EMAIL");
		}
		//End data validation
		if(count($errors) == 0)
		{	
				//Construct a user object
				$user = new User($username,$password,$email);
				
				//Checking this flag tells us whether there were any errors such as possible data duplication occured
				if(!$user->status)
				{
					if($user->username_taken) $errors[] = lang("ACCOUNT_USERNAME_IN_USE",array($username));
					if($user->email_taken) 	  $errors[] = lang("ACCOUNT_EMAIL_IN_USE",array($email));		
				}
				else
				{
					//Attempt to add the user to the database, carry out finishing  tasks like emailing the user (if required)
					if(!$user->userPieAddUser())
					{
						if($user->mail_failure) $errors[] = lang("MAIL_ERROR");
						if($user->sql_failure)  $errors[] = lang("SQL_ERROR");
					}
				}
		}
	   if(count($errors) == 0) 
	   {
		        if($emailActivation)
		        {
		             $message = lang("ACCOUNT_REGISTRATION_COMPLETE_TYPE2");
		        } else {
		             $message = lang("ACCOUNT_REGISTRATION_COMPLETE_TYPE1");
		        }
	   }
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
 	<head>
 		<title>The Big What If...?</title>
 		<meta name="viewport" content="width=device-width, initial-scale=1.0">
 		<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
 		<link href="css/style.css" rel="stylesheet" type="text/css">
		<script src="assets/js/bootstrap-carousel.js"></script> 
		<script src="assets/js/bootstrap-transition.js"></script>
	</head>
	
	
<body style='background-color:#5f5f5f;'>
	<header>
		<div class="page-header">
	<div class="col-sm-4 col-xs-6 pull-right">		
			<div style="padding-top:20px;">
				<form name="newUser" action="login_v2.php" method="post">

		<input type="text" style="width:230px;float:left;" class="form-control" placeholder="Username" name="username"><br><br>
		<input type="password" style="width:230px;float:left;" class="form-control" placeholder="Password" name="password"><br><br>
		<div class="checkbox pull-left">
  <label>
	  <!--Fix Remember Me-->
	  <input type="hidden" name="remember_me">
	  <input type="checkbox" name="remember_me"><p style="color:#fff;">Remember Me</p>
  </label></div><br><br><br>
		<div class="pull-left" style="color:#fff;"><input type="submit" class="btn btn-success" name="new" id="newfeedform" value="Log In" />
		Trouble Logging In? <a href="forgot-password.php">Help Me!</a>
			</div>	
			</div>
		</div>
	<div class="col-sm-8 col-xs-6 pull-right">
		<img class="pull-left" src="images/logo.png" style="padding-top:30px;">
		<span><h2 style="color:#fff;padding-top:55px;">The Big What If...</h2></span>
		</div>	
	</div>
	</form>
	</header>
		</div>		
	<div class="container">
		<div class="wrapper">
		<div class="row-long">
			<div class="col-sm-6 col-xs-12" style="background-color:#fff;border:1px solid black;">
				<div id="success">
				</div>
				<div id="regbox">
				<form name="newUser" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
					<div><h2>Find out what would happen.<br>Sign up now</h2></div>
					<p><strong><?php echo $message; ?></strong><br></p>
					<p><strong>
					<?php foreach($errors as $error){
							echo $error;
						}
					?>
					</strong><br></p>
						<input type="text" style="width:230px;float:left;" class="form-control" placeholder="Username" name="username"><br><br>
						<input type="text" style="width:230px;float:left;" class="form-control" placeholder="Email" name="email"><br><br>
						<input type="password" style="width:230px;float:left;" class="form-control" placeholder="Password" name="password"><br><br>
						<input type="password" style="width:230px;float:left;" class="form-control" placeholder="Re-Type Password" name="passwordc"><br><br>
						<input type="submit" class="btn btn-success" name="new" id="newfeedform" value="Register" /><br><br>
						<div class="clear"></div>
						<p style="margin-top:30px; text-align:center;"><a href="login.php">Login</a> / <a href="forgot-password.php">Forgot Password?</a> / <a href="index.php">Home Page</a></p>
				</div>
			</div>
			<div class="col-sm-6 col-xs-12" style="background-color:#fff;border:1px solid black;">
				<div class="pull-left"><h3>Want to know what would happen if you were stranded on a desert island with your boss, or better yet your crush from school? <a style="color:green" href="register.php">Join</a> The Big What If? Today to find out! The newest, most interactive social network around!</h3></div>
				<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
			</div>
		</div>
	<div class="push"></div>
		</div>
	</div>
	</form>
	<script href="js/bootstrap.min.js"></script>	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	
</body>
<!--<div class="col-sm-12 hidden-xs footer" style="background-color:#898F8B;color:#000;text-align:center;">SocialAppDesign &copy;<span style="color:green;"> 2014</span></div>-->
</html>
