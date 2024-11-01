<?php
/**
 * @package lolimeow@boxmoe themes
 * @link https://www.boxmoe.com
 */
get_header();
?>
      <section class="section-blog-breadcrumb container">
        <div class="breadcrumb-head">
          <span>
            <i class="fa fa-home"></i>Single</span>
        </div>
      </section>
      <section id="boxmoe_theme_container">
        <div class="container">
          <div class="row">
            <div class="blog-single  <?php echo boxmoe_blog_layout() ?>  fadein-bottom">
          <?php echo get_boxmoe('ads_top');?>
              <div class="post-single <?php echo boxmoe_border()?>  <?php if (is_sticky()) { echo 'sticky-post'; } ?>"><?php while (have_posts()) : the_post(); ?>
                  <?php if (is_sticky()) : ?>
                    <div class="ribbon">置顶</div>
                  <?php endif; ?>
                <div class="single-category">
				 <?php $category = get_the_category();if($category[0]){ echo '<a href="'.get_category_link($category[0]->term_id ).'" title="查看《'.$category[0]->cat_name.'》下的所有文章 " class="tag-cloud" rel="category tag" '. _post_target_blank().'><i class="fa fa-folder-o"></i>'.$category[0]->cat_name.'</a>'; };?>
                </div>
                <H1 class="single-title"><?php the_title(); echo get_the_subtitle(); ?></H1>
                <hr class="horizontal dark">
                <div class="single-meta-box">
                  <div class="single-info-left">
                    <div class="single-meta">
                      <a class="" href="#">
                        <?php echo get_avatar(get_the_author_meta('ID'),60); ?></a>
                      <div class="single-author-name">
                        <div class="single-author-info">
                          <a href="#" class="name">
                            <i class="fa fa-at"></i><?php the_author(); ?></a>
                          <span class="data">
                            <i class="fa fa-clock-o"></i><?php echo get_the_time( 'Y-m-d'); ?></span>
                          <span class="view">
                            <i class="fa fa-street-view"></i><?php setPostViews(get_the_ID()); ?><?php echo getPostViews(get_the_ID()); ?></span>
                          <?php edit_post_link( '<i class="fa fa-pencil-square-o"></i>编辑['.__( '仅作者可见', 'boxmoe'). ']'); ?>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="single-info-right">
                    <div class="single-comnum">
                      <a href="" class="tag-cloud">
                        <i class="fa fa-comments-o"></i> <?php echo get_comments_number( '0', '1', '%') ?> 评论</a>
                    </div>
                  </div>
                </div>
                <div class="single-content">
				<?php the_content(); ?>
        <?php wp_link_pages(array('before' => '<div class="fenye pagination justify-content-center">', 'after' => '</div>', 'next_or_number' => 'number','link_before' =>'<span>', 'link_after'=>'</span>')); ?>  
                </div>
				 
                <div class="post-tags">
                  <?php
                    $tags = get_the_tags();
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
                </div><?php endwhile; ?>
				<?php $categories=get_the_category();$categoryIDS=array();foreach ($categories as $category) { array_push($categoryIDS, $category->term_id);}$categoryIDS = implode(",", $categoryIDS);?>	  		
                <div class="post-next">
                  <nav class="post-navigation thw-sept">
                    <div class="row no-gutters">
                      <div class="col-12 col-md-6">
                        <div class="post-previous">
                          <?php if (get_next_post($categoryIDS)) { next_post_link('%link','<span><i class="fa fa-angle-left"></i> Previous Post</span><h4>%title</h4>',true);} else { echo '<span><i class="fa fa-angle-left"></i> Previous Post </span><h4>本文分类下已经是最后一篇文章了哦！';} ?>
                        </div>
                      </div>
                      <div class="col-12 col-md-6">
                        <div class="post-next">
                          <?php if (get_previous_post($categoryIDS)) { previous_post_link( '%link', '<span>Next Post <i class="fa fa-angle-right"></i></span> <h4>%title</h4>',true);}else { echo '<span>Next Post <i class="fa fa-angle-right"></i></span> <h4>本文分类下已经是最新一篇文章了哦！</h4>';} ?>
                        </div>
                      </div>
                    </div>
                  </nav>                 
                </div>
                <?php if (!get_boxmoe('comments_off')): ?>
                <div class="thw-sept"></div> 
                <?php comments_template( '', true); ?>
                <?php endif; ?>				
             
              <?php if (get_boxmoe('post_related_s')): ?>
              <div class="post-related container">
                <div class="row">
                  <div class="col-lg-6">
                    <h3 class="mb-4">相关阅读</h3>
					</div>
                </div>
                <div class="row g-5">
                  <?php boxmoe_posts_related( get_boxmoe('related_title'), get_boxmoe('post_related_n'), (get_boxmoe('post_related_model') ? get_boxmoe('post_related_model') : 'thumb') );
                  ?>
                </div>
                
              </div>            
              <?php endif; ?>	
              
                  <?php echo get_boxmoe('ads_bottom');?>
            </div>
          </div>  
            <?php if (get_boxmoe('blog_layout')== 'two' ): ?>
              <?php get_sidebar();?>
              <?php endif; ?>	      
            </div>
        </div>
      </section>

<?php
get_footer();
