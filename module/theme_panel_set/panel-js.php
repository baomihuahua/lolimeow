<?php

add_action( 'optionsframework_custom_scripts', 'optionsframework_custom_scripts' );
function optionsframework_custom_scripts() { ?>
<script type="text/javascript">
jQuery(document).ready(function() {
		jQuery('#music_on').click(function() {
  		jQuery('#section-163_music_id').fadeToggle(400);
	});
	if (jQuery('#music_on:checked').val() !== undefined) {
		jQuery('#section-163_music_id').show();
	}
	
	jQuery('#example_showhidden').click(function() {
  		jQuery('#section-example_text_hidden').fadeToggle(400);
	});
	if (jQuery('#example_showhidden:checked').val() !== undefined) {
		jQuery('#section-example_text_hidden').show();
	}
	jQuery('#style_src_onoff').click(function() {
  		jQuery('#section-style_src').fadeToggle(400);
	});

	if (jQuery('#style_src_onoff:checked').val() !== undefined) {
		jQuery('#section-style_src').show();
	}
	jQuery('#gravatar_onoff').click(function() {
  		jQuery('#section-gravatar_url').fadeToggle(400);
	});

	if (jQuery('#gravatar_onoff:checked').val() !== undefined) {
		jQuery('#section-gravatar_url').show();
	}	
	jQuery('#lolijump').click(function() {
  		jQuery('#section-lolijumpsister').fadeToggle(400);
	});

	if (jQuery('#lolijump:checked').val() !== undefined) {
		jQuery('#section-lolijumpsister').show();
	}
	jQuery('#lolijump').click(function() {
  		jQuery('#section-lolijumptext').fadeToggle(400);
	});

	if (jQuery('#lolijump:checked').val() !== undefined) {
		jQuery('#section-lolijumptext').show();
	}	
	jQuery('#banner_rand').click(function() {
  		jQuery('#section-banner_rand_n').fadeToggle(400);
	});

	if (jQuery('#banner_rand:checked').val() !== undefined) {
		jQuery('#section-banner_rand_n').show();
	}
	jQuery('#banner_api_on').click(function() {
  		jQuery('#section-banner_api_url').fadeToggle(400);
	});

	if (jQuery('#banner_api_on:checked').val() !== undefined) {
		jQuery('#section-banner_api_url').show();
	}	
	jQuery('#open_author_info').click(function() {
  		jQuery('#section-authorinfo').fadeToggle(400);
	});

	if (jQuery('#open_author_info:checked').val() !== undefined) {
		jQuery('#section-authorinfo').show();
	}	
    jQuery('#baidutuisong').click(function() {
  		jQuery('#section-baidutuisongkey').fadeToggle(400);
	});

	if (jQuery('#baidutuisong:checked').val() !== undefined) {
		jQuery('#section-baidutuisongkey').show();
	}	
	jQuery('#sign_f').click(function() {
  		jQuery('#section-reg_question,#section-sign_zhcn,#section-users_login, #section-users_reg, #section-users_reset,#section-users_page, #section-regto, #section-loginto,#section-czcard_src,#section-user_banner_src ').fadeToggle(400);
	});

	if (jQuery('#sign_f:checked').val() !== undefined) {
		jQuery('#section-reg_question,#section-sign_zhcn, #section-users_login, #section-users_reg,#section-users_reset, #section-users_page, #section-regto, #section-loginto,#section-czcard_src,#section-user_banner_src').show();
	}	
	jQuery('#smtpmail').click(function() {
  		jQuery('#section-fromnames,#section-smtphost,#section-smtpprot, #section-smtpusername, #section-smtppassword').fadeToggle(400);
	});

	if (jQuery('#smtpmail:checked').val() !== undefined) {
		jQuery('#section-fromnames,#section-smtphost,#section-smtpprot, #section-smtpusername, #section-smtppassword').show();
	}		
	
	
	
	
});
</script>

<?php
}