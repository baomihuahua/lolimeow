<?php
/**
 * @link https://www.boxmoe.com
 * @package lolimeow
 */
 
//使用默认编辑器
if( get_boxmoe('gutenberg_off') ) {
	add_filter('use_block_editor_for_post', '__return_false');
	remove_action( 'wp_enqueue_scripts', 'wp_common_block_scripts_and_styles' );// 禁止前端加载样式文件
}

//禁用小工具区块
add_filter( 'gutenberg_use_widgets_block_editor', '__return_false' );
add_filter( 'use_widgets_block_editor', '__return_false' );
//禁用global-styles-inline-css
add_action('wp_enqueue_scripts', 'fanly_remove_styles_inline');
	function fanly_remove_styles_inline(){
	wp_deregister_style( 'global-styles' );
	wp_dequeue_style( 'global-styles' );
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
	wp_dequeue_style( 'wp-block-style' );
	}
if( get_boxmoe('wpheader_on') ) {
remove_action( 'wp_head', 'index_rel_link' );//去除本页唯一链接信息
remove_action('wp_head', 'parent_post_rel_link', 10, 0 );//清除前后文信息
remove_action('wp_head', 'start_post_rel_link', 10, 0 );//清除前后文信息
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
remove_action( 'wp_head', 'locale_stylesheet' );
remove_action('publish_future_post','check_and_publish_future_post',10, 1 );
remove_action( 'wp_head', 'noindex', 1 );
remove_action( 'wp_head', 'wp_print_styles', 8 );//载入css
remove_action( 'wp_head', 'wp_print_head_scripts', 9 );
remove_action( 'wp_head', 'wp_generator' ); //移除WordPress版本
remove_action( 'template_redirect', 'wp_shortlink_header', 11, 0 );
remove_action( 'wp_head', 'rsd_link' );
remove_action('wp_head','wlwmanifest_link');//移除head中的rel="wlwmanifest"
remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );
remove_action( 'wp_head', 'rel_canonical' );
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
add_action('widgets_init', 'my_remove_recent_comments_style');
function my_remove_recent_comments_style() {
global $wp_widget_factory;
remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'] ,'recent_comments_style'));
} 
}
if( get_boxmoe('wpheader_on_1') ) {
	remove_action( 'wp_head', 'wp_enqueue_scripts', 1 );
	remove_action( 'wp_footer', 'wp_print_footer_scripts' );
}	
//移除feed
if(get_boxmoe('feed_off')) {
remove_action( 'wp_head', 'feed_links', 2 ); 
remove_action( 'wp_head', 'feed_links_extra', 3 ); 
}
// 移除 Emoji
if(get_boxmoe('emoji_off')) {
function disable_emojis() {
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );
remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
}
add_action( 'init', 'disable_emojis' );
function disable_emojis_tinymce( $plugins ) {
return array_diff( $plugins, array( 'wpemoji' ) );
}
}

if(get_boxmoe('remove_dns_refresh')) {
	function remove_dns_prefetch( $hints, $relation_type ) {
		if ( 'dns-prefetch' === $relation_type ) {
			return array_diff( wp_dependencies_unique_hosts(), $hints );
		}
		return $hints;
	}
	add_filter( 'wp_resource_hints', 'remove_dns_prefetch', 10, 2 );
}
//禁止加载WP自带的jquery.js
 if ( !is_admin() ) { // 后台不禁止
 function my_init_method() {
 wp_deregister_script( 'jquery' ); // 取消原有的 jquery 定义
 }
 add_action('init', 'my_init_method');
 }
//禁用文章自动保存
if(get_boxmoe('autosaveop')) {
	add_action('wp_print_scripts','disable_autosave');
	function disable_autosave() {
		wp_deregister_script('autosave');
	}
}

