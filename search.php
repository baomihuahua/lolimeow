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
	  <div class="container shape-container d-flex align-items-center py-lg">
          <div class="col px-0">
            <div class="row align-items-center justify-content-center">
              <div class="col-lg-8 text-center">
<h2 class="headerpagetit text-white">搜索:[<?php echo htmlspecialchars($s); ?>]<?php echo __('关键词的结果', 'meowdata') ?><?php global $wp_query;echo ' 共' . $wp_query->found_posts . ' 篇文章';?></h2>
              </div>
            </div>
          </div>
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
<?php if ( !have_posts() ) : ?>	<h3 class="text-muted text-center"><?php echo __('暂无搜索结果', 'meowdata') ?></h3><?php else: ?>									  
<?php while ( have_posts() ) : the_post(); get_template_part( 'component/blog-list' ); endwhile;?>
<?php endif; ?>
</div>                                     
</div>
</div>
<?php md_paging(); ?>
</div>      
</main>								  							 							 							  
<?php get_footer(); ?>
