<?php
/**
 * @link https://www.boxmoe.com
 * @package lolimeow
 */
//boxmoe.com===安全设置=阻止直接访问主题文件
if(!defined('ABSPATH')){echo'Look your sister';exit;}
?>
        <div class="<?php echo boxmoe_layout_setting(); ?> blog-post">
        <?php while ( have_posts() ) : the_post(); ?>
          <article class="post-list list-one row <?php echo boxmoe_border_setting(); ?>">
            <div class="post-list-img">
              <figure class="mb-4 mb-lg-0 zoom-img">
                <a <?php echo boxmoe_article_new_window(); ?> href="<?php echo get_the_permalink(); ?>" title="<?php echo get_the_title().get_the_subtitle(false).boxmoe_title_link().get_bloginfo('name')?>">
                  <img src="<?php boxmoe_lazy_load_images(); ?>" data-src="<?php echo boxmoe_article_thumbnail_src(); ?>?id<?php echo get_the_ID(); ?>" alt="<?php the_title(); ?>" class="img-fluid rounded-3 lazy"></a>
              </figure>

            </div>
            <div class="post-list-content">
              <div class="category">
                <div class="tags">
                  <?php 
                  $categories = get_the_category();
                  if (!empty($categories)) {
                      $first_category = $categories[0]; ?>
                      <a href="<?php echo esc_url(get_category_link($first_category->term_id)); ?>" title="查看《<?php echo esc_attr($first_category->name); ?>》分类下的所有文章" rel="category tag">
                        <i class="tagfa fa fa-dot-circle-o"></i><?php echo esc_html($first_category->name); ?>
                      </a>
                  <?php } ?>
                </div>
              </div>
              <div class="mt-2 mb-2">
                <h3 class="post-title h4">
                  <a href="<?php echo get_the_permalink(); ?>" title="<?php echo get_the_title().get_the_subtitle(false).boxmoe_title_link().get_bloginfo('name')?>" class="text-reset"><?php echo get_the_title(); ?></a></h3>
                <p class="post-content"><?php echo _get_excerpt(); ?></p></div>
              <div class="post-meta align-items-center">
                <div class="post-list-avatar">
                <img src="<?php echo boxmoe_lazy_load_images(); ?>" data-src="<?php echo boxmoe_get_avatar_url(get_the_author_meta('ID'), 100); ?>" alt="avatar" class="avatar lazy">
                    </div>
                <div class="post-meta-info">
                  <div class="post-meta-stats">
                    <span class="list-post-view">
                      <i class="fa fa-street-view"></i><?php echo getPostViews(get_the_ID()); ?></span>
                    <span class="list-post-comment">
                      <i class="fa fa-comments-o"></i><?php echo get_comments_number(); ?></span>
                  </div>
                  <span class="list-post-author">
                    <i class="fa fa-at"></i><?php echo get_the_author(); ?>
                    <span class="dot"></span><?php echo get_the_date(); ?></span>
                </div>
              </div>
            </div>
          </article>
        <?php endwhile; ?>
          <div class="col-lg-12 col-md-12 pagenav">
            <?php boxmoe_pagination(); ?>            
          </div>
        </div>