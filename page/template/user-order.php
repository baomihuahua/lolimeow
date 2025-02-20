<?php
/**
 * @link https://www.boxmoe.com
 * @package lolimeow
 */
//boxmoe.com===安全设置=阻止直接访问主题文件
if(!defined('ABSPATH')){echo'Look your sister';exit;}
global $wpdb, $current_user;
$total_trade   = $wpdb->get_var("SELECT COUNT(ice_id) FROM $wpdb->icealipay WHERE ice_success>0 and ice_user_id=".$current_user->ID);
$ice_perpage = 20;
$pages = ceil($total_trade / $ice_perpage);
$page=isset($_GET['pp']) ?intval($_GET['pp']) :1;
$offset = $ice_perpage*($page-1);
$list = $wpdb->get_results("SELECT * FROM $wpdb->icealipay where ice_success=1 and ice_user_id=$current_user->ID order by ice_time DESC limit $offset,$ice_perpage");                       

?>
                        <div class="mb-5">
                           <p class="fs-7 mb-0 text-muted">订单列表</p>
                        </div>
                        <?php
                                 			if($list){
                                             foreach($list as $value){
                                                $start_down = get_post_meta( $value->ice_post, 'start_down', true );
                                                $start_down2 = get_post_meta( $value->ice_post, 'start_down2', true ); ?>
                        <div class="border py-3 px-4 rounded-3 mb-3">
                           <div class="d-flex justify-content-between">
                              <div class="d-flex">
                                 <i class="fa fa-cc-visa fa-2x me-3 text-primary"></i>
                                 <div>
                                    <h6 class="mb-0"><a href="<?php echo get_permalink($value->ice_post); ?>" target='_blank'><?php echo get_post($value->ice_post)->post_title; ?></a></h6>
                                    <small>
                                        <i class="fa fa-shopping-cart me-1"></i>订单号:<?php echo $value->ice_num;?> 
                                        <i class="fa fa-clock-o ms-2 me-1"></i>下单时间:<?php echo $value->ice_time;?> 
                                        <i class="fa fa-jpy ms-2 me-1"></i>价格:<?php echo $value->ice_price;?>
                                    </small>
                                 </div>
                              </div>
                              <div class="d-flex align-items-center">
                                 <?php if($start_down || $start_down2): ?>
                                    <a class="btn btn-outline-primary btn-sm" href="<?php echo constant("erphpdown").'download.php?postid='.$value->ice_post.'&index='.$value->ice_index.'&timestamp='.time(); ?>" target="_blank">点击下载</a>
                                 <?php else: ?>
                                    <a class="btn btn-outline-primary btn-sm" href="<?php echo get_permalink($value->ice_post); ?>" target="_blank">查看</a>                                    
                                 <?php endif; ?>
                              </div>
                           </div>
                        </div>
                     <?php }
                     }else{
                        ?>
                        <div class="border py-3 px-4 rounded-3">
                           <div class="d-flex justify-content-between">
                              暂无订单
                           </div>
                        </div>
                        <?php } ?>
                        <div class="mt-4">
                           <?php mobantu_paging('order',$page,$pages);?>	
                           </div>
                        
