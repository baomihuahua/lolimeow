<?php
/**
 * @link https://www.boxmoe.com
 * @package lolimeow
 */
//boxmoe.com===安全设置=阻止直接访问主题文件
if(!defined('ABSPATH')){echo'Look your sister';exit;}

?>

                        <div class="row gx-4">
                           <div class="col-lg-3">
                              <div class="card border-0 mb-4 mb-lg-0 bg-light-subtle">
                                 <div class="card-body py-lg-3 px-lg-4">
                                    <div class="mb-5">
                                       <h6>积分余额</h6>
                                       <h4><?php echo boxmoe_user_money(); ?></h4>
                                    </div>
                                    <a href="?items=recharge" class="icon-link icon-link-hover text-primary">
                                       查看充值记录
                                       <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                          <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z">
                                          </path>
                                       </svg>
                                    </a>
                                 </div>
                              </div>
                           </div>
                           <div class="col-lg-3">
                              <div class="card border-0 mb-4 mb-lg-0 bg-light-subtle">
                                 <div class="card-body py-lg-3 px-lg-4">
                                    <div class="mb-5">
                                       <h6>累计消耗</h6>
                                       <h4><?php echo boxmoe_user_moneyto(); ?></h4>
                                    </div>

                                    <a href="?items=money" class="icon-link icon-link-hover text-primary">
                                       前往充值
                                       <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                          <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z">
                                          </path>
                                       </svg>
                                    </a>
                                 </div>
                              </div>
                           </div>
                           <div class="col-lg-3">
                              <div class="card border-0 mb-4 mb-lg-0 bg-light-subtle">
                                 <div class="card-body py-lg-3 px-lg-4">
                                    <div class="mb-5">
                                       <h6>收藏文章</h6>
                                       <h4><?php 
                                       $current_user_id = get_current_user_id();
                                       $favorites = get_user_meta($current_user_id, 'user_favorites', true);
                                       echo (!empty($favorites) && is_array($favorites)) ? count($favorites) : '0';
                                       ?>条</h4>
                                    </div>
                                    <a href="?items=collect" class="icon-link icon-link-hover text-primary">
                                       查看收藏文章
                                       <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                          <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z">
                                          </path>
                                       </svg>
                                    </a>
                                 </div>
                              </div>
                           </div>
                           <div class="col-lg-3">
                              <div class="card border-0 mb-4 mb-lg-0 bg-light-subtle">
                                 <div class="card-body py-lg-3 px-lg-4">
                                    <div class="mb-5">
                                       <h6>累计评论</h6>
                                       <h4><?php global $user_ID;echo get_comments('count=true&user_id='.$user_ID);?>条</h4>
                                    </div>
                                    <a href="?items=comment" class="icon-link icon-link-hover text-primary">
                                       查看评论记录
                                       <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                          <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z">
                                          </path>
                                       </svg>
                                    </a>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="mt-5 mb-5">
                           <h4 class="mb-1">更新头像</h4>
                           <p class="mb-0 fs-7 text-muted">上传头像，让您的头像更加突出！</p>
                        </div>
                        <div class="d-flex align-items-center">
                           <div class="ms-4">
                            <form id="avatarForm">
                                <input type="file" id="avatarInput" accept="image/*" style="display: none;">
                                <button id="uploadAvatarButton" class="btn btn-outline-primary btn-sm mb-0 ms-2">上传头像</button>
                                <small class="ms-3">支持 *.jpeg, *.jpg, *.png, *.gif 最大1MB</small>
                            </form>
                           </div>                          
                        </div>
                        <div class="mt-5 mb-5">
                            <h4 class="mb-1">更新资料</h4>
                            <p class="mb-0 fs-7 text-muted">补全您的资料，让您的资料更加完整！</p>
                        </div>
                        <form class="row g-3 needs-validation" novalidate="" id="profileUpdateForm">
                           <div class="col-lg-6 col-md-12">
                              <label for="user_login" class="form-label">用户名<small class="text-muted">（不可修改）</small></label>
                              <input type="text" disabled class="form-control" id="user_login" value="<?php echo $current_user->user_login; ?>" >
                           </div>
                           <div class="col-lg-6 col-md-12">
                              <label for="user_email" class="form-label">邮箱<small class="text-muted">（不可修改）</small></label>
                              <input type="text" disabled class="form-control" id="user_email" value="<?php echo $current_user->user_email; ?>" >
                           </div>
                           <div class="col-lg-6">
                              <label for="display_name" class="form-label">昵称</label>
                              <input type="text" class="form-control input-phone" id="display_name" value="<?php echo $current_user->display_name; ?>">
                              <div class="invalid-feedback">请输入昵称。</div>
                           </div>
                           <div class="col-lg-6">
                              <label for="profileBiruser_urlthdayInput" class="form-label">网站</label>
                              <input type="text" class="form-control input-date" id="user_url"  value="<?php echo $current_user->user_url; ?>" >
                              <div class="invalid-feedback">请输入网站。</div>
                           </div>
                           <div class="col-lg-12">
                              <label for="user_description" class="form-label">个性签名</label>
                              <textarea class="form-control" id="user_description" rows="3"><?php echo $current_user->user_description; ?></textarea>
                              <div class="invalid-feedback">请输入个性签名。</div>
                           </div>
                           <div class="col-12 mt-4">
                              <button class="btn btn-primary me-2" type="submit" id="profileUpdateButton">保存修改</button>
                           </div>
                        </form>
