<?php
/**
 * @link https://www.boxmoe.com
 * @package lolimeow
 */
 
 //解析短代码

//H2设置标
add_shortcode('h2set', 'h2set_shortcode');  
function h2set_shortcode( $attr , $content = '') {             
    $out ='<h2 class="section-title"><span><i class="fa fa-paint-brush"></i>'.$content.'</span></h2>';  
    return $out;  
} 

//H2下载标
add_shortcode('h2down', 'h2down_shortcode');  
function h2down_shortcode( $attr , $content = '') {             
    $out ='<h2 class="section-title"><span><i class="fa fa-cloud-download"></i>'.$content.'</span></h2>';  
    return $out;  
}

//下载按钮
add_shortcode('downloadbtn', 'downloadbtn_shortcode');  
function downloadbtn_shortcode( $attr , $content = ' ') {
	extract( shortcode_atts( array('link' => ''), $attr ) );
    $out ='<a href="'.esc_attr($attr['link']).'" rel="noopener" target="_blank" class="download_btn btn-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="该资源来源于网络如有侵权,请联系删除." data-container="body" data-animation="true">'.$content.'</a>';  
    return $out;  
}

//链接按钮
add_shortcode('linksbtn', 'linksbtn_shortcode');  
function linksbtn_shortcode( $attr , $content = ' ') {
	extract( shortcode_atts( array('link' => ''), $attr ) );
    $out ='<a href="'.esc_attr($attr['link']).'" rel="noopener" target="_blank" class="links_btn" >'.$content.'</a>';  
    return $out;  	
}

//blockquote1
add_shortcode('blockquote1', 'blockquote1_shortcode');  
function blockquote1_shortcode( $attr , $content = ' ') {
	extract( shortcode_atts( array('name' => ''), $attr ) );
    $out ='<div class="quote"><blockquote><p>'.$content.'</p><cite>'.esc_attr($attr['name']).'</cite></blockquote></div>';  
    return $out;  	
}

//blockquote2
add_shortcode('blockquote2', 'blockquote2_shortcode');  
function blockquote2_shortcode( $attr , $content = ' ') {
	extract( shortcode_atts( array('name' => ''), $attr ) );
    $out ='<div class="animated-border-quote"><blockquote><p>'.$content.'</p><cite>'.esc_attr($attr['name']).'</cite></blockquote></div>';  
    return $out;  	
}

//OL列表
add_shortcode( 'listol', 'listol_shortcode' );
function listol_shortcode( $atts, $content='' ) {
    extract( shortcode_atts( array('type' => '0'), $atts ) );
    $lists = explode("\n", $content);
    $output = null;
    foreach($lists as $li){
        if(trim($li) != '') {
            $output .= "<ol>{$li}</ol>\n";
        }
    }
    $outputs = "<ul class='ol'>\n".$output."</ul>\n";
    return $outputs;
}

//飞进来模块
add_shortcode('rollin', 'rollin_shortcode');  
function rollin_shortcode( $attr , $content = '') {             
    $out ='<div class="link-title wow rollIn">'.$content.'</div>';  
    return $out;  
}

//药丸
add_shortcode('yaowan', 'yaowan_shortcode');  
function yaowan_shortcode( $atts , $content = '') {
	extract( shortcode_atts( array('style' => '0'), $atts ) );
	$out = '';
	if($style=='1'){
        $out = '<span class="badge badge-primary mb-1 mt-1">'.$content.'</span>';
    }else 
	if($style=='2'){
		$out = '<span class="badge badge-secondary mb-1 mt-1">'.$content.'</span>';
	}else
	if($style=='3'){
		$out = '<span class="badge badge-info mb-1 mt-1">'.$content.'</span>';
	}else
	if($style=='4'){
		$out = '<span class="badge badge-success mb-1 mt-1">'.$content.'</span>';
	}else
	if($style=='5'){
		$out = '<span class="badge badge-danger mb-1 mt-1">'.$content.'</span>';
	}else
	if($style=='6'){
		$out = '<span class="badge badge-warning mb-1 mt-1">'.$content.'</span>';
	}else	
	if($style=='7'){
		$out = '<span class="badge badge-light mb-1 mt-1">'.$content.'</span>';
	}else
	if($style=='8'){
		$out = '<span class="badge badge-dark mb-1 mt-1">'.$content.'</span>';
	}else
	if($style=='9'){
		$out = '<span class="badge bg-gradient-primary mb-1 mt-1">'.$content.'</span>';
	}else	
	if($style=='10'){
		$out = '<span class="badge bg-gradient-secondary mb-1 mt-1">'.$content.'</span>';
	}else
	if($style=='11'){
		$out = '<span class="badge bg-gradient-info mb-1 mt-1">'.$content.'</span>';
	}else
	if($style=='12'){
		$out = '<span class="badge bg-gradient-success mb-1 mt-1">'.$content.'</span>';
	}else
	if($style=='13'){
		$out = '<span class="badge bg-gradient-danger mb-1 mt-1">'.$content.'</span>';
	}else
	if($style=='14'){
		$out = '<span class="badge bg-gradient-warning mb-1 mt-1">'.$content.'</span>';
	}else
	if($style=='15'){
		$out = '<span class="badge bg-gradient-light mb-1 mt-1">'.$content.'</span>';
	}else
	if($style=='16'){
		$out = '<span class="badge bg-gradient-dark mb-1 mt-1">'.$content.'</span>';
	}else{
		$out = '<span class="badge bg-gradient-dark mb-1 mt-1">'.$content.'</span>';	
	}	
    return $out;  
}

