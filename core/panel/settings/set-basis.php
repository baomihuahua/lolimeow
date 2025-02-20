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
    'name' => __('基础设置', 'ui_boxmoe_com'),
    'icon' => 'dashicons-admin-settings',
    'type' => 'heading');

    $options[] = array(
        'group' => 'start',
		'group_title' => '博客布局效果设置',
		'name' => __('博客布局', 'ui_boxmoe_com'),
		'id' => 'boxmoe_blog_layout',
		'std' => "one",
		'type' => "radio",
		'options' => array(
			'one' => __('单栏布局', 'ui_boxmoe_com'),
			'two' => __('双栏布局', 'ui_boxmoe_com')
		)); 
    $options[] = array(
		'name' => __('布局边框', 'ui_boxmoe_com'),
		'id' => 'boxmoe_blog_border',
		'std' => "default",
		'type' => "radio",
		'options' => array(
			'default' => __('无边框效果', 'ui_boxmoe_com'),
			'border' => __('漫画边框效果', 'ui_boxmoe_com'),
			'shadow' => __('阴影边框效果', 'ui_boxmoe_com'),
			'lines' => __('线条边框效果', 'ui_boxmoe_com')
		));
    $options[] = array(
        'name' => __('懒加载自定义占位图', 'ui_boxmoe_com'), 
        'id' => 'boxmoe_lazy_load_images',
        'std' => $image_path.'loading.gif',
        'class' => '',
        'type' => 'text');   

    $options[] = array(
		'name' => __('页面过度动画', 'ui_boxmoe_com'),
		'id' => 'boxmoe_page_loading_switch',
		'type' => "checkbox",
		'std' => false,
		);    
    $options[] = array(
		'name' => __('网页飘落樱花', 'ui_boxmoe_com'),
		'id' => 'boxmoe_sakura_switch',
		'type' => "checkbox",
		'std' => false,
		);           
    $options[] = array(
        'group' => 'end',
		'name' => __('悼念模式-全站变灰', 'ui_boxmoe_com'),
		'id' => 'boxmoe_body_grey_switch',
		'type' => "checkbox",
		'std' => false,
		);
    $options[] = array(
        'group' => 'start',
        'group_title' => '节日灯笼开关设置',
		'id' => 'boxmoe_festival_lantern_switch',
		'type' => "checkbox",
		'std' => false,
		);
	$options[] = array(
		'name' => __( '灯笼文字(1)', 'ui_boxmoe_com' ),
		'id' => 'boxmoe_lanternfont1',
		'std' => '新',
		'class' => 'mini',
		'type' => 'text');
	$options[] = array(
		'name' => __( '灯笼文字(2)', 'ui_boxmoe_com' ),
		'id' => 'boxmoe_lanternfont2',
		'std' => '春',
		'class' => 'mini',
		'type' => 'text');
	$options[] = array(
		'name' => __( '灯笼文字(3)', 'ui_boxmoe_com' ),
		'id' => 'boxmoe_lanternfont3',
		'std' => '快',
		'class' => 'mini',
		'type' => 'text');
	$options[] = array(
        'group' => 'end',
		'name' => __( '灯笼文字(4)', 'ui_boxmoe_com' ),
		'id' => 'boxmoe_lanternfont4',
		'std' => '乐',
		'class' => 'mini',
		'type' => 'text');      
    $options[] = array(
		'name' => __( 'LOGO设置', 'ui_boxmoe_com' ),
		'id' => 'boxmoe_logo_src',
		'desc' => __(' ', 'ui_boxmoe_com'),
		'std' => $image_path.'logo.png',
		'type' => 'upload');      
    $options[] = array(
		'name' => __( 'Favicon地址', 'ui_boxmoe_com' ),
		'id' => 'boxmoe_favicon_src',
		'std' => $image_path.'favicon.ico',
		'type' => 'upload'); 
    $options[] = array(
		'name' => __('分类链接去除category标识', 'ui_boxmoe_com'),
		'desc' => __('（需主机伪静态，开关都需要 后台导航的 设置>固定链接 点保存一次）', 'ui_boxmoe_com'),
		'id' => 'boxmoe_no_categoty',
		'type' => "checkbox",
		'std' => false,
		);       
    $options[] = array(
        'group' => 'start',
		'group_title' => '网页右侧看板开关',
		'id' => 'boxmoe_lolijump_switch',
		'type' => "checkbox",
		'std' => false,
		); 
	$options[] = array(
        'group' => 'end',
		'name' => __('选择前端看板形象', 'ui_boxmoe_com'),
		'id' => 'boxmoe_lolijump_img',
		'type' => "radio",
		'std' => 'lolisister1',
		'options' => array(
			'lolisister1' => __(' 看板萝莉-姐姐 ', 'ui_boxmoe_com'),
			'lolisister2' => __(' 看板萝莉-妹妹', 'ui_boxmoe_com'),
			'dance' => __(' 看板娘-舞娘娘', 'ui_boxmoe_com'),
			'meow' => __(' 看板娘-喵小娘', 'ui_boxmoe_com'),
			'lemon' => __(' 看板妹-柠檬妹', 'ui_boxmoe_com'),			
			'bear' => __(' 看板熊-熊宝宝', 'ui_boxmoe_com'),
		));

	$options[] = array(
        'group' => 'start',
		'group_title' => '底部设置',
		'name' => __('底部显示页面执行时间', 'ui_boxmoe_com'),
		'desc' => __('（默认关闭，开启后底部显示页面执行时间）', 'ui_boxmoe_com'),
		'id' => 'boxmoe_footer_dataquery_switch',
		'type' => "checkbox",
		'std' => false,
		);	
	$options[] = array(
		'name' => __('网站底部导航链接', 'ui_boxmoe_com'),
		'id' => 'boxmoe_footer_seo',
		'std' => '<li class="nav-item"><a href="'.site_url('/sitemap.xml').'" target="_blank" class="nav-link">网站地图</a></li>'."\n",
		'desc' => __('（网站地图可自行使用sitemap插件自动生成）', 'ui_boxmoe_com'),
		'settings' => array('rows' => 3),
		'type' => 'textarea');
	$options[] = array(
		'name' => __('网站底部自定义信息（如备案号支持HTML代码）', 'ui_boxmoe_com'),
		'id' => 'boxmoe_footer_info',
		'std' => '本站使用Wordpress创作'."\n",
		'settings' => array('rows' => 3),
		'type' => 'textarea');	
    $options[] = array(
		'name' => __('统计代码', 'ui_boxmoe_com'),
		'desc' => __('（底部第三方流量数据统计代码）', 'ui_boxmoe_com'),
		'id' => 'boxmoe_trackcode',
		'std' => '统计代码',
		'settings' => array('rows' => 3),
		'type' => 'textarea');
	$options[] = array(
        'group' => 'end',
		'name' => __('自定义代码', 'ui_boxmoe_com'),
		'desc' => __('（适用于自定义如css js代码置于底部加载）', 'ui_boxmoe_com'),
		'id' => 'boxmoe_diy_code_footer',
		'std' => '',
		'settings' => array('rows' => 3),
		'type' => 'textarea');   
		$options[] = array(
			'group' => 'start',
			'group_title' => '底部运行天数设置',
			'name' => __('底部运行天数开关', 'ui_boxmoe_com'),
			'id' => 'boxmoe_footer_running_days_switch',
			'type' => 'checkbox',
			'std' => false,
		);
		$options[] = array(
			'name' => __('建站时间', 'ui_boxmoe_com'),
			'id' => 'boxmoe_footer_running_days_time',
			'type' => 'text',
			'class' => 'mini',
			'std' => '2025-01-01',
		);
		$options[] = array(
			'name' => __('运行天数自定义文字前缀', 'ui_boxmoe_com'),
			'id' => 'boxmoe_footer_running_days_prefix',
			'type' => 'text',
			'class' => 'small',
			'std' => '本站已稳定运行了',
		);
		$options[] = array(
			'group' => 'end',
			'name' => __('运行天数自定义文字后缀', 'ui_boxmoe_com'),
			'id' => 'boxmoe_footer_running_days_suffix',
			'type' => 'text',
			'class' => 'small',
			'std' => '天',
		);
