<?php
class widget_archive extends WP_Widget {
    // 构造函数
    public function __construct() {
        parent::__construct(
            'boxmoe_widget_archive', // 小工具 ID
            'Boxmoe侧栏文章归档', // 小工具名称
            array('description' => __('boxmoe侧栏文章归档', 'text_domain'),
            'classname' => __('widget_archive', 'text_domain' ))
        );
    }

    public function widget($args, $instance) {
        $title = apply_filters('widget_title', $instance['title']);
        $show_count = isset($instance['show_count']) ? $instance['show_count'] : false;
    
        echo $args['before_widget'];
        if ($title) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
    
        // 获取归档
        $archives = wp_get_archives(array(
            'type'            => 'monthly',
            'show_post_count' => $show_count,
            'echo'            => 0
        ));
    
        if ($archives) {
            // 创建 DOMDocument 对象
            $doc = new DOMDocument();
            libxml_use_internal_errors(true); // Suppress errors for invalid HTML
            $doc->loadHTML('<?xml encoding="utf-8" ?>' . $archives); // Load HTML
            libxml_clear_errors();
    
            $xpath = new DOMXPath($doc);
            $listItems = $xpath->query('//li'); // 获取所有 <li> 元素
    
            echo '<ul>';
            foreach ($listItems as $item) {
                $link = $xpath->query('.//a', $item);
                $count = $xpath->query('.//text()', $item);
                
                if ($link->length > 0) {
                    $href = $link->item(0)->getAttribute('href');
                    $title = $link->item(0)->textContent;
                    $countText = '';
                    if ($count->length > 1) {
                        $countText = $count->item(1)->nodeValue;
                    }
    
                    echo '<li><a href="' . esc_attr($href) . '" title="' . esc_attr($title) . '">' . esc_html($title) . '</a><span>' . esc_html($countText) . '</span></li>';
                }
            }
            echo '</ul>';
        } else {
            echo '<p>' . __('No archives found.', 'text_domain') . '</p>';
        }
    
        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Archives', 'text_domain');
        $show_count = !empty($instance['show_count']) ? (bool) $instance['show_count'] : false;
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php checked($show_count); ?> id="<?php echo $this->get_field_id('show_count'); ?>" name="<?php echo $this->get_field_name('show_count'); ?>" />
            <label for="<?php echo $this->get_field_id('show_count'); ?>"><?php _e('Display Post Count'); ?></label>
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
