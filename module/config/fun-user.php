<?php
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
//会员等级
function get_user_level() {
	$styleurls=get_template_directory_uri();
	$ciphp_year_price    = get_option('ciphp_year_price');
	$ciphp_quarter_price = get_option('ciphp_quarter_price');
	$ciphp_month_price  = get_option('ciphp_month_price');
	$ciphp_life_price  = get_option('ciphp_life_price');
	$userTypeId=getUsreMemberType();
	if($userTypeId==7) {
		echo '包月会员&nbsp;<img src="'.$styleurls.'/assets/images/vip/v2.jpg">';
	} elseif ($userTypeId==8) {
		echo '包季会员&nbsp;<img src="'.$styleurls.'/assets/images/vip/v3.jpg">';
	} elseif ($userTypeId==9) {
		echo '包年会员&nbsp;<img src="'.$styleurls.'/assets/images/vip/v4.jpg">';
	} elseif ($userTypeId==10) {
		echo '终身会员&nbsp;<img src="'.$styleurls.'/assets/images/vip/v5.jpg">';
	} else {
		echo '普通会员<img src="'.$styleurls.'/assets/images/vip/v1.jpg">';
	}
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
if ( is_admin() && ( !defined( 'DOING_AJAX' ) || !DOING_AJAX ) ) {
	$current_user = wp_get_current_user();
	if($current_user->roles[0] == get_option('default_role')) {
		wp_safe_redirect( home_url() );
		exit();
	}
}

