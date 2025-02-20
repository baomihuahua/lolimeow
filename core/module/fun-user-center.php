<?php
/**
 * @link https://www.boxmoe.com
 * @package lolimeow
 */
//boxmoe.com===安全设置=阻止直接访问主题文件
if(!defined('ABSPATH')){echo'Look your sister';exit;}

// 头像上传处理
add_action('wp_ajax_upload_avatar', 'boxmoe_upload_avatar');

function boxmoe_upload_avatar() {
    if (!is_user_logged_in()) {
        wp_send_json_error(['message' => '请先登录']);
        return;
    }
    $nonce = $_POST['nonce'];
    if (!wp_verify_nonce($nonce, 'boxmoe_ajax_nonce')) {
        wp_send_json_error(['message' => '非法请求']);
        return;
    }

    if (!isset($_FILES['avatar']) || $_FILES['avatar']['error'] !== UPLOAD_ERR_OK) {
        wp_send_json_error(['message' => '文件上传失败']);
        return;
    }

    $file = $_FILES['avatar'];
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $max_size = 1 * 1024 * 1024; // 1MB

    if (!in_array($file['type'], $allowed_types)) {
        wp_send_json_error(['message' => '只支持 JPEG、PNG 和 GIF 格式']);
        return;
    }

    if ($file['size'] > $max_size) {
        wp_send_json_error(['message' => '文件大小不能超过1MB']);
        return;
    }
    $upload_dir = WP_CONTENT_DIR . '/uploads/useravatar';
    if (!file_exists($upload_dir)) {
        wp_mkdir_p($upload_dir);
    }
    $user_id = get_current_user_id();
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $random_string = wp_generate_password(8, false);
    $filename = $user_id . '_' . $random_string . '.' . $extension;
    $filepath = $upload_dir . '/' . $filename;
    $old_avatar = get_user_meta($user_id, 'user_avatar', true);
    if ($old_avatar) {
        $old_filepath = WP_CONTENT_DIR . str_replace(content_url(), '', $old_avatar);
        if (file_exists($old_filepath)) {
            unlink($old_filepath);
        }
    }
    if (move_uploaded_file($file['tmp_name'], $filepath)) {
        $avatar_url = content_url() . '/uploads/useravatar/' . $filename;
        update_user_meta($user_id, 'user_avatar', $avatar_url);

        wp_send_json_success([
            'message' => '头像上传成功',
            'avatar_url' => $avatar_url
        ]);
    } else {
        wp_send_json_error(['message' => '文件上传失败，请重试']);
    }
}

// 用户信息更新处理
add_action('wp_ajax_update_user_profile', 'boxmoe_update_user_profile');

function boxmoe_update_user_profile() {
    if (!is_user_logged_in()) {
        wp_send_json_error(['message' => '请先登录']);
        return;
    }

    $nonce = $_POST['nonce'];
    if (!wp_verify_nonce($nonce, 'boxmoe_ajax_nonce')) {
        wp_send_json_error(['message' => '非法请求']);
        return;
    }

    $user_id = get_current_user_id();
    $display_name = sanitize_text_field($_POST['display_name']);
    $user_url = esc_url_raw($_POST['user_url']);
    $description = sanitize_textarea_field($_POST['description']);

    if (empty($display_name)) {
        wp_send_json_error(['message' => '昵称不能为空']);
        return;
    }

    $user_data = array(
        'ID' => $user_id,
        'display_name' => $display_name,
        'user_url' => $user_url,
        'description' => $description
    );

    $result = wp_update_user($user_data);

    if (is_wp_error($result)) {
        wp_send_json_error(['message' => $result->get_error_message()]);
    } else {
        wp_send_json_success(['message' => '个人资料更新成功']);
    }
}

// 用户密码更新处理
add_action('wp_ajax_update_user_password', 'boxmoe_update_user_password');

