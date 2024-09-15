<?php
/**
 * @link https://www.boxmoe.com
 * @package lolimeow
 */
 
//============默认开启项=============
 //隐藏管理条
function hide_admin_bar($flag) {
    return false;
}
add_filter('show_admin_bar', 'hide_admin_bar');

//移除后台谷歌字体
function remove_open_sans() {
    wp_deregister_style('open-sans');
    wp_register_style('open-sans', false);
    wp_enqueue_style('open-sans', '');
}
add_action('init', 'remove_open_sans');

//禁止加载WP自带的jquery.js
if (!is_admin()) { // 后台不禁止
    function my_init_method() {
        wp_deregister_script('jquery'); // 取消原有的 jquery 定义
    }
    add_action('init', 'my_init_method');
}
//============自定义开启项=============

//使用默认编辑器 //禁用小工具区块
if (get_boxmoe('gutenberg_off')) {
    remove_filter('the_content', 'do_blocks', 9);
    remove_action('admin_enqueue_scripts', 'wp_common_block_scripts_and_styles');
    add_filter('gutenberg_use_widgets_block_editor', '__return_false');
    add_filter('use_widgets_block_editor', '__return_false');
    add_filter('use_block_editor_for_post', '__return_false');
    remove_action('wp_enqueue_scripts', 'wp_common_block_scripts_and_styles'); // 禁止前端加载样式文件
    add_action('wp_enqueue_scripts', 'fanly_remove_styles_inline');
    function fanly_remove_styles_inline() {
    wp_deregister_style('global-styles');
    wp_dequeue_style('global-styles');
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('wp-block-style');
    }
}
//移除 WP_Head没用代码
if (get_boxmoe('wpheader_on')) {
    remove_action('wp_head', 'index_rel_link'); //去除本页唯一链接信息
    remove_action('wp_head', 'parent_post_rel_link', 10, 0); //清除前后文信息
    remove_action('wp_head', 'start_post_rel_link', 10, 0); //清除前后文信息
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
    remove_action('wp_head', 'locale_stylesheet');
    remove_action('publish_future_post', 'check_and_publish_future_post', 10, 1);
    remove_action('wp_head', 'noindex', 1);
    remove_action('wp_head', 'wp_generator'); //移除WordPress版本
    remove_action('template_redirect', 'wp_shortlink_header', 11, 0);
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link'); //移除head中的rel="wlwmanifest"
    remove_action('wp_head', 'rest_output_link_wp_head', 10);
    remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
    remove_action('wp_head', 'rel_canonical');
    remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
    add_action('widgets_init', 'my_remove_recent_comments_style');
    function my_remove_recent_comments_style() {
        global $wp_widget_factory;
        if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
            remove_action('wp_head', array(
                $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
                'recent_comments_style'
            ));
        }
    }
    }

//移除dns-prefetch
if (get_boxmoe('remove_dns_refresh')) {
    function remove_dns_prefetch($hints, $relation_type) {
        if ('dns-prefetch' === $relation_type) {
            return array_diff(wp_dependencies_unique_hosts(), $hints);
        }
        return $hints;
    }
    add_filter('wp_resource_hints', 'remove_dns_prefetch', 10, 2);
}

//禁用 XML-RPC 接口
	add_filter('xmlrpc_enabled', '__return_false');
	add_filter('xmlrpc_methods', '__return_empty_array');
	remove_action('xmlrpc_rsd_apis', 'rest_output_rsd');


//移除feed
if (get_boxmoe('feed_off')) {
    remove_action('wp_head', 'feed_links', 2);
    remove_action('wp_head', 'feed_links_extra', 3);
	if(is_feed()){
		if(wpjam_basic_get_setting('disable_feed')){	// 屏蔽站点 Feed
			wp_die('Feed订阅已经关闭, 请直接访问<a href="'.get_bloginfo('url').'">网站首页</a>！', 'Feedoff'	, 200);
		}
	}    
}
// 移除 Emoji
if (get_boxmoe('emoji_off')) {
	add_action('admin_init', function(){
		remove_action('admin_print_scripts',	'print_emoji_detection_script');
		remove_action('admin_print_styles',		'print_emoji_styles');
	});
	remove_action('wp_head',			'print_emoji_detection_script',	7);
	remove_action('wp_print_styles',	'print_emoji_styles');
	remove_action('embed_head',			'print_emoji_detection_script');
	remove_filter('the_content_feed',	'wp_staticize_emoji');
	remove_filter('comment_text_rss',	'wp_staticize_emoji');
	remove_filter('wp_mail',			'wp_staticize_emoji_for_email');
	add_filter('emoji_svg_url',		'__return_false');
	add_filter('tiny_mce_plugins',	function($plugins){
		return array_diff($plugins, ['wpemoji']);
	});
}




