<?php
/**
 * @link https://www.boxmoe.com
 * @package lolimeow
 */
function custom_admin_styles() {
    echo '<style>
        .avatar{width: 60px;height: 60px;}
    </style>';
}
add_action('admin_head', 'custom_admin_styles');
function boxmoe_options_menu_filter($menu) {
	$menu['mode'] = 'menu';
	$menu['page_title'] = 'Boxmoe主题设置';
	$menu['menu_title'] = 'Boxmoe主题设置';
	$menu['menu_slug'] = 'boxmoe-options';
	$menu['icon_url'] = 'dashicons-admin-generic';
	$menu['position'] = '61';
	return $menu;
}
add_filter('optionsframework_menu', 'boxmoe_options_menu_filter');
//自动给修改网站登陆页面logo
function customize_login_logo(){         
    echo '<style type="text/css">
        .login{position: relative;width: 100%;background: rgba(0, 0, 0, 0) -webkit-linear-gradient(left, #ff5f6d 0%, #ffb270 100%) repeat scroll 0 0;background: rgba(0, 0, 0, 0) linear-gradient(to right, #ff5f6d 0%, #ffb270 100%) repeat scroll 0 0;overflow: hidden;background-size: cover;background-position: center center;z-index: 1;background-image: linear-gradient(to top, #a8edea 0%, #fed6e3 100%);}.login h1 a { background-image:url('.get_template_directory_uri() .'/assets/images/logo.png); width: 180px; max-height: 100px;margin: 20px auto 15px; background-size: contain;background-repeat: no-repeat;background-position: center center;}
		.login form{border-radius: 10px;}
        </style>';   
  
}  
add_action('login_head', 'customize_login_logo');   

add_filter( 'login_headerurl', 'custom_loginlogo_url' );
function custom_loginlogo_url($url) {
    return '';
}

// 后台Ctrl+Enter提交评论回复
add_action('admin_footer', '_admin_comment_ctrlenter');
function _admin_comment_ctrlenter() {
	echo '<script type="text/javascript">
        jQuery(document).ready(function($){
            $("textarea").keypress(function(e){
                if(e.ctrlKey&&e.which==13||e.which==10){
                    $("#replybtn").click();
                }
            });
        });
    </script>';
};
//版权信息
function example_footer_admin () {
echo '<span id="footer-thankyou">感谢使用<a target="_blank" href="https://cn.wordpress.org/">WordPress</a>进行创作。Theme by <a target="_blank" href="https://www.boxmoe.com/" style="color:red;">Lolimeow</a></span> ';
}
add_filter('admin_footer_text', 'example_footer_admin');
//编辑器TinyMCE增强
function enable_more_buttons($buttons)
{
	$buttons[] = 'hr';
	$buttons[] = 'del';
	$buttons[] = 'sub';
	$buttons[] = 'sup';
	$buttons[] = 'fontselect';
	$buttons[] = 'fontsizeselect';
	$buttons[] = 'cleanup';
	$buttons[] = 'styleselect';
	$buttons[] = 'wp_page';
	$buttons[] = 'anchor';
	$buttons[] = 'backcolor';
	return $buttons;
}
add_filter("mce_buttons_3", "enable_more_buttons");


?>