
<?php
/**
 * @link https://www.boxmoe.com
 * @package lolimeow
 */
//boxmoe.com===安全设置=阻止直接访问主题文件
if(!defined('ABSPATH')){echo'Look your sister';exit;}
?>
<html <?php language_attributes(); ?>>
    <head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <title><?php echo boxmoe_theme_title(); ?></title>
   <link rel="icon" href="<?php echo boxmoe_favicon(); ?>" type="image/x-icon">
    <?php boxmoe_keywords(); ?>
    <?php boxmoe_description(); ?>
    <?php ob_start();wp_head();$wp_head_output = ob_get_clean();echo preg_replace('/\n/', "\n    ", trim($wp_head_output))."\n    ";?>
</head>

<body>
   <main>

<div class="container d-flex flex-column overflow-hidden">
         <div class="row align-items-center justify-content-center min-vh-100 text-center">
            <div class="col-lg-6 col-12">
               <div class="position-relative mb-7">
                  <div class="scene d-none d-lg-block" data-relative-input="true" style="transform: translate3d(0px, 0px, 0px) rotate(0.0001deg); transform-style: preserve-3d; backface-visibility: hidden; position: relative; pointer-events: none;">
                     <div class="position-absolute top-0" data-depth="0.5" style="transform: translate3d(0px, 0px, 0px); transform-style: preserve-3d; backface-visibility: hidden; position: relative; display: block; left: 0px; top: 0px;">
                        <img src="<?php echo boxmoe_theme_url(); ?>/assets/images/error/stars.svg" alt="">
                     </div>
                  </div>
                  <div class="scene d-none d-lg-block" data-relative-input="true" style="transform: translate3d(0px, 0px, 0px) rotate(0.0001deg); transform-style: preserve-3d; backface-visibility: hidden; position: relative; pointer-events: none;">
                     <div class="position-absolute" data-depth="0.1" style="transform: translate3d(0px, 0px, 0px); transform-style: preserve-3d; backface-visibility: hidden; position: relative; display: block; left: 0px; top: 0px;">
                        <img src="<?php echo boxmoe_theme_url(); ?>/assets/images/error/rocket.svg" alt="">
                     </div>
                  </div>
                  <div class="scene d-none d-lg-block" data-relative-input="true" style="transform: translate3d(0px, 0px, 0px) rotate(0.0001deg); transform-style: preserve-3d; backface-visibility: hidden; position: relative; pointer-events: none;">
                     <div class="position-absolute top-0 start-50 translate-middle" style="margin-top: -80px; margin-left: -80px; transform: translate3d(0px, 0px, 0px); transform-style: preserve-3d; backface-visibility: hidden; position: relative; display: block; left: 0px; top: 0px;" data-depth="0.1">
                        <img src="<?php echo boxmoe_theme_url(); ?>/assets/images/error/globe.svg" alt="">
                     </div>
                  </div>
                  <div class="scene d-none d-lg-block" data-relative-input="true" style="transform: translate3d(0px, 0px, 0px) rotate(0.0001deg); transform-style: preserve-3d; backface-visibility: hidden; position: relative; pointer-events: none;">
                     <div class="position-absolute start-50" data-depth="0.1" style="transform: translate3d(0px, 0px, 0px); transform-style: preserve-3d; backface-visibility: hidden; position: relative; display: block; left: 0px; top: 0px;">
                        <img src="<?php echo boxmoe_theme_url(); ?>/assets/images/error/astronut.svg" alt="" style="top: -110px; position: absolute; bottom: 0">
                     </div>
                  </div>
                  <div class="position-relative z-n1">
                     <img src="<?php echo boxmoe_theme_url(); ?>/assets/images/error/404-number.svg" alt="" class="img-fluid">
                  </div>
                  <div class="scene d-none d-lg-block" data-relative-input="true" style="transform: translate3d(0px, 0px, 0px) rotate(0.0001deg); transform-style: preserve-3d; backface-visibility: hidden; position: relative; pointer-events: none;">
                     <div class="position-absolute start-100 bottom-0" style="transform: translate3d(0px, 0px, 0px); transform-style: preserve-3d; backface-visibility: hidden; position: relative; display: block; left: 0px; top: 0px;" data-depth="0.1">
                        <img src="<?php echo boxmoe_theme_url(); ?>/assets/images/error/planet.svg" alt="">
                     </div>
                  </div>
               </div>

               <h2>页面未找到</h2>
               <p>您要查找的页面不存在。</p>

               <a href="<?php echo home_url(); ?>" class="btn btn-primary">返回首页</a>
            </div>
         </div>
      </div>
      </main>
   <?php 
    ob_start();
    wp_footer();
    $wp_footer_output = ob_get_clean();
    echo preg_replace('/\n/', "\n    ", trim($wp_footer_output))."\n    ";
    ?>
</body></html>