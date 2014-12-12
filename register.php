<?php
	require_once("models/config.php");
	
	//Prevent the user visiting the logged in page if he/she is already logged in
	if(isUserLoggedIn()) { header("Location: index.php"); die(); }
?>


<?php

//Forms posted
if(!empty($_POST))
{
		$errors = array();
		$email = trim($_POST["email"]);
		$username = trim($_POST["username"]);
		$password = trim($_POST["password"]);
		$confirm_pass = trim($_POST["passwordc"]);
	
		//Perform some validation
		//Feel free to edit / change as required
		
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
	</header>
<div class="modal-ish">
  <div class="modal-header">
<h2>Sign Up</h2>
</div>
  <div class="modal-body">

       

			


        <div id="success">
        
           <p><?php echo $message ?></p>
           
        </div>

            <div id="regbox">
                <form name="newUser" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                
                <p>
                    <label>Username:</label>
                    <input type="text" name="username" />
                </p>
                
                <p>
                    <label>Password:</label>
                    <input type="password" name="password" />
                </p>
                
                <p>
                    <label>Re-type Password:</label>
                    <input type="password" name="passwordc" />
                </p>
                
                <p>
                    <label>Email:</label>
                    <input type="text" name="email" />
                </p>
    
      </div>           
      </div>


  
 <div class="modal-footer">
<input type="submit" class="btn btn-primary" name="new" id="newfeedform" value="Register" />
  </div>  
                
                </form>
            </div>

			<div class="clear"></div>
            <p style="margin-top:30px; text-align:center;"><a href="login.php">Login</a> / <a href="forgot-password.php">Forgot Password?</a> / <a href="<?php echo $websiteUrl; ?>">Home Page</a></p>

</body>
</html>
