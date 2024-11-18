<?php
/**
 * @link https://www.boxmoe.com
 * @package lolimeow
 */

if ( ! function_exists( 'boxmoe_comments_list' ) ) :
	function boxmoe_comments_list( $comment, $args, $depth ) {
		?>
                      <li class="commentsline">
                        <div <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?> id="comment-<?php comment_ID(); ?>">
						<?php if ( $args['type'] != 'pings' ) : ?>
                          <div class="author-box">
                            <div class="comment-autohr-img">
                              <div class="autohr-img-border">
							  <?php if($comment->user_id == 0){echo get_avatar($comment->comment_author_email,60);}else{echo get_avatar($comment->user_id,60);} ?></div>
                            </div>
                            <?php if($comment->user_id > 1){echo '<span class="commentsbadge members"><i class="fa fa-heart"></i> '.get_boxmoe('comnanesu','会员').'</span>';}if($comment->user_id == 1){echo '<span class="commentsbadge blogger"><i class="fa fa-check-square"></i> '.get_boxmoe('comnanes','博主').'</span>'; }if($comment->user_id == 0){echo '<span class="commentsbadge tourists"><i class="fa fa-globe"></i> '.get_boxmoe('comnaness','游客').'</span>'; }?>
                          </div><?php endif; ?>
                          <div class="comment-body">
                            <div class="meta-data">
                              <div class="comment-author">
                                <?php echo comment_author_link_window();?>
                                <span class="dot"></span>
                                <time><?php printf(
							/*说明: %1$s 是日期, %2$s 是时间 */
							esc_html__( '%1$s', 'boxmoe' ),get_comment_date(),get_comment_time());edit_comment_link( esc_html__( '(编辑)', 'boxmoe' ), '  ', '' );?></time>
                                <?php echo get_comment_reply_link( array('depth'=> $depth,'max_depth'=> $args['max_depth'],
	'reply_text' => sprintf( '<span class="pull-right"><i class="fa fa-commenting-o"></i> %s </span>', esc_html__( '回复', 'boxmoe' ).'' ),),
		$comment->comment_ID,$comment->comment_post_ID); ?>
                              </div>
                            </div>
                            <div class="comment-content">
                              <?php comment_text(); ?>
							  <?php if ( $comment->comment_approved == '0' ) : ?><span> 您的评论正在等待审核中...</span><?php endif; ?>
                            </div>
                          </div>
                        </div>
<?php							  
	}
	function boxmoe_end_comment() {
    echo '</li>';
}
endif;                    

//判断评论是否带链接并新窗口打开
function comment_author_link_window() {
global $comment;
$url    = get_comment_author_url();
$author = get_comment_author();
if ( empty( $url ) || 'http://' == $url )
 $return = $author;
 else
 $return = '<a href="'.$url.'" rel="external nofollow" target="_blank">'.$author.'</a>'; 
 return $return;
}
add_filter('get_comment_author_link', 'comment_author_link_window');

//评论开启@人
function boxmoe_comment_add_at( $comment_text, $comment = '' ) {  
  if ( $comment !== null && $comment->comment_parent > 0 ) {
    if ( $comment->user_id == 1 ) {
      $comment_text = '<span class="commentsbadges atwho">@ '.get_comment_author( $comment->comment_parent ) . '</span> ' . $comment_text;
    } else {
      $comment_text = '<span class="commentsbadges atwho">@ '.get_comment_author( $comment->comment_parent ) . '</span> ' . $comment_text;
    }
  }
  return $comment_text;  
}

add_filter( 'comment_text' , 'boxmoe_comment_add_at', 20, 2);  
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
    <table style="width:100%;margin: 0 auto;height:100% "><tbody><tr><td style="background:#fafafa url()">
<div style="border-radius: 10px 10px 10px 10px;font-size:13px;    color: #555555;width:100%;font-family:"Century Gothic","Trebuchet MS","Hiragino Sans GB",微软雅黑,"Microsoft Yahei",Tahoma,Helvetica,Arial,"SimSun",sans-serif;margin:50px auto;border:1px solid #eee;max-width:100%;background: #ffffff repeating-linear-gradient(-45deg,#fff,#fff 1.125rem,transparent 1.125rem,transparent 2.25rem);box-shadow: 0 1px 5px rgba(0, 0, 0, 0.15);">
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
            $c = ord($str[$i]);
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
            $c = ord($str[$i]);
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
//自定义表情路径
function custom_smilies_src($src, $img){
	return get_bloginfo('template_directory').'/assets/images/smilies/' . $img;
	}
add_filter('smilies_src', 'custom_smilies_src', 10, 2);

//输出评论表情函数
function boxmoe_smilies(){
  $a = array( 'mrgreen','razz','sad','smile','oops','grin','eek','???','cool','lol','mad','twisted','roll','wink','idea','arrow','neutral','cry','?','evil','shock','!' );
  $b = array( 'mrgreen','razz','sad','smile','redface','biggrin','surprised','confused','cool','lol','mad','twisted','rolleyes','wink','idea','arrow','neutral','cry','question','evil','eek','exclaim' );
  for( $i=0;$i<22;$i++ ){
    echo '<a title="'.$a[$i].'" class="smilie-icon"  href="javascript:grin('."' :".$a[$i].": '".')" ><img src="'.get_bloginfo('template_directory').'/assets/images/smilies/icon_'.$b[$i].'.gif" width=18/></a>';
  }
}
function alu_smilies_reset() {
    global $wpsmiliestrans, $wp_smiliessearch;
 
// don't bother setting up smilies if they are disabled
    if ( !get_option( 'use_smilies' ) )
        return;
 
    $wpsmiliestrans = array(
        ':mrgreen:' => 'icon_mrgreen.gif',
        ':neutral:' => 'icon_neutral.gif',
        ':twisted:' => 'icon_twisted.gif',
        ':arrow:' => 'icon_arrow.gif',
        ':shock:' => 'icon_eek.gif',
        ':smile:' => 'icon_smile.gif',
        ':???:' => 'icon_confused.gif',
        ':cool:' => 'icon_cool.gif',
        ':evil:' => 'icon_evil.gif',
        ':grin:' => 'icon_biggrin.gif',
        ':idea:' => 'icon_idea.gif',
        ':oops:' => 'icon_redface.gif',
        ':razz:' => 'icon_razz.gif',
        ':roll:' => 'icon_rolleyes.gif',
        ':wink:' => 'icon_wink.gif',
        ':cry:' => 'icon_cry.gif',
        ':eek:' => 'icon_surprised.gif',
        ':lol:' => 'icon_lol.gif',
        ':mad:' => 'icon_mad.gif',
        ':sad:' => 'icon_sad.gif',
        '8-)' => 'icon_cool.gif',
        '8-O' => 'icon_eek.gif',
        ':-(' => 'icon_sad.gif',
        ':-)' => 'icon_smile.gif',
        ':-?' => 'icon_confused.gif',
        ':-D' => 'icon_biggrin.gif',
        ':-P' => 'icon_razz.gif',
        ':-o' => 'icon_surprised.gif',
        ':-x' => 'icon_mad.gif',
        ':-|' => 'icon_neutral.gif',
        ';-)' => 'icon_wink.gif',
        // This one transformation breaks regular text with frequency.
        //     '8)' => 'icon_cool.gif',
        '8O' => 'icon_eek.gif',
        ':(' => 'icon_sad.gif',
        ':)' => 'icon_smile.gif',
        ':?' => 'icon_confused.gif',
        ':D' => 'icon_biggrin.gif',
        ':P' => 'icon_razz.gif',
        ':o' => 'icon_surprised.gif',
        ':x' => 'icon_mad.gif',
        ':|' => 'icon_neutral.gif',
        ';)' => 'icon_wink.gif',
        ':!:' => 'icon_exclaim.gif',
        ':?:' => 'icon_question.gif',
    );
}
add_action('init','alu_smilies_reset');

