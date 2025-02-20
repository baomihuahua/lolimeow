<?php
// 安全设置--------------------------boxmoe.com--------------------------
if(!defined('ABSPATH')){
    echo'Look your sister';
    exit;
}

// =================默认开启优化项=================

// 隐藏后台工具栏--------------------------boxmoe.com--------------------------
function boxmoe_hide_admin_bar($flag) {
    return false;
}
add_filter('show_admin_bar', 'boxmoe_hide_admin_bar');

// 移除Open Sans字体--------------------------boxmoe.com--------------------------

function boxmoe_remove_open_sans() {
    wp_deregister_style('open-sans');
    wp_register_style('open-sans', false);
    wp_enqueue_style('open-sans', '');
}
add_action('init', 'boxmoe_remove_open_sans');

// 移除jQuery--------------------------boxmoe.com--------------------------
function boxmoe_custom_deregister_jquery() {
    if (!is_admin()) {
        wp_deregister_script('jquery');
    }
}
add_action('wp_enqueue_scripts', 'boxmoe_custom_deregister_jquery', 100);

// 屏蔽6.71新增无用的代码加载在前端--------------------------boxmoe.com--------------------------
function boxmoe_disable_add_auto_sizes( $add_auto_sizes ) {
    return false;
}
add_filter( 'wp_img_tag_add_auto_sizes', 'boxmoe_disable_add_auto_sizes' );

// 删除全局样式内联 CSS--------------------------boxmoe.com--------------------------
function boxmoe_remove_global_inline_css() {
    remove_action('wp_head', 'wp_print_styles');
}
add_action('init', 'boxmoe_remove_global_inline_css');
add_action('after_setup_theme', function() {
    remove_action('wp_enqueue_scripts', 'wp_enqueue_global_styles');
}, 0);
add_action( 'wp_enqueue_scripts', function() {
    wp_dequeue_style( 'global-styles-inline' );
    wp_dequeue_style( 'classic-theme-styles' );
    wp_dequeue_style( 'wp-block-library' );
    wp_dequeue_style( 'wp-block-library-theme' );
    wp_dequeue_style( 'wp-block-style' );
}, 20 );


// =================自定义开启优化项=================

// 禁止非管理员访问后台--------------------------boxmoe.com--------------------------
if(get_boxmoe('boxmoe_no_admin_switch')){
    if ( is_admin() && ( !defined( 'DOING_AJAX' ) || !DOING_AJAX ) ) {
        $current_user = wp_get_current_user();
        if($current_user->roles[0] == get_option('default_role')) {
            wp_safe_redirect( home_url() );
            exit();
        }
    }
}   

// 关闭古藤堡编辑器，使用经典编辑器--------------------------boxmoe.com--------------------------
if(get_boxmoe('boxmoe_gutenberg_switch')){
function boxmoe_disable_gutenberg() {
    remove_filter('the_content', 'do_blocks', 9);
    remove_action('admin_enqueue_scripts', 'wp_common_block_scripts_and_styles');
    add_filter('gutenberg_use_widgets_block_editor', '__return_false');
    add_filter('use_widgets_block_editor', '__return_false');
    add_filter('use_block_editor_for_post', '__return_false');
    remove_action('wp_enqueue_scripts', 'wp_common_block_scripts_and_styles'); 
    add_action('wp_enqueue_scripts', 'fanly_remove_styles_inline');
    function fanly_remove_styles_inline() {
    wp_deregister_style('global-styles');
    wp_dequeue_style('global-styles');
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('wp-block-style');
    }
}
add_action('init', 'boxmoe_disable_gutenberg');
}

// 移除 WP_Head没用代码--------------------------boxmoe.com--------------------------
if(get_boxmoe('boxmoe_wphead_switch')){
function boxmoe_remove_wp_head_unused_code() {
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'feed_links_extra', 3);
    remove_action('wp_head', 'feed_links', 2);
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'rest_output_link_wp_head', 10);
    remove_action('wp_enqueue_scripts', 'wp_enqueue_classic_theme_styles'); 
    remove_action('wp_head', 'rel_canonical');
    remove_action('wp_head', 'wp_shortlink_wp_head');
        add_filter('wp_robots', function($robots) {
        unset($robots['max-image-preview']);
        return $robots;
    }, 20);
}
add_action('init', 'boxmoe_remove_wp_head_unused_code');
}

// 移除dns-prefetch--------------------------boxmoe.com--------------------------
if(get_boxmoe('boxmoe_dns_prefetch_switch')){
function boxmoe_remove_dns_prefetch($hints, $relation_type) {
    if ('dns-prefetch' === $relation_type) {
        return array_diff(wp_dependencies_unique_hosts(), $hints);
    }
    return $hints;
}
add_filter('wp_resource_hints', 'boxmoe_remove_dns_prefetch', 10, 2);
}


