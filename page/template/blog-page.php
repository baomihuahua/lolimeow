<?php
/**
 * @link https://www.boxmoe.com
 * @package lolimeow
 */
//boxmoe.com===安全设置=阻止直接访问主题文件
if(!defined('ABSPATH')){echo'Look your sister';exit;}
?>
            <div class="<?php echo boxmoe_layout_setting(); ?>">
            <div class="blog-single <?php echo boxmoe_border_setting(); ?>">
            <?php while (have_posts()) : the_post(); ?>
                <div class="post-single">
                    <div class="single-category">
                        <?php 
                        $categories = get_the_category();
                        if (!empty($categories)) {
                            $first_category = $categories[0]; ?>
                            <a href="<?php echo esc_url(get_category_link($first_category->term_id)); ?>" title="查看《<?php echo esc_attr($first_category->name); ?>》分类下的所有文章" class="tag-cloud" rel="category tag">
                                <i class="tagfa fa fa-dot-circle-o"></i><?php echo esc_html($first_category->name); ?>
                            </a>
                        <?php } ?>
                      </div>
                      <h1 class="single-title"><?php the_title(); ?></h1>
                      <hr class="horizontal dark">
                      <div class="single-meta-box">
                        <div class="single-info-left">
                          <div class="single-meta">
                              <img src="<?php echo boxmoe_lazy_load_images(); ?>" data-src="<?php echo boxmoe_get_avatar_url(get_the_author_meta('ID'), 100); ?>" class="avatar lazy" alt="avatar">
                            <div class="single-author-name">
                              <div class="single-author-info">
                                <a href="#" class="name">
                                  <i class="fa fa-at"></i><?php the_author(); ?></a>
                                <span class="data">
                                  <i class="fa fa-clock-o"></i><?php the_date(); ?></span>
                                  <?php edit_post_link( '<i class="fa fa-pencil-square-o"></i>编辑['.__( '仅作者可见', 'boxmoe'). ']'); ?>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="single-info-right">
                          <div class="single-comnum">
                            <a href="#comments-container" class="tag-cloud">
                              <i class="fa fa-comments-o"></i><?php echo get_comments_number(); ?> 评论</a>
                          </div>
                        </div>
                      </div>
                      <div class="single-content">
                        <div class="post-toc-container">
                            <div class="post-toc-btn">
                                <i class="fa fa-list-ul"></i>
                            </div>
                            <div class="post-toc">
                                <div class="toc-title">文章导读</div>
                                <div class="toc-list"></div>
                            </div>
                        </div>
                        <?php the_content(); ?>
                    </div>


                </div>
                <?php endwhile; ?>
                <?php if (comments_open()) : ?>
                    <?php comments_template('', true); ?>
                <?php endif; ?>
            </div>
        </div>
