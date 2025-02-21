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

//发件邮件统一模板
function boxmoe_smtp_mail_template($to, $subject, $message) {
    if (!is_email($to)) {
        error_log('错误的邮件地址：' . $to);
        return false;
    }
    if (empty($subject) || empty($message)) {
        error_log('消息错误：消息不能为空');
        return false;
    }
    $from_email = get_option('boxmoe_smtp_from');
    if (!is_email($from_email)) {
        error_log('发件人错误：错误的发件人配置');
        return false;
    }
    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: ' . $from_email . ' <' . $from_email . '>'
    );
    $result = wp_mail($to, $subject, $message, $headers);   
    if (!$result) {
        error_log('邮件发送失败：' . $to);
    }
    return $result;
}

//新用户注册消息通知
function boxmoe_new_user_register($user_id){
    $user = get_user_by('id', $user_id);
    $subject = '[' . get_option('blogname') . '] 有新注册会员！';
    $message = '
    <table style="width:50%;margin: 0 auto;height:100% ">
        <tbody>
            <tr>
                <td>
                    <div style="border-radius: 10px 10px 10px 10px;font-size:13px;color: #555555;width:100%;font-family:\'Century Gothic\',\'Trebuchet MS\',\'Hiragino Sans GB\',微软雅黑,\'Microsoft Yahei\',Tahoma,Helvetica,Arial,\'SimSun\',sans-serif;margin:50px auto;border:1px solid #eee;max-width:100%;background: #ffffff repeating-linear-gradient(-45deg,#fff,#fff 1.125rem,transparent 1.125rem,transparent 2.25rem);box-shadow: 0 1px 5px rgba(0, 0, 0, 0.15);">
                        <div style="width:100%;background:#49BDAD;color:#ffffff;border-radius: 10px 10px 0 0;background-image: -moz-linear-gradient(0deg, rgb(67, 198, 184), rgb(255, 209, 244));background-image: -webkit-linear-gradient(0deg, rgb(67, 198, 184), rgb(255, 209, 244));height: 66px;">
                            <p style="font-size:15px;word-break:break-all;padding: 23px 32px;margin:0;background-color: hsla(0,0%,100%,.4);border-radius: 10px 10px 0 0;">
                                <a style="text-decoration:none;color: #ffffff;" href="' . get_option('home') . '" rel="noopener" target="_blank">
                                     [' . get_option('blogname') . '] </a> 
                                    有新注册会员</p>
                        </div>
                        <div style="margin:40px 30px">
                            <p>新注册会员：</p>
                            <p style="background: #fafafa repeating-linear-gradient(-45deg,#fff,#fff 1.125rem,transparent 1.125rem,transparent 2.25rem);box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);margin:20px 0px;padding:15px;border-radius:5px;font-size:14px;color:#555555;">
                                '. $user->user_login . '<br>
                                '. $user->user_email . '<br>
                                '. $user->user_registered . '<br>
                            </p>
                            <p style="font-size:14px;color:#999;margin-top:30px;border-top:1px solid #eee;padding-top:20px;">
                            此邮件由<a href="' . get_option('home') . '" rel="noopener" target="_blank">' . get_option('blogname') . '</a>系统自动发送，请勿直接回复！</p>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>';

    // 获取管理员邮箱
    $admin_email = get_option('admin_email');
    boxmoe_smtp_mail_template($admin_email, $subject, $message);
}

