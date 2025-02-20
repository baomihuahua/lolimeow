<?php
/**
 * @link https://www.boxmoe.com
 * @package lolimeow
 */
//boxmoe.com===安全设置=阻止直接访问主题文件
if(!defined('ABSPATH')){echo'Look your sister';exit;}?>
        </div>
        </section>
<footer class="mt-7">
    <hr class="horizontal dark">
      <div class="container pb-4">
        <div class="row align-items-center">
        <?php echo boxmoe_load_assets_footer(); ?>
      </div>
    </footer>
    <div class="body-background"></div>
    <div class="floating-action-menu">
      <nav class="floating-menu-items">
        <ul>
          <?php if(get_boxmoe('boxmoe_blog_layout')=='two'): ?>
          <li class="d-lg-none">
            <button class="float-btn" title="打开侧栏" data-bs-toggle="offcanvas" href="#blog-sidebar" aria-controls="blog-sidebar">
              <i class="fa fa-outdent"></i>
            </button>
          </li>
          <?php endif; ?>
          <?php if(get_boxmoe('boxmoe_lolijump_switch')): ?>
          <li>
            <a id="lolijump" href="#" title="返回顶部">
              <img src="<?php echo boxmoe_theme_url(); ?>/assets/images/top/<?php echo get_boxmoe('boxmoe_lolijump_img'); ?>.gif" alt="返回顶部"></a>
          </li>
          <?php endif; ?>
        </ul>
      </nav>
    </div>
    <?php 
    ob_start();
    wp_footer();
    $wp_footer_output = ob_get_clean();
    echo preg_replace('/\n/', "\n    ", trim($wp_footer_output))."\n    ";
    ?>
    <?php echo get_boxmoe('boxmoe_diy_code_footer'); ?>
  </body>
</html>
<style>
.toast {
  transition: transform .3s ease-out !important;
    transform: translateX(100%);
}

.toast.fade.show {
    transform: translateX(0);
}
</style>
