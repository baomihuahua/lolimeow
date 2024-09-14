<?php
/**
 * @link https://www.boxmoe.com
 * @package lolimeow
 */
if( get_boxmoe('smtpmail') ) {
add_action('phpmailer_init', 'mail_smtp');
function mail_smtp( $phpmailer ) {
$phpmailer->FromName = ''.get_boxmoe('fromnames').''; //发件人
$phpmailer->Host = ''.get_boxmoe('smtphost').''; //修改为你使用的SMTP服务器
$phpmailer->Port = ''.get_boxmoe('smtpprot').''; //SMTP端口，开启了SSL加密
$phpmailer->Username = ''.get_boxmoe('smtpusername').''; //邮箱账户   
$phpmailer->Password = ''.get_boxmoe('smtppassword').''; //输入你对应的邮箱密码，这里使用了*代替
$phpmailer->From = ''.get_boxmoe('smtpusername').''; //你的邮箱   
$phpmailer->SMTPAuth = true;   
$phpmailer->SMTPSecure = ''.get_boxmoe('smtpsecure').''; //tls or ssl （port=25留空，465为ssl）
$phpmailer->IsSMTP();
}
}

//修复 WordPress 找回密码提示“抱歉，该key似乎无效”
function reset_password_message( $message, $key ) {
 if ( strpos($_POST['user_login'], '@') ) {
 $user_data = get_user_by('email', trim($_POST['user_login']));
 } else {
 $login = trim($_POST['user_login']);
 $user_data = get_user_by('login', $login);
 }
 $user_login = $user_data->user_login;
 $msg = __('有人要求重设如下帐号的密码：'). "\r\n\r\n";
 $msg .= network_site_url() . "\r\n\r\n";
 $msg .= sprintf(__('用户名：%s'), $user_login) . "\r\n\r\n";
 $msg .= __('若这不是您本人要求的，请忽略本邮件，一切如常。') . "\r\n\r\n";
 $msg .= __('要重置您的密码，请打开下面的链接：'). "\r\n\r\n";
 $msg .= network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') ;
 return $msg;
}
add_filter('retrieve_password_message', 'reset_password_message', null, 2);


























?>