function boxmoe_update_user_password() {
    if (!is_user_logged_in()) {
        wp_send_json_error(['message' => '请先登录']);
        return;
    }

    $nonce = $_POST['nonce'];
    if (!wp_verify_nonce($nonce, 'boxmoe_ajax_nonce')) {
        wp_send_json_error(['message' => '非法请求']);
        return;
    }

    $user_id = get_current_user_id();
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // 验证输入不为空
    if (empty($old_password) || empty($new_password) || empty($confirm_password)) {
        wp_send_json_error(['message' => '请填写所有密码字段']);
        return;
    }

    // 验证新密码一致性
    if ($new_password !== $confirm_password) {
        wp_send_json_error(['message' => '新密码与确认密码不一致']);
        return;
    }

    // 验证新密码长度
    if (strlen($new_password) < 6) {
        wp_send_json_error(['message' => '新密码长度至少需要6个字符']);
        return;
    }

    // 验证旧密码是否正确
    $user = get_user_by('id', $user_id);
    if (!wp_check_password($old_password, $user->user_pass, $user_id)) {
        wp_send_json_error(['message' => '旧密码不正确']);
        return;
    }

    // 更新密码
    $result = wp_update_user([
        'ID' => $user_id,
        'user_pass' => $new_password
    ]);

    if (is_wp_error($result)) {
        wp_send_json_error(['message' => $result->get_error_message()]);
    } else {
        wp_send_json_success(['message' => '密码修改成功']);
    }
}


add_action('wp_ajax_boxmoe_form_money_card', 'boxmoe_form_money_card');
add_action('wp_ajax_nopriv_boxmoe_form_money_card', 'boxmoe_form_money_card');

function boxmoe_form_money_card() {
	date_default_timezone_set('Asia/Shanghai');
	$erphp_aff_money = get_option('erphp_aff_money');
    if (isset($_POST['epdcardnum']) && !empty($_POST['epdcardnum']) &&
        isset($_POST['epdcardpass']) && !empty($_POST['epdcardpass'])) {
		$cardnum = esc_sql($_POST['epdcardnum']);
		$cardpass = esc_sql($_POST['epdcardpass']);
        $result = checkDoCardResult($cardnum, $cardpass);
        
        if ($result == '5') {
            wp_send_json_error(array('message' => '充值卡不存在'));
        } elseif ($result == '0') {
            wp_send_json_error(array('message' => '充值卡已被使用'));
        } elseif ($result == '2') {
            wp_send_json_error(array('message' => '充值卡密错误'));
        } elseif ($result == '1') {
            wp_send_json_success(array('message' => '充值成功'));
        } else {
            wp_send_json_error(array('message' => '系统超时，请稍后重试'));
        }
    } else {
        wp_send_json_error(array('message' => '参数缺失或无效'));
    }
    
    wp_die(); // 结束 AJAX 请求
}


add_action('wp_ajax_boxmoe_form_money_online', 'boxmoe_form_money_online');
add_action('wp_ajax_nopriv_boxmoe_form_money_online', 'boxmoe_form_money_online');

