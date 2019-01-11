<?php
/**
 * Template Name: 前台登录
 *  防止刷新页面重复提交数据
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
	  
    if ( isset( $_GET['r'] ) ) {
      $redirect_to = $_GET['r'];
      // Redirect to https if user wants ssl
      if ( $secure_cookie && false !== strpos($redirect_to, 'wp-admin') )
        $redirect_to = preg_replace('|^http://|', 'https://', $redirect_to);
    }
    else {
      $redirect_to = admin_url();
    }
	
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
if (!is_user_logged_in()) { get_header();?>
<section class="section-profile-cover section-blog-cover section-shaped my-0 " <?php if( meowdata('banneron') ) {echo md_banner();} ?>>
      <div class="shape shape-style-1 shape-primary alpha-4">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
      </div>
      <div class="separator separator-bottom separator-skew" >
        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none">
          <polygon class="fill-white" points="2560 0 2560 100 0 100"></polygon>
        </svg>
      </div>
    </section> 
<main class="meowblog">
<div class="main-container">
      <div class="container pt-lg-md">
        <div class="row justify-content-center">
          <div class="col-lg-5">
            <div class="card bg-secondary shadow border-0">
              <div class="card-header bg-white pb-5">
                <div class="btn-wrapper text-center mt-3">
<?php echo md_logo();?>
<?php if(!empty($error)) {
 echo '<div class="text-muted text-center mt-3"><span class="badge badge-pill badge-danger text-uppercase">'.$error.'</span></div>';
}?>
                </div>
              </div>
              <div class="card-body px-lg-5 py-lg-5">
                <div class="text-center text-muted mb-4">
				<H3>会员登录</H3>
                  <small>该页面已经过安全加密</small>
                </div>
                <form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>" novalidate="novalidate">
                  <div class="form-group mb-3">
                    <div class="input-group input-group-alternative">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-envelope-o"></i></span>
                      </div>
					  <input type="text" name="log" id="log" class="form-control" value="<?php if(!empty($user_name)) echo $user_name; ?>" placeholder="Email或用户名"  />
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group input-group-alternative">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-key"></i></span>
                      </div>
					  <input id="pwd" class="form-control" type="password" value="" name="pwd"  placeholder="Password"/>
                    </div>
                  </div>
                  <div class="custom-control custom-control-alternative custom-checkbox"> 
                    <input class="custom-control-input" name="rememberme" type="checkbox" id="rememberme" value="1" <?php checked( $rememberme ); ?>>
                    <label class="custom-control-label" for="rememberme">
                      <span>记住账户</span>
                    </label>
                  </div>
                  <div class="text-center"><input type="hidden" name="md_token" value="<?php echo $token; ?>" />
				  <input type="hidden" name="redirect_to" value="<?php if(isset($_GET['r'])) echo $_GET['r']; ?>" />
                    <button type="submit" class="btn btn-primary my-4">登录账户</button>
                  </div>
                </form>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-6">
                <a href="<?php echo site_url('/') ?>wp-login.php?action=lostpassword" class="btn btn-1 btn-sm btn-outline-warning">
                  <small>忘记密码?</small>
                </a>
              </div>
              <div class="col-6 text-right">
                <a href="<?php echo site_url('/') ?>reg" class="btn btn-1 btn-sm btn-outline-warning">
                  <small>创建新帐户</small>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>

</div>
</main>	

<?php get_footer(); } else {
echo "<script type='text/javascript'>window.location='".meowdata('regto')."'</script>";
} ?>
