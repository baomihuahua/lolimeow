<?php
/**
 * Template Name: Boxmoe[New]友情链接
 * Description: 新版友情链接页面模板,支持响应式,分类,描述内容的展示
 * @link https://MoeJue.cn
 * author 阿珏酱
 * @package lolimeow
 */
get_header();
?>
<section class="section-blog-breadcrumb container">
    <div class="breadcrumb-head">
        <span><i class="fa fa-home"></i> Page</span>
    </div>
</section>
<section id="boxmoe_theme_container">
    <div class="container">
        <div class="row">
            <div class="blog-single col-lg-12 mx-auto fadein-bottom">
                <div class="post-single <?php echo boxmoe_border()?>">
                    <?php while (have_posts()) : the_post(); ?>
                    <h1 class="single-title"><?php the_title(); echo get_the_subtitle(); ?></h1>
                    <hr class="horizontal dark">
                    <div class="single-content">
                        <?php the_content(); ?>
                        <?php wp_link_pages(array('before' => '<div class="fenye pagination justify-content-center">', 'after' => '</div>', 'next_or_number' => 'number','link_before' =>'<span>', 'link_after'=>'</span>')); ?>                  
                        <?php
                        $categories = get_terms(array(
                            'taxonomy' => 'link_category',
                            'hide_empty' => false,
                        ));

                        // 新样式结构
                        echo '<div class="MoeJuelinks">';

                        // 遍历每个分类，获取每个分类下的链接
                        foreach ($categories as $index => $category) {
                            // 设置标题和描述
                            $index += 1; // 索引从1开始
                            $category_title = $index . '. ' . $category->name;
                            $category_description = term_description($category->term_id, 'link_category') ?: '';

                            echo '<h3 id="toc-head-' . $index . '" class="link-title">';
                            echo '<span class="fake-title">' . esc_html($category_title) . '</span>';
                            echo '</h3>';
                            echo '<p>' . $category_description . '</p>';
                            echo '<ul class="link-items fontSmooth">';

                            // 获取该分类下的所有链接
                            $links = get_bookmarks(array('category' => $category->term_id));					  
                            foreach ($links as $link) {
                                $desc = !empty($link->link_description) ? $link->link_description : '这站长太懒了什么也没留下';
                                $webimg = !empty($link->link_image) ? $link->link_image : boxmoe_themes_dir().'/assets/images/profile.jpg';

                                // 获取后台设置是否在新标签页中打开
                                $target_blank = $link->link_target=='_blank' ? 'target="_blank"' : '';

                                // 单个链接项的结构
                                echo '<li class="link-item">';
                                echo '<a class="link-item-inner effect-apollo" href="' . esc_url($link->link_url) . '" ' . $target_blank . '>';
                                echo '<img src="' . esc_url($webimg) . '" alt="' . esc_html($link->link_name) . '">';
                                echo '<span class="sitename">' . esc_html($link->link_name) . '</span>';
                                echo '</a>';
                                echo '<div class="linkdes">' . esc_html($desc) . '</div>';
                                echo '</li>';
                            }
                            echo '</ul>';
                        }                        				  
                        echo '</div>';	
                        ?>
                    </div>
                    <?php endwhile; ?>
                    <?php if (!get_boxmoe('comments_off')): ?>
                    <div class="thw-sept"></div> 
                    <?php comments_template( '', true); ?>
                    <?php endif; ?>	
                </div>
            </div>
        </div>
    </div>
</section>
<?php
get_footer();
?>