//禁用文章修订版本
if(get_boxmoe('revisions_to_keepop')) {
	add_filter( 'wp_revisions_to_keep', 'specs_wp_revisions_to_keep', 10, 2 );
	function specs_wp_revisions_to_keep( $num, $post ) {
		return 0;
	}
}
// 移除 embeds
if(get_boxmoe('embeds_off')) {
function disable_embeds_init() {
	/* @var WP $wp */
	global $wp;
	// Remove the embed query var.
	$wp->public_query_vars = array_diff( $wp->public_query_vars, array(
	'embed',
	) );
	// Remove the REST API endpoint.
	remove_action( 'rest_api_init', 'wp_oembed_register_route' );
	// Turn off
	add_filter( 'embed_oembed_discover', '__return_false' );
	// Don't filter oEmbed results.
	remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );
	// Remove oEmbed discovery links.
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
	// Remove oEmbed-specific JavaScript from the front-end and back-end.
	remove_action( 'wp_head', 'wp_oembed_add_host_js' );
	add_filter( 'tiny_mce_plugins', 'disable_embeds_tiny_mce_plugin' );
	// Remove all embeds rewrite rules.
	add_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );
}
add_action( 'init', 'disable_embeds_init', 9999 );

// Removes the 'wpembed' TinyMCE plugin.
function disable_embeds_tiny_mce_plugin( $plugins ) {
	return array_diff( $plugins, array( 'wpembed' ) );
}
//Remove all rewrite rules related to embeds.
function disable_embeds_rewrites( $rules ) {
	foreach ( $rules as $rule => $rewrite ) {
		if ( false !== strpos( $rewrite, 'embed=true' ) ) {
			unset( $rules[ $rule ] );
		}
	}
	return $rules;
}
//Remove embeds rewrite rules on plugin activation.
function disable_embeds_remove_rewrite_rules() {
	add_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'disable_embeds_remove_rewrite_rules' );

// Flush rewrite rules on plugin deactivation.
function disable_embeds_flush_rewrite_rules() {
	remove_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );
	flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'disable_embeds_flush_rewrite_rules' );
}



// 移除RSS订阅
if(get_boxmoe('rss_off')) {
function disable_our_feeds() {
	wp_die( __('<strong>Error:</strong> 没有RSS订阅,请访问我们的主页！') );
}
add_action('do_feed','disable_our_feeds',1);
add_action('do_feed_rdf','disable_our_feeds',1);
add_action('do_feed_rss','disable_our_feeds',1);
add_action('do_feed_rss2','disable_our_feeds',1);
add_action('do_feed_atom','disable_our_feeds',1);
}
//禁止Pingback
if(get_boxmoe('Pingback_off')) {
add_action('pre_ping', '_noself_ping');
function _noself_ping(&$links) {
	$home = get_option('home');
	foreach ($links as $l => $link) {
		if (0 === strpos($link, $home)) {
			unset($links[$l]);
		}
	}
}
}
//隐藏管理条
function hide_admin_bar($flag) {
	return false;
}
add_filter('show_admin_bar', 'hide_admin_bar');

//移除后台谷歌字体
function remove_open_sans() {
	wp_deregister_style( 'open-sans' );
	wp_register_style( 'open-sans', false );
	wp_enqueue_style('open-sans','');
}
add_action( 'init', 'remove_open_sans' );

//Gravatar头像加速
function boxmoe_getavatar_host() {
	$gravatarUrl = 'gravatar.loli.net/avatar';
	switch (get_boxmoe('gravatar_url')) {
		case 'cn':
					$gravatarUrl = 'cn.gravatar.com/avatar';
		break;
		case 'ssl':
					$gravatarUrl = 'secure.gravatar.com/avatar';
		break;
		case 'lolinet':
					$gravatarUrl = 'gravatar.loli.net/avatar';
		//break;
		//case 'v2excom':
		//			$gravatarUrl = 'cdn.v2ex.com/gravatar';
		//break;
		case 'qiniu':
					$gravatarUrl = 'dn-qiniu-avatar.qbox.me/avatar';
		break;
		case 'geekzu':
					$gravatarUrl = 'fdn.geekzu.org/avatar';
		break;
		case 'cravatar':
					$gravatarUrl = 'cravatar.cn/avatar';
		break;
		default:
					$gravatarUrl = 'cravatar.cn/avatar';
	}
	return $gravatarUrl;
}
//function boxmoe_get_avatar($avatar) {
//	$avatar = str_replace(array("www.gravatar.com/avatar","0.gravatar.com/avatar","1.gravatar.com/avatar","2.gravatar.com/avatar","secure.gravatar.com/avatar"), boxmoe_getavatar_host(), $avatar);
//	return $avatar;
//}
//add_filter( 'get_avatar', 'boxmoe_get_avatar', 10, 3 );

