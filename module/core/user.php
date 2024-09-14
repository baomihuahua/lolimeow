<?php
/**
 * @link https://www.boxmoe.com
 * @package lolimeow
 */
//链接输出
function get_login_url() {	
$id=get_boxmoe('users_login');
$output=the_permalink($id);
echo $output;
}
function get_reg_url() {	
$id=get_boxmoe('users_reg');
$output=the_permalink($id);
echo $output;
}
function get_reset_url() {	
$id=get_boxmoe('users_reset');
$output=the_permalink($id);
echo $output;
}
function get_user_url() {	
$id=get_boxmoe('users_page');
$output=the_permalink($id);
echo $output;
}


//中文注册用户名
if( get_boxmoe('sign_zhcn') ) {
	function boxmoe_sanitize_user ($username, $raw_username, $strict) {
		$username = wp_strip_all_tags( $raw_username );
		$username = remove_accents( $username );
		$username = preg_replace( '|%([a-fA-F0-9][a-fA-F0-9])|', '', $username );
		$username = preg_replace( '/&.+?;/', '', $username );
		if ($strict) {
			$username = preg_replace ('|[^a-z\p{Han}0-9 _.\-@]|iu', '', $username);
		}
		$username = trim( $username );
		$username = preg_replace( '|\s+|', ' ', $username );
		return $username;
	}
	add_filter ('sanitize_user', 'boxmoe_sanitize_user', 10, 3);
}
// 通过Email获取用户名登录
function boxmoe_allow_email_login($username, $raw_username, $strict) {
	if (filter_var($raw_username, FILTER_VALIDATE_EMAIL)) {
		$user_data = get_user_by('email', $raw_username);
		if (empty($user_data))
		      wp_die(__('<strong>ERROR</strong>: There is no user registered with that email address.'), '用户名不正确'); else
		      return $user_data->user_login;
	} else {
		return $username;
	}
}
if (strpos($_SERVER['REQUEST_URI'], '?action=register') === FALSE && strpos($_SERVER['REQUEST_URI'], '?action=lostpassword') === FALSE && strpos($_SERVER['REQUEST_URI'], '?action=rp') === FALSE ) {
	add_filter('sanitize_user', 'boxmoe_allow_email_login', 10, 3);
}

// 注册验证问题
add_action( 'register_form', 'add_security_question' );
function add_security_question() {
	?>
	    <p>
	    <label><?php _e('验证码:芝麻开门') ?><br />
	        <input type="text" name="user_proof" id="user_proof" class="input" size="25" tabindex="20" /></label>
	    </p>
	<?php
}
 
add_action( 'register_post', 'add_security_question_validate', 10, 3 );
function add_security_question_validate( $sanitized_user_login, $user_email, $errors) {
	// 如果没有回答
	if (!isset($_POST[ 'user_proof' ]) || empty($_POST[ 'user_proof' ])) {
		return $errors->add( 'proofempty', '<strong>错误</strong>: 您还没有回答问题。'  );
		// 如果答案不正确
	} elseif ( strtolower( $_POST[ 'user_proof' ] ) != '芝麻开门' ) {
		return $errors->add( 'prooffail', '<strong>错误</strong>: 您的回答不正确。'  );
	}
}

//透过代理或者cdn获取访客真实IP
function get_client_ip() {
	if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
	        $ip = getenv("HTTP_CLIENT_IP"); else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), 
	"unknown"))
	        $ip = getenv("HTTP_X_FORWARDED_FOR"); else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
	        $ip = getenv("REMOTE_ADDR"); else if (isset ($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] 
	&& strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
	        $ip = $_SERVER['REMOTE_ADDR']; else
	        $ip = "unknown";
	return ($ip);
}

// 创建一个新字段存储用户注册时的IP地址
add_action('user_register', 'log_ip');
function log_ip($user_id) {
	$ip = get_client_ip();
	update_user_meta($user_id, 'signup_ip', $ip);
}

