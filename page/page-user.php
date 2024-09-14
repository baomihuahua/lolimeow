<?php 
/*
Template Name: Boxmoe会员中心
@link https://www.boxmoe.com
@package lolimeow
*/
//error_reporting(0);
if (session_status() == PHP_SESSION_NONE) {
   session_start();
}
if(!is_user_logged_in()){
	if( get_boxmoe('users_login') ) {
		$redirect_to = ''.site_url().'?page_id='.get_boxmoe('users_login').'';	
		echo "<script>window.location.href='".$redirect_to."';</script>";
		exit;
		}else{
		//echo "<script>window.location.href='".wp_login_url()."';</script>";
		wp_redirect(wp_login_url());
		exit;
		}	
}
global $wpdb,$current_user;
$user_info=wp_get_current_user();
$moneyVipName = get_option('ice_name_alipay');

$erphp_quarter_price = get_option('erphp_quarter_price');
$erphp_month_price  = get_option('erphp_month_price');
$erphp_day_price  = get_option('erphp_day_price');
$erphp_year_price    = get_option('erphp_year_price');
$erphp_life_price  = get_option('erphp_life_price');

$erphp_life_days    = get_option('erphp_life_days');
$erphp_year_days    = get_option('erphp_year_days');
$erphp_quarter_days = get_option('erphp_quarter_days');
$erphp_month_days  = get_option('erphp_month_days');
$erphp_day_days  = get_option('erphp_day_days');
$erphp_vip_name  = get_option('erphp_vip_name')?get_option('erphp_vip_name'):'VIP';

//6.体验VIP 7.月会员 8.季会员 9.年会员 10.终身会员
function boxmoe_user_money() {
            global $wpdb,$current_user;
            $moneyVipName = get_option('ice_name_alipay');
            $user_info=wp_get_current_user();
            $okMoney=0; 
            $userMoney=$wpdb->get_row("select * from ".$wpdb->iceinfo." where ice_user_id=".$user_info->ID);                
					if(!$userMoney){
						$okMoney=0;
					}else{
						$okMoney=$userMoney->ice_have_money - $userMoney->ice_get_money;
					}
               return $okMoney.$moneyVipName;
            }
function boxmoe_user_moneyto() {
            global $wpdb,$current_user;
            $moneyVipName = get_option('ice_name_alipay');
            $user_info=wp_get_current_user();
            $okMoney=0; 
            $userMoney=$wpdb->get_row("select * from ".$wpdb->iceinfo." where ice_user_id=".$user_info->ID);                
					if(!$userMoney){
						$okMoney=0;
					}else{
						$okMoney=$userMoney->ice_get_money;
					}
               return $okMoney.$moneyVipName;
            }           
   function boxmoe_vip_name() {
      $userTypeId=getUsreMemberType();
      if($userTypeId==6) {
         echo $erphp_day_name  = get_option('erphp_day_name')?get_option('erphp_day_name'):'体验VIP';
      } elseif($userTypeId==7) { 
         echo $erphp_month_name  = get_option('erphp_month_name')?get_option('erphp_month_name'):'包月VIP';
      } elseif ($userTypeId==8) {
         echo $erphp_quarter_name = get_option('erphp_quarter_name')?get_option('erphp_quarter_name'):'包季VIP';
      } elseif ($userTypeId==9) {
         echo $erphp_year_name    = get_option('erphp_year_name')?get_option('erphp_year_name'):'包年VIP';
      } elseif ($userTypeId==10) {
         echo $erphp_life_name    = get_option('erphp_life_name')?get_option('erphp_life_name'):'终身VIP';
      } else {
         echo '注册会员';
      }
      }   
      function boxmoe_vip_pic() {
         $userTypeId=getUsreMemberType();
         if($userTypeId==6) {
            echo '<img src="'.boxmoe_themes_dir().'/assets/images/vip/v2.jpg">';
         } elseif($userTypeId==7) { 
            echo '<img src="'.boxmoe_themes_dir().'/assets/images/vip/v2.jpg">';
         } elseif ($userTypeId==8) {
            echo '<img src="'.boxmoe_themes_dir().'/assets/images/vip/v3.jpg">';
         } elseif ($userTypeId==9) {
            echo '<img src="'.boxmoe_themes_dir().'/assets/images/vip/v4.jpg">';
         } elseif ($userTypeId==10) {
            echo '<img src="'.boxmoe_themes_dir().'/assets/images/vip/v5.jpg">';
         } else {
            echo '<img src="'.boxmoe_themes_dir().'/assets/images/vip/v1.jpg">';
         }
         }       
function boxmoe_vip_time() {	
   $userTypeId=getUsreMemberType();
   if($userTypeId) {
		echo getUsreMemberTypeEndTime();
	} else {
      echo '永久';
   }
   }
   function mobantu_paging($type,$paged,$max_page) {
      if ( $max_page <= 1 ) return;
      if ( empty( $paged ) ) $paged = 1;
      echo '<nav aria-label="Page navigation example"><ul class="pagination pagination-info pagination-sm m-4">';
      if($paged > 1) {
         echo '<li class="page-item"><a class="page-link" href="?items='.$type.'&pp='.($paged-1).'" aria-label="Previous"><i class="fa fa-angle-left"></i><span class="sr-only">Previous</span></a></li>';
      }
      if ( $paged > 2 ) echo "<li><span> ... </span></li>";
      for ( $i = $paged - 1; $i <= $paged + 3; $i++ ) {
         if ( $i > 0 && $i <= $max_page ) {
            if($i == $paged) 
                        print "<li class=\"page-item active\"><a class=\"page-link\">{$i}</a></li>"; else
                        print "<li class=\"page-item\"><a class=\"page-link\" href='?items=".$type."&pp={$i}'><span>{$i}</span></a></li>";
         }
      }
      if ( $paged < $max_page - 3 ) echo "<li><span> ... </span></li>";
      if($paged < $max_page) {
         echo '<li class="page-item"><a class="page-link" href="?items='.$type.'&pp='.($paged+1).'" aria-label="Next"><i class="fa fa-angle-right"></i><span class="sr-only">Next</span></a></li>';
      }
      echo '</ul></div>';
   }

