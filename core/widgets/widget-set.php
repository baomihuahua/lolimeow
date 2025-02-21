<?php
/**
 * @link https://www.boxmoe.com
 * @package lolimeow
 */
//=======安全设置，阻止直接访问主题文件=======
if (!defined('ABSPATH')) {echo'Look your sister';exit;}
//=========================================
add_action('widgets_init','unregister_d_widget');
function unregister_d_widget(){
    unregister_widget('WP_Widget_Recent_Comments');
}

$widgets = array(
	'ads',
	'postlist',
	'comments',
	'category',
	'archive',
	'tags',
	'userinfo',
	'search',

);

foreach ($widgets as $widget) {
	include 'widget-'.$widget.'.php';
}

add_action( 'widgets_init', 'widget_ui_loader' );
function widget_ui_loader() {
	global $widgets;
	foreach ($widgets as $widget) {
		register_widget( 'widget_'.$widget );
	}
}