<?php 
class widget_tags extends WP_Widget {

	function __construct(){
		parent::__construct( 'widget_tags', 'Boxmoe侧栏标签', array( 'classname' => 'widget-tag' ) );
	}

	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters('widget_name', $instance['title']);
		$count = $instance['count'];

		echo $before_widget;
		echo $before_title.$title.$after_title; 
		echo '<div class="widget-tag">';
		$tags_list = get_tags('orderby=count&order=DESC&number='.$count);
		if ($tags_list) { 
			$i = 0;
			foreach($tags_list as $tag) {
				$i++;
				echo '<a title="['. $tag->name .']有'.$tag->count.__('个相关', 'boxmoe-com').'" href="'.get_tag_link($tag).'" class="tag-cloud"><i class="tagfa fa fa-dot-circle-o"></i>'. $tag->name .'</a>'; 
			} 
		}else{
			echo __('暂无标签！', 'boxmoe-com');
		}
		echo '</div>';
		echo $after_widget;
	}

	function form($instance) {
		$defaults = array( 'title' => __('标签云', 'boxmoe-com'), 'count' => 24 );
		$instance = wp_parse_args( (array) $instance, $defaults );
?>
		<p>
			<label>
				<?php echo __('标题：', 'boxmoe-com') ?>
				<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" class="widefat" />
			</label>
		</p>
		<p>
			<label>
				<?php echo __('显示数量：', 'boxmoe-com') ?>
				<input id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="number" value="<?php echo $instance['count']; ?>" class="widefat" />
			</label>
		</p>
<?php
	}
}