//代码高亮
add_shortcode('precode', 'precode_shortcode');  
function precode_shortcode( $attr , $content = ' ') {
    $out ='<pre class="prettyprint linenums">'.$content.'</pre>';  
    return $out;  	
}

//Iframe
add_shortcode('iframe', 'iframe_shortcode');  
function iframe_shortcode( $attr , $content = ' ') {
	extract( shortcode_atts( array('link' => ''), $attr ) );
    $out ='<a href="javascript:;" data-fancybox data-type="iframe" data-src="'.esc_attr($attr['link']).'">'.$content.'</a>';  
    return $out;  	
}

//警告框
add_shortcode('alert', 'alert_shortcode');  
function alert_shortcode( $atts , $content = '') {
	extract( shortcode_atts( array('style' => '0'), $atts ) );
	$out = '';
	if($style=='1'){
        $out = '<div class="alert alert-primary" role="alert">'.$content.'</div>';
    }else 
	if($style=='2'){
		$out = '<div class="alert alert-secondary" role="alert">'.$content.'</div>';
	}else
	if($style=='3'){
		$out = '<div class="alert alert-info" role="alert">'.$content.'</div>';
	}else
	if($style=='4'){
		$out = '<div class="alert alert-success" role="alert">'.$content.'</div>';
	}else
	if($style=='5'){
		$out = '<div class="alert alert-danger" role="alert">'.$content.'</div>';
	}else
	if($style=='6'){
		$out = '<div class="alert alert-warning" role="alert">'.$content.'</div>';
	}else	
	if($style=='7'){
		$out = '<div class="alert alert-light" role="alert">'.$content.'</div>';
	}else
	if($style=='8'){
		$out = '<div class="alert alert-dark" role="alert">'.$content.'</div>';
	}else{
		$out = '<div class="alert alert-dark" role="alert">'.$content.'</div>';	
	}	
    return $out;  
}
//文章密码保护
add_shortcode('pwd_protected_post','password_protected_post');
function password_protected_post($atts, $content=null){
    extract(shortcode_atts(array('key'=>null), $atts));
    if(isset($_POST['password_key']) && $_POST['password_key']==$key){
        return '
		    <div class="alert alert-default" role="alert"><strong>温馨提示！</strong>以下是密码保护的内容！</div> 
			<div class="password_protected_post_content">'.$content.'</div>
		';
    }elseif(isset($_POST['password_key']) && $_POST['password_key']!=$key){
        return '
			<script>
				alert("密码错误，请仔细核对密码后重试！！！");
				window.location.href="'.get_permalink().'";
			</script>
		';
	
	}else{
        return '

		    <div class="alert alert-warning alert-dismissible fade show" role="alert">
		    <strong>注意！</strong>以下部分内容需要输入密码后才能查看！

		    </div>
		    <div class="row justify-content-center align-items-center">
            <div class="col-md-6">		
			<form class="mt20" action="'.get_permalink().'" method="post">
			<div class="input-group mb-3">
			<input type="password" id="password_key" name="password_key" class="form-control" placeholder="请输入密码查看隐藏内容" aria-label="请输入密码查看隐藏内容" aria-describedby="button-password_key">
			<button class="btn btn-outline-primary mb-0" type="submit" id="button-password_key">确  定</button>
			</div>
			</form>
			</div>
			</div>
		';
    }
}
//音频
add_shortcode('audio', 'audio_shortcode');  
function audio_shortcode( $attr , $content = ' ') {
	extract( shortcode_atts( array('link' => ''), $attr ) );
    $out ='<audio preload="none" controls="controls"><source type="audio/mpeg" src="'.esc_attr($attr['link']).'"></audio>';  
    return $out;  	
}
//音频preload=metadata
add_shortcode('video', 'video_shortcode');  
function video_shortcode( $attr , $content = ' ') {
	extract( shortcode_atts( array('link' => ''), $attr ) );
    $out ='<video preload="none" controls="controls" width="1080" height="1920"><source type="video/mp4" src="'.esc_attr($attr['link']).'"></video>';  
    return $out;  	
}



