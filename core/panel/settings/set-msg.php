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
    'name' => __('通知设置', 'ui_boxmoe_com'),
    'icon' => 'dashicons-admin-users',
    'type' => 'heading'); 
    $options[] = array(
        'name' => __('消息设置说明', 'ui_boxmoe_com'), 
        'id' => 'boxmoe_msg_notice_info',
        'desc' => __('
         <p>1.SMTP发件系统开启需要在SMTP设置中配置SMTP发件信息<span style="color: #0073aa;cursor: pointer;" onclick="window.open(\'admin.php?page=boxmoe-smtp-settings\')">SMTP设置</span></p>
         <p>2.新评论新会员注册通知博主消息，邮件和机器人建议2选1，降低服务器压力，没必要双开双通知</p>			
        ', 'ui_boxmoe_com'),
        'type' => 'info');

    $options[] = array(
        'group' => 'start',
        'group_title' => 'SMTP发件消息通知设置开关',
        'name' => __('SMTP发件系统开关', 'ui_boxmoe_com'),
        'id' => 'boxmoe_smtp_mail_switch',
        'type' => "checkbox",
        'std' => false,
        'desc' => __('开启后检查smtp设置', 'ui_boxmoe_com'),
        );
        $options[] = array(
            'name' => __('新评论通知博主', 'ui_boxmoe_com'),
            'id' => 'boxmoe_new_comment_notice_switch',
            'type' => 'checkbox',
            'std' => false,
            'desc' => __('若开启则新评论通知将使用SMTP发件系统', 'ui_boxmoe_com'),
        );
        $options[] = array(
            'group' => 'end',
            'name' => __('新会员注册通知博主', 'ui_boxmoe_com'),
            'id' => 'boxmoe_new_user_register_notice_switch',
            'type' => 'checkbox',
            'std' => false,
            'desc' => __('若开启则新会员注册通知将使用SMTP发件系统', 'ui_boxmoe_com'),
        );      
        //机器人消息通知
        $options[] = array(
            'group' => 'start',
            'group_title' => '机器人消息通知设置开关',
            'name' => __('机器人消息通知', 'ui_boxmoe_com'),
            'id' => 'boxmoe_robot_notice_switch',
            'type' => 'checkbox',
            'std' => false,
            'desc' => __('若开启则机器人消息通知将使用机器人系统', 'ui_boxmoe_com'),
        );
        //新评论通知
        $options[] = array(
            'name' => __('新评论通知博主', 'ui_boxmoe_com'),
            'id' => 'boxmoe_new_comment_notice_robot_switch',
            'type' => 'checkbox',
            'std' => false,
            'desc' => __('若开启则新评论通知将使用机器人消息通知', 'ui_boxmoe_com'),
        );
        //新会员注册通知
        $options[] = array(
            'group' => 'end',
            'name' => __('新会员注册通知博主', 'ui_boxmoe_com'),
            'id' => 'boxmoe_new_user_register_notice_robot_switch',
            'type' => 'checkbox',
            'std' => false,
            'desc' => __('若开启则新会员注册通知将使用机器人消息通知', 'ui_boxmoe_com'),
        );
        $options[] = array(
            'name' => __('QQ机器人说明', 'ui_boxmoe_com'), 
            'id' => 'boxmoe_robot_notice_info',
            'desc' => __('
             <p>机器人接口基于NapCatQQ开发，需要先安装NapCatQQ，然后获取机器人接口URL</p>		
            ', 'ui_boxmoe_com'),
            'type' => 'info');
        $options[] = array(
            'group' => 'start',
            'group_title' => '机器人接口配置',
            'name' => __('机器人渠道选择', 'ui_boxmoe_com'),
            'id' => 'boxmoe_robot_channel',
            'type' => 'radio',
            'std' => 'qq_user',
            'options' => array(
                'qq_group' => __('QQ群', 'ui_boxmoe_com'),
                'qq_user' => __('个人QQ', 'ui_boxmoe_com'),
                'dingtalk' => __('钉钉', 'ui_boxmoe_com'),
                'telegram' => __('TG', 'ui_boxmoe_com'),
            ), 
        );
        $options[] = array(   
            'name' => __('机器人接口URL', 'ui_boxmoe_com'),
            'id' => 'boxmoe_robot_api_url',
            'type' => 'text',
            'std' => '',
            'desc' => __('请输入机器人接口URL', 'ui_boxmoe_com'),
        );
        $options[] = array(
            'name' => __('机器人接口密钥', 'ui_boxmoe_com'),
            'id' => 'boxmoe_robot_api_key',
            'type' => 'text',
            'class' => 'small',
            'std' => '',
            'desc' => __('请输入机器人接口密钥/TOKEN,留空则不使用', 'ui_boxmoe_com'),
        );
        $options[] = array(
            'group' => 'end',
            'name' => __('消息接受人', 'ui_boxmoe_com'),
            'id' => 'boxmoe_robot_msg_user',
            'class' => 'mini',
            'type' => 'text',
            'std' => '',
            'desc' => __('QQ号码\群号、TG用户\群组\频道ID,留空则不使用', 'ui_boxmoe_com'),
        );


