<?php
/**
 * @link https://www.boxmoe.com
 * @package lolimeow
 */

//boxmoe.com===安全设置=阻止直接访问主题文件
if(!defined('ABSPATH')){
    echo'Look your sister';
    exit;
}

$options[] = array(
    'name' => __('系统优化', 'ui_boxmoe_com'),
    'icon' => 'dashicons-performance',
    'type' => 'heading');
    
    $options[] = array(
        'group' => 'start',
	    'group_title' => '写作类相关开关优化',
        'name' => __('关闭古腾堡编辑器', 'ui_boxmoe_com'),
        'id' => 'boxmoe_gutenberg_switch',
        'type' => "checkbox",
        'std' => false,
        'desc' => __('若开启则关闭古腾堡编辑器', 'ui_boxmoe_com'),
        );
    $options[] = array(
        'name' => __('禁用文章自动保存', 'ui_boxmoe_com'),
        'id' => 'boxmoe_autosave_switch',
        'type' => "checkbox",
        'std' => false,
        'desc' => __('若开启则禁用文章自动保存', 'ui_boxmoe_com'),
        );
    $options[] = array(
        'name' => __('禁用文章修订版本', 'ui_boxmoe_com'),
        'id' => 'boxmoe_revision_switch',
        'type' => "checkbox",
        'std' => false,
        'desc' => __('若开启则禁用文章修订版本', 'ui_boxmoe_com'),
        );
    $options[] = array(
        'group' => 'end',
        'name' => __('禁用XMLRPC接口', 'ui_boxmoe_com'),
        'id' => 'boxmoe_xmlrpc_switch',
        'type' => "checkbox",
        'std' => false,
        'desc' => __('建议开启，若需要使用接口发文章就关闭', 'ui_boxmoe_com'),
        );    
    $options[] = array(
        'group' => 'start',
        'group_title' => 'WP头部底部多余代码移除禁用设置',
        'name' => __('头部代码优化', 'ui_boxmoe_com'),
        'id' => 'boxmoe_wphead_switch',
        'type' => "checkbox",
        'std' => false,
        'desc' => __('建议开启，如果插件前端不能正常使用，请不要开启', 'ui_boxmoe_com'),
        );
    $options[] = array(
        'name' => __('jQuery兼容开关', 'ui_boxmoe_com'),
        'id' => 'boxmoe_jquery_switch',
        'type' => "checkbox",
        'std' => true,
        'desc' => __('默认开启，如果不使用jquery的代码插件可关闭', 'ui_boxmoe_com'),
        );
    $options[] = array(
        'name' => __('移除dns-prefetch', 'ui_boxmoe_com'),
        'id' => 'boxmoe_dns_prefetch_switch',
        'type' => "checkbox",
        'std' => false,
        'desc' => __('建议开启', 'ui_boxmoe_com'),
        );
    $options[] = array(
        'name' => __('移除feed', 'ui_boxmoe_com'),
        'id' => 'boxmoe_feed_switch',
        'type' => "checkbox",
        'std' => false,
        'desc' => __('建议开启', 'ui_boxmoe_com'),
        );
    $options[] = array(
        'name' => __('移除 Emojis', 'ui_boxmoe_com'),
        'id' => 'boxmoe_emojis_switch',
        'type' => "checkbox",
        'std' => false,
        'desc' => __('建议开启', 'ui_boxmoe_com'),
        );
    $options[] = array(
        'group' => 'end',
        'name' => __('移除 embeds', 'ui_boxmoe_com'),
        'id' => 'boxmoe_embeds_switch',
        'type' => "checkbox",
        'std' => false,
        'desc' => __('建议开启', 'ui_boxmoe_com'),
        );
    $options[] = array(
        'group' => 'start',
        'group_title' => '安全项优化设置',
        'name' => __('禁止非管理员访问后台', 'ui_boxmoe_com'),
        'id' => 'boxmoe_no_admin_switch',
        'type' => "checkbox",
        'std' => true,
        'desc' => __('默认开启，则禁止非管理员访问后台', 'ui_boxmoe_com'),
        );
    $options[] = array(     
        'name' => __('优化数据库-自动清理', 'ui_boxmoe_com'),
        'id' => 'boxmoe_optimize_database_switch',
        'type' => "checkbox",
        'std' => false,
        'desc' => __('若开启，则每日0点自动优化数据表', 'ui_boxmoe_com'),
        );
    $options[] = array(
        'name' => __('移除WordPress版本号', 'ui_boxmoe_com'),
        'desc' => __('若开启，则移除WordPress版本号', 'ui_boxmoe_com'),
        'id' => 'boxmoe_remove_wp_version_switch',
        'type' => "checkbox",
        'std' => false,
        );
    $options[] = array(
        'name' => __('禁用REST API', 'ui_boxmoe_com'),
        'desc' => __('若开启，则禁用REST API', 'ui_boxmoe_com'),
        'id' => 'boxmoe_disable_rest_api_switch',
        'type' => "checkbox",
        'std' => false,
        );
    $options[] = array(
        'name' => __('禁止Trackbacks', 'ui_boxmoe_com'),
        'desc' => __('建议开启', 'ui_boxmoe_com'),
        'id' => 'boxmoe_trackbacks_switch',
        'type' => "checkbox",
        'std' => false,
        );
    $options[] = array(
        'group' => 'end',
        'name' => __('禁止Pingback', 'ui_boxmoe_com'),
        'desc' => __('建议开启', 'ui_boxmoe_com'),
        'id' => 'boxmoe_pingbacks_switch',
        'type' => "checkbox",
        'std' => false,
        );