// 可视化编辑器添加下拉式按钮
function boxmoe_select(){
echo '
<select id="short_code_select">
    <option value="短代码选择！">Boxmoe短代码</option>
	<option value="[h2set]内容[/h2set]">H2设置标</option>	
	<option value="[h2down]内容[/h2down]">H2下载标</option>
	<option value="[downloadbtn link=\'链接\']按钮名称[/downloadbtn]">下载按钮</option>
	<option value="[linksbtn link=\'链接\']按钮名称[/linksbtn]">链接按钮</option>
	<option value="[blockquote1 name=\'签名\']内容[/blockquote1]">引用模块1</option>
	<option value="[blockquote2 name=\'签名\']内容[/blockquote2]">引用模块2</option>
	<option value="[listol]每行一条内容[/listol]">OL列表</option>
	<option value="[yaowan style=\'输入数字1-16共16个模式颜色\']内容[/yaowan]">药丸模块</option>
	<option value="[alert style=\'输入数字1-7共7个模式颜色\']内容[/alert]">警告框模块</option>
	<option value="[precode]内容[/precode]">代码高亮</option>
	<option value="[iframe link=\'链接\']内容[/iframe]">Iframe</option>
	<option value="[userreading]隐藏内容[/userreading]">登录查看一</option>
	<option value="[userreading notice=\'未登录时候显示的内容\']隐藏内容[/userreading]">登录查看二</option>
	<option value="[pwd_protected_post key=\'保护密码\']文章密码保护内容[/pwd_protected_post]">文章密码保护</option>
	<option value="[audio link=\'音频链接\'][/audio]">插入音频</option>
	<option value="[video link=\'视频链接\'][/video]">插入视频</option>
	<option value="<!--nextpage-->">文章分页</option>
	<option value="<div class=\'timeline timeline-one-side\' data-timeline-content=\'axis\' data-timeline-axis-style=\'dashed\'>
<div class=\'timeline-block\'>
<span class=\'timeline-step badge-success\'>
<i class=\'fa fa-bell\'></i>
</span>
<div class=\'timeline-content\'>
<small class=\'text-muted font-weight-bold\'>2021年1月1日</small
<h5 class=\' mt-3 mb-0\'>主题</h5>
<p class=\' text-sm mt-1 mb-0\'>内容段</p>
</div>
</div>
<!--时间段时间开始-->
<div class=\'timeline-block\'>
<span class=\'timeline-step badge-success\'>
<i class=\'fa fa-clock-o\'></i>
</span>
<div class=\'timeline-content\'>
<small class=\'text-muted font-weight-bold\'>2021年1月1日</small
<h5 class=\' mt-3 mb-0\'>主题</h5>
<p class=\' text-sm mt-1 mb-0\'>内容段</p>
</div>
</div>
<!--时间段时间结束，此段可无限复制往下排列-->


<!--以上时间段区--></div>">时间线1(切换文本代码编辑)</option>
	<option value="<ul class=\'timelines\'>
<!--时间段时间开始-->
  <li class=\'timeline-event\'>
    <label class=\'timeline-event-icon\'></label>
    <div class=\'timeline-event-copy\'>
      <p class=\'timeline-event-thumbnail\'>2020/03/05</p>
      <h3>h3标题</h3>
      <h4>H4标题2</h4>
      <p><strong>加粗小标题</strong><br>内容</p>
    </div>
  </li>
 <!--时间段时间结束，此段可无限复制往下排列--> 
</ul>">时间线2(切换文本代码编辑)</option>
</select>';
}
if (current_user_can('edit_posts') && current_user_can('edit_pages')) {
	add_action('media_buttons', 'boxmoe_select', 11);
}
//ctlr+enter回复
function boxmoe_button() {
echo '<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery("#short_code_select").change(function(){
			send_to_editor(jQuery("#short_code_select :selected").val());
			return false;
		});
	});
</script>';
}
add_action('admin_head', 'boxmoe_button');

// HTML模式短代码
function html_code_button() {
wp_enqueue_script( 'html_code_button', boxmoe_themes_dir(). '/assets/js/lib/quicktags.js', array( 'jquery', 'quicktags' ), '1.0.0', true );
}
add_action('admin_print_footer_scripts', 'html_code_button' );

