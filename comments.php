<?php
defined('ABSPATH') or die('This file can not be loaded directly.');

/*global $comment_ids; $comment_ids = array();
// global $loguser;
foreach ( $comments as $comment ) {
	if (get_comment_type() == "comment") {
		$comment_ids[get_comment_id()] = ++$comment_i;
	}
} */

if ( !comments_open() ) return;

date_default_timezone_set('PRC');
$closeTimer = (strtotime(date('Y-m-d G:i:s'))-strtotime(get_the_time('Y-m-d G:i:s')))/86400;
?>


 <div id="comments" class="comments-area thw-sept wow bounceInUp">
  <h3 class="comments-heading"><?php
									$comments_number = get_comments_number();
									if ( 0 == ! $comments_number ) {
										if ( 1 === $comments_number ) {
											/* translators: %s: post title */
											_x( 'One comment', 'comments title', 'meowdata' );
										} else {
											printf(
												/* translators: 1: number of comments, 2: post title */
												_nx(
													'%1$s Comment',
													'%1$s Comments',
													$comments_number,
													'comments title',
													'meowdata'
												),
												number_format_i18n( $comments_number )
											);
										}
									}
									?> </h3>
  <ul class="comments-list">
  
									<?php
										wp_list_comments( 'type=comment&callback=meowdata_comments_list&end-callback=meowdata_end_comment' );
                                        wp_list_comments( 'type=pings&callback=meowdata_comments_list&end-callback=meowdata_end_comment' );
									?> 
									</ul>
<div class="pagenav text-center"><?php paginate_comments_links('prev_next=0');?></div>
									</div><!-- Post comment end -->	
<?php if ( ! comments_open() && get_comments_number() ) : ?>
									<?php if ( is_single() ) : ?>
										<h3 class="title-normal  thw-sept text-center"><?php esc_html_e( '评论已关闭！' , 'meowdata' ); ?></h3>
									<?php endif; ?>
								<?php endif; ?>	
								
<h3 class="title-normal thw-sept text-center wow swing" id="respond_com">留下你的评论</h3>
<div class="clearfix text-center">
									*评论支持代码高亮&lt;pre class=&quot;prettyprint linenums&quot;&gt;代码&lt;/pre&gt;
									</div>
<div id="respond">
<form id="commentform" name="commentform" action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post">                                   
<?php if ( is_user_logged_in() ) { ?><div class="row justify-content-center mb10"><div class="col-md-12"><a href="<?php echo get_option('siteurl'); ?>/user" class="btn btn-sm btn-info">您已登录:<?php echo $user_identity; ?></a> <a href="<?php echo wp_logout_url(get_permalink()); ?>" class="btn btn-sm br"title="退出登录">退出 &raquo;</a></div></div>	<?php }?>									
<div class="row justify-content-center mb10"><div class="col-md-4"><a id="cancel-comment-reply-link" href="javascript:;"  class="btn btn-sm btn-info" style="display:none;"><?php echo __('取消回复', 'mogu') ?></a></div></div>
<?php if ( ! $user_ID  && '' != $comment_author ) : ?>
<div class="row justify-content-center mb10"><div class="col-md-12">
<div class="alert alert-success">
<?php printf(__('你好，%s，'), $comment_author); ?><a href="javascript:toggleCommentAuthorInfo();" id="toggle-comment-author-info">[ 切换评论身份 ]</a>
<script type="text/javascript" charset="utf-8">
						//<![CDATA[
						var changeMsg = "<i>[ 切换评论身份 ]</i>";
						var closeMsg = "<i>[ 收起来 ]</i>";
						function toggleCommentAuthorInfo() {
							jQuery('#comment-author-info').slideToggle('slow', function(){
								if ( jQuery('#comment-author-info').css('display') == 'none' ) {
								jQuery('#toggle-comment-author-info').html(changeMsg);
								} else {
								jQuery('#toggle-comment-author-info').html(closeMsg);
								}
							});
						}
						jQuery(document).ready(function(){
							jQuery('#comment-author-info').hide();
						});
						//]]>
					</script>
					</div></div></div>
 <?php endif; ?> 
 <?php if ( ! $user_ID ): ?>	
                                          <div class="row" id="comment-author-info">
                                                <div class="col-md-4">
                                                <div class="form-group">
												<input type="text" name="author" id="author" class="form-control" value="<?php echo $comment_author; ?>" placeholder="<?php echo __('昵称 *', 'meowdata') ?>" tabindex="1">
                                                </div>
                                          </div><!-- Col 4 end -->
                                          <div class="col-md-4">
                                                <div class="form-group">
												<input type="email" name="email" id="email" class="form-control" value="<?php echo $comment_author_email; ?>" placeholder="<?php echo __('邮箱 *', 'meowdata') ?>"  tabindex="2" />
                                                </div>
                                          </div>
                                          <div class="col-md-4">
                                                <div class="form-group">
                                                <input type="text" name="url" id="url" class="form-control" value="<?php echo $comment_author_url; ?>" placeholder="<?php echo __('网址', 'meowdata') ?>" size="22" tabindex="3" />	
                                                </div>
                                          </div>
										   </div><?php endif; ?>   
                                          <div class="row">
                                          <div class="col-md-12">
                                                <div class="form-group">
												<textarea class="form-control  required-field" rows="5" name="comment" id="comment" tabindex="4" placeholder="你可以在这里输入评论内容..."></textarea>
                                                </div>
                                          </div><!-- Col 12 end -->
                                    </div><!-- Form row end -->
                                    <div class="clearfix text-center">
									<div class="comt-tips"><?php comment_id_fields(); do_action('comment_form', $post->ID); ?></div>
                                          <button class="btn btn-1 btn-outline-success" name="submit" type="submit" id="submit" tabindex="5">发表评论</button> 
                                    </div>									
                                    </form>									
				
</div>								