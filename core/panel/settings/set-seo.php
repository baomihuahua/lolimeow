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
    'name' => __('SEO优化', 'ui_boxmoe_com'),
    'icon' => 'dashicons-chart-line',
    'type' => 'heading');

    $options[] = array(
        'group' => 'start',
	    'group_title' => '搜索引擎推送设置',
        'name' => __('百度推送开关', 'ui_boxmoe_com'),
        'id' => 'boxmoe_baidu_submit_switch',
        'desc' => __('开启后下方填写百度推送Token Key', 'ui_boxmoe_com'),
        'class' => 'small',
        'type' => "checkbox",
        'std' => false,
        );
    $options[] = array(
	    'id' => 'boxmoe_baidu_token',
	    'std' => '',
        'class' => 'small',
	    'type' => 'text'
        ); 

    $options[] = array(
        'name' => __('Bing推送开关', 'ui_boxmoe_com'),
        'id' => 'boxmoe_bing_submit_switch',
        'desc' => __('开启后下方填写Bing推送API Key', 'ui_boxmoe_com'),
        'type' => "checkbox",
        'std' => false,
        );
    $options[] = array(
	    'id' => 'boxmoe_bing_api_key',
	    'std' => '',
        'class' => 'small',
	    'type' => 'text'
        );   

    $options[] = array(
        'name' => __('360推送开关', 'ui_boxmoe_com'),
        'desc' => __('开启后下方填写360推送API Key', 'ui_boxmoe_com'),
        'id' => 'boxmoe_360_submit_switch',
        'type' => "checkbox",
        'std' => false,
        );
    $options[] = array(
	    'id' => 'boxmoe_360_api_key',
	    'std' => '',
        'class' => 'small',
	    'type' => 'text'
        );
        
    $options[] = array(
        'name' => __('谷歌推送开关', 'ui_boxmoe_com'),
        'id' => 'boxmoe_google_submit_switch',
        'desc' => __('开启后下方填写谷歌推送API Key', 'ui_boxmoe_com'),
        'type' => "checkbox",
        'std' => false,
        );
    $options[] = array(
	    'id' => 'boxmoe_google_api_key',
	    'std' => '',
        'class' => 'small',
	    'group' => 'end',
	    'type' => 'text'
        );

    $options[] = array(
        'group' => 'start',
        'group_title' => '网站头部设置',
        'name' => __('网站标题连接符', 'ui_boxmoe_com'),
        'id' => 'boxmoe_title_link',
        'type' => "text",
        'std' => '-',
        'class' => 'mini',
        'desc' => __('网站标题连接符，默认是"-"', 'ui_boxmoe_com'),
        );
    $options[] = array(
        'name' => __('网站关键词', 'ui_boxmoe_com'),
        'id' => 'boxmoe_keywords',
        'type' => "textarea",
        'settings' => array('rows' => 3),
        'std' => 'wordpress,boxmoe,lolimeow',
        'desc' => __('网站关键词，多个关键词用英文逗号隔开', 'ui_boxmoe_com'),
        );

    $options[] = array(
        'name' => __('网站描述', 'ui_boxmoe_com'),
        'id' => 'boxmoe_description',
        'type' => "textarea",
        'settings' => array('rows' => 3),
        'std' => '这个一个wordpress网站的描述',
        'desc' => __('网站描述', 'ui_boxmoe_com'),
        );

    $options[] = array(
		'name' => __('网站自动添加关键字和描述', 'ui_boxmoe_com'),
		'desc' => __('（开启后所有页面将自动使用主题配置的关键字和描述）', 'ui_boxmoe_com'),
		'id' => 'boxmoe_auto_keywords_description_switch',
		'type' => "checkbox",
		'std' => true,
		);    

    $options[] = array(
        'group' => 'end',
		'name' => __('自定义文章关键字和描述', 'ui_boxmoe_com'),
		'desc' => __('（开启后你需要在编辑文章的时候书写关键字和描述，如果为空，将自动使用主题配置的关键字和描述；开启这个必须开启上面的"网站自动添加关键字和描述"开关）', 'ui_boxmoe_com'),
		'id' => 'boxmoe_post_keywords_description_switch',
		'type' => "checkbox",
		'std' => false,
		);