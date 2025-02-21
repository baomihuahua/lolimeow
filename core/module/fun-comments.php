<?php
// 安全设置--------------------------boxmoe.com--------------------------
if(!defined('ABSPATH')){
    echo'Look your sister';
    exit;
}
// 添加 session 处理函数
function init_comment_session() {
    if (!session_id()) {
        session_start();
    }
}
add_action('init', 'init_comment_session');
function boxmoe_comment($comment, $args = array(), $depth = 1) {
    $GLOBALS['comment'] = $comment;
    $defaults = array(
        'max_depth' => 5,
        'reply_text' => '回复'
    );
    $args = wp_parse_args($args, $defaults);
    $post_author_id = get_post_field('post_author', $comment->comment_post_ID);
    $current_user_id = get_current_user_id();
    $is_private = get_comment_meta($comment->comment_ID, 'private_comment', true);
    ?>
    <div id="comment-<?php comment_ID(); ?>" class="comment-item <?php echo $depth > 1 ? 'child' : 'parent'; ?>">
            <div class="comment-avatar">
            <img src="<?php echo boxmoe_lazy_load_images(); ?>" data-src="<?php echo boxmoe_get_avatar_url($comment->comment_author_email, 60); ?>" alt="评论头像" class="lazy">
            </div>
        <div class="comment-content">
            <div class="comment-meta">
                <span class="comment-author">
                    <?php 
                    $comment_url = get_comment_author_url();
                    if (!empty($comment_url) && $comment_url !== 'http://') {
                        echo '<a href="' . esc_url($comment_url) . '" target="_blank" rel="nofollow">' . get_comment_author() . '</a>';
                    } else {
                        comment_author();
                    }
                    ?>
                </span>
                <?php if (user_can($comment->user_id, 'administrator')): ?>
                    <span class="comment-badge"><?php echo get_boxmoe('boxmoe_comment_blogger_tag')?get_boxmoe('boxmoe_comment_blogger_tag'):'博主'; ?></span>
                <?php endif; ?>
                <span class="comment-date"><?php comment_date('Y年m月d日'); ?></span>
            </div>
            <div class="comment-text">
                <?php 
                if ($is_private) {
                    if ($current_user_id && 
                        ($current_user_id == $post_author_id || 
                         $current_user_id == $comment->user_id || 
                         ($comment->comment_parent > 0 && $current_user_id == get_comment($comment->comment_parent)->user_id))
                    ) {
                        echo esc_html(get_comment_text());
                        echo '<span class="private-comment-badge">仅作者可见</span>';
                    } else {
                        echo '<p class="private-comment-notice">此评论仅作者可见</p>';
                    }
                } else {
                    echo esc_html(get_comment_text());
                }
                ?>   
                <?php if ( $comment->comment_approved == '0' ) : ?>
                    <span class="comment-awaiting-moderation">您的评论正在等待审核...</span>
                <?php endif; ?>
            </div>


            <div class="comment-actions">
                <?php
                comment_reply_link(array_merge($args, array(
                    'reply_text' => '<i class="fa fa-reply"></i>回复',
                    'depth' => $depth,
                    'max_depth' => $args['max_depth'],
                    'before' => '',
                    'after' => ''
                )));
                ?>
            </div>
        </div>
        <?php if ($depth < $args['max_depth']) : ?>
        <?php endif; ?>
    </div>
    <?php
}
function boxmoe_comment_add_at($comment_text, $comment) {  
    if ($comment->comment_parent > 0) {
        $parent_comment = get_comment($comment->comment_parent);
        if ($parent_comment) {
            $parent_author = get_comment_author($parent_comment);
            $comment_text = sprintf(
                '<span class="comment-at">@%s</span> %s',
                esc_html($parent_author),
                esc_html($comment_text)
            );
        }
    }
    return $comment_text;  
}
add_filter('comment_text', 'boxmoe_comment_add_at', 10, 2);

function save_private_comment_status($comment_id) {
    if (isset($_POST['private_comment'])) {
        add_comment_meta($comment_id, 'private_comment', '1', true);
    }
}
add_action('comment_post', 'save_private_comment_status');

// session
function save_comment_author_info($comment_ID, $comment_approved, $commentdata) {
    if ($comment_approved !== 'spam') {
        $_SESSION['comment_author'] = $commentdata['comment_author'];
        $_SESSION['comment_author_email'] = $commentdata['comment_author_email'];
        $_SESSION['comment_author_url'] = $commentdata['comment_author_url'];

        setcookie('author', $commentdata['comment_author'], time() + 7 * 24 * 3600, '/');
        setcookie('email', $commentdata['comment_author_email'], time() + 7 * 24 * 3600, '/');
        setcookie('url', $commentdata['comment_author_url'], time() + 7 * 24 * 3600, '/');
    }
}
add_action('comment_post', 'save_comment_author_info', 10, 3);

function get_comment_author_info($field) {
    if (isset($_SESSION[$field])) {
        return $_SESSION[$field];
    }
    $cookie_field = str_replace('comment_', '', $field);
    if (isset($_COOKIE[$cookie_field])) {
        return $_COOKIE[$cookie_field];
    }
    return '';
}

add_action('wp_ajax_ajax_comment', 'ajax_comment_callback');
add_action('wp_ajax_nopriv_ajax_comment', 'ajax_comment_callback');

