<?php
/**
 * @link https://www.boxmoe.com
 * @package lolimeow
 */
//boxmoe.com===安全设置=阻止直接访问主题文件
if(!defined('ABSPATH')){echo'Look your sister';exit;}
if(!isset($user_ID)) {
    $user_ID=null;
  }
  ?>
                <div class="post-comments" id="comments-container">
                    <?php if (get_boxmoe('boxmoe_comment_switch')) :?>
                    <h2 class="mb-7" id="comments-container">评论（已关闭）</h2>
                    <?php else:?>
                    <h2>评论（<?php comments_number('0', '1', '%'); ?>）</h2>
                    <?php endif;?>
                    <?php if (get_boxmoe('boxmoe_comment_switch') == false) :?>
                    <div class="comments-toggle">
                        <i class="fa fa-chevron-down"></i>
                        <span>查看评论列表</span>
                    </div>
                    <div class="comments-list">
                        <?php

                        if (have_comments()) {
                            $comments = get_comments(array(
                                'post_id' => get_the_ID(),
                                'status' => 'approve',
                                'order' => 'ASC'
                            ));                            
                            $comments_by_parent = array();
                            foreach ($comments as $comment) {
                                $parent_id = $comment->comment_parent;
                                if (!isset($comments_by_parent[$parent_id])) {
                                    $comments_by_parent[$parent_id] = array();
                                }
                                $comments_by_parent[$parent_id][] = $comment;
                            }                           
                            $comment_args = array(
                                'max_depth' => 5,
                                'reply_text' => '<i class="fa fa-reply"></i>回复',
                                'page' => max(1, get_query_var('cpage')),
                                'per_page' => get_option('comments_per_page'),
                                'reverse_top_level' => false
                            );
                            
                            $comment_args['current_page'] = $comment_args['page'];
                            function display_comments($parent_id, $comments_by_parent, $comment_args, $depth) {
                                if($depth === 1) {
                                    global $page_comments;
                                    $per_page = get_option('comments_per_page');
                                    $current_page = isset($comment_args['current_page']) ? $comment_args['current_page'] : 1;
                                    
                                    // 计算当前页面应该显示的评论起始位置
                                    $start = ($current_page - 1) * $per_page;
                                    $end = $start + $per_page;
                                    $comment_count = 0;
                                }
                                
                                if (!empty($comments_by_parent[$parent_id])) {
                                    foreach ($comments_by_parent[$parent_id] as $comment) {
                                        if($depth === 1) {
                                            $comment_count++;
                                            if($comment_count <= $start || $comment_count > $end) continue;
                                        }
                                        ?>
                                        <div class="comment-level-<?php echo $depth; ?>">
                                            <?php boxmoe_comment($comment, $comment_args, $depth); ?>
                                            <?php display_comments($comment->comment_ID, $comments_by_parent, $comment_args, $depth + 1); ?>
                                        </div>
                                        <?php
                                    }
                                }
                            }
                            display_comments(0, $comments_by_parent, $comment_args, 1);
                        } else {
                            echo '<div class="comment-item"><div class="comment-content"><div class="comment-text"><p>暂无评论</p></div></div></div>';
                        }
                        ?>
                    </div>
                    <hr class="horizontal dark">
                    <?php if (get_comment_pages_count() > 1): ?>
                    <div class="comments-pagination">
                        <?php paginate_comments_links(array(
                            'prev_text' => '<i class="fa fa-angle-left"></i>',
                            'next_text' => '<i class="fa fa-angle-right"></i>',
                            'type' => 'list',
                            'before_page_number' => '<span class="page-number">',
                            'after_page_number' => '</span>',
                            'current' => max(1, get_query_var('cpage')),
                        )); ?>
                    </div>
                    <hr class="horizontal dark">
                    <?php endif; ?>
                    <div id="respond" class="comment-respond">
                        <div class="comment-new" style="display: none;">
                            <div class="new-content comment-level-1"></div>
                        </div>
                        <div class="comment-message">
                            <div class="message-content"></div>
                        </div>                                   
                        <h3 id="reply-title" class="comment-reply-title">
                            发表评论
                            <small><a rel="nofollow" id="cancel-comment-reply-link" href="#respond" style="display:none;">取消回复</a></small>
                        </h3>             
                        <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform" class="comment-form">
                            <?php wp_nonce_field('comment_nonce', 'comment_nonce_field'); ?>
                            <?php comment_id_fields(); ?>
                            <div class="comment-user-info">
                            <div class="user-info-ck">
                                <?php if (is_user_logged_in() ):?>
                                <div class="user-meta">
                                        <?php echo get_avatar(get_current_user_id(), 48); ?>
                                        <div class="user-info">
                                            <span class="user-name"><?php echo esc_attr(wp_get_current_user()->display_name); ?></span>
                                            <span class="user-email"><?php echo esc_attr(wp_get_current_user()->user_email); ?></span>
                                            <input type="hidden" name="author" value="<?php echo esc_attr(wp_get_current_user()->display_name); ?>">
                                            <input type="hidden" name="email" value="<?php echo esc_attr(wp_get_current_user()->user_email); ?>">
                                        </div>
                                        <div class="user-start">
                                            [当前状态：已登录，用户]
                                        </div>
                                    </div>
                                    <?php endif;?>
                                    <?php if (!is_user_logged_in()) :?>
                                        <div class="user-meta">
                                        <?php 
                                        $comment_author = get_comment_author_info('comment_author');
                                        $comment_author_email = get_comment_author_info('comment_author_email');
                                        echo get_avatar($comment_author_email, 60,'',''); 
                                        ?>
                                        <div class="user-info">
                                            <span class="user-name"><?php echo !empty($comment_author) ? esc_attr($comment_author) : '访客'; ?></span>
                                            <span class="user-email"><?php echo !empty($comment_author_email) ? esc_attr($comment_author_email) : '未填写邮箱'; ?></span>
                                        </div>
                                        <div class="user-start">
                                           <?php if (!empty($comment_author)) {
                                            echo '[当前状态：未登录，访客]';
                                           }else{
                                            if (!get_boxmoe('boxmoe_comment_login_switch')) :
                                            echo '[填写昵称邮箱后可以评论]';
                                            else:
                                            echo '[登录后可以评论]';
                                            endif;
                                           }?> 
                                        </div>
                                    </div>    
                                    <?php endif;?>
                                    <?php if (! is_user_logged_in() ):?>
                                    <?php if (!get_boxmoe('boxmoe_comment_login_switch')) :?>
                                    <button type="button" class="switch-account-btn">
                                        <i class="fa fa-refresh"></i>
                                        <?php $comment_author = get_comment_author_info('comment_author');
                                        $comment_author_email = get_comment_author_info('comment_author_email');
                                        if (!empty($comment_author) && !empty($comment_author_email)) {
                                            echo '切换信息';
                                        }else{
                                            echo '输入信息';
                                        }
                                        ?>
                                    </button>
                                    <?php else:?>
                                    <a href="<?php echo wp_login_url(); ?>" target="_blank" type="button" class="switch-account-btn">
                                        <i class="fa fa-sign-in"></i>
                                        用户登录
                                    </a>
                                    <?php endif;?>
                                    <?php else:?>
                                    <a href="<?php echo wp_logout_url(); ?>" type="button" class="switch-account-btn">
                                        <i class="fa fa-sign-out"></i>
                                        退出登录
                                    </a>
                                    <?php endif;?>
                                </div>
                                <?php if (!get_boxmoe('boxmoe_comment_login_switch')) :?>
                                <?php if (! is_user_logged_in() ):?>
                                <div class="guest-inputs" >                                   
                                    <div class="input-group">
                                        <span class="input-group-text" id="author"><i class="fa fa-user"></i></span>
                                        <input id="author" class="form-control" name="author" type="text" tabindex="1" 
                                            value="<?php echo esc_attr(get_comment_author_info('comment_author')); ?>" 
                                            placeholder="昵称 *">
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-text" id="email"><i class="fa fa-envelope"></i></span>
                                        <input id="email" class="form-control" name="email" type="email" tabindex="2" 
                                            value="<?php echo esc_attr(get_comment_author_info('comment_author_email')); ?>" 
                                            placeholder="邮箱 *">
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-text" id="url"><i class="fa fa-link"></i></span>
                                        <input id="url" class="form-control" name="url" type="url" tabindex="3" 
                                            value="<?php echo esc_attr(get_comment_author_info('comment_author_url')); ?>" 
                                            placeholder="网址(选填)">
                                    </div>
                                </div>
                                <?php endif;?>
                                <?php endif;?>
                            </div>
                            <?php if (!is_user_logged_in() &&  get_boxmoe('boxmoe_comment_login_switch')) :?>
                                <?php else:?>
                            <div class="comment-form-comment">
                                <textarea id="comment" name="comment" tabindex="4" placeholder="写下您的评论..." rows="4" required></textarea>                                
                                <div class="comment-toolbar">
                                    <div class="toolbar-left">
                                        <button type="button" class="toolbar-btn emoji-btn" title="插入表情">
                                            <i class="fa fa-smile-o"></i>
                                        </button>
                                        <div class="emoji-panel">
                                            <div class="emoji-tabs">
                                                <span data-tab="emoji" class="active">表情</span>
                                                <span data-tab="custom">颜文字</span>
                                            </div>
                                            <div class="emoji-content"></div>
                                        </div>
                                        <button type="button" class="toolbar-btn code-btn" title="插入代码">
                                            <i class="fa fa-code"></i>
                                        </button>
                                    </div>
                                    <div class="toolbar-right">
                                        <label class="private-comment">
                                            <input class="form-check-input" type="checkbox" name="private_comment" id="private_comment">
                                            <label class="form-check-label" for="private_comment">仅作者可见</label>
                                        </label>
                                        <div class="form-submit">
                                             <?php do_action('comment_form', $post->ID); ?>
                                            <button type="submit" name="submit" type="submit" id="submit" tabindex="5" class="submit-btn">
                                                <i class="fa fa-paper-plane"></i> 发表评论
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="code-panel">
                                    <div class="code-header">
                                        <h5>插入代码</h5>
                                        <button type="button" class="close-btn">&times;</button>
                                    </div>
                                    <div class="code-body">
                                        <textarea class="code-input form-control" rows="6" placeholder="输入代码..."></textarea>
                                    </div>
                                    <div class="code-footer">
                                        <button type="button" class="insert-code-btn btn btn-primary btn-sm">插入</button>
                                    </div>
                                </div>
                            </div>
                            <?php endif;?>                          
                        </form>  
                    </div>
                    <?php else:?>
                    <div class="comments-list">
                        <div class="comment-item">
                            <div class="comment-content">
                                <div class="comment-text">
                                    <p>评论已关闭</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif;?>
                </div>



