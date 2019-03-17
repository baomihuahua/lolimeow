<?php

################# 主题优化 ################# 

if(meowdata('wpheaderop')){ 
    remove_action('wp_head', 'feed_links_extra', 3);
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'index_rel_link');
    remove_action('wp_head', 'start_post_rel_link', 10, 0);
    remove_action('wp_head', 'wp_generator');
    remove_action( 'admin_print_scripts' ,	'print_emoji_detection_script');
    remove_action( 'admin_print_styles'  ,	'print_emoji_styles');
    remove_action( 'wp_head'             ,	'print_emoji_detection_script',	7);
    remove_action( 'wp_print_styles'     ,	'print_emoji_styles');
    remove_filter( 'the_content_feed'    ,	'wp_staticize_emoji');
    remove_filter( 'comment_text_rss'    ,	'wp_staticize_emoji');
    remove_filter( 'wp_mail'             ,	'wp_staticize_emoji_for_email');
    add_theme_support( 'post-formats', array( 'aside' ) );
    remove_action('rest_api_init', 'wp_oembed_register_route');
	remove_filter('rest_pre_serve_request', '_oembed_rest_pre_serve_request', 10, 4);
	remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
	remove_filter('oembed_response_data', 'get_oembed_response_data_rich', 10, 4);
	remove_action('wp_head', 'wp_oembed_add_discovery_links');
	remove_action('wp_head', 'wp_oembed_add_host_js');
	remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
}	


if(meowdata('remove_dns_refresh')){
	remove_action( 'wp_head','wp_resource_hints', 2 );
}

//禁用文章自动保存
if(meowdata('autosaveop')){
add_action('wp_print_scripts','disable_autosave');
function disable_autosave(){
wp_deregister_script('autosave');
}
 }
 
//禁用文章修订版本
if(meowdata('revisions_to_keepop')){
add_filter( 'wp_revisions_to_keep', 'specs_wp_revisions_to_keep', 10, 2 );
function specs_wp_revisions_to_keep( $num, $post ) {
return 0;
}
}

//隐藏管理条
function hide_admin_bar($flag) {
	return false;}
add_filter('show_admin_bar', 'hide_admin_bar');

// no self Pingback
add_action('pre_ping', '_noself_ping');
function _noself_ping(&$links) {
	$home = get_option('home');
	foreach ($links as $l => $link) {
		if (0 === strpos($link, $home)) {
			unset($links[$l]);
		}
	}
}



//移除后台谷歌字体
function remove_open_sans() {
    wp_deregister_style( 'open-sans' );
    wp_register_style( 'open-sans', false );
    wp_enqueue_style('open-sans','');
}
add_action( 'init', 'remove_open_sans' );


//移除没有用的元素
add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1);
add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1);
add_filter('page_css_class', 'my_css_attributes_filter', 100, 1);
function my_css_attributes_filter($var) {
    return is_array($var) ? array() : '';
}
//Gravatar头像加速
function mkm_getavatar_host(){
	$gravatarUrl = 'gravatar.loli.net';
	switch (meowdata('mkm_gravatar_url')){
		case 'cn':
			$gravatarUrl = 'cn.gravatar.com';
			break;
		case 'ssl':
			$gravatarUrl = 'secure.gravatar.com';
			break;			
		case 'lolinet':
			$gravatarUrl = 'gravatar.loli.net';
			break;
		case 'v2excom':
			$gravatarUrl = 'cdn.v2ex.com';
			break;	
		default:
			$gravatarUrl = 'gravatar.loli.net';
	}
	return $gravatarUrl;
}

/**
 *替换头像链接 Gravatar host  
 */ 

function mkm_get_avatar($avatar) {
	$avatar = str_replace(array("www.gravatar.com","0.gravatar.com","1.gravatar.com","2.gravatar.com"), mkm_getavatar_host(), $avatar);
return $avatar;
}
add_filter( 'get_avatar', 'mkm_get_avatar', 10, 3 );
?>