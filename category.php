<?php 
/**
 * @link https://www.boxmoe.com
 * @package lolimeow
 */
get_header();
?>
        <div class="container">
          <div class="section-head">
            <span>Category</span></div>
        </div>
        <div class="boxmoe-blog-content">
          <div class="container-full">
            <div class="row">
              <div class="col-lg-<?php echo sidebaron(); ?>">
<?php while ( have_posts() ) : the_post(); get_template_part( 'component/blog-list' );endwhile; ?>	             
                <?php boxmoe_paging(); ?>
              </div>
<?php if(get_boxmoe('sidebar_on') == 'col-1' ){} else {get_sidebar();} ?>
            </div>
          </div>
        </div>
<?php get_footer(); ?>
