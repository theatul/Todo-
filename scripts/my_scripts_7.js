$(document).ready(function()
{

var allTask=0;
var todaysTask=0;
var taskHeadString="allTask";
var date_today=Date.today().toString("d-MMM-yyyy");

//Fadeout the Date details box.	
$(".details").fadeOut(0);


/**********DATE PICKER FUNCTIONS***********/

//show the date picker on click
$(".datepicker").live("click",function()
{
$(this).datepicker({dateFormat: 'd-M-yy'});
$(this).datepicker("show");
});

//update date picker on relode 
$(".datepicker").each( function(i) 
{
	var j_input_date =$(this).attr('val');
	$(this).val(j_input_date);
	allTask++;
	if (date_today==j_input_date)
	{
		todaysTask++;
	}
});

// Select custume date done
$(".date_done").live("click",function(e)
{
	e.preventDefault();
	var parent_top=$(this).parent().parent().parent();
	var parent_id=parent_top.attr('id');
	var date_text=$(this).prev().children().val();

	var old_date = $(parent_top).find('.datepicker').attr('val');

	if(old_date==date_today)
	{	
		//update count
		if(date_text!=date_today)
		{
			todaysTask--;
			update_task_count_link();
		}
	}
	else if(date_text==date_today)
	{
			todaysTask++;
			update_task_count_link();
	}

	$(parent_top).find('.datepicker').attr('val',date_text);

	$(this).update_date_db(parent_id,date_text);
	$(this).update_date_href(parent_top,date_text);
	//slide the window up
	$(this).parent().parent().slideToggle();
});

// select today button
$(".date_today").live("click",function(e)
{
	e.preventDefault();
	var parent_top=$(this).parent().parent().parent();
	var parent_id=parent_top.attr('id');
	
	//update date
	$(this).update_date_db(parent_id,date_today);
	$(this).update_date_href(parent_top,date_today);
	
	var old_date = $(this).parent().find('.datepicker').attr('val');
	if(old_date!=date_today)
	{
		todaysTask++;
		update_task_count_link();
	}
	$(this).parent().find('.datepicker').attr('val', date_today);
	$('this').update_datepicker();

	//slide the window up
	$(this).parent().parent().slideToggle();
});

// select tommorrow button
$(".date_tomorrow").live("click",function(e)
{
	e.preventDefault();
	var parent_top=$(this).parent().parent().parent();
	var parent_id=parent_top.attr('id');
	
	var date_tomorrow=Date.today().add(1).days().toString("dd-MMM-yyyy");
	
	//update date
	$(this).update_date_db(parent_id,date_tomorrow);
	$(this).update_date_href(parent_top,date_tomorrow);

	//update count
	var old_date = $(this).parent().find('.datepicker').attr('val');
	if(old_date==date_today)
	{
		todaysTask--;
		update_task_count_link();
	}
	$(this).parent().find('.datepicker').attr('val', date_tomorrow);
	$('this').update_datepicker();
	
	//slide the window up
	$(this).parent().parent().slideToggle();
});

// select date href
$(".date_href").live("click",function(e)
{	
	$(this).parent().find('#single_detail').slideToggle();
	e.preventDefault();
	
});


//change color for today's task
$.fn.update_date_href_color = function()
{
	$(".date_href").each( function(i) 
	{
		var j_input_date =$(this).text();
		j_input_date=j_input_date.replace('Till ','');
		if (date_today==j_input_date)
		{
		 	$(this).css("color","#800517");
		}
		else
		{
			$(this).css("color","#CECB8A");
		}
	});
}

$(this).update_date_href_color();

//update date href when date is choosen 
$.fn.update_date_href = function(parent_top, date)
{
	parent_top.find(".date_href").text('Till '+date);
	$(this).update_date_href_color();
}

//update date in db
$.fn.update_date_db = function(parent_id, date)
{
	$.get("ajax.php",{'action':'edit_date','id':parent_id,'date':date})
}

//update date picker when date is changed
$.fn.update_datepicker = function()
{
	//update date picker
	$(".datepicker").each( function(i)  //remove this and put something optimal
	{
		var j_input_date =$(this).attr('val');
		$(this).val(j_input_date);
	});
}

/************SELECT TASK VIEW****************/



var update_task_count_link = function()
{ 
	$("#allTask").text("All tasks ("+allTask+")");
	$("#todaysTask").text("Today's tasks ("+todaysTask+")");

	if(taskHeadString=="allTask")
	{
		$("#taskHead").text("All tasks ("+allTask+")");
	}
	else
	{
		$("#taskHead").text("Today's tasks ("+todaysTask+")");
	}
	$("#taskHead").append($('<span class="caret"></span>'));
}



// update on load
update_task_count_link();



// update view of all tasks
$("#allTask").live("click",function()
{
	$(".datepicker").each( function(i) 
	{
		var parent_top=$(this).parent().parent().parent().parent();
		
		var number = 1 + Math.floor(Math.random() * 2);
		switch(number)
		{
			case 1:
				//go to left	
				$(parent_top).animate({left:"+=120%"},200);
				$(parent_top).fadeIn(100);
				$(parent_top).animate({left:"-=120%"},200);
			break;

			case 2:
				//go to right
				$(parent_top).animate({left:"-=60%"},200);
				$(parent_top).fadeIn(100);
				$(parent_top).animate({left:"+=60%"},200);
			break;
		}
	});

	$(this).parent().parent().parent().find("#taskHead").text("All tasks ("+allTask+")");
	$(this).parent().parent().parent().find("#taskHead").append($('<span class="caret"></span>'));
	taskHeadString="allTask";
});

// Update view for todays task only
$("#todaysTask").live("click",function()
{
	 $(".datepicker").each( function(i) 
	 {
		var j_input_date =$(this).attr('val');
		if (Date.today().toString("d-MMM-yyyy")!=j_input_date)
		{
			var parent_top=$(this).parent().parent().parent().parent();
			var number = 1 + Math.floor(Math.random() * 2);
			switch(number)
			{
				case 1:
					//go to left	
					$(parent_top).animate({left:"+=120%"},200);
					$(parent_top).animate({left:"-=120%"},200);
					$(parent_top).fadeOut();
				break;

				case 2:
					//go to right
					$(parent_top).animate({left:"-=60%"},200);
					$(parent_top).animate({left:"+=60%"},200);
					$(parent_top).fadeOut();
				break;
			}
		
		}
		else
		{
			var parent_top=$(this).parent().parent().parent().parent();
			var number = 1 + Math.floor(Math.random() * 2);
			switch(number)
			{
				case 1:
					//go to left	
					$(parent_top).animate({left:"+=120%"},200);
					$(parent_top).fadeIn(100);
					$(parent_top).animate({left:"-=120%"},200);
				break;
	
				case 2:
					//go to right
					$(parent_top).animate({left:"-=60%"},200);
					$(parent_top).fadeIn(100);
					$(parent_top).animate({left:"+=60%"},200);
				break;
			}
		}
	});

	$(this).parent().parent().parent().find("#taskHead").text("Today's tasks ("+todaysTask+")");
	$(this).parent().parent().parent().find("#taskHead").append($('<span class="caret"></span>'));
	taskHeadString="todaysTask";
});

/*
// Update view for todays task only
$("#deletedTask").live("click",function()
{
	//alert("deletedTask");
	 $(".datepicker").each( function(i) 
	 {
			var parent_top=$(this).parent().parent().parent().parent();
			var number = 1 + Math.floor(Math.random() * 2);
			switch(number)
			{
				case 1:
					//go to left	
					$(parent_top).animate({left:"+=120%"},200);
					$(parent_top).animate({left:"-=120%"},200);
					$(parent_top).fadeOut();
				break;

				case 2:
					//go to right
					$(parent_top).animate({left:"-=60%"},200);
					$(parent_top).animate({left:"+=60%"},200);
					$(parent_top).fadeOut();
				break;
			}
	});

	$(this).parent().parent().parent().find("#taskHead").text("Deleted tasks ("+todaysTask+")");
	$(this).parent().parent().parent().find("#taskHead").append($('<span class="caret"></span>'));
	taskHeadString="deletedTask";
});
*/
/******TASK ADD AND EDIT********/

// add a task
$('a.add').click(function(e)
{
	$("#body").css("cursor", "progress");
	var text_data=$("#task_box").val();
	$.get("ajax.php",{'action':'new','text':text_data,'rand':Math.random(), 'date':date_today},function(msg)
	{
		$("#task_box").val('');
		$("#task_box").css("cursor", "auto");
		
		// Appending the new todo and fading it into view:
		$('.todoList').prepend($(msg).hide().fadeIn());
		
		$('this').update_datepicker();
		$(".details").fadeOut(0);
		$(this).update_date_href_color();
	});
	
	e.preventDefault();

	todaysTask++;
	allTask++;
	update_task_count_link();
});

//add task on key press
$('#task_box').bind('keypress', function(e)
{
	if(e.keyCode==13) //when press enter
	{
			$('a.add').click();
	}
});

//update edited task on enter
$('#item_box').live('keypress', function(e) {
    if(e.keyCode==13) //when press enter
    {
     		$(this).edit();
     }
 });
 
//update edited task on focus lost
$('#item_box').live("blur",function()
{
	 $(this).edit();
});

// update edited changes to DB
$.fn.edit = function()
{ 
    var parent=$(this).parent();
	var temp_text=$(this).val();
	if (temp_text.trim()!="")
	{
		var parent_id=parent.attr('id');
		$.get("ajax.php",{'action':'edit','id':parent_id,'text':temp_text});
		$(parent).find("#item_box").replaceWith($('<div class="text"></div>').text(temp_text));
	}
	else
	{
		alert("OoPs, It's an empty task !!");
	}
}

// Edit a task
$(".text").live("click",function()
{
	var parent=$(this).parent();
	var temp_text=$(this).text();
	$(parent).find(".text").replaceWith($('<input type="text" id=item_box>').val(temp_text));
	$('#item_box').focus();
});

//Delete a task completly
$('.delete').live("click", function (e)
{
	e.preventDefault();
	var parent_id=$(this).closest('.todo').attr("id");
	$.get("ajax.php",{"action":"delete","id":parent_id},function(msg){
			});
	var temp= $(this).parent().parent();
	$(temp).fadeOut("normal",function(){
		$(this).remove();
	});
});

// Restore an archived task
$('.restore').live("click", function (e)
{
	e.preventDefault();
	var parent_id=$(this).closest('.todo').attr("id");
	$.get("ajax.php",{"action":"restore","id":parent_id},function(msg){
			});
	var temp= $(this).parent().parent();
		$(temp).fadeOut("normal",function(){
		$(this).remove();
	});
});


// Archive a task (when completed)
$('.archive').live("click", function (e)
{
	e.preventDefault();
	var parent_id=$(this).closest('.todo').attr("id");
	$.get("ajax.php",{"action":"archive","id":parent_id},function(msg){
			});
				
	var temp= $(this).parent().parent();


/*	var position=$(temp).position();
	var top_animate=500-position.top;
*/	
	//choose randomly which way to fall
	var number = 1 + Math.floor(Math.random() * 5);
	switch(number)
	{
		case 1:
			// first right then fall
			$(temp).animate({left:"+=565px"},400);
			$(temp).animate({top:"+="+400+"px"},500);
		break;
	
		case 2:
			//just fall
			$(temp).animate({top:"+="+400+"px"},500);
		break;
	
		case 3:
			//go to left	
			$(temp).animate({left:"+=1000px"},500);
		break;

		case 4:
			//go to right
			$(temp).animate({left:"-=500px"},500);
		break;

		case 5:
			//disappear
		break;
	}


	if(date_today==($(temp).find('.datepicker').attr('val')))
		todaysTask--;

	allTask--;
	update_task_count_link();

	$(temp).fadeOut("normal",function(){
		$(this).remove();
	});

});

// sort the tasks
$(".todoList").sortable(
{
	axis		: 'y',				// Only vertical movements allowed
	//containment	: 'window',			// Constrained by the window
	update		: function()
	{	
		// The toArray method returns an array with the ids of the todos
		var arr = $(".todoList").sortable('toArray');

		// Saving with AJAX
		$.get('ajax.php',{action:'rearrange',positions:arr.reverse()});
		
	}
});
			
			
			
});//end doc.onready function