get_header(); 
$items = isset($_GET["items"]) ? $_GET["items"] : 'home';
?>
         <link rel='stylesheet' href="https://lf9-cdn-tos.bytecdntp.com/cdn/expire-1-M/limonte-sweetalert2/11.4.4/sweetalert2.min.css" type='text/css' media='all' />
         <script src="https://lf3-cdn-tos.bytecdntp.com/cdn/expire-1-M/limonte-sweetalert2/11.4.4/sweetalert2.min.js"></script>
      <section class="section-blog-breadcrumb container fadein-bottom">
        <div class="breadcrumb-head">
          <span>
            <i class="fa fa-home"></i>User</span>
        </div>
      </section>
      <?php if(function_exists( 'mobantu_erphp_menu' )  ) {?>
      <main>
         <section class="boxmoe_user_center fadein-bottom">
            <div class="container">
               <div class="row">
                  <div class="col-lg-3 col-md-4">
                     <div class="user-menu blog-shadow">
                     <div class="d-flex align-items-center mb-4 justify-content-center justify-content-md-start">
                     <?php echo get_avatar($user_info->ID,60); ?>   
                        <div class="ms-3">
                           <h5 class="mb-0"><?php echo esc_attr($user_info->user_login ); ?></h5>
                           <small><?php boxmoe_vip_pic(); ?></small>
                        </div>
                     </div>
                     <!-- Navbar -->
                     <div class="d-md-none text-center d-grid">
                        <button
                           class="btn btn-light mb-3 d-flex align-items-center justify-content-between"
                           type="button"
                           data-bs-toggle="collapse"
                           data-bs-target="#collapseAccountMenu"
                           aria-expanded="false"
                           aria-controls="collapseAccountMenu">
                           导航菜单
                           <i class="bi bi-chevron-down ms-2"></i>
                        </button>
                     </div>
                     <div class="collapse d-md-block" id="collapseAccountMenu">
                        <ul class="nav flex-column nav-account">
                           <li class="nav-item">
                              <a class="nav-link <?php if($items == 'home') {?>active<?php }?>" href="?items=home">                               
                              <i class="fa fa-address-card"></i><span class="ms-2">用户中心</span>
                              </a>
                           </li>
                           <li class="nav-item">
                              <a class="nav-link <?php if($items == 'info') {?>active<?php }?>" href="?items=info">
                                 <i class="fa fa-user-circle-o"></i><span class="ms-2">个人信息</span>
                              </a>
                           </li>                           
                           <li class="nav-item">
                              <a class="nav-link <?php if($items == 'order') {?>active<?php }?>" href="?items=order">
                                 <i class="fa fa-database"></i><span class="ms-2">订单管理</span>
                              </a>
                           </li>
                           <li class="nav-item">
                              <a class="nav-link <?php if($items == 'vip') {?>active<?php }?>" href="?items=vip">
                                 <i class="fa fa-line-chart"></i><span class="ms-2">会员等级</span>
                              </a>
                           </li>
                           <li class="nav-item">
                              <a class="nav-link <?php if($items == 'money') {?>active<?php }?>" href="?items=money">
                                 <i class="fa fa-credit-card"></i><span class="ms-2">资产管理</span>
                              </a>
                           </li>
                           <li class="nav-item">
                              <a class="nav-link <?php if($items == 'recharge') {?>active<?php }?>" href="?items=recharge">
                              <i class="fa fa-won"></i><span class="ms-2">充值记录</span>
                              </a>
                           </li>
                           <li class="nav-item">
                              <a class="nav-link <?php if($items == 'comment') {?>active<?php }?>" href="?items=comment">
                              <i class="fa fa-comments-o"></i><span class="ms-2">评论内容</span>
                              </a>
                           </li>
                           <li class="nav-item">
                              <a class="nav-link <?php if($items == 'password') {?>active<?php }?>" href="?items=password">
                              <i class="fa fa-keyboard-o"></i><span class="ms-2">修改密码</span>
                              </a>
                           </li>
                           <li class="nav-item">
                              <a class="nav-link" href="<?php echo wp_logout_url(home_url());?>">
                              <i class="fa fa-sign-out"></i><span class="ms-2">退出登录</span>
                              </a>
                           </li>
                        </ul>
                     </div>
                     </div>
                  </div>

                  <div class="col-lg-9 col-md-8">
                     <?php if($items == 'home') {?>
                     <div class="card mb-4 blog-shadow">
                        <div class="card-body p-lg-5">
                           <div class="mb-6 d-lg-flex align-items-center justify-content-between">
                              <h4 class="mb-0">用户中心</h4>
                              <div class="mt-3 mt-lg-0 d-md-flex">
                              <?php global $wpdb, $current_user; if(get_option('ice_ali_money_checkin')){
                                 if(erphpdown_check_checkin($user_info->ID)) {?> 
                                 <span class="btn btn-success me-2 btn-sm disabled">已签到</span>
                                 <?php }else{ ?>
                                    <a href="javascript:;" class="boxmoe-checkin btn btn-danger me-2 btn-sm ">每日签到</a>   
								         <?php } }?>                                 
                                 <a href="?items=money" class="btn btn-primary btn-sm">
                                    余额充值</a>
                              </div>
                           </div>
                           <div class="table-responsive">
                              <table class="table table-centered td table-centered th table-lg text-nowrap">
                                 <tbody>
                                    <tr>
                                       <th scope="row">
                                          <div class="d-flex align-items-center">
                                          <?php echo get_avatar($user_info->ID,60); ?>  
                                             <div class="ms-3">
                                                <div class="fs-5 fw-semibold text-dark"><?php echo esc_attr( $current_user->nickname ) ?></div>
                                                <small>会员等级：<?php echo boxmoe_vip_name(); ?> <?php echo boxmoe_vip_pic(); ?> 到期时间：<?php echo boxmoe_vip_time(); ?></small>
                                             </div>
                                          </div>
                                       </th>

                                    </tr>
                                 </tbody>
                              </table>
                           </div>                           
                           <div class="row gx-4 mb-4">
                              <div class="col-lg-4">
                                 <div class="card border-0 mb-4 mb-lg-0 bg-light-subtle">
                                    <div class="card-body py-lg-3 px-lg-4">
                                       <div class="mb-5">
                                          <h6>账号余额</h6>
                                          <h4><?php echo boxmoe_user_money(); ?></h4>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-lg-4">
                                 <div class="card border-0 mb-4 mb-lg-0 bg-light-subtle">
                                    <div class="card-body py-lg-3 px-lg-4">
                                       <div class="mb-5">
                                          <h6>累计消费</h6>
                                          <h4><?php echo boxmoe_user_moneyto(); ?></h4>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-lg-4">
                                 <div class="card border-0 mb-4 mb-lg-0 bg-light-subtle">
                                    <div class="card-body py-lg-3 px-lg-4">
                                       <div class="mb-5">
                                          <h6>累计评论</h6>
                                          <h4><?php global $user_ID;echo get_comments('count=true&user_id='.$user_ID);?>条</h4>
                                       </div>
                                    </div>
                                 </div>
                              </div>

                           </div>

                           <div class="border mb-4 rounded-3 px-4 py-3">
                                 <div class="d-flex align-items-start">
                                    <div class="me-4">
                                       <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                          <circle cx="8" cy="8" r="8" class="text-success"/>
                                       </svg>
                                    </div>
                                    <div class="d-lg-flex align-items-center justify-content-between w-100">
                                       <div class="d-flex">
                                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-display" viewBox="0 0 16 16">
                                             <path
                                                d="M0 4s0-2 2-2h12s2 0 2 2v6s0 2-2 2h-4c0 .667.083 1.167.25 1.5H11a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1h.75c.167-.333.25-.833.25-1.5H2s-2 0-2-2V4zm1.398-.855a.758.758 0 0 0-.254.302A1.46 1.46 0 0 0 1 4.01V10c0 .325.078.502.145.602.07.105.17.188.302.254a1.464 1.464 0 0 0 .538.143L2.01 11H14c.325 0 .502-.078.602-.145a.758.758 0 0 0 .254-.302 1.464 1.464 0 0 0 .143-.538L15 9.99V4c0-.325-.078-.502-.145-.602a.757.757 0 0 0-.302-.254A1.46 1.46 0 0 0 13.99 3H2c-.325 0-.502.078-.602.145z" />
                                          </svg>
                                          <div class="ms-4">
                                             <h5 class="mb-0">最近登录IP <?php echo esc_attr( $user_info->last_login_ip) ?></h5>
                                             <small>你的账号安全信息</small>
                                          </div>
                                       </div>
                                       <div class="mt-4 mt-lg-0">
                                          <a
                                             href="#"
                                             class="btn btn-light btn-sm"
                                             data-bs-toggle="collapse"
                                             data-bs-target="#collapseDeviceTwo"
                                             aria-expanded="false"
                                             aria-controls="collapseDeviceTwo">
                                             See More
                                          </a>
                                       </div>
                                    </div>
                                 </div>
                                 <div id="collapseDeviceTwo" class="accordion-collapse collapse show" data-bs-parent="#accordionExampleOne">
                                    <div class="pt-4">                                  
                                       <div class="mb-4">
                                          <h6 class="mb-0">登录账号:</h6>
                                          <small><?php echo esc_attr( $user_info->user_login) ?></small>
                                       </div>
                                       <div class="mb-4">
                                          <h6 class="mb-0">注册时间:</h6>
                                          <small><?php echo esc_attr($user_info->reg_time,'0000-00-00' ); ?></small>
                                       </div>
                                       <div class="mb-4">
                                          <h6 class="mb-0">最近登录:</h6>
                                          <small><?php echo esc_attr( $user_info->last_login ) ?></small>
                                       </div>
                                    </div>
                                 </div>
                              </div>

                          </div>
                     </div> 
                     <?php }?>
                     <?php if($items =='info') {?>
                     <div class="card blog-shadow mb-4">
                        <div class="card-body p-lg-5">
                           <div class="mb-5">
                              <h4 class="mb-1">账户信息</h4>
                              <p class="mb-0 fs-6">你的账号基础信息,你可以通过编辑信息更新</p>
                           </div>
                           <div class="d-flex align-items-center mb-5 boxmoe_user_avatar">
                           <div id="avatar-preview">
                           <?php echo get_avatar($user_info->ID,60); ?> 
                           </div>
                              <div class="ms-4">
                                 <button class="mb-0 input-file">
                                 <input type="file" id="avatar-upload" accept="image/*">
                                 <label id="avatar-upload-label" for="avatar-upload" class="btn btn-outline-dark btn-sm">上传头像</label>                             
                                 </button>                                 
                                 <small>支持格式 *.jpeg, *.jpg, *.png, *.gif, *.webp 图片最大尺寸 1 MB</small>
                              </div>
                           </div>                                              
                           <form class="row g-3 needs-validation" action="" method="post">
                              <div class="col-lg-6 col-md-12">
                                 <label class="form-label" for="mm_mail">帐户邮箱</label>
                                 <input type="text" class="form-control" id="mm_mail" name="mm_mail" value="<?php echo esc_attr( $current_user->user_email ) ?>">
                              </div>
                              <div class="col-lg-6 col-md-12">
                              <label class="form-label" for="mm_name">帐户昵称</label>
                                 <input type="text" class="form-control" id="mm_name" name="mm_name" value="<?php echo esc_attr( $current_user->nickname ) ?>">
                              </div>
                              <div class="col-lg-6">
                              <label class="form-label" for="mm_url">会员网站</label>
                                 <input type="text" class="form-control" id="mm_url" name="mm_url" value="<?php echo esc_attr( $current_user->user_url ) ?>">
                              </div>
                              <div class="col-lg-12">
                              <label class="form-label" for="mm_desc">会员简介</label>
                                 <textarea rows="4" class="form-control forminput" id="mm_desc" name="mm_desc"><?php echo esc_html( $current_user->description ); ?></textarea>
                              </div>
                              <div class="col-12 mt-4">
                                 <button class="btn btn-primary me-2 btn-sm" id="doprofile" type="button">保存设置</button>
                              </div>
                           </form>
                        </div>
                     </div>

                     <?php }?>
                     <?php  if($items =='order') { 
                        	global $wpdb, $current_user;
                           $total_trade   = $wpdb->get_var("SELECT COUNT(ice_id) FROM $wpdb->icealipay WHERE ice_success>0 and ice_user_id=".$current_user->ID);
                           $ice_perpage = 20;
                           $pages = ceil($total_trade / $ice_perpage);
                           $page=isset($_GET['pp']) ?intval($_GET['pp']) :1;
                           $offset = $ice_perpage*($page-1);
                           $list = $wpdb->get_results("SELECT * FROM $wpdb->icealipay where ice_success=1 and ice_user_id=$current_user->ID order by ice_time DESC limit $offset,$ice_perpage");                       
                        ?>
                        <div class="card blog-shadow mb-4">
                        <div class="card-body p-lg-5">
                           <div class="mb-5">
                              <h4 class="mb-1">订单管理</h4>
                              <p class="fs-6 mb-0">购买的资源都在此订单方式呈现记录</p>
                           </div>
                        <div class="table-responsive">
                           <table class="table table-striped">
                                    <thead>
                                       <tr>
                                          <th scope="col">订单号</th>
                                          <th scope="col">商品名称</th>
                                          <th scope="col">价格</th>
                                          <th scope="col">交易时间</th>
                                          <th scope="col">下载</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <?php
                                 			if($list){
                                             foreach($list as $value){
                                                $start_down = get_post_meta( $value->ice_post, 'start_down', true );
                                                $start_down2 = get_post_meta( $value->ice_post, 'start_down2', true );
                                                echo "<tr>\n";
                                                echo "<th scope='row'>$value->ice_num</th>\n";
                                                echo "<td class='title'><a href='".get_permalink($value->ice_post)."' target='_blank'>".get_post($value->ice_post)->post_title."</a></td>\n";
                                                echo "<td>$value->ice_price</td>\n";
                                                echo "<td>$value->ice_time</td>\n";
                                                if($start_down || $start_down2){
                                                  echo '<td><a href="'.constant("erphpdown").'download.php?postid='.$value->ice_post.'&index='.$value->ice_index.'&timestamp='.time().'" target="_blank">'.__('点击下载','erphpdown').'</a></td>';
                                                }else{
                                                   echo '<td><a href="'.get_permalink($value->ice_post).'" target="_blank">'.__('查看','erphpdown').'</a></td>';
                                                }
                                                echo "</tr>";
                                             }
                                          }else{
                                             echo '<tr><td colspan="5" align="center">'.__('暂无记录','erphpdown').'</td></tr>';
                                          }      
                                       ?>
                                    </tbody>
                                 </table>
                        </div>
                           <div class="mt-4">
                           <?php mobantu_paging('order',$page,$pages);?>	
                           </div>
                        </div>
                     </div>
                        <?php }?>                    
          <?php if($items =='vip'){
	   global $wpdb, $current_user;
	   $vip_update_pay = get_option('vip_update_pay');
	   $error = '';                          
      $erphp_life_price    = get_option('erphp_life_price');
      $erphp_year_price    = get_option('erphp_year_price');
      $erphp_quarter_price = get_option('erphp_quarter_price');
      $erphp_month_price  = get_option('erphp_month_price');
      $erphp_day_price  = get_option('erphp_day_price');
      $erphp_life_name    = get_option('erphp_life_name')?get_option('erphp_life_name'):'终身VIP';
      $erphp_year_name    = get_option('erphp_year_name')?get_option('erphp_year_name'):'包年VIP';
      $erphp_quarter_name = get_option('erphp_quarter_name')?get_option('erphp_quarter_name'):'包季VIP';
      $erphp_month_name  = get_option('erphp_month_name')?get_option('erphp_month_name'):'包月VIP';
      $erphp_day_name  = get_option('erphp_day_name')?get_option('erphp_day_name'):'体验VIP';
      $erphp_life_days    = get_option('erphp_life_days');
      $erphp_year_days    = get_option('erphp_year_days');
      $erphp_quarter_days = get_option('erphp_quarter_days');
      $erphp_month_days  = get_option('erphp_month_days');
      $erphp_day_days  = get_option('erphp_day_days');
      $money_name = get_option('ice_name_alipay');
      $okMoney=erphpGetUserOkMoney();
      $userTypeId=getUsreMemberType();      
      
	if(isset($_POST['userType'])){
		$userType=isset($_POST['userType']) && is_numeric($_POST['userType']) ?intval($_POST['userType']) :0;
		$userType = esc_sql($userType);
		if($userType >5 && $userType < 11){
			$okMoney=erphpGetUserOkMoney();
			$priceArr=array('6'=>'erphp_day_price','7'=>'erphp_month_price','8'=>'erphp_quarter_price','9'=>'erphp_year_price','10'=>'erphp_life_price');
			$priceType=$priceArr[$userType];
			$price=get_option($priceType);

			$oldUserType = getUsreMemberTypeById($current_user->ID);
			if($vip_update_pay){
				$erphp_quarter_price = get_option('erphp_quarter_price');
				$erphp_month_price  = get_option('erphp_month_price');
				$erphp_day_price  = get_option('erphp_day_price');
				$erphp_year_price    = get_option('erphp_year_price');
				$erphp_life_price  = get_option('erphp_life_price');

				if($userType == 7){
					if($oldUserType == 6){
         		$price = $erphp_month_price - $erphp_day_price;
         	}
				}elseif($userType == 8){
					if($oldUserType == 6){
         		$price = $erphp_quarter_price - $erphp_day_price;
         	}elseif($oldUserType == 7){
         		$price = $erphp_quarter_price - $erphp_month_price;
         	}
				}elseif($userType == 9){
					if($oldUserType == 6){
         		$price = $erphp_year_price - $erphp_day_price;
         	}elseif($oldUserType == 7){
         		$price = $erphp_year_price - $erphp_month_price;
         	}elseif($oldUserType == 8){
         		$price = $erphp_year_price - $erphp_quarter_price;
         	}
				}elseif($userType == 10){
					if($oldUserType == 6){
         		$price = $erphp_life_price - $erphp_day_price;
         	}elseif($oldUserType == 7){
         		$price = $erphp_life_price - $erphp_month_price;
         	}elseif($oldUserType == 8){
         		$price = $erphp_life_price - $erphp_quarter_price;
         	}elseif($oldUserType == 9){
         		$price = $erphp_life_price - $erphp_year_price;
         	}
				}
			}

			if(isset($_SESSION['erphp_promo_code']) && $_SESSION['erphp_promo_code']){
		        $promo = str_replace("\\","", $_SESSION['erphp_promo_code']);
		        $promo_arr = json_decode($promo,true);
		        if($promo_arr['type'] == 1){
		            $promo_money = get_option('erphp_promo_money1');
		            if($promo_money){
		                if(!$start_down2){
		                    $promo_money = $promo_money / get_option("ice_proportion_alipay");
		                }
		                $price = $price - $promo_money;
		            }
		        }elseif($promo_arr['type'] == 2){
		            $promo_money = get_option('erphp_promo_money2');
		            if($promo_money){
		                $price = $price * 0.1 * $promo_money;
		            }
		        }
		    }

			if($price <= 0){
				$error = '<div class="alert alert-warning d-flex align-items-center" role="alert"><i class="fa fa-exclamation-circle me-2"/></i><div>价格有误</div></div>';
			}elseif($okMoney < $price){
            $error = '<div class="alert alert-warning d-flex align-items-center" role="alert"><i class="fa fa-exclamation-circle me-2"/></i><div>余额不足</div></div>';
			}elseif($okMoney >=$price){
				if(erphpSetUserMoneyXiaoFei($price)){
					if(userPayMemberSetData($userType)){
						addVipLog($price, $userType);
						$EPD = new EPD();
						$EPD->doAff($price, $current_user->ID);
						$error = '<div class="alert alert-success d-flex align-items-center" role="alert"><i class="fa fa-check-circle me-2"/></i><div>升级成功</div></div>';
					}else{
                  $error = '<div class="alert alert-warning d-flex align-items-center" role="alert"><i class="fa fa-exclamation-circle me-2"/></i><div>系统超时，请稍后重试</div></div>';
					}
				}else{
               $error = '<div class="alert alert-warning d-flex align-items-center" role="alert"><i class="fa fa-exclamation-circle me-2"/></i><div>系统超时，请稍后重试</div></div>';
				}
			}else{
				$error = '<div class="alert alert-warning d-flex align-items-center" role="alert"><i class="fa fa-exclamation-circle me-2"/></i><div>系统超时，请稍后重试</div></div>';
			}
		}else{
         $error = '<div class="alert alert-warning d-flex align-items-center" role="alert"><i class="fa fa-exclamation-circle me-2"/></i><div>VIP类型错误</div></div>';
		}
	}                           ?>
                    <div class="card blog-shadow mb-4 user-vip">
                        <div class="card-body p-lg-5">
                           <div class="mb-5">
                              <h4 class="mb-1">会员升级</h4>
                              <p class="fs-6 mb-0">通过升级会员的等级，可以解锁更多的功能和权限哦！</p>
                           </div>
                           <div class="d-flex align-items-center mb-6">
                           <?php echo get_avatar($user_info->ID,60); ?> 
                              <div class="ms-4">
                                 <h5 class="mb-0 info"><span class="text-success">●</span><?php echo esc_attr( $current_user->nickname ) ?></h5>
                                 <small class="info"><span class="vipcoll">当前余额：<?php echo $okMoney?>&nbsp;当前等级：<?php echo boxmoe_vip_name()?>&nbsp;到期时间：<?php echo boxmoe_vip_time(); ?> </span></small>                                
                              </div>
                           </div>
                           <?php echo $error;?>           
                           <form action="" method="post" id="vipform">        
                           <?php if($erphp_life_price){ 
                              $old_price = '';
                              if($vip_update_pay){
                                      if($userTypeId == 6 && $erphp_day_price){
                                         $old_price .= '原价<del>'.$erphp_life_price.'</del> 差价';
                                          $old_price .= $erphp_life_price - $erphp_day_price;
                                       }elseif($userTypeId == 7 && $erphp_month_price){
                                          $old_price .= '原价<del>'.$erphp_life_price.'</del> 差价';
                                          $old_price .= $erphp_life_price - $erphp_month_price;
                                       }elseif($userTypeId == 8 && $erphp_quarter_price){
                                          $old_price .= '原价<del>'.$erphp_life_price.'</del> 差价';
                                          $old_price .= $erphp_life_price - $erphp_quarter_price;
                                       }elseif($userTypeId == 9 && $erphp_year_price){
                                          $old_price .= '原价<del>'.$erphp_life_price.'</del> 差价';
                                          $old_price .= $erphp_life_price - $erphp_year_price;
                                       }else{
                                          $old_price .= $erphp_life_price;
                                       }
                                   }else{
                                      $old_price .= $erphp_life_price;
                                   }?>
                           <div class="border py-3 px-4 rounded-3 mb-3">
                              <div class="d-flex justify-content-between">
                                 <div class="d-flex vipicon">
                                    <img src="<?php echo boxmoe_themes_dir(); ?>/assets/images/vip/v5.jpg" alt="VIP5" class="me-3">
                                    <div>
                                       <h6 class="mb-0"><?php echo $erphp_life_name; ?></h6>
                                       <small>有效期:<?php echo $erphp_life_days?$erphp_life_days.'年':'永久'; ?></small>
                                    </div>
                                 </div>
                                 <div class="d-flex align-items-center">
                                    <span class="dropstart">
                                       <div class="form-check">
                                       <input class="form-check-input" id="VIP5" type="radio" name="userType"  value="10"checked="">
                                       <label class="form-check-label" for="VIP5">售价：<?php echo $old_price;?><?php echo $moneyVipName;?></label>
                                       </div>                                       
                                    </span>
                                 </div>
                              </div>
                           </div>
                           <?php }?>
                           <?php if($erphp_year_price){ 
                              $old_price = '';
                              if($vip_update_pay){
                                      if($userTypeId == 6 && $erphp_day_price){
                                         $old_price .= '原价<del>'.$erphp_year_price.'</del> 差价';
                                          $old_price .= $erphp_year_price - $erphp_day_price;
                                       }elseif($userTypeId == 7 && $erphp_month_price){
                                          $old_price .= '原价<del>'.$erphp_year_price.'</del> 差价';
                                          $old_price .= $erphp_year_price - $erphp_month_price;
                                       }elseif($userTypeId == 8 && $erphp_quarter_price){
                                          $old_price .= '原价<del>'.$erphp_year_price.'</del> 差价';
                                          $old_price .= $erphp_year_price - $erphp_quarter_price;
                                       }else{
                                          $old_price .= $erphp_year_price;
                                       }
                                   }else{
                                       $old_price .= $erphp_year_price;
                                   }?>
                           <div class="border py-3 px-4 rounded-3 mb-3">
                              <div class="d-flex justify-content-between">
                                 <div class="d-flex vipicon">
                                    <img src="<?php echo boxmoe_themes_dir(); ?>/assets/images/vip/v4.jpg" alt="VIP" class="me-3">
                                    <div>
                                       <h6 class="mb-0"><?php echo $erphp_year_name; ?></h6>
                                       <small>有效期:<?php echo $erphp_year_days; ?>个月</small>
                                    </div>
                                 </div>
                                 <div class="d-flex align-items-center">
                                    <span class="dropstart">
                                       <div class="form-check">
                                       <input class="form-check-input" id="VIP4" type="radio" name="userType"  value="9"checked="">
                                       <label class="form-check-label" for="VIP4">售价：<?php echo $old_price;?><?php echo $moneyVipName;?></label>
                                       </div>                                       
                                    </span>
                                 </div>
                              </div>
                           </div><?php }?>
                           <?php if($erphp_quarter_price){ 
                              $old_price = '';
                              if($vip_update_pay){
                                      if($userTypeId == 6 && $erphp_day_price){
                                         $old_price .= '原价<del>'.$erphp_quarter_price.'</del> 差价';
                                          $old_price .= $erphp_quarter_price - $erphp_day_price;
                                       }elseif($userTypeId == 7 && $erphp_month_price){
                                          $old_price .= '原价<del>'.$erphp_quarter_price.'</del> 差价';
                                          $old_price .= $erphp_quarter_price - $erphp_month_price;
                                       }else{
                                          $old_price .= $erphp_quarter_price;
                                       }
                                   }else{
                                       $old_price .= $erphp_quarter_price;
                                   }?>
                           <div class="border py-3 px-4 rounded-3 mb-3">
                              <div class="d-flex justify-content-between">
                                 <div class="d-flex vipicon">
                                    <img src="<?php echo boxmoe_themes_dir(); ?>/assets/images/vip/v3.jpg" alt="VIP" class="me-3">
                                    <div>
                                       <h6 class="mb-0"><?php echo $erphp_quarter_name; ?></h6>
                                       <small>有效期:<?php echo $erphp_quarter_days;?>个月</small>
                                    </div>
                                 </div>
                                 <div class="d-flex align-items-center">
                                    <span class="dropstart">
                                       <div class="form-check">
                                       <input class="form-check-input" id="VIP3" type="radio" name="userType"  value="8"checked="">
                                       <label class="form-check-label" for="VIP3">售价：<?php echo $old_price;?><?php echo $moneyVipName;?></label>
                                       </div>                                       
                                    </span>
                                 </div>
                              </div>
                           </div>
                           <?php }?>
                           <?php if($erphp_month_price){ 
                              $old_price = '';
                              if($vip_update_pay){
                                      if($userTypeId == 6 && $erphp_day_price){
                                         $old_price .= '原价<del>'.$erphp_month_price.'</del>差价';
                                          $old_price .= $erphp_month_price - $erphp_day_price;
                                       }else{
                                          $old_price .= $erphp_month_price;
                                       }
                                   }else{
                                       $old_price .= $erphp_month_price;
                                   }?>
                           <div class="border py-3 px-4 rounded-3 mb-3">
                              <div class="d-flex justify-content-between">
                                 <div class="d-flex vipicon">
                                    <img src="<?php echo boxmoe_themes_dir(); ?>/assets/images/vip/v2.jpg" alt="VIP" class="me-3">
                                    <div>
                                       <h6 class="mb-0"><?php echo $erphp_month_name; ?></h6>
                                       <small>有效期:<?php echo $erphp_month_days;?>天</small>
                                    </div>
                                 </div>
                                 <div class="d-flex align-items-center">
                                    <span class="dropstart">
                                       <div class="form-check">
                                       <input class="form-check-input" id="VIP2" type="radio" name="userType"  value="7"checked="">
                                       <label class="form-check-label" for="VIP2">售价：<?php echo $old_price;?><?php echo $moneyVipName;?></label>
                                       </div>                                       
                                    </span>
                                 </div>
                              </div>
                           </div><?php }?>
                           <?php if($erphp_day_price){ ?>
                           <div class="border py-3 px-4 rounded-3 mb-3">
                              <div class="d-flex justify-content-between">
                                 <div class="d-flex vipicon">
                                    <img src="<?php echo boxmoe_themes_dir(); ?>/assets/images/vip/v2.jpg" alt="VIP" class="me-3">
                                    <div>
                                       <h6 class="mb-0"><?php echo $erphp_day_name; ?></h6>
                                       <small>有效期:<?php echo $erphp_day_days;?>天</small>
                                    </div>
                                 </div>
                                 <div class="d-flex align-items-center">
                                    <span class="dropstart">
                                       <div class="form-check">
                                       <input class="form-check-input" id="VIPday" type="radio" name="userType"  value="6" checked="">
                                       <label class="form-check-label" for="VIPday">售价：<?php echo $erphp_day_price;?><?php echo $moneyVipName;?></label>
                                       </div>                                       
                                    </span>
                                 </div>
                              </div>
                           </div><?php }?>
                               <button class="btn btn-outline-primary mt-4" type="button" id="VIPSubmit" >升级会员</button>
                           </form>
                        </div>
                     </div>                 
                      <?php }?>
                     <?php if($items =='money'){ 
                        	global $wpdb, $current_user;                      
                        ?>      
                     <div class="card blog-shadow mb-4">
                        <div class="card-body p-lg-5">
                           <div class="mb-5">
                              <h4 class="mb-1">资产管理</h4>
                              <p class="fs-6 mb-0">一时冲一时爽，一直冲一直爽</p>
                           </div>
                           <div class="d-flex align-items-center mb-2">
                           <?php echo get_avatar($user_info->ID,60); ?>
                              <div class="ms-4">
                                 <h5 class="mb-0">TEST</h5>
                                 <small>当前余额：<?php echo boxmoe_user_money();?> 累计消费：<?php echo boxmoe_user_moneyto();?></small>
                              </div>
                           </div>
                  <div class="card border-primary mb-4 mt-3 border-1 shadow-sm">
                        <div class="card-header border-0 bg-primary bg-opacity-10 py-3">
                           <h3 class="mb-1 text-primary-emphasis">在线充值</h3>
                           <p class="mb-0 fs-6 text-primary-emphasis">充值说明：1 元 = <?php echo get_option('ice_proportion_alipay').' '.get_option('ice_name_alipay')?>请根据需求充值</p>
                        </div>
                        <div class="card-body">
                           <div class="row">
                              <div class="col-lg-12">
                                 <div class="mt-4">
                           <form class="row g-3 needs-validation" id="online-form">
                              <div class="col-lg-4 col-md-12">
                                 <label for="ice_money" class="form-label">充值金额</label>
                                 <input type="text" class="form-control fontsize"  id="ice_money" name="ice_money" placeholder="输入整数" required="">
                              </div>
                              <div class="col-lg-4 col-md-12">
                                 <label for="formGroupRoleInput" class="form-label">支付方式</label>
                                 <select class="form-select fontsize" name="paytype" id="formGroupRoleInput" required="" >
                                    <?php 
                                    			$erphpdown_recharge_order = get_option('erphpdown_recharge_order');
                                             if($erphpdown_recharge_order){
                                                $erphpdown_recharge_order_arr = explode(',', str_replace('，', ',', trim($erphpdown_recharge_order)));
                                                $pi = 0;
                                                foreach ($erphpdown_recharge_order_arr as $payment) {
                                                  
                                                   if($pi == 0) $checked = 'selected=""'; else $checked = '';
                                                   switch ($payment) {
                                                      case 'alipay':
                                                         echo '<option value="1" '.$checked.'>支付宝</option>';
                                                         break;
                                                      case 'wxpay':
                                                         echo '<option value="4" '.$checked.'>微信</option>';
                                                      case 'f2fpay':
                                                         echo '<option value="5" '.$checked.'>支付宝</option>';
                                                         break;
                                                      case 'paypal':
                                                         echo '<option value="2" '.$checked.'>PayPal</option>';
                                                         break;
                                                      case 'paypy-wx':
                                                         echo '<option value="7" '.$checked.'>微信</option>';
                                                         break;
                                                      case 'paypy-ali':
                                                         echo '<option value="8" '.$checked.'>支付宝</option>';
                                                         break;
                                                      case 'payjs-wx':
                                                         echo '<option value="19" '.$checked.'>微信</option>';
                                                         break;
                                                      case 'payjs-ali':
                                                         echo '<option value="20" '.$checked.'>支付宝</option>';
                                                         break;
                                                      case 'xhpay-wx':
                                                         echo '<option value="18" '.$checked.'>微信</option>';
                                                         break;
                                                      case 'xhpay-ali':
                                                         echo '<option value="17" '.$checked.'>支付宝</option>';
                                                         break;
                                                      case 'codepay-wx':
                                                         echo '<option value="14" '.$checked.'>微信</option>';
                                                         break;
                                                      case 'codepay-ali':
                                                         echo '<option value="13" '.$checked.'>支付宝</option>';
                                                         break;
                                                      case 'codepay-qq':
                                                         echo '<option value="15" '.$checked.'>QQ钱包</option>';
                                                         break;
                                                      case 'epay-wx':
                                                         echo '<option value="22" '.$checked.'>微信</option>';
                                                         break;
                                                      case 'epay-ali':
                                                         echo '<option value="21" '.$checked.'>支付宝</option>';
                                                         break;
                                                      case 'epay-qq':
                                                         echo '<option value="23" '.$checked.'>QQ钱包</option>';
                                                         break;
                                                      case 'easepay-wx':
                                                         echo '<option value="42" '.$checked.'>微信</option>';
                                                         break;
                                                      case 'easepay-ali':
                                                         echo '<option value="41" '.$checked.'>支付宝</option>';
                                                         break;
                                                      case 'easepay-usdt':
                                                         echo '<option value="43" '.$checked.'>USDT</option>';
                                                         break;
                                                      case 'vpay-wx':
                                                         echo '<option value="32" '.$checked.'>微信</option>';
                                                         break;
                                                      case 'vpay-ali':
                                                         echo '<option value="31" '.$checked.'>微信</option>';
                                                         break;
                                                      case 'usdt':
                                                         echo '<option value="50" '.$checked.'>USDT</option>';
                                                         break;
                                                      case 'stripe':
                                                         echo '<option value="60" '.$checked.'>信用卡</option>';
                                                         break;
                                                      case 'ecpay':
                                                         echo '<option value="70" '.$checked.'>新台币</option>';
                                                         break;
                                                      case 'newebpay':
                                                         echo '<option value="80" '.$checked.'>新台币</option>';
                                                         break;
                                                      default:
                                                         break;
                                                   }
                                                   $pi ++;
                                                }                                                
                                             }else{
                                                $checked='';
                                                if(get_option('erphpdown_usdt_address')){
                                                     echo '<option value="50" '.$checked.'>USDT</option>';
                                                  }
                                             if(get_option('ice_payapl_api_uid')){
                                                echo '<option value="2" '.$checked.'>PayPal</option>';
                                             }
                                             if(get_option('erphpdown_stripe_pk')){
                                                echo '<option value="60" '.$checked.'>信用卡</option>';
                                                  }
                                          if(plugin_check_ecpay() && get_option('erphpdown_ecpay_MerchantID')){
                                             echo '<option value="70" '.$checked.'>新台币</option>';
                                                  }
                                         if(plugin_check_newebpay() && get_option('erphpdown_newebpay_MerchantID')){
                                          echo '<option value="80" '.$checked.'>新台币</option>';
                                                  }
                                             if(get_option('ice_weixin_mchid')){ 
                                                echo '<option value="4" '.$checked.'>微信</option>';
                                             }
                                             if(get_option('ice_ali_partner') || get_option('ice_ali_app_id')){ 
                                                echo '<option value="1" '.$checked.'>支付宝</option>';
                                             }
                                             if(get_option('erphpdown_f2fpay_id')){
                                                echo '<option value="5" '.$checked.'>支付宝</option>';
                                                  }
                                                  if(get_option('erphpdown_payjs_appid')){
                                                     if(!get_option('erphpdown_payjs_alipay')){ 
                                                      echo '<option value="20" '.$checked.'>支付宝</option>'; }
                                                     if(!get_option('erphpdown_payjs_wxpay')){ 
                                                      echo '<option value="19" '.$checked.'>微信</option>';
                                                  }
                                                  if(get_option('erphpdown_xhpay_appid31')){
                                                   echo '<option value="18" '.$checked.'>微信</option>'; }
                                                  }
                                                  if(get_option('erphpdown_xhpay_appid32')){
                                                   echo '<option value="17" '.$checked.'>支付宝</option>';
                                                  }
                                             if(get_option('erphpdown_codepay_appid')){
                                                if(!get_option('erphpdown_codepay_alipay')){ 
                                                   echo '<option value="13" '.$checked.'>支付宝</option>'; }
                                                if(!get_option('erphpdown_codepay_wxpay')){
                                                   echo '<option value="14" '.$checked.'>微信</option>'; }
                                                if(!get_option('erphpdown_codepay_qqpay')){
                                                   echo '<option value="15" '.$checked.'>QQ钱包</option>'; }
                                             }
                                             if(get_option('erphpdown_paypy_key')){
                                                if(!get_option('erphpdown_paypy_alipay')){ 
                                                   echo '<option value="8" '.$checked.'>支付宝</option>'; }
                                                     if(!get_option('erphpdown_paypy_wxpay')){ 
                                                      echo '<option value="7" '.$checked.'>微信</option>'; }
                                                  }
                                                  if(get_option('erphpdown_epay_id')){
                                                     if(!get_option('erphpdown_epay_alipay')){ 
                                                      echo '<option value="21" '.$checked.'>支付宝</option>'; }
                                                     if(!get_option('erphpdown_epay_qqpay')){ 
                                                      echo '<option value="23" '.$checked.'>QQ钱包</option>'; }
                                                     if(!get_option('erphpdown_epay_wxpay')){ 
                                                      echo '<option value="22" '.$checked.'>微信</option>'; }
                                                  }
                                                  if(get_option('erphpdown_easepay_id')){
                                                     if(!get_option('erphpdown_easepay_usdt')){ 
                                                      echo '<option value="43" '.$checked.'>USDT</option>'; }
                                                     if(!get_option('erphpdown_easepay_alipay')){ 
                                                      echo '<option value="41" '.$checked.'>支付宝</option>'; }
                                                     if(!get_option('erphpdown_easepay_wxpay')){ 
                                                      echo '<option value="42" '.$checked.'>微信</option>'; }
                                                  }
                                             if(get_option('erphpdown_vpay_key')){
                                                     if(!get_option('erphpdown_vpay_alipay')){ 
                                                      echo '<option value="2" '.$checked.'>支付宝</option>'; }
                                                     if(!get_option('erphpdown_vpay_wxpay')){ 
                                                      echo '<option value="32" '.$checked.'>微信</option>'; }
                                                  }
                                               }                                              
                                    ?>
                                    </select>                 
                              </div>
                              <div class="col-12">
                                 <button class="btn btn-primary fontsize" type="submit">在线充值</button>
                              </div>
                           </form>
                              </div>
                           </div>
                         </div>
                        </div>
                     </div>
                  <div class="card border-primary mb-4 mt-3 border-1 shadow-sm">
                        <div class="card-header border-0 bg-primary bg-opacity-10 py-3">
                           <h3 class="mb-1 text-primary-emphasis">卡密充值</h3>
                           <p class="mb-0 fs-6 text-primary-emphasis">充值说明：1 元 = <?php echo get_option('ice_proportion_alipay').' '.get_option('ice_name_alipay')?>请根据需求充值</p>
                        </div>
                        <div class="card-body">
                           <div class="row">
                              <div class="col-lg-12">
                                 <div class="mt-4">
                           <form class="row g-3 needs-validation" id="card-form">
                              <div class="col-lg-4 col-md-12">
                              <input type="text" id="epdcardnum" name="epdcardnum" class="form-control fontsize" placeholder="输入卡号" required="required">
                              </div>
                              <div class="col-lg-4 col-md-12">
                              <input type="text" id="epdcardpass" name="epdcardpass" class="form-control fontsize" placeholder="输入卡密" required="required">
                              </div>
                              <div class="col-12">
                                 <button class="btn btn-primary fontsize" type="submit">卡号充值</button>
                              </div>
                           </form> 
                              </div>
                           </div>
                         </div>
                        </div>
                  </div>                                                   
               </div>
            </div>
                     <?php }?>
                     <?php if($items =='recharge'){ 
                        	global $wpdb, $current_user;
                           $total_trade   = $wpdb->get_var("SELECT COUNT(ice_id) FROM $wpdb->icemoney where ice_user_id=".$current_user->ID." and ice_success=1");
                           $ice_perpage = 20;
                           $pages = ceil($total_trade / $ice_perpage);
                           $page=isset($_GET['pp']) ?intval($_GET['pp']) :1;
                           $offset = $ice_perpage*($page-1);
                           $list = $wpdb->get_results("SELECT * FROM $wpdb->icemoney where ice_user_id=".$current_user->ID." and ice_success=1 order by ice_time DESC limit $offset,$ice_perpage");
                        ?>  
                     <div class="card blog-shadow mb-4">
                        <div class="card-body p-lg-5">
                           <div class="mb-5">
                              <h4 class="mb-1">充值记录</h4>
                              <p class="fs-6 mb-0">你的历史充值记录将在这里呈现</p>
                           </div>
                           <div class="table-responsive">
                           <table class="table table-hover">
                              <thead>
                              <tr>
                              <th scope="col">金额</th>
                              <th scope="col">方式</th>
                              <th scope="col">时间</th>
                              </tr>
                              </thead>
                              <tbody>
                              <?php
                              			if($list) {
                                          foreach($list as $value){
                                             echo "<tr>\n";
                                             echo "<td>$value->ice_money</td>\n";
                                             if(intval($value->ice_note)==0){
                                                echo "<td>".__('在线充值','erphpdown')."</td>\n";
                                             }elseif(intval($value->ice_note)==1){
                                                echo "<td>".__('后台充值','erphpdown')."</td>\n";
                                             }elseif(intval($value->ice_note)==4){
                                                echo "<td>".__('积分兑换','erphpdown')."</td>\n";
                                             }elseif(intval($value->ice_note)==6){
                                                echo "<td>".__('充值卡','erphpdown')."</td>\n";
                                             }else{
                                                echo "<td>".__('未知','erphpdown')."</td>\n";
                                             }
                                             echo "<td>$value->ice_time</td>\n";
                                             echo "</tr>";
                                          }
                                       }else{
                                          echo '<tr><td colspan="3" align="center">'.__('暂无记录','erphpdown').'</td></tr>';
                                       }
                              ?> 
                           </tbody>
                           </table>
                           </div>
                           <div class="mt-4">
                           <?php mobantu_paging('recharge',$page,$pages);?>	
                           </div>                           
                           </div>
                           </div>
                           <?php }?>
                           <?php if($items =='comment'){ ?>  
                     <div class="card blog-shadow mb-4">
                        <div class="card-body p-lg-5">
                           <div class="mb-5">
                              <h4 class="mb-1">我的评论</h4>
                              <p class="fs-6 mb-0">你的历史评论内容将在这里呈现</p>
                           </div>                     
                           <?php echo do_shortcode('[user_comments_summary]'); ?>
                           </div>
                           </div>
                           <?php }?>
                           <?php if($items =='social'){ ?>  
                     <div class="card border-0 mb-4 shadow-sm">
                        <div class="card-body p-lg-5">
                           <div class="mb-5">
                              <h4 class="mb-1">未使用</h4>
                              <p class="fs-6 mb-0">未使用</p>
                           </div>                     
                           未使用
                           </div>
                           </div>
                           <?php }?>
                           <?php if($items =='password'){ ?>  
                     <div class="card blog-shadow mb-4">
                        <div class="card-body p-lg-5">
                           <div class="mb-5">
                              <h4 class="mb-1">修改密码</h4>
                              <p class="fs-6 mb-0">这里修改你的账户密码</p>
                           </div>
                           <div class="alert alert-danger d-flex align-items-center" role="alert">
                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"class="bi bi-exclamation-triangle-fill me-2" viewBox="0 0 16 16">
                            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                           </svg>
                           <div>
                              请自行保管好密码，密码遗忘只能通过邮箱找回！请保持邮箱有效可接收邮件。
                            </div>
                           </div>
                           <form class="row gy-3 needs-validation" id="change-password-form">
                              <div class="col-lg-7">
                                 <label for="current_password" class="form-label">当前密码</label>
                                 <input type="password" class="form-control" id="current_password" name="current_password" required="">
                              </div>    
                              <div class="col-lg-7">
                                 <label for="new_password" class="form-label">新密码</label>
                                 <input type="password" class="form-control" id="new_password" name="new_password" required="">
                              </div>
                              <div class="col-lg-7">
                                 <label for="confirm_password" class="form-label">重复新密码</label>
                                 <input type="password" class="form-control"  id="confirm_password" name="confirm_password" required="">
                              </div>
                              <div class="col-12">
                              <button  class="btn btn-primary me-2" type="submit">更改密码</button>
                              </div>
                           </form>                       
                           </div>
                           </div>
                           <?php }?>                     
                  </div>
               </div>
            </div>
         </section>
      </main>
      <script src="<?php echo boxmoe_themes_dir();?>/assets/js/lib/user.js"></script>
         <?php
            $ajaxurl = admin_url('admin-ajax.php');
            $posturl = admin_url('admin-post.php');
            $erpurl  = ERPHPDOWN_URL.'/admin/action/ajax-profile.php';
            //$ajaxurl_url = json_encode($ajaxurl);
            echo "<script type='text/javascript'>\n";
            echo "var ajaxurl = '$ajaxurl';\n";
            echo "var posturl = '$posturl';\n";
            echo "var erpurl  = '$erpurl';\n";
            echo "</script>";
         ?>
         <?php }else{ ?> 
       <main>
         <section class="boxmoe_user_center fadein-bottom">
            <div class="container">
               <div class="row">            
            <div class="user-info card">
				<div class="card-header card-header-warning text-center">会员中心</div>
                <div class="card-body">
				<div class="row">
				<div class="col-lg-10 col-md-10 ml-auto mx-auto">		
				<div class="alert alert-warning d-flex align-items-center" role="alert">
  				<span class="alert-icon"><i class="fa fa-bell"></i></span>
   				<span class="alert-text"><strong>提示：</strong> 会员中心必须配套Erphpdown插件使用，检测网站未启用或者未安装该插件！<a href="https://www.boxmoe.com/468.html" target="_blank" style="font-weight: bold;color: #121211;font-size: 15px;">详细点击查看说明</a></span>
				</div>
				</div>
				</div>				
				</div>				
				</div>
            </div>
            </div>
         </section>
      </main>
            <?php } ?>

<?php get_footer(); ?>