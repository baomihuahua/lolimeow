<?php
/**
 * @link https://www.boxmoe.com
 * @package lolimeow
 */
//boxmoe.com===安全设置=阻止直接访问主题文件
if(!defined('ABSPATH')){echo'Look your sister';exit;}
?>
            <div class="col-md-12 mx-auto">
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

                      <div class="single-tags mt-7">
                      <?php $tags = get_the_tags();
                      if ($tags) {
                        foreach ($tags as $tag) {
                          $tag_link = get_tag_link($tag->term_id);
                          $tag_name = esc_html($tag->name);
                          echo '<a target="_blank" title="' . esc_attr($tag_name) . '有1个相关" href="' . esc_url($tag_link) . '" class="tag-cloud">';
                          echo '<i class="tagfa fa fa-dot-circle-o"></i>';
                          echo $tag_name;
                          echo '</a> ';
                          }
                      }
                        ?>                      
                      </div>
                      <?php if(get_boxmoe('boxmoe_like_switch') || get_boxmoe('boxmoe_reward_switch')): ?>
                      <div class="post-actions mt-4">
                        <?php if(get_boxmoe('boxmoe_like_switch')): ?>
                          <button class="action-btn like-btn" title="点赞" data-post-id="<?php the_ID(); ?>">
                              <i class="fa fa-thumbs-up"></i>
                              <span class="like-count"><?php echo getPostLikes(get_the_ID()); ?></span>
                          </button>
                          <?php endif; ?>
                          <?php if(get_boxmoe('boxmoe_reward_switch')): ?>
                          <button class="action-btn reward-btn" title="赞赏">
                              <i class="fa fa-gift"></i>
                              <span>打赏</span>
                          </button>
                          <?php endif; ?>
                      </div>
                      <?php if(get_boxmoe('boxmoe_reward_switch')): ?>
                      <div class="reward-modal">
                          <div class="reward-content">
                              <div class="reward-header">

                                  <h5>感谢您的支持</h5>
                                  <button class="reward-close">&times;</button>
                              </div>
                              <div class="reward-body">
                                  <div class="qrcode-item">
                                      <?php if(get_boxmoe('boxmoe_reward_qrcode_weixin')): ?>
                                      <img src="<?php echo get_boxmoe('boxmoe_reward_qrcode_weixin'); ?>" alt="微信赞赏" >
                                      <p>微信扫一扫</p>
                                      <?php endif; ?>
                                  </div>
                                  <div class="qrcode-item">
                                      <?php if(get_boxmoe('boxmoe_reward_qrcode_alipay')): ?>
                                      <img src="<?php echo get_boxmoe('boxmoe_reward_qrcode_alipay'); ?>" alt="支付宝赞赏">
                                      <p>支付宝扫一扫</p>
                                      <?php endif; ?>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <?php endif; ?>
                      <?php endif; ?>
                      <hr class="horizontal dark">

                </div>
                <?php endwhile; ?>
                <?php if (comments_open()) : ?>
                    <?php comments_template('', true); ?>
                <?php endif; ?>
            </div>
        </div>