// 禁用 XML-RPC 接口--------------------------boxmoe.com--------------------------

if(get_boxmoe('boxmoe_xmlrpc_switch')){
function boxmoe_disable_xmlrpc() {
    add_filter('xmlrpc_enabled', '__return_false');
}
add_action('init', 'boxmoe_disable_xmlrpc');
}


// 移除feed--------------------------boxmoe.com--------------------------
if(get_boxmoe('boxmoe_feed_switch')){
function boxmoe_remove_feed() {
    remove_action('do_feed_rdf', 'do_feed_rdf');
    remove_action('do_feed_rss', 'do_feed_rss');
    remove_action('do_feed_rss2', 'do_feed_rss2');
    remove_action('do_feed_atom', 'do_feed_atom');
}
add_action('init', 'boxmoe_remove_feed');
}


// 禁用Emoji表情--------------------------boxmoe.com--------------------------
if(get_boxmoe('boxmoe_emojis_switch')){
function boxmoe_disable_emojis() {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
}
add_action('init', 'boxmoe_disable_emojis');
}

// 禁用Embeds--------------------------boxmoe.com--------------------------
if(get_boxmoe('boxmoe_embeds_switch')){
function boxmoe_disable_embeds() {
    wp_deregister_script('wp-embed');
}
add_action('init', 'boxmoe_disable_embeds');

function boxmoe_remove_embeds() {
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    remove_action('wp_head', 'wp_oembed_add_host_js');
}
add_action('init', 'boxmoe_remove_embeds');
}

// 移除WordPress版本号--------------------------boxmoe.com--------------------------
if(get_boxmoe('boxmoe_remove_wp_version_switch')){
function boxmoe_remove_wp_version() {
    return '';
}
add_filter('the_generator', 'boxmoe_remove_wp_version');
}


// 禁用文章修订版本--------------------------boxmoe.com--------------------------
if(get_boxmoe('boxmoe_revision_switch')){
function boxmoe_disable_revisions($num, $post) {
    return 0;
}
add_filter('wp_revisions_to_keep', 'boxmoe_disable_revisions', 10, 2);
}


// 禁用文章自动保存--------------------------boxmoe.com--------------------------
if(get_boxmoe('boxmoe_autosave_switch')){
function boxmoe_disable_autosave() {
    wp_deregister_script('autosave');
}
add_action('wp_enqueue_scripts', 'boxmoe_disable_autosave');
}


// 优化数据库自动清理--------------------------boxmoe.com--------------------------
if(get_boxmoe('boxmoe_optimize_database_switch')){
function boxmoe_optimize_database() {
    if (!wp_next_scheduled('boxmoe_optimize_database_event')) {
        $timestamp = strtotime('today 00:00:00') + DAY_IN_SECONDS;
        wp_schedule_event($timestamp, 'daily', 'boxmoe_optimize_database_event');
    }
}
add_action('wp', 'boxmoe_optimize_database');

function boxmoe_run_optimize_database() {
    global $wpdb;
    $wpdb->query("OPTIMIZE TABLE $wpdb->posts");
    $wpdb->query("OPTIMIZE TABLE $wpdb->comments");
    $wpdb->query("OPTIMIZE TABLE $wpdb->options");
}
add_action('boxmoe_optimize_database_event', 'boxmoe_run_optimize_database');
}


// 禁用REST API--------------------------boxmoe.com--------------------------
if(get_boxmoe('boxmoe_disable_rest_api_switch')){
function boxmoe_disable_rest_api() {
    if (!is_user_logged_in()) {
        remove_action('wp_head', 'rest_output_link_wp_head', 10);
        remove_action('template_redirect', 'rest_output_link_header', 11);
    }
}
add_action('init', 'boxmoe_disable_rest_api');
}

// Trackbacks--------------------------boxmoe.com--------------------------
if(get_boxmoe('boxmoe_trackbacks_switch')){
function boxmoe_disable_trackbacks() {
    remove_action('wp_head', 'wp_trackback_header', 10);
}
add_action('init', 'boxmoe_disable_trackbacks');
}

// 禁止Pingback--------------------------boxmoe.com--------------------------
if(get_boxmoe('boxmoe_pingbacks_switch')){
function boxmoe_disable_pingbacks() {
    remove_action('wp_head', 'wp_generator');
}
add_action('init', 'boxmoe_disable_pingbacks');
}







