<?php
/**
 * @link https://www.boxmoe.com
 * @package lolimeow
 */

//机器人配置

if( get_boxmoe('bot_api') ) {
	//机器人开关全局
	
function request_by_curl($remote_server, $post_string) {  
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
	if(get_boxmoe('bot_api_comment')){
		add_action('comment_post', 'boxmoe_msg_comment', 19, 2);	  
		} 
	
//评论通知
function boxmoe_msg_comment($comment_id){
    $comment = get_comment($comment_id);
    $siteurl = get_bloginfo('url');
    $text = '文章《' . get_the_title($comment->comment_post_ID) . '》有新的评论！';
    $message = $text . "\n" . "作者: $comment->comment_author \n邮箱: $comment->comment_author_email \n评论: $comment->comment_content \n 点击查看：$siteurl/?p=$comment->comment_post_ID#comments";
		if(get_boxmoe('bot_api_server') == 'boe_api_qq' ){
			$apiurl	=	get_boxmoe('bot_api_url');
			$msgqq	=	get_boxmoe('bot_api_qqnum');
			$postdata = http_build_query(array('message' => $message));
			$opts = array('http' =>array(
										'method' => 'POST',
										'header' => 'Content-type: application/x-www-form-urlencoded',
										'content' => $postdata));
			$context = stream_context_create($opts);  
			return $result = file_get_contents(''.$apiurl.'/send_private_msg?user_id='.$msgqq.'', false, $context);
			}
		if(get_boxmoe('bot_api_server') == 'boe_api_dd' ){
			$time    = intval(microtime(true) * 1000);
			$secret  = get_boxmoe('bot_api_ddkey');
			$sign    = urlencode(base64_encode(hash_hmac('sha256', "{$time}\n{$secret}", $secret, true)));
			$apiurl	=	get_boxmoe('bot_api_url').'&timestamp='.$time.'&sign='.$sign;
			$data = array ('msgtype' => 'text','text' => array ('content' => $message));
			$data_string = json_encode($data);
			return $result = request_by_curl($apiurl, $data_string);  
			}
	}
	
//新注册会员通知	
function boxmoe_msg_reguser($user_id='',$user_email=''){	
	$text = '['.get_bloginfo('name').']新会员注册通知！';
	$message = $text . "\n" ."用户名：$user_id \n邮箱:$user_email";
		if(get_boxmoe('bot_api_server') == 'boe_api_qq' ){
			$apiurl	=	get_boxmoe('bot_api_url');
			$msgqq	=	get_boxmoe('bot_api_qqnum');
			$postdata = http_build_query(array('message' => $message));
			$opts = array('http' =>array(
										'method' => 'POST',
										'header' => 'Content-type: application/x-www-form-urlencoded',
										'content' => $postdata));
			$context = stream_context_create($opts);  
			return $result = file_get_contents(''.$apiurl.'/send_private_msg?user_id='.$msgqq.'', false, $context);
			}
		if(get_boxmoe('bot_api_server') == 'boe_api_dd' ){
			$time    = intval(microtime(true) * 1000);
			$secret  = get_boxmoe('bot_api_ddkey');
			$sign    = urlencode(base64_encode(hash_hmac('sha256', "{$time}\n{$secret}", $secret, true)));
			$apiurl	=	get_boxmoe('bot_api_url').'&timestamp='.$time.'&sign='.$sign;
			$data = array ('msgtype' => 'text','text' => array ('content' => $message));
			$data_string = json_encode($data);
			return $result = request_by_curl($apiurl, $data_string);  
			}
}	

	
//机器人开关全局
}


 


