<?php
/**
 * @link https://www.boxmoe.com
 * @package lolimeow
 */
//boxmoe.com===安全设置=阻止直接访问主题文件
if(!defined('ABSPATH')){echo'Look your sister';exit;}
global $wpdb, $current_user;
                           $total_trade   = $wpdb->get_var("SELECT COUNT(ice_id) FROM $wpdb->icemoney where ice_user_id=".$current_user->ID." and ice_success=1");
                           $ice_perpage = 20;
                           $pages = ceil($total_trade / $ice_perpage);
                           $page=isset($_GET['pp']) ?intval($_GET['pp']) :1;
                           $offset = $ice_perpage*($page-1);
                           $list = $wpdb->get_results("SELECT * FROM $wpdb->icemoney where ice_user_id=".$current_user->ID." and ice_success=1 order by ice_time DESC limit $offset,$ice_perpage");
                        
?>
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
                                                echo "<td>".__('在线线充值','erphpdown')."</td>\n";
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