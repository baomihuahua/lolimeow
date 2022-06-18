<?php
/**
 * Template Name: Boxmoe登录页
 * @link https://www.boxmoe.com
 * @package lolimeow
 */
if(!isset($_SESSION))
session_start();  
if( isset($_POST['md_token']) && ($_POST['md_token'] == $_SESSION['md_token'])) {
  $error = '';
  $secure_cookie = false;
  $user_name = sanitize_user( $_POST['log'] );
  $user_password = $_POST['pwd'];
  if ( empty($user_name) || ! validate_username( $user_name ) ) {
    $error .= '<strong>错误</strong>：请输入有效的用户名。<br />';
    $user_name = '';
  }  
  if( empty($user_password) ) {
    $error .= '<strong>错误</strong>：请输入密码。<br />';
  } 
  if($error == '') {
    // If the user wants ssl but the session is not ssl, force a secure cookie.
    if ( !empty($user_name) && !force_ssl_admin() ) {
      if ( $user = get_user_by('login', $user_name) ) {
        if ( get_user_option('use_ssl', $user->ID) ) {
          $secure_cookie = true;
          force_ssl_admin(true);
        }
      }
    }	  
    $redirect_to = ''.site_url().'?page_id='.get_boxmoe('users_page').'';	
    if ( !$secure_cookie && is_ssl() && force_ssl_login() && !force_ssl_admin() && ( 0 !== strpos($redirect_to, 'https') ) && ( 0 === strpos($redirect_to, 'http') ) )
    $secure_cookie = false;	
    $creds = array();
    $creds['user_login'] = $user_name;
    $creds['user_password'] = $user_password;
    $creds['remember'] = !empty( $_POST['rememberme'] );
    $user = wp_signon( $creds, $secure_cookie );
    if ( is_wp_error($user) ) {
      $error .= $user->get_error_message();
    }
    else {
      unset($_SESSION['md_token']);
      wp_safe_redirect($redirect_to);
    }
  }

  unset($_SESSION['md_token']);
}
$rememberme = !empty( $_POST['rememberme'] ); 
$token = md5(uniqid(rand(), true));
$_SESSION['md_token'] = $token;
?>
<?php 
if (!is_user_logged_in()) {?>
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
</head>
  <body class="sign-in-cover">
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
<header class="header-global">	
<div class="container position-sticky z-index-sticky top-0">
    <div class="row">
      <div class="col-12">
        <nav class="navbar navbar-expand-lg  blur blur-rounded top-0  z-index-3 shadow position-absolute my-3 py-2 start-0 end-0 mx-4">
          <div class="container-fluid px-0">
            <a class="navbar-brand font-weight-bold" href="<?php echo home_url(); ?>" title="boxmoe">
            <?php echo boxmoe_logo();?></a>
            <button class="navbar-toggler shadow-none ms-md-2" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="切换导航">
              <span class="navbar-toggler-icon mt-2">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </span>
            </button>
            <div class="collapse navbar-collapse w-100 pt-3 pb-2 py-lg-0" id="navigation">
              <ul class="navbar-nav navbar-nav-hover mx-auto">
             <?php boxmoe_nav_menu() ;?>
			 </ul>
            </div>
          </div>
        </nav>
      </div>
    </div>
  </div>
</header>
<section>  
<link rel='stylesheet' href="https://lf9-cdn-tos.bytecdntp.com/cdn/expire-1-M/limonte-sweetalert2/11.4.4/sweetalert2.min.css" type='text/css' media='all' />
<script src="https://lf9-cdn-tos.bytecdntp.com/cdn/expire-1-M/limonte-sweetalert2/11.4.4/sweetalert2.min.js"></script>
<div class="page-header min-vh-75">
<div class="container">
        <div class="row">
          <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
            <div class="card card-plain mt-8">
              <div class="card-header pb-0 text-left">
                <h3 class="font-weight-bolder text-info text-gradient">欢迎回来</h3>
                <p class="mb-0">输入您的电子邮件或用户名和密码登录</p>
              </div>
              <div class="card-body">
                <form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>" >
                  <label>电子邮件/用户名</label>
                  <div class="mb-3">
                    <input type="text" name="log" id="log" value="<?php if(!empty($user_name)) echo $user_name; ?>" class="form-control" placeholder="Email/用户名" aria-label="Email/用户名" required>
                  </div>
                  <label>密码</label>
                  <div class="mb-3">
                    <input type="password" name="pwd" id="pwd" placeholder="Password" value="" class="form-control" placeholder="密码" aria-label="密码" required>
                  </div>
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="rememberme" value="1" <?php checked( $rememberme ); ?>>
                    <label class="form-check-label" for="rememberMe">记住账号</label>
                  </div>
                  <div class="text-center">
				    <input type="hidden" name="md_token" value="<?php echo $token; ?>" />
				    <input type="hidden" name="redirect_to" value="<?php echo $redirect_to; ?>" />
                    <button type="submit" id="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">登录</button>
                  </div>
                </form>
              </div>
              <div class="card-footer text-center pt-0 px-lg-2 px-1">
                <p class="mb-4 text-sm mx-auto">
                  没有账户？
                  <a href="<?php get_reg_url(); ?>" class="text-info text-gradient font-weight-bold">注册</a>  |  <a href="<?php get_reset_url(); ?>" class="text-info text-gradient font-weight-bold">忘记密码？</a>
                </p>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
              <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6" style="background-image:url('<?php echo randpic();?>')"></div>
            </div>
          </div>
        </div>
      </div>
	  </div>
<?php if(!empty($error)) {echo '<script type="text/javascript">Swal.fire("Oops...","'.$error.'", "error");</script>';}?>	  	
<?php get_footer(); } else {
echo "<script type='text/javascript'>window.location='".site_url()."?page_id=".get_boxmoe('users_page')."'</script>";
} ?>

	  