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
<?php if ( have_comments() ){
	$comments_number = get_comments_number();
	if ( 0 == ! $comments_number ) {
	if ( 1 === $comments_number ) {
	_x( 'One comment', 'comments title', 'boxmoe' );
	} else {
	printf(_nx('<h3 class="comments-heading text-center" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="点击打开或者关闭评论内容">
                  <span class="" data-bs-toggle="collapse" href="#comments-container" role="button" aria-expanded="false" aria-controls="comments-container">
                    <i class="fa fa-comments"></i>文章有（%1$s）条网友点评</span></h3>',
				'<h3 class="comments-heading text-center" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="点击打开或者关闭评论内容">
                  <span class="" data-bs-toggle="collapse" href="#comments-container" role="button" aria-expanded="false" aria-controls="comments-container">
                    <i class="fa fa-comments"></i>文章有（%1$s）条网友点评</span></h3>',$comments_number,'comments title','boxmoe'),number_format_i18n( $comments_number ));
	}}	
	?>
                <div class="thw-sept"></div>
                <div class="collapse show" id="comments-container">
                  <div id="comments" class="comments-area">						  
                    <ul class="comments-list mx-auto">
							<?php
                                 wp_list_comments( 'type=comment&callback=boxmoe_comments_list&end-callback=boxmoe_end_comment' );
                                 wp_list_comments( 'type=pings&callback=boxmoe_comments_list&end-callback=boxmoe_end_comment' );
                            ?> 					
                    </ul>
                    <div class="col-lg-12 col-md-12 pagenav">
                      <nav class="fenye d-flex justify-content-center">
                        <span class="pagination">
                          <?php paginate_comments_links('prev_next=0');?>
                        </span>
                      </nav>
                    </div>
                  </div>
                </div><?php } else {?>
				<h3 class="comments-heading text-center">
                  <span>
                    <i class="fa fa-comments"></i>暂无评论</span>
                </h3>				
						<?php } ?>
						<?php if ( ! comments_open() && get_comments_number() ) { ?>
				<h3 class="comments-heading text-center">
                  <span>
                    <i class="fa fa-comments"></i>评论已关闭！</span>
                </h3>							
						<?php } else {?>
				<div id="respond_com"></div>
				<?php if (get_option('comment_registration') && !is_user_logged_in()) {?>
				<div class="col-lg-10 col-md-10 mx-auto">
				<div class="no_comment">
				<H5 class="title-normal text-center">当前仅支持登录后发布评论</H5>
                    <div class="user-wrapper">
                      <div class="user-no-login">
                        <span class="user-login">
                          <a href="<?php echo home_url('/login?r='); echo home_url('/user'); ?>" class="signin-loader z-bor">登录</a>
                          <b class="middle-text">
                            <span class="middle-inner">or</span></b>
                        </span>
                        <span class="user-reg">
                          <a href="<?php echo home_url('/reg'); ?>" class="signup-loader l-bor">注册</a></span>
                      </div>
                    </div>				
				</div>
				</div><?php } else {?>
                <div id="respond" class="col-lg-10 col-md-10 mx-auto">
                  <h5 class="title-normal text-center" id="respond_com">
                    <i class="fa fa-commenting"></i>发表评论
                     <a id="cancel-comment-reply-link" href="javascript:;" class="btn btn-primary btn-sm" style="display:none;">取消回复</a></h5>
                        <form id="commentform" name="commentform" action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post">
                        <div class="row" id="comment-author-info">
                        <div class="col-md-10 mx-auto"> <?php if (! is_user_logged_in() ):?>
                                    <div class="input-form">
                                       <div class="input-group">
                                          <span class="input-group-text input-form-rtl bm0">
                                          <i class="fa fa-user-circle"></i>
                                          </span>
                                          <input type="text" name="author" id="author" class="form-control form-control-sm br0 bm0" value="<?php echo $comment_author; ?>" placeholder="昵称 *" tabindex="1">
                                       </div>
                                       <div class="input-group">
                                          <span class="input-group-text bl0 bm0">
                                          <i class="fa fa-envelope"></i>
                                          </span>
                                          <input type="email" name="email" id="email" class="form-control form-control-sm bl0 br0 bm0" value="<?php echo $comment_author_email; ?>" placeholder="邮箱 *" tabindex="2">
                                       </div>
                                       <div class="input-group ">
                                          <span class="input-group-text bl0 bm0">
                                          <i class="fa fa-link"></i>
                                          </span>
                                          <input type="text" name="url" id="url" class="form-control form-control-sm input-form-rtr bm0" value="<?php echo $comment_author_url; ?>" placeholder="网址" size="22" tabindex="3">
                                       </div>
                                    </div> <?php endif; ?>
                                    <div class="comment-text-form">
                                       <div class="form-group">
                                          <textarea class="form-control  <?php if ( is_user_logged_in() ){echo 'login';}?>" rows="4" name="comment" id="comment" tabindex="4" placeholder="<?php echo get_boxmoe('diy_comment_text','你可以在这里输入评论内容...') ?>"></textarea>
                                       </div>
                                       <div class="comment-submit-btn">
                                          <div class="comment-submit-btn-l">
                                             <div class="dropup">
                                                <div class="comt-addsmilies" href="javascript:;" id="boxmoe_smilies" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                   <span>
                                                   <i class="fa fa-smile-o"></i></span>
                                                </div>
                                                <div class="dropdown-menu" aria-labelledby="boxmoe_smilies">
                                                  <div class="dropdown-smilie scroll-y">
                                                  <?php boxmoe_smilies() ?>
                                                  </div>                               
                                                </div>
                                                <div class="img-up"></div>
                                             </div>
                                          </div>
                                          <div class="comment-submit-btn-r">
                                            <?php if ( ! $user_ID  && !is_user_logged_in()&& '' != $comment_author ) : ?>
                                              <span type="button" data-bs-toggle="tooltip" data-bs-placement="top"
                                                data-bs-title="当前[游客身份]:<?php printf(__('%s'), $comment_author); ?>">
                                              <?php echo get_avatar($comment_author_email, 60,''); ?> </span><?php endif; ?>
                                              <?php if ( is_user_logged_in() ):?>
                                                <span type="button" data-bs-toggle="tooltip" data-bs-placement="top"
                                                data-bs-title="当前[会员身份]:<?php echo $user_identity; ?>">
                                                <?php $current_user = wp_get_current_user(); echo get_avatar( $current_user->user_id, 60); ?> 
                                              </span><?php endif; ?>
                                              <?php comment_id_fields(); do_action('comment_form', $post->ID); ?>
                                             <button class="box-btn moe" name="submit" type="submit" id="submit" tabindex="5"><?php echo get_boxmoe('diy_comment_btn','发送评论') ?></button>
                                          </div>
                                       </div>
                                    </div> 

                                    </div>
                                    </div>                                                                
                          </form>
                      </div>						
                     <?php } ?>
					 <?php }?>