// 创建新字段存储用户登录时间和登录IP
add_action( 'wp_login', 'insert_last_login' );
function insert_last_login( $login ) {
	global $user_id;
	$user = get_userdatabylogin( $login );
	update_user_meta( $user->ID, 'last_login', current_time( 'mysql' ) );
	$last_login_ip = get_client_ip();
	update_user_meta( $user->ID, 'last_login_ip', $last_login_ip);
}
// 添加额外的栏目
add_filter('manage_users_columns', 'add_user_additional_column');
function add_user_additional_column($columns) {
	$columns['user_nickname'] = '昵称';
	$columns['user_url'] = '网站';
	$columns['reg_time'] = '注册时间';
	$columns['last_login'] = '上次登录';
	// 打算将注册IP和注册时间、登录IP和登录时间合并显示，所以我注销下面两行
	/*$columns['signup_ip'] = '注册IP';
    $columns['last_login_ip'] = '登录IP';*/
	unset($columns['name']);
	//移除“姓名”这一栏，如果你需要保留，删除这行即可
	return $columns;
}
//显示栏目的内容
add_action('manage_users_custom_column',  'show_user_additional_column_content', 10, 3);
function show_user_additional_column_content($value, $column_name, $user_id) {
	$user = get_userdata( $user_id );
	// 输出“昵称”
	if ( 'user_nickname' == $column_name )
	        return $user->nickname;
	// 输出用户的网站
	if ( 'user_url' == $column_name )
	        return '<a href="'.$user->user_url.'" target="_blank">'.$user->user_url.'</a>';
	// 输出注册时间和注册IP
	if('reg_time' == $column_name ) {
		return get_date_from_gmt($user->user_registered) .'<br />'.get_user_meta( $user->ID, 'signup_ip', true);
	}
	// 输出最近登录时间和登录IP
	if ( 'last_login' == $column_name && $user->last_login ) {
		return get_user_meta( $user->ID, 'last_login', true ).'<br />'.get_user_meta( $user->ID, 'last_login_ip', true );
	}
	return $value;
}
// 默认按照注册时间排序
add_filter( "manage_users_sortable_columns", 'cmhello_users_sortable_columns' );
function cmhello_users_sortable_columns($sortable_columns) {
	$sortable_columns['reg_time'] = 'reg_time';
	return $sortable_columns;
}

