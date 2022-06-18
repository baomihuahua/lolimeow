<?php 
/**
 * Template Name: Boxmoe友情链接
 * @link https://www.boxmoe.com
 * @package lolimeow
 */
get_header();
?>
      <div class="container">
        <div class="section-head">
          <span>Links</span></div>
      </div>
      <div class="boxmoe-blog-page mb30">
        <div class="container-full">	  
          <div class="row">
            <div class="col-md-12 col-lg-12 mx-auto">
<?php while (have_posts()) : the_post(); ?>
              <div class="post-single">
                <h3 class="post-title <?php boxmoe_wow_set( )?>"><?php the_title(); echo get_the_subtitle(); ?></h3>
                <div class="post-content">
				<?php the_content(); ?>				  
                </div>
              </div>
<?php endwhile;  ?>
<?php echo get_link_items(); ?>
            </div>
          </div>
        </div>
      <div class="container">
        <div class="row">
          <div class="col-md-12 col-lg-12 mx-auto">
<?php comments_template('', true); ?>
		  </div>
        </div>
      </div>		
      </div>
<?php  get_footer(); ?>
