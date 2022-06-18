<?php
/**
 * @link https://www.boxmoe.com
 * @package lolimeow
 */
?>
      </section>			  
    </div>

<footer class="footer pb-3 pt-3 position-relative">
	
  <div class="container">
  <hr class="horizontal dark">
    <div class="row">
      <div class="col-lg-3">
        <h6 class="font-weight-bolder mb-lg-4 mb-3"><i class="fa fa-sign-language"></i> <?php echo get_bloginfo( 'name' );?></h6>
      </div>
      <div class="col-lg-6 text-center">
        <?php boxmoe_footer_seo();?>
        <?php boxmoe_footer_info();?>
      </div>
      <?php boxmoe_footer_qq();?>
    </div>
  </div>
</footer>
    <div id="search">
      <span class="close">X</span>
      <form role="search" id="searchform" method="get" action="<?php echo home_url( '/' ) ?>">
        <div class="search_form_inner  animate slideUp">
          <div class="search-bar">
            <i class="fa fa-search"></i>
            <input type="search" name="s" value="<?php echo htmlspecialchars($s) ?>" placeholder="输入搜索关键词..." /></div>
        </div>
      </form>
    </div>
	<?php echo boxmoe_load_footer(); ?>
	<?php wp_footer(); ?>
	<?php echo get_boxmoe('diy_code_footer',''); ?>
  </body>
</html>
