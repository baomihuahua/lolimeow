<?php
/**
 * @link https://www.boxmoe.com
 * @package lolimeow
 */
get_header(); ?>
        <div class="container">
          <div class="section-head">
            <span>Search</span></div>
        <div class="site-main">
          <h1 class="main-title">
            <i class="fa fa-search"></i>
            <span>搜索:[<?php echo htmlspecialchars($s); ?>]关键词<?php global $wp_query;echo ' 共' . $wp_query->found_posts . ' 篇文章';?></span></h1>
        </div>			
        </div>
        <div class="boxmoe-blog-content">
          <div class="container-full">
            <div class="row">
              <div class="col-lg-<?php echo sidebaron($sidebar,'10 mx-auto'); ?>">
<?php while ( have_posts() ) : the_post(); get_template_part( 'component/blog-list' );endwhile; ?>	             
                <?php boxmoe_paging(); ?>
              </div>
<?php if(get_boxmoe('sidebar_on') == 'col-2' ){get_sidebar();} else {} ?>
            </div>
          </div>
        </div>
<?php get_footer(); ?>
