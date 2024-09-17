<?php
/*
Template Name: Boxmoe注册页
 * @link https://www.boxmoe.com
 * @package lolimeow
*/
	
//如果用户已经登陆那么跳转到首页
if (is_user_logged_in()){
  wp_safe_redirect( get_option('home') );
  exit;
}
	
//获取注册页面提交时候的表单数据

if( !empty($_POST['csyor_reg']) ) { 
  $error = '';
  $redirect_to = sanitize_user( $_REQUEST['redirect_to'] );
  $sanitized_user_login = sanitize_user( $_POST['user_login'] );
  //$user_website = sanitize_user( $_POST['website'] );
  //$user_nickname = sanitize_user( $_POST['nickname'] );
  $user_email = apply_filters( 'user_registration_email', $_POST['user_email'] );
  $comment_aaa      	  = ( isset($_POST['aaa']) ) ? trim($_POST['aaa']) : '0';
  $comment_bbb          = ( isset($_POST['bbb']) ) ? trim($_POST['bbb']) : '0';
  $comment_subab        = ( isset($_POST['subab']) ) ? trim($_POST['subab']) : '0';
if (get_boxmoe('sign_zhcn')){
  // 验证邮箱
  if ( $user_email == '' ) {
    $error .= '错误：请填写电子邮件地址。';
  } elseif ( ! is_email( $user_email ) ) {
    $error .= '错误：电子邮件地址不正确。';
    $user_email = '';
  } elseif ( email_exists( $user_email ) ) {
    $error .= '错误：该电子邮件地址已经被注册，请换一个。';
  }
	
  // 验证用户名
  elseif ( $sanitized_user_login == '' ) {
    $error .= '错误：请输入登陆账号。';
  }elseif ( username_exists( $sanitized_user_login ) ) {
    $error .= '错误：该用户名已被注册，请再选择一个。';
  }
	
  //验证密码
  elseif(strlen($_POST['user_pass']) < 6){
    $error .= '错误：密码长度至少6位。';
  }elseif($_POST['user_pass'] != $_POST['user_pass2']){
    $error .= '错误：两次输入的密码必须一致。';
  }elseif(((int)$comment_subab)!=(((int)$comment_aaa)+((int)$comment_bbb))){
    $error .= '错误：请输入正确的计算结果验证码。';	
  }
}else{
  // 验证邮箱
  if ( $user_email == '' ) {
    $error .= '错误：请填写电子邮件地址。';
  } elseif ( ! is_email( $user_email ) ) {
    $error .= '错误：电子邮件地址不正确。';
    $user_email = '';
  } elseif ( email_exists( $user_email ) ) {
    $error .= '错误：该电子邮件地址已经被注册，请换一个。';
  }
	
// 验证用户名
elseif ( $sanitized_user_login == '' ) {
    $error .= '错误：请输入登录账号。';
} elseif ( !preg_match("/^[\p{L}\p{N}_]{4,16}$/u", $sanitized_user_login) ) {
    $error .= '错误：登录账号只能包含中文、字母、数字、下划线，长度4到16位。';
    $sanitized_user_login = '';
} elseif ( username_exists( $sanitized_user_login ) ) {
    $error .= '错误：该用户名已被注册，请再选择一个。';
}
	
  //验证密码
  elseif(strlen($_POST['user_pass']) < 6){
    $error .= '错误：密码长度至少6位。';
  }elseif($_POST['user_pass'] != $_POST['user_pass2']){
    $error .= '错误：两次输入的密码必须一致。';
  }elseif(((int)$comment_subab)!=(((int)$comment_aaa)+((int)$comment_bbb))){
    $error .= '错误：请输入正确的计算结果验证码。';	
  }
}	
  if($error == '') {
    //验证全部通过进入注册信息添加
    $display_name = empty($user_nickname)?$sanitized_user_login:$user_nickname;
    $user_pass = $_POST['user_pass'];
    $user_id = wp_insert_user( array ( 
      'user_login' => $sanitized_user_login, 
      'user_pass' => $user_pass , 
      'nickname' => $user_nickname,
      'display_name' => $display_name, 
      'user_email' => $user_email, 
      'user_url' => $user_website) ) ;
		
    //意外情况判断，添加失败
    if ( ! $user_id ) {
      $error .= sprintf( '错误：无法完成您的注册请求... 请联系<a href=\"mailto:%s\">管理员</a>！</p>', get_option( 'admin_email' ) );
    }else if (!is_user_logged_in()) {
      //注册成功发送邮件通知用户
      $to = $user_email;
      $subject = '您在 [' . get_option("blogname") . '] 的注册已经成功';
      $message = '<div style="background-color:#eef2fa; border:1px solid #d8e3e8; color:#111; padding:0 15px; -moz-border-radius:5px; -webkit-border-radius:5px; -khtml-border-radius:5px; border-radius:5px;">
        <p>' . $user_nickname . ', 您好!</p>
        <p>感谢您在 [' . get_option("blogname") . '] 注册用户~</p>
        <p>你的注册信息如下:<br />
        账号：'. $sanitized_user_login . '<br />
        邮箱：'. $user_email . '<br />
        密码：'. $_POST['user_pass'] . '<br />
        </p>
        <p>欢迎光临 <a href="'.get_option('home').'">' . get_option('blogname') . '</a>。</p>
	<p>(此郵件由系統自動發出, 請勿回覆.)</p>
	</div>';
      $from = "From: \"" . get_option('blogname') . "\" <$wp_email>";
      $headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
      wp_mail( $to, $subject, $message, $headers );
	  if(get_boxmoe('bot_api_reguser')){
		boxmoe_msg_reguser($sanitized_user_login,$user_email);		  
		}  			
      $user = get_user_by('login', $sanitized_user_login);
      $user_id = $user->ID;
			
      // 自动登录
      wp_set_current_user($user_id, $user_login);
      wp_set_auth_cookie($user_id);
      do_action('wp_login', $user_login);			
      wp_safe_redirect( $redirect_to );
    }
  }
}	
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
<div class="page-header min-vh-75">
      <div class="container">
        <div class="row">
          <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
          <div class="w-100 align-self-end col-12 mt-7">
                     <div class="text-center mb-3 mt-5">
                        <h1 class="mb-1 text-gradient">创建账户</h1>
                        <p class="mb-0">
                           如果你已经创建
                           <a href="<?php get_login_url(); ?>" class="text-primary text-gradient">点击登录</a>
                        </p>
                     </div>
                     <form class="needs-validation mb-3" method="post" action="#">
                      <div class="mb-3">
                           <label for="user_login" class="form-label">
                              用户名
                              <span class="text-danger">*</span>
                           </label>
                           <input type="text" class="form-control" name="user_login" id="user_login" tabIndex="2" value="<?php if(!empty($sanitized_user_login)) echo $sanitized_user_login; ?>" required="">
                        </div>
                        <div class="mb-3">
                           <label for="user_email" class="form-label">
                              Email
                              <span class="text-danger">*</span>
                           </label>
                           <input type="email" class="form-control" name="user_email" id="user_email" tabIndex="1" value="<?php if(!empty($user_email)) echo $user_email; ?>" required="">
                        </div>
                        <div class="mb-3">
                           <label for="user_pwd1" class="form-label">密码</label>
                              <input type="password" class="form-control fakePassword" tabindex="3" id="user_pwd1" name="user_pass" required="">
                        </div>
                        <div class="mb-3">
                           <label for="user_pwd1" class="form-label">确认密码</label>
                              <input type="password" class="form-control fakePassword" tabindex="4" id="user_pwd2" name="user_pass2" required="">
                        </div>
                        <div class="mb-3">
                           <label for="subab" class="form-label">验证码:<?php $aaa=rand(1,9); $bbb=rand(1,9); ?><?php echo $aaa; ?>+<?php echo $bbb; ?>=？</label>
                              <input name="aaa" value="<?php echo $aaa; ?>" type="hidden" />
				                      <input name="bbb" value="<?php echo $bbb; ?>" type="hidden" />
                              <input type="text" class="form-control fakePassword" name="subab" id="subab" tabindex="5" required="">
                        </div>
                        <div class="d-grid">
                        <input type="hidden" name="csyor_reg" value="ok" />
                        <input type="hidden" name="redirect_to" value="<?php get_user_url() ?>"/>
                           <button class="btn btn-primary" name="wp-submit"  id="wp-submit"  tabindex="6" type="submit">创建账号</button>
                        </div>
                     </form>

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

<link rel='stylesheet' href="https://lf9-cdn-tos.bytecdntp.com/cdn/expire-1-M/limonte-sweetalert2/11.4.4/sweetalert2.min.css" type='text/css' media='all' />
<script src="https://lf9-cdn-tos.bytecdntp.com/cdn/expire-1-M/limonte-sweetalert2/11.4.4/sweetalert2.min.js"></script>	  
<?php if(!empty($error)) {echo '<script type="text/javascript">Swal.fire("Oops...","'.$error.'", "error");</script>';}?>	  
<?php } get_footer(); ?>