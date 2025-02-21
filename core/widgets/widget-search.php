<?php
/**
 * @link https://www.boxmoe.com
 * @package lolimeow
 */
//=======安全设置，阻止直接访问主题文件=======
if (!defined('ABSPATH')) {echo'Look your sister';exit;}
//=========================================
class widget_search extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'boxmoe_widget_search',
            'Boxmoe_侧栏搜索',
            array('description' => __('Boxmoe_侧栏搜索框', 'text_domain'),
            'classname' => __('widget-search', 'text_domain'))
        );
    }

    public function widget($args, $instance) {
        $title = apply_filters('widget_title', $instance['title']);
        
        echo $args['before_widget'];
        if ($title) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        ?>
        <div class="widget-content">
            <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
                <div class="search-wrap">
                    <input type="search" class="search-input" placeholder="<?php echo esc_attr_x('搜索...', 'placeholder', 'text_domain'); ?>" 
                           value="<?php echo get_search_query(); ?>" name="s" required>
                    <button type="submit" class="search-submit">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
        <?php
        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('搜索', 'text_domain');
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('标题:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" 
                   name="<?php echo $this->get_field_name('title'); ?>" type="text" 
                   value="<?php echo esc_attr($title); ?>">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }
}