add_filter('comment_text', 'replace_comment_smilies', 20, 2);
global $search, $replace;
$search = [];  // 用于存储所有表情符号代码
$replace = []; // 用于存储所有替换的图片标签
function replace_comment_smilies($comment_content, $comment) {

    if (!get_option('use_smilies')) {
        return $comment_content;
    }
    
    $emoji = array(
        array('url' => '/assets/images/emoji/aru/1.png','title' => "aru_1"),
        array('url' => '/assets/images/emoji/aru/2.png','title' => "aru_2"),
        array('url' => '/assets/images/emoji/aru/3.png','title' => "aru_3"),
        array('url' => '/assets/images/emoji/aru/4.png','title' => "aru_4"),
        array('url' => '/assets/images/emoji/aru/5.png','title' => "aru_5"),
        array('url' => '/assets/images/emoji/aru/6.png','title' => "aru_6"),
        array('url' => '/assets/images/emoji/aru/7.png','title' => "aru_7"),
        array('url' => '/assets/images/emoji/aru/8.png','title' => "aru_8"),
        array('url' => '/assets/images/emoji/aru/9.png','title' => "aru_9"),
        array('url' => '/assets/images/emoji/aru/10.png','title' => "aru_10"),
        array('url' => '/assets/images/emoji/aru/11.png','title' => "aru_11"),
        array('url' => '/assets/images/emoji/aru/12.png','title' => "aru_12"),
        array('url' => '/assets/images/emoji/aru/13.png','title' => "aru_13"),
        array('url' => '/assets/images/emoji/aru/14.png','title' => "aru_14"),
        array('url' => '/assets/images/emoji/aru/15.png','title' => "aru_15"),
        array('url' => '/assets/images/emoji/aru/16.png','title' => "aru_16"),
        array('url' => '/assets/images/emoji/aru/17.png','title' => "aru_17"),
        array('url' => '/assets/images/emoji/aru/18.png','title' => "aru_18"),
        array('url' => '/assets/images/emoji/aru/19.png','title' => "aru_19"),
        array('url' => '/assets/images/emoji/aru/20.png','title' => "aru_20"),
        array('url' => '/assets/images/emoji/aru/21.png','title' => "aru_21"),
        array('url' => '/assets/images/emoji/aru/22.png','title' => "aru_22"),
        array('url' => '/assets/images/emoji/aru/23.png','title' => "aru_23"),
        array('url' => '/assets/images/emoji/aru/24.png','title' => "aru_24"),
        array('url' => '/assets/images/emoji/aru/25.png','title' => "aru_25"),
        array('url' => '/assets/images/emoji/aru/26.png','title' => "aru_26"),
        array('url' => '/assets/images/emoji/aru/27.png','title' => "aru_27"),
        array('url' => '/assets/images/emoji/aru/28.png','title' => "aru_28"),
        array('url' => '/assets/images/emoji/aru/29.png','title' => "aru_29"),
        array('url' => '/assets/images/emoji/aru/30.png','title' => "aru_30"),
        array('url' => '/assets/images/emoji/aru/31.png','title' => "aru_31"),
        array('url' => '/assets/images/emoji/aru/32.png','title' => "aru_32"),
        array('url' => '/assets/images/emoji/aru/33.png','title' => "aru_33"),
        array('url' => '/assets/images/emoji/aru/34.png','title' => "aru_34"),
        array('url' => '/assets/images/emoji/aru/35.png','title' => "aru_35"),
        array('url' => '/assets/images/emoji/aru/36.png','title' => "aru_36"),
        array('url' => '/assets/images/emoji/aru/37.png','title' => "aru_37"),
        array('url' => '/assets/images/emoji/aru/38.png','title' => "aru_38"),
        array('url' => '/assets/images/emoji/aru/39.png','title' => "aru_39"),
        array('url' => '/assets/images/emoji/aru/40.png','title' => "aru_40"),
        array('url' => '/assets/images/emoji/aru/41.png','title' => "aru_41"),
        array('url' => '/assets/images/emoji/aru/42.png','title' => "aru_42"),
        array('url' => '/assets/images/emoji/aru/43.png','title' => "aru_43"),
        array('url' => '/assets/images/emoji/aru/44.png','title' => "aru_44"),
        array('url' => '/assets/images/emoji/aru/45.png','title' => "aru_45"),
        array('url' => '/assets/images/emoji/aru/46.png','title' => "aru_46"),
        array('url' => '/assets/images/emoji/aru/47.png','title' => "aru_47"),
        array('url' => '/assets/images/emoji/aru/48.png','title' => "aru_48"),
        array('url' => '/assets/images/emoji/aru/49.png','title' => "aru_49"),
        array('url' => '/assets/images/emoji/aru/50.png','title' => "aru_50"),
        array('url' => '/assets/images/emoji/aru/51.png','title' => "aru_51"),
        array('url' => '/assets/images/emoji/aru/52.png','title' => "aru_52"),
        array('url' => '/assets/images/emoji/aru/53.png','title' => "aru_53"),
        array('url' => '/assets/images/emoji/aru/54.png','title' => "aru_54"),
        array('url' => '/assets/images/emoji/aru/55.png','title' => "aru_55"),
        array('url' => '/assets/images/emoji/aru/56.png','title' => "aru_56"),
        array('url' => '/assets/images/emoji/aru/57.png','title' => "aru_57"),
        array('url' => '/assets/images/emoji/aru/58.png','title' => "aru_58"),
        array('url' => '/assets/images/emoji/aru/59.png','title' => "aru_59"),
        array('url' => '/assets/images/emoji/aru/60.png','title' => "aru_60"),
        array('url' => '/assets/images/emoji/aru/61.png','title' => "aru_61"),
        array('url' => '/assets/images/emoji/aru/62.png','title' => "aru_62"),
        array('url' => '/assets/images/emoji/aru/63.png','title' => "aru_63"),
        array('url' => '/assets/images/emoji/aru/64.png','title' => "aru_64"),
        array('url' => '/assets/images/emoji/aru/65.png','title' => "aru_65"),
        array('url' => '/assets/images/emoji/aru/66.png','title' => "aru_66"),
        array('url' => '/assets/images/emoji/aru/67.png','title' => "aru_67"),
        array('url' => '/assets/images/emoji/aru/68.png','title' => "aru_68"),
        array('url' => '/assets/images/emoji/aru/69.png','title' => "aru_69"),
        array('url' => '/assets/images/emoji/aru/70.png','title' => "aru_70"),
        array('url' => '/assets/images/emoji/aru/71.png','title' => "aru_71"),
        array('url' => '/assets/images/emoji/aru/72.png','title' => "aru_72"),
        array('url' => '/assets/images/emoji/aru/73.png','title' => "aru_73"),
        array('url' => '/assets/images/emoji/aru/74.png','title' => "aru_74"),
        array('url' => '/assets/images/emoji/aru/75.png','title' => "aru_75"),
        array('url' => '/assets/images/emoji/aru/76.png','title' => "aru_76"),
        array('url' => '/assets/images/emoji/aru/77.png','title' => "aru_77"),
        array('url' => '/assets/images/emoji/aru/78.png','title' => "aru_78"),
        array('url' => '/assets/images/emoji/aru/79.png','title' => "aru_79"),
        array('url' => '/assets/images/emoji/aru/80.png','title' => "aru_80"),
        array('url' => '/assets/images/emoji/aru/81.png','title' => "aru_81"),
        array('url' => '/assets/images/emoji/aru/82.png','title' => "aru_82"),
        array('url' => '/assets/images/emoji/aru/83.png','title' => "aru_83"),
        array('url' => '/assets/images/emoji/aru/84.png','title' => "aru_84"),
        array('url' => '/assets/images/emoji/aru/85.png','title' => "aru_85"),
        array('url' => '/assets/images/emoji/aru/86.png','title' => "aru_86"),
        array('url' => '/assets/images/emoji/aru/87.png','title' => "aru_87"),
        array('url' => '/assets/images/emoji/aru/88.png','title' => "aru_88"),
        array('url' => '/assets/images/emoji/aru/89.png','title' => "aru_89"),
        array('url' => '/assets/images/emoji/aru/90.png','title' => "aru_90"),
        array('url' => '/assets/images/emoji/aru/91.png','title' => "aru_91"),
        array('url' => '/assets/images/emoji/aru/92.png','title' => "aru_92"),
        array('url' => '/assets/images/emoji/aru/93.png','title' => "aru_93"),
        array('url' => '/assets/images/emoji/aru/94.png','title' => "aru_94"),
        array('url' => '/assets/images/emoji/aru/95.png','title' => "aru_95"),
        array('url' => '/assets/images/emoji/aru/96.png','title' => "aru_96"),
        array('url' => '/assets/images/emoji/aru/97.png','title' => "aru_97"),
        array('url' => '/assets/images/emoji/aru/98.png','title' => "aru_98"),
        array('url' => '/assets/images/emoji/aru/99.png','title' => "aru_99"),
        array('url' => '/assets/images/emoji/aru/100.png','title' => "aru_100"),
        array('url' => '/assets/images/emoji/aru/101.png','title' => "aru_101"),
        array('url' => '/assets/images/emoji/aru/102.png','title' => "aru_102"),
        array('url' => '/assets/images/emoji/aru/103.png','title' => "aru_103"),
        array('url' => '/assets/images/emoji/aru/104.png','title' => "aru_104"),
        array('url' => '/assets/images/emoji/aru/105.png','title' => "aru_105"),
        array('url' => '/assets/images/emoji/aru/106.png','title' => "aru_106"),
        array('url' => '/assets/images/emoji/aru/107.png','title' => "aru_107"),
        array('url' => '/assets/images/emoji/aru/108.png','title' => "aru_108"),
        array('url' => '/assets/images/emoji/aru/109.png','title' => "aru_109"),
        array('url' => '/assets/images/emoji/aru/110.png','title' => "aru_110"),
        array('url' => '/assets/images/emoji/aru/111.png','title' => "aru_111"),
        array('url' => '/assets/images/emoji/aru/112.png','title' => "aru_112"),
        array('url' => '/assets/images/emoji/aru/113.png','title' => "aru_113"),
        array('url' => '/assets/images/emoji/aru/114.png','title' => "aru_114"),
        array('url' => '/assets/images/emoji/aru/115.png','title' => "aru_115"),
        array('url' => '/assets/images/emoji/aru/116.png','title' => "aru_116"),
        array('url' => '/assets/images/emoji/aru/117.png','title' => "aru_117"),
        array('url' => '/assets/images/emoji/aru/118.png','title' => "aru_118"),
        array('url' => '/assets/images/emoji/aru/119.png','title' => "aru_119"),
        array('url' => '/assets/images/emoji/aru/120.png','title' => "aru_120"),
        array('url' => '/assets/images/emoji/aru/121.png','title' => "aru_121"),
        array('url' => '/assets/images/emoji/aru/122.png','title' => "aru_122"),
        array('url' => '/assets/images/emoji/aru/123.png','title' => "aru_123"),
        array('url' => '/assets/images/emoji/aru/124.png','title' => "aru_124"),
        array('url' => '/assets/images/emoji/aru/125.png','title' => "aru_125"),
        array('url' => '/assets/images/emoji/aru/126.png','title' => "aru_126"),
        array('url' => '/assets/images/emoji/aru/127.png','title' => "aru_127"),
        array('url' => '/assets/images/emoji/aru/128.png','title' => "aru_128"),
        array('url' => '/assets/images/emoji/aru/129.png','title' => "aru_129"),
        array('url' => '/assets/images/emoji/aru/130.png','title' => "aru_130"),
        array('url' => '/assets/images/emoji/aru/131.png','title' => "aru_131"),
        array('url' => '/assets/images/emoji/aru/132.png','title' => "aru_132"),
        array('url' => '/assets/images/emoji/aru/133.png','title' => "aru_133"),
        array('url' => '/assets/images/emoji/aru/134.png','title' => "aru_134"),
        array('url' => '/assets/images/emoji/aru/135.png','title' => "aru_135"),
        array('url' => '/assets/images/emoji/aru/136.png','title' => "aru_136"),
        array('url' => '/assets/images/emoji/aru/137.png','title' => "aru_137"),
        array('url' => '/assets/images/emoji/aru/138.png','title' => "aru_138"),
        array('url' => '/assets/images/emoji/aru/139.png','title' => "aru_139"),
        array('url' => '/assets/images/emoji/aru/140.png','title' => "aru_140"),
        array('url' => '/assets/images/emoji/aru/141.png','title' => "aru_141"),
        array('url' => '/assets/images/emoji/aru/142.png','title' => "aru_142"),
        array('url' => '/assets/images/emoji/aru/143.png','title' => "aru_143"),
        array('url' => '/assets/images/emoji/aru/144.png','title' => "aru_144"),
        array('url' => '/assets/images/emoji/aru/145.png','title' => "aru_145"),
        array('url' => '/assets/images/emoji/aru/146.png','title' => "aru_146"),
        array('url' => '/assets/images/emoji/aru/147.png','title' => "aru_147"),
        array('url' => '/assets/images/emoji/aru/148.png','title' => "aru_148"),
        array('url' => '/assets/images/emoji/aru/149.png','title' => "aru_149"),
        array('url' => '/assets/images/emoji/aru/150.png','title' => "aru_150"),
        array('url' => '/assets/images/emoji/aru/151.png','title' => "aru_151"),
        array('url' => '/assets/images/emoji/aru/152.png','title' => "aru_152"),
        array('url' => '/assets/images/emoji/aru/153.png','title' => "aru_153"),
        array('url' => '/assets/images/emoji/aru/154.png','title' => "aru_154"),
        array('url' => '/assets/images/emoji/aru/155.png','title' => "aru_155"),
        array('url' => '/assets/images/emoji/aru/156.png','title' => "aru_156"),
        array('url' => '/assets/images/emoji/aru/157.png','title' => "aru_157"),
        array('url' => '/assets/images/emoji/aru/158.png','title' => "aru_158"),
        array('url' => '/assets/images/emoji/aru/159.png','title' => "aru_159"),
        array('url' => '/assets/images/emoji/aru/160.png','title' => "aru_160"),
        array('url' => '/assets/images/emoji/aru/161.png','title' => "aru_161"),
        array('url' => '/assets/images/emoji/aru/162.png','title' => "aru_162"),
        array('url' => '/assets/images/emoji/aru/163.png','title' => "aru_163"),
        array('url' => '/assets/images/emoji/aru/164.png','title' => "aru_164"),
        array('url' => '/assets/images/emoji/qq/kge.gif','title' => "K歌"),
        array('url' => '/assets/images/emoji/qq/NO.gif','title' => "NO"),
        array('url' => '/assets/images/emoji/qq/OK.gif','title' => "OK"),
        array('url' => '/assets/images/emoji/qq/xiayu.gif','title' => "下雨"),
        array('url' => '/assets/images/emoji/qq/pingpang.gif','title' => "乒乓"),
        array('url' => '/assets/images/emoji/qq/qingqing.gif','title' => "亲亲"),
        array('url' => '/assets/images/emoji/qq/bianbian.gif','title' => "便便"),
        array('url' => '/assets/images/emoji/qq/touxiao.gif','title' => "偷笑"),
        array('url' => '/assets/images/emoji/qq/aoman.gif','title' => "傲慢"),
        array('url' => '/assets/images/emoji/qq/zaijian.gif','title' => "再见"),
        array('url' => '/assets/images/emoji/qq/lenghan.gif','title' => "冷汗"),
        array('url' => '/assets/images/emoji/qq/diaoxie.gif','title' => "凋谢"),
        array('url' => '/assets/images/emoji/qq/dao.gif','title' => "刀"),
        array('url' => '/assets/images/emoji/qq/gouyin.gif','title' => "勾引"),
        array('url' => '/assets/images/emoji/qq/fadai.gif','title' => "发呆"),
        array('url' => '/assets/images/emoji/qq/fanu.gif','title' => "发怒"),
        array('url' => '/assets/images/emoji/qq/fadou.gif','title' => "发抖"),
        array('url' => '/assets/images/emoji/qq/facai.gif','title' => "发财"),
        array('url' => '/assets/images/emoji/qq/kelian.gif','title' => "可怜"),
        array('url' => '/assets/images/emoji/qq/keai.gif','title' => "可爱"),
        array('url' => '/assets/images/emoji/qq/youhengheng.gif','title' => "右哼哼"),
        array('url' => '/assets/images/emoji/qq/youtaiji.gif','title' => "右太极"),
        array('url' => '/assets/images/emoji/qq/tu.gif','title' => "吐"),
        array('url' => '/assets/images/emoji/qq/xia.gif','title' => "吓"),
        array('url' => '/assets/images/emoji/qq/wen.gif','title' => "吻"),
        array('url' => '/assets/images/emoji/qq/ciya.gif','title' => "呲牙"),
        array('url' => '/assets/images/emoji/qq/zhouma.gif','title' => "咒骂"),
        array('url' => '/assets/images/emoji/qq/kafei.gif','title' => "咖啡"),
        array('url' => '/assets/images/emoji/qq/haqian.gif','title' => "哈欠"),
        array('url' => '/assets/images/emoji/qq/pijiu.gif','title' => "啤酒"),
        array('url' => '/assets/images/emoji/qq/hecai.gif','title' => "喝彩"),
        array('url' => '/assets/images/emoji/qq/xiudale.gif','title' => "嗅大了"),
        array('url' => '/assets/images/emoji/qq/xu.gif','title' => "嘘"),
        array('url' => '/assets/images/emoji/qq/xi.gif','title' => "囍"),
        array('url' => '/assets/images/emoji/qq/huitou.gif','title' => "回头"),
        array('url' => '/assets/images/emoji/qq/kun.gif','title' => "困"),
        array('url' => '/assets/images/emoji/qq/huaixiao.gif','title' => "坏笑"),
        array('url' => '/assets/images/emoji/qq/duoyun.gif','title' => "多云"),
        array('url' => '/assets/images/emoji/qq/yewan.gif','title' => "夜晚"),
        array('url' => '/assets/images/emoji/qq/dabing.gif','title' => "大兵"),
        array('url' => '/assets/images/emoji/qq/daku.gif','title' => "大哭"),
        array('url' => '/assets/images/emoji/qq/taiyang.gif','title' => "太阳"),
        array('url' => '/assets/images/emoji/qq/fendou.gif','title' => "奋斗"),
        array('url' => '/assets/images/emoji/qq/naiping.gif','title' => "奶瓶"),
        array('url' => '/assets/images/emoji/qq/weiqu.gif','title' => "委屈"),
        array('url' => '/assets/images/emoji/qq/haixiu.gif','title' => "害羞"),
        array('url' => '/assets/images/emoji/qq/ganga.gif','title' => "尴尬"),
        array('url' => '/assets/images/emoji/qq/zuohengheng.gif','title' => "左哼哼"),
        array('url' => '/assets/images/emoji/qq/zuotaiji.gif','title' => "左太极"),
        array('url' => '/assets/images/emoji/qq/chajin.gif','title' => "差劲"),
        array('url' => '/assets/images/emoji/qq/shuai.gif','title' => "帅"),
        array('url' => '/assets/images/emoji/qq/ruo.gif','title' => "弱"),
        array('url' => '/assets/images/emoji/qq/qiang.gif','title' => "强"),
        array('url' => '/assets/images/emoji/qq/deyi.gif','title' => "得意"),
        array('url' => '/assets/images/emoji/qq/weixiao.gif','title' => "微笑"),
        array('url' => '/assets/images/emoji/qq/xin.gif','title' => "心"),
        array('url' => '/assets/images/emoji/qq/xinsui.gif','title' => "心碎"),
        array('url' => '/assets/images/emoji/qq/kuaikule.gif','title' => "快哭了"),
        array('url' => '/assets/images/emoji/qq/ouhuo.gif','title' => "怄火"),
        array('url' => '/assets/images/emoji/qq/jingkong.gif','title' => "惊恐"),
        array('url' => '/assets/images/emoji/qq/jingya.gif','title' => "惊讶"),
        array('url' => '/assets/images/emoji/qq/hanxiao.gif','title' => "憨笑"),
        array('url' => '/assets/images/emoji/qq/jiezhi.gif','title' => "戒指"),
        array('url' => '/assets/images/emoji/qq/zhuakuang.gif','title' => "抓狂"),
        array('url' => '/assets/images/emoji/qq/zhemo.gif','title' => "折磨"),
        array('url' => '/assets/images/emoji/qq/koubi.gif','title' => "抠鼻"),
        array('url' => '/assets/images/emoji/qq/baoquan.gif','title' => "抱拳"),
        array('url' => '/assets/images/emoji/qq/yongbao.gif','title' => "拥抱"),
        array('url' => '/assets/images/emoji/qq/quantou.gif','title' => "拳头"),
        array('url' => '/assets/images/emoji/qq/huidong.gif','title' => "挥动"),
        array('url' => '/assets/images/emoji/qq/woshou.gif','title' => "握手"),
        array('url' => '/assets/images/emoji/qq/piezui.gif','title' => "撇嘴"),
        array('url' => '/assets/images/emoji/qq/cahan.gif','title' => "擦汗"),
        array('url' => '/assets/images/emoji/qq/qiaoda.gif','title' => "敲打"),
        array('url' => '/assets/images/emoji/qq/yun.gif','title' => "晕"),
        array('url' => '/assets/images/emoji/qq/qiang2.gif','title' => "枪"),
        array('url' => '/assets/images/emoji/qq/bangbangtang.gif','title' => "棒棒糖"),
        array('url' => '/assets/images/emoji/qq/qiqiu.gif','title' => "气球"),
        array('url' => '/assets/images/emoji/qq/shafa.gif','title' => "沙发"),
        array('url' => '/assets/images/emoji/qq/liuhan.gif','title' => "流汗"),
        array('url' => '/assets/images/emoji/qq/liulei.gif','title' => "流泪"),
        array('url' => '/assets/images/emoji/qq/jidong.gif','title' => "激动"),
        array('url' => '/assets/images/emoji/qq/deng.gif','title' => "灯"),
        array('url' => '/assets/images/emoji/qq/denglong.gif','title' => "灯笼"),
        array('url' => '/assets/images/emoji/qq/zhatan.gif','title' => "炸弹"),
        array('url' => '/assets/images/emoji/qq/xiongmao.gif','title' => "熊猫"),
        array('url' => '/assets/images/emoji/qq/baojin.gif','title' => "爆筋"),
        array('url' => '/assets/images/emoji/qq/aini.gif','title' => "爱你"),
        array('url' => '/assets/images/emoji/qq/aiqing.gif','title' => "爱情"),
        array('url' => '/assets/images/emoji/qq/zhutou.gif','title' => "猪头"),
        array('url' => '/assets/images/emoji/qq/xianwen.gif','title' => "献吻"),
        array('url' => '/assets/images/emoji/qq/meigui.gif','title' => "玫瑰"),
        array('url' => '/assets/images/emoji/qq/piaochong.gif','title' => "瓢虫"),
        array('url' => '/assets/images/emoji/qq/yiwen.gif','title' => "疑问"),
        array('url' => '/assets/images/emoji/qq/baiyan.gif','title' => "白眼"),
        array('url' => '/assets/images/emoji/qq/shui.gif','title' => "睡"),
        array('url' => '/assets/images/emoji/qq/ketou.gif','title' => "磕头"),
        array('url' => '/assets/images/emoji/qq/liwu.gif','title' => "礼物"),
        array('url' => '/assets/images/emoji/qq/lanqiu.gif','title' => "篮球"),
        array('url' => '/assets/images/emoji/qq/zhijin.gif','title' => "纸巾"),
        array('url' => '/assets/images/emoji/qq/shengli.gif','title' => "胜利"),
        array('url' => '/assets/images/emoji/qq/se.gif','title' => "色"),
        array('url' => '/assets/images/emoji/qq/yaowan.gif','title' => "药丸"),
        array('url' => '/assets/images/emoji/qq/caidao.gif','title' => "菜刀"),
        array('url' => '/assets/images/emoji/qq/dangao.gif','title' => "蛋糕"),
        array('url' => '/assets/images/emoji/qq/lazhu.gif','title' => "蜡烛"),
        array('url' => '/assets/images/emoji/qq/jiewu.gif','title' => "街舞"),
        array('url' => '/assets/images/emoji/qq/shuai2.gif','title' => "衰"),
        array('url' => '/assets/images/emoji/qq/xigua.gif','title' => "西瓜"),
        array('url' => '/assets/images/emoji/qq/tiaopi.gif','title' => "调皮"),
        array('url' => '/assets/images/emoji/qq/gouwu.gif','title' => "购物"),
        array('url' => '/assets/images/emoji/qq/zuqiu.gif','title' => "足球"),
        array('url' => '/assets/images/emoji/qq/tiaosheng.gif','title' => "跳绳"),
        array('url' => '/assets/images/emoji/qq/tiaotiao.gif','title' => "跳跳"),
        array('url' => '/assets/images/emoji/qq/che.gif','title' => "车"),
        array('url' => '/assets/images/emoji/qq/chexiang.gif','title' => "车厢"),
        array('url' => '/assets/images/emoji/qq/zhuanquan.gif','title' => "转圈"),
        array('url' => '/assets/images/emoji/qq/youjian.gif','title' => "邮件"),
        array('url' => '/assets/images/emoji/qq/bishi.gif','title' => "鄙视"),
        array('url' => '/assets/images/emoji/qq/ku.gif','title' => "酷"),
        array('url' => '/assets/images/emoji/qq/qian.gif','title' => "钱"),
        array('url' => '/assets/images/emoji/qq/shandian.gif','title' => "闪电"),
        array('url' => '/assets/images/emoji/qq/bizui.gif','title' => "闭嘴"),
        array('url' => '/assets/images/emoji/qq/naozhong.gif','title' => "闹钟"),
        array('url' => '/assets/images/emoji/qq/yinxian.gif','title' => "阴险"),
        array('url' => '/assets/images/emoji/qq/nanguo.gif','title' => "难过"),
        array('url' => '/assets/images/emoji/qq/yusan.gif','title' => "雨伞"),
        array('url' => '/assets/images/emoji/qq/qingwa.gif','title' => "青蛙"),
        array('url' => '/assets/images/emoji/qq/miantiao.gif','title' => "面条"),
        array('url' => '/assets/images/emoji/qq/bianpao.gif','title' => "鞭炮"),
        array('url' => '/assets/images/emoji/qq/fengche.gif','title' => "风车"),
        array('url' => '/assets/images/emoji/qq/feiwen.gif','title' => "飞吻"),
        array('url' => '/assets/images/emoji/qq/feiji.gif','title' => "飞机"),
        array('url' => '/assets/images/emoji/qq/jie.gif','title' => "饥饿"),
        array('url' => '/assets/images/emoji/qq/fan.gif','title' => "饭"),
        array('url' => '/assets/images/emoji/qq/xiangqiao.gif','title' => "香蕉"),
        array('url' => '/assets/images/emoji/qq/kulou.gif','title' => "骷髅"),
        array('url' => '/assets/images/emoji/qq/gaotieyouchetou.gif','title' => "高铁右车头"),
        array('url' => '/assets/images/emoji/qq/gaotiezuochetou.gif','title' => "高铁左车头"),
        array('url' => '/assets/images/emoji/qq/guzhang.gif','title' => "鼓掌"),
        array('url' => '/assets/images/emoji/weibo/doge.png','title' => "wb_doge"),
        array('url' => '/assets/images/emoji/weibo/miao.png','title' => "wb_miao"),
        array('url' => '/assets/images/emoji/weibo/dog1.png','title' => "wb_dog1"),
        array('url' => '/assets/images/emoji/weibo/erha.png','title' => "wb_二哈"),
        array('url' => '/assets/images/emoji/weibo/dog2.png','title' => "wb_dog2"),
        array('url' => '/assets/images/emoji/weibo/dog3.png','title' => "wb_dog3"),
        array('url' => '/assets/images/emoji/weibo/dog4.png','title' => "wb_dog4"),
        array('url' => '/assets/images/emoji/weibo/dog5.png','title' => "wb_dog5"),
        array('url' => '/assets/images/emoji/weibo/dog6.png','title' => "wb_dog6"),
        array('url' => '/assets/images/emoji/weibo/dog7.png','title' => "wb_dog7"),
        array('url' => '/assets/images/emoji/weibo/dog8.png','title' => "wb_dog8"),
        array('url' => '/assets/images/emoji/weibo/dog9.png','title' => "wb_dog9"),
        array('url' => '/assets/images/emoji/weibo/dog10.png','title' => "wb_dog10"),
        array('url' => '/assets/images/emoji/weibo/dog11.png','title' => "wb_dog11"),
        array('url' => '/assets/images/emoji/weibo/dog12.png','title' => "wb_dog12"),
        array('url' => '/assets/images/emoji/weibo/dog13.png','title' => "wb_dog13"),
        array('url' => '/assets/images/emoji/weibo/dog14.png','title' => "wb_dog14"),
        array('url' => '/assets/images/emoji/weibo/dog15.png','title' => "wb_dog15"),
        array('url' => '/assets/images/emoji/weibo/aini.png','title' => "wb_爱你"),
        array('url' => '/assets/images/emoji/weibo/aoteman.png','title' => "wb_奥特曼"),
        array('url' => '/assets/images/emoji/weibo/baibai.png','title' => "wb_拜拜"),
        array('url' => '/assets/images/emoji/weibo/beishang.png','title' => "wb_悲伤"),
        array('url' => '/assets/images/emoji/weibo/bishi.png','title' => "wb_鄙视"),
        array('url' => '/assets/images/emoji/weibo/bizui.png','title' => "wb_闭嘴"),
        array('url' => '/assets/images/emoji/weibo/chanzui.png','title' => "wb_馋嘴"),
        array('url' => '/assets/images/emoji/weibo/chijing.png','title' => "wb_吃惊"),
        array('url' => '/assets/images/emoji/weibo/dahaqi.png','title' => "wb_打哈气"),
        array('url' => '/assets/images/emoji/weibo/dalian.png','title' => "wb_打脸"),
        array('url' => '/assets/images/emoji/weibo/ding.png','title' => "wb_顶"),
        array('url' => '/assets/images/emoji/weibo/feizao.png','title' => "wb_肥皂"),
        array('url' => '/assets/images/emoji/weibo/ganmao.png','title' => "wb_感冒"),
        array('url' => '/assets/images/emoji/weibo/guzhang.png','title' => "wb_鼓掌"),
        array('url' => '/assets/images/emoji/weibo/haha.png','title' => "wb_哈哈"),
        array('url' => '/assets/images/emoji/weibo/haixiu.png','title' => "wb_害羞"),
        array('url' => '/assets/images/emoji/weibo/hehe.png','title' => "wb_呵呵"),
        array('url' => '/assets/images/emoji/weibo/heixian.png','title' => "wb_黑线"),
        array('url' => '/assets/images/emoji/weibo/heng.png','title' => "wb_哼"),
        array('url' => '/assets/images/emoji/weibo/huaxin.png','title' => "wb_花心"),
        array('url' => '/assets/images/emoji/weibo/jiyan.png','title' => "wb_挤眼"),
        array('url' => '/assets/images/emoji/weibo/keai.png','title' => "wb_可爱"),
        array('url' => '/assets/images/emoji/weibo/kelian.png','title' => "wb_可怜"),
        array('url' => '/assets/images/emoji/weibo/ku.png','title' => "wb_哭"),
        array('url' => '/assets/images/emoji/weibo/kun.png','title' => "wb_困"),
        array('url' => '/assets/images/emoji/weibo/landelini.png','title' => "wb_懒得理你"),
        array('url' => '/assets/images/emoji/weibo/lei.png','title' => "wb_累"),
        array('url' => '/assets/images/emoji/weibo/nanhaier.png','title' => "wb_男孩儿"),
        array('url' => '/assets/images/emoji/weibo/nu.png','title' => "wb_怒"),
        array('url' => '/assets/images/emoji/weibo/numa.png','title' => "wb_怒骂"),
        array('url' => '/assets/images/emoji/weibo/nvhaier.png','title' => "wb_女孩儿"),
        array('url' => '/assets/images/emoji/weibo/qian.png','title' => "wb_钱"),
        array('url' => '/assets/images/emoji/weibo/qinqin.png','title' => "wb_亲亲"),
        array('url' => '/assets/images/emoji/weibo/shayan.png','title' => "wb_傻眼"),
        array('url' => '/assets/images/emoji/weibo/shengbing.png','title' => "wb_生病"),
        array('url' => '/assets/images/emoji/weibo/shenshou.png','title' => "wb_神兽"),
        array('url' => '/assets/images/emoji/weibo/shiwang.png','title' => "wb_失望"),
        array('url' => '/assets/images/emoji/weibo/shuai.png','title' => "wb_衰"),
        array('url' => '/assets/images/emoji/weibo/shuijiao.png','title' => "wb_睡觉"),
        array('url' => '/assets/images/emoji/weibo/sikao.png','title' => "wb_思考"),
        array('url' => '/assets/images/emoji/weibo/taikaixin.png','title' => "wb_太开心"),
        array('url' => '/assets/images/emoji/weibo/touxiao.png','title' => "wb_偷笑"),
        array('url' => '/assets/images/emoji/weibo/tu.png','title' => "wb_吐"),
        array('url' => '/assets/images/emoji/weibo/tuzi.png','title' => "wb_兔子"),
        array('url' => '/assets/images/emoji/weibo/wabishi.png','title' => "wb_挖鼻屎"),
        array('url' => '/assets/images/emoji/weibo/weiqu.png','title' => "wb_委屈"),
        array('url' => '/assets/images/emoji/weibo/xiaoku.png','title' => "wb_笑哭"),
        array('url' => '/assets/images/emoji/weibo/xiongmao.png','title' => "wb_熊猫"),
        array('url' => '/assets/images/emoji/weibo/xixi.png','title' => "wb_嘻嘻"),
        array('url' => '/assets/images/emoji/weibo/xu.png','title' => "wb_嘘"),
        array('url' => '/assets/images/emoji/weibo/yinxian.png','title' => "wb_阴险"),
        array('url' => '/assets/images/emoji/weibo/yiwen.png','title' => "wb_疑问"),
        array('url' => '/assets/images/emoji/weibo/youhengheng.png','title' => "wb_右哼哼"),
        array('url' => '/assets/images/emoji/weibo/yun.png','title' => "wb_晕"),
        array('url' => '/assets/images/emoji/weibo/zhuakuang.png','title' => "wb_抓狂"),
        array('url' => '/assets/images/emoji/weibo/zhutou.png','title' => "wb_猪头"),
        array('url' => '/assets/images/emoji/weibo/zuiyou.png','title' => "wb_最右"),
        array('url' => '/assets/images/emoji/weibo/zuohengheng.png','title' => "wb_左哼哼"),
        array('url' => '/assets/images/emoji/weibo/geili.png','title' => "wb_给力"),
        array('url' => '/assets/images/emoji/weibo/hufen.png','title' => "wb_互粉"),
        array('url' => '/assets/images/emoji/weibo/jiong.png','title' => "wb_囧"),
        array('url' => '/assets/images/emoji/weibo/meng.png','title' => "wb_萌"),
        array('url' => '/assets/images/emoji/weibo/shenma.png','title' => "wb_神马"),
        array('url' => '/assets/images/emoji/weibo/v5.png','title' => "wb_v5"),
        array('url' => '/assets/images/emoji/weibo/xi.png','title' => "wb_囍"),
        array('url' => '/assets/images/emoji/weibo/zhi.png','title' => "wb_织"),
        array('url' => '/assets/images/emoji/newtieba/hehe.png','title' => "(呵呵)"),
        array('url' => '/assets/images/emoji/newtieba/haha2.png','title' => "(哈哈)"),
        array('url' => '/assets/images/emoji/newtieba/tushe.png','title' => "(吐舌)"),
        array('url' => '/assets/images/emoji/newtieba/taikaixin.png','title' => "(太开心)"),
        array('url' => '/assets/images/emoji/newtieba/xiaoyan.png','title' => "(笑眼)"),
        array('url' => '/assets/images/emoji/newtieba/huaxin.png','title' => "(花心)"),
        array('url' => '/assets/images/emoji/newtieba/xiaoguai.png','title' => "(小乖)"),
        array('url' => '/assets/images/emoji/newtieba/guai.png','title' => "(乖)"),
        array('url' => '/assets/images/emoji/newtieba/wuzuixiao.png','title' => "(捂嘴笑)"),
        array('url' => '/assets/images/emoji/newtieba/huaji.png','title' => "(滑稽)"),
        array('url' => '/assets/images/emoji/newtieba/nidongde.png','title' => "(你懂的)"),
        array('url' => '/assets/images/emoji/newtieba/bugaoxing.png','title' => "(不高兴)"),
        array('url' => '/assets/images/emoji/newtieba/nu.png','title' => "(怒)"),
        array('url' => '/assets/images/emoji/newtieba/han.png','title' => "(汗)"),
        array('url' => '/assets/images/emoji/newtieba/heixian.png','title' => "(黑线)"),
        array('url' => '/assets/images/emoji/newtieba/lei.png','title' => "(泪)"),
        array('url' => '/assets/images/emoji/newtieba/zhenbang.png','title' => "(真棒)"),
        array('url' => '/assets/images/emoji/newtieba/pen.png','title' => "(喷)"),
        array('url' => '/assets/images/emoji/newtieba/jingku.png','title' => "(惊哭)"),
        array('url' => '/assets/images/emoji/newtieba/yinxian.png','title' => "(阴险)"),
        array('url' => '/assets/images/emoji/newtieba/bishi.png','title' => "(鄙视)"),
        array('url' => '/assets/images/emoji/newtieba/ku.png','title' => "(酷)"),
        array('url' => '/assets/images/emoji/newtieba/a.png','title' => "(啊)"),
        array('url' => '/assets/images/emoji/newtieba/kuanghan.png','title' => "(狂汗)"),
        array('url' => '/assets/images/emoji/newtieba/what.png','title' => "(what)"),
        array('url' => '/assets/images/emoji/newtieba/yiwen.png','title' => "(疑问)"),
        array('url' => '/assets/images/emoji/newtieba/suanshuang.png','title' => "(酸爽)"),
        array('url' => '/assets/images/emoji/newtieba/yamiedie.png','title' => "(呀咩爹)"),
        array('url' => '/assets/images/emoji/newtieba/weiqu.png','title' => "(委屈)"),
        array('url' => '/assets/images/emoji/newtieba/jingya.png','title' => "(惊讶)"),
        array('url' => '/assets/images/emoji/newtieba/shuijue.png','title' => "(睡觉)"),
        array('url' => '/assets/images/emoji/newtieba/xiaoniao.png','title' => "(笑尿)"),
        array('url' => '/assets/images/emoji/newtieba/wabi.png','title' => "(挖鼻)"),
        array('url' => '/assets/images/emoji/newtieba/tu.png','title' => "(吐)"),
        array('url' => '/assets/images/emoji/newtieba/xili.png','title' => "(犀利)"),
        array('url' => '/assets/images/emoji/newtieba/xiaohonglian.png','title' => "(小红脸)"),
        array('url' => '/assets/images/emoji/newtieba/landeli.png','title' => "(懒得理)"),
        array('url' => '/assets/images/emoji/newtieba/mianqiang.png','title' => "(勉强)"),
        array('url' => '/assets/images/emoji/newtieba/aixin.png','title' => "(爱心)"),
        array('url' => '/assets/images/emoji/newtieba/xinsui.png','title' => "(心碎)"),
        array('url' => '/assets/images/emoji/newtieba/meigui.png','title' => "(玫瑰)"),
        array('url' => '/assets/images/emoji/newtieba/liwu.png','title' => "(礼物)"),
        array('url' => '/assets/images/emoji/newtieba/caihong.png','title' => "(彩虹)"),
        array('url' => '/assets/images/emoji/newtieba/taiyang.png','title' => "(太阳)"),
        array('url' => '/assets/images/emoji/newtieba/xingxingyueliang.png','title' => "(星星月亮)"),
        array('url' => '/assets/images/emoji/newtieba/qianbi.png','title' => "(钱币)"),
        array('url' => '/assets/images/emoji/newtieba/chabei.png','title' => "(茶杯)"),
        array('url' => '/assets/images/emoji/newtieba/dangao.png','title' => "(蛋糕)"),
        array('url' => '/assets/images/emoji/newtieba/damuzhi.png','title' => "(大拇指)"),
        array('url' => '/assets/images/emoji/newtieba/shengli.png','title' => "(胜利)"),
        array('url' => '/assets/images/emoji/newtieba/haha.png','title' => "(haha)"),
        array('url' => '/assets/images/emoji/newtieba/OK.png','title' => "(OK)"),
        array('url' => '/assets/images/emoji/newtieba/shafa.png','title' => "(沙发)"),
        array('url' => '/assets/images/emoji/newtieba/shouzhi.png','title' => "(手纸)"),
        array('url' => '/assets/images/emoji/newtieba/xiangqiao.png','title' => "(香蕉)"),
        array('url' => '/assets/images/emoji/newtieba/bianbian.png','title' => "(便便)"),
        array('url' => '/assets/images/emoji/newtieba/yaowan.png','title' => "(药丸)"),
        array('url' => '/assets/images/emoji/newtieba/honglingjin.png','title' => "(红领巾)"),
        array('url' => '/assets/images/emoji/newtieba/lazhu.png','title' => "(蜡烛)"),
        array('url' => '/assets/images/emoji/newtieba/yinle.png','title' => "(音乐)"),
        array('url' => '/assets/images/emoji/newtieba/dengpao.png','title' => "(灯泡)"),
    );
    global $search, $replace;
    if (!is_array($search)) {
        $search = [];
    }
    if (!is_array($replace)) {
        $replace = [];
    }
    if (empty($search)) {
        $dir = boxmoe_themes_dir();
        foreach ($emoji as $smiley_data) {
            $img_tag = '<img src="' . $dir . $smiley_data['url'] . '" alt="' . esc_attr($smiley_data['title']) . '" title="' . esc_attr($smiley_data['title']) . '" />';
            $search[] = "[{$smiley_data['title']}]";
            $replace[] = $img_tag; 
        }
    }
    $comment_content = str_replace($search, $replace, $comment_content);

    return $comment_content;
}