function boxmoe_form_money_online() {
	if(isset($_POST['paytype']) && $_POST['paytype']){
	   $paytype=esc_sql(intval($_POST['paytype']));
 
	   if(isset($_POST['paytype']) && $paytype==1)
	   {
		  $url=constant("erphpdown")."payment/alipay.php?ice_money=".esc_sql($_POST['ice_money']);
	   }
	   elseif(isset($_POST['paytype']) && $paytype==5)
	   {
		  $url=constant("erphpdown")."payment/f2fpay.php?ice_money=".esc_sql($_POST['ice_money']);
	   }
	   elseif(isset($_POST['paytype']) && $paytype==2)
	   {
		  $url=constant("erphpdown")."payment/paypal.php?ice_money=".esc_sql($_POST['ice_money']);
	   }
	   elseif(isset($_POST['paytype']) && $paytype==4)
	   {
		  if(erphpdown_is_weixin() && get_option('ice_weixin_app')){
			 $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.get_option('ice_weixin_appid').'&redirect_uri='.urlencode(constant("erphpdown")).'payment%2Fweixin.php%3Fice_money%3D'.esc_sql($_POST['ice_money']).'&response_type=code&scope=snsapi_base&state=STATE&connect_redirect=1#wechat_redirect';
		  }else{
			 $url=constant("erphpdown")."payment/weixin.php?ice_money=".esc_sql($_POST['ice_money']);
		  }
	   }
	   elseif(isset($_POST['paytype']) && $paytype==7)
	   {
		  $url=constant("erphpdown")."payment/paypy.php?ice_money=".esc_sql($_POST['ice_money']);
	   }
	   elseif(isset($_POST['paytype']) && $paytype==8)
	   {
		  $url=constant("erphpdown")."payment/paypy.php?ice_money=".esc_sql($_POST['ice_money'])."&type=alipay";
	   }
	   elseif(isset($_POST['paytype']) && $paytype==18)
	   {
		  $url=constant("erphpdown")."payment/xhpay3.php?ice_money=".esc_sql($_POST['ice_money'])."&type=2";
	   }
	   elseif(isset($_POST['paytype']) && $paytype==17)
	   {
		  $url=constant("erphpdown")."payment/xhpay3.php?ice_money=".esc_sql($_POST['ice_money'])."&type=1";
	   }elseif(isset($_POST['paytype']) && $paytype==19)
	   {
		  $url=constant("erphpdown")."payment/payjs.php?ice_money=".esc_sql($_POST['ice_money']);
	   }elseif(isset($_POST['paytype']) && $paytype==20)
	   {
		  $url=constant("erphpdown")."payment/payjs.php?ice_money=".esc_sql($_POST['ice_money'])."&type=alipay";
	   }
	   elseif(isset($_POST['paytype']) && $paytype==13)
	   {
		  $url=constant("erphpdown")."payment/codepay.php?ice_money=".esc_sql($_POST['ice_money'])."&type=1";
	   }elseif(isset($_POST['paytype']) && $paytype==14)
	   {
		  $url=constant("erphpdown")."payment/codepay.php?ice_money=".esc_sql($_POST['ice_money'])."&type=3";
	   }elseif(isset($_POST['paytype']) && $paytype==15)
	   {
		  $url=constant("erphpdown")."payment/codepay.php?ice_money=".esc_sql($_POST['ice_money'])."&type=2";
	   }
	   elseif(isset($_POST['paytype']) && $paytype==21)
	   {
		  $url=constant("erphpdown")."payment/epay.php?ice_money=".esc_sql($_POST['ice_money'])."&type=alipay";
	   }elseif(isset($_POST['paytype']) && $paytype==22)
	   {
		  $url=constant("erphpdown")."payment/epay.php?ice_money=".esc_sql($_POST['ice_money'])."&type=wxpay";
	   }elseif(isset($_POST['paytype']) && $paytype==23)
	   {
		  $url=constant("erphpdown")."payment/epay.php?ice_money=".esc_sql($_POST['ice_money'])."&type=qqpay";
	   }elseif(isset($_POST['paytype']) && $paytype==31)
	   {
		  $url=constant("erphpdown")."payment/vpay.php?ice_money=".esc_sql($_POST['ice_money'])."&type=2";
	   }elseif(isset($_POST['paytype']) && $paytype==32)
	   {
		  $url=constant("erphpdown")."payment/vpay.php?ice_money=".esc_sql($_POST['ice_money']);
	   }elseif(isset($_POST['paytype']) && $paytype==41)
	   {
		  $url=constant("erphpdown")."payment/easepay.php?ice_money=".esc_sql($_POST['ice_money'])."&type=alipay";
	   }elseif(isset($_POST['paytype']) && $paytype==42)
	   {
		  $url=constant("erphpdown")."payment/easepay.php?ice_money=".esc_sql($_POST['ice_money'])."&type=wxpay";
	   }elseif(isset($_POST['paytype']) && $paytype==43)
	   {
		  $url=constant("erphpdown")."payment/easepay.php?ice_money=".esc_sql($_POST['ice_money'])."&type=usdt";
	   }elseif(isset($_POST['paytype']) && $paytype==50)
	   {
		  $url=home_url('?epd_r64='.base64_encode('usdt-'.esc_sql($_POST['ice_money']).'-'.time()));
	   }elseif(isset($_POST['paytype']) && $paytype==60)
	   {
		  $url=home_url('?epd_r64='.base64_encode('stripe-'.esc_sql($_POST['ice_money']).'-'.time()));
	   }elseif(plugin_check_ecpay() && isset($_POST['paytype']) && $paytype==70)
	   {
		  $url=ERPHPDOWN_ECPAY_URL."/ecpay.php?ice_money=".esc_sql($_POST['ice_money']);
	   }elseif(plugin_check_newebpay() && isset($_POST['paytype']) && $paytype==80)
	   {
		  $url=ERPHPDOWN_NEWEBPAY_URL."/newebpay.php?ice_money=".esc_sql($_POST['ice_money']);
	   }
	   wp_send_json_success(array('url' => $url));	
	}   	
}


add_action('wp_ajax_upgrade_vip', 'handle_vip_upgrade');

