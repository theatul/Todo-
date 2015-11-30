<?php
require_once "include.php";
require_once "include_global.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
<title>The cleanest todo list ever</title>
<link type="text/css" href="styles/<?php echo $css_file ?>" rel="stylesheet" />
<link type="text/css" href="styles/auth-buttons.css" rel="stylesheet" />
<link rel="shortcut icon" href="/favicon.ico" />

</head>

<body >
		<?php
			require_once 'openid.php';
			$openid = new LightOpenID($domain);
			$openid->identity = 'https://www.google.com/accounts/o8/id';
			$openid->required = array(
  			'namePerson/first',
  			'namePerson/last',
  			'contact/email',
			);
			$openid->returnUrl = $returnUrl;
		?>


		<div id=login_msg>
			<p>The cleanest todo list ever!! Try it out.<p>
			<div id=button>
				<a class="btn-auth btn-google medium" href="<?php echo $openid->authUrl() ?>">Sign in with <b>Google</b></a>
			</div>
			<div id=button>
				<a class="btn-auth btn-facebook medium" onclick="doLogin();return false;" href="#">Sign in with <b>Facebook</b></a>
			</div>
			
			<?php

				if(isset($_SESSION['error']))
				{
				$error=trim($_SESSION['error']);
				 if (!empty($error))
				 {
				 	echo "<div id=error_msg> $error </div>";
				 	$_SESSION['error']="";
				 }
				}
				

			?>
			
		</div>


		<script src="http://connect.facebook.net/en_US/all.js"></script>
		<script>
		  FB.init({ appId: '184988181645247', status: true, cookie: true, xfbml : true });

		  FB.Event.subscribe('auth.login', function () {
          window.location = "http://todo.appflop.com/login.php";
      });

		  function doLogin() 
		  {  
			/*
		    FB.login(function(response) {
		      if (response.session) {
		        FB.api('/me',  function(response) {
		            alert('Welcome ' + response.name);
		            alert('Full details: ' + JSON.stringify(response));
		          }
		        );
		      }
		    } , {perms:''}); */

			alert("1sfas");
		  FB.getLoginStatus(function(response)
		  {
		  	alert("1sdsfsdfsdfas");
			  if (response.status === 'connected') 
			  {
			  	alert("1");
			    // the user is logged in and has authenticated your
			    // app, and response.authResponse supplies
			    // the user's ID, a valid access token, a signed
			    // request, and the time the access token 
			    // and signed request each expire
			    var uid = response.authResponse.userID;
			    var accessToken = response.authResponse.accessToken;

			    alert(uid);
			    alert(accessToken);

			  }
			   else if (response.status === 'not_authorized')
			    {
			    	alert("2");
			    // the user is logged in to Facebook, 
			    // but has not authenticated your app
					top.location=window.location="http://www.facebook.com/dialog/oauth/?scope=read_stream,publish_stream &client_id=184988181645247&redirect_uri=http://todo.appflop.com/login.php&response_type=code";
			  }
			  else
			  {
			  	alert("3");
			  	// the user isn't logged in to Facebook.
			  	FB.login(function(response) 
				    {
				       if (response.status.toString().indexOf("connected")>-1)
				       {
		        		initAll();
				        FB.api('/me',  function(response) {
				            alert('Welcome ' + response.name);
				            alert('Full details: ' + JSON.stringify(response));
				          }
				        );
				      }
				    } , {perms:''});
					    
			}
		 });

		}
		</script>
</body>

</html>