//评论消息通知
function boxmoe_comment_notification($comment_id){
    $comment = get_comment($comment_id);
    $post = get_post($comment->comment_post_ID);
    $subject = '[' . get_option('blogname') . '] 有新的评论消息！';
    $message = '    <table style="width:70%;margin: 0 auto;height:100% ">
        <tbody>
            <tr>
                <td>
                    <div style="border-radius: 10px 10px 10px 10px;font-size:13px;color: #555555;width:100%;font-family:\'Century Gothic\',\'Trebuchet MS\',\'Hiragino Sans GB\',微软雅黑,\'Microsoft Yahei\',Tahoma,Helvetica,Arial,\'SimSun\',sans-serif;margin:50px auto;border:1px solid #eee;max-width:100%;background: #ffffff repeating-linear-gradient(-45deg,#fff,#fff 1.125rem,transparent 1.125rem,transparent 2.25rem);box-shadow: 0 1px 5px rgba(0, 0, 0, 0.15);">
                        <div style="width:100%;background:#49BDAD;color:#ffffff;border-radius: 10px 10px 0 0;background-image: -moz-linear-gradient(0deg, rgb(67, 198, 184), rgb(255, 209, 244));background-image: -webkit-linear-gradient(0deg, rgb(67, 198, 184), rgb(255, 209, 244));height: 66px;">
                            <p style="font-size:15px;word-break:break-all;padding: 23px 32px;margin:0;background-color: hsla(0,0%,100%,.4);border-radius: 10px 10px 0 0;">
                                <a style="text-decoration:none;color: #ffffff;" href="' . get_option('home') . '" rel="noopener" target="_blank"> 
								[' . get_option('blogname') . '] </a> 
                                有新的评论消息！
                            </p>
                        </div>
                        <div style="margin:40px 30px">
                            <p>' . trim($comment->comment_author) . ' 给您的文章回复如下：</p>
                            <p style="background: #fafafa repeating-linear-gradient(-45deg,#fff,#fff 1.125rem,transparent 1.125rem,transparent 2.25rem);box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);margin:20px 0px;padding:15px;border-radius:5px;font-size:14px;color:#555555;">'. trim($comment->comment_content) . '</p>
                            <p>您可以点击 <a style="text-decoration:none; color:#12addb" href="' . htmlspecialchars(get_comment_link($comment_id)) . '" rel="noopener" target="_blank">查看回复的完整內容 </a>，
                            此邮件由<a href="' . get_option('home') . '" rel="noopener" target="_blank">' . get_option('blogname') . '</a>系统自动发送，请勿直接回复！</p>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>';

    boxmoe_smtp_mail_template($post->post_author, $subject, $message);
}
if(get_boxmoe('boxmoe_new_comment_notice_switch')){
    add_action('comment_post', 'boxmoe_comment_notification');
}