function ajax_comment_callback() {
    if (!check_ajax_referer('comment_nonce', 'security')) {
        wp_send_json_error('非法请求');
    }

    $comment_data = wp_unslash($_POST);
    $comment_data = array_map('esc_attr', $comment_data);
    $current_user_ip = $_SERVER['REMOTE_ADDR'];
    $last_comment = get_comments(array(
        'author_ip' => $current_user_ip,
        'number' => 1,
        'orderby' => 'comment_date',
        'order' => 'DESC'
    ));
    
    if (!empty($last_comment)) {
        $last_comment_time = strtotime($last_comment[0]->comment_date);
        $current_time = time();
        $time_diff = $current_time - $last_comment_time;
        
        // 设置最小评论间隔为20秒
        if ($time_diff < 20) {
            wp_send_json_error('评论太快了，请稍等片刻再发表评论！');
        }
    }

    // 检查重复评论
    $duplicate_check = array(
        'comment_post_ID' => $comment_data['comment_post_ID'],
        'comment_content' => $comment_data['comment'],
        'comment_parent' => isset($comment_data['comment_parent']) ? absint($comment_data['comment_parent']) : 0,
    );
    $last_comment = get_comments(array(
        'post_id' => $duplicate_check['comment_post_ID'],
        'search' => $duplicate_check['comment_content'],
        'date_query' => array(
            'after' => '60 minutes ago'
        ),
        'number' => 1
    ));
    
    if (!empty($last_comment)) {
        wp_send_json_error('您刚刚已经发表过相同的评论了，请稍后再试！');
    }

    $comment_content = $comment_data['comment'];
    if(get_boxmoe('boxmoe_comment_english_switch')){
    if (preg_match('/^[\x20-\x7E\s]+$/', $comment_content)) {
        wp_send_json_error('评论内容不能为纯英文');
    }
    }

    $required_fields = array(
        'comment_post_ID' => '文章ID不能为空',
        'comment' => '评论内容不能为空'
    );


    if (!is_user_logged_in()) {
        $required_fields['author'] = '请填写昵称';
        $required_fields['email'] = '请填写邮箱';
    }
    foreach ($required_fields as $field => $error) {
        if (empty($comment_data[$field])) {
            wp_send_json_error($error);
        }
    }

    $user = wp_get_current_user();
    $comment_author = $user->exists() ? $user->display_name : $comment_data['author'];
    $comment_author_email = $user->exists() ? $user->user_email : $comment_data['email'];
    
    $commentarr = array(
        'comment_post_ID' => (int)$comment_data['comment_post_ID'],
        'comment_author' => $comment_author,
        'comment_author_email' => $comment_author_email,
        'comment_author_url' => $user->exists() ? $user->user_url : ($comment_data['url'] ?? ''),
        'comment_content' => $comment_data['comment'],
        'comment_parent' => isset($comment_data['comment_parent']) ? absint($comment_data['comment_parent']) : 0,
        'user_id' => $user->exists() ? $user->ID : 0,
        'comment_agent' => substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 254),
        'comment_approved' => 1
    );

    if (!user_can($commentarr['user_id'], 'moderate_comments')) {
        $commentarr['comment_approved'] = wp_allow_comment($commentarr, true);
        if (is_wp_error($commentarr['comment_approved'])) {
            wp_send_json_error($commentarr['comment_approved']->get_error_message());
        }
    }

    add_filter('notify_post_author', '__return_false', 1);
    add_filter('notify_moderator', '__return_false', 1);

    $comment_id = wp_insert_comment($commentarr);
    if (!$comment_id) {
        wp_send_json_error('评论提交失败，请稍后再试');
    }

    if (isset($comment_data['private_comment'])) {
        save_private_comment_status($comment_id);
    }

    do_action('comment_post', $comment_id, $commentarr['comment_approved'], $commentarr);
    if ('spam' !== $commentarr['comment_approved']) { 
        add_comment_meta($comment_id, '_wp_trash_meta_status', $commentarr['comment_approved']);
    }
    if (get_boxmoe('boxmoe_smtp_mail_switch')){
    if ($commentarr['comment_parent'] > 0) {
        $parent_comment = get_comment($commentarr['comment_parent']);
        if ($parent_comment && $parent_comment->comment_author_email) {
            boxmoe_comment_reply_notification($comment_id);
        }
    }
    }
    if (get_boxmoe('boxmoe_smtp_mail_switch') && get_boxmoe('boxmoe_new_comment_notice_switch')) {
        boxmoe_new_comment_notice_email($comment_id);
    }

    if (get_boxmoe('boxmoe_robot_notice_switch') && get_boxmoe('boxmoe_new_comment_notice_robot_switch')) {
        boxmoe_robot_msg_comment($comment_id);
    }

    $comment = get_comment($comment_id);
    ob_start();
    boxmoe_comment($comment, array('max_depth' => 1), 1);
    $comment_html = ob_get_clean();

    wp_send_json_success(array(
        'comment' => $comment_html,
        'message' => '评论提交成功！',
        'clear_form' => true
    ));
}
function disable_comment_flood_filter(){
    remove_filter('check_comment_flood', 'check_comment_flood_db', 10, 4);
}
add_action('init', 'disable_comment_flood_filter');

// 全局禁用默认通知
add_filter('notify_post_author', '__return_false', 1);
add_filter('notify_moderator', '__return_false', 1);

// 添加后台评论回复的邮件通知
function boxmoe_admin_comment_reply($comment_id, $comment_object) {
    if (!get_boxmoe('boxmoe_smtp_mail_switch')) {
        return;
    }
    if ($comment_object->comment_parent > 0) {
        boxmoe_comment_reply_notification($comment_id);
    }
}
add_action('wp_insert_comment', 'boxmoe_admin_comment_reply', 10, 2);
remove_action('comment_post', 'boxmoe_comment_reply_notification');
