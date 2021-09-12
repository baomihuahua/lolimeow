<?php 
/*
 * Template Name: Boxmoe会员中心
*/
get_header();?>
<?php 
if(!is_user_logged_in()){echo "<script>window.location.href='".wp_login_url()."';</script>";}?>
<?php 
if(is_user_logged_in()) {

get_header();
global $wpdb, $erphpdown_version;
$user_info=wp_get_current_user();
$erphp_life_name    = get_option('erphp_life_name')?get_option('erphp_life_name'):'终身VIP';
$erphp_year_name    = get_option('erphp_year_name')?get_option('erphp_year_name'):'包年VIP';
$erphp_quarter_name = get_option('erphp_quarter_name')?get_option('erphp_quarter_name'):'包季VIP';
$erphp_month_name  = get_option('erphp_month_name')?get_option('erphp_month_name'):'包月VIP';
$erphp_day_name  = get_option('erphp_day_name')?get_option('erphp_day_name'):'体验VIP';
function mobantu_paging($type,$paged,$max_page) {
	if ( $max_page <= 1 ) return;
	if ( empty( $paged ) ) $paged = 1;
	echo '<nav aria-label="Page navigation example"><ul class="pagination pagination-info">';
	echo '<li class="page-item"><a class="page-link" href="?items=$type&pp=1">首页</a></li>';
	if($paged > 1) {
		echo '<li class="page-item"><a class="page-link" href="?items='.$type.'&pp='.($paged-1).'" aria-label="Previous"><i class="fa fa-angle-left"></i><span class="sr-only">Previous</span></a></li>';
	}
	if ( $paged > 2 ) echo "<li><span> ... </span></li>";
	for ( $i = $paged - 1; $i <= $paged + 3; $i++ ) {
		if ( $i > 0 && $i <= $max_page ) {
			if($i == $paged) 
							print "<li class=\"page-item active\"><a class=\"page-link\">{$i}</a></li>"; else
							print "<li class=\"page-item\"><a class=\"page-link\" href='?items=$type&pp={$i}'><span>{$i}</span></a></li>";
		}
	}
	if ( $paged < $max_page - 3 ) echo "<li><span> ... </span></li>";
	if($paged < $max_page) {
		echo '<li class="page-item"><a class="page-link" href="?items='.$type.'&pp='.($paged+1).'" aria-label="Next"><i class="fa fa-angle-right"></i><span class="sr-only">Next</span></a></li>';
	}
	echo '<li class="page-item"><a class="page-link" href="?items=$type&pp=$max_page">尾页</a></li>';
	echo '</ul></div>';
}
if(isset($_POST['ice_alipay'])) {
	$fee=get_option("ice_ali_money_site");
	$fee=isset($fee) ?$fee :100;
	$userMoney=$wpdb->get_row("select * from ".$wpdb->iceinfo." where ice_user_id=".$user_info->ID);
	/////////////////////////////////////////////////www.mobantu.com   82708210@qq.com
	if(!$userMoney) {
		$okMoney=0;
	} else {
		$okMoney=$userMoney->ice_have_money - $userMoney->ice_get_money;
	}
	$ice_alipay = $wpdb->escape($_POST['ice_alipay']);
	$ice_name   = $wpdb->escape($_POST['ice_name']);
	$ice_money  = isset($_POST['ice_money']) && is_numeric($_POST['ice_money']) ?$_POST['ice_money'] :0;
	$ice_money = $wpdb->escape($ice_money);
	if($ice_money<get_option('ice_ali_money_limit')) {
		echo '<div class="alert"><p>提现金额至少得满'.get_option('ice_ali_money_limit').get_option('ice_name_alipay').'</p></div>';
	} elseif(empty($ice_name) || empty($ice_alipay)) {
		echo '<div class="alert"><p>请输入支付宝帐号和姓名</p></div>';
	} elseif($ice_money > $okMoney) {
		echo '<div class="alert"><p>提现金额大于可提现金额'.$okMoney.'</p></div>';
	} else {
		$sql="insert into ".$wpdb->iceget."(ice_money,ice_user_id,ice_time,ice_success,ice_success_time,ice_note,ice_name,ice_alipay)values
			('".$ice_money."','".$user_info->ID."','".date("Y-m-d H:i:s")."',0,'".date("Y-m-d H:i:s")."','','$ice_name','$ice_alipay')";
		if($wpdb->query($sql)) {
			addUserMoney($user_info->ID, '-'.$ice_money);
			echo '<div class="alert"><p>申请成功，等待管理员处理！</p></div>';
		} else {
			echo '<div class="alert"><p>系统错误，请稍后重试！</p></div>';
		}
	}
}
if(isset($_POST['paytype'])) {
	$paytype=intval($_POST['paytype']);
	$doo = 1;
	if(isset($_POST['paytype']) && $paytype==1) {
		$url=constant("erphpdown")."payment/alipay.php?ice_money=".esc_sql($_POST['ice_money']);
	} elseif(isset($_POST['paytype']) && $paytype==5) {
		$url=constant("erphpdown")."payment/f2fpay.php?ice_money=".esc_sql($_POST['ice_money']);
	} elseif(isset($_POST['paytype']) && $paytype==4) {
		if(erphpdown_is_weixin() && get_option('ice_weixin_app')) {
			$url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.get_option('ice_weixin_appid').'&redirect_uri='.urlencode(constant("erphpdown")).'payment%2Fweixin.php%3Fice_money%3D'.esc_sql($_POST['ice_money']).'&response_type=code&scope=snsapi_base&state=STATE&connect_redirect=1#wechat_redirect';
		} else {
			$url=constant("erphpdown")."payment/weixin.php?ice_money=".esc_sql($_POST['ice_money']);
		}
	} elseif(isset($_POST['paytype']) && $paytype==7) {
		$url=constant("erphpdown")."payment/paypy.php?ice_money=".esc_sql($_POST['ice_money']);
	} elseif(isset($_POST['paytype']) && $paytype==8) {
		$url=constant("erphpdown")."payment/paypy.php?ice_money=".esc_sql($_POST['ice_money'])."&type=alipay";
	} elseif(isset($_POST['paytype']) && $paytype==2) {
		$url=constant("erphpdown")."payment/paypal.php?ice_money=".esc_sql($_POST['ice_money']);
	} elseif(isset($_POST['paytype']) && $paytype==18) {
		$url=constant("erphpdown")."payment/xhpay3.php?ice_money=".esc_sql($_POST['ice_money'])."&type=2";
	} elseif(isset($_POST['paytype']) && $paytype==17) {
		$url=constant("erphpdown")."payment/xhpay3.php?ice_money=".esc_sql($_POST['ice_money'])."&type=1";
	} elseif(isset($_POST['paytype']) && $paytype==13) {
		$url=constant("erphpdown")."payment/codepay.php?ice_money=".esc_sql($_POST['ice_money'])."&type=1";
	} elseif(isset($_POST['paytype']) && $paytype==14) {
		$url=constant("erphpdown")."payment/codepay.php?ice_money=".esc_sql($_POST['ice_money'])."&type=3";
	} elseif(isset($_POST['paytype']) && $paytype==15) {
		$url=constant("erphpdown")."payment/codepay.php?ice_money=".esc_sql($_POST['ice_money'])."&type=2";
	} else {
	}
	if($doo) echo "<script>location.href='".$url."'</script>";
	exit;
}
if(isset($_POST['userType'])) {
	$userType=isset($_POST['userType']) && is_numeric($_POST['userType']) ?intval($_POST['userType']) :0;
	if($userType >5 && $userType < 11) {
		$okMoney=erphpGetUserOkMoney();
		$priceArr=array('6'=>'ciphp_day_price','7'=>'ciphp_month_price','8'=>'ciphp_quarter_price','9'=>'ciphp_year_price','10'=>'ciphp_life_price');
		$priceType=$priceArr[$userType];
		$price=get_option($priceType);
		if(!$price) {
			echo "<script>Swal.fire('Oops...', '此类型的会员价格错误，请稍候重试！', 'error'); </script>";
		} elseif($okMoney < $price) {
			echo "<script>Swal.fire('Oops...', '当前可用余额不足完成此次交易！', 'error');</script>";
		} elseif($okMoney >=$price) {
			if(erphpSetUserMoneyXiaoFei($price)) {
				if(userPayMemberSetData($userType)) {
					addVipLog($price, $userType);
					$RefMoney=$wpdb->get_row("select * from ".$wpdb->users." where ID=".$user_info->ID);
					if($RefMoney->father_id > 0) {
						addUserMoney($RefMoney->father_id,$price*get_option('ice_ali_money_ref')*0.01);
					}
				} else {
					echo "<script>Swal.fire('Oops...', '系统发生错误，请联系管理员！', 'error');  </script>";
				}
			} else {
				echo "<script>Swal.fire('Oops...', '系统发生错误，请稍候重试！', 'error'); </script>";
			}
		} else {
			echo "<script>Swal.fire('Oops...', '未定义的操作！', 'error'); </script>";
		}
	} else {
		echo "<script>Swal.fire('Oops...', '会员类型错误！', 'error')</script>";
	}
}
if($_POST['action'] == 'card') {
	$cardnum = $wpdb->escape($_POST['epdcardnum']);
	$cardpass = $wpdb->escape($_POST['epdcardpass']);
	$result = checkDoCardResult($cardnum,$cardpass);
	if($result == '5') {
		echo "<script>Swal.fire('Oops...', '充值卡不存在！', 'error');</script>";
	} elseif($result == '0') {
		echo "<script>Swal.fire('Oops...', '充值卡已被使用！', 'error');</script>";
	} elseif($result == '2') {
		echo "<script>Swal.fire('Oops...', '充值卡密码错误！', 'error');</script>";
	} elseif($result == '1') {
		echo "<script>Swal.fire('恭喜','充值成功！', 'success');</script>";
	} else {
		echo "<script>Swal.fire('Oops...', '系统错误，请稍后重试！', 'error');</script>";
	}
} elseif($_POST['action'] == 'mycredto') {
	$epdmycrednum = $wpdb->escape($_POST['epdmycrednum']);
	if(is_numeric($epdmycrednum) && $epdmycrednum > 0 && get_option('erphp_mycred') == 'yes') {
		if(floatval(mycred_get_users_cred( $user_info->ID )) < floatval($epdmycrednum*get_option('erphp_to_mycred'))) {
			$mycred_core = get_option('mycred_pref_core');
			echo "<script>alert('mycred剩余".$mycred_core['name']['plural']."不足！');</script>";
		} else {
			mycred_add( '兑换', $user_info->ID, '-'.$epdmycrednum*get_option('erphp_to_mycred'), '兑换扣除%plural%!', date("Y-m-d H:i:s") );
			$money = $epdmycrednum;
			if(addUserMoney($user_info->ID, $money)) {
				$sql="INSERT INTO $wpdb->icemoney (ice_money,ice_num,ice_user_id,ice_time,ice_success,ice_note,ice_success_time,ice_alipay)
				VALUES ('$money','".date("ymdhis").mt_rand(10000,99999)."','".$user_info->ID."','".date("Y-m-d H:i:s")."',1,'4','".date("Y-m-d H:i:s")."','')";
				$wpdb->query($sql);
				echo "<script>Swal.fire('恭喜','兑换成功！', 'success');</script>";
			} else {
				echo "<script>Swal.fire('Oops...','兑换失败！', 'error');</script>";
			}
		}
	}
}
//会员设定

    $ciphp_year_price    = get_option('ciphp_year_price');
	$ciphp_quarter_price = get_option('ciphp_quarter_price');
	$ciphp_month_price  = get_option('ciphp_month_price');
	$ciphp_life_price  = get_option('ciphp_life_price');
	$ciphp_day_price  = get_option('ciphp_day_price');

function boxmoe_vip_pic() {	
	$userTypeId=getUsreMemberType();
	if($userTypeId==6) {
		echo ''.$erphp_day_name;
	} elseif($userTypeId==7) {
		echo ''.$erphp_month_name.'<img src="'.boxmoe_load_style().'/assets/images/vip/v2.jpg">';
	} elseif ($userTypeId==8) {
		echo ''.$erphp_quarter_name.'<img src="'.boxmoe_load_style().'/assets/images/vip/v3.jpg">';
	} elseif ($userTypeId==9) {
		echo ''.$erphp_year_name.'<img src="'.boxmoe_load_style().'/assets/images/vip/v4.jpg">';
	} elseif ($userTypeId==10) {
		echo ''.$erphp_life_name.'<img src="'.boxmoe_load_style().'/assets/images/vip/v5.jpg">';
	} else {
		echo '普通会员<img src="'.boxmoe_load_style().'/assets/images/vip/v1.jpg">';
	}
	}
//积分设定
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
<?php if(function_exists( 'mobantu_erphp_menu' )  ) {?>
<link rel='stylesheet' href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.min.css" type='text/css' media='all' />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.min.js"></script>
      <div class="boxmoe-user-page mb30">
        <div class="container">
          <div class="section-head">
            <span>User</span></div>
          <div class="row boxmoe-user-page mt20">
            <div class="col-lg-12 col-md-12">
			<nav class="navbar navbar-expand-lg navbar-dark bg-gradient-dark z-index-3 py-3 blog-card mb-4">
  <div class="container">
    <a class="navbar-brand text-white"  rel="tooltip" title="Designed and Coded by Creative Tim" data-placement="bottom" target="_blank">
      会员中心
    </a>
    <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#usernavigation" aria-controls="usernavigation" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon mt-2">
        <span class="navbar-toggler-bar bar1"></span>
        <span class="navbar-toggler-bar bar2"></span>
        <span class="navbar-toggler-bar bar3"></span>
      </span>
    </button>
    <div class="collapse navbar-collapse w-100 pt-3 pb-2 py-lg-0" id="usernavigation">
      <ul class="navbar-nav navbar-nav-hover mx-auto">
                      <li class="nav-item mx-2 <?php if($_GET["items"]=='info' || !isset($_GET["items"])) {?>active<?php }?>">
                        <a class="nav-link" href="?items=info"><i class="fa fa-home"></i>个人信息</a></li>
                      <li class="nav-item mx-2 <?php if($_GET["items"]=='order') {?>active<?php }?>">
                        <a class="nav-link" href="?items=order"><i class="fa fa-database"></i>订单管理</a></li>
                      <li class="nav-item mx-2 <?php if($_GET["items"]=='vip') {?>active<?php }?>">
                        <a class="nav-link" href="?items=vip"><i class="fa fa-line-chart"></i>会员升级</a></li>
                      <li class="nav-item mx-2 <?php if($_GET["items"]=='money') {?>active<?php }?>">
                        <a class="nav-link" href="?items=money"><i class="fa fa-credit-card"></i>积分管理</a></li>
                      <li class="nav-item mx-2 <?php if($_GET["items"]=='recharge') {?>active<?php }?>">
                        <a class="nav-link" href="?items=recharge"><i class="fa fa-won"></i>充值记录</a></li>
                      <li class="nav-item mx-2 <?php if($_GET["items"]=='pass') {?>active<?php }?>">
                        <a class="nav-link" href="?items=pass"><i class="fa fa-keyboard-o"></i>修改密码</a></li>
                      <li class="nav-item mx-2">
                        <a class="nav-link" href="<?php echo wp_logout_url(home_url());?>"><i class="fa fa-sign-out"></i>安全退出</a></li>
      </ul>
    </div>
  </div>
</nav>
            </div>
            <div class="col-lg-12 col-md-12">
              <div class="user-info card blog-card ">
			  
			  
			<?php if($_GET["items"]=='info' || !isset($_GET["items"])) {?>			  
			  
			  
                <div class="card-header card-header-warning text-center">个人信息</div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-4 col-md-4">
                      <div class="user-header card card-profile">
                        <div class="card-header bg-info" style="background-image: url('<?php echo get_boxmoe('user_banner_src')?>')">
                          <div class="card-avatar">
                            <a href="javascript:;">
                              <?php echo get_avatar( $user_info->user_email, 100,'','',array('class'=>array('rounded-circle'))); ?> </a>
                          </div>
                        </div>
                        <div class="card-body pt-0">
                          <div class="d-flex justify-content-between">
                            <a href="?items=money" class="btn btn-sm btn-info mr-4 mt-3">充值</a>
							<?php if(get_option('ice_ali_money_checkin')) {if(erphpdown_check_checkin($user_info->ID)) {
                            echo '<a href="javascript:;" class="btn btn-sm btn-default float-right mt-3">已签到</a>';} else {
							echo '<a href="javascript:;" class="erphp-checkin btn btn-sm btn-default float-right mt-3">签到</a>';}	}?>
							</div>
                          <div class="row">
                            <div class="col">
                              <div class="card-profile-stats d-flex justify-content-center mb-2">
							  <span class="badge bg-gradient-primary">
							  余额：<?php echo $okMoney?>
							  </span>
							  <span class="badge bg-gradient-primary">
							  消费：<?php echo intval($userMoney->ice_get_money)?>
							  </span>
							  <span class="badge bg-gradient-primary">
							  评论：<?php global $user_ID;echo get_comments('count=true&user_id='.$user_ID);?>
							  </span>
                              </div>
                            </div>
                          </div>
                          <p class="control-label userinfo card-text">登陆用户：<?php echo esc_attr($user_info->user_login ); ?></p>
                          <p class="control-label userinfo card-text">会员等级：<?php boxmoe_vip_pic()?></p>
						  <p class="control-label userinfo card-text">到期时间：<?php $userTypeId=getUsreMemberType(); if($userTypeId>0 && $userTypeId<11){echo getUsreMemberTypeEndTime() ;}else{echo '当前未购买会员服务';}?></p>
                          <p class="control-label userinfo card-text">注册时间：<?php echo esc_attr( $user_info->user_registered ) ?></p>
                          <p class="control-label userinfo card-text">最近登录：<?php echo esc_attr( $user_info->last_login ) ?></p></div>
                      </div>
                    </div>
                    <div class="col-lg-8 col-md-8">
                      <form action="" method="post" class="mb20 mt20">
                        <div class="row">
                          <div class="col-md-9">
                            <div class="form-group">
                              <label class="control-label ">帐户邮箱：</label>
                              <input type="text" class="form-control" id="mm_mail" name="mm_mail" value="<?php echo esc_attr( $current_user->user_email ) ?>"></div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-9">
                            <div class="form-group">
                              <label class="control-label">会员昵称：</label>
                              <input type="text" class="form-control" id="mm_name" name="mm_name" value="<?php echo esc_attr( $current_user->nickname ) ?>"></div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-9">
                            <div class="form-group">
                              <label class="control-label">会员网站：</label>
                              <input type="text" class="form-control" id="mm_url" name="mm_url" value="<?php echo esc_attr( $current_user->user_url ) ?>"></div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="control-label">会员简介：</label>
                              <textarea rows="4" class="form-control forminput" id="mm_desc" name="mm_desc"><?php echo esc_html( $current_user->description ); ?></textarea>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12 text-center">
                            <button class="btn btn-outline-default" id="doprofile" type="button">保存</button>
							<div class="mt10" id="result"></div></div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
				<script type="text/javascript">
    $("#doprofile").click(function(event) {
        var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/;
        if ($("#mm_name").val().trim().length == 0) {
            $('#tipsnode').modal();
            $("#tip1").html("<span class=\"badge badge-danger\">请输入昵称</span>");
        } else if (strlen($("#mm_name").val().trim()) < 4) {
            $('#tipsnode').modal();
            $("#tip1").html("<span class=\"badge badge-danger\">昵称长度至少为4位</span>");
        } else if (!reg.test($("#mm_mail").val().trim())) {
            $('#tipsnode').modal();
            $("#tip1").html("<span class=\"badge badge-danger\">法请输入正确邮箱，以免忘记密码时无找回</span>");
        } else {
            $("#doprofile").val("保存中...");
            $('#result').html('<img src="<?php echo boxmoe_load_style(); ?>/assets/images/loader.gif" class="loader" />').fadeIn();
            $.ajax({
                type: "post",
                //async: false,
                url: "<?php echo ERPHPDOWN_URL; ?>/admin/action/ajax-profile.php",
                data: "do=profile&mm_name=" + $("#mm_name").val() + "&mm_mail=" + $("#mm_mail").val() + "&mm_url=" + $("#mm_url").val() + "&mm_desc=" + $("#mm_desc").val(),
                //contentType: "application/json; charset=utf-8",
                dataType: "text",
                success: function(data) {
                    $('.loader').remove();
					Swal.fire('恭喜','恭喜！修改信息成功', 'success');
                    $("#doprofile").val("保存");
                },
                error: function() {
                    $('.loader').remove();
					Swal.fire('Oops...','抱歉！修改失败！', 'error');
                    $("#doprofile").val("保存");
                }
            });
        }
    });
	</script>
				<?php } ?>
<?php  if ($_GET["items"]=='order') {
	$total_trade   = $wpdb->get_var("SELECT COUNT(ice_id) FROM $wpdb->icealipay WHERE ice_success>0 and ice_user_id=".$user_info->ID);
	$ice_perpage = 10;
	$pages = ceil($total_trade / $ice_perpage);
	$page=isset($_GET['pp']) ?intval($_GET['pp']) :1;
	$offset = $ice_perpage*($page-1);
	$list = $wpdb->get_results("SELECT * FROM $wpdb->icealipay where ice_success=1 and ice_user_id=$user_info->ID order by ice_time DESC limit $offset,$ice_perpage");
	?>				
    <div class="card-header card-header-warning text-center">订单管理</div>
    <div class="card-body">
    <div class="row">
    <div class="col-lg-12 col-md-12">
    <table class="table table-hover table-striped">
      <thead>
        <tr>
          <th width="15%">订单号</th>
          <th width="35%">商品名称</th>
          <th width="10%">价格</th>
          <th width="25%">交易时间</th>
          <th width="15%">下载信息</th></tr>
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
	<?php mobantu_paging('order',$page,$pages);?>	  
                    </div>
                   
                  </div>
                </div>
              </div>
           	
	<?php } ?>			
				
<?php if($_GET["items"]=='vip'){ 
	$totallists = $wpdb->get_var("SELECT COUNT(ice_id) FROM $wpdb->vip where ice_user_id=".$user_info->ID);
	$ice_perpage = 10;
	$pages = ceil($totallists / $ice_perpage);
	$page=isset($_GET['pp']) ?intval($_GET['pp']) :1;
	$offset = $ice_perpage*($page-1);
	$lists = $wpdb->get_results("SELECT * FROM $wpdb->vip where ice_user_id=".$user_info->ID." order by ice_time DESC limit $offset,$ice_perpage");
	?>					
    <div class="card-header card-header-warning text-center">会员升级</div>
    <div class="card-body">
    <div class="row">
    <div class="col-lg-12 col-md-12">
          <ul class="list-group list-group-flush list my--3 ">
            <li class="list-group-item">
              <div class="row align-items-center">
                <div class="col-auto">
                  <!-- Avatar -->
                  <div class="avatar rounded-circle">
				  <?php echo get_avatar( $user_info->user_email, 50,'','',array('class'=>array(''))); ?> 
                </div>
                </div>
                <div class="col ml--2">
                  <h4 class="mb-0">
                    <span><?php echo esc_attr($user_info->user_login ); ?></span>
                    <small class="vipcol">账户余额：<?php echo $okMoney?>&nbsp;<?php echo get_option('ice_name_alipay');?></small></h4>
                  <span class="text-success">●</span>
                  <small class="vipcoll">当前会员等级：<?php boxmoe_vip_pic()?>&nbsp;&nbsp;<?php $userTypeId=getUsreMemberType(); echo ($userTypeId>0 && $userTypeId<10) ?'到期时间：'.getUsreMemberTypeEndTime() :''?></small></div>
                <div class="col-auto">
                  <a href="?items=addmoney" class="btn btn-sm btn-success">充值</a></div>
              </div>
            </li>
          </ul>
<form action="" method="post" class="thw-sept">
            <ul class="list-group list-group-flush" data-toggle="checklist">
              <?php if($ciphp_life_price){?><li class="checklist-entry list-group-item flex-column align-items-start">
                <div class="checklist-item checklist-item-purple">
                  <div class="checklist-purple">
                    <h5 class="checklist-title mb-0">
                      <span class="text-purple">
                        <strong>&nbsp;终身会员&nbsp;（<?php echo $ciphp_life_price.get_option('ice_name_alipay')?> ）</strong></span>
                    </h5>
                    <small>
                      <img src="<?php echo boxmoe_load_style()?>/assets/images/vip/v5.jpg"></small>
                  </div>
                  <div>
                    <div class="form-check custom-checkbox-purple">
                      <input class="form-check-input" name="userType" id="userType10" type="radio" value="10" checked>
                      <label class="custom-control-label" for="userType10"></label>
                    </div>
                  </div>
                </div>
              </li><?php }?>
              <?php if($ciphp_year_price){?><li class="checklist-entry list-group-item flex-column align-items-start">
                <div class="checklist-item checklist-item-danger">
                  <div class="checklist-danger">
                    <h5 class="checklist-title mb-0">
                      <span class="text-danger">
                        <strong>&nbsp;年付会员&nbsp;（<?php echo $ciphp_year_price.get_option('ice_name_alipay')?> ）</strong></span>
                    </h5>
                    <small>
                      <img src="<?php echo boxmoe_load_style()?>/assets/images/vip/v4.jpg"></small>
                  </div>
                  <div>
                    <div class="form-check custom-checkbox-danger">
                      <input class="form-check-input" name="userType" id="userType9"value="9" type="radio">
                      <label class="custom-control-label" for="userType9"></label>
                    </div>
                  </div>
                </div>
              </li><?php }?>
               <?php if($ciphp_quarter_price){?><li class="checklist-entry list-group-item flex-column align-items-start">
                <div class="checklist-item checklist-item-warning">
                  <div class="checklist-warning">
                    <h5 class="checklist-title mb-0">
                      <span class="text-warning">
                        <strong>&nbsp;季付会员&nbsp;（<?php echo $ciphp_quarter_price.get_option('ice_name_alipay')?> ）</strong></span>
                    </h5>
                    <small>
                      <img src="<?php echo boxmoe_load_style()?>/assets/images/vip/v3.jpg"></small>
                  </div>
                  <div>
                    <div class="form-check custom-checkbox-warning">
                      <input class="form-check-input" name="userType" id="userType8" value="8" type="radio">
                      <label class="custom-control-label" for="userType8"></label>
                    </div>
                  </div>
                </div>
              </li><?php }?>
              <?php if($ciphp_month_price){?><li class="checklist-entry list-group-item flex-column align-items-start">
                <div class="checklist-item checklist-item-golden">
                  <div class="checklist-golden">
                    <h5 class="checklist-title mb-0">
                      <span class="text-golden">
                        <strong>&nbsp;月付会员&nbsp;（<?php echo $ciphp_month_price.get_option('ice_name_alipay')?> ）</strong></span> 
                    </h5>
                    <small>
                      <img src="<?php echo boxmoe_load_style()?>/assets/images/vip/v2.jpg"></small>
                  </div>
                  <div>
                    <div class="form-check custom-checkbox-golden">
                      <input class="form-check-input" name="userType" id="userType7" value="7" type="radio">
                      <label class="custom-control-label" for="userType7"></label>
                    </div>
                  </div>
                </div>
              </li><?php }?>
            </ul><div class="row">
                          <div class="col-md-12 text-center">
            <input type="submit" name="Submit" value="升级会员" style="text-center" class="btn btn-outline-danger mt20 mb20" onClick="return confirm('确认升级会员?');" />
          </form> </div> </div>
                    </div>
                   
                  </div>
                </div>
              </div>				

	<?php } ?>	
<?php if($_GET["items"]=='money'){ /////////////////充值?>	
    <div class="card-header card-header-warning text-center">积分管理</div>
    <div class="card-body">
    <div class="row">
    <div class="col-lg-12 col-md-12">
 <ul class="list-group list-group-flush list my--3 ">
            <li class="list-group-item">
              <div class="row align-items-center">
                <div class="col-auto">
                  <!-- Avatar -->
                  <div class="avatar rounded-circle">
				  <?php echo get_avatar( $user_info->user_email, 50,'','',array('class'=>array(''))); ?> 
                </div>
                </div>
                <div class="col ml--2">
                  <h4 class="mb-0">
                    <span><?php echo esc_attr($user_info->user_login ); ?></span>
					<small class="vipcoll">&nbsp;&nbsp;&nbsp;消费<?php echo get_option('ice_name_alipay');?>：<?php echo intval($userMoney->ice_get_money)?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;剩余<?php echo get_option('ice_name_alipay');?>：<?php echo $okMoney?></small>
                    </h4>
                  <span class="text-success">●</span>
                  <small class="vipcoll">当前会员等级：<?php boxmoe_vip_pic()?>&nbsp;&nbsp;<?php $userTypeId=getUsreMemberType(); echo ($userTypeId>0 && $userTypeId<10) ?'到期时间：'.getUsreMemberTypeEndTime() :''?></small>
				  </div>
              </div>
            </li>
          </ul>		  
<div class="row thw-sept">
<script type="text/javascript">
					function checkFm(){
						if(document.getElementById("ice_money").value=="")
						{
							alert('请输入金额');
							return false;
						}
					}
					function checkFm2(){
						if(document.getElementById("epdcardnum").value=="")
						{
							alert('请输入金额');
							return false;
						}
					}
					function checkFm3(){
						if(document.getElementById("epdmycrednum").value=="")
						{
							alert('请输入兑换的金额');
							return false;
						}
					}
					</script>			
<div class="col-md-12">
 <div class="checklist-item checklist-item-success">
                    <div class="checklist-info">
                      <h5 class="checklist-title mb-0">在线充值</h5>
                      <small>充值说明：<span class="badge badge-warning">1 元 = <?php echo get_option('ice_proportion_alipay').' '.get_option('ice_name_alipay')?></span>请根据需求充值</small>
                    </div>
 </div>
                <form action="" method="post" onsubmit="return checkFm();">
                        <table class="form-table">
                            <tbody><tr>
                				<td>
								<div class="col-md-12 mt10 mb10">
                				<input type="text" id="ice_money" name="ice_money" class="form-control" placeholder="请输入一个整数金额" required="required">
                				</div>
								<?php if(get_option('ice_weixin_mchid')){?> 
								<div class="form-check">
								<input type="radio" id="paytype4" name="paytype"  value="4" class="form-check-input">
								<label class="custom-control-label" for="paytype4">微信</label>
								</div>
                                <?php }?>
                                <?php if(get_option('ice_ali_partner')){?> 
								<div class="form-check">
								<input type="radio" id="paytype1" name="paytype"  value="1" class="form-check-input">
								<label class="custom-control-label" for="paytype1">支付宝</label>
								</div>
                                <?php }?>
                                <?php if(get_option('erphpdown_f2fpay_id')){?> 
								<div class="form-check">
								<input type="radio" id="paytype5" name="paytype"  value="5" class="form-check-input" >
								<label class="custom-control-label" for="paytype5">支付宝</label>
								</div>
								<?php }?>
								<?php if(get_option('erphpdown_xhpay_appid31')){?>
								<div class="form-check">
								<input type="radio" id="paytype18" name="paytype" value="18" class="form-check-input">
								<label class="custom-control-label" for="paytype18">微信</label>
								</div>   
								<?php }?>
								<?php if(get_option('erphpdown_xhpay_appid32')){?>
								<div class="form-check">
								<input type="radio" id="paytype17" name="paytype" value="17" class="form-check-input">
								<label class="custom-control-label" for="paytype17">支付宝</label>
								</div>      
								<?php }?>
				                <?php if(get_option('erphpdown_codepay_appid')){?>
								<div class="form-check">
								<input type="radio" id="paytype13" name="paytype" value="13" class="form-check-input">
								<label class="custom-control-label" for="paytype13"checked>支付宝</label>
								</div>
								<div class="form-check">
								<input type="radio" id="paytype14" name="paytype" value="14" class="form-check-input">
								<label class="custom-control-label" for="paytype14" >微信</label>
								</div>
								<div class="form-check">
								<input type="radio" id="paytype15" name="paytype" value="15" class="form-check-input">
								<label class="custom-control-label" for="paytype15">QQ钱包</label>
								</div>   
				                <?php }?>
				                <?php if(get_option('erphpdown_paypy_key')){?> 
									<?php if(!get_option('erphpdown_paypy_wxpay')){?>
								<div class="form-check">
								<input type="radio" id="paytype7" name="paytype"  value="7" class="form-check-input">
								<label class="custom-control-label" for="paytype7">微信</label>
								</div>
									<?php }?>    
									<?php if(!get_option('erphpdown_paypy_alipay')){?>
									<div class="form-check">
								<input type="radio" id="paytype8" name="paytype"  value="8" class="form-check-input">
								<label class="custom-control-label" for="paytype8">支付宝</label>
								</div> 
								<?php }?> 
								<?php }?> 
                                <?php if(get_option('ice_payapl_api_uid')){?>
								<div class="form-check">
								<input type="radio" id="paytype2" name="paytype"  value="2" class="form-check-input">
								<label class="custom-control-label" for="paytype2">PayPal($美元)汇率：
                                 (<?php echo get_option('ice_payapl_api_rmb')?>)</label>
								</div> 								
                                 <?php }?> 
							 </td>
                            </tr>

                    </tbody></table>
                        <br> 
                        <table> <tbody><tr>
                        <td><p class="submit">
                            <input type="submit" name="Submit" value="在线充值" class="btn btn-outline-success">
                            </p>
                        </td>
                
                        </tr> 
                        
                        </tbody></table>
                
               </form> 
			   </div>
 <?php if(function_exists("checkDoCardResult")){?>			   
 <div class="col-md-12 mb30 mt30">
 <div class="checklist-item checklist-item-success">
                    <div class="checklist-info">
                      <h5 class="checklist-title mb-0">充值卡充值</h5>
                      <small>充值说明：<span class="badge badge-warning">1 元 = <?php echo get_option('ice_proportion_alipay').' '.get_option('ice_name_alipay')?></span>请根据需求充值，充值卡密金额分别为<span class="badge badge-success">10元</span> <span class="badge badge-success">30元</span> <span class="badge badge-success">50元</span> <span class="badge badge-success">100元</span></small>
                    </div>
 </div>


                    <ul class="user-meta mt-2">
<div id="viptip" class="mb20"></div>							
					<form action="" method="post" onsubmit="return checkFm2();">	
					<li class="col-md-6"><label>充值卡号</label><input type="text" id="epdcardnum" name="epdcardnum" class="form-control" required="required"> </li>
					<li class="col-md-6"><label>充值卡密</label><input type="text" id="epdcardpass" name="epdcardpass" class="form-control" required="required"></li>
                   
					<div class="col-md-9 mt-3">
					<input type="hidden" name="action" value="card"><input type="submit" value="充值卡充值" class="btn btn-outline-success">  <a class="btn btn-info" href="<?php echo get_boxmoe('czcard_src');?>" target="_blank">获得充值卡</a></div> 
					</form>
					</ul>
</div>
 	</form>
                <?php }?>               
                    </div>
                   
                  </div>
                </div>
              </div>				
	<?php } ?>	


<?php if($_GET["items"]=='pass'){///修改密码
?>			
    <div class="card-header card-header-warning text-center">修改密码</div>
    <div class="card-body">
    <div class="row">
    <div class="col-lg-12 col-md-12">
 <div id="changepass">
				<div class="alert alert-success">为了确保安全，密码最好是由“字母+字符+数字”组成！</div>
				<div class="row justify-content-center">
				<div class="col-md-6">
				<div class="profile-form">
					<form action="" method="post">
                    <dl class="dl-horizontal"  style="display: none;">
						<dt><label class="pt10">用户名</label></dt> 
						<dd>
							<input type="text" id="mm_username" name="log" value="<?php echo esc_attr( $user_info->user_login ); ?>" class="form-control" disabled>
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
					<dl class="dl-horizontal mt10 text-center">
						<dd>
							<input type="button" id="dopassword" value="保存修改" class="btn btn-outline-danger text-center" />
						</dd>
					</dl>
					</form>
				</div>
				</div>
				</div>
			</div>
<script type="text/javascript">		
$("#dopassword").click(function() {
        if ($("#mm_pass_new").val().trim().length == 0) {
			Swal.fire('Oops...','请输入新密码！', 'error');
        } else if (strlen($("#mm_pass_new").val().trim()) < 6) {
			Swal.fire('Oops...','密码长度至少为6位！', 'error');
        } else if ($("#mm_pass_new2").val().trim() != $("#mm_pass_new").val().trim()) {
			Swal.fire('Oops...','两次密码不一致！', 'error');
        } else {
            $('#result').html('<img src="<?php echo boxmoe_load_style(); ?>/assets/images/loader.gif" class="loader" />').fadeIn();
            $.ajax({
                type: "post",
                //async: false,
                url: "<?php echo ERPHPDOWN_URL; ?>/admin/action/ajax-profile.php",
                data: "do=password&mm_usrname=" + $("#mm_usrname").val() + "&mm_pass_old=" + $("#mm_pass_old").val() + "&mm_pass_new=" + $("#mm_pass_new").val() + "&mm_pass_new2=" + $("#mm_pass_new2").val(),
                //contentType: "application/json; charset=utf-8",
                dataType: "text",
                success: function(data) {
                    $('.loader').remove();
					Swal.fire('恭喜','密码修改信息成功', 'success');
                    //alert(data);
                },
                error: function() {
                    $('.loader').remove();
                    Swal.fire('Oops...','密码修改失败！', 'error');
                }
            });
        }
    });	

</script>	
 
                    </div>
                   
                  </div>
                </div>
              </div>				

	<?php } ?>			
				
<?php if($_GET["items"]=='recharge'){///充值记录
				$totallists = $wpdb->get_var("SELECT count(*) FROM $wpdb->icemoney WHERE ice_success=1 and ice_user_id=".$user_info->ID);
				$ice_perpage = 10;
				$pages = ceil($totallists / $ice_perpage);
				$page=isset($_GET['pp']) ?intval($_GET['pp']) :1;
				$offset = $ice_perpage*($page-1);
				$lists = $wpdb->get_results("SELECT * FROM $wpdb->icemoney where ice_success=1 and ice_user_id=".$user_info->ID." order by ice_time DESC limit $offset,$ice_perpage");
?>			
    <div class="card-header card-header-warning text-center">充值记录</div>
    <div class="card-body">
    <div class="row">
    <div class="col-lg-12 col-md-12">
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


 
                    </div>
                   
                  </div>
                </div>
              </div>				

	<?php } ?>		

			
              </div>
            </div>
          </div>
        </div>
      </div>
      </div>
      </div>								
				
<script type="text/javascript">
	function checkFm() {
	if(document.getElementById("ice_money").value=="") {
		alert('请输入金额');
		return false;
	}
}
function checkFm2() {
	if(document.getElementById("epdcardnum").value=="") {
		alert('请输入金额');
		return false;
	}
}
function checkFm3() {
	if(document.getElementById("epdmycrednum").value=="") {
		alert('请输入兑换的金额');
		return false;
	}
}
function strlen(str) {
	var len = 0;
	for (var i=0; i<str.length; i++) {
		var c = str.charCodeAt(i);
		if ((c >= 0x0001 && c <= 0x007e) || (0xff60<=c && c<=0xff9f)) {
			len++;
		} else {
			len+=2;
		}
	}
	return len;
}
</script>
<?php }else{ ?> 			
      <div class="boxmoe-user-page mb30">
        <div class="container">
          <div class="section-head"><span>Single</span></div>
			<div class="row boxmoe-user-page mt20">
			<div class="col-lg-12 col-md-12">
              <div class="user-info card">
			  <div class="card-header card-header-warning text-center">会员中心</div>
                <div class="card-body">
				<div class="row">
				<div class="col-lg-10 col-md-10 ml-auto mr-auto">		
				<div class="alert alert-warning" role="alert">
  				  <span class="alert-icon"><i class="fa fa-bell"></i></span>
   				 <span class="alert-text"><strong>提示：</strong> 会员中心必须配套Erphpdown插件使用，检测网站未启用或者未安装该插件！<a href="#" style="font-weight: bold;color: #fff;font-size: 16px;">详细点击查看说明</a></span>
				</div>
				</div>
				</div>				
				</div>				
				</div>
				
				</div>
				</div>
				</div>
				</div>
<?php } ?>
<?php } ?>

<?php get_footer();?>