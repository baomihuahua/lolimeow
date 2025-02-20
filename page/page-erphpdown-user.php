<?php 
/*
Template Name: erphpdown个人中心
Version: 17.0+
*/
if(!is_user_logged_in()){
	wp_redirect(wp_login_url());
	exit;
}
if (session_status() == PHP_SESSION_NONE) {
   session_start();
}
get_header(); global $current_user;
$erphp_url_front_novip = get_option('erphp_url_front_novip');
$erphp_url_front_notx = get_option('erphp_url_front_notx');
$erphp_url_front_nogm = get_option('erphp_url_front_nogm');
$erphp_url_front_notg = get_option('erphp_url_front_notg');
?>
<div class="container">
	<div class="erphpdown-sc-user-wrap">
		<ul class="erphpdown-sc-user-aside">
			<?php 
			if(get_option('ice_ali_money_checkin')){
				if(erphpdown_check_checkin($current_user->ID)){
		      		echo '<li style="padding-top:0"><a href="javascript:;" class="usercheck erphpdown-sc-btn active">已签到</a></li>';
		        }else{
		      		echo '<li style="padding-top:0"><a href="javascript:;" class="usercheck erphpdown-sc-btn erphp-checkin">今日签到</a></li>';
		        }
		    }
			?>
			<li <?php if((isset($_GET["pd"]) && $_GET["pd"]=='money') || !isset($_GET["pd"])){?>class="active"<?php }?> ><a href="<?php echo add_query_arg('pd','money',get_permalink());?>">在线充值</a></li>
			<?php if(!$erphp_url_front_novip){?><li <?php if(isset($_GET["pd"]) && $_GET["pd"]=='vip'){?>class="active"<?php }?> ><a href="<?php echo add_query_arg('pd','vip',get_permalink());?>">升级VIP</a></li><?php }?>
			<?php if(function_exists('erphpad_install')){?>
			<li class="<?php if(isset($_GET["pd"]) && $_GET['pd'] == 'ad') echo 'active';?>"><a href="<?php echo add_query_arg('pd','ad',get_permalink());?>">我的广告</a></li>
			<?php }?>
			<?php if(function_exists('erphpdown_tuan_install')){?>
			<li class="<?php if(isset($_GET["pd"]) && $_GET['pd'] == 'tuan') echo 'active';?>"><a href="<?php echo add_query_arg('pd','tuan',get_permalink());?>">我的拼团</a></li>
			<?php }?>
			<?php if(!$erphp_url_front_nogm){?><li <?php if(isset($_GET["pd"]) && $_GET["pd"]=='cart'){?>class="active"<?php }?> ><a href="<?php echo add_query_arg('pd','cart',get_permalink());?>">购买清单</a></li><?php }?>
			<li <?php if(isset($_GET["pd"]) && $_GET["pd"]=='recharge'){?>class="active"<?php }?> ><a href="<?php echo add_query_arg('pd','recharge',get_permalink());?>" >充值记录</a></li>
			<?php if(!$erphp_url_front_novip){?><li <?php if(isset($_GET["pd"]) && $_GET["pd"]=='vips'){?>class="active"<?php }?> ><a href="<?php echo add_query_arg('pd','vips',get_permalink());?>">VIP记录</a></li><?php }?>
			<?php if(!$erphp_url_front_notg){?><li <?php if(isset($_GET["pd"]) && $_GET["pd"]=='ref'){?>class="active"<?php }?> ><a href="<?php echo add_query_arg('pd','ref',get_permalink());?>">推广注册</a></li><?php }?>
			<?php if(!$erphp_url_front_novip && !$erphp_url_front_notg){?><li <?php if(isset($_GET["pd"]) && $_GET["pd"]=='ref2'){?>class="active"<?php }?> ><a href="<?php echo add_query_arg('pd','ref2',get_permalink());?>">推广VIP</a></li><?php }?>
			<?php if(!$erphp_url_front_notx){?><li <?php if(isset($_GET["pd"]) && $_GET["pd"]=='outmo'){?>class="active"<?php }?> ><a href="<?php echo add_query_arg('pd','outmo',get_permalink());?>">申请提现</a></li><?php }?>
			<li <?php if(isset($_GET["pd"]) && $_GET["pd"]=='info' ){?>class="active"<?php }?> ><a href="<?php echo add_query_arg('pd','info',get_permalink());?>">个人资料</a></li>
			<li><a href="<?php echo wp_logout_url(home_url());?>">安全退出</a></li>
		</ul>
		<div class="erphpdown-sc-user-content">
			<?php 
				if((isset($_GET['pd']) && $_GET['pd'] == 'money') || !isset($_GET['pd'])){
					echo do_shortcode('[erphpdown_sc_my]');
					echo do_shortcode('[erphpdown_sc_recharge]');
					echo do_shortcode('[erphpdown_sc_recharge_card]');
					echo do_shortcode('[erphpdown_sc_mycred]');
				}elseif(isset($_GET['pd']) && $_GET['pd'] == 'vip'){
					echo do_shortcode('[erphpdown_sc_vip_pay]');
					echo do_shortcode('[erphpdown_sc_vip]');
					echo do_shortcode('[erphpdown_sc_vip_card]');
				}elseif(isset($_GET['pd']) && $_GET['pd'] == 'cart'){
					echo '<style>.erphpdown-sc h2{display:none}</style>';
					echo do_shortcode('[erphpdown_sc_order_down]');
				}elseif(isset($_GET['pd']) && $_GET['pd'] == 'recharge'){
					echo '<style>.erphpdown-sc h2{display:none}</style>';
					echo do_shortcode('[erphpdown_sc_recharges]');
				}elseif(isset($_GET['pd']) && $_GET['pd'] == 'vips'){
					echo '<style>.erphpdown-sc h2{display:none}</style>';
					echo do_shortcode('[erphpdown_sc_order_vip]');
				}elseif(isset($_GET['pd']) && $_GET['pd'] == 'ref'){
					echo '<style>.erphpdown-sc h2{display:none}</style>';
					echo do_shortcode('[erphpdown_sc_ref]');
				}elseif(isset($_GET['pd']) && $_GET['pd'] == 'ref2'){
					echo '<style>.erphpdown-sc h2{display:none}</style>';
					echo do_shortcode('[erphpdown_sc_ref_vip]');
				}elseif(isset($_GET['pd']) && $_GET['pd'] == 'outmo'){
					echo '<style>.erphpdown-sc h2{display:none}</style>';
					echo do_shortcode('[erphpdown_sc_withdraw]');
					echo do_shortcode('[erphpdown_sc_withdraws]');
				}elseif(isset($_GET['pd']) && $_GET['pd'] == 'tuan'){
					echo '<style>.erphpdown-sc h2{display:none}</style>';
					echo do_shortcode('[erphpdown_sc_tuan]');
				}elseif(isset($_GET['pd']) && $_GET['pd'] == 'ad'){
					echo '<style>.erphpdown-sc h2{display:none}</style>';
					echo do_shortcode('[erphpdown_sc_ad]');
				}elseif(isset($_GET['pd']) && $_GET['pd'] == 'info'){
					echo '<style>.erphpdown-sc h2{display:none}</style>';
					echo do_shortcode('[erphpdown_sc_info]');
				}
			?>
		</div>
	</div>
</div>
<?php get_footer(); ?>