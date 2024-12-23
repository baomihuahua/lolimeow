<?php
/**
 * @link https://www.boxmoe.com
 * @package lolimeow
 */
//=======安全设置，阻止直接访问主题文件=======
if (!defined('ABSPATH')) {echo'Look your sister';exit;}
//=========================================
?>

<div class="blog-sidebar col-lg-4 fadein-bottom">
<div class="position-sticky top">    
<div class="offcanvas-lg offcanvas-end" id="blog-sidebar" tabindex="-1" aria-labelledby="blog-sidebar">
<div class="offcanvas-header">
<h5 class="offcanvas-title h4" id="blog-sidebar"><?php echo boxmoe_logo(); ?></h5>
<button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#blog-sidebar"></button>
</div>
<div class="offcanvas-body flex-column">	
<?php 
if (function_exists('dynamic_sidebar') && dynamic_sidebar('widget_sitesidebar')) : endif; 

if (is_single()){
	if (function_exists('dynamic_sidebar') && dynamic_sidebar('widget_postsidebar')) : endif; 
}
else if (is_page()){
	if (function_exists('dynamic_sidebar') && dynamic_sidebar('widget_pagesidebar')) : endif; 
}
else if (is_home()){
	if (function_exists('dynamic_sidebar') && dynamic_sidebar('widget_sidebar')) : endif; 
}
?>
</div>
</div>
</div>
</div>
