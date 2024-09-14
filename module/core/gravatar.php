<?php
/**
 * @link https://www.boxmoe.com
 * @package lolimeow
 */
// 处理头像
add_action('admin_post_upload_avatar', 'boxmoe_avatar_upload');
add_action('admin_post_nopriv_upload_avatar', 'boxmoe_avatar_upload');

function boxmoe_avatar_upload() {
    if (!is_user_logged_in()) {
        wp_send_json_error(['message' => '请登录后再进行上传']);
    }    
    if (empty($_FILES['file'])) {
        wp_send_json_error(['message' => '没有文件上传']);
    }
    $file = $_FILES['file'];
    // 限制文件大小为 1MB (1048576 bytes)
    $max_size = 1048576;
    if ($file['size'] > $max_size) {
        wp_send_json_error(['message' => '文件大小超过限制，最大为 1MB']);
    }
    // 允许的文件类型
    $allowed_types = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    if (!in_array($file['type'], $allowed_types)) {
        wp_send_json_error(['message' => '不允许的文件类型']);
    }
    // 使用 WordPress 的 wp_handle_upload 处理文件上传
    $upload = wp_handle_upload($file, ['test_form' => false]);
    if (isset($upload['file'])) {
        $filename = $upload['file'];
        $wp_filetype = wp_check_filetype($filename, null);        
        // 定义目标文件夹
        $upload_dir = wp_upload_dir();
        $target_dir = $upload_dir['basedir'] . '/user_avatar/';        
        // 创建目标文件夹（如果不存在）
        if (!file_exists($target_dir)) {
            wp_mkdir_p($target_dir);
        }      
        // 新文件名和路径
        $pathinfo = pathinfo($filename);
        $user_id = get_current_user_id(); // 获取当前用户ID
        $new_filename = $user_id . '_' . $pathinfo['basename'];
        $new_filepath = $target_dir . $new_filename;       
        // 移动文件到指定目录
        rename($filename, $new_filepath);      
        // 获取文件的URL
        $url = wp_get_upload_dir()['baseurl'] . '/user_avatar/' . $new_filename;    
        // 更新用户头像
        update_user_meta($user_id, 'user_avatar', $url);
        $avatar_url ='<img src="' . $url . '"class="avatar" alt="avatar" />';
        wp_send_json_success(['url' => $avatar_url]);
    } else {
        wp_send_json_error(['message' => '上传失败']);
    }
}

//头像输出
//Gravatar头像加速
function boxmoe_getavatar_host() {
    $gravatarUrl = 'gravatar.loli.net/avatar';
    switch (get_boxmoe('gravatar_url')) {
        case 'cn':
            $gravatarUrl = 'cn.gravatar.com/avatar';
            break;
        case 'ssl':
            $gravatarUrl = 'secure.gravatar.com/avatar';
            break;
        case 'lolinet':
            $gravatarUrl = 'gravatar.loli.net/avatar';
            break;
        //case 'v2excom':
        //			$gravatarUrl = 'cdn.v2ex.com/gravatar';
        //break;
        case 'qiniu':
            $gravatarUrl = 'dn-qiniu-avatar.qbox.me/avatar';
            break;
        case 'geekzu':
            $gravatarUrl = 'fdn.geekzu.org/avatar';
            break;
        case 'cravatar':
            $gravatarUrl = 'cravatar.cn/avatar';
            break;
        default:
            $gravatarUrl = 'cravatar.cn/avatar';
    }
    return $gravatarUrl;
}
//function boxmoe_get_avatar($avatar) {
//	$avatar = str_replace(array("www.gravatar.com/avatar","0.gravatar.com/avatar","1.gravatar.com/avatar","2.gravatar.com/avatar","secure.gravatar.com/avatar"), boxmoe_getavatar_host(), $avatar);
//	return $avatar;
//}
//add_filter( 'get_avatar', 'boxmoe_get_avatar', 10, 3 );

//QQ头像节点
function boxmoe_qqavatar_host() {
    $qqravatarUrl = 'q2.qlogo.cn';
    switch (get_boxmoe('qqavatar_url')) {
        case 'Q1':
            $qqravatarUrl = 'q1.qlogo.cn';
            break;
        case 'Q2':
            $qqravatarUrl = 'q2.qlogo.cn';
            break;
        case 'Q3':
            $qqravatarUrl = 'q3.qlogo.cn';
            break;
        case 'Q4':
            $qqravatarUrl = 'q4.qlogo.cn';
        default:
            $qqravatarUrl = 'q2.qlogo.cn';
    }
    return $qqravatarUrl;
}

add_filter('get_avatar', 'boxmoe_qq_avatar', 10, 2);
function boxmoe_qq_avatar($avatar, $id_or_email) {
    $email = '';
    $user_id = '';
    if (is_numeric($id_or_email)) {
        $id   = (int) $id_or_email;
        $user = get_userdata($id);
        $user_id = $id_or_email;
        if ($user)
            $email = $user->user_email;
            $user_id = $user->ID;
    } else if (is_object($id_or_email)) {
        $user_id = $id_or_email->user_id;
        if (!empty($user_id)) {
            $id   = (int) $id_or_email->user_id;
            $user = get_userdata($id);
            if ($user)
                $email = $user->user_email;
                $user_id = $user->ID;
        } else if (!empty($id_or_email->comment_author_email)) {
            $email = $id_or_email->comment_author_email;
        }
    } else {
        $email = $id_or_email;
    }
    $hash       = md5(strtolower(trim($email)));
    $gavatarurl = 'https://' . boxmoe_getavatar_host() . '/' . $hash;


    if (isset($user_id)) {
        $user_avatar_url = get_user_meta($user_id, 'user_avatar', true);
        if ($user_avatar_url) { 
            return '<img src="' . $user_avatar_url . ' "class="avatar" alt="avatar" />';
        }elseif (stripos($email, "@qq.com"))  {
            $qq = str_ireplace("@qq.com", "", $email);
            if (preg_match("/^\d+$/", $qq)) {
                $qqavatar = "https://" . boxmoe_qqavatar_host() . "/headimg_dl?dst_uin=" . $qq . "&spec=100";
                return '<img src="' . $qqavatar . ' "class="avatar" alt="avatar" />';
            } else {
                return '<img src="' . $gavatarurl . ' "class="avatar" alt="avatar" />';
            }
        } else {
            return '<img src="' . $gavatarurl . ' "class="avatar" alt="avatar" />';
        }
    }elseif (stripos($email, "@qq.com"))  {
        $qq = str_ireplace("@qq.com", "", $email);
        if (preg_match("/^\d+$/", $qq)) {
            $qqavatar = "https://" . boxmoe_qqavatar_host() . "/headimg_dl?dst_uin=" . $qq . "&spec=100";
            return '<img src="' . $qqavatar . ' "class="avatar" alt="avatar" />';
        } else {
            return '<img src="' . $gavatarurl . ' "class="avatar" alt="avatar" />';
        }
    } else {
        return '<img src="' . $gavatarurl . ' "class="avatar" alt="avatar" />';
    }

}