//评论回复消息通知
function boxmoe_comment_reply_notification($comment_id) {
    $comment = get_comment($comment_id);   
    // 基础检查
    if (!$comment || !$comment->comment_parent) {
        return;
    }  
    // 获取父评论
    $parent_comment = get_comment($comment->comment_parent);
    if (!$parent_comment || !is_email($parent_comment->comment_author_email)) {
        return;
    } 
    // 获取文章
    $post = get_post($comment->comment_post_ID);
    if (!$post) {
        return;
    }   
    // 检查评论状态
    if ($comment->comment_approved !== '1') {
        return;
    }   
    $subject = '[' . get_option('blogname') . '] 有新的评论回复消息！';
    $message = '    <table style="width:70%;margin: 0 auto;height:100% ">
        <tbody>
            <tr>
                <td>
                    <div style="border-radius: 10px 10px 10px 10px;font-size:13px;color: #555555;width:100%;font-family:\'Century Gothic\',\'Trebuchet MS\',\'Hiragino Sans GB\',微软雅黑,\'Microsoft Yahei\',Tahoma,Helvetica,Arial,\'SimSun\',sans-serif;margin:50px auto;border:1px solid #eee;max-width:100%;background: #ffffff repeating-linear-gradient(-45deg,#fff,#fff 1.125rem,transparent 1.125rem,transparent 2.25rem);box-shadow: 0 1px 5px rgba(0, 0, 0, 0.15);">
                        <div style="width:100%;background:#49BDAD;color:#ffffff;border-radius: 10px 10px 0 0;background-image: -moz-linear-gradient(0deg, rgb(67, 198, 184), rgb(255, 209, 244));background-image: -webkit-linear-gradient(0deg, rgb(67, 198, 184), rgb(255, 209, 244));height: 66px;">
                            <p style="font-size:15px;word-break:break-all;padding: 23px 32px;margin:0;background-color: hsla(0,0%,100%,.4);border-radius: 10px 10px 0 0;">
                                <a style="text-decoration:none;color: #ffffff;" href="' . get_option('home') . '" rel="noopener" target="_blank"> [' . get_option('blogname') . '] </a> 
                                有新的评论回复消息！
                            </p>
                        </div>
                        <div style="margin:40px 30px">
                            <p>' . trim($comment->comment_author) . ' 给您的回复如下：</p>
                            <p style="background: #fafafa repeating-linear-gradient(-45deg,#fff,#fff 1.125rem,transparent 1.125rem,transparent 2.25rem);box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);margin:20px 0px;padding:15px;border-radius:5px;font-size:14px;color:#555555;">'. trim($comment->comment_content) . '</p>
                            <p>您在《' . get_the_title($comment->comment_post_ID) . '》的原始留言：</p>
                            <p style="background: #fafafa repeating-linear-gradient(-45deg,#fff,#fff 1.125rem,transparent 1.125rem,transparent 2.25rem);box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);margin:20px 0px;padding:15px;border-radius:5px;font-size:14px;color:#555555;">'. trim($parent_comment->comment_content) . '</p>
                            <p>您可以点击 <a style="text-decoration:none; color:#12addb" href="' . htmlspecialchars(get_comment_link($comment_id)) . '" rel="noopener" target="_blank">查看回复的完整內容 </a>，此邮件由<a href="' . get_option('home') . '" rel="noopener" target="_blank">' . get_option('blogname') . '</a>系统自动发送，请勿直接回复！</p>
                            <p style="font-size:14px;color:#999;margin-top:30px;border-top:1px solid #eee;padding-top:20px;">
                            此邮件由<a href="' . get_option('home') . '" rel="noopener" target="_blank">' . get_option('blogname') . '</a>系统自动发送，请勿直接回复！</p>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>';
    boxmoe_smtp_mail_template($parent_comment->comment_author_email, $subject, $message);
}


//找回密码邮件
function boxmoe_reset_password_email($user_login) {
    // 获取用户信息
    $user = get_user_by('login', $user_login);
    if (!$user) {
        return false;
    }
    $key = get_password_reset_key($user);
    if (is_wp_error($key)) {
        return false;
    }
    $user_email = $user->user_email;
    $reset_link = network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login');
    $subject = '[' . get_option('blogname') . '] 密码重置请求';
    $message = '
    <table style="width:70%;margin: 0 auto;height:100%">
        <tbody>
            <tr>
                <td>
                    <div style="border-radius: 10px;font-size:13px;color: #555555;width:100%;font-family:\'Microsoft YaHei\',\'Helvetica Neue\',Arial,sans-serif;margin:50px auto;border:1px solid #eee;max-width:100%;background: #ffffff;box-shadow: 0 1px 5px rgba(0, 0, 0, 0.15);">
                        <div style="width:100%;background:#49BDAD;color:#ffffff;border-radius: 10px 10px 0 0;background-image: linear-gradient(45deg, #43C6B8, #FFD1F4);height: 66px;">
                            <p style="font-size:15px;word-break:break-all;padding: 23px 32px;margin:0;background-color: rgba(255,255,255,0.4);border-radius: 10px 10px 0 0;">
                                <a style="text-decoration:none;color: #ffffff;" href="' . get_option('home') . '" target="_blank">' . get_option('blogname') . '</a> 
                                - 密码重置
                            </p>
                        </div>
                        <div style="margin:40px 30px">
                            <p style="font-size:14px;margin-bottom:20px;">尊敬的 ' . $user->user_login . '：</p>
                            <p style="font-size:14px;margin-bottom:20px;">我们收到了您的密码重置请求。如果这不是您本人的操作，请忽略此邮件。</p>
                            <p style="font-size:14px;margin-bottom:20px;">若要重置密码，请点击下方按钮：</p>
                            <p style="margin-bottom:30px;">
                                <a style="background:#49BDAD;color:#fff;padding:12px 30px;text-decoration:none;border-radius:5px;font-size:14px;display:inline-block;" href="' . $reset_link . '" target="_blank">重置密码</a>
                            </p>
                            <p style="font-size:14px;margin-bottom:20px;">或者复制以下链接到浏览器地址栏：</p>
                            <p style="background:#f7f7f7;padding:12px;border-radius:5px;font-size:12px;margin-bottom:20px;word-break:break-all;color:#666;">' . $reset_link . '</p>
                            <p style="font-size:14px;color:#999;margin-top:30px;border-top:1px solid #eee;padding-top:20px;">
                                此邮件由<a href="' . get_option('home') . '" rel="noopener" target="_blank">' . get_option('blogname') . '</a>系统自动发送，请勿直接回复<br>
                                出于安全考虑，此链接将在24小时后失效
                            </p>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>';
    
    return boxmoe_smtp_mail_template($user_email, $subject, $message);
}

