<?php 
/**
 * @link https://www.boxmoe.com
 * @package lolimeow
 */
get_header();
?>
        <div class="container"><?php if(get_boxmoe('hitokoto_on')){?>
		<div class="site-main">
          <h1 class="main-title">
            <i class="fa fa-heartbeat"></i>
            <span id="hitokoto"></span></h1>
        </div>
        		<script>$.get("https://v1.hitokoto.cn/?c=<?php echo get_boxmoe('hitokoto_text','b'); ?>", {},
        function(data) {
          document.getElementById("hitokoto").innerHTML = data.hitokoto;
        });</script><?php }?>
          <div class="section-head">
            <span><?php if(is_home()) {echo'Home';}else{echo'category';}  ?></span></div>		
        </div>
        <div class="boxmoe-blog-content">
          <div class="container-full">
            <div class="row">
              <div class="col-lg-<?php echo sidebaron(); ?>">
<?php while ( have_posts() ) : the_post(); get_template_part( 'component/blog-list' );endwhile; ?>	             
                <?php boxmoe_paging(); ?>
              </div>
<?php if(get_boxmoe('sidebar_on') == 'col-2' ){get_sidebar();} else {} ?>
            </div>
          </div>
        </div>
<?php get_footer(); ?>
