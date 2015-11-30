<?php

require "connect.php";
require "todo.class.php";

try{

	switch($_GET['action'])
	{
		case 'archive':
			$id = (int)$_GET['id'];
			ToDo::archive($id);
			break;
			
		case 'delete':
			$id = (int)$_GET['id'];
			ToDo::delete($id);
			break;
			
		case 'rearrange':
			ToDo::rearrange($_GET['positions']);
			break;
			
		case 'edit':
			$id = (int)$_GET['id'];
			ToDo::edit($id,$_GET['text']);
			break;
			
		case 'new':
			$date_today=$_GET['date'];
			ToDo::createNew($date_today,$_GET['text']);
			break;
		
		case 'edit_date':
			$id = (int)$_GET['id'];
			ToDo::edit_date($id , $_GET['date']);
			break;
		
		case 'restore':
			$id = (int)$_GET['id'];
			ToDo::restore($id);
			break;
			
	}

}
catch(Exception $e){
//	echo $e->getMessage();
	die("0");
}

echo "1";
?>
