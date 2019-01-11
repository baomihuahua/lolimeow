<?php
/* 
 * comment list 
 * ====================================================
*/

if ( ! function_exists( 'meowdata_comments_list' ) ) :
	function meowdata_comments_list( $comment, $args, $depth ) {
		?>
<li class="commentsline"><div <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?> id="comment-<?php comment_ID(); ?>">
<?php if ( $args['type'] != 'pings' ) : ?>
                                                      <div class="author-box">
                                                            <div class="thw-autohr-bio-img">
                                                                  <div class="thw-img-border">
                                                                 <img src="<?php echo meowdata('gravatar_url'); ?><?php echo esc_attr(md5($comment->comment_author_email)); ?>?s=100" class="img-fluid" alt="image">
                                                                  </div>
                                                            </div>
                                                      </div><?php endif; ?>
                                                      <div class="comment-body">
                                                            <div class="meta-data">
                                                            <span class="pull-right">
<?php echo get_comment_reply_link( array('depth'      => $depth,'max_depth'  => $args['max_depth'],
'reply_text' => sprintf( '<i class="fa fa-mail-reply-all"></i> %s', esc_html__( '回复', 'meowdata' ).'' ),),
$comment->comment_ID,$comment->comment_post_ID); ?>
                                                            </span>
                                                            <span class="comment-author"><?php echo comment_author_link_window();?> 
															<?php if($comment->user_id > 1){
																echo '<span class="badge badge-success"><i class="fa fa-heart"></i> '.meowdata('comnanesu').'</span>'; 
																}if($comment->user_id == 1){
																echo '<span class="badge badge-warning"><i class="fa fa-check-square"></i> '.meowdata('comnanes').'</span>'; 
																}if($comment->user_id == 0){
																echo '<span class="badge badge-info"><i class="fa fa-globe"></i> '.meowdata('comnaness').'</span>'; }
																?>
																	</span>
                                                            <span class="comment-date"><?php
						printf(
							/*说明: %1$s 是日期, %2$s 是时间 */
							esc_html__( '%1$s', 'meowdata' ),
							get_comment_date(),
							get_comment_time()
						);
						edit_comment_link( esc_html__( '(编辑)', 'meowdata' ), '  ', '' );
						?></span>
                                                            </div>
                                                            <div class="comment-content"><?php comment_text(); ?>
														<?php if ( $comment->comment_approved == '0' ) : ?>
												<span class="badge badge-danger"> 您的评论正在等待审核中...</span><?php endif; ?>
															</div>   
                                                      </div>
                                                </div>		
			
                              <?php
							  
	}
	function meowdata_end_comment() {
    echo '</li>';
}
endif;                              

//判断评论是否带链接并新窗口打开+GO功能开关
function comment_author_link_window() {
global $comment;
$url    = get_comment_author_url();
$author = get_comment_author();
$comnanesgo = meowdata('comnanesgo');
if(!empty($comnanesgo)) $comnanesgo_url = meowdata('comnanesgo_url');else $comnanesgo_url ='';

if ( empty( $url ) || 'http://' == $url )
 $return = $author;
 else
 $return = '<a href="'.$comnanesgo_url.''.$url.'" rel="external nofollow" target="_blank">'.$author.'</a>'; 
 return $return;
}
add_filter('get_comment_author_link', 'comment_author_link_window');

//评论开启@人
function meowdata_comment_add_at( $comment_text, $comment = '') {  
  if( $comment->comment_parent > 0 & $comment->user_id == 1) {  
    $comment_text = '<span class="badge badge-pill badge-success text-uppercase">@'.get_comment_author( $comment->comment_parent ) . '</span> ' . $comment_text.'';  
  }  
  if( $comment->comment_parent > 0 & $comment->user_id != 1) {  
    $comment_text = '<span class="badge badge-pill badge-success text-uppercase">@'.get_comment_author( $comment->comment_parent ) . '</span> ' . $comment_text;  
  }
  return $comment_text;  
}  
add_filter( 'comment_text' , 'meowdata_comment_add_at', 20, 2);  
function recover_comment_fields($comment_fields){
    $comment = array_shift($comment_fields);
    $comment_fields =  array_merge($comment_fields ,array('comment' => $comment));
    return $comment_fields;
}
add_filter('comment_form_fields','recover_comment_fields');


