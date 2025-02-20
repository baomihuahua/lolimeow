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
    'name' => __('用户设置', 'ui_boxmoe_com'),
    'icon' => 'dashicons-admin-users',
    'type' => 'heading'); 

    $options[] = array(
        'name' => __('开启导航会员注册链接', 'ui_boxmoe_com'),
        'id' => 'boxmoe_sign_in_link_switch',
        'type' => "checkbox",
        'std' => false,
        'desc' => __('若开启则导航栏将显示会员注册链接', 'ui_boxmoe_com'),
        );
    $options[] = array(
        'name' => __('用户登录注册页面背景图', 'ui_boxmoe_com'),
        'id' => 'boxmoe_user_login_bg',
        'type' => 'text',
        'std' => '',
        'desc' => __('（用户登录注册页面背景图，填写图片URL，支持API）', 'ui_boxmoe_com'),
        );    
    $options[] = array(
        'group' => 'start',
        'group_title' => '用户中心链接设置',
        'name' => __('用户中心选择', 'ui_boxmoe_com'),
        'id' => 'boxmoe_user_center_link_page',
        'type' => "select",
        'std' => 'user_center',
        'options' => $options_pages
        );
    $options[] = array(
        'name' => __('注册页面选择', 'ui_boxmoe_com'),
        'id' => 'boxmoe_sign_up_link_page',
        'type' => "select",
        'std' => 'user_center',
        'options' => $options_pages

        );
    $options[] = array(
        'name' => __('登录页面选择', 'ui_boxmoe_com'),
        'id' => 'boxmoe_sign_in_link_page',
        'type' => "select",
        'std' => 'user_center',
        'options' => $options_pages
        );
    $options[] = array(
        'name' => __('重置密码页面选择', 'ui_boxmoe_com'),
        'id' => 'boxmoe_reset_password_link_page',
        'type' => "select",
        'std' => 'user_center',
        'options' => $options_pages
        );
    $options[] = array(
        'group' => 'end',
        'name' => __('前端充值卡购买链接', 'ui_boxmoe_com'), 
        'id' => 'boxmoe_czcard_src',
        'std' => '',
        'desc' => __('（前端用户充值中心，充值卡购买链接）', 'ui_boxmoe_com'),
        'type' => 'text'); 
