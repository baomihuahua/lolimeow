/**
 * Custom scripts needed for the colorpicker, image button selectors,
 * and navigation tabs.
 */

jQuery(document).ready(function($) {
$('#versionss').click(function(){
	$("#versionss").val("检测版本中...");	
         $.ajax({
             type: "GET", 
             url: "https://api.boxmoe.com/themeversion/lolimeow2021.txt", 
             data: {}, 
             dataType: "json", 
             success: function(result){ 
             var dataObj = result,
			 con = "";
			 $.each(dataObj, function(index, item){
             con += "<span class=\"boxmoe-versions\">主题名："+item.name+" | ";
			 con += "最新版本："+item.version+" | ";
			 con += "更新链接：<a href='"+item.updateto+"' target='_blank'>点击访问</a></span>";	
             });
             console.log(con);
			 $("#versionss").html(con);

              }
         });
    });
    $('.navbar-toggler-icon').on('click',
    function() {
        $("body").toggleClass('aside-open');
    });    
    
	// Loads the color pickers
	$('.of-color').wpColorPicker();

	// Image Options
	$('.of-radio-img-img').click(function(){
		$(this).parent().parent().find('.of-radio-img-img').removeClass('of-radio-img-selected');
		$(this).addClass('of-radio-img-selected');
	});

	$('.of-radio-img-label').hide();
	$('.of-radio-img-img').show();
	$('.of-radio-img-radio').hide();

	// Loads tabbed sections if they exist
	if ( $('.nav-tab-wrapper').length > 0 ) {
		options_framework_tabs();
	}

	function options_framework_tabs() {

		var $group = $('.group'),
			$navtabs = $('.nav-tab-wrapper a'),
			active_tab = '';

		// Hides all the .group sections to start
		$group.hide();

		// Find if a selected tab is saved in localStorage
		if ( typeof(localStorage) != 'undefined' ) {
			active_tab = localStorage.getItem('active_tab');
		}

		// If active tab is saved and exists, load it's .group
		if ( active_tab != '' && $(active_tab).length ) {
			$(active_tab).fadeIn();
			$(active_tab + '-tab').addClass('nav-tab-active');
		} else {
			$('.group:first').fadeIn();
			$('.nav-tab-wrapper a:first').addClass('nav-tab-active');
		}

		// Bind tabs clicks
		$navtabs.click(function(e) {

			e.preventDefault();

			// Remove active class from all tabs
			$navtabs.removeClass('nav-tab-active');

			$(this).addClass('nav-tab-active').blur();

			if (typeof(localStorage) != 'undefined' ) {
				localStorage.setItem('active_tab', $(this).attr('href') );
			}

			var selected = $(this).attr('href');

			$group.hide();
			$(selected).fadeIn();

		});
	}

});