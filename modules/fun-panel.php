<?php
function optionsframework_custom_scripts() { ?>
<script type="text/javascript">
jQuery(document).ready(function() {

	jQuery('#example_showhidden').click(function() {
  		jQuery('#section-example_text_hidden').fadeToggle(400);
	});
	if (jQuery('#example_showhidden:checked').val() !== undefined) {
		jQuery('#section-example_text_hidden').show();
	}
jQuery('#style_src_onoff').click(function() {  		jQuery('#section-style_src').fadeToggle(400);	});	if (jQuery('#style_src_onoff:checked').val() !== undefined) {		jQuery('#section-style_src').show();	}
});
</script>

<?php
}