<?php 
/*
 * Template Name: 会员中心
 * 
*/
if(!is_user_logged_in()){ ?>
<?php	echo "<script>window.location.href='".site_url('login')."';</script>";?>
<?php }else { ?>
<?php get_header();
$styleurls=get_template_directory_uri(); 
global $wpdb;
$user_info=wp_get_current_user();
function mobantu_paging($type,$paged,$max_page) {
	if ( $max_page <= 1 ) return; 
	if ( empty( $paged ) ) $paged = 1;
	
	echo '<nav aria-label="Page navigation example"><ul class="pagination">';
	echo "<li class='page-item'><a class=extend href='?item=$type&pp=1'>首页</a></li>";
	if($paged > 1){
		echo '<li class="page-item"><a href="?item='.$type.'&pp='.($paged-1).'" class="page-link"><i class="fa fa-angle-left"></i></a></li>';
	}
	if ( $paged > 2 ) echo "<li class='page-item'><span> ... </span></li>";
	for( $i = $paged - 1; $i <= $paged + 3; $i++ ) { 
		if ( $i > 0 && $i <= $max_page ) 
		{
			if($i == $paged) 
				print "<li class=\"active page-item\"><span>{$i}</span></li>";
			else
				print "<li class='page-item'><a href='?item=$type&pp={$i}' class='page-link'><span>{$i}</span></a></li>";
		}
	}
	if ( $paged < $max_page - 3 ) echo "<li class='page-item'><span> ... </span></li>";
	if($paged < $max_page){
		echo '<li class="page-item"><a href="?item='.$type.'&pp='.($paged+1).'" class="page-link"><i class="fa fa-angle-right"></i></a></li>';
	}
	echo "<li class='page-item'><a href='?item=$type&pp=$max_page' class='extend'>尾页</a></li>";
	echo '</ul>';
}

if($_POST['paytype']){
		$paytype=intval($_POST['paytype']);
		$doo = 1;
		
		if(isset($_POST['paytype']) && $paytype==3)
		{
			$url=get_bloginfo('url')."/wp-content/plugins/erphpdown/payment/chinabank.php?ice_money=".$wpdb->escape($_POST['ice_money']);
		}
		elseif(isset($_POST['paytype']) && $paytype==1)
		{
			$url=get_bloginfo('url')."/wp-content/plugins/erphpdown/payment/alipay.php?ice_money=".$wpdb->escape($_POST['ice_money']);
		}
		elseif(isset($_POST['paytype']) && $paytype==7)
		{
			$url=get_bloginfo('url')."/wp-content/plugins/erphpdown/payment/tenpay.php?ice_money=".$wpdb->escape($_POST['ice_money']);
		}
		elseif(isset($_POST['paytype']) && $paytype==4)
		{
			$url=get_bloginfo('url')."/wp-content/plugins/erphpdown/payment/weixin/example/weixin.php?ice_money=".$wpdb->escape($_POST['ice_money']);
		}
		elseif(isset($_POST['paytype']) && $paytype==8)
		{
			$url=get_bloginfo('url')."/wp-content/plugins/erphpdown/payment/alipay_jk.php?ice_money=".$wpdb->escape($_POST['ice_money']);
		}
		elseif(isset($_POST['paytype']) && $paytype==2)
		{
			$url=get_bloginfo('url')."/wp-content/plugins/erphpdown/payment/paypal.php?ice_money=".$wpdb->escape($_POST['ice_money']);
		}
		elseif(isset($_POST['paytype']) && $paytype==9)
	    {
	        $url=constant("erphpdown")."payment/xhpay.php?ice_money=".esc_sql($_POST['ice_money']);
	    }
	    elseif(isset($_POST['paytype']) && $paytype==10)
	    {
	        $url=constant("erphpdown")."payment/xhpay2.php?ice_money=".esc_sql($_POST['ice_money']);
	    }elseif(isset($_POST['paytype']) && $paytype==11)
	    {
	        $url=constant("erphpdown")."payment/xhpay3.php?ice_money=".esc_sql($_POST['ice_money']);
	    }
	    elseif(isset($_POST['paytype']) && $paytype==12)
	    {
	        $url=constant("erphpdown")."payment/xhpay4.php?ice_money=".esc_sql($_POST['ice_money']);
	    }elseif(isset($_POST['paytype']) && $paytype==13)
	    {
	        $url=constant("erphpdown")."payment/codepay.php?ice_money=".esc_sql($_POST['ice_money'])."&type=1";
	    }elseif(isset($_POST['paytype']) && $paytype==14)
	    {
	        $url=constant("erphpdown")."payment/codepay.php?ice_money=".esc_sql($_POST['ice_money'])."&type=3";
	    }elseif(isset($_POST['paytype']) && $paytype==15)
	    {
	        $url=constant("erphpdown")."payment/codepay.php?ice_money=".esc_sql($_POST['ice_money'])."&type=2";
	    }elseif(isset($_POST['paytype']) && $paytype==16)
	    {
	        $url=constant("erphpdown")."payment/youzan.php?ice_money=".esc_sql($_POST['ice_money']);
	    }
		else{
			
		}
		if($doo) echo "<script>location.href='".$url."'</script>";
		exit;
	}
	
	
	global $userdata, $wp_http_referer;
					get_currentuserinfo();
					if ( !(function_exists( 'get_user_to_edit' )) ) {
						require_once(ABSPATH . '/wp-admin/includes/user.php');
					}			
					if ( !(function_exists( '_wp_get_user_contactmethods' )) ) {

						require_once(ABSPATH . '/wp-includes/registration.php');

					}			
					if ( !$user_id ) {

						$current_user = wp_get_current_user();

						$user_id = $user_ID = $current_user->ID;

					}
                    $user_Info   = wp_get_current_user();
					$userMoney=$wpdb->get_row("select * from ".$wpdb->iceinfo." where ice_user_id=".$user_Info->ID);
					if(!$userMoney)
					{
						$okMoney=0;
					}
					else 
					{
						$okMoney=$userMoney->ice_have_money - $userMoney->ice_get_money;
					}
			
					$profileuser = get_user_to_edit( $user_id );
 //get_header 
 ?>

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
<div class="main main-raised profile-page">
        <div class="profile-content">
            <div class="container"> 

<div class="card card-profile shadow" style="z-index:9;">
          <div class="px-4">
            <div class="row justify-content-center">
              <div class="col-lg-3 order-lg-2">
                <div class="card-profile-image">
                  <a href="#">
                    <img src="<?php echo meowdata('gravatar_url'); ?><?php echo esc_attr(md5($profileuser->user_email)); ?>?s=160" class="rounded-circle">
                  </a>
                </div>
              </div>
              <div class="col-lg-4 order-lg-3 text-lg-right align-self-lg-center">
                <div class="card-profile-actions py-4 mt-lg-0">
                  <a href="?item=money" class="btn btn-sm btn-info mr-4">充值积分</a>
                  <a href="?item=vip" class="btn btn-sm btn-default float-right">升级会员</a>
                </div>
              </div>
              <div class="col-lg-4 order-lg-1">
                <div class="card-profile-stats d-flex justify-content-center">
                  <div>
                    <span class="heading"><?php echo sprintf("%.2f",$okMoney)?></span>
                    <span class="description">账户<?php echo get_option('ice_name_alipay');?></span>
                  </div>
                  <div>
                    <span class="heading"><?php echo sprintf("%.2f",$userMoney->ice_get_money)?></span>
                    <span class="description">消费<?php echo get_option('ice_name_alipay');?></span>
                  </div>
                </div>
              </div>
            </div>
</div></div>

			  
                <div class="nav-wrapper mt30">
                            <ul class="nav nav-pills nav-fill flex-column flex-md-row">
                                <li class="nav-item">
                                    <a class="nav-link mb-sm-3 mb-md-0 <?php if($_GET["item"]=='info' || !isset($_GET["item"])){?>active show<?php }?>" href="?item=info" >
                                        <i class="fa fa-user-circle-o"></i>会员信息
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link mb-sm-3 mb-md-0 <?php if($_GET["item"]=='order'){?>active show<?php }?>" href="?item=order">
                                        <i class="fa fa-bars"></i> 订单管理
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link mb-sm-3 mb-md-0 <?php if($_GET["item"]=='vip'){?>active show<?php }?>" href="?item=vip">
                                        <i class="fa fa-arrow-circle-o-up"></i> 会员升级
                                    </a>
                                </li>
								<li class="nav-item">
                                    <a class="nav-link mb-sm-3 mb-md-0 <?php if($_GET["item"]=='money'){?>active show<?php }?>" href="?item=money">
                                        <i class="fa fa-jpy"></i> <?php echo get_option('ice_name_alipay')?>充值
                                    </a>
                                </li>
								<li class="nav-item">
                                    <a class="nav-link mb-sm-3 mb-md-0 <?php if($_GET["item"]=='recharge'){?>active show<?php }?>" href="?item=recharge">
                                        <i class="fa fa-won"></i> 充值记录
                                    </a>
                                </li>
								<li class="nav-item">
                                    <a class="nav-link mb-sm-3 mb-md-0 <?php if($_GET["item"]=='pass'){?>active show<?php }?>" href="?item=pass">
                                        <i class="fa fa-pencil-square-o"></i> 修改密码
                                    </a>
                                </li>
								<?php if ( $user_ID )  { ?><li class="nav-item">
                                    <a class="nav-link mb-sm-3 mb-md-0" href="<?php echo wp_logout_url( home_url('/login') ); ?>" >
                                        <i class="fa fa-sign-out"></i> 退出会员 </a>
                                </li><?php } ?>
                            </ul>
                    </div>
				
				
<div class="tab-content tab-space">
				 
 <?php if($_GET["item"]=='info' || !isset($_GET["item"])){ ?>
<div class="tab-pane active show" id="info">						
<div class="card card-nav-tabs">
<div class="card-header card-header-info text-center">
    会员信息<div id="result"></div>
  </div>
  <div class="card-body">
  <div class="row">
<div class="col-md-8 ml-auto mr-auto">
<div class="row">
<div class="col-md-8 ml-auto mr-auto">
<span class="text-info">登陆用户：</span> <?php echo esc_attr( $profileuser->user_login ); ?>
</div>
</div>
<div class="row">
<div class="col-md-8 ml-auto mr-auto">
<span class="text-info">会员等级：</span> <?php 
							$ciphp_year_price    = get_option('ciphp_year_price');
							$ciphp_quarter_price = get_option('ciphp_quarter_price');
							$ciphp_month_price  = get_option('ciphp_month_price');
							$ciphp_life_price  = get_option('ciphp_life_price');							
                            $userTypeId=getUsreMemberType();
                            if($userTypeId==7)
                            {
                                echo '包月会员&nbsp;<img src="'.$styleurls.'/assets/images/vip/v2.jpg">'; 
                            }
                            elseif ($userTypeId==8)
                            {
                                echo '包季会员&nbsp;<img src="'.$styleurls.'/assets/images/vip/v3.jpg">';
                            }
                            elseif ($userTypeId==9)
                            {
                                echo '包年会员&nbsp;<img src="'.$styleurls.'/assets/images/vip/v4.jpg">';
                            }
							elseif ($userTypeId==10)
                            {
                                echo '终身会员&nbsp;<img src="'.$styleurls.'/assets/images/vip/v5.jpg">';
                            }
                            else 
                            {
                                echo '普通会员<img src="'.$styleurls.'/assets/images/vip/v1.jpg">';
                            }
                            ?>		&nbsp;&nbsp;<?php echo $userTypeId>0 ?'到期时间：'.getUsreMemberTypeEndTime() :''?>	
</div>
</div>
<div class="row">
<div class="col-md-8 ml-auto mr-auto">    
<span class="text-info">账户余额：</span><?php echo sprintf("%.2f",$okMoney)?>&nbsp;&nbsp;<?php echo get_option('ice_name_alipay');?>
</div>
</div>
<div class="row">
<div class="col-md-8 ml-auto mr-auto">    
<span class="text-info">累计消费：</span><?php echo sprintf("%.2f",$userMoney->ice_get_money)?>&nbsp;&nbsp;<?php echo get_option('ice_name_alipay');?>
</div>
</div>
<div class="row">
<div class="col-md-8 ml-auto mr-auto">    
<span class="text-info">评论数量：</span><?php global $user_ID;echo get_comments('count=true&user_id='.$user_ID);?> 条
</div>
</div>
<div class="row">
<div class="col-md-8 ml-auto mr-auto">    
<span class="text-info">注册时间：</span><?php echo esc_attr( $profileuser->user_registered ) ?>
</div>
</div>
<div class="row">
<div class="col-md-8 ml-auto mr-auto">    
<span class="text-info">最近登录：</span><?php echo esc_attr( $profileuser->last_login ) ?>
</div>
</div>

	  		  <form action="" method="post">
<div class="row">
<div class="col-md-8 ml-auto mr-auto"> 
<div class="form-group label-floating has-info">
    <label class="control-label ">帐户邮箱：</label>
          <input type="text" class="form-control"id="mm_mail" name="mm_mail" value="<?php echo esc_attr( $profileuser->user_email ) ?>">
  </div>
  </div>
</div> 		
<div class="row">
<div class="col-md-8 ml-auto mr-auto"> <div class="form-group label-floating has-info">
    <label class="control-label">会员昵称：</label>
          <input type="text" class="form-control" id="mm_name" name="mm_name" value="<?php echo esc_attr( $profileuser->nickname ) ?>">
  </div> </div>
</div>
<div class="row">
<div class="col-md-8 ml-auto mr-auto"><div class="form-group label-floating has-info">
    <label class="control-label">会员网站：</label>
        <input type="text" class="form-control" id="mm_url" name="mm_url" value="<?php echo esc_attr( $profileuser->user_url ) ?>">
  </div> </div>
</div>	
<div class="row">
<div class="col-md-8 ml-auto mr-auto"> <div class="form-group label-floating has-info">
    <label class="control-label">会员简介：</label>
        <textarea rows="4" class="form-control forminput" id="mm_desc" name="mm_desc"><?php echo esc_html( $profileuser->description ); ?></textarea>
  </div></div>
</div>
<div class="row">
<div class="col-md-8 ml-auto mr-auto">
<button class="btn btn-outline-info"  id="doprofile" type="button">保存</button>
</div></div>  
<div class="row  mb20 ml-auto mr-auto">
<div class="col-md-6">
</div>         
</div>
	  </form>

	
	</div>
	</div>	
	</div>
</div>


						 
						 <script type="text/javascript">
				jQuery(document).ready(function($){
				
					$("#doprofile").click(function(){ 
						var reg = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/ ;
						if($("#mm_name").val().trim().length==0)
						{
							$("#tip1").html("<span class=\"badge badge-danger\">请输入昵称</span>");
						}
						else if(strlen($("#mm_name").val().trim())<4)
						{   
					        $('#tipsnode').modal();	
							$("#tip1").html("<span class=\"badge badge-danger\">昵称长度至少为4位</span>");
						}
						else if(!reg.test($("#mm_mail").val().trim()))
						{
							$("#tip1").html("<span class=\"badge badge-danger\">法请输入正确邮箱，以免忘记密码时无找回</span>");
						}
						else
						{
							$('#result').html('<img src="<?php bloginfo('template_url'); ?>/assets/images/loader.gif" class="loader" />').fadeIn();						
							$.ajax({
								type: "post",
								//async: false,
								url: "<?php echo ERPHPDOWN_URL; ?>/admin/action/ajax-profile.php",
								data: "do=profile&mm_name=" + $("#mm_name").val() + "&mm_mail=" + $("#mm_mail").val() + "&mm_url=" + $("#mm_url").val() + "&mm_desc=" + $("#mm_desc").val(),
								//contentType: "application/json; charset=utf-8",
								dataType: "text",
								success: function (data) {
									$('.loader').remove(); 		
                                    $('#tipsnode').modal();									
									$("#tip1").html("<span class=\"badge badge-success\">修改成功</span>");
									
								},
								error: function () {
								   $('.loader').remove();
								   $('#tipsnode').modal();
								$("#tip1").html("<span class=\"badge badge-danger\">修改失败</span>");
								}
							});
						}
					});
				
				});
			</script>


	









                    </div>
					<?php //结束  
}?>
					
					 <?php if($_GET["item"]=='order'){
			//统计数据
			//$user_info=wp_get_current_user();
			$total_trade   = $wpdb->get_var("SELECT COUNT(ice_id) FROM $wpdb->icealipay WHERE ice_success>0 and ice_user_id=".$user_info->ID);
			//$total_money   = $wpdb->get_var("SELECT SUM(ice_price) FROM $wpdb->icealipay WHERE ice_success>0 and ice_user_id=".$user_info->ID);
			//分页计算
			$ice_perpage = 10;
			$pages = ceil($total_trade / $ice_perpage);
			$page=isset($_GET['pp']) ?intval($_GET['pp']) :1;
			$offset = $ice_perpage*($page-1);
			$list = $wpdb->get_results("SELECT * FROM $wpdb->icealipay where ice_success=1 and ice_user_id=$user_info->ID order by ice_time DESC limit $offset,$ice_perpage");
			?>
 <div class="tab-pane active show" id="order">			
<div class="card card-nav-tabs">
<div class="card-header card-header-info text-center">
    会员信息
  </div>
  <div class="card-body">
			 <table class="table table-hover table-striped">
					<thead>
						<tr>
							<th width="15%">订单号</th>
							<th width="35%">商品名称</th>
							<th width="10%">价格</th>
							<th width="25%">交易时间</th>
							<th width="15%">下载信息</th>
						</tr>
					</thead>
					<tbody>
						<?php
							if($list) {
								foreach($list as $value)
								{
									echo "<tr>\n";
									echo "<td>$value->ice_num</td>";
									echo "<td><a target=_blank href=".get_permalink($value->ice_post).">$value->ice_title</a></td>\n";
									echo "<td>$value->ice_price</td>\n";
									echo "<td>$value->ice_time</td>\n";
									echo "<td><a href='".get_bloginfo('wpurl').'/wp-content/plugins/erphpdown/download.php?url='.$value->ice_url."' target='_blank'><span class='badge badge-pill badge-success'>下载页面</span></a></td>\n";
									echo "</tr>";
								}
							}
							else
							{
								echo '<tr width=100%><td colspan="5" align="center"><center><strong>没有订单</strong></center></td></tr>';
							}
						?>
					</tbody>
				</table>
                <?php mobantu_paging('cart',$page,$pages);?></div></div></div>
<?php //订单结束  
}?> 					 
<?php if($_GET["item"]=='vip'){ /////////////////升级会员
                    $user_Info   = wp_get_current_user();
					$userMoney=$wpdb->get_row("select * from ".$wpdb->iceinfo." where ice_user_id=".$user_Info->ID);
					if(!$userMoney)
					{
						$okMoney=0;
					}
					else 
					{
						$okMoney=$userMoney->ice_have_money - $userMoney->ice_get_money;
					}
				?>					 
<div class="tab-pane active show" id="updatavip">
<div class="card card-nav-tabs">
<div class="card-header card-header-info text-center">
    升级会员
  </div>
  <div class="card-body">

<div class="alert alert-info" role="alert">
<strong class="text-warning">当前会员等级：
                            <?php 
							$ciphp_year_price    = get_option('ciphp_year_price');
							$ciphp_quarter_price = get_option('ciphp_quarter_price');
							$ciphp_month_price  = get_option('ciphp_month_price');
							$ciphp_life_price  = get_option('ciphp_life_price');							
                            $userTypeId=getUsreMemberType();
                            if($userTypeId==7)
                            {
                                echo '包月会员&nbsp;&nbsp;<img src="'.$styleurls.'/assets/images/vip/v2.jpg">';
                            }
                            elseif ($userTypeId==8)
                            {
                                echo '包季会员&nbsp;&nbsp;<img src="'.$styleurls.'/assets/images/vip/v3.jpg">';
                            }
                            elseif ($userTypeId==9)
                            {
                                echo '包年会员&nbsp;&nbsp;<img src="'.$styleurls.'/assets/images/vip/v4.jpg">';
                            }
							elseif ($userTypeId==10)
                            {
                                echo '终身会员&nbsp;&nbsp;<img src="'.$styleurls.'/assets/images/vip/v5.jpg">'; 
                            }
                            else 
                            {
                                echo '注册会员&nbsp;&nbsp;<img src="'.$styleurls.'/assets/images/vip/v1.jpg">';
                            }
                            ?>		&nbsp;&nbsp;<?php echo $userTypeId>0 ?'到期时间：'.getUsreMemberTypeEndTime() :''?></strong>&nbsp;&nbsp;<a href="?item=money" class="btn btn-sm btn-danger" >账户余额：<?php echo sprintf("%.2f",$okMoney)?><?php echo get_option('ice_name_alipay')?> &nbsp;&nbsp;充值<?php echo get_option('ice_name_alipay')?></a></div>

<?php if($userTypeId>0){
	
}else{?><form action="" method="post"><ul class="user-meta zwfb_shop_table">
<li> <input type="radio" id="userType" name="userType" value="10" checked /><span class="text-info"><strong>&nbsp;终身会员&nbsp;(<?php echo $ciphp_life_price.get_option('ice_name_alipay')?>)</strong></span>&nbsp;&nbsp;<img src="<?php echo get_template_directory_uri().'/assets/images/vip/v5.jpg' ?>"> </li>
<li> <input type="radio" id="userType" name="userType" value="9" /><span class="text-danger"><strong>&nbsp;包年会员&nbsp;(<?php echo $ciphp_year_price.get_option('ice_name_alipay')?>)</strong></span>&nbsp;&nbsp;<img src="<?php echo get_template_directory_uri().'/assets/images/vip/v4.jpg' ?>"> </li>
<li><input type="radio" id="userType" name="userType" value="8" /><span class="text-warning"><strong>&nbsp;包季会员&nbsp;(<?php echo $ciphp_quarter_price.get_option('ice_name_alipay')?>)</strong></span>&nbsp;&nbsp;<img src="<?php echo get_template_directory_uri().'/assets/images/vip/v3.jpg' ?>"> </li>
<li><input type="radio" id="userType" name="userType" value="7" /><span class="text-success"><strong>&nbsp;包月会员&nbsp;(<?php echo $ciphp_month_price.get_option('ice_name_alipay')?> )</strong></span>&nbsp;&nbsp;<img src="<?php echo get_template_directory_uri().'/assets/images/vip/v2.jpg' ?>"></li>                         
<li class=""><input type="submit" name="Submit" value="升级会员" class="btn btn-1 btn-outline-success mt20 mb20" onClick="return confirm('确认升级会员?');"/></li>
<li id="viptip" class="mt10 mb10"></li>
</ul></form><?php }?>
<?php 
if($_POST['userType']){
		$userType=isset($_POST['userType']) && is_numeric($_POST['userType']) ?intval($_POST['userType']) :0;
		if($userType >6 && $userType < 11)
		{
			$okMoney=erphpGetUserOkMoney();
			$priceArr=array('7'=>'ciphp_month_price','8'=>'ciphp_quarter_price','9'=>'ciphp_year_price','10'=>'ciphp_life_price');
			$priceType=$priceArr[$userType];
			$price=get_option($priceType);
			echo "<div>";
			if(empty($price) || $price<1)
			{
				echo "<script>document.getElementById('viptip').innerHTML='<span class=\'badge badge-warning\' role=\'alert\'>此类型的会员价格错误，请稍候重试！</span>';</script>";
			}
			elseif($okMoney < $price)
			{
				echo "<script>document.getElementById('viptip').innerHTML='<span class=\'badge badge-warning\' role=\'alert\'>当前可用余额不足完成此次升级！</span>';</script>";
			}
			elseif($okMoney >=$price)
			{
				if(erphpSetUserMoneyXiaoFei($price))
				{
					if(userPayMemberSetData($userType))
					{
						addVipLog($price, $userType);
						
					}
					else
					{
						echo "<script>document.getElementById('viptip').innerHTML='<span class=\'badge badge-warning\' role=\'alert\'>系统发生错误，请联系管理员！</span>';</script>";
					}
				}
				else
				{
					echo "<script>document.getElementById('viptip').innerHTML='<span class=\'badge badge-warning\' role=\'alert\'>系统发生错误，请稍候重试！</span>';</script>";
				}
			}
			else
			{
				echo "<script>document.getElementById('viptip').innerHTML='<span class=\'badge badge-warning\' role=\'alert\'>未定义的操作！</span>';</script>";
			}
		}
		else
		{
			echo "<script>document.getElementById('viptip').innerHTML='<span class=\'badge badge-warning\' role=\'alert\'>会员类型错误！</span>';</script>";
		}
		echo "</div>";
	}?>
</div></div></div> <?php //升级会员
}?>
<?php if($_GET["item"]=='money'){ //////个人资产
					$user_Info   = wp_get_current_user();
					$userMoney=$wpdb->get_row("select * from ".$wpdb->iceinfo." where ice_user_id=".$user_Info->ID);
					if(!$userMoney)
					{
						$okMoney=0;
					}
					else 
					{
						$okMoney=$userMoney->ice_have_money - $userMoney->ice_get_money;
					}
				?>
<div class="tab-pane active show" id="pay">
<div class="card card-nav-tabs">
<div class="card-header card-header-info text-center">
   充值中心
  </div>
<div class="card-body">
<h5>

 <h4 style="border-bottom:1px solid #999999;">账户情况</h4>
 <span class="badge badge-warning">消费<?php echo get_option('ice_name_alipay');?>：<?php echo intval($userMoney->ice_get_money)?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;剩余<?php echo get_option('ice_name_alipay');?>：<?php echo $okMoney?><?php if(plugin_check_cred() && get_option('erphp_mycred') == 'yes'){$mycred_core = get_option('mycred_pref_core');?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;剩余<?php echo $mycred_core[name][plural];?>：<?php echo mycred_get_users_cred( $user_Info->ID )?><?php }?></span>
<div class="row mt20">
 <?php if(function_exists("checkDoCardResult")){?>
<script type="text/javascript">
					function checkFm(){
						if(document.getElementById("ice_money").value=="")
						{
							alert('请输入金额');
							return false;
						}
					}
					</script>
					
					
<div class="col-md-12">
                <form action="" method="post" onSubmit="return checkFm();">
                        <h4 style="border-bottom:1px solid #999999;">在线充值</h4>
                        <table class="form-table">
                            <tr>
                				<td><div class="col-md-12 mt10 mb10">
                				<input type="text" id="ice_money" name="ice_money" class="form-control" placeholder="请输入一个整数金额" required="required"/>
                				</div><?php if(get_option('ice_weixin_mchid')){?> 
                                <input type="radio" id="paytype4" class="paytype" checked name="paytype" value="4" onclick="checkCard()" />微信&nbsp;
                                <?php }?>
                                <?php if(get_option('ice_ali_partner')){?> 
                                <input type="radio" id="paytype1" class="paytype" checked name="paytype" value="1" onclick="checkCard()" />支付宝&nbsp;
                                <?php }?>
                                <?php if(get_option('erphpdown_tenpay_uid')){?> 
                                <input type="radio" id="paytype7" class="paytype" checked name="paytype" value="7" onclick="checkCard()" />财付通&nbsp;    
                                <?php }?> 
                                <?php if(get_option('ice_china_bank_uid')){?> 
                                <input type="radio" id="paytype3" class="paytype" checked name="paytype" value="3" onclick="checkCard()"/>银联支付&nbsp;    
                                <?php }?>
                                <?php if(get_option('erphpdown_zfbjk_uid')){?> 
                                <input type="radio" id="paytype8" class="paytype" checked name="paytype" value="8" onclick="checkCard()"/>支付宝转账自动充值&nbsp;    
                                <?php }?>
                                <?php if(get_option('erphpdown_xhpay_appid')){?> 
				                <input type="radio" id="paytype9" class="paytype" name="paytype" value="9" checked onclick="checkCard()"/>支付宝&nbsp;
				                <input type="radio" id="paytype10" class="paytype" name="paytype" value="10" checked onclick="checkCard()"/>微信&nbsp;        
				                <?php }?> 
				                <?php if(get_option('erphpdown_xhpay_appid2')){?> 
				                <input type="radio" id="paytype11" class="paytype" name="paytype" value="11" checked onclick="checkCard()"/>支付宝&nbsp;
				                <input type="radio" id="paytype12" class="paytype" name="paytype" value="12" checked onclick="checkCard()"/>微信&nbsp;        
				                <?php }?>
				                <?php if(get_option('erphpdown_codepay_appid')){?> 
				                <input type="radio" id="paytype13" class="paytype" name="paytype" value="13" checked onclick="checkCard()"/>支付宝&nbsp;
				                <input type="radio" id="paytype14" class="paytype" name="paytype" value="14" onclick="checkCard()"/>微信&nbsp;
				                <input type="radio" id="paytype15" class="paytype" name="paytype" value="15" onclick="checkCard()"/>QQ钱包&nbsp;        
				                <?php }?>
				                <?php if(get_option('erphpdown_youzan_id')){?> 
				                <input type="radio" id="paytype16" class="paytype" name="paytype" value="16" checked onclick="checkCard()"/>有赞支付&nbsp;    
				                <?php }?> 
                                <?php if(get_option('ice_payapl_api_uid')){?> 
                                <input type="radio" id="paytype2" class="paytype" checked name="paytype" value="2" onclick="checkCard()"/>PayPal($美元)汇率：
                                 (<?php echo get_option('ice_payapl_api_rmb')?>)&nbsp;  
                                 <?php }?>  </td>
                            </tr>

                    </table>
                        <br /> 
                        <table> <tr>
                        <td><p class="submit">
                            <input type="submit" name="Submit" value="在线充值" class="btn btn-outline-success"/>
                            </p>
                        </td>
                
                        </tr> 
                        
                        </table>
                
               </form> </div>					
 <div class="col-md-12 mb30">
 <h4 style="border-bottom:1px solid #999999;">充值卡充值</h4>
 <div class="alert alert-info" role="alert">充值说明：<span class="badge badge-warning">1 元 = <?php echo get_option('ice_proportion_alipay').' '.get_option('ice_name_alipay')?></span>请根据需求充值，充值卡密金额分别为<span class="badge badge-success">10元</span> <span class="badge badge-success">30元</span> <span class="badge badge-success">50元</span> <span class="badge badge-success">100元</span></div><h5>

                    <ul class="user-meta mt20">
<div id="viptip" class="mb20"></div>							
					<form action="" method="post" onSubmit="return checkFm2();">	
					<li class="col-md-6"><label>充值卡号</label><input type="text" id="epdcardnum"  name="epdcardnum" class="form-control"  required="required" /> </li>
					<li class="col-md-6"><label>充值卡密</label><input type="text" id="epdcardpass" name="epdcardpass" class="form-control" required="required"/></li>
                   
					<div class="col-md-9 mt10">
					<input type="hidden" name="action" value="card"><input  type="submit" value="充值卡充值"  class="btn btn-outline-success" />  <a class="btn btn-info" href="#">淘宝购买充值卡</a></div> 
					</form>
					</ul>
</div>
                <?php }?>

				

</div>
<?php  if($_POST['action'] == 'card'){
		$cardnum = $wpdb->escape($_POST['epdcardnum']);
		$cardpass = $wpdb->escape($_POST['epdcardpass']);
		$result = checkDoCardResult($cardnum,$cardpass);
		echo "<li>";	
		if($result == '5'){
			echo "<script>document.getElementById('viptip').innerHTML='<span class=\'badge badge-danger\' role=\'alert\'>充值卡不存在！</span>';</script>";				
		}elseif($result == '0'){
			echo "<script>document.getElementById('viptip').innerHTML='<span class=\'badge badge-danger\' role=\'alert\'>充值卡已被使用！</span>';</script>";
		}elseif($result == '2'){
			echo "<script>document.getElementById('viptip').innerHTML='<span class=\'badge badge-danger\' role=\'alert\'>充值卡密码错误！</span>';</script>";
		}elseif($result == '1'){
			echo "<script>document.getElementById('viptip').innerHTML='<div class=\'alert alert-success\' role=\'alert\'>充值成功！</div>';</script>";
		}else{
			echo "<script>document.getElementById('viptip').innerHTML='<span class=\'badge badge-danger\' role=\'alert\'>系统错误，请稍后重试！</span>';</script>";
		}
	}elseif($_POST['action'] == 'mycredto'){
		$epdmycrednum = $wpdb->escape($_POST['epdmycrednum']);
		if(floatval(mycred_get_users_cred( $user_info->ID )) < floatval($epdmycrednum*get_option('erphp_to_mycred'))){
			$mycred_core = get_option('mycred_pref_core');
			echo "<script>document.getElementById('viptip').innerHTML='<span class=\'badge badge-danger\' role=\'alert\'>mycred剩余".$mycred_core[name][plural]."不足</span>';</script>";
		}
		else
		{
			mycred_add( '兑换', $user_info->ID, '-'.$epdmycrednum*get_option('erphp_to_mycred'), '兑换扣除%plural%!', date("Y-m-d H:i:s") );
			$money = $epdmycrednum;
			if(addUserMoney($user_info->ID, $money))
			{
				$sql="INSERT INTO $wpdb->icemoney (ice_money,ice_num,ice_user_id,ice_time,ice_success,ice_note,ice_success_time,ice_alipay)
				VALUES ('$money','".date("y").mt_rand(10000000,99999999)."','".$user_info->ID."','".date("Y-m-d H:i:s")."',1,'4','".date("Y-m-d H:i:s")."','')";
				$wpdb->query($sql);
				echo "<script>document.getElementById('viptip').innerHTML='<span class=\'badge badge-success\' role=\'alert\'>兑换成功！</span>';</script>";
			}
			else
			{
				echo "<script>document.getElementById('viptip').innerHTML='<span class=\'badge badge-danger\' role=\'alert\'>兑换失败！</span>';</script>";
			}
		}echo "</li>";
		}?>
</div></div></div><?php 
}?>
<?php if($_GET["item"]=='recharge'){//////充值记录
				$totallists = $wpdb->get_var("SELECT count(*) FROM $wpdb->icemoney WHERE ice_success=1 and ice_user_id=".$user_info->ID);
				$ice_perpage = 10;
				$pages = ceil($totallists / $ice_perpage);
				$page=isset($_GET['pp']) ?intval($_GET['pp']) :1;
				$offset = $ice_perpage*($page-1);
				$lists = $wpdb->get_results("SELECT * FROM $wpdb->icemoney where ice_success=1 and ice_user_id=".$user_info->ID." order by ice_time DESC limit $offset,$ice_perpage");	
				?> 
<div class="tab-pane active show" id="recharge">
<div class="card card-nav-tabs">
<div class="card-header card-header-info text-center">
    充值记录
  </div>
<div class="card-body">
 <table class="table table-hover table-striped">
					<thead>
						<tr>			
                <th width="35%">充值时间</th>
                <th width="25%">充值金额</th>
				<th width="20%">充值方式</th>
                
						</tr>
					</thead>
					<tbody>
						<?php
							if($lists) {
								foreach($lists as $value)
								{
									echo "<tr>\n";
									echo "<td>$value->ice_time</td>";
									echo "<td>$value->ice_money</td>\n";
									if(intval($value->ice_note)==0)
									{
										echo "<td>在线充值</td>\n";
									}elseif(intval($value->ice_note)==1)
									{
										echo "<td>后台充值</td>\n";
									}
									elseif(intval($value->ice_note)==2)
									{
										echo "<td>转账收</td>\n";
									}
									elseif(intval($value->ice_note)==3)
									{
										echo "<td>转账付</td>\n";
									}
									elseif(intval($value->ice_note)==6)
					               {
						            echo "<td>充值卡</td>\n";
					                }								
									
									echo "</tr>";
								}
							}
							else
							{
								echo '<tr width=100%><td colspan="3" align="center"><center><strong>没有记录！</strong></center></td></tr>';
							}
						?>
					</tbody>
				</table>
				<?php mobantu_paging('recharge',$page,$pages);?>

</div></div></div> <?php //充值记录结束  
}?>
 <?php if($_GET["item"]=='pass'){/////修改密码?>
<div class="tab-pane active show" id="pass">
<div class="card card-nav-tabs">
<div class="card-header card-header-info text-center">
    修改密码
  </div>
<div class="card-body">

<div id="changepass">
				<div class="alert alert-success">为了确保安全，密码最好是由“字母+字符+数字”组成！</div>
				<div class="profile-form  col-sm-8">
					<form action="" method="post">
                    <dl class="dl-horizontal">
						<dt><label class="pt10">用户名</label></dt> 
						<dd>
							<input type="text" id="mm_username" name="log" value="<?php echo esc_attr( $profileuser->user_login ); ?>" class="form-control" disabled>
						</dd>
					</dl>
					<dl class="dl-horizontal">
						<dt><label class="pt10">新密码</label></dt>
						<dd>
							<input type="password" id="mm_pass_new" name="mm_pass_new" value="" class="form-control">
						</dd>
					</dl>
					<dl class="dl-horizontal">
						<dt><label class="pt10">重复密码</label></dt>
						<dd>
							<input type="password" id="mm_pass_new2" name="mm_pass_new2" value="" class="form-control">
						</dd>
					</dl>
					<dl class="dl-horizontal">
						<dt><div id="tip1" class="pt10"></div></dt>
						<dd>
							<input type="button" id="dopassword" value="保存修改" class="btn btn-outline-danger" /><div id="result"></div>
						</dd>
					</dl>
					</form>
				</div>
			</div>
<script type="text/javascript">
				jQuery(document).ready(function($){
				
					$("#dopassword").click(function(){ 
						if($("#mm_pass_new").val().trim().length==0)
						{
							$("#tip1").html("<span class=\"badge badge-danger\">请输入新密码</span>");
						}
						else if(strlen($("#mm_pass_new").val().trim())<6)
						{
							$("#tip1").html("<span class=\"badge badge-danger\">密码长度至少为6位</span>");
						}
						else if($("#mm_pass_new2").val().trim() != $("#mm_pass_new").val().trim())
						{
							$("#tip1").html("<span class=\"badge badge-danger\">两次密码不一致</span>");
						}
						else
						{
							$('#result').html('<img src="<?php bloginfo('template_url'); ?>/assets/images/loader.gif" class="loader" />').fadeIn();
							$.ajax({
								type: "post",
								//async: false,
								url: "<?php echo get_template_directory_uri() ?>/actions/ajax-profile.php",
								data: "do=password&mm_usrname="+$("#mm_usrname").val()+"&mm_pass_old=" + $("#mm_pass_old").val() + "&mm_pass_new=" + $("#mm_pass_new").val() + "&mm_pass_new2=" + $("#mm_pass_new2").val(),
								//contentType: "application/json; charset=utf-8",
								dataType: "text",
								success: function (data) {
									$('.loader').remove();
									$("#tip1").html("<span class=\"badge badge-success\">密码修改成功</span>");
									//alert(data);
								},
								error: function () {
                                $('.loader').remove();
								$("#tip1").html("<span class=\"badge badge-danger\">密码修改失败</span>");
								}
							});
						}
					});
				
				
				});
			</script>

</div></div></div>		 <?php } //修改密码?>			 
					 
					 
					 
					 
					 
					 
					 
					 
					 
					 
					 </div>
               





			   </div><!---------tab-content 框--------->  
				




 <!--container---></div> 
 <!--profile-content---></div> 
    <!--main---></div> 
 
 <div class="modal fade" id="tipsnode" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">提醒</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="tip1"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>
 
 
 
 
 
 
 



 <script type="text/javascript">
	function strlen(str){
		var len = 0;
		for (var i=0; i<str.length; i++){
			var c = str.charCodeAt(i);
			if ((c >= 0x0001 && c <= 0x007e) || (0xff60<=c && c<=0xff9f)) {
				len++;
			}else {
				len+=2;
			}
		} 
		return len;
	}
</script>
<?php get_footer(); ?>
<?php //结束  
}?>