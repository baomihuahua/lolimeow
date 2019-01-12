<?php get_header(); ?>
<section class="section-profile-cover section-blog-cover section-shaped my-0 " <?php if( meowdata('banneron') ) {echo md_banner();} ?>>
      <div class="shape shape-style-1 shape-primary alpha-4">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
      </div>
      <div class="separator separator-bottom separator-skew" >
        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none">
          <polygon class="fill-white" points="2560 0 2560 100 0 100"></polygon>
        </svg>
      </div>
    </section> 
<main class="meowblog">
<div class="main-container">
                              <div class="container">
                                    <div class="row">
                                          <div class="col-lg-12 col-md-12 post-standard-list3-style">
<?php 
while ( have_posts() ) : 
the_post(); 
if( has_post_format( 'status' )) { 
get_template_part( 'component/blog-list-status' );
 } else if ( has_post_format( 'aside' )) { 
get_template_part( 'component/blog-list-aside' );
 }  else{ get_template_part( 'component/blog-list' );
 } ;
endwhile; ?>
</div>                                     
</div>
</div>
<?php md_paging(); ?>
<?php if( meowdata('indexlinks') ){ ?><?php echo get_the_link_items_index(); ?><?php } ?>  
</div>    
</main>								  							 							 							  
<?php get_footer(); ?>