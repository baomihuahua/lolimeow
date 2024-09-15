<?php
/**
 * @package lolimeow@boxmoe themes
 * @link https://www.boxmoe.com
 */
?>
      <section id="boxmoe_theme_footer">
        <hr class="horizontal dark">
        <footer class="small">
          <div class="container">
            <div class="row">
              <div class="row align-items-center">
                <div class="col-md-3 footer-left">
                  <?php echo boxmoe_load_footerlogo();?>
                </div>
                <div class="col-md-6 text-center">
				<?php boxmoe_footer_seo();?>
                </div>
                <div class="col-md-3 footer-right">
                  <div class="text-md-end">
				  <?php boxmoe_footer_social();?>
                  </div>
                </div>
              </div>
              <div class="col-lg-12 text-center">
                <?php boxmoe_footer_info();?>
              </div>
            </div>
          </div>
        </footer>
      </section>
      </div>   
    <div id="search">
      <span class="close">X</span>
      <form role="search" id="searchform" method="get" action="<?php echo home_url( '/' ) ?>">
        <div class="search_form_inner">
          <div class="search-bar">
            <i class="fa fa-search"></i>
            <input type="search" name="s" value="<?php echo htmlspecialchars($s) ?>" placeholder="输入搜索关键词..." /></div>
        </div>
      </form>
    </div>
	  <div class="body-background"></div>   
    <div class="floating-action-menu">
      <nav class="floating-menu-items">
        <ul>
          <?php if(get_boxmoe('blog_layout') == 'two' ){?><li class="d-lg-none"><a class="button" title="打开侧栏" data-bs-toggle="offcanvas" href="#blog-sidebar" aria-controls="blog-sidebar"><i class="fa fa-outdent"></i></a></li><?php } ?>
          <?php if (get_boxmoe('lolijump') ){?><li><a id="lolijump" href="#"><img src="<?php echo boxmoe_themes_dir(); ?>/assets/images/top/<?php echo get_boxmoe('lolijumpsister'); ?>.gif"></a></li><?php } ?>
        </ul>
      </nav>
    </div>  
	</body>	
	<?php echo boxmoe_load_footer(); ?>
	<?php wp_footer(); ?>
	<?php echo get_boxmoe('diy_code_footer',''); ?>
</html>