//会员注册成功发生邮件
function boxmoe_new_user_register_email($user_id){
    $user = get_user_by('id', $user_id);
    $subject = '[' . get_option('blogname') . '] 会员注册成功';
    $message = '
    <table style="width:60%;margin: 0 auto;height:100% ">
        <tbody>
            <tr>
                <td>
                    <div style="border-radius: 10px 10px 10px 10px;font-size:13px;color: #555555;width:100%;font-family:\'Century Gothic\',\'Trebuchet MS\',\'Hiragino Sans GB\',微软雅黑,\'Microsoft Yahei\',Tahoma,Helvetica,Arial,\'SimSun\',sans-serif;margin:50px auto;border:1px solid #eee;max-width:100%;background: #ffffff repeating-linear-gradient(-45deg,#fff,#fff 1.125rem,transparent 1.125rem,transparent 2.25rem);box-shadow: 0 1px 5px rgba(0, 0, 0, 0.15);">
                        <div style="width:100%;background:#49BDAD;color:#ffffff;border-radius: 10px 10px 0 0;background-image: -moz-linear-gradient(0deg, rgb(67, 198, 184), rgb(255, 209, 244));background-image: -webkit-linear-gradient(0deg, rgb(67, 198, 184), rgb(255, 209, 244));height: 66px;">
                            <p style="font-size:15px;word-break:break-all;padding: 23px 32px;margin:0;background-color: hsla(0,0%,100%,.4);border-radius: 10px 10px 0 0;">
                                <a style="text-decoration:none;color: #ffffff;" href="' . get_option('home') . '" rel="noopener" target="_blank"> [' . get_option('blogname') . '] </a> 
                                会员注册成功
                            </p>
                        </div>
                        <div style="margin:40px 30px">
                            <p>亲爱的 ' . $user->user_login . '，</p>
                            <p>感谢您在 ' . get_option('blogname') . ' 注册会员。</p>
                            <p>您的会员账号为：' . $user->user_login . '</p>
                            <p>您的会员邮箱为：' . $user->user_email . '</p>
                            <p>请妥善保管您的会员账号和密码，如遗忘密码请在线找回。</p>
                            <p style="font-size:14px;color:#999;margin-top:30px;border-top:1px solid #eee;padding-top:20px;">
                            此邮件由<a href="' . get_option('home') . '" rel="noopener" target="_blank">' . get_option('blogname') . '</a>系统自动发送，请勿直接回复！</p>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>';
    boxmoe_smtp_mail_template($user->user_email, $subject, $message);
}
//add_action('user_register', 'boxmoe_new_user_register_email');  

