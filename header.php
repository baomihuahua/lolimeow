<?php
/**
 * boxmoe.com
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?php echo  md_title(); ?></title>
  <?php if(meowdata('favicon_src')){?><?php echo  md_favicon();?><?php } ?> 
  <link type="text/css" href="<?php echo boxmoe_load_style();?>/assets/css/themes.min.css?ver=<?php md_version() ;?>" rel="stylesheet">
    <link href="<?php echo boxmoe_load_style();?>/assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link type="text/css" href="<?php echo boxmoe_load_style();?>/assets/css/animate.min.css" rel="stylesheet">
  <link type="text/css" href="<?php echo boxmoe_load_style();?>/assets/css/style.css?ver=<?php md_version() ;?>" rel="stylesheet">   
  <?php if( meowdata('diystyles') ){ ?> <link rel="stylesheet" href="<?php echo boxmoe_load_style();?>/assets/css/diystyle.css"><?php } ?> 
  <script src="<?php echo boxmoe_load_style();?>/assets/vendor/jquery/jquery.min.js"></script>
  <?php wp_head(); ?>
</head>
<body>

<header class="header-global">
    <nav id="navbar-main" class="navbar navbar-main navbar-expand-lg navbar-transparent navbar-light headroom">
      <div class="container">
        <a class="navbar-brand mr-lg-5" href="<?php echo home_url(); ?>">
         <?php echo md_logo();?>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar_global" aria-controls="navbar_global" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse collapse" id="navbar_global">
          <div class="navbar-collapse-header">
            <div class="row">
              <div class="col-6 collapse-brand">
                <a href="<?php echo home_url(); ?>">
                   <?php echo md_logo();?>
                </a>
              </div>
              <div class="col-6 collapse-close">
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar_global" aria-controls="navbar_global" aria-expanded="false" aria-label="Toggle navigation">
                  <span></span>
                  <span></span>
                </button>
              </div>
            </div>
          </div>
          <ul class="navbar-nav navbar-nav-hover align-items-lg-center ml-lg-auto">
		   <?php md_nav_menu() ;?>
<li class="nav-item"><a href="#search" class="nav-link"><i class="fa fa-search"></i>Search</a></li>		   
<?php if( meowdata('sign_f') & is_user_logged_in() ){ global $current_user; wp_get_current_user(); ?> 
<li class="nav-item dropdown"><a href="#" data-toggle="dropdown" class="dropdown-toggle  nav-link" aria-haspopup="true"><i class="fa fa-user-circle-o"></i>Hello,<?php echo $current_user->nickname; ?></a>
<ul class="dropdown-menu">
<li class="nav-item"><a href="<?php echo site_url('/') ?><?php echo meowdata('users_page') ?>" class="dropdown-item"><i class="fa fa-address-card-o"></i>会员中心</a></li>
<li class="nav-item"><a href="<?php echo wp_logout_url( home_url() ); ?>" class="dropdown-item"><i class="fa fa-sign-out"></i>注销登录</a></li></ul></li><?php } ?>		           
		  </ul> 
		<?php if( meowdata('sign_f') & !is_user_logged_in() ){ ?> <div class="my-2 meowlogin"> <div class="admin-login hidden-sm">
 <div class="ruike_user-wrapper"> 
 <span class="ruike_user-loader">
 <a href="<?php echo site_url('') ?>/<?php echo meowdata('users_login')?>?r=<?php echo site_url('/') ?>" class="signin-loader z-bor" target="_blank" >登录</a> 
 <b class="middle-text"><span class="middle-inner">or</span></b> 
 </span> <span class="ruike_user-loader" >
 <a target="_blank" href="<?php echo site_url('/') ?><?php echo meowdata('users_reg') ?>" class="signup-loader l-bor" target="_blank" >注册</a></span> 
 </div> <i class="up-new"></i> 
 </div> 
 </div><?php } ?>
        </div>
      </div>	                                               
    </nav>
  </header>

  