<?php
/**
 * @link https://www.boxmoe.com
 * @package lolimeow
 */
//boxmoe.com===安全设置=阻止直接访问主题文件
if(!defined('ABSPATH')){echo'Look your sister';exit;}

?>
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
               