<?php
/**
 * @link https://www.boxmoe.com
 * @package lolimeow
 */
//boxmoe.com===安全设置=阻止直接访问主题文件
if(!defined('ABSPATH')){echo'Look your sister';exit;}

?>
                <div class="col-lg-3 col-md-4">
                  <div class="d-flex align-items-center mb-4 justify-content-center justify-content-md-start">
                     <img src="<?php echo boxmoe_get_avatar_url($current_user->ID,100); ?>" alt="avatar" class="avatar avatar-lg rounded-circle">
                     <div class="ms-3">
                        <h5 class="mb-0"><?php echo $current_user->display_name; ?></h5>
                        <small><?php echo $current_user->user_email; ?></small>
                     </div>
                  </div>


                  <div class="d-md-none text-center d-grid">
                     <button class="btn btn-light mb-3 d-flex align-items-center justify-content-between" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAccountMenu" aria-expanded="false" aria-controls="collapseAccountMenu">
                        用户导航
                        <i class="fa fa-angle-down ms-2"></i>
                     </button>
                  </div>
                  <style>
                    .nav-account .nav-link i.fa {
                      font-size: 16px;
                      width: 20px;
                      text-align: center;
                    }
                  </style>
                  <div class="collapse d-md-block" id="collapseAccountMenu">
                     <ul class="nav flex-column nav-account">
                        <li class="nav-item">
                           <a class="nav-link <?php if($items == 'home') {?>active<?php }?>" href="?items=home">
                              <i class="align-bottom fa fa-user"></i>
                              <span class="ms-2">用户中心</span>
                           </a>
                        </li>
                        <li class="nav-item">
                           <a class="nav-link <?php if($items == 'order') {?>active<?php }?>" href="?items=order">
                              <i class="align-bottom fa fa-shopping-cart"></i>
                              <span class="ms-2">订单管理</span>
                           </a>
                        </li>
                        <li class="nav-item">
                           <a class="nav-link <?php if($items == 'vip') {?>active<?php }?>" href="?items=vip">
                              <i class="align-bottom fa fa-diamond"></i>
                              <span class="ms-2">会员订阅</span>
                           </a>
                        </li>
                        <li class="nav-item">
                           <a class="nav-link <?php if($items == 'money') {?>active<?php }?>" href="?items=money">
                              <i class="align-bottom fa fa-money"></i>
                              <span class="ms-2">资产管理</span>
                           </a>
                        </li>
                        <li class="nav-item">
                           <a class="nav-link <?php if($items == 'recharge') {?>active<?php }?>" href="?items=recharge">
                              <i class="align-bottom fa fa-credit-card"></i>
                              <span class="ms-2">充值记录</span>
                           </a>
                        </li>
                        <li class="nav-item">
                           <a class="nav-link <?php if($items == 'collect') {?>active<?php }?>" href="?items=collect">
                              <i class="align-bottom fa fa-heart"></i>
                              <span class="ms-2">我的收藏</span>
                           </a>
                        </li>
                        <li class="nav-item">
                           <a class="nav-link <?php if($items == 'comment') {?>active<?php }?>" href="?items=comment">
                              <i class="align-bottom fa fa-comments"></i>
                              <span class="ms-2">评论内容</span>
                           </a>
                        </li>
                        <li class="nav-item">
                           <a class="nav-link <?php if($items == 'password') {?>active<?php }?>" href="?items=password">
                              <i class="align-bottom fa fa-lock"></i>
                              <span class="ms-2">修改密码</span>
                           </a>
                        </li>
                        <li class="nav-item">
                           <a class="nav-link" href="<?php echo wp_logout_url(home_url()); ?>">
                              <i class="align-bottom fa fa-sign-out"></i>
                              <span class="ms-2">退出登录</span>
                           </a>
                        </li>
                     </ul>
                  </div>
               </div>