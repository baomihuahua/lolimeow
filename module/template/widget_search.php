<?php
class widget_search extends WP_Widget {

    function __construct() {
        parent::__construct(
            'widget_search', // 小工具 ID
            'Boxmoe 搜索', // 小工具名称
            array( 'classname' => 'widget-search' ) // 小工具类名
        );
    }

    // 前台显示小工具内容
    function widget( $args, $instance ) {
        extract( $args );
        $title = !empty($instance['title']) ? $instance['title'] : '';

        echo $before_widget;
        if (!empty($title)) {
            echo $before_title . $title . $after_title;
        }

        // 搜索表单 HTML
        ?>
        <div class="widget-search-form">
            <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                <input type="search" class="form-control" placeholder="<?php echo esc_attr__('Search …', 'boxmoe-com'); ?>" value="<?php echo get_search_query(); ?>" name="s" />
            </form>
        </div>
        <?php

        echo $after_widget;
    }

    // 后台小工具配置表单
    function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php echo __('标题：', 'boxmoe-com'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <?php
    }

    // 更新小工具配置
    function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = !empty($new_instance['title']) ? sanitize_text_field($new_instance['title']) : '';
        return $instance;
    }
}

// 注册小工具
function register_widget_search() {
    register_widget('widget_search');
}
add_action('widgets_init', 'register_widget_search');
?>