//验证码注册模板
function boxmoe_verification_code_register_email($email, $verification_code = ''){
    if (func_num_args() === 1 && is_numeric($email)) {
        return;
    }
    $subject = '[' . get_option('blogname') . '] 注册验证码';
    $message = '
    <table style="width:50%;margin: 0 auto;height:100% ">
        <tbody>
            <tr>
                <td>
                    <div style="border-radius: 10px 10px 10px 10px;font-size:13px;color: #555555;width:100%;font-family:\'Century Gothic\',\'Trebuchet MS\',\'Hiragino Sans GB\',微软雅黑,\'Microsoft Yahei\',Tahoma,Helvetica,Arial,\'SimSun\',sans-serif;margin:50px auto;border:1px solid #eee;max-width:100%;background: #ffffff repeating-linear-gradient(-45deg,#fff,#fff 1.125rem,transparent 1.125rem,transparent 2.25rem);box-shadow: 0 1px 5px rgba(0, 0, 0, 0.15);">
                        <div style="width:100%;background:#49BDAD;color:#ffffff;border-radius: 10px 10px 0 0;background-image: -moz-linear-gradient(0deg, rgb(67, 198, 184), rgb(255, 209, 244));background-image: -webkit-linear-gradient(0deg, rgb(67, 198, 184), rgb(255, 209, 244));height: 66px;">
                            <p style="font-size:15px;word-break:break-all;padding: 23px 32px;margin:0;background-color: hsla(0,0%,100%,.4);border-radius: 10px 10px 0 0;">
                                <a style="text-decoration:none;color: #ffffff;" href="' . get_option('home') . '" rel="noopener" target="_blank"> [' . get_option('blogname') . '] </a> 
                                注册验证码
                            </p>
                        </div>
                        <div style="margin:40px 30px">  
                            <p>您的注册验证码是：' . $verification_code . '</p>
                            <p>有效期5分钟。请勿将验证码泄露给他人。</p>
                            <p style="font-size:14px;color:#999;margin-top:30px;border-top:1px solid #eee;padding-top:20px;">
                            此邮件由<a href="' . get_option('home') . '" rel="noopener" target="_blank">' . get_option('blogname') . '</a>系统自动发送，请勿直接回复！</p>
                        </div>
                    </div>  
                </td>
            </tr>
        </tbody>
    </table>';
    return boxmoe_smtp_mail_template($email, $subject, $message);
}




if(get_boxmoe('boxmoe_robot_notice_switch')){
//机器人post接口消息统一模板
function boxmoe_robot_post_template($remote_server, $post_string) {  
    $ch = curl_init();  
    curl_setopt($ch, CURLOPT_URL, $remote_server);
    curl_setopt($ch, CURLOPT_POST, 1); 
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5); 
    curl_setopt($ch, CURLOPT_HTTPHEADER, array ('Content-Type: application/json;charset=utf-8'));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
    curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0); 
    curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $data = curl_exec($ch);
    curl_close($ch);                
    return $data;  
} 

//评论机器人通知
function boxmoe_robot_msg_comment($comment_id){
    $comment = get_comment($comment_id);
    $siteurl = get_bloginfo('url');
    $text = '文章《' . get_the_title($comment->comment_post_ID) . '》有新的评论！';
    $message = $text . "\n" . "作者: $comment->comment_author \n邮箱: $comment->comment_author_email \n评论: $comment->comment_content \n 点击查看：$siteurl/?p=$comment->comment_post_ID#comments";
		if(get_boxmoe('boxmoe_robot_channel') == 'qq_group' ){			
			$msgid	=	get_boxmoe('boxmoe_robot_msg_user');
            $apiurl	=	get_boxmoe('boxmoe_robot_api_url').'/send_private_msg?group_id='.$msgid;
            $data = array ('msgtype' => 'text','text' => array ('content' => $message));
			$data_string = json_encode($data);
			return $result = boxmoe_robot_post_template($apiurl, $data_string);  
			}
        if(get_boxmoe('boxmoe_robot_channel') == 'qq_user' ){			
			$msgid	=	get_boxmoe('boxmoe_robot_msg_user');
            $apiurl	=	get_boxmoe('boxmoe_robot_api_url').'/send_private_msg?user_id='.$msgid;
            $data = array ('msgtype' => 'text','text' => array ('content' => $message));
			$data_string = json_encode($data);
			return $result = boxmoe_robot_post_template($apiurl, $data_string);  
			}    
		if(get_boxmoe('boxmoe_robot_channel') == 'dingtalk' ){
			$time    = intval(microtime(true) * 1000);
			$secret  = get_boxmoe('boxmoe_robot_api_key');
			$sign    = urlencode(base64_encode(hash_hmac('sha256', "{$time}\n{$secret}", $secret, true)));
			$apiurl	=	get_boxmoe('boxmoe_robot_api_url').'&timestamp='.$time.'&sign='.$sign;
			$data = array ('msgtype' => 'text','text' => array ('content' => $message));
			$data_string = json_encode($data);
			return $result = boxmoe_robot_post_template($apiurl, $data_string);  
			}
        if(get_boxmoe('boxmoe_robot_channel') == 'telegram' ){
            $msgid	=	get_boxmoe('boxmoe_robot_msg_user');
            $key_token = get_boxmoe('boxmoe_robot_api_key');
            $apiurl = 'https://api.telegram.org/bot'.$key_token.'/sendMessage';
            $postdata = http_build_query(array('chat_id' => $msgid,'text' => $message));
            return $result = boxmoe_robot_post_template($apiurl, $postdata);  
            }    
	}
    if(get_boxmoe('boxmoe_new_comment_notice_robot_switch')){
        add_action('comment_post', 'boxmoe_robot_msg_comment');
    }

