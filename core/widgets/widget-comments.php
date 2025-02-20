<?php
/**
 * @link https://www.boxmoe.com
 * @package lolimeow
 */
//=======安全设置，阻止直接访问主题文件=======
if (!defined('ABSPATH')) {echo'Look your sister';exit;}
//=========================================
class widget_comments extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'widget_comments',
            'Boxmoe_最新评论', 
            array('description' => __('Boxmoe_最新评论侧栏', 'text_domain'),
				  'classname' => __('widget_comments', 'text_domain' ))
        );
    }
	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters('widget_name', $instance['title']);
		$limit = isset($instance['limit']) ? $instance['limit'] : 8;
		$outer = isset($instance['outer']) ? $instance['outer'] : -1;
		echo $before_widget;
		echo $before_title.$title.$after_title; 
		echo '<ul class="widget-latest-comment">';
		$output = '';
		$comment_avatar = '';
		global $wpdb;
		$sql = "SELECT DISTINCT ID, post_title, post_password, user_id, comment_ID, comment_post_ID, comment_author, comment_date, comment_date_gmt, comment_approved,comment_author_email, comment_type,comment_author_url, SUBSTRING(comment_content,1,60) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID) WHERE user_id!='".$outer."' AND comment_approved = '1' AND (comment_type = '' OR comment_type = 'comment') AND post_password = '' ORDER BY comment_date DESC LIMIT $limit";
		$comments = $wpdb->get_results($sql);
		foreach ( $comments as $comment ) {
			$content = strip_tags($comment->com_excerpt);
            $content = mb_strimwidth(strip_tags($content), 0, '40', '...', 'UTF-8');
            $content = convert_smilies($content);
            $lazy_img = boxmoe_lazy_load_images();
            $comment_avatar = '<img src="'.esc_url($lazy_img).'" data-src="'.esc_url(boxmoe_get_avatar_url($comment->user_id, 60)).'" class="avatar lazy" alt="avatar">';
			$output .= '<li class="comment-listitem">
			            <div class="comment-user">
                          <span class="comment-avatar">
                            '.$comment_avatar.'</span>
                          <div class="comment-author">'.strip_tags($comment->comment_author).'</div>
                          <span class="comment-date">'.get_comment_date('Y-m-d', $comment->comment_ID).'</span></div>
                        <div class="comment-content-link">
                          <a '.boxmoe_article_new_window().' href="'.get_comment_link( $comment->comment_ID ).'" title="'.$comment->post_title.__('上的评论', 'boxmoe-com').'">
                            <div class="comment-content">'.$content.'</div></a>
                        </div>						  
						</li>';
		}
		echo $output;
		echo '</ul>';
		echo $after_widget;
	}

	function form($instance) {
		$defaults = array( 'title' => __('最新评论', 'boxmoe-com'), 'limit' => 8, 'outer' => 1 );
		$instance = wp_parse_args( (array) $instance, $defaults );
?>
		<p>
			<label>
				<?php echo __('标题：', 'boxmoe-com') ?>
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" />
			</label>
		</p>
		<p>
			<label>
				<?php echo __('显示数目：', 'boxmoe-com') ?>
				<input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="number" value="<?php echo $instance['limit']; ?>" />
			</label>
		</p>
		<p>
			<label>
				<?php echo __('排除某用户ID：', 'boxmoe-com') ?>
				<input class="widefat" id="<?php echo $this->get_field_id('outer'); ?>" name="<?php echo $this->get_field_name('outer'); ?>" type="number" value="<?php echo $instance['outer']; ?>" />
			</label>
		</p>

<?php
	}
}


