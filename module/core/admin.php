<?php
/**
 * @link https://www.boxmoe.com
 * @package lolimeow
 */
//=======安全設定，阻止直接訪問主題檔案=======
if (!defined('ABSPATH')) {echo'看你的姊妹';exit;}
//=========================================

// 自訂後台樣式
function custom_admin_styles() {
    echo '<style>
        .avatar{width: 60px;height: 60px;}
    </style>';
}
add_action('admin_head', 'custom_admin_styles');

// 自訂主題選單過濾器
function boxmoe_options_menu_filter($menu) {
	$menu['mode'] = 'menu';
	$menu['page_title'] = 'Boxmoe 主題設定';
	$menu['menu_title'] = 'Boxmoe 主題設定';
	$menu['menu_slug'] = 'boxmoe-options';
	$menu['icon_url'] = 'dashicons-admin-generic';
	$menu['position'] = '61';
	return $menu;
}
add_filter('optionsframework_menu', 'boxmoe_options_menu_filter');

// 後台 Ctrl+Enter 提交評論回覆
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
}

// 自訂後台版權訊息
function example_footer_admin () {
echo '<span id="footer-thankyou">感謝使用 <a target="_blank" href="https://tw.wordpress.org/">WordPress</a> 進行創作。主題由 <a target="_blank" href="https://www.boxmoe.com/" style="color:red;">Lolimeow</a> 提供</span>';
}
add_filter('admin_footer_text', 'example_footer_admin');

// 增強 TinyMCE 編輯器功能
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
