<?php
/**
 * Template Name: 登录页面
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
                  <div class="text-center mb-3">
                     <a href="<?php echo get_option('home'); ?>"><?php boxmoe_logo(); ?></a>
                     <h2 class="mb-1">欢迎回来</h2>
                     <p class="mb-0">
                        如果你还没有账号可以点击
                        <a href="<?php echo boxmoe_sign_up_link_page(); ?>" class="text-primary">注册</a>
                     </p>
                  </div>
                  <form class="needs-validation mb-6" action="" method="post" id="loginform" novalidate>
                     <div class="mb-3">
                        <label for="username" class="form-label">
                        电子邮件/用户名
                           <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="username" class="form-control" id="username" required>
                        <div class="invalid-feedback">请输入用户名或邮箱。</div>
                     </div>
                     <div class="mb-3">
                        <label for="password" class="form-label">密码<span class="text-danger">*</span></label>
                        <div class="password-field position-relative">
                           <input type="password" name="password" class="form-control fakePassword" id="password" required>
                           <span><i class="bi bi-eye-slash passwordToggler"></i></span>
                           <div class="invalid-feedback">请输入密码。</div>
                        </div>
                     </div>

                     <div class="mb-3">
                        <div class="d-flex align-items-center justify-content-between">
                           <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="rememberme" id="rememberme">
                              <label class="form-check-label" for="rememberme">记住账号</label>
                           </div>

                           <div><a href="<?php echo boxmoe_reset_password_link_page(); ?>" class="text-primary">忘记密码</a></div>
                        </div>
                     </div>

                     <?php wp_nonce_field('user_login', 'login_nonce'); ?>
                     <div class="d-grid">
                        <button class="btn btn-primary" type="submit" name="login_submit">
                           <span class="spinner-border spinner-border-sm me-2 d-none" role="status"></span>
                           <span class="btn-text">登录</span>
                        </button>
                     </div>
                     <div id="login-message"></div>
                  </form>
                  <div class="text-center mt-7">
                     <div class="small mb-3 mb-lg-0 text-body-tertiary">
                        Copyright © 2025 
                        <span class="text-primary"><a href="<?php echo get_option('home'); ?>"><?php echo get_bloginfo('name'); ?></a></span>
                        | Theme by
                        <span class="text-primary"><a href="https://www.boxmoe.com">Boxmoe</a></span> powered by WordPress
                     </div>
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
    document.getElementById('loginform').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const loginButton = this.querySelector('button[type="submit"]');
        const spinner = loginButton.querySelector('.spinner-border');
        const btnText = loginButton.querySelector('.btn-text');

        loginButton.disabled = true;
        spinner.classList.remove('d-none');
        btnText.textContent = '登录中...';

        const formData = {
            username: document.getElementById('username').value,
            password: document.getElementById('password').value,
            rememberme: document.getElementById('rememberme').checked,
            login_nonce: document.getElementById('login_nonce').value 
        };                         
        fetch(ajax_object.ajaxurl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'action=user_login_action&formData=' + encodeURIComponent(JSON.stringify(formData))
        })
        .then(response => response.json())
        .then(response => {
            if(response.success) {
                document.getElementById('login-message').innerHTML = 
                    '<div class="alert alert-success mt-3">' + response.data.message + '，正在跳转...</div>';
                setTimeout(() => {
                    if (document.referrer) {
                        window.location.href = document.referrer;
                    } else {
                        window.location.href = '/';
                    }
                }, 1000);
            } else {
                loginButton.disabled = false;
                spinner.classList.add('d-none');
                btnText.textContent = '登录';
                
                document.getElementById('login-message').innerHTML = 
                    '<div class="alert alert-danger mt-3">' + response.data.message + '</div>';
            }
        })
        .catch(error => {
            loginButton.disabled = false;
            spinner.classList.add('d-none');
            btnText.textContent = '登录';
            
            document.getElementById('login-message').innerHTML = 
                '<div class="alert alert-danger mt-3">登录请求失败，请稍后重试</div>';
        });
    });
});
    </script>
</body></html>