//新注册会员机器人通知	
function boxmoe_robot_msg_reguser($user_id='',$user_email=''){	
	$text = '['.get_bloginfo('name').']新会员注册通知！';
	$message = $text . "\n" ."用户名：$user_id \n邮箱:$user_email";
		if(get_boxmoe('boxmoe_robot_channel') == 'qq_group' ){
			$msgid	=	get_boxmoe('boxmoe_robot_msg_user');
            $apiurl	=	get_boxmoe('boxmoe_robot_api_url').'/send_private_msg?group_id='.$msgid;
            $data = array ('msgtype' => 'text','text' => array ('content' => $message));
			$data_string = json_encode($data);
			return $result = boxmoe_robot_post_template($apiurl, $data_string);  
			}
        if(get_boxmoe('boxmoe_robot_channel') == 'qq_user' ){
			$msgid	=	get_boxmoe('boxmoe_robot_msg_user');
            $apiurl	=	get_boxmoe('boxmoe_robot_api_url').'/send_private_msg?user_id='.$msgid;
            $data = array ('msgtype' => 'text','text' => array ('content' => $message));
			$data_string = json_encode($data);
			return $result = boxmoe_robot_post_template($apiurl, $data_string);  
			$context = stream_context_create($opts);  
			return $result = file_get_contents(''.$apiurl.'/send_private_msg?user_id='.$msgqq.'', false, $context);
			}    
		if(get_boxmoe('boxmoe_robot_channel') == 'dingtalk' ){
			$time    = intval(microtime(true) * 1000);
			$secret  = get_boxmoe('boxmoe_robot_api_key');
			$sign    = urlencode(base64_encode(hash_hmac('sha256', "{$time}\n{$secret}", $secret, true)));
			$apiurl	=	get_boxmoe('boxmoe_robot_api_url').'&timestamp='.$time.'&sign='.$sign;
			$data = array ('msgtype' => 'text','text' => array ('content' => $message));
			$data_string = json_encode($data);
			return $result = boxmoe_robot_post_template($apiurl, $data_string);  
			}
        if(get_boxmoe('boxmoe_robot_channel') == 'telegram' ){
            $msgid = get_boxmoe('boxmoe_robot_msg_user');
            $key_token = get_boxmoe('boxmoe_robot_api_key');
            $apiurl = 'https://api.telegram.org/bot'.$key_token.'/sendMessage';
            $postdata = http_build_query(array('chat_id' => $msgid,'text' => $message));
            return $result = boxmoe_robot_post_template($apiurl, $postdata);  
        }    
}
if(get_boxmoe('boxmoe_new_user_register_notice_robot_switch')){
    add_action('user_register', 'boxmoe_robot_msg_reguser');
}
//机器人开关
}

