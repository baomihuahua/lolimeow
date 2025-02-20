<?php
/**
 * @link https://www.boxmoe.com
 * @package lolimeow
 */
//boxmoe.com===安全设置=阻止直接访问主题文件
if(!defined('ABSPATH')){echo'Look your sister';exit;}?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo boxmoe_theme_title(); ?></title>
    <link rel="icon" href="<?php echo boxmoe_favicon(); ?>" type="image/x-icon">
    <?php boxmoe_keywords(); ?>
    <?php boxmoe_description(); ?>
    <?php ob_start();wp_head();$wp_head_output = ob_get_clean();echo preg_replace('/\n/', "\n    ", trim($wp_head_output))."\n    ";?>
    <?php if (get_boxmoe('boxmoe_banner_height_switch')){ boxmoe_banner_height_load(); }?>
</head>
  <body>
  <?php if(get_boxmoe('boxmoe_page_loading_switch')): ?>  
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
   <style>.preloader{position:fixed;top:0;left:0;width:100%;height:100%;background:#fff;display:flex;justify-content:center;align-items:center;z-index:9999;opacity:1;transition:opacity 0.5s ease;}.preloader svg{max-width:80%;max-height:80%;position:absolute;top:0;left:0;right:0;bottom:0;margin:auto}.preloader{background:#f8c3cd;text-align:center;height:100%;position:fixed;width:100%;top:0;z-index:1031}.preloader .st0{fill:#FCFCFC}.preloader .st1{fill:none;stroke:#FCFCFC;stroke-miterlimit:10;stroke-width:1.1}</style>
  <?php endif; ?>

  <?php boxmoe_festival_lantern(); ?>
  <header class="boxmoe_header">
      <nav class="navbar navbar-expand-lg  w-100">
        <div class="container d-flex justify-content-between align-items-center">
          <button class="navbar-toggler offcanvas-nav-btn" type="button">
            <span class="navbar-toggler-bar"></span>
            <span class="navbar-toggler-bar"></span>
            <span class="navbar-toggler-bar"></span>
          </button>
          <a class="navbar-brand mx-auto" href="<?php echo home_url(); ?>">
            <?php boxmoe_logo(); ?></a>
          <div class="d-flex d-lg-none align-items-center">
            <form class="mobile-search-form" role="search" method="get" action="<?php echo home_url( '/' ) ?>"  >
              <input type="search" class="mobile-search-input" placeholder="搜索..." aria-label="Search" name="s" value="<?php echo get_search_query(); ?>">
              <button type="submit" class="mobile-search-btn">
                <i class="fa fa-search"></i>
              </button>
            </form>
            <button class="mobile-user-btn ms-2" type="button">
              <i class="fa fa-user"></i>
            </button>
            <?php if(is_user_logged_in() && get_boxmoe('boxmoe_sign_in_link_switch')): ?>
            <div class="mobile-user-panel">
              <div class="user-panel-content">
                <div class="mobile-user-wrapper">
                  <div class="mobile-logged-menu">
                    <a href="<?php echo boxmoe_user_center_link_page(); ?>" class="mobile-menu-item">
                      <i class="fa fa-user-circle"></i>
                      <span>会员中心</span></a>
                      <?php if(current_user_can('administrator')): ?>
                    <a href="<?php echo admin_url(); ?>" class="mobile-menu-item">
                      <i class="fa fa-cog"></i>
                      <span>后台管理</span></a>
                      <?php endif; ?>
                    <a href="<?php echo wp_logout_url(home_url()); ?>" class="mobile-menu-item">
                      <i class="fa fa-sign-out"></i>
                      <span>注销登录</span></a>
                  </div>
                </div>
              </div>
            </div>
            <?php endif; ?>
            <?php if(!is_user_logged_in() && get_boxmoe('boxmoe_sign_in_link_switch')): ?>
            <div class="mobile-user-panel">
              <div class="user-panel-content">
                <div class="mobile-user-wrapper">
                  <div class="mobile-logged-menu">
                  <div class="user-wrapper d-lg-flex">
                <div class="user-login-wrap">
                <a href="<?php echo boxmoe_sign_in_link_page(); ?>" class="user-login">
                <span class="login-text">登录</span></a>
                </div>
                <span class="divider">or</span>
                <div class="user-reg-wrap">
                <a href="<?php echo boxmoe_sign_up_link_page(); ?>" class="user-reg">
                <span class="reg-text">注册</span></a></div>
                <img src="<?php echo boxmoe_theme_url(); ?>/assets/images/up-new-iocn.png" class="new-tag" alt="up-new-iocn">
                </div>
                  </div>
                </div>
              </div>
            </div>
            <?php endif; ?>
          </div>
          <div class="offcanvas offcanvas-start offcanvas-nav width">
            <div class="offcanvas-header">
              <a href="<?php echo home_url(); ?>" class="text-inverse">
                <?php boxmoe_logo(); ?></a>
              <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <?php if(is_user_logged_in() && get_boxmoe('boxmoe_sign_in_link_switch')): ?>
            <div class="mobile-logged-user-wrapper d-block d-lg-none">
              <a href="<?php echo boxmoe_user_center_link_page(); ?>" class="user-info-wrap d-flex align-items-center">
                <div class="user-avatar">
                  <img src="<?php echo boxmoe_lazy_load_images(); ?>" data-src="<?php echo boxmoe_get_avatar_url(get_current_user_id(), 100); ?>" alt="avatar" class="img-fluid rounded-3 lazy">
                </div>
                <div class="user-info">
                  <div class="user-name"><?php echo get_the_author_meta('display_name', get_current_user_id()); ?></div>
                  <div class="user-email"><?php echo get_the_author_meta('user_email', get_current_user_id()); ?></div>
                </div>
              </a>
              </div>
              <?php endif; ?>
              <div class="lighting d-lg-none ">
            <ul>
              <li data-bs-theme-value="light" aria-pressed="false" class="active">Light</li>
              <li data-bs-theme-value="dark" aria-pressed="false">Dark</li>
              <li data-bs-theme-value="auto" aria-pressed="true">Auto</li>
            </ul>
          </div>
            <div class="offcanvas-body pt-0 align-items-center">
             <?php boxmoe_nav_menu();?>
              <div class="nav-right-section d-flex align-items-center">
                <div class="search-box">
                  <form class="search-form" role="search" method="get" action="<?php echo home_url( '/' ) ?>">
                    <input type="search" class="search-input" placeholder="搜索..." aria-label="Search" name="s" value="<?php echo get_search_query(); ?>">
                    <button type="submit" class="search-btn">
                      <i class="fa fa-search"></i>
                    </button>
                  </form>
                </div>
                <div class="dropdown">
                <button
                    class="float-btn bd-theme"
                    type="button"
                    aria-expanded="false"
                    data-bs-toggle="dropdown"
                    aria-label="Toggle theme (auto)">
                    <i class="fa fa-adjust"></i>
                    <span class="visually-hidden bs-theme-text">主题颜色切换</span>
                </button>
                <ul class="bs-theme dropdown-menu dropdown-menu-end " aria-labelledby="bs-theme-text">
                    <li>
                        <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light" aria-pressed="false">
                            <i class="fa fa-sun-o"></i>
                            <span class="ms-2">Light</span>
                        </button>
                    </li>
                    <li>
                        <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark" aria-pressed="false">
                            <i class="fa fa-moon-o"></i>
                            <span class="ms-2">Dark</span>
                        </button>
                    </li>
                    <li>
                        <button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="auto" aria-pressed="true">
                            <i class="fa fa-adjust"></i>
                            <span class="ms-2">Auto</span>
                        </button>
                    </li>
                </ul>
            </div>
                <?php if(!is_user_logged_in() && get_boxmoe('boxmoe_sign_in_link_switch')): ?>
                <div class="user-wrapper d-none d-lg-flex">
                <div class="user-login-wrap">
                <a href="<?php echo boxmoe_sign_in_link_page(); ?>" class="user-login">
                <span class="login-text">登录</span></a>
                </div>
                <span class="divider">or</span>
                <div class="user-reg-wrap">
                <a href="<?php echo boxmoe_sign_up_link_page(); ?>" class="user-reg">
                <span class="reg-text">注册</span></a></div>
                <img src="<?php echo boxmoe_theme_url(); ?>/assets/images/up-new-iocn.png" class="new-tag" alt="up-new-iocn">
                </div>
                <?php endif; ?>
                 <?php if(is_user_logged_in() && get_boxmoe('boxmoe_sign_in_link_switch')):  ?>
                <div class="logged-user-wrapper d-none d-lg-flex">
                  <div class="user-info-wrap d-flex align-items-center dropdown">
                    <a href="<?php echo boxmoe_user_center_link_page(); ?>" class="dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown" aria-expanded="false">
                      <div class="user-avatar">
                      <img src="<?php echo boxmoe_lazy_load_images(); ?>" data-src="<?php echo boxmoe_get_avatar_url(get_current_user_id(), 100); ?>" alt="avatar" class="img-fluid rounded-3 lazy">
                    </div>
                      <div class="user-info">
                        <div class="user-name"><?php echo get_the_author_meta('display_name', get_current_user_id()); ?></div>
                        <div class="user-email"><?php echo get_the_author_meta('user_email', get_current_user_id()); ?></div>
                    </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                      <li>
                        <a class="dropdown-item" href="<?php echo boxmoe_user_center_link_page(); ?>">
                          <i class="fa fa-user-circle"></i>会员中心</a>
                      </li>
                      <?php if(current_user_can('administrator')): ?>
                      <li>
                        <a class="dropdown-item" target="_blank" href="<?php echo admin_url(); ?>">
                          <i class="fa fa-cog"></i>后台管理</a>
                      </li>
                      <?php endif; ?>
                      <li>
                        <a class="dropdown-item" href="<?php echo wp_logout_url(home_url()); ?>">
                          <i class="fa fa-sign-out"></i>注销登录</a>
                      </li>

                    </ul>
                  </div>
                </div>
                <?php endif; ?>
                </div>
            </div>
          </div>
        </div>
      </nav>
    </header>
    <section class="boxmoe_header_banner">
      <div class="boxmoe_header_banner_img">
        <img src="<?php  boxmoe_banner_image(); ?>" alt="boxmoe_header_banner_img">
        <div class="site-main">
          <h2 class="text-gradient"><?php echo boxmoe_banner_welcome(); ?></h2>
          <?php echo boxmoe_banner_hitokoto(); ?>
        </div>
      </div>
      <div class="boxmoe_header_banner_waves">
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
    <section class="boxmoe-container container">
      <div class="breadcrumb-head">
        <span>
          <i class="fa fa-home"></i>
          <?php 
          if(is_home()) {
              echo 'HOME';
          } elseif(is_category()) {
              echo 'CATEGORY';
          } elseif(is_tag()) {
              echo 'TAG';
          } elseif(is_search()) {
              echo 'SEARCH';
          } elseif(is_404()) {
              echo '404';
          } elseif(is_author()) {
              echo 'AUTHOR';
          } elseif(is_date()) {
              echo 'DATE';
          } elseif(is_archive()) {
              echo 'ARCHIVE';
          } elseif(is_single()){
              echo 'POST';
          } elseif(is_page()){
              $template_names = array(
                  'page/p-links.php' => 'MY friend',
                  'page/p-user_center.php' => 'user center',
              );
              $template = get_page_template_slug();
              if($template && isset($template_names[$template])) {
                  echo $template_names[$template];
              } else {
                  echo 'PAGE';
              }
          } ?>
        </span>
      </div>
      <div class="row">