//禁用文章自动保存
if (get_boxmoe('autosaveop')) {
    add_action('wp_print_scripts', 'disable_autosave');
    function disable_autosave() {
        wp_enqueue_script('autosave');
    }
}

//禁用文章修订版本
if (get_boxmoe('revisions_to_keepop')) {
    add_filter('wp_revisions_to_keep', 'specs_wp_revisions_to_keep', 10, 2);
    function specs_wp_revisions_to_keep($num, $post) {
        return 0;
    }
}
// 移除 embeds
if (get_boxmoe('embeds_off')) {
    function disable_embeds_init() {
        /* @var WP $wp */
        global $wp;
        // Remove the embed query var.
        $wp->public_query_vars = array_diff($wp->public_query_vars, array(
            'embed'
        ));
        // Remove the REST API endpoint.
        remove_action('rest_api_init', 'wp_oembed_register_route');
        // Turn off
        add_filter('embed_oembed_discover', '__return_false');
        // Don't filter oEmbed results.
        remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
        // Remove oEmbed discovery links.
        remove_action('wp_head', 'wp_oembed_add_discovery_links');
        // Remove oEmbed-specific JavaScript from the front-end and back-end.
        remove_action('wp_head', 'wp_oembed_add_host_js');
        add_filter('tiny_mce_plugins', 'disable_embeds_tiny_mce_plugin');
        // Remove all embeds rewrite rules.
        add_filter('rewrite_rules_array', 'disable_embeds_rewrites');
    }
    add_action('init', 'disable_embeds_init', 9999);
    
    // Removes the 'wpembed' TinyMCE plugin.
    function disable_embeds_tiny_mce_plugin($plugins) {
        return array_diff($plugins, array(
            'wpembed'
        ));
    }
    //Remove all rewrite rules related to embeds.
    function disable_embeds_rewrites($rules) {
        foreach ($rules as $rule => $rewrite) {
            if (false !== strpos($rewrite, 'embed=true')) {
                unset($rules[$rule]);
            }
        }
        return $rules;
    }
    //Remove embeds rewrite rules on plugin activation.
    function disable_embeds_remove_rewrite_rules() {
        add_filter('rewrite_rules_array', 'disable_embeds_rewrites');
        flush_rewrite_rules();
    }
    register_activation_hook(__FILE__, 'disable_embeds_remove_rewrite_rules');
    
    // Flush rewrite rules on plugin deactivation.
    function disable_embeds_flush_rewrite_rules() {
        remove_filter('rewrite_rules_array', 'disable_embeds_rewrites');
        flush_rewrite_rules();
    }
    register_deactivation_hook(__FILE__, 'disable_embeds_flush_rewrite_rules');
}



// 移除RSS订阅
if (get_boxmoe('rss_off')) {
    function disable_our_feeds() {
        wp_die(__('<strong>Error:</strong> 没有RSS订阅,请访问我们的主页！'));
    }
    add_action('do_feed', 'disable_our_feeds', 1);
    add_action('do_feed_rdf', 'disable_our_feeds', 1);
    add_action('do_feed_rss', 'disable_our_feeds', 1);
    add_action('do_feed_rss2', 'disable_our_feeds', 1);
    add_action('do_feed_atom', 'disable_our_feeds', 1);
}
// 屏蔽Trackbacks //禁止Pingback
if (get_boxmoe('Pingback_off')) {
		//彻底关闭 pingback
		add_filter('xmlrpc_methods', function($methods){
			return array_merge($methods, [
				'pingback.ping'						=> '__return_false',
				'pingback.extensions.getPingbacks'	=> '__return_false'
			]);
		});
	//禁用 pingbacks, enclosures, trackbacks
	remove_action('do_pings', 'do_all_pings', 10);
	//去掉 _encloseme 和 do_ping 操作。
	remove_action('publish_post','_publish_post_hook',5);		
    }
    

//移除没有用的元素
add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1);
add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1);
add_filter('page_css_class', 'my_css_attributes_filter', 100, 1);
function my_css_attributes_filter($var) {
    return is_array($var) ? array_intersect($var, array(
        'nav-item',
        'dropdown',
        'dropdown-hover',
        'active'
    )) : ''; //删除当前菜单的四个选择器
}

?>