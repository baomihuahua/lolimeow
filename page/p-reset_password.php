<?php
/**
 * Template Name: 重置密码
 * @link https://www.boxmoe.com
 * @package lolimeow
 */
//boxmoe.com===安全设置=阻止直接访问主题文件
if(!defined('ABSPATH')){echo'Look your sister';exit;}
//如果用户已经登陆那么跳转到首页
if (is_user_logged_in()){
    wp_safe_redirect( get_option('home') );
    exit;
 }
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
      <div class="position-relative h-100 login_register_page">
         <div class="container d-flex flex-wrap justify-content-center vh-100 align-items-center w-lg-50 position-lg-absolute">
         <div class="row justify-content-center">
               <div class="w-100 align-self-end col-12">
                  <div class="text-center mb-7">
                     <a href="<?php echo home_url(); ?>">
                     <?php boxmoe_logo(); ?></a>
                     <h1 class="mb-1">重置密码</h1>
                     <p class="mb-0">请输入您的邮箱，我们将发送重置密码的链接。</p>
                  </div>
                  <form class="needs-validation mb-5" id="resetPasswordForm" novalidate>
                     <?php wp_nonce_field('reset_password_action', 'reset_password_nonce'); ?>
                     <div class="mb-3">
                        <label for="resetEmailInput" class="form-label">
                           邮箱
                           <span class="text-danger">*</span>
                        </label>
                        <input type="email" class="form-control" id="resetEmailInput" name="user_email" placeholder="请输入您的邮箱" required>
                        <div class="invalid-feedback">请输入有效的邮箱地址。</div>
                     </div>
                     <div id="signup-message"></div>
                     <div class="d-grid">
                        <button class="btn btn-primary" type="submit" id="resetSubmitBtn">发送重置链接</button>
                     </div>
                  </form>
                  <div class="text-center">
                     <a href="<?php echo boxmoe_sign_in_link_page(); ?>" class="icon-link icon-link-hover">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                           <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"></path>
                        </svg>
                        <span>返回登录</span>
                     </a>
                  </div>
               </div>
            </div>
         </div>
         <div class="position-fixed top-0 end-0 w-50 h-100 d-none d-lg-block vh-100" style="background-image: url(<?php echo get_boxmoe('boxmoe_user_login_bg')? get_boxmoe('boxmoe_user_login_bg') :'https://api.boxmoe.com/random.php'; ?>); background-position: center; background-repeat: no-repeat; background-size: cover;transform: skewX(-10deg);right:-8rem!important;">
         </div>
      </div>

      <div class="position-absolute start-0 bottom-0 m-4">
         <div class="dropdown">
            <button
                    class="float-btn bd-theme btn btn-light btn-icon rounded-circle d-flex align-items-center"
                    type="button"
                    aria-expanded="false"
                    data-bs-toggle="dropdown"
                    aria-label="Toggle theme (auto)">
                    <i class="fa fa-adjust"></i>
                    <span class="visually-hidden bs-theme-text">主题颜色切换</span>
                </button>
                <ul class="bs-theme dropdown-menu dropdown-menu-end shadow" aria-labelledby="bs-theme-text">
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
      </div>
   </main>
   <?php 
    ob_start();
    wp_footer();
    $wp_footer_output = ob_get_clean();
    echo preg_replace('/\n/', "\n    ", trim($wp_footer_output))."\n    ";
    ?>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('resetPasswordForm');
    const submitBtn = document.getElementById('resetSubmitBtn');
    const emailInput = document.getElementById('resetEmailInput');
    const messageDiv = document.getElementById('signup-message');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        messageDiv.innerHTML = '';
        
        if (!emailInput.value) {
            emailInput.classList.add('is-invalid');
            return false;
        }
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> 发送中...';
        
        fetch(ajax_object.ajaxurl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                action: 'reset_password_action',
                user_email: emailInput.value,
                nonce: document.getElementById('reset_password_nonce').value
            })
        })
        .then(response => response.json())
        .then(response => {
            if (response.success) {
                messageDiv.innerHTML = '<div class="alert alert-success">' + response.data.message + '</div>';
                form.reset();
            } else {
                submitBtn.disabled = false;
                submitBtn.textContent = '发送重置链接';
                messageDiv.innerHTML = '<div class="alert alert-danger">' + response.data.message + '</div>';
            }
        })
        .catch(() => {
            submitBtn.disabled = false;
            submitBtn.textContent = '发送重置链接';
            messageDiv.innerHTML = '<div class="alert alert-danger">发送请求失败，请稍后重试</div>';
        });
    });
});
    </script>
</body></html>

