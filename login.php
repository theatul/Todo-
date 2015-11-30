<?php
require_once "connect.php";
require_once 'openid.php';
require_once "include.php";

$openid = new LightOpenID($domain);

if ($openid->mode)
 {
	if ($openid->mode == 'cancel')
	{
		$_SESSION['error']="Authentication canceled !! please try again";
		header('Location: index.php');
		flush();
	}
	elseif($openid->validate())
	{
		$data = $openid->getAttributes();
	   // $email = $data['contact/email'];
		//$first = $data['namePerson/first'];

		$email=trim($data['contact/email']);
		 if (empty($email))
		 {
   			$_SESSION['error'] ="Sorry, Could not get email id, please try again!!";
			header('Location: index.php');
			flush();
		 }

		$_SESSION['email']=$data['contact/email'];

		$name=trim($data['namePerson/first']);
		if (empty($name))
		{
			$_SESSION['first']=$email;
		}
		else
		{
			$_SESSION['first']=$data['namePerson/first'];
		}
	  	
		$today = date('Y-m-d H:i:s');
		$query = mysql_query("INSERT INTO `users` (`email`, `join_date`, `count`) VALUES ( '".$_SESSION['email']."', '".$today."', 1 )");

		if(!$query)
		{
			// old user, just update the last login time stamp
			$update_query = mysql_query("UPDATE `users` SET count = count +1 WHERE `email`='".$_SESSION['email']."' ");
			$update_query = mysql_query("UPDATE `users` SET last_login='".$today."' WHERE `email`='".$_SESSION['email']."' ");
		}

		header('Location: list.php');
		flush();
	  
	} 
	else 
	{
		$_SESSION['error']="Sorry,you are not loged in, Please log in here!!";
		header('Location: index.php');
		flush();
	}
}
else
{
	$_SESSION['error']="Sorry,you are not loged in, Please log in here!!";
	header('Location: index.php');
	flush();
}

?>