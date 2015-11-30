<?php

require "connect.php";
require_once "todo.class.php";
require_once "include.php";
require_once "include_global.php";

if (!$_SESSION['email'])
	header('Location: index.php');

include_once("analytics_list.php");
	
// Select all deleted TODo's 
$query = mysql_query("SELECT * FROM  `tz_todo` WHERE  `email` =  '".$_SESSION['email']."' and live=0 ORDER BY `position` ASC");
$archived_todos = array();
// Filling the $todos array with new ToDo objects:
while($row = mysql_fetch_assoc($query))
{
	$archived_todos[] = new ToDo($row, 0);
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title> Your clean ToDo List | Enjoy it. </title> 
		 <link rel="stylesheet" href="http://ajax.microsoft.com/ajax/jquery.ui/1.8.6/themes/smoothness/jquery-ui.css" type="text/css" media="all" />
		<link type="text/css" href="styles/<?php echo $css_file ?>" rel="stylesheet" />		
		 <link href="morden_buttons/css/m-styles.min.css" rel="stylesheet"> 
	</head>

	<body>

		<div id="main">
			<div id="head">
				<div id="input_form">
					<!-- <input id=task_box type="text" name="task_box" placeholder="Add Task here..">
					<a href="#" class="add"></a>  -->
                    <div id ="archive_text"> Archived Task's </div>
				 </div>

				 <div id= "dropdown">
					 <a href="list.php" class= "backToAllTask"> < Back to all Tasks</a>
                  
				</div>

				<?php	
				   //considering the best case
					echo "<div id=account_archive>";
					echo $_SESSION['first']." |";
					echo "<a id=logout href=logout.php>logout</a>";
					echo "</div>";
				?>
			</div>
			<div id=main_left>
				<ul class="todoList">
					<?php
						// Looping and outputting the $todos array. The __toString() method
						// is used internally to convert the objects to strings:
						foreach(array_reverse($archived_todos) as $item)
						{
							echo $item;
						}
					?>
				</ul>
			</div>

			<div id=main_right>
			<!-- 120_600_right_side -->
         
				<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <!-- 120_600_right_side -->
                <ins class="adsbygoogle"
                     style="display:inline-block;width:120px;height:600px"
                     data-ad-client="ca-pub-8466330162458580"
                     data-ad-slot="3095731017"></ins>
                <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>
	<!--			<a target="_blank" href="https://chrome.google.com/webstore/detail/todo/madhkckbjlmbdljfhidcbnpkknjlojoa/reviews?utm_source=chrome-ntp-icon" id="feedback_href">Let us listen you!</a>-->
			
		</div>
	
		<!-- Including the jQuery UI Human Theme -->
	 	
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
		<!--<script src="http://ace-subido.github.com/css3-microsoft-metro-buttons/js/jquery-1.8.0.min.js"></script> -->
		<script src="http://ajax.microsoft.com/ajax/jquery.ui/1.8.6/jquery-ui.min.js"></script>

		<script src="scripts/date.js"></script>
		<script src="scripts/<?php echo $js_file ?>"></script>
		
		<script src="morden_buttons/js/m-dropdown.min.js"></script>
		<script src="morden_buttons/js/m-radio.min.js"></script>
		
	</body>
</html>
