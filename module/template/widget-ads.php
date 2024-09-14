<?php 
class widget_ads extends WP_Widget {

	function __construct(){
		parent::__construct( 'widget_ads', 'Boxmoe侧栏广告', array( 'classname' => 'widget_ads' ) );
	}

	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters('widget_name', $instance['title']);
		$code = $instance['code'];

		echo $before_widget;
		echo '<H4 class="widget-title">'.$title.'</H4>';
		echo '<div class="widget_ads_inner">'.$code.'</div>';
		echo $after_widget;
	}

	function form($instance) {
		$defaults = array( 
			'title' => __('广告', 'boxmoe-com').' '.date('m-d'), 
			'code' => '<div class="widget-pic">
                      <a href="https://www.boxmoe.com" tabindex="0">
                        <div class="inner">
                          <img src="https://cdn.jsdelivr.net/gh/baomihuahua/boxmoeimg@490aaab75e7a15aafad22ea834b812e07bcb99f0/2021/09/20/ca111ff00ec6ae56e3ba8987855a6fbe.png" alt="标题"></div>
                      </a>
                    </div>' 
		);
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
				<?php echo __('广告代码：', 'boxmoe-com') ?>
				<textarea id="<?php echo $this->get_field_id('code'); ?>" name="<?php echo $this->get_field_name('code'); ?>" class="widefat" rows="12" style="font-family:Courier New;"><?php echo $instance['code']; ?></textarea>
			</label>
		</p>
<?php
	}
}
