<?php
/**
 * @link https://www.boxmoe.com
 * @package lolimeow
 */
defined('ABSPATH') or die('This file can not be loaded directly.');
if ( !comments_open() ) return;
date_default_timezone_set('PRC');
$closeTimer = (strtotime(date('Y-m-d G:i:s'))-strtotime(get_the_time('Y-m-d G:i:s')))/86400;
if(!isset($user_ID)) {
  $user_ID=null;
}
?>
												
					    <?php if ( have_comments() ){?>
                      <div id="comments" class="comments-area">
                        <h3 class="comments-heading text-center">
                          <?php $comments_number = get_comments_number();
	                        if ( 0 == ! $comments_number ) {
	                        if ( 1 === $comments_number ) {
	                        _x( 'One comment', 'comments title', 'boxmoe' );
	                        } else {
	                        printf(_nx('<span><i class="fa fa-comments"></i> 文章有（%1$s）条网友点评</span>','<span><i class="fa fa-comments"></i> 文章有（%1$s）条网友点评</span>',$comments_number,'comments title','boxmoe'),number_format_i18n( $comments_number ));
	                        }}?>
                        </h3>					
                        <ul class="comments-list mx-auto">					
							<?php
                                 wp_list_comments( 'type=comment&callback=boxmoe_comments_list&end-callback=boxmoe_end_comment' );
                                 wp_list_comments( 'type=pings&callback=boxmoe_comments_list&end-callback=boxmoe_end_comment' );
                            ?> 					
                        </ul>					
                        <div class="pagenav text-center"><?php paginate_comments_links('prev_next=0');?></div>
                      </div>						
                        <?php } else {?>					
                        <h3 class="comments-heading text-center"><span><i class="fa fa-comments"></i> 暂无评论</span></h3>
						<?php } ?>
						<?php if ( ! comments_open() && get_comments_number() ) { ?>					
						<h5 class="title-normal  thw-sept text-center"><?php esc_html_e( '评论已关闭！' , 'ui_boxmoe_com' ); ?></h5>					    
						<?php } else {?>
                      <div id="respond_com"></div>						
                      <div id="respond" class="col-lg-10 col-md-10 mx-auto">
                        <h5 class="title-normal text-center" id="respond_com">
                          <i class="fa fa-commenting"></i>发表评论
                          <a id="cancel-comment-reply-link" href="javascript:;" class="btn btn-sm btn-warning btn-comment" style="display:none;">取消回复</a></h5>
                        <form id="commentform" name="commentform" action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post">
						  <?php if ( is_user_logged_in() ) { ?>
						  <div class="author align-items-center mb-2">
						  <?php $current_user = wp_get_current_user(); echo get_avatar( $current_user->user_email, 60,'','',array('class'=>array(''))); ?> 
						   <div class="name ps-3">
						    <span>你好，<?php echo $user_identity; ?></span>
						     <div class="stats">
						     <a href="<?php echo wp_logout_url(get_permalink()); ?>" >[ 退出登录 &raquo; ]</a>
						     </div>
						   </div>
                          </div>
						  <?php }?>
						  <?php if ( ! $user_ID  && !is_user_logged_in()&& '' != $comment_author ) : ?>
						  <div class="author align-items-center mb-2">
						  <?php echo get_avatar( $comment_author_email, 60,'','',array('class'=>array(''))); ?> 
						   <div class="name ps-3">
						    <span><?php printf(__('你好，%s，'), $comment_author); ?></span>
						     <div class="stats">
						     <a href="javascript:toggleCommentAuthorInfo();" id="toggle-comment-author-info">[ 切换评论身份 ]</a>
						     </div>
						   </div>
                          </div>
					<script type="text/javascript" charset="utf-8">
						//<![CDATA[
                        function toggleCommentAuthorInfo() {
							jQuery('#comment-author-info').slideToggle('slow', function(){
								if ( jQuery('#comment-author-info').css('display') == 'none' ) {
								var changeMsg = "[ 切换评论身份 ]";	
								jQuery('#toggle-comment-author-info').html(changeMsg);
								} else {
								var closeMsg = "[ 收起来 ]";	
								jQuery('#toggle-comment-author-info').html(closeMsg);
								}
							});
						}
						
						//]]>
					</script>						  
						  <?php endif; ?>
						   <?php if ( !$user_ID && !is_user_logged_in() ): ?>	
						  <div class="row" id="comment-author-info">
                            <div class="col-md-4">
                              <div class="input-group mb-4">
                                <span class="input-group-text"><i class="fa fa-user-circle"></i></span>
								<input type="text" name="author" id="author" class="form-control" value="<?php echo $comment_author; ?>" placeholder="昵称 *" tabindex="1">
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="input-group mb-4">
                               <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                               <input type="email" name="email" id="email" class="form-control" value="<?php echo $comment_author_email; ?>" placeholder="邮箱 *" tabindex="2">
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="input-group mb-4">
                               <span class="input-group-text"><i class="fa fa-link"></i></span>
                               <input type="text" name="url" id="url" class="form-control" value="<?php echo $comment_author_url; ?>" placeholder="网址" size="22" tabindex="3">
                              </div>							
                            </div>
                          </div>
						  <?php endif; ?>
                          <div class="row">
                            <div class="col-md-12">
								<div class="form-group mb-4">
                                  <textarea class="form-control" rows="4" name="comment" id="comment" tabindex="4" placeholder="<?php echo get_boxmoe('diy_comment_text','你可以在这里输入评论内容...') ?>"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mx-auto clearfix text-center">
                              <div class="dropup">
                                <div class="comt-addsmilies" href="javascript:;" id="boxmoe_smilies" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <span>
                                    <i class="fa fa-smile-o"></i>表情</span>
                                </div>
                                <div class="dropdown-menu" aria-labelledby="boxmoe_smilies">
                                  <div class="dropdown-smilie scroll-y">
                                    <?php boxmoe_smilies() ?>
                                  </div>
                                </div>
                              </div>
                              <?php comment_id_fields(); do_action('comment_form', $post->ID); ?>
                              <button class="btn btn-outline-dark btn-comment" name="submit" type="submit" id="submit" tabindex="5"><?php echo get_boxmoe('diy_comment_btn','发送评论') ?></button>
							  </div>
                          </div>
                          </form>
                      </div>						
                      <?php }?>

