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
    'name' => __('评论设置', 'ui_boxmoe_com'),
    'icon' => 'dashicons-admin-comments',
    'type' => 'heading');     

    $options[] = array(
        'group' => 'start',
        'group_title' => '评论开关设置',
        'name' => __('全站评论关闭', 'ui_boxmoe_com'),
        'id' => 'boxmoe_comment_switch',
        'type' => "checkbox",
        'std' => false,
        );
    $options[] = array(
        'name' => __('仅登录评论开关', 'ui_boxmoe_com'),
        'id' => 'boxmoe_comment_login_switch',
        'type' => "checkbox",
        'std' => false,
        );
    $options[] = array(
        'name' => __('禁止纯英文评论', 'ui_boxmoe_com'),
        'id' => 'boxmoe_comment_english_switch',
        'type' => "checkbox",
        'std' => false,
        );
    $options[] = array(
        'group' => 'end',
        'name' => __('博主标签自定义', 'ui_boxmoe_com'),
        'id' => 'boxmoe_comment_blogger_tag',
        'type' => "text",
        'std' => '博主',
        'desc' => __('博主标签，留空则显示博主', 'ui_boxmoe_com'),
        'class' => 'mini',
        ); 