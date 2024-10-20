<?php
/**
 * @link https://www.boxmoe.com
 * @package lolimeow
 */
session_start();
if ( 'POST' != $_SERVER['REQUEST_METHOD'] ) {
	header('Allow: POST');
	header('HTTP/1.1 405 Method Not Allowed');
	header('Content-Type: text/plain');
	exit;
}

/** Sets up the WordPress Environment. */
require( dirname(__FILE__) . '/../../../../../wp-load.php' ); // 此 comments-ajax.php 位于主题数据夹,所以位置已不同

nocache_headers();

$comment_post_ID = isset($_POST['comment_post_ID']) ? (int) $_POST['comment_post_ID'] : 0;

$post = get_post($comment_post_ID);

if ( empty($post->comment_status) ) {
	do_action('comment_id_not_found', $comment_post_ID);
	err(__('无效的评论状态.', 'Nana')); // 将 exit 改为错误提示
}

// get_post_status() will get the parent status for attachments.
$status = get_post_status($post);

$status_obj = get_post_status_object($status);

if ( !comments_open($comment_post_ID) ) {
	do_action('comment_closed', $comment_post_ID);
	err(__('对不起,评论是关闭的.', 'Nana')); // 将 wp_die 改为错误提示
} elseif ( 'trash' == $status ) {
	do_action('comment_on_trash', $comment_post_ID);
	err(__('无效的评论状态.', 'Nana')); // 将 exit 改为错误提示
} elseif ( !$status_obj->public && !$status_obj->private ) {
	do_action('comment_on_draft', $comment_post_ID);
	err(__('无效的评论状态.', 'Nana')); // 将 exit 改为错误提示
} elseif ( post_password_required($comment_post_ID) ) {
	do_action('comment_on_password_protected', $comment_post_ID);
	err(__('密码保护', 'Nana')); // 将 exit 改为错误提示
} else {
	do_action('pre_comment_on_post', $comment_post_ID);
}

$comment_author       = ( isset($_POST['author']) )  ? trim(strip_tags($_POST['author'])) : null;
$comment_author_email = ( isset($_POST['email']) )   ? trim($_POST['email']) : null;
$comment_author_url   = ( isset($_POST['url']) )     ? trim($_POST['url']) : null;
$comment_content      = ( isset($_POST['comment']) ) ? trim($_POST['comment']) : null;
$edit_id              = ( isset($_POST['edit_id']) ) ? $_POST['edit_id'] : null; // 提取 edit_id

// If the user is logged in
$user = wp_get_current_user();
if ( $user->ID ) {
	if ( empty( $user->display_name ) )
		$user->display_name=$user->user_login;
	$comment_author       = esc_sql($user->display_name);
	$comment_author_email = esc_sql($user->user_email);
	$comment_author_url   = esc_sql($user->user_url);
	if ( current_user_can('unfiltered_html') ) {
		if ( wp_create_nonce('unfiltered-html-comment_' . $comment_post_ID) != $_POST['_wp_unfiltered_html_comment'] ) {
			kses_remove_filters(); // start with a clean slate
			kses_init_filters(); // set up the filters
		}
	}
} else {
	if ( get_option('comment_registration') || 'private' == $status )
		err(__('对不起，您必须登录后才能发表评论。', 'Nana')); // 将 wp_die 改为错误提示
}

$comment_type = '';

if ( '' != $comment_content ) {
    $codetext = '/<(iframe|script)/i';
    if (preg_match($codetext,$comment_content,$matches)) {
    $comment_content = htmlspecialchars($comment_content).'<br />（<font color="red">温馨提示:你的评论含代码内容,已强制转义。</font>）';
 }
}
if ( get_option('require_name_email') && !$user->ID ) {
	if ( 6 > strlen($comment_author_email) || '' == $comment_author )
		err( __('提示：必须填写昵称及邮件。', 'Nana') ); // 将 wp_die 改为错误提示
	elseif ( !is_email($comment_author_email))
		err( __('提示：请输入一个有效的电子邮件地址。', 'Nana') );// 将 wp_die 改为错误提示
	elseif ( mb_strlen($comment_author, 'UTF-8') > 10 ) {
        err( __('提示：昵称长度不能超过10个字符。', 'Nana') );
    }
}

if ( '' == $comment_content )
	err( __('提示：请输入评论内容。', 'Nana') ); // 将 wp_die 改为错误提示

// 增加: 错误提示功能
function err($ErrMsg) {
    header('HTTP/1.1 405 Method Not Allowed');
    echo $ErrMsg;
    exit;
}
//屏蔽纯英文评论和纯日文
function boxmoe_enjpcomment_post( $incoming_comment ) {
$pattern = '/[一-龥]/u';
// 禁止全英文评论
if(!preg_match($pattern, $incoming_comment['comment_content'])) {
err( __('您的评论中必须包含汉字!', 'Nana') );	
}
$pattern = '/[あ-んア-ン]/u';
// 禁止日文评论
if(preg_match($pattern, $incoming_comment['comment_content'])) {
err( __('评论禁止包含日文!', 'Nana') );		
}
return( $incoming_comment );
}

