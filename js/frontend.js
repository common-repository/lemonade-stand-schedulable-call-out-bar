jQuery(document).ready(function($){
	// Click Bar
	$(document).on('click', '.lemonadestand-boxcontainer', function(){
		if ($(this).attr('data-url') !== '') {
			location.href = $(this).attr('data-url');
		}
	});
	// Mouseover Bar
	$(document).on('mouseover', '.lemonadestand-boxcontainer', function(){
		if ($(this).attr('data-url') !== '') {
			$(this).css('cursor','pointer');
		}
	});
	// Show Bar
	$('.lemonadestand-box').each(function(){
		var d = new Date();
		var currentyear = d.getFullYear();
		if (d.getDate().toString().length == 1) {
			var currentdate = '0'+d.getDate();
		} else {
			var currentdate = d.getDate();
		}
		if ((d.getMonth()+1).toString().length == 1) {
			var currentmonth = '0'+(d.getMonth()+1);
		} else {
			var currentmonth = (d.getMonth()+1);
		}
		var lstodaysdate = 'lemonadestand-'+currentyear + "-" + currentmonth + "-" + currentdate;
		if ($(this).find('.'+lstodaysdate).length) {
			$(this).show();
			return false;
		}
	});
});