<?php
/**
 * @package lolimeow@boxmoe themes
 * @link https://www.boxmoe.com
 */
get_header();
?>
      <section class="section-blog-breadcrumb container fadein-bottom">
        <div class="breadcrumb-head">
          <span>
            <i class="fa fa-home"></i>Search</span>
        </div>
      </section>
	  <section>
		<div class="container fadein-bottom">
					<div class="site-search">
						<h1 class="search-title">
						<i class="fa fa-search"></i>
						<span>搜索:[<?php echo htmlspecialchars($s); ?>]关键词<?php global $wp_query;echo ' 共' . $wp_query->found_posts . ' 篇文章';?></span></h1>
                </div>
		</div>
		</section>
      <section id="boxmoe_theme_container">
        <div class="container">
          <div class="row">
            <div class="blog-post <?php echo boxmoe_blog_layout() ?> fadein-bottom">
			        <?php while ( have_posts() ) : 
			        the_post();
			        get_template_part( 'module/template/blog-list');
			        endwhile; 
			        ?>
			      <?php boxmoe_paging(); ?>
            </div>
            <?php if (get_boxmoe('blog_layout')== 'two' ): ?>
              <?php get_sidebar();?>
              <?php endif; ?>	      
            </div>
        </div>
      </section>	
<?php get_footer(); ?>