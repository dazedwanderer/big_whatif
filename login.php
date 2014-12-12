<?php
	require_once("models/config.php");
	
	//Prevent the user visiting the logged in page if he/she is already logged in
	if(isUserLoggedIn()) { header("Location: index_v2.php"); die(); }
?>
<?php

//Forms posted
if(!empty($_POST))
{
		$errors = array();
		$username = trim($_POST["username"]);
		$password = trim($_POST["password"]);
		$remember_choice = trim($_POST["remember_me"]);
	
		//Perform some validation
		//Feel free to edit / change as required
		if($username == "")
		{
			$errors[] = lang("ACCOUNT_SPECIFY_USERNAME");
		}
		if($password == "")
		{
			$errors[] = lang("ACCOUNT_SPECIFY_PASSWORD");
		}
		
		//End data validation
		if(count($errors) == 0)
		{
			//A security note here, never tell the user which credential was incorrect
			if(!usernameExists($username))
			{
				$errors[] = lang("ACCOUNT_USER_OR_PASS_INVALID");
			}
			else
			{
				$userdetails = fetchUserDetails($username);
			
				//See if the user's account is activation
				if($userdetails["active"]==0)
				{
					$errors[] = lang("ACCOUNT_INACTIVE");
				}
				else
				{
					//Hash the password and use the salt from the database to compare the password.
					$entered_pass = generateHash($password,$userdetails["password"]);

					if($entered_pass != $userdetails["password"])
					{
						//Again, we know the password is at fault here, but lets not give away the combination incase of someone bruteforcing
						$errors[] = lang("ACCOUNT_USER_OR_PASS_INVALID");
					}
					else
					{
						//passwords match! we're good to go'
						
						//Construct a new logged in user object
						//Transfer some db data to the session object
						$loggedInUser = new loggedInUser();
						$loggedInUser->email = $userdetails["email"];
						$loggedInUser->user_id = $userdetails["user_id"];
						$loggedInUser->hash_pw = $userdetails["password"];
						$loggedInUser->display_username = $userdetails["username"];
						$loggedInUser->clean_username = $userdetails["username_clean"];
						$loggedInUser->remember_me = $remember_choice;
						$loggedInUser->remember_me_sessid = generateHash(uniqid(rand(), true));
						
						//Update last sign in
						$loggedInUser->updatelast_sign_in();
		
						if($loggedInUser->remember_me == 0)
							$_SESSION["userPieUser"] = $loggedInUser;
						else if($loggedInUser->remember_me == 1) {
							$db->sql_query("INSERT INTO ".$db_table_prefix."sessions VALUES('".time()."', '".serialize($loggedInUser)."', '".$loggedInUser->remember_me_sessid."')");
							setcookie("userPieUser", $loggedInUser->remember_me_sessid, time()+parseLength($remember_me_length));
						}
						//Redirect to user account page
						header("Location: index.php");
						die();
					}
				}
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
<h2>Sign In</h2>
  </div>
  <div class="modal-body">
 

               
        <?php
        if(!empty($_POST))
        {
        ?>
        <?php
        if(count($errors) > 0)
        {
        ?>
        <div id="errors">
        <?php errorBlock($errors); ?>
        </div>     
        <?php
        } }
        ?> 
        
        <?php if(($_GET['status']) == "success") 
        {
        
        echo "<p>Your account was created successfully. Please login.</p>";
        
    	}
    	?>
        
        
                <form name="newUser" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                <p>
                    <label>Username:</label>
                    <input type="text"  name="username" />
                </p>
                
                <p>
                     <label>Password:</label>
                     <input type="password" name="password" />
                </p>
                
 <p>
		     <input type="checkbox" name="remember_me" value="1" />	
                     <label><small>Remember Me?</small></label>
                </p>                

	
                          

                          </div>

            
 <div class="modal-footer">
<input type="submit" class="btn btn-primary" name="new" id="newfeedform" value="Sign In" />
  </div>
  
</div>

                </form>
                
        
            <div class="clear"></div>
<p style="margin-top:30px; text-align:center;">
<a href="register.php">Sign Up</a> | <a href="forgot-password.php">Forgot Password?</a> | <a href="/">Home Page</a></p>
            
      
</body>
</html>


