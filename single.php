<?php
/**
 * @link https://www.boxmoe.com
 * @package lolimeow
 */
get_header(); ?>
      <div class="container">
        <div class="section-head">
          <span>Single</span></div>
      </div>
        <div class="boxmoe-blog-content">
          <div class="container-full">
            <div class="row">
              <div class="col-lg-<?php echo sidebaron(); ?> single">
			  <div class="<?php echo boxmoe_border()?> single-card mb-4"><?php while (have_posts()) : the_post(); ?>
                <div class="post-single">
                  <div class="post-header">
                    <p class="post-category">
					 <?php $category = get_the_category();if($category[0]){ echo '<a href="'.get_category_link($category[0]->term_id ).'" title="查看《'.$category[0]->cat_name.'》下的所有文章 " rel="category tag" '. _post_target_blank().'><i class="fa fa-folder-o"></i>'.$category[0]->cat_name.'</a>'; };?>
                    </p>
                    <h3 class="post-title"><?php the_title(); echo get_the_subtitle(); ?></h3>
                    <div class="post-meta thw-sept">
                      <div class="post-auther-avatar">
					  <?php echo get_avatar(get_the_author_meta( 'user_email' ),60, '', '',array( 'class'=>array('img-fluid'))); ?></div>
                      <div class="post-meta-info">
                        <span class="post-date">
                          <i class="fa fa-clock-o"></i>Post on <?php echo get_the_time( 'Y-m-d'); ?></span>
                        <span class="post-view">
                          <i class="fa fa-street-view"></i><?php setPostViews(get_the_ID()); ?><?php echo getPostViews(get_the_ID()); ?></span>
                        <span class="post-comment">
                          <i class="fa fa-comments-o"></i><?php echo get_comments_number( '0', '1', '%') ?></span>
						  <?php edit_post_link( '['.__( '<span>编辑仅作者可见</span>', 'meowdata'). ']'); ?>
                      </div>
                    </div>
                  </div>	  
                  <div class="post-content">	  
	                <?php the_content(); ?>  
                  </div>	
				  <?php wp_link_pages(array('before' => '<div class="fenye pagination justify-content-center">', 'after' => '</div>', 'next_or_number' => 'number','link_before' =>'<span>', 'link_after'=>'</span>')); ?>  
                  <div class="post-footer">
                    <div class="post-tags">
                      <div class="article-categories">
                        <?php the_tags( '', '', ''); ?></div>
                    </div>
                  </div>	  
                </div><?php if (get_boxmoe('open_author_info')){?>
			<div class="block_auther_post mb-4">
                <div class="row">
                  <div class="col-lg-9">
					<div class="author align-items-center mb-2">
					    <?php echo get_avatar( get_the_author_meta( 'user_email' ), 60, '', '',array( 'class'=>array('shadow'))); ?>
						 <div class="name ps-3">
						 <span><?php the_author(); ?></span>
						  <div class="stats">
						     <?php echo get_boxmoe( 'authorinfo'); ?>
						  </div>
						 </div>
                    </div>
                  </div>
                  <div class="col-lg-3 my-auto ml-auto text-lg-right"><?php if(get_boxmoe('boxmoe_qq')){?>
				   <a href="https://wpa.qq.com/msgrd?v=3&amp;uin=<?php echo get_boxmoe('social_qq');?>&amp;site=qq&amp;menu=yes" target="_blank" class="btn-social color-qq border-0  mr-2">
                   <i class="fa fa-qq"></i></a><?php } ?><?php if(get_boxmoe('boxmoe_wechat')){?>                    
				   <a href="<?php echo get_boxmoe('boxmoe_wechat');?>" data-fancybox="images" data-fancybox-group="button" target="_blank" class="btn-social color-weixin border-0  mr-2">
                   <i class="fa fa-weixin"></i></a> <?php } ?><?php if(get_boxmoe('boxmoe_github')){?>
                   <a href="<?php echo get_boxmoe('social_github');?>" target="_blank" class="btn-social color-github border-0  mr-2">
                   <i class="fa fa-github"></i></a><?php } ?>                 
				  </div>
                </div>
            </div><?php } ?>	<?php endwhile; ?>			
				<?php $categories=get_the_category();$categoryIDS=array();foreach ($categories as $category) { array_push($categoryIDS, $category->term_id);}$categoryIDS = implode(",", $categoryIDS);?>	  
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
                <div class="thw-sept"> </div>
                <?php if (get_boxmoe('comments_off')==''):?><?php comments_template( '', true); ?><?php endif; ?> 	
	<?php if( get_boxmoe('post_related_s') ) {?> 	
		
		<div class="container postrelated mt-5">       
		<div class="row">
		<div class="thw-sept"> </div>	
     <?php if( get_boxmoe('post_related_s') ) boxmoe_posts_related( get_boxmoe('related_title'), get_boxmoe('post_related_n'), (get_boxmoe('post_related_model') ? get_boxmoe('post_related_model') : 'thumb') ) ?>
		</div>
		</div>	  
	 <?php }	?>	 				
            </div>
			</div>
<?php if(get_boxmoe('sidebar_on') == 'col-2' ){get_sidebar();} else {} ?>				
          </div>
        </div>
      </div>			  
<?php get_footer(); ?>