//QQ头像节点
function boxmoe_qqavatar_host() {
	$qqravatarUrl = 'q2.qlogo.cn';
	switch (get_boxmoe('qqavatar_url')) {
		case 'Q1':
					$qqravatarUrl = 'q1.qlogo.cn';
		break;
		case 'Q2':
					$qqravatarUrl = 'q2.qlogo.cn';
		break;
		case 'Q3':
					$qqravatarUrl = 'q3.qlogo.cn';
		break;
		case 'Q4':
					$qqravatarUrl = 'q4.qlogo.cn';
		default:
					$qqravatarUrl = 'q2.qlogo.cn';
	}
	return $qqravatarUrl;
}

add_filter('get_avatar', 'boxmoe_qq_avatar', 10, 2);
function boxmoe_qq_avatar($avatar,$id_or_email){
    $email = '';
	if (is_numeric($id_or_email)){
		$id = (int)$id_or_email;
		$user = get_userdata($id);
		if ($user)
			$email = $user->user_email;
	    }else if(is_object($id_or_email)){
		if (!empty($id_or_email->user_id)){
			$id = (int)$id_or_email->user_id;
			$user = get_userdata($id);
			if ($user)
				$email = $user->user_email;
		}else if(!empty($id_or_email->comment_author_email)){
			$email = $id_or_email->comment_author_email;
		}
	}else{
		$email = $id_or_email;
	}
	$hash = md5(strtolower(trim($email)));
	$gavatarurl = 'https://'.boxmoe_getavatar_host().'/' . $hash;
	if(stripos($email,"@qq.com"))//判断是否为QQ邮箱
        {
	    $qq=str_ireplace("@qq.com","",$email);
            if(preg_match("/^\d+$/",$qq))//正则过滤英文邮箱
            {
                $qqavatar="https://".boxmoe_qqavatar_host()."/headimg_dl?dst_uin=".$qq."&spec=100";
		return '<img src="'.$qqavatar.'"class="avatar avatar-50 photo" width="50" height="50" alt="avatar" />';
            }else{ //如果是英文QQ邮箱就调用Gravatar头像
		return '<img src="'.$gavatarurl.'"class="avatar avatar-60 photo img-fluid" alt="avatar" />';
            }
         }else{ //不是QQ邮箱
		return '<img src="'.$gavatarurl.'"class="avatar avatar-60 photo img-fluid" alt="avatar" />';
	 }
}


// 自适应图片
function boxmoe_remove_width_height($content){
  preg_match_all('/<[img|IMG].*?src=[\'|"](.*?(?:[\.gif|\.jpg|\.png\.bmp]))[\'|"].*?[\/]?>/', $content, $images);
  if(!empty($images)) {
    foreach($images[0] as $index => $value){
      $new_img = preg_replace('/(width|height)="\d*"\s/', "", $images[0][$index]);
      $content = str_replace($images[0][$index], $new_img, $content);
    }
  }
  return $content;
}
add_filter('the_content', 'boxmoe_remove_width_height', 99);


//移除没有用的元素
add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1);
add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1);
add_filter('page_css_class', 'my_css_attributes_filter', 100, 1);
function my_css_attributes_filter($var) {
    return is_array($var) ? array_intersect($var, array('nav-item','dropdown','dropdown-hover','active')) : ''; //删除当前菜单的四个选择器
}

?>