<?php
/**
 * @link https://www.boxmoe.com
 * @package lolimeow
 */
?>
      </section>			  
    </div>
    <footer class="footer fontsom">
      <hr class="horizontal dark">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 mb-2 mx-auto text-center nav-footer">
            <?php echo get_boxmoe('footer_seo') ;?>	
			</div>
          <div class="col-lg-8 mx-auto text-center mt-2 mb-2"><?php if(get_boxmoe('boxmoe_qq')){?>
            <a href="https://wpa.qq.com/msgrd?v=3&amp;uin=<?php echo get_boxmoe('boxmoe_qq');?>&amp;site=qq&amp;menu=yes" target="_blank" class="text-secondary me-xl-4 me-4">
              <i class="fa fa-qq"></i>
            </a><?php } ?><?php if(get_boxmoe('boxmoe_wechat')){?>
            <a href="<?php echo get_boxmoe('boxmoe_wechat');?>" data-fancybox="images" data-fancybox-group="button" class="text-secondary me-xl-4 me-4">
              <i class="fa fa-wechat"></i>
            </a><?php } ?><?php if(get_boxmoe('boxmoe_weibo')){?>
            <a href="<?php echo get_boxmoe('boxmoe_weibo');?>" target="_blank" class="text-secondary me-xl-4 me-4">
              <i class="fa fa-weibo"></i>
            </a><?php } ?><?php if(get_boxmoe('boxmoe_github')){?>
            <a href="<?php echo get_boxmoe('boxmoe_github');?>" target="_blank" class="text-secondary me-xl-4 me-4">
              <i class="fa fa-github"></i>
            </a><?php } ?><?php if(get_boxmoe('boxmoe_mail')){?>
            <a href="http://mail.qq.com/cgi-bin/qm_share?t=qm_mailme&email=<?php echo get_boxmoe('boxmoe_mail');?>" target="_blank" class="text-secondary me-xl-4 me-4">
              <i class="fa fa-envelope"></i>
            </a><?php } ?>
          </div>
        </div>
        <div class="row">
          <div class="col-8 mx-auto text-center mt-2 mb-2">
            <p class="mb-0 copyright">© <?php echo date('Y'); ?>
              <a href="<?php echo home_url();?>" target="_blank"><?php echo get_bloginfo( 'name' );?></a> | Theme by
              <a href="https://www.boxmoe.com" target="_blank">LoLiMeow</a>&nbsp; <?php echo get_boxmoe('footer_info','| 本站使用Wordpress创作') ?>
			   <br><?php echo get_boxmoe('trackcode','网站统计') ?>
               <br><?php if(get_boxmoe('boxmoedataquery') ){?><?php echo get_num_queries(); ?> queries in <?php timer_stop(3); ?> s <?php } ?></p>
		  </div>
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
	<?php if (get_boxmoe('lolijump') ): ?><div id="lolijump"><img src="<?php echo boxmoe_load_style(); ?>/assets/images/top/<?php echo get_boxmoe('lolijumpsister'); ?>.gif"></div><?php endif; ?>
	<script src="<?php echo boxmoe_load_style();?>/assets/js/theme.js" type="text/javascript"></script>
	<script src="<?php echo get_template_directory_uri();?>/assets/js/comments.js" type="text/javascript"></script>
    <script src="<?php echo boxmoe_load_style();?>/assets/js/lolimeow.js" type="text/javascript" id="boxmoe_script"></script>
	<?php wp_footer(); ?>
	<?php if (get_boxmoe('music_on') ): ?>
    <link id="APlayer" href="<?php echo boxmoe_load_style();?>/assets/css/APlayer.min.css" rel="stylesheet" />
    <script src="<?php echo boxmoe_load_style();?>/assets/js/APlayer.min.js" type="text/javascript"></script>
	<div class="aplayer" data-id="<?php echo get_boxmoe('163_music_id','2765798464');?>" data-fixed="true" data-server="netease" data-volume="0.4 "data-type="playlist"></div>
    <script src="<?php echo boxmoe_load_style();?>/assets/js/Meting.min.js" type="text/javascript"></script>
	<?php endif; ?>
  </body>
</html>