function comment_mail_notify($comment_id) {
  $comment = get_comment($comment_id);
  $parent_id = $comment->comment_parent ? $comment->comment_parent : '';
  $spam_confirmed = $comment->comment_approved;
  if (($parent_id != '') && ($spam_confirmed != 'spam')) {
    $wp_email = 'no-reply@' . preg_replace('#^www.#', '', strtolower($_SERVER['SERVER_NAME'])); //e-mail 发出点, no-reply 可改为可用的 e-mail.
    $to = trim(get_comment($parent_id)->comment_author_email);
    $subject = '您在 [' . get_option("blogname") . '] 的留言有了回复';
    $message = '
    <table style="width: 99.8%;height:99.8% "><tbody><tr><td style="background:#fafafa url()">
<div style="border-radius: 10px 10px 10px 10px;font-size:13px;    color: #555555;width: 95%;font-family:"Century Gothic","Trebuchet MS","Hiragino Sans GB",微软雅黑,"Microsoft Yahei",Tahoma,Helvetica,Arial,"SimSun",sans-serif;margin:50px auto;border:1px solid #eee;max-width:100%;background: #ffffff repeating-linear-gradient(-45deg,#fff,#fff 1.125rem,transparent 1.125rem,transparent 2.25rem);box-shadow: 0 1px 5px rgba(0, 0, 0, 0.15);">
<div style="width:100%;background:#49BDAD;color:#ffffff;border-radius: 10px 10px 0 0;background-image: -moz-linear-gradient(0deg, rgb(67, 198, 184), rgb(255, 209, 244));background-image: -webkit-linear-gradient(0deg, rgb(67, 198, 184), rgb(255, 209, 244));height: 66px;">
<p style="font-size:15px;word-break:break-all;padding: 23px 32px;margin:0;background-color: hsla(0,0%,100%,.4);border-radius: 10px 10px 0 0;">
您在<a style="text-decoration:none;color: #ffffff;" href="' . get_option('blogname') . '" rel="noopener" target="_blank"> [' . get_option('blogname') . '] </a> 的留言有回复啦！
</p>
</div>
<div style="margin:40px 30px">
<p>' . trim($comment->comment_author) . ' 给您的回复如下：</p>
<p style="background: #fafafa repeating-linear-gradient(-45deg,#fff,#fff 1.125rem,transparent 1.125rem,transparent 2.25rem);box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);margin:20px 0px;padding:15px;border-radius:5px;font-size:14px;color:#555555;">'. trim($comment->comment_content) . '</p>
<p>您在《' . get_the_title($comment->comment_post_ID) . '》的原始留言：</p>
<p style="background: #fafafa repeating-linear-gradient(-45deg,#fff,#fff 1.125rem,transparent 1.125rem,transparent 2.25rem);box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);margin:20px 0px;padding:15px;border-radius:5px;font-size:14px;color:#555555;">'. trim(get_comment($parent_id)->comment_content) . '</p>
<p>您可以点击 <a style="text-decoration:none; color:#12addb" href="' . htmlspecialchars(get_comment_link($parent_id, array('type' => 'comment'))) . '" rel="noopener" target="_blank">查看回复的完整內容 </a>，此邮件由 <a style="text-decoration:none; color:#12addb" href="' . htmlspecialchars(get_comment_link($parent_id, array('type' => 'comment'))) . '" rel="noopener" target="_blank"> ' . get_option('blogname') . ' </a> 系统自动发送，请勿直接回复！</p>
</div></div></td></tr></tbody></table>';
      $from = "From: \"" . get_option('blogname') . "\" <$wp_email>";
      $headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
      wp_mail( $to, $subject, $message, $headers );
  }
}
add_action('comment_post', 'comment_mail_notify');


function _get_post_comments($before = '评论(', $after = ')') {
	return $before . get_comments_number('0', '1', '%') . $after;
}
function _new_strlen($str,$charset='utf-8') {        
    $n = 0; $p = 0; $c = '';
    $len = strlen($str);
    if($charset == 'utf-8') {
        for($i = 0; $i < $len; $i++) {
            $c = ord($str{$i});
            if($c > 252) {
                $p = 5;
            } elseif($c > 248) {
                $p = 4;
            } elseif($c > 240) {
                $p = 3;
            } elseif($c > 224) {
                $p = 2;
            } elseif($c > 192) {
                $p = 1;
            } else {
                $p = 0;
            }
            $i+=$p;$n++;
        }
    } else {
        for($i = 0; $i < $len; $i++) {
            $c = ord($str{$i});
            if($c > 127) {
                $p = 1;
            } else {
                $p = 0;
        }
            $i+=$p;$n++;
        }
    }        
    return $n;
}