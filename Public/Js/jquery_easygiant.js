<!--

var noSelectedString = "Please select some items";
var doYouConfirmString = "Do you confirm the action: '";
var inputFieldErrorBorderStyle = "2px solid red";
var dataFormat = "dd-mm-yy";

$(document).ready(function(){

	//events binded to the checkbox for bulk selection
	$(".bulk_select_checkbox").click(function(){

		var bulk_select_class = $(this).attr("data-class");
		
		if ($(this).is(":checked"))
		{
			$("." + bulk_select_class).prop('checked', true);
		}
		else
		{
			$("." + bulk_select_class).prop('checked', false);
		}
		
	});
	
	//events binded to the select of bulk actions
	$(".bulk_actions_select").change(function(){
		
		var that = $(this);
		
		var current_URL = that.attr("data-url");
		
		var t_action_readable;
		
		var t_action = $(this).val();
		
		if (t_action != 0)
		{
			var selected_option = $(this).find('option:selected');
			
			var t_class = selected_option.attr('data-class');
			t_action_readable = selected_option.text();
			
			var bulk_values_array = [];
			
			$("." + t_class).each(function(){
			
				var t_type = $(this).attr("type");
				
				if (t_type == "text")
				{
					bulk_values_array.push($(this).attr("data-primary-key") + ":" + $(this).val());
				}
				else if (t_type == "checkbox")
				{
					if ($(this).val() == "")
					{
						if ($(this).prop('checked'))
						{
							bulk_values_array.push($(this).attr("data-primary-key"));
						}
					}
					else
					{
						if ($(this).prop('checked'))
						{
							bulk_values_array.push($(this).attr("data-primary-key") + ":" + $(this).val());
						}
						else
						{
							bulk_values_array.push($(this).attr("data-primary-key") + ":NC");
						}
					}
				}
			});
			
			if (bulk_values_array.length > 0)
			{
				var bulk_values_string = bulk_values_array.join('|');

				var submit = true;
				
				if (selected_option.attr("data-confirm") == "Y")
				{
					if (!window.confirm(doYouConfirmString + t_action_readable + "' ?")) {
						submit = false;
					}
				}
				
				if (submit)
				{
					var formHtml = "<form class='bulk_actions_form' action='"+current_URL+"' method='POST'><input type='hidden' name='bulkActionValues' value='"+bulk_values_string+"' /><input type='hidden' name='bulkAction' value='"+t_action+"' /></form>";
					$("body").append(formHtml);
					$(".bulk_actions_form").submit();
				}
			}
			else
			{
				alert(noSelectedString);
			}
		}
	
		$(".bulk_actions_select option").filter(function() {
			return $(this).val() == "0"; 
		}).prop('selected', true);

	});

	//events binded to alert notices
	$( "div[rel='hidden_alert_notice']" ).each(function(){
		
		var t_name = $(this).text();
		
		var input = $("[name='"+t_name+"']");
		
		if (input.length > 0)
		{
			if (input.attr("type") == "checkbox" || input.attr("type") == "radio" )
			{
				input.parent().css("border",inputFieldErrorBorderStyle);
			}
			else
			{
				input.css("border",inputFieldErrorBorderStyle);
			}
		}
		
	});
	
	//automatically set jQueryUI datepicker
	$( ".date_input" ).datepicker( {
		dateFormat: dataFormat
	} );
});

//-->