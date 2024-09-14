<?php
/**
 * Template Name: Boxmoe登录页
 * @link https://www.boxmoe.com
 * @package lolimeow
 */
if(!isset($_SESSION))
session_start(); 
$redirect_to=''; 
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
    if ( !$secure_cookie && is_ssl() && !force_ssl_admin() && ( 0 !== strpos($redirect_to, 'https') ) && ( 0 === strpos($redirect_to, 'http') ) )
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
	  <?php wp_head(); ?>
</head>
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
      <section id="boxmoe_theme_header" class="fadein-top position-sticky" style="z-index: 3 !important;">
        <nav class="navbar navbar-expand-lg navbar-bg-box blur blur-rounded userheader my-3 py-2">
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

                </ul>
              </div>
            </div>
          </div>
        </nav>
      </section>
<section>  
<link rel='stylesheet' href="https://lf9-cdn-tos.bytecdntp.com/cdn/expire-1-M/limonte-sweetalert2/11.4.4/sweetalert2.min.css" type='text/css' media='all' />
<script src="https://lf9-cdn-tos.bytecdntp.com/cdn/expire-1-M/limonte-sweetalert2/11.4.4/sweetalert2.min.js"></script>
<div class="page-header min-vh-75">
<div class="container">
        <div class="row">
        <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
                     <div class="text-center mb-7">
                        <h1 class="mb-1 text-gradient">欢迎回来</h1>
                        <p class="mb-0">
                        如果你还没有账户
                           <a href="<?php get_reg_url(); ?>" class="text-primary  text-gradient">点击注册</a>
                        </p>
                     </div>
                     <form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>" class="needs-validation mb-6">
                        <div class="mb-3">
                           <label for="log" class="form-label">电子邮件/用户名<span class="text-danger">*</span></label>
                           <input type="text"  name="log" id="log"  class="form-control" required="">
                        </div>
                        <div class="mb-3">
                           <label for="pwd" class="form-label">密码</label>
                              <input type="password" name="pwd" id="pwd" class="form-control" required="">
                        </div>
                        <div class="mb-3">
                           <div class="d-flex align-items-center justify-content-between">
                              <div class="form-check">
                                 <input class="form-check-input" type="checkbox"  id="rememberme" value="1" <?php checked( $rememberme ); ?>>
                                 <label class="form-check-label" for="rememberme">记住账号</label>
                              </div>

                              <div><a href="<?php get_reset_url(); ?>" class="text-primary  text-gradient">找回密码</a></div>
                           </div>
                        </div>

                        <div class="d-grid">
                        <input type="hidden" name="md_token" value="<?php echo $token; ?>" />
                        <input type="hidden" name="redirect_to" value="<?php if(!empty($redirect_to)){echo $redirect_to;}else{echo get_user_url();} ?>" />
                           <button class="btn btn-primary" type="submit">登录账号</button>
                        </div>
                     </form>
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

	  