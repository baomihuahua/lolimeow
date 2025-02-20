<?php
/**
 * Template Name: 用户中心
 * @link https://www.boxmoe.com
 * @package lolimeow
 */
//boxmoe.com===安全设置=阻止直接访问主题文件
if(!defined('ABSPATH')){echo'Look your sister';exit;}
//如果用户已经登陆那么跳转到首页
if (!is_user_logged_in()){
    wp_safe_redirect( get_option('home') );
    exit;
 }
get_header();
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
            echo '<img src="'.boxmoe_theme_url().'/assets/images/vip/v2.jpg">';
         } elseif($userTypeId==7) { 
            echo '<img src="'.boxmoe_theme_url().'/assets/images/vip/v2.jpg">';
         } elseif ($userTypeId==8) {
            echo '<img src="'.boxmoe_theme_url().'/assets/images/vip/v3.jpg">';
         } elseif ($userTypeId==9) {
            echo '<img src="'.boxmoe_theme_url().'/assets/images/vip/v4.jpg">';
         } elseif ($userTypeId==10) {
            echo '<img src="'.boxmoe_theme_url().'/assets/images/vip/v5.jpg">';
         } else {
            echo '<img src="'.boxmoe_theme_url().'/assets/images/vip/v1.jpg">';
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
   function mobantu_paging($type, $paged, $max_page) {
    if ($max_page <= 1) return;
    if (empty($paged)) $paged = 1;
    
    echo '<nav aria-label="Page navigation example"><ul class="pagination pagination-info pagination-sm m-4">';
    
    // 上一页按钮
    if ($paged > 1) {
        echo '<li class="page-item"><a class="page-link" href="?items='.$type.'&pp='.($paged-1).'" aria-label="Previous"><i class="fa fa-angle-left"></i><span class="sr-only">Previous</span></a></li>';
    }
    
    // 计算显示的页码范围
    $start = max(1, min($paged - 2, $max_page - 4));
    $end = min($max_page, max(5, $paged + 2));
    
    // 如果在开始处显示省略号
    if ($start > 1) {
        echo '<li class="page-item"><a class="page-link" href="?items='.$type.'&pp=1">1</a></li>';
        if ($start > 2) {
            echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
        }
    }
    
    // 显示页码
    for ($i = $start; $i <= $end; $i++) {
        if ($i == $paged) {
            echo "<li class=\"page-item active\"><a class=\"page-link\">{$i}</a></li>";
        } else {
            echo "<li class=\"page-item\"><a class=\"page-link\" href='?items=".$type."&pp={$i}'>{$i}</a></li>";
        }
    }
    
    // 如果在结束处显示省略号
    if ($end < $max_page) {
        if ($end < $max_page - 1) {
            echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
        }
        echo '<li class="page-item"><a class="page-link" href="?items='.$type.'&pp='.$max_page.'">'.$max_page.'</a></li>';
    }
    
    // 下一页按钮
    if ($paged < $max_page) {
        echo '<li class="page-item"><a class="page-link" href="?items='.$type.'&pp='.($paged+1).'" aria-label="Next"><i class="fa fa-angle-right"></i><span class="sr-only">Next</span></a></li>';
    }
    
    echo '</ul></nav>';
}

echo '<link rel="stylesheet" href="'.boxmoe_theme_url().'/assets/css/user_center.css">';
$items = isset($_GET["items"]) ? $_GET["items"] : 'home';
$current_user = wp_get_current_user();
?>
   <?php if(function_exists( 'mobantu_erphp_menu' )  ) {?>
    <section class="py-lg-7 py-5 user_center">
         <div class="container">
            <div class="row">
                <?php require_once(get_template_directory() . '/page/template/user-nav.php'); ?>
                <div class="col-lg-9 col-md-8">
                  <div class="card border-0 mb-4 shadow-sm">
                     <div class="card-body p-lg-5">
                        <div class="mb-3 d-lg-flex align-items-center justify-content-between">
                            <h3><?php 
                            $menu_names = array(
                                'home' => '个人中心',
                                'order' => '订单管理',
                                'vip' => '会员订阅',
                                'money' => '资产管理',
                                'recharge' => '充值记录',
                                'consumption' => '消费记录',
                                'collect' => '我的收藏',
                                'comment' => '我的评论',
                                'password' => '修改密码'
                            );
                            echo isset($menu_names[$items]) ? $menu_names[$items] : $items;
                            ?></h3>
                           <div class="mt-3 mt-lg-0 d-md-flex">
                              <?php if(get_option('ice_ali_money_checkin')):?>
                                 <?php if(erphpdown_check_checkin($current_user->ID)):?>
                                    <span class="btn btn btn-secondary me-2">已签到</span>
                                 <?php else:?>
                                    <a href="javascript:;" id="boxmoe-checkin-today" class="btn btn-outline-primary me-2">今日签到</a>
                                 <?php endif;?>
                              <?php endif;?>
                              <a href="?items=money" class="btn btn-outline-primary">
                                 积分充值
                                 <span class="ms-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-arrow-up-right-circle-fill" viewBox="0 0 16 16">
                                       <path d="M0 8a8 8 0 1 0 16 0A8 8 0 0 0 0 8zm5.904 2.803a.5.5 0 1 1-.707-.707L9.293 6H6.525a.5.5 0 1 1 0-1H10.5a.5.5 0 0 1 .5.5v3.975a.5.5 0 0 1-1 0V6.707l-4.096 4.096z"></path>
                                    </svg>
                                 </span>
                              </a>
                           </div>
                        </div>
                        <div class="table-responsive mb-3">
                              <table class="table table-centered td table-centered th table-lg text-nowrap">
                                 <tbody>
                                    <tr>
                                       <th scope="row">
                                          <div class="d-flex align-items-center">
                                          <img id="user-avatar"  src="<?php echo boxmoe_get_avatar_url($current_user->ID,100); ?>"  class="avatar rounded-3 img-fluid" alt="avatar">  
                                             <div class="ms-3">
                                                <div class="fs-5 fw-semibold text-dark"><?php echo get_user_meta(get_current_user_id(), 'nickname', true); ?> (ID:<?php echo $current_user->ID; ?>)</div>
                                                <small>会员等级：<?php echo boxmoe_vip_name(); ?> <?php echo boxmoe_vip_pic(); ?> 到期时间：<?php echo boxmoe_vip_time(); ?></small>
                                             </div>
                                             <div class="ms-3">
                                                <div class="fs-6 fw-semibold text-dark">最近登录</div>
                                                <small><?php echo get_user_meta(get_current_user_id(), 'last_login_time', true); ?></small>
                                             </div>
                                             <div class="ms-3">
                                                <div class="fs-6 fw-semibold text-dark">登录IP</div>
                                                <small><?php echo get_user_meta(get_current_user_id(), 'last_login_ip', true); ?></small>
                                             </div>
                                          </div>
                                       </th>
                                    </tr>
                                 </tbody>
                              </table>
                        </div>                
                <?php if($items == 'home'){?>
                    <?php require_once(get_template_directory() . '/page/template/user-home.php'); ?>
                <?php }elseif($items == 'order'){?>
                    <?php require_once(get_template_directory() . '/page/template/user-order.php'); ?>
                <?php }elseif($items == 'vip'){?>
                    <?php require_once(get_template_directory() . '/page/template/user-vip.php'); ?>
                <?php }elseif($items == 'money'){?>
                    <?php require_once(get_template_directory() . '/page/template/user-money.php'); ?>
                <?php }elseif($items == 'recharge'){?>
                    <?php require_once(get_template_directory() . '/page/template/user-recharge.php'); ?>
                <?php }elseif($items == 'consumption'){?>
                    <?php require_once(get_template_directory() . '/page/template/user-consumption.php'); ?>
                <?php }elseif($items == 'collect'){?>
                    <?php require_once(get_template_directory() . '/page/template/user-collect.php'); ?>
                <?php }elseif($items == 'comment'){?>
                    <?php require_once(get_template_directory() . '/page/template/user-comment.php'); ?>
                <?php }elseif($items == 'password'){?>
                    <?php require_once(get_template_directory() . '/page/template/user-password.php'); ?>
                <?php }?>
                </div>
                  </div>
               </div>

            </div>
         </div>
      </section>
      <?php }else{ ?> 
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
   				<span class="alert-text"> 提示：会员中心必须配套Erphpdown插件使用，检测网站未启用或者未安装该插件！<a href="https://www.boxmoe.com/468.html" target="_blank" style="font-weight: bold;color: #121211;font-size: 15px;">详细点击查看说明</a> 
               <a href="https://www.boxmoe.com/443.html" target="_blank" style="font-weight: bold;font-size: 15px;">破解版插件购买</a></span>
				</div>
				</div>
				</div>				
				</div>				
				</div>
            </div>
            </div>
         </section>
      <?php } ?>
<?php
get_footer();
?>  
<script type="text/javascript" src="<?php echo boxmoe_theme_url(); ?>/assets/js/user_center.js"></script>