function handle_vip_upgrade() {
    // 检查nonce
    $nonce = $_POST['nonce'];
    if (!wp_verify_nonce($nonce, 'boxmoe_ajax_nonce')) {
        wp_send_json_error(array('message' => '安全验证失败'));
        return;
    }

    global $wpdb, $current_user;
    $vip_update_pay = get_option('vip_update_pay');
    $error = '';
    
    $userType = isset($_POST['userType']) && is_numeric($_POST['userType']) ? intval($_POST['userType']) : 0;
    $userType = esc_sql($userType);
    
    if($userType > 5 && $userType < 11) {
        $okMoney = erphpGetUserOkMoney();
        $priceArr = array(
            '6' => 'erphp_day_price',
            '7' => 'erphp_month_price',
            '8' => 'erphp_quarter_price',
            '9' => 'erphp_year_price',
            '10' => 'erphp_life_price'
        );
        $priceType = $priceArr[$userType];
        $price = get_option($priceType);

        $oldUserType = getUsreMemberTypeById($current_user->ID);
        
        // 处理会员升级差价逻辑
        if($vip_update_pay) {
            $erphp_quarter_price = get_option('erphp_quarter_price');
            $erphp_month_price = get_option('erphp_month_price');
            $erphp_day_price = get_option('erphp_day_price');
            $erphp_year_price = get_option('erphp_year_price');
            $erphp_life_price = get_option('erphp_life_price');

            // 计算升级差价
            if($userType == 7) {
                if($oldUserType == 6) {
                    $price = $erphp_month_price - $erphp_day_price;
                }
            } elseif($userType == 8) {
                if($oldUserType == 6) {
                    $price = $erphp_quarter_price - $erphp_day_price;
                } elseif($oldUserType == 7) {
                    $price = $erphp_quarter_price - $erphp_month_price;
                }
            } elseif($userType == 9) {
                if($oldUserType == 6) {
                    $price = $erphp_year_price - $erphp_day_price;
                } elseif($oldUserType == 7) {
                    $price = $erphp_year_price - $erphp_month_price;
                } elseif($oldUserType == 8) {
                    $price = $erphp_year_price - $erphp_quarter_price;
                }
            } elseif($userType == 10) {
                if($oldUserType == 6) {
                    $price = $erphp_life_price - $erphp_day_price;
                } elseif($oldUserType == 7) {
                    $price = $erphp_life_price - $erphp_month_price;
                } elseif($oldUserType == 8) {
                    $price = $erphp_life_price - $erphp_quarter_price;
                } elseif($oldUserType == 9) {
                    $price = $erphp_life_price - $erphp_year_price;
                }
            }
        }

        // 处理优惠码逻辑
        if(isset($_SESSION['erphp_promo_code']) && $_SESSION['erphp_promo_code']) {
            $promo = str_replace("\\","", $_SESSION['erphp_promo_code']);
            $promo_arr = json_decode($promo,true);
            if($promo_arr['type'] == 1) {
                $promo_money = get_option('erphp_promo_money1');
                if($promo_money) {
                    if(!$start_down2) {
                        $promo_money = $promo_money / get_option("ice_proportion_alipay");
                    }
                    $price = $price - $promo_money;
                }
            } elseif($promo_arr['type'] == 2) {
                $promo_money = get_option('erphp_promo_money2');
                if($promo_money) {
                    $price = $price * 0.1 * $promo_money;
                }
            }
        }

        // 处理升级结果
        if($price <= 0) {
            wp_send_json_error(array('message' => '价格有误'));
        } elseif($okMoney < $price) {
            wp_send_json_error(array('message' => '余额不足'));
        } elseif($okMoney >= $price) {
            if(erphpSetUserMoneyXiaoFei($price)) {
                if(userPayMemberSetData($userType)) {
                    addVipLog($price, $userType);
                    $EPD = new EPD();
                    $EPD->doAff($price, $current_user->ID);
                    wp_send_json_success(array('message' => '升级成功'));
                } else {
                    wp_send_json_error(array('message' => '系统超时，请稍后重试'));
                }
            } else {
                wp_send_json_error(array('message' => '系统超时，请稍后重试'));
            }
        } else {
            wp_send_json_error(array('message' => '系统超时，请稍后重试'));
        }
    } else {
        wp_send_json_error(array('message' => 'VIP类型错误'));
    }
}