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
    'name' => __('社交图标', 'ui_boxmoe_com'),
    'icon' => 'dashicons-share',
    'type' => 'heading'); 

    $options[] = array(
        'group' => 'start',
        'group_title' => '社交图标设置',
        'name' => __('QQ', 'ui_boxmoe_com'),
        'id' => 'boxmoe_social_qq',
        'type' => 'text',
        'std' => '10000',
        'class' => 'mini',
        'desc' => __('QQ号，留空则不显示', 'ui_boxmoe_com'),
        );
    $options[] = array(        
        'name' => __('Email', 'ui_boxmoe_com'),
        'id' => 'boxmoe_social_email',
        'type' => 'text',
        'std' => '',
        'desc' => __('Email地址，留空则不显示', 'ui_boxmoe_com'),
        'class' => 'mini',
        );    
    $options[] = array(
        'name' => __('WeChat', 'ui_boxmoe_com'),
        'id' => 'boxmoe_social_wechat',
        'type' => 'text',
        'std' => $image_path.'default-thumbnail.jpg',
        'desc' => __('WeChat二维码链接，留空则不显示', 'ui_boxmoe_com'),
        'class' => '',
        );

    $options[] = array(
        'name' => __('Weibo', 'ui_boxmoe_com'),
        'id' => 'boxmoe_social_weibo',
        'type' => 'text',
        'std' => '',
        'desc' => __('Weibo链接，留空则不显示', 'ui_boxmoe_com'),
        'class' => 'small',
        );   
    $options[] = array(
        'name' => __('Instagram', 'ui_boxmoe_com'),
        'id' => 'boxmoe_social_instagram',
        'type' => 'text',
        'std' => '',
        'desc' => __('Instagram链接，留空则不显示', 'ui_boxmoe_com'),
        'class' => 'small',
        );
    $options[] = array(
        'name' => __('Telegram', 'ui_boxmoe_com'),
        'id' => 'boxmoe_social_telegram',
        'type' => 'text',
        'std' => '',
        'desc' => __('Telegram链接，留空则不显示', 'ui_boxmoe_com'),
        'class' => 'small',
        );
    $options[] = array(
        'group' => 'end',
        'name' => __('GitHub', 'ui_boxmoe_com'),
        'id' => 'boxmoe_social_github',
        'type' => 'text',
        'std' => '',
        'desc' => __('GitHub链接，留空则不显示', 'ui_boxmoe_com'),
        'class' => 'small',
        );