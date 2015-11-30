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
				<a class="btn-auth btn-google large" href="<?php echo $openid->authUrl() ?>">Sign in with <b>Google</b></a>
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
        
        <div id = front_add>
       <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- 728_90_front_google_default -->
<ins class="adsbygoogle"
     style="display:inline-block;width:728px;height:90px"
     data-ad-client="ca-pub-8466330162458580"
     data-ad-slot="9932510214"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
        </div>


</body>
</html>
