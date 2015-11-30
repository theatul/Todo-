<?php
/* Defining the ToDo class */
require_once "include.php";
class ToDo
{	
	/* An array that stores the todo item data: */	
	private $data;
	private $type = 1; // 1 Live, 0 deleted
	
	/* The constructor */
	public function __construct($par, $islive)
	{
		$this->type = $islive;
		if(is_array($par))
			$this->data = $par;
	}
	
	/*
		This is an in-build "magic" method that is automatically called 
		by PHP when we output the ToDo objects with echo. 
	*/	
	public function __toString()
	{
		// The string we return is outputted by the echo statement
		//$date_format=date("d-M-Y", strtotime($this->data['lastdate']));
		$date_format = $this->data['lastdate'];
		
		if($this->type == 1)
		{
			return '
				<li class="todo" id='.$this->data['id'].'>		
					<div class="text">'.$this->data['text'].'</div>
					<a class="date_href" href="#">Till '.$date_format.'</a>
					<div class="actions">
						<a href="#" class="archive">Archive</a>
					</div>
					<div class="details" id="single_detail">
						<form>
							<a href="#" class="date_today m-btn ">Today</a>
							<a href="#" class="date_tomorrow m-btn ">Tomorrow</a>
							<div id="date_picker">
								<input class="datepicker" val='.$this->data['lastdate'].' >
							</div>
							<a href="#" class="date_done m-btn red-stripe">I wanna choose this date !</a>
						</form>
					</div>
				</li>';
		}
		else if($this->type == 0)
		{
			return '
				<li class="todo" id='.$this->data['id'].'>		
					<div class="text_archived">'.$this->data['text'].'</div>
					<div class="actions">
						<a href="#" class="delete">Delete</a>
						<a href="#" class="restore">Restore</a>
					</div>
				</li>';
		}
	}
	
	
	/*
		The following are static methods. These are available
		directly, without the need of creating an object.
	*/
	
	
	/*edit date*/
	public static function edit_date($id, $date)
	{
		mysql_query("	UPDATE tz_todo
						SET lastdate='".$date."'
						WHERE id=".$id
					);
		
		if(mysql_affected_rows($GLOBALS['link'])!=1)
			throw new Exception("Couldn't update item!");
	}
	/*
		The edit method takes the ToDo item id and the new text
		of the ToDo. Updates the database.
	*/
		
	public static function edit($id, $text){
		
		$text = self::esc($text);
		if(!$text) throw new Exception("Wrong update text!");
		
		mysql_query("	UPDATE tz_todo
						SET text='".$text."'
						WHERE id=".$id
					);
		
		if(mysql_affected_rows($GLOBALS['link'])!=1)
			throw new Exception("Couldn't update item!");
	}
	
	/*
		The delete method. Takes the id of the ToDo item
		and deletes it from the database.
	*/
	public static function delete($id)
	{
		// Deleting fron database
		mysql_query("DELETE FROM tz_todo WHERE id=".$id);
		if(mysql_affected_rows($GLOBALS['link'])!=1)
			throw new Exception("Couldn't delete item!");
	}
	
	public static function archive($id){
		//just updating the live value
		mysql_query("	UPDATE tz_todo
						SET live=0,
						position=0
						WHERE id=".$id
					);
		
		if(mysql_affected_rows($GLOBALS['link'])!=1)
			throw new Exception("Couldn't archive item!");
	}
	
	public static function restore($id){
		$email=trim($_SESSION['email']);
		if (empty($email))
		{
   			$_SESSION['error'] ="Oops, you are loged out it seems, please login again!!";
			header('Location: index.php');
			flush();
		}
		
		$posResult = mysql_query("SELECT MAX(position)+1 FROM tz_todo where email='".$_SESSION['email']."'");
		if(mysql_num_rows($posResult))
			list($position) = mysql_fetch_array($posResult);

		if(!$position) $position = 1;
		
		
		//just updating the live value
		mysql_query("	UPDATE tz_todo
						SET live=1,
						position=".$position.
						" WHERE id=".$id
					);
					/*
						mysql_query("	UPDATE tz_todo
						SET live=1,
						position=1
						WHERE id=".$id
					);*/
		
		if(mysql_affected_rows($GLOBALS['link'])!=1)
			throw new Exception("Couldn't restore item!");
	}
	/*
		The rearrange method is called when the ordering of
		the todos is changed. Takes an array parameter, which
		contains the ids of the todos in the new order.
	*/
	
	public static function rearrange($key_value){
		
		$updateVals = array();
		foreach($key_value as $k=>$v)
		{
			$strVals[] = 'WHEN '.(int)$v.' THEN '.((int)$k+1).PHP_EOL;
		}
		
		if(!$strVals) throw new Exception("No data!");
		
		// We are using the CASE SQL operator to update the ToDo positions en masse:
		
		mysql_query("	UPDATE tz_todo SET position = CASE id
						".join($strVals)."
						ELSE position
						END");
		
		if(mysql_error($GLOBALS['link']))
			throw new Exception("Error updating positions!");
	}
	
	/*
		The createNew method takes only the text of the todo,
		writes to the databse and outputs the new todo back to
		the AJAX front-end.
	*/
	
	public static function createNew($date_today, $text)
	{
		$email=trim($_SESSION['email']);
		if (empty($email))
		{
   			$_SESSION['error'] ="Oops, you are loged out it seems, please login again!!";
			header('Location: index.php');
			flush();
		}
		
		$text = self::esc($text);
		if(!$text) throw new Exception("Wrong input data!");

		$posResult = mysql_query("SELECT MAX(position)+1 FROM tz_todo where email='".$_SESSION['email']."'");
		
		if(mysql_num_rows($posResult))
			list($position) = mysql_fetch_array($posResult);

		if(!$position) $position = 1;
		// $date = date('d-m-Y');
		mysql_query("INSERT INTO tz_todo SET text='".$text."', position = '".$position."',email = '".$_SESSION['email']."',lastdate='".$date_today."'");
		//mysql_query("INSERT INTO tz_todo SET text='".$text."', position = ".$position);

		if(mysql_affected_rows($GLOBALS['link'])!=1)
			throw new Exception("Error inserting TODO!");
		
		// Creating a new ToDo and outputting it directly:
		echo (new ToDo(array(
			'id'	=> mysql_insert_id($GLOBALS['link']),
			'text'	=> $text,
			'lastdate'=> $date_today
		), 1));
		
		exit;
	}
	
	/*
		A helper method to sanitize a string:
	*/
	
	public static function esc($str){
		
		if(ini_get('magic_quotes_gpc'))
			$str = stripslashes($str);
		
		return mysql_real_escape_string(strip_tags($str));
	}
	
} // closing the class definition

?>
