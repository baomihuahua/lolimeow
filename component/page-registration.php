<?php
/**
 * Template Name: 注册页面
 */
  
if( !empty($_POST['mogu_reg']) ) {
  $error = '';
  $sanitized_user_login = sanitize_user( $_POST['user_login'] );
  $user_email = apply_filters( 'user_registration_email', $_POST['user_email'] );

  // Check the username
  if ( $sanitized_user_login == '' ) {
    $error .= '<strong>错误</strong>：请输入用户名。<br />';
  } elseif ( ! validate_username( $sanitized_user_login ) ) {
    $error .= '<strong>错误</strong>：此用户名包含无效字符，请输入有效的用户名<br />。';
    $sanitized_user_login = '';
  } elseif ( username_exists( $sanitized_user_login ) ) {
    $error .= '<strong>错误</strong>：该用户名已被注册，请再选择一个。<br />';
  }

  // Check the e-mail address
  if ( $user_email == '' ) {
    $error .= '<strong>错误</strong>：请填写电子邮件地址。<br />';
  } elseif ( ! is_email( $user_email ) ) {
    $error .= '<strong>错误</strong>：电子邮件地址不正确。！<br />';
    $user_email = '';
  } elseif ( email_exists( $user_email ) ) {
    $error .= '<strong>错误</strong>：该电子邮件地址已经被注册，请换一个。<br />';
  }
	
  // Check the password
  if(strlen($_POST['user_pass']) < 6)
    $error .= '<strong>错误</strong>：密码长度至少6位!<br />';
  elseif($_POST['user_pass'] != $_POST['user_pass2'])
    $error .= '<strong>错误</strong>：两次输入的密码必须一致!<br />';
	  
	if($error == '') {
    $user_id = wp_create_user( $sanitized_user_login, $_POST['user_pass'], $user_email );
	
    if ( ! $user_id ) {
      $error .= sprintf( '<strong>错误</strong>：无法完成您的注册请求... 请联系<a href="mailto:%s">管理员</a>！<br />', get_option( 'admin_email' ) );
    }
    else if (!is_user_logged_in()) {
      $user = get_user_by( 'login', $sanitized_user_login );
      $user_id = $user->ID;
            $from = get_option('admin_email');
	        $headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
			$subject = '注册成功';
			$msg = '<table style="width: 99.8%;height:99.8% "><tbody><tr><td style="background:#fafafa url()">
<div style="border-radius: 10px 10px 10px 10px;font-size:13px;color: #555555;width: 95%;font-family:"Century Gothic","Trebuchet MS","Hiragino Sans GB",微软雅黑,"Microsoft Yahei",Tahoma,Helvetica,Arial,"SimSun",sans-serif;margin:50px auto;border:1px solid #eee;max-width:100%;background: #ffffff repeating-linear-gradient(-45deg,#fff,#fff 1.125rem,transparent 1.125rem,transparent 2.25rem);box-shadow: 0 1px 5px rgba(0, 0, 0, 0.15);">
<div style="width:100%;background:#49BDAD;color:#ffffff;border-radius: 10px 10px 0 0;background-image: -moz-linear-gradient(0deg, rgb(67, 198, 184), rgb(255, 209, 244));background-image: -webkit-linear-gradient(0deg, rgb(67, 198, 184), rgb(255, 209, 244));height: 66px;">
<p style="font-size:15px;word-break:break-all;padding: 23px 32px;margin:0;background-color: hsla(0,0%,100%,.4);border-radius: 10px 10px 0 0;">您在<a style="text-decoration:none;color: #ffffff;" href="' . home_url(). '" rel="noopener" target="_blank"> [' . get_option('blogname') . '] </a> 的会员注册信息！</p>
</div><div style="margin:40px 30px"><p>恭喜注册成功，请保存好您的会员信息</p><p style="background: #fafafa repeating-linear-gradient(-45deg,#fff,#fff 1.125rem,transparent 1.125rem,transparent 2.25rem);box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);margin:20px 0px;padding:15px;border-radius:5px;font-size:14px;color:#555555;">
用户名: '.$sanitized_user_login.' <br>邮  箱: '.$user_email.' <br>密  码: 用户自己设定</p><p>此邮件由 <a style="text-decoration:none; color:#12addb" href="' . home_url(). '" rel="noopener" target="_blank"> ' . get_option('blogname') . ' </a> 系统自动发送，请勿直接回复！</p>
</div></div></td></tr></tbody></table>';
			//发送邮件
			wp_mail( $user_email, $subject, $msg, $headers );

      // 自动登录
      wp_set_current_user($user_id, $user_login);
      wp_set_auth_cookie($user_id);
      do_action('wp_login', $user_login);
    }
  }
}

?>
<?php the_content(); ?>
<?php
if (!is_user_logged_in()) { get_header(); ?>
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
				<H3>注册会员</H3>
                  <small>该页面已经过安全加密</small>
                </div><?php if(get_option('users_can_register')) {?>
                <form name="registerform" method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
                  <div class="form-group mb-3">
                    <div class="input-group input-group-alternative">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                      </div>
					  <input type="text" name="user_login" tabindex="1" id="user_login" class="form-control" value="<?php if(!empty($sanitized_user_login)) echo $sanitized_user_login; ?>" placeholder="请输入用户名" />
                    </div>
                  </div>
				  <div class="form-group">
                    <div class="input-group input-group-alternative mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-envelope-o"></i></span>
                      </div>
					  <input type="email" name="user_email" tabindex="2" id="user_email" class="form-control" value="<?php if(!empty($user_email)) echo $user_email; ?>"  placeholder="请输入注册邮箱" />
                    </div>
                  </div>
				   <div class="form-group">
                    <div class="input-group input-group-alternative mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-key"></i></span>
                      </div>
					  <input id="user_pwd1" class="form-control" tabindex="3" type="password" tabindex="21" size="25" value="" name="user_pass" placeholder="请输入密码至少6位"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group input-group-alternative">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-key"></i></span>
                      </div>
					  <input id="user_pwd2" class="form-control" tabindex="4" type="password" tabindex="21" size="25" value="" name="user_pass2" placeholder="再次输入密码"/>
                    </div>
                  </div>

                  <div class="text-center">
				  <input type="hidden" name="mogu_reg" value="ok" />
                    <button type="submit" class="btn btn-primary my-4">注册账户</button>
                  </div>
                </form><?php }else{ echo '<div class="alert alert-danger mt30" role="alert">对不起暂时不开放注册，请以后再试.</div>';}?>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-6">
                <a href="<?php echo site_url('/') ?>wp-login.php?action=lostpassword" class="btn btn-1 btn-sm btn-outline-warning">
                  <small>忘记密码?</small>
                </a>
              </div>
              <div class="col-6 text-right">
                <a href="<?php echo site_url('/') ?>login" class="btn btn-1 btn-sm btn-outline-warning">
                  <small>已注册? 赶紧登陆会员吧！</small>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>

</div>
</main>	
<?php get_footer(); ?>
<?php } else {
echo '<script type="text/javascript">window.location="'.meowdata('regto').'"</script>';
} ?>