//非管理员不允许进入后台
if( get_boxmoe('boxmoe_admin_off') ) {
if ( is_admin() && ( !defined( 'DOING_AJAX' ) || !DOING_AJAX ) ) {
	$current_user = wp_get_current_user();
	if($current_user->roles[0] == get_option('default_role')) {
		wp_safe_redirect( home_url() );
		exit();
	}
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
		  $url=constant("erphpdown")."payment/boxmoepay.php?ice_money=".esc_sql($_POST['ice_money']);
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

function user_comments_summary_shortcode($atts) {
    if (!is_user_logged_in()) {
        return '<p>Please log in to view your comments.</p>';
    }
    $current_user = wp_get_current_user();
    $paged = get_query_var('paged') ? get_query_var('paged') : 1;
    $comments_per_page = 20;
    $offset = ($paged - 1) * $comments_per_page;

    $comments = get_comments(array(
        'user_id' => $current_user->ID,
        'status'  => 'approve',
        'number'  => $comments_per_page,
        'offset'  => $offset,
    ));

    $total_comments = get_comments(array(
        'user_id' => $current_user->ID,
        'status'  => 'approve',
        'count'   => true,
    ));

    // 统计被回复的总数量
    $total_replies = 0;
    foreach ($comments as $comment) {
        $total_replies += get_comments(array(
            'parent' => $comment->comment_ID,
            'count'  => true,
        ));
    }
	$total_pages = ceil($total_comments / $comments_per_page);

	$output = '';
	$output .= '<div class="row gx-4">';
	$output .= '<div class="col-lg-6">';
	$output .= '   <div class="card border-0 mb-4 mb-lg-0 bg-light-subtle">';
	$output .= '	  <div class="card-body py-lg-3 px-lg-4">';
	$output .= '		 <div class="mb-1">';
	$output .= '			<h6>发出评论数</h6>';
	$output .= '			<h4>' . $total_comments . '条</h4>';
	$output .= '		 </div>';
	$output .= '	  </div>';
	$output .= '   </div>';
	$output .= '</div>';
	$output .= '<div class="col-lg-6">';
	$output .= '   <div class="card border-0 mb-4 mb-lg-0 bg-light-subtle">';
	$output .= '	  <div class="card-body py-lg-3 px-lg-4">';
	$output .= '		 <div class="mb-1">';
	$output .= '			<h6>被回复评论数</h6>';
	$output .= '			<h4>' . $total_replies . '条</h4>';
	$output .= '		 </div>';
	$output .= '	  </div>';
	$output .= '   </div>';
	$output .= '</div>';
	$output .= '</div>';
	$output .= '<div class="table-responsive border mt-4 mb-4 rounded-3 px-4 py-3">';
	$output .= '<table class="table table-hover">';
  	$output .= '<thead>';
    $output .= '<tr>';
    $output .= '  <th scope="col">评论内容</th>';
    $output .= '  <th scope="col">被回复数</th>';
    $output .= '  <th scope="col">查看原文</th>';
    $output .= '</tr>';
  	$output .= '</thead>';
  	$output .= '<tbody>';
	if (empty($comments)) {
	$output .= '  <tr>';
    $output .= '  <td colspan="3" align="center">你暂时还没有发出评论！</td>';
    $output .= '</tr>';        
    }else{
		foreach ($comments as $comment) {
			$replies_count = get_comments(array(
				'parent' => $comment->comment_ID,
				'count'  => true,
			));
			$comment_content = wp_trim_words($comment->comment_content, 10, '...');
			$comment_post_url = get_permalink($comment->comment_post_ID);
			$output .= '<tr>';
			$output .= '<td>' . esc_html($comment_content) . '</td>';
			$output .= '<td>' . intval($replies_count) . '</td>';
			$output .= '<td><a href="' . esc_url($comment_post_url) . '">查看原文</a></td>';
			$output .= '</tr>';
		}
	}
  	$output .= '</tbody>';
	$output .= '</table>';
	$output .= '</div>';
	$output .= '<div class="mt-4">';
	$output .= '<nav>';
	$output .= '<ul class="pagination pagination-sm">';
	for ($i = 1; $i <= $total_pages; $i++) {
		$current_page = max(1, get_query_var('paged', 1));
		$class = ($i === $current_page) ? ' active' : '';
	$output .= '<li class="page-item'.$class.'" ><a href="' . esc_url(add_query_arg('paged', $i)) . '" class="page-link">' . $i . '</a></li>';
	}
	$output .= '</ul>';
  	$output .= '</nav>';
	$output .= '</div>';	
    return $output;
}
add_shortcode('user_comments_summary', 'user_comments_summary_shortcode');


	add_action('wp_ajax_change_password', 'boxmoe_password_change');
	add_action('wp_ajax_nopriv_change_password', 'boxmoe_password_change');
	
	function boxmoe_password_change() {
		// 获取当前用户
		$user_id = get_current_user_id();
		
		if ($user_id == 0) {
			wp_send_json_error(['message' => '用户未登录']);
			return;
		}
		$current_password = $_POST['current_password'] ?? '';
		$new_password = $_POST['new_password'] ?? '';
		$confirm_password = $_POST['confirm_password'] ?? '';
	
		// 验证当前密码
		$user = get_userdata($user_id);
		if (!wp_check_password($current_password, $user->user_pass, $user_id)) {
			wp_send_json_error(array('message' => '当前密码不正确'));
		}
	
		// 检查新密码是否匹配
		if ($new_password !== $confirm_password) {
			wp_send_json_error(array('message' => '新密码不匹配'));
		}
	
		// 密码强度验证
		if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/', $new_password)) {
			wp_send_json_error(array('message' => '密码必须至少8个字符长，并包含至少一个大写字母、一个小写字母和一个数字'));
		}
	
		// 更新密码
		wp_set_password($new_password, $user_id);
	
		wp_send_json_success(array('message' => '密码更新成功'));
	}
	