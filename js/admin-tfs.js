jQuery(document).ready(function() 
{
	jQuery('.datepicker').datepicker({
		showOtherMonths: true,
		selectOtherMonths: true,
		changeMonth: true,
		changeYear: true,
		dateFormat: "dd/mm/yy",
	});
});