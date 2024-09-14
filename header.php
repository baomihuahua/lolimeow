<?php
/**
 * @package lolimeow@boxmoe themes
 * @link https://www.boxmoe.com
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title><?php echo  boxmoe_title(); ?></title>
	  <?php echo boxmoe_keywords()?>
    <?php echo boxmoe_description()?>
    <?php echo boxmoe_favicon();?>
	  <?php wp_head(); ?>
	  <?php if(get_boxmoe('banner_height')){?><style>.section-blog-cover{height:<?php echo get_boxmoe('banner_height');?>px;}</style><?php }?>
	  <?php if(get_boxmoe('m_banner_height')){?><style>@media (max-width:767px){.section-blog-cover {height:<?php echo get_boxmoe('m_banner_height');?>px;}}</style><?php }?>

  <body>
    <?php if(get_boxmoe('boxmoe_preloader')){ ?> 
      <div class="preloader">
      <svg version="1.1" id="boxmoe-sakura" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="80" height="80" viewBox="0 0 80 80" style="enable-background:new 0 0 80 80;" xml:space="preserve">
         <g id="sakura">
            <path id="hana-01" class="st0" d="M52,16.4c-1-8-8-12-8-12l-4,2l-4-2c0,0-7,4-8,12c-0.4,3.2,1,7,2,9.1c2.1,4.4,6.4,7.9,10,10.9
               c3.6-3,7.9-6.6,10-10.9C51,23.4,52.4,19.7,52,16.4z">
               <animate attributeType="XML" attributeName="opacity" values="0;1;1;1;1;1;0;0;0;0" dur="5s" calcMode="discrete" begin="0s" repeatCount="indefinite"></animate>
            </path>
            <path id="hanapath-01" class="st1" d="M52,16.4c-1-8-8-12-8-12l-4,2l-4-2c0,0-7,4-8,12c-0.4,3.2,1,7,2,9.1c2.1,4.4,6.4,7.9,10,10.9
               c3.6-3,7.9-6.6,10-10.9C51,23.4,52.4,19.7,52,16.4z"></path>
            <path id="hana-02" class="st0" d="M74.2,31.3l0.7-4.4c0,0-6-5.4-13.9-3.9c-3.2,0.6-6.3,3.1-8,4.7c-3.5,3.4-5.6,8.5-7.3,12.9
               c4,2.5,8.7,5.5,13.5,6.1c2.3,0.3,6.3,0.5,9.2-0.9c7.3-3.4,8.9-11.3,8.9-11.3L74.2,31.3z">
               <animate attributeType="XML" attributeName="opacity" values="0;1;1;1;1;1;0;0;0;0" dur="5s" calcMode="discrete" begin="0.5s" repeatCount="indefinite"></animate>
            </path>
            <path id="hanapath-02" class="st1" d="M74.2,31.3l0.7-4.4c0,0-6-5.4-13.9-3.9c-3.2,0.6-6.3,3.1-8,4.7c-3.5,3.4-5.6,8.5-7.3,12.9
               c4,2.5,8.7,5.5,13.5,6.1c2.3,0.3,6.3,0.5,9.2-0.9c7.3-3.4,8.9-11.3,8.9-11.3L74.2,31.3z"></path>
            <path id="hana-03" class="st0" d="M65,56.4c-1.6-2.9-4.9-5.1-6.9-6.2c-4.3-2.3-9.8-2.7-14.5-3c-1.2,4.6-2.5,9.9-1.7,14.7
               c0.4,2.2,1.5,6.1,3.7,8.5c5.5,5.9,13.5,5,13.5,5l2.1-4l4.4-0.7C65.6,70.8,68.9,63.5,65,56.4z">
               <animate attributeType="XML" attributeName="opacity" values="0;1;1;1;1;1;0;0;0;0" dur="5s" calcMode="discrete" begin="1s" repeatCount="indefinite"></animate>
            </path>
            <path id="hanapath-03" class="st1" d="M65,56.4c-1.6-2.9-4.9-5.1-6.9-6.2c-4.3-2.3-9.8-2.7-14.5-3c-1.2,4.6-2.5,9.9-1.7,14.7
               c0.4,2.2,1.5,6.1,3.7,8.5c5.5,5.9,13.5,5,13.5,5l2.1-4l4.4-0.7C65.6,70.8,68.9,63.5,65,56.4z"></path>
            <path id="hana-04" class="st0" d="M36.5,47.3c-4.7,0.3-10.2,0.7-14.5,3c-2,1.1-5.4,3.3-6.9,6.2c-3.9,7.1-0.6,14.4-0.6,14.4l4.4,0.7
               l2.1,4c0,0,8,0.9,13.5-5c2.2-2.4,3.3-6.3,3.7-8.5C39,57.2,37.6,51.9,36.5,47.3z">
               <animate attributeType="XML" attributeName="opacity" values="0;1;1;1;1;1;0;0;0;0" dur="5s" calcMode="discrete" begin="1.5s" repeatCount="indefinite"></animate>
            </path>
            <path id="hanapath-04" class="st1" d="M36.5,47.3c-4.7,0.3-10.2,0.7-14.5,3c-2,1.1-5.4,3.3-6.9,6.2c-3.9,7.1-0.6,14.4-0.6,14.4
               l4.4,0.7l2.1,4c0,0,8,0.9,13.5-5c2.2-2.4,3.3-6.3,3.7-8.5C39,57.2,37.6,51.9,36.5,47.3z"></path>
            <path id="hana-05" class="st0" d="M27,27.7c-1.6-1.6-4.8-4.1-8-4.7c-7.9-1.5-13.9,3.9-13.9,3.9l0.7,4.4l-3.1,3.2
               c0,0,1.6,7.9,8.9,11.3c3,1.4,7,1.2,9.2,0.9c4.8-0.7,9.5-3.6,13.5-6.1C32.5,36.2,30.5,31.1,27,27.7z">
               <animate attributeType="XML" attributeName="opacity" values="0;1;1;1;1;1;0;0;0;0" dur="5s" calcMode="discrete" begin="2s" repeatCount="indefinite"></animate>
            </path>
            <path id="hanapath-05" class="st1" d="M27,27.7c-1.6-1.6-4.8-4.1-8-4.7c-7.9-1.5-13.9,3.9-13.9,3.9l0.7,4.4l-3.1,3.2
               c0,0,1.6,7.9,8.9,11.3c3,1.4,7,1.2,9.2,0.9c4.8-0.7,9.5-3.6,13.5-6.1C32.5,36.2,30.5,31.1,27,27.7z"></path>
            <animateTransform attributeType="XML" attributeName="transform" type="rotate" values="0 40 40; 360 40 40" calcMode="linear" dur="10s" repeatCount="indefinite"></animateTransform>
         </g>
         <animateTransform attributeName="transform" type="translate" additive="sum" from="40,40" to="40,40"></animateTransform>
         <animateTransform attributeName="transform" type="scale" additive="sum" keyTimes="0;0.5;1" keySplines="0.42 0.0 0.58 1.0" values="1,1;0.75,0.75;1,1" dur="3s" repeatCount="indefinite"></animateTransform>
         <animateTransform attributeName="transform" type="translate" additive="sum" from="-40,-40" to="-40,-40"></animateTransform>
      </svg>
   </div>
	<?php } ?>
  <?php echo boxmoe_load_lantern(); ?>
    <div id="boxmoe_theme_global">
      <section id="boxmoe_theme_header" class="fadein-top">
        <nav class="navbar navbar-expand-lg navbar-bg-box">
          <div class="container">
            <a class="navbar-brand" href="<?php echo home_url(); ?>" title="<?php echo get_bloginfo('name'); ?>">
			<?php echo boxmoe_logo(); ?></a>
            <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </span>
            </button>
            <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="navigation" aria-labelledby="offcanvasWithBothOptionsLabel">
              <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel">
                 <?php echo boxmoe_logo(); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
              </div>
              <div class="offcanvas-body">
                <ul class="navbar-nav mx-auto">
				        <?php boxmoe_nav_menu();?>
                </ul>
                <ul class="navbar-nav">
				<li class="nav-item">
                    <a href="#search" class="nav-link search btn">
                      <i class="fa fa-search"></i>
                    </a>
                  </li>
                  <?php if(get_boxmoe('sign_f')){ ?><?php if(!is_user_logged_in() ){ ?>
                  <li class="nav-item">
                    <div class="user-wrapper">
                      <div class="user-no-login">
                        <span class="user-login">
                          <a href="<?php get_login_url(); ?>?r=<?php get_user_url(); ?>" class="signin-loader z-bor">登录</a>
                          <b class="middle-text">
                            <span class="middle-inner">or</span></b>
                        </span>
                        <span class="user-reg">
                          <a href="<?php get_reg_url(); ?>" class="signup-loader l-bor">注册</a></span>
                      </div>
                      <i class="up-new"></i>
                    </div>
                  </li><?php }else{ ?>
                  <li class="nav-item dropdown dropdown-hover nav-item">
                    <a href="#" class="nav-link  dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fa fa-user-circle-o"></i><?php $current_user = wp_get_current_user(); echo 'Hello！, ' . esc_html( $current_user->user_login );; ?></a>
                    <ul class="dropdown-menu">
                      <li>
                        <a href="<?php get_user_url(); ?>" class="dropdown-item">
                          <i class="fa fa-address-card-o"></i>会员中心</a>
                      </li>
                      <li>
                        <a href="<?php echo wp_logout_url( home_url() ); ?>" class="dropdown-item">
                          <i class="fa fa-sign-out"></i>注销登录</a>
                      </li><?php } ?>
                    </ul>
                  </li>
                  <?php } ?>
                </ul>
              </div>
            </div>
          </div>
        </nav>
      </section>
      <section class="section-blog-cover fadein-top" <?php echo boxmoe_banner();?>>
        <div class="site-main">
          <h2 class="text-gradient"><?php if(get_boxmoe('banner_font')){echo get_boxmoe('banner_font');}?></h2>
          <?php if(get_boxmoe('hitokoto_on')){?>
          <h1 class="main-title">
            <i class="fa fa-star spinner"></i>
            <span id="hitokoto" class="text-gradient"></span>
          </h1> 
          <?php }?>
        </div>
        <div class="separator separator-bottom separator-skew">
          <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
            <defs>
              <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z"></path>
            </defs>
            <g class="parallax">
              <use xlink:href="#gentle-wave" x="48" y="0"></use>
              <use xlink:href="#gentle-wave" x="48" y="3"></use>
              <use xlink:href="#gentle-wave" x="48" y="5"></use>
              <use xlink:href="#gentle-wave" x="48" y="7"></use>
            </g>
          </svg>
        </div>
      </section>

