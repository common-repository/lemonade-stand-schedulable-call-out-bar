jQuery(document).ready(function($){
	$('.lemonadestand-main').css('opacity','');
	// Insert New
	$(document).on('click', '.lemonadestand-insertbutton', function(){
		$('.lemonadestand-container').prepend($('.lemonadestand-insert').html());
	});
	// Open Editor
	$(document).on('click', '.lemonadestand-edit', function(){
		$('.lemonadestand-gallery').html('');
		for(var n = 1; n < 120; n++) {
			$('.lemonadestand-gallery').append('<img src="'+$('.lemonadestand-directory').val()+'/images/clipart'+n+'.png">');
		}
		$('.lemonadestand-full').css('display','flex');
		$('.lemonadestand-active').removeClass('lemonadestand-active');
		$(this).parent().addClass('lemonadestand-active');
		$('.lemonadestand-board').html($('.lemonadestand-active').html());
		$('.lemonadestand-control').each(function() {
			$(this).val($('.lemonadestand-board').find('.'+$(this).attr('data-name')).html());
		});
		$('.lemonadestand-scheduleitems').html($('.lemonadestand-active').find('.lemonadestand-schedule').html());
	});
	// Editor Tools
	$(document).on('click', '.lemonadestand-delete', function(){
		$('.lemonadestand-active').remove();
		$('.lemonadestand-full').css('display','none');
		$('.lemonadestand-selectthis').removeClass('lemonadestand-selectthis');
		$('.lemonadestand-deletedate').css('opacity','0.2');
	});
	$(document).on('click', '.lemonadestand-done', function(){
		$('.lemonadestand-board').find('.lemonadestand-schedule').html($('.lemonadestand-scheduleitems').html());
		$('.lemonadestand-active').html($('.lemonadestand-board').html());
		$('.lemonadestand-active').removeClass('lemonadestand-active');
		$('.lemonadestand-full').css('display','none');
		$('.lemonadestand-selectthis').removeClass('lemonadestand-selectthis');
		$('.lemonadestand-deletedate').css('opacity','0.2');
	});
	// Select Dates
	$(document).on('click', '.lemonadestand-sortable', function(){
		if ($(this).hasClass('lemonadestand-selectthis')) {
			$('.lemonadestand-selectthis').removeClass('lemonadestand-selectthis');
			$('.lemonadestand-deletedate').css('opacity','0.2');
		} else {
			$('.lemonadestand-selectthis').removeClass('lemonadestand-selectthis');
			$(this).addClass('lemonadestand-selectthis');
			$('.lemonadestand-deletedate').css('opacity','1');
		}
	});
	// Delete Date
	$(document).on('click', '.lemonadestand-deletedate', function(){
		$('.lemonadestand-selectthis').remove();
		$(this).css('opacity','0.2');
	});
	// Schedule
	$(document).on('click', '.lemonadestand-insertdate', function(){
		if ($('.lemonadestand-control-date').val() !== '') {
			if ($('.lemonadestand-main *').hasClass('lemonadestand-'+$('.lemonadestand-control-date').val())) {
				alert('A Bar is Already Scheduled for '+$('.lemonadestand-control-date').val());
				$('.lemonadestand-control-date').val('');
			} else {
				$('.lemonadestand-scheduleitems').append('<div class="lemonadestand-sortable lemonadestand-'+$('.lemonadestand-control-date').val()+'">'+$('.lemonadestand-control-date').val()+'</div>');
				$('.lemonadestand-scheduleitems').addClass('lemonadestand-success');
				setTimeout(function() {
					$('.lemonadestand-success').removeClass('lemonadestand-success');
				}, 500);
				$('.lemonadestand-control-date').val('');
				$('.lemonadestand-scheduleitems').find('.lemonadestand-sortable').sort(function(a, b) {
				if (a.textContent < b.textContent) {
					return -1;
				} else {
					return 1;
				}
				}).appendTo('.lemonadestand-scheduleitems');
			}
		} else {
			alert('Please select a valid date');
		}
	});
	// Redraw
	$(document).on('change input', '.lemonadestand-control', function(){
		$('.lemonadestand-board').find('.lemonadestand-data').html('');
		$('.lemonadestand-control').each(function() {
			$('.lemonadestand-board').find('.lemonadestand-data').append('<div class="'+$(this).attr('data-name')+'">'+$(this).val()+'</div>');
		});
		$('.lemonadestand-board').find('.lemonadestand-boxcontainer').attr('class','lemonadestand-boxcontainer '+$('.lemonadestand-control-background').val()+' '+$('.lemonadestand-control-radius').val()+' '+$('.lemonadestand-control-animation').val()+' lemonadestand-hue'+$('.lemonadestand-control-hue').val());
		$('.lemonadestand-board').find('.lemonadestand-boxcontainer').attr('data-url',$('.lemonadestand-control-url').val());
		$('.lemonadestand-board').find('.lemonadestand-subheader').html($('.lemonadestand-control-subheader').val());
		$('.lemonadestand-board').find('.lemonadestand-solidbutton').html($('.lemonadestand-control-solidbutton').val());
		if ($('.lemonadestand-control-solidbutton').val() == '') {
			$('.lemonadestand-board').find('.lemonadestand-buttonpanel').addClass('lemonadestand-hidepanel');
		} else {
			$('.lemonadestand-board').find('.lemonadestand-buttonpanel').removeClass('lemonadestand-hidepanel');
		}
	});
	// Gallery Open
	$(document).on('click', '.lemonadestand-insertclipart', function(){
		$('.lemonadestand-gallery').show();
	});
	// Clipart Select
	$(document).on('click', '.lemonadestand-gallery img', function(){
		$('.lemonadestand-gallery').hide();
		$('.lemonadestand-board').find('.lemonadestand-imagebox').attr('src',$(this).attr('src'));
	});
	// Image Upload
	$(document).on('click', '.lemonadestand-insertimage', function(){
		var upload = wp.media({
        title:'Choose Image',
        multiple:false
        })
        .on('select', function(){
            var select = upload.state().get('selection');
            var attach = select.first().toJSON();
            $('.lemonadestand-board').find('.lemonadestand-imagebox').attr('src',attach.url);
        })
        .open();
	});
	/* Save */
	$(document).on('click', '#submit', function(){
		$('.lemonadestand-main').css('opacity','0.2');
		$('.lemonadestand-code').val($('.lemonadestand-container').html());
	});
});