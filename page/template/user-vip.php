<?php
/**
 * @link https://www.boxmoe.com
 * @package lolimeow
 */
//boxmoe.com===安全设置=阻止直接访问主题文件
if(!defined('ABSPATH')){echo'Look your sister';exit;}


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
    
  ?>
           <div class="row g-4">    
        <?php if($erphp_day_price): ?>
                <div class="col-lg-4">
                    <div class="vip-card card h-100 border-0 shadow-hover">
                        <div class="card-body text-center p-4">
                            <div class="vip-level mb-3">
                                <img src="<?php echo boxmoe_theme_url(); ?>/assets/images/vip/v1.jpg">
                            </div>
                            <h5 class="card-title"><?php echo $erphp_day_name; ?></h5>
                            <h6 class="price mb-3"><?php echo $erphp_day_price;?><?php echo $moneyVipName;?><small>/天</small></h6>
                            <ul class="list-unstyled mb-4">
                                <li>有效期:<?php echo $erphp_day_days;?>天</li>
                            </ul>
                            <button class="btn btn-upgrade" 
                                    data-level="6" 
                                    data-price="<?php echo $erphp_day_price;?>" 
                                    data-type="<?php echo $erphp_day_name;?>" 
                                    data-days="<?php echo $erphp_day_days;?>">
                                立即升级
                            </button>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php if($erphp_month_price): 
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
            
            <div class="col-lg-4">
                <div class="vip-card card h-100 border-0 shadow-hover">
                    <div class="card-body text-center p-4">
                        <div class="vip-level mb-3">
                            <img src="<?php echo boxmoe_theme_url(); ?>/assets/images/vip/v2.jpg">
                        </div>
                        <h5 class="card-title"><?php echo $erphp_month_name; ?></h5>
                        <h6 class="price mb-3"><?php echo $old_price;?><?php echo $moneyVipName;?><small>/月</small></h6>
                        <ul class="list-unstyled mb-4">
                            <li>有效期:<?php echo $erphp_month_days;?>天</li>
                        </ul>
                        <button class="btn btn-upgrade" 
                                data-level="7" 
                                data-price="<?php echo $erphp_month_price;?>" 
                                data-type="<?php echo $erphp_month_name;?>" 
                                data-days="<?php echo $erphp_month_days;?>">
                            立即升级
                        </button>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <?php if($erphp_quarter_price):
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
            <div class="col-lg-4">
                <div class="vip-card card h-100 border-0 shadow-hover">
                    <div class="card-body text-center p-4">
                        <div class="vip-level mb-3">
                            <img src="<?php echo boxmoe_theme_url(); ?>/assets/images/vip/v3.jpg">
                        </div>
                        <h5 class="card-title"><?php echo $erphp_quarter_name; ?></h5>
                        <h6 class="price mb-3"><?php echo $old_price;?><?php echo $moneyVipName;?><small>/季</small></h6>
                        <ul class="list-unstyled mb-4">
                            <li>有效期:<?php echo $erphp_quarter_days;?>个月</li>
                        </ul>
                        <button class="btn btn-upgrade" 
                                data-level="8" 
                                data-price="<?php echo $erphp_quarter_price;?>" 
                                data-type="<?php echo $erphp_quarter_name;?>" 
                                data-days="<?php echo $erphp_quarter_days;?>">
                            立即升级
                        </button>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <?php if($erphp_year_price): 
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
            <div class="col-lg-4">
                <div class="vip-card card h-100 border-0 shadow-hover">
                    <div class="card-body text-center p-4">
                        <div class="vip-level mb-3">
                            <img src="<?php echo boxmoe_theme_url(); ?>/assets/images/vip/v4.jpg">
                        </div>
                        <h5 class="card-title"><?php echo $erphp_year_name; ?></h5>
                        <h6 class="price mb-3"><?php echo $old_price;?><?php echo $moneyVipName;?><small>/年</small></h6>
                        <ul class="list-unstyled mb-4">
                            <li>有效期:<?php echo $erphp_year_days;?>个月</li>
                        </ul>
                        <button class="btn btn-upgrade" 
                                data-level="9" 
                                data-price="<?php echo $erphp_year_price;?>" 
                                data-type="<?php echo $erphp_year_name;?>" 
                                data-days="<?php echo $erphp_year_days;?>">
                            立即升级
                        </button>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <?php if($erphp_life_price): 
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
            <div class="col-lg-4">
                <div class="vip-card card h-100 border-0 shadow-hover">
                    <div class="card-body text-center p-4">
                        <div class="vip-level mb-3">
                            <img src="<?php echo boxmoe_theme_url(); ?>/assets/images/vip/v5.jpg">
                        </div>
                        <h5 class="card-title"><?php echo $erphp_life_name; ?></h5>
                        <h6 class="price mb-3"><?php echo $old_price;?><?php echo $moneyVipName;?><small>/终身</small></h6>
                        <ul class="list-unstyled mb-4">
                            <li>有效期:永久</li>
                        </ul>
                        <button class="btn btn-upgrade" 
                                data-level="10" 
                                data-price="<?php echo $erphp_life_price;?>" 
                                data-type="<?php echo $erphp_life_name;?>" 
                                data-days="永久">
                            立即升级
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        </div>

