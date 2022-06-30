<?php
/*Template Name: Boxmoe注册页
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
  $user_website = sanitize_user( $_POST['website'] );
  $user_nickname = sanitize_user( $_POST['nickname'] );
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
    $error .= '错误：请输入登陆账号。';
  } elseif ( !preg_match("/^[a-zA-Z0-9_]{4,16}$/",$sanitized_user_login) ) {
    $error .= '错误：登陆账号只能包含字母、数字、下划线，长度4到16位。';
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
      $user = get_userdatabylogin($sanitized_user_login);
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
<div class="page-header min-vh-75">
      <div class="container">
        <div class="row">
          <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
            <div class="card card-plain mt-sm-8 mt-5">
              <div class="card-header pb-0 text-left">
                <h3 class="font-weight-bolder text-primary text-gradient">注册成为会员</h3>
                <p class="mb-0">输入您的用户名/电子邮件和密码进行注册</p>
              </div>
              <div class="card-body pb-3">
                <form name="registerform" method="post" action="#" >
                  <label>*用户名</label>
                  <div class="mb-3">
                    <input type="text" class="form-control" placeholder="用户名"  name="user_login" id="user_login" tabIndex="2" value="<?php if(!empty($sanitized_user_login)) echo $sanitized_user_login; ?>" required>
                  </div>
                  <label>Email</label>
                  <div class="mb-3">
                    <input type="email" class="form-control" placeholder="Email" name="user_email" id="user_email" tabIndex="1" value="<?php if(!empty($user_email)) echo $user_email; ?>" required>
                  </div>
                  <label>密码</label>
                  <div class="mb-3">
                    <input type="password" class="form-control" placeholder="输入密码" tabindex="3" id="user_pwd1" name="user_pass"  required>
                  </div>
                  <label>确认密码</label>
                  <div class="mb-3">
                    <input type="password" class="form-control" placeholder="确认密码" tabindex="4" id="user_pwd2" name="user_pass2"  required>
                  </div>
                  <label>验证码：<?php $aaa=rand(1,9); $bbb=rand(1,9); ?><?php echo $aaa; ?>+<?php echo $bbb; ?>=？</label>
                  <div class="mb-3">
				  <input name="aaa" value="<?php echo $aaa; ?>" type="hidden" />
				  <input name="bbb" value="<?php echo $bbb; ?>" type="hidden" />
                  <input class="form-control" placeholder="验证码" name="subab" id="subab" tabindex="5" required type="text">
                  </div>				  
                  <div class="text-center">
				    <input type="hidden" name="csyor_reg" value="ok" />
				    <input type="hidden" name="redirect_to" value="<?php get_user_url() ?>"/>
                    <button iname="wp-submit"  id="wp-submit"  tabindex="6" type="submit" class="btn bg-gradient-primary w-100 mt-4 mb-0">注册</button>
                  </div>
                </form>
              </div>
              <div class="card-footer text-center pt-0 px-sm-4 px-1">
                <p class="mb-4 mx-auto">
                  已经有账户？
                  <a href="<?php get_login_url(); ?>" class="text-primary text-gradient font-weight-bold">登入</a>
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

<link rel='stylesheet' href="https://lf9-cdn-tos.bytecdntp.com/cdn/expire-1-M/limonte-sweetalert2/11.4.4/sweetalert2.min.css" type='text/css' media='all' />
<script src="https://lf9-cdn-tos.bytecdntp.com/cdn/expire-1-M/limonte-sweetalert2/11.4.4/sweetalert2.min.js"></script>	  
<?php if(!empty($error)) {echo '<script type="text/javascript">Swal.fire("Oops...","'.$error.'", "error");</script>';}?>	  
<?php } get_footer(); ?>