<?php 
/**
 * @link https://www.boxmoe.com
 * @package lolimeow
 */
?>
<!--
                   _ooOoo_
                  o8888888o
                  88" . "88
                  (| -_- |)
                  O\  =  /O
               ____/`---'\____
             .'  \\|     |//  `.
            /  \\|||  :  |||//  \
           /  _||||| -:- |||||-  \
           |   | \\\  -  /// |   |
           | \_|  ''\---/''  |   |
           \  .-\__  `-`  ___/-. /
         ___`. .'  /--.--\  `. . __
      ."" '<  `.___\_<|>_/___.'  >'"".
     | | :  `- \`.;`\ _ /`;.`/ - ` : | |
     \  \ `-.   \_ __\ /__ _/   .-` /  /
======`-.____`-.___\_____/___.-`____.-'======
                   `=---='
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
    佛祖保佑       永不宕机     永无BUG
-->
<!DOCTYPE html>
<html <?php language_attributes(); ?>> 
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php if(get_boxmoe('favicon_src')){?><?php echo  boxmoe_favicon();?><?php } ?>
    <title><?php echo  boxmoe_title(); ?></title>
	<?php echo boxmoe_keywords()?>
    <?php echo boxmoe_description()?>
    <?php echo boxmoe_load_header(); ?>
	<?php wp_head(); ?>
	<?php if(get_boxmoe('banner_height')){?><style>.section-blog-cover{height:<?php echo get_boxmoe('banner_height');?>px;}</style><?php }?>
	<?php if(get_boxmoe('m_banner_height')){?><style>@media (max-width:767px){.section-blog-cover {height:<?php echo get_boxmoe('m_banner_height');?>px;}}</style><?php }?>
</head>
  <body class="index-page <?php if(get_boxmoe('body_background')){echo'body_color';}?>">
  <?php echo boxmoe_load_lantern(); ?>
    <div id="preloader">
      <div class="book">
        <div class="inner">
          <div class="left"></div>
          <div class="middle"></div>
          <div class="right"></div>
        </div>
        <ul>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
        </ul>
      </div>
    </div>
	<div id="boxmoe_global">	
    <header class="header-global">
      <nav id="navbar-main" class="navbar navbar-expand-lg navbar-light navbar-transparent headroom">
        <div class="container">
          <a class="logo navbar-brand font-weight-bold" href="<?php echo home_url(); ?>" title="boxmoe">
            <?php echo boxmoe_logo();?></a>
          <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon mt-2">
              <span class="navbar-toggler-bar bar1"></span>
              <span class="navbar-toggler-bar bar2"></span>
              <span class="navbar-toggler-bar bar3"></span>
            </span>
          </button>
          <div class="collapse navbar-collapse w-100 pt-3 pb-2 py-lg-0" id="navigation">
            <ul class="navbar-nav navbar-nav-hover mx-auto">
              <?php boxmoe_nav_menu();?>
                <?php if( get_boxmoe('sousuo')){ ?><li class="nav-item"><a href="#search" class="nav-link"><i class="fa fa-search"></i>Search</a></li><?php } ?>
            </ul><?php if( get_boxmoe('sign_f') & is_user_logged_in() ){ global $current_user; wp_get_current_user(); ?>
			<ul class="navbar-nav d-lg-block sign_f" id="userlogin">
			<li class="nav-item dropdown dropdown-hover nav-item">
			<a href="#" class="nav-link  dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user-circle-o"></i>Hello！<?php echo $current_user->nickname; ?></a>
			<ul class="dropdown-menu">
			<li><a href="<?php get_user_url(); ?>" class="dropdown-item"><i class="fa fa-address-card-o"></i>会员中心</a></li>
			<li><a href="<?php echo wp_logout_url( home_url() ); ?>" class="dropdown-item"><i class="fa fa-sign-out"></i>注销登录</a></li>
			</ul>
			</li>
			</ul><?php } ?><?php if( get_boxmoe('sign_f') & !is_user_logged_in() ){ ?>
              <div class="boxmoe-user-login hidden-sm" id="userlogin">
                <div class="boxmoe_user-wrapper">
                  <span class="boxmoe_user-loader">
                    <a href="<?php get_login_url(); ?>?r=<?php get_user_url(); ?>" class="signin-loader z-bor">登录</a>
                    <b class="middle-text">
                      <span class="middle-inner">or</span></b>
                  </span>
                  <span class="boxmoe_user-loader">
                    <a href="<?php get_reg_url(); ?>" class="signup-loader l-bor">注册</a></span>
                </div>
                <i class="up-new"></i>
              </div><?php } ?>			
          </div>
        </div>
      </nav>
    </header>
    
      <section class="section-blog-cover section-shaped my-0" <?php echo boxmoe_banner();?>>
        <div class="separator separator-bottom separator-skew">
          <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
			<defs>
			<path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z"></path>
			</defs>
			<g class="parallax">
				<use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(255,255,255,0.7"></use>
				<use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(255,255,255,0.5)"></use>
				<use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(255,255,255,0.3)"></use>
				<use xlink:href="#gentle-wave" x="48" y="7" fill="#fff"></use>
			</g>
		</svg>
        </div>
      </section>
      <section class="boxmoe_blog <?php echo single_border();?>">