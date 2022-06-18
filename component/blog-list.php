<?php
/**
 * @link https://www.boxmoe.com
 * @package lolimeow
 */
?>
                <div class="post-list-view <?php echo boxmoe_border()?> <?php boxmoe_wow_set()?>">
                  <i class="post-hello-cat"></i>
                  <div class="post-thumbnail featured-image">
                    <a <?php echo _post_target_blank() ?> href="<?php echo get_permalink() ?>" title="<?php echo get_the_title().get_the_subtitle(false).boxmoe_connector().get_bloginfo('name')?>"  class="post-overlay">
                      <img class="img-fluid" <?php echo _get_post_thumbnail('$html2') ?>></a>
                  </div>
                  <div class="post-list-content">
                    <div class="post-list-header">
                      <span class="category-meta">
                        <?php $category = get_the_category();if($category[0]){ echo '
                      <a href="'.get_category_link($category[0]->term_id ).'" title="查看《'.$category[0]->cat_name.'》下的所有文章 " rel="category tag" '. _post_target_blank().'>
                        <i class="fa fa-folder-o"></i>'.$category[0]->cat_name.'</a>'; };?>
                      </span>
                      <h2 class="post-list-title">
                        <a <?php echo _post_target_blank() ?> href="<?php echo get_permalink() ?>"><?php echo get_the_title().get_the_subtitle() ?></a></h2>
                    </div>
                    <div class="post-list-text"><?php echo _get_excerpt() ?></div>
                    <div class="post-list-info">
                      <div class="post-list-avatar">
                        <?php echo get_avatar(get_the_author_meta( 'user_email' ),60,'','',array('class'=>array('img-fluid'))); ?></div>
                      <div class="post-meta-info">
                        <span class="list-post-date">
                          <i class="fa fa-clock-o"></i>Post on <?php echo get_the_time('Y-m-d') ?></span>
                        <span class="list-post-view">
                          <i class="fa fa-street-view"></i><?php echo getPostViews(get_the_ID()) ?></span>
                        <span class="list-post-comment">
                          <i class="fa fa-comments-o"></i><?php echo get_comments_number('0', '1', '%') ?></span>
                      </div>
                    </div>
                  </div>
                </div>