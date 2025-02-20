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
    'name' => __('静态加速', 'ui_boxmoe_com'),
    'icon' => 'dashicons-performance',
    'type' => 'heading'); 
    $options[] = array(
        'group' => 'start',
        'group_title' => '静态资源加速设置项',
        'name' => __('静态资源加速开关', 'ui_boxmoe_com'),
        'id' => 'boxmoe_cdn_assets_switch',
        'type' => "checkbox",
        'std' => false,
        );
    $options[] = array(
        'group' => 'end',
        'name' => __('静态资源加速url', 'ui_boxmoe_com'),
        'id' => 'boxmoe_cdn_assets_url',
        'type' => "text",
        'std' => '',
        'desc' => __('(如https://domain.com/lolimeow/assets)，链接结尾不要带"/"', 'ui_boxmoe_com'),
        );
	$gravatar_array = array(
		'cravatar' => __('cravatar源', 'ui_boxmoe_com'),
        'weavatar' => __('cravatar备用源', 'ui_boxmoe_com'),
		'qiniu' => __('七牛源', 'ui_boxmoe_com'),
		'geekzu' => __('极客源', 'ui_boxmoe_com'),
		'v2excom' => __('v2ex源', 'ui_boxmoe_com'),
		'cn' => __('默认CN源', 'ui_boxmoe_com'),
		'ssl' => __('默认SSL源', 'ui_boxmoe_com'),
	);
    $options[] = array(
        'group' => 'start',
        'group_title' => '前端头像加速服务器',
        'name' => __('Gravatar头像', 'ui_boxmoe_com'),
        'desc' => __('（通过镜像服务器可对gravatar头像进行加速）', 'ui_boxmoe_com'),
        'id' => 'boxmoe_gravatar_url',       
        'std' => 'lolinet',
        'type' => 'select',
        'class' => 'mini', //mini, tiny, small
        'options' => $gravatar_array);
    
    $qqravatar_array = array(
		'Q1' => __('QQ官方服务器1', 'ui_boxmoe_com'),
		'Q2' => __('QQ官方服务器2', 'ui_boxmoe_com'),
		'Q3' => __('QQ官方服务器3', 'ui_boxmoe_com'),
		'Q4' => __('QQ官方服务器4', 'ui_boxmoe_com'),	
	);    
    $options[] = array(
        'name' => __('QQ头像', 'ui_boxmoe_com'),
        'desc' => __('（如果用户是QQ邮箱则调用QQ头像）', 'ui_boxmoe_com'),
        'id' => 'boxmoe_qqavatar_url',
        'group' => 'end',
        'std' => 'Q2',
        'type' => 'select',
        'class' => 'mini', //mini, tiny, small
        'options' => $qqravatar_array);	