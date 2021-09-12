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
    $ouput = '';
    foreach($lists as $li){
        if(trim($li) != '') {
            $output .= "<ol>{$li}</ol>\n";
        }
    }
    if($type=="ol"){
        $output = "<ol>\n".$output."</ol>\n";
    }else{
        $output = "<ul class='ol'>\n".$output."</ul>\n";
    }
    return $output;
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
