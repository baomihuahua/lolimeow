<?php
// 安全设置--------------------------boxmoe.com--------------------------
if(!defined('ABSPATH')){
    echo'Look your sister';
    exit;
}

// 设置菜单--------------------------boxmoe.com--------------------------
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

function boxmoe_admin_style() {
    echo '<style>
	.avatar {width:60px;height:60px;}
    </style>';
}
add_action('admin_head', 'boxmoe_admin_style');

function example_footer_admin () {
	echo '<span id="footer-thankyou">感谢使用<a target="_blank" href="https://cn.wordpress.org/">WordPress</a>进行创作。Theme by <a target="_blank" href="https://www.boxmoe.com/" style="color:red;">Lolimeow</a></span> ';
	}
	add_filter('admin_footer_text', 'example_footer_admin');

function customize_login_logo(){         
echo '<style type="text/css">
.login {display:flex;min-height:100vh;justify-content:center;align-items:center;background:linear-gradient(-45deg,#ee7752,#e73c7e,#23a6d5,#23d5ab);background-size:400% 400%;animation:gradient 15s ease infinite;}
@keyframes gradient {0% {background-position:0% 50%;}
50% {background-position:100% 50%;}
100% {background-position:0% 50%;}
}
#login {background:rgba(255,255,255,0.9);padding:40px 30px;border-radius:15px;box-shadow:0 0 20px rgba(0,0,0,0.1);width:350px;}
@media (max-width:768px) {#login {background:transparent;box-shadow:none;}
}
.login h1 a {background-image:url('.get_template_directory_uri() .'/assets/images/logo.png);width:180px;height:80px;margin:0 auto 20px;background-size:contain;background-repeat:no-repeat;background-position:center center;}
.login form {background:transparent !important;padding:0 !important;border:none !important;box-shadow:none !important;}
.login input[type="text"],.login input[type="password"] {border-radius:5px;border:1px solid #ddd;padding:10px;margin-bottom:15px;}
.wp-core-ui .button-primary {background:#23a6d5;border:none;border-radius:5px;padding:5px 20px;height:auto;transition:all 0.3s ease;}
.wp-core-ui .button-primary:hover {background:#1e8ab0;}
.language-switcher {display:none;}
</style>';   
}  
add_action('login_head', 'customize_login_logo'); 	