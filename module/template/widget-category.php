<?php
class widget_category extends WP_Widget {
    // 构造函数
    public function __construct() {
        parent::__construct(
            'category_widget', // 小工具 ID
            'Boxmoe侧栏分类', // 小工具名称
            array('description' => __('Boxmoe侧栏分类小工具', 'text_domain'),
				  'classname' => __('widget_categories', 'text_domain' )) // 小工具描述
        );
    }

    public function widget($args, $instance) {
        $title = apply_filters('widget_title', $instance['title']);
        $show_count = isset($instance['show_count']) ? $instance['show_count'] : false;

        echo $args['before_widget'];
        if ($title) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        $categories = get_categories(array('hide_empty' => false));
        echo '<ul>';
        foreach ($categories as $category) {
            echo '<li>';
            echo '<a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->name) . '</a>';
            if ($show_count) {
                echo '<span>(' . $category->count . ')</span>';
            }
            echo '</li>';
        }
        echo '</ul>';
        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Categories', 'text_domain');
        $show_count = !empty($instance['show_count']) ? (bool) $instance['show_count'] : false;
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php checked($show_count); ?> id="<?php echo $this->get_field_id('show_count'); ?>" name="<?php echo $this->get_field_name('show_count'); ?>" />
            <label for="<?php echo $this->get_field_id('show_count'); ?>"><?php _e('显示文章数目'); ?></label>
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        $instance['show_count'] = !empty($new_instance['show_count']) ? (bool) $new_instance['show_count'] : false;
        return $instance;
    }
}