if(!is_user_logged_in() && get_boxmoe('false_enjp_comment')) {
	add_filter('preprocess_comment', 'boxmoe_enjpcomment_post');
}


// 检查重复评论功能
$dupe = "SELECT comment_ID FROM $wpdb->comments WHERE comment_post_ID = '$comment_post_ID' AND ( comment_author = '$comment_author' ";
if ( $comment_author_email ) $dupe .= "OR comment_author_email = '$comment_author_email' ";
$dupe .= ") AND comment_content = '$comment_content' LIMIT 1";
if ( $wpdb->get_var($dupe) ) {
    err(__('发现有重复的评论内容哦！你已经说过了！废话不要那么多咯!', 'Nana'));
}

// 检查评论太快功能
if ( $lasttime = $wpdb->get_var( $wpdb->prepare("SELECT comment_date_gmt FROM $wpdb->comments WHERE comment_author = %s ORDER BY comment_date DESC LIMIT 1", $comment_author) ) ) { 
$time_lastcomment = mysql2date('U', $lasttime, false);
$time_newcomment  = mysql2date('U', current_time('mysql', 1), false);
$flood_die = apply_filters('comment_flood_filter', false, $time_lastcomment, $time_newcomment);
if ( $flood_die ) {
    err(__('您发表评论也太快了', 'Nana'));
	}
}

$comment_parent = isset($_POST['comment_parent']) ? absint($_POST['comment_parent']) : 0;

$commentdata = compact('comment_post_ID', 'comment_author', 'comment_author_email', 'comment_author_url', 'comment_content', 'comment_type', 'comment_parent', 'user_ID');

// 检查评论是否正被编辑, 更新或新建评论
if ( $edit_id ){
if($_SESSION['comment_id']==$edit_id){
$comment_id = $commentdata['comment_ID'] = $edit_id;
wp_update_comment( $commentdata );
}else{
err(__('没有更改此评论的权限!'));
}
} else {
$comment_id = wp_new_comment( $commentdata );
$_SESSION['comment_id']=$comment_id;
}

$comment = get_comment($comment_id);
if ( !$user->ID ) {
	$comment_cookie_lifetime = apply_filters('comment_cookie_lifetime', 30000000);
	setcookie('comment_author_' . COOKIEHASH, $comment->comment_author, time() + $comment_cookie_lifetime, COOKIEPATH, COOKIE_DOMAIN);
	setcookie('comment_author_email_' . COOKIEHASH, $comment->comment_author_email, time() + $comment_cookie_lifetime, COOKIEPATH, COOKIE_DOMAIN);
	setcookie('comment_author_url_' . COOKIEHASH, esc_url($comment->comment_author_url), time() + $comment_cookie_lifetime, COOKIEPATH, COOKIE_DOMAIN);
}

//$location = empty($_POST['redirect_to']) ? get_comment_link($comment_id) : $_POST['redirect_to'] . '#comment-' . $comment_id; //取消原有的刷新重定向
//$location = apply_filters('comment_post_redirect', $location, $comment);

//wp_redirect($location);

$comment_depth = 1;   //为评论的 class 属性准备的
$tmp_c = $comment;
while($tmp_c->comment_parent != 0){
$comment_depth++;
$tmp_c = get_comment($tmp_c->comment_parent);
}

//以下是评论式样, 不含 "回复". 
?>
                    <ul class="comments-list mx-auto">
                      <li class="commentsline">
                        <div <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?> id="comment-<?php comment_ID(); ?>">
                          <div class="author-box">
                            <div class="comment-autohr-img">
                              <div class="autohr-img-border">
                                <?php echo get_avatar( $comment->comment_author_email, 60,); ?> </div>
                            </div>
                            <span class="commentsbadge tourists">
                              <i class="fa fa-comment-o"></i> <?php echo $comment->comment_author;?></span>
                          </div>
                          <div class="comment-body">
                            <div class="meta-data">
                              <div class="comment-author">
                                <?php echo comment_author_link_window();?>
                                <span class="dot"></span>
                                <time><?php printf(
/*说明: %1$s 是日期, %2$s 是时间 */
esc_html__( '%1$s | %2$s', 'boxmoe' ),get_comment_date(),get_comment_time());edit_comment_link( esc_html__( '(编辑)', 'boxmoe' ), '  ', '' );?></time>
                              </div>
                            </div>
                            <div class="comment-content">
                              <?php comment_text(); ?>
							  <?php if ( $comment->comment_approved == '0' ) : ?>
							  <span> 您的评论正在等待审核中...</span><?php endif; ?>
                            </div>
                          </div>
                        </div>
                      </li>
					  </ul>
