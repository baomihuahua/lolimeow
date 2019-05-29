  <footer class="footer">
    <div class="container">
      <div class="row row-grid align-items-center">
        <div class="col-lg-12 text-lg-center btn-wrapper justify-content-center">
		<?php if(meowdata('social_qq')){?> <a href="https://wpa.qq.com/msgrd?v=3&amp;uin=<?php echo meowdata('social_qq');?>&amp;site=qq&amp;menu=yes" target="_blank" class="btn btn-neutral btn-icon-only btn-qq btn-round btn-lg wow fadeInUpBig" data-toggle="tooltip" data-original-title="博主宝宝QQ<?php echo meowdata('social_qq');?>"><i class="fa fa-qq"></i></a><?php } ?>
		<?php if(meowdata('social_github')){?><a target="_blank" href="<?php echo meowdata('social_github');?>" class="btn btn-neutral btn-icon-only btn-github btn-round btn-lg" data-toggle="tooltip" data-original-title="Github">            <i class="fa fa-github"></i>          </a><?php } ?>
		<?php if(meowdata('social_wechat')){?><button type="button" class="btn btn-neutral btn-icon-only btn-wechat btn-round btn-lg wow fadeInUpBig" data-toggle="modal" data-target="#modal-notification"><i class="fa fa-wechat"></i></button>		
		<div class="modal fade" id="modal-notification" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
     <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
        <div class="modal-content bg-gradient-danger">

            <div class="modal-header">
                <h6 class="modal-title" id="modal-title-notification">打开微信扫一扫二维码就可以啦</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="py-3 text-center">
                   <img class="img img-raised" src="<?php echo meowdata('social_wechat') ;?>" width="200" height="200" alt="wechat" >
                </div>

            </div>
        </div>
    </div>
</div>
<?php } ?>
<?php if(meowdata('social_mail')){?><a href="http://mail.qq.com/cgi-bin/qm_share?t=qm_mailme&email=<?php echo meowdata('social_mail');?>" target="_blank" class="btn btn-neutral btn-icon-only btn-mail btn-round btn-lg wow fadeInUpBig" data-toggle="tooltip" data-original-title="Email：<?php echo meowdata('social_mail');?>"><i class="fa fa-envelope"></i></a><?php } ?>						  
        </div>
      </div>
      <hr>
      <div class="row align-items-center justify-content-md-between">

	      <div class="col-md-12 ">
          <ul class="nav nav-footer justify-content-center">
           <?php echo meowdata('footer_seo') ?>
          </ul>
        </div>
        <div class="col-md-12">
          <div class="copyright text-center">
            © <?php echo date('Y'); ?> <a href="<?php echo home_url();?>" target="_blank" ><?php echo get_bloginfo( 'name' );?> </a>. Theme by <a href="https://mkm.st"  target="_blank" >LoLiMeow</a>&nbsp;<?php echo get_num_queries(); ?> queries in <?php timer_stop(3); ?> s &nbsp;<?php echo meowdata('footer_info') ?> <div <?php if(meowdata('trackcodehidden'))echo 'style="display:none;"'?>><?php echo meowdata('trackcode') ?>
			</div>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <div id="search"> 
	<span class="close">X</span>
	<form role="search" id="searchform" method="get" action="<?php echo home_url( '/' ) ?>">
		<input type="search" name="s" value="<?php echo htmlspecialchars($s) ?>" placeholder="输入搜索关键词..."/>
	</form>
</div>
  <?php if(meowdata('lolijump')){?>
  <div id="lolijump"><img src="<?php echo md_stylesrc();?>/assets/images/lolijump.gif" ></div>  
  <script language="javascript">
lastScrollY=0;
function heartBeat0(){
diffY=document.body.scrollTop;
percent=.1*(diffY-lastScrollY);
if(percent>0)percent=Math.ceil(percent);
else percent=Math.floor(percent);
document.all.lolijump.style.pixelTop+=percent;
lastScrollY=lastScrollY+percent;}
window.setInterval("heartBeat0()",1);
$('#lolijump').click(function(){
        $('html, body').animate({                
            scrollTop: 0
        }, 500);
    });
</script> 
<?php } ?>
  <script src="<?php echo md_stylesrc();?>/assets/vendor/popper/popper.min.js"></script>
  <script src="<?php echo md_stylesrc();?>/assets/vendor/bootstrap/bootstrap.min.js"></script>
  <script src="<?php echo md_stylesrc();?>/assets/vendor/headroom/headroom.min.js"></script>    
  <script src="<?php echo md_stylesrc();?>/assets/js/wow.min.js"></script>
  <script src="<?php echo md_stylesrc();?>/assets/js/theme.js"></script>
  <?php wp_footer(); ?>
  <?php if(is_single() || is_page() ) {?><script src="<?php echo get_template_directory_uri(); ?>/assets/js/custom.js"></script>
  <?php if(meowdata('codept')){?><script src="<?php echo md_stylesrc();?>/assets/vendor/prettify/prettify.js"></script><?php } ?>
  <script src="<?php echo md_stylesrc();?>/assets/vendor/fancybox/fancybox.js"></script><?php } ?>
</body>
</html>
