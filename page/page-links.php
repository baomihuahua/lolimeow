<?php 
/**
 * Template Name: Boxmoe友情链接
 * @link https://www.boxmoe.com
 * @package lolimeow
 */
get_header();
?>
<section class="section-blog-breadcrumb container">
    <div class="breadcrumb-head">
        <span>
            <i class="fa fa-home"></i>Page</span>
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
                        $desc ='';
                        $webimg ='';
                        echo '<div class="thw-sept"></div><div class="link-title mt-4 mb-8">友情链接 - 排名不分先后</div>';
                        echo '<div class="row">';

                        // 遍历每个分类，获取每个分类下的链接
                        foreach ($categories as $category) {
                            $links = get_bookmarks(array('category' => $category->term_id));					  
                            foreach ($links as $link) {
                                if (empty($link->link_description)) {
                                    $desc = '这站长太懒了什么也没留下';
                                } else {
                                    $desc = $link->link_description;
                                }
                                if (empty($link->link_image)) {
                                    $webimg = boxmoe_themes_dir().'/assets/images/linkspic.jpg';
                                } else {
                                    $webimg = $link->link_image;
                                }                              
                                echo '<div class="col-md-4 mb-8">';
                                echo '<div class="boxmoe_links_card">';
                                echo '  <div class="card-text">';
                                echo '      <img src="' . esc_url($webimg) . '" alt="' . esc_html($link->link_name) . '">';
                                echo '    <div class="title-total">   
                                        <div class="title"><a href="' . esc_url($link->link_url) . '" class="icon-link icon-link-hover">' . esc_html($link->link_name) . '
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"></path>
                                        </svg></a>';
                                echo '      </div> ';
                                echo '      <div class="desc">' . esc_html($desc) . '</div> ';
                                echo '    </div>';
                                echo '  </div>';
                                echo '</div>';
                                echo '</div>';
                            }
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