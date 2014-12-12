<?php
	//General Settings
	//--------------------------------------------------------------------------
	
	//Database Information
	$dbtype = "mysql"; 
	$db_host = "localhost";
	$db_user = "dazed";
	$db_pass = "ideacreator55";
	$db_name = "thebigwhatif";
	$db_port = "3306";
	$db_table_prefix = "";

	$langauge = "en";
	
	//Generic website variables
	$websiteName = "The Big What If";
	$websiteUrl = "http://www.thebigwhatif.com"; //including trailing slash

	//Do you wish UserPie to send out emails for confirmation of registration?
	//We recommend this be set to true to prevent spam bots.
	//False = instant activation
	//If this variable is falses the resend-activation file not work.
	$emailActivation = true;

	//In hours, how long before UserPie will allow a user to request another account activation email
	//Set to 0 to remove threshold
	$resend_activation_threshold = 1;
	
	//Tagged onto our outgoing emails
	$emailAddress = "noreply@thebigwhatif.com";
	
	//Date format used on email's
	$emailDate = date("l \\t\h\e jS");
	
	//Directory where txt files are stored for the email templates.
	$mail_templates_dir = "models/mail-templates/";
	
	$default_hooks = array("#WEBSITENAME#","#WEBSITEURL#","#DATE#");
	$default_replace = array($websiteName,$websiteUrl,$emailDate);
	
	//Display explicit error messages?
	$debug_mode = false;

	//Remember me - amount of time to remain logged in.
	$remember_me_length = "1wk";
	
	//---------------------------------------------------------------------------
?>
