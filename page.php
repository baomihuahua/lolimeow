<?php 
/**
 * @link https://www.boxmoe.com
 * @package lolimeow
 */
 get_header(); ?>
       <div class="container">
        <div class="section-head">
          <span>Page</span></div>
      </div>
        <div class="boxmoe-blog-content">
          <div class="container-full">
            <div class="row">
              <div class="col-lg-<?php echo sidebaron(); ?>">
			  <div class="<?php echo boxmoe_border()?> single-card mb-4"><?php while (have_posts()) : the_post(); ?>
                <div class="post-single">
                  <div class="post-header">
                    <h3 class="post-title"><?php the_title(); echo get_the_subtitle(); ?></h3>
                    <div class="thw-sept">
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
                </div><?php endwhile; ?>
                <div class="thw-sept"> </div>				
                <?php if (get_boxmoe('comments_off')==''):?><?php comments_template( '', true); ?><?php endif; ?> 					 			 
            </div>
			</div>
<?php if(get_boxmoe('sidebar_on') == 'col-2' ){get_sidebar();} else {} ?>						
          </div>
        </div>
      </div>	 
<?php get_footer(); ?>	  

