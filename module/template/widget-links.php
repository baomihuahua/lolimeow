<?php
class widget_links extends WP_Widget {

    // 构造函数
    function __construct() {
        parent::__construct(
            'widget_links', // 小工具 ID
            'Boxmoe友情链接', // 小工具名称
            array( 'classname' => 'widget-links' ) // 小工具类名
        );
    }

    // 输出前台小工具内容
    function widget( $args, $instance ) {
        extract( $args );

        $title = apply_filters('widget_title', $instance['title']);
        $category_id = isset($instance['category_id']) ? $instance['category_id'] : 0;
        $limit = isset($instance['limit']) ? $instance['limit'] : 5;

        echo $before_widget;
        echo $before_title . $title . $after_title;

        // 获取友情链接
        $bookmarks = get_bookmarks(array(
            'orderby' => 'name',
            'order'   => 'ASC',
            'limit'   => $limit,
            'category' => $category_id, // 按分类ID获取链接
        ));

        if (!empty($bookmarks)) {
            echo '<ul class="custom-widget-link-list">';
            foreach ($bookmarks as $bookmark) {
                $link_image = $bookmark->link_image ? '<img src="' . esc_url($bookmark->link_image) . '" alt="' . esc_attr($bookmark->link_name) . '" class="custom-link-icon" title="' . esc_attr($bookmark->link_description) . '">' : '';
                echo '<li class="custom-link-item">';
                echo '<a href="' . esc_url($bookmark->link_url) . '" title="' . esc_attr($bookmark->link_description) . '" target="_blank">';
                echo $link_image . '<span class="custom-link-name">' . esc_html($bookmark->link_name) . '</span>';
                echo '</a>';
                echo '</li>';
            }
            echo '</ul>';
        } else {
            echo '<p>' . __('暂无友情链接', 'boxmoe-com') . '</p>';
        }

        echo $after_widget;
    }

    // 后台小工具配置表单
    function form($instance) {
        $defaults = array( 'title' => __('友情链接', 'boxmoe-com'), 'category_id' => 0, 'limit' => 5 );
        $instance = wp_parse_args((array) $instance, $defaults);

        // 小工具标题
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php echo __('标题：', 'boxmoe-com'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>">
        </p>
        <!-- 友情链接分类选择 -->
        <p>
            <label for="<?php echo $this->get_field_id('category_id'); ?>"><?php echo __('选择分类：', 'boxmoe-com'); ?></label>
            <?php
            wp_dropdown_categories(array(
                'taxonomy' => 'link_category',
                'name' => $this->get_field_name('category_id'),
                'selected' => $instance['category_id'],
                'show_option_all' => __('全部分类', 'boxmoe-com'),
                'class' => 'widefat'
            ));
            ?>
        </p>
        <!-- 显示数目 -->
        <p>
            <label for="<?php echo $this->get_field_id('limit'); ?>"><?php echo __('显示数目：', 'boxmoe-com'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="number" value="<?php echo esc_attr($instance['limit']); ?>" />
        </p>
        <?php
    }

    // 更新小工具配置
    function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = !empty($new_instance['title']) ? sanitize_text_field($new_instance['title']) : '';
        $instance['category_id'] = !empty($new_instance['category_id']) ? intval($new_instance['category_id']) : 0;
        $instance['limit'] = !empty($new_instance['limit']) ? intval($new_instance['limit']) : 5;
        return $instance;
    }
}

// 注册小工具
function register_widget_links() {
    register_widget('widget_links');
}
add_action('widgets_init', 'register_widget_links');

?>