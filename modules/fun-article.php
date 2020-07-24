<?php
//文章新窗口打开
function _post_target_blank(){return meowdata('target_blank') ? ' target="_blank"' : '';}
//开启支持文章日志形式
add_theme_support( 'post-formats', array( 'aside','status','audio' ) );
//缩略图设置
add_theme_support('post-thumbnails');
set_post_thumbnail_size(380, 250, true );

//缩略图获取post_thumbnail
function _get_post_thumbnail( $single=true, $must=true ) {  
    global $post;
    $html = '';
	$ospic = boxmoe_load_style();
//如果有特色图片则取特色图片
if ( has_post_thumbnail() ){
	$domsxe = get_the_post_thumbnail();
        preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $domsxe, $strResult, PREG_PATTERN_ORDER);  
        $images = $strResult[1];
        foreach($images as $src){
            $html = sprintf('src="%s"', $src);
            break;
}
}
else
{
$content = $post->post_content;
preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $content, $strResult, PREG_PATTERN_ORDER);
$images = count($strResult[1]);
//没有设置特色图片则取文章第一张图片
if($images > 0)
{
$html = sprintf ('src="'.$strResult[1][0].'"  alt="'.trim(strip_tags( $post->post_title )).'"');
}
else
{
//既没有设置特色图片、文章内又没图片则取默认图片
$thumbnail_no = meowdata('thumbnail_rand_n');
$temp_no = rand(1,$thumbnail_no);
$html = sprintf ('src="'.$ospic.'/assets/images/rand/rand ('.$temp_no.').jpg"  alt="'.trim(strip_tags( $post->post_title )).'"');
}
}
return $html;
}



//文章点击数
function getPostViews($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0 View";
    }
    return $count.' Views';
}
function setPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}



add_filter('the_content', 'fancybox');
function fancybox ($content)  { 
global $post;  
$pattern = "/<a(.*?)href=('|\")([^>]*).(bmp|gif|jpeg|jpg|png|swf)('|\")(.*?)>(.*?)<\/a>/i";  
$replacement = '<a$1href=$2$3.$4$5 data-fancybox="images"$6>$7</a>';  
$content = preg_replace($pattern, $replacement, $content);  
return $content;  
} 
//修剪标记
function _str_cut($str, $start, $width, $trimmarker) {
	$output = preg_replace('/^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,' . $start . '}((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,' . $width . '}).*/s', '\1', $str);
	return $output . $trimmarker;
}

//custom_excerpt_length
function custom_excerpt_length( $length ){
return 200;
}
add_filter( 'excerpt_length', 'custom_excerpt_length');

//文章、评论内容缩短
function _get_excerpt($limit = 90, $after = '...') { 
	$excerpt = get_the_excerpt();
	if (_new_strlen($excerpt) > $limit) {
		return _str_cut(strip_tags($excerpt), 0, $limit, $after);
	} else {
		return $excerpt;
	}
}
/* 
 * 使用默认编辑器
 * ====================================================
*/
if( meowdata('gutenbergoff') )  {
if ( version_compare( get_bloginfo('version'), '5.0', '>=' ) ) {
    add_filter('use_block_editor_for_post', '__return_false'); // 切换回之前的编辑器
    remove_action( 'wp_enqueue_scripts', 'wp_common_block_scripts_and_styles' ); // 禁止前端加载样式文件
}else{
    // 4.9.8 < WP < 5.0 插件形式集成Gutenberg古腾堡编辑器
    add_filter('gutenberg_can_edit_post_type', '__return_false');
}
}
/* 
 * timeago
 * ====================================================
*/
function meowdata_post_date($ptime='')
{
    if( empty($ptime) ){
        return false;
    }
    if( meowdata('post_date_ago') ){
        return timeago($ptime);
    }
    $format = meowdata('post_date_format');
    if( !$format ){
        $format = 'Y-m-d';
    }
    return date($format, strtotime($ptime));
}

function timeago( $ptime ) {
    date_default_timezone_set( "UTC" );    
    $ptime = strtotime($ptime);
    $etime = time() - $ptime;
    if($etime < 1) return __('刚刚', 'meowdata');
    $interval = array (
        12 * 30 * 24 * 60 * 60  =>  __('年前', 'meowdata').' ('.date('Y-m-d', $ptime).')',
        30 * 24 * 60 * 60       =>  __('个月前', 'meowdata').' ('.date('m-d', $ptime).')',
        7 * 24 * 60 * 60        =>  __('周前', 'meowdata').' ('.date('m-d', $ptime).')',
        24 * 60 * 60            =>  __('天前', 'meowdata'),
        60 * 60                 =>  __('小时前', 'meowdata'),
        60                      =>  __('分钟前', 'meowdata'),
        1                       =>  __('秒前', 'meowdata')
    );
    foreach ($interval as $secs => $str) {
        $d = $etime / $secs;
        if ($d >= 1) {
            $r = round($d);
            return $r . $str;
        }
    };
}

//会员查看内容
function login_to_read($atts, $content=null) {
extract(shortcode_atts(array("notice" => '
<div class="alerts error"><strong>该段内容只有登录才可以查看
 <span class="ruike_user-loader">
 <a href="'.site_url('/').meowdata('users_login').'" class="signin-loader z-bor">登录</a> 
 <b class="middle-text"><span class="middle-inner">or</span></b> 
 </span> <span class="ruike_user-loader">
 <a href="'.site_url('/').meowdata('users_reg').'" class="signup-loader l-bor">注册</a></span> 
</strong></div>'), $atts));
if ( is_user_logged_in() && !is_null( $content ) && !is_feed() )
                return $content;
        return $notice;
}
add_shortcode('userreading', 'login_to_read');


/* 
 * post related
 * ====================================================
*/
function md_posts_related($title='', $limit=6, $model='thumb'){
    global $post;

    $exclude_id = $post->ID; 
    $posttags = get_the_tags(); 
    $i = 0;
    if ( $posttags ) { 
        $tags = ''; foreach ( $posttags as $tag ) $tags .= $tag->name . ',';
        $args = array(
            'post_status' => 'publish',
            'tag_slug__in' => explode(',', $tags), 
            'post__not_in' => explode(',', $exclude_id), 
            'ignore_sticky_posts' => 1, 
            'orderby' => 'comment_date', 
            'posts_per_page' => $limit
        );
        query_posts($args); 
        while( have_posts() ) { the_post();
            echo '<div class="col-md-4"><div class="card card-blog">'; 

            if( $model == 'thumb' ){
                echo '<div class="card-header card-header-image"><a'._post_target_blank().' href="'.get_permalink().'"><img class="img img-raised" '._get_post_thumbnail(). '></a></div>';
            }
            echo '<div class="card-body">';
			echo'<h4 class="card-title"><a'._post_target_blank().' href="'.get_permalink().'" title="'.get_the_title().'">'.mb_strimwidth(get_the_title(), 0, 30, '…').'</a></h4></div>';
			echo'</div></div>'; 

            $exclude_id .= ',' . $post->ID; $i ++;
        };
        wp_reset_query();
    }
    if ( $i < $limit ) { 
        $cats = ''; foreach ( get_the_category() as $cat ) $cats .= $cat->cat_ID . ',';
        $args = array(
            'category__in' => explode(',', $cats), 
            'post__not_in' => explode(',', $exclude_id),
            'ignore_sticky_posts' => 1,
            'orderby' => 'comment_date',
            'posts_per_page' => $limit - $i
        );
        query_posts($args);
        while( have_posts() ) { the_post();
            echo '<div class="col-md-4"><div class="card card-blog">'; 

            if( $model == 'thumb' ){
                echo '<div class="card-header card-header-image"><a'._post_target_blank().' href="'.get_permalink().'"><img class="img img-raised" '._get_post_thumbnail(). '></a></div>';
            }

             echo '<div class="card-body">';
			echo'<h4 class="card-title"><a'._post_target_blank().' href="'.get_permalink().'" title="'.get_the_title().'">'.mb_strimwidth(get_the_title(), 0, 30, '…').'</a></h4></div>';
			echo'</div></div>'; 
            $i ++;
        };
        wp_reset_query();
    }
    if ( $i == 0 ){
        echo '<div class="col-md-12">暂无内容！</div>';
    }
    

}
function autoset_featured_image() {
    global $post;
    if (!is_object($post)) return;
    $already_has_thumb = has_post_thumbnail($post->ID);
    if (!$already_has_thumb)  {
        $attached_image = get_children( "post_parent=$post->ID&post_type=attachment&post_mime_type=image&numberposts=1" );
        if ($attached_image) {
            foreach ($attached_image as $attachment_id => $attachment) {
                set_post_thumbnail($post->ID, $attachment_id);
            }
        }
    }
}
add_action( 'the_post', 'autoset_featured_image' );
add_action( 'save_post', 'autoset_featured_image' );
add_action( 'draft_to_publish', 'autoset_featured_image' );
add_action( 'new_to_publish', 'autoset_featured_image' );
add_action( 'pending_to_publish', 'autoset_featured_image' );
add_action( 'future_to_publish', 'autoset_featured_image' );



function zww_archives_list() {
	if( !$output = get_option('zww_db_cache_archives_list') ){
		$output = '<div class="timeline timeline-one-side" data-timeline-content="axis" data-timeline-axis-style="dashed" >';
		$args = array(
			'post_type' => array('archives', 'post', 'zsay'),
			'posts_per_page' => -1, //全部 posts
			'ignore_sticky_posts' => 1 //忽略 sticky posts

		);
		$the_query = new WP_Query( $args );
		$posts_rebuild = array();
		$year = $mon = 0;
		while ( $the_query->have_posts() ) : $the_query->the_post();
			$post_year = get_the_time('Y');
			$post_mon = get_the_time('m');
			$post_day = get_the_time('d');
			if ($year != $post_year) $year = $post_year;
			if ($mon != $post_mon) $mon = $post_mon;
			$posts_rebuild[$year][$mon][] = '<li>'. get_the_time('d日: ') .'<a href="'. get_permalink() .'">'. get_the_title() .'</a> <em>('. get_comments_number('0', '1', '%') .')</em></li>';
		endwhile;
		wp_reset_postdata();

		foreach ($posts_rebuild as $key_y => $y) {
			$y_i = 0; $y_output = '';
			foreach ($y as $key_m => $m) {
				$posts = ''; $i = 0;
				foreach ($m as $p) {
					++$i; ++$y_i;
					$posts .= $p;
				}
				$y_output .= '<li><span class="al_mon biji-oth">'. $key_m .' 月 <em>( '. $i .' 篇文章 )</em>  <b class="openoff" style="color: #ff5f33;"> [ 展开 ]</b></span><ul class="al_post_list biji-content">'; //输出月份
				$y_output .= $posts; //输出 posts
				$y_output .= '</ul></li>';
			}
			$output .= '<span class="timeline-step badge-success"><br><i class="fa fa-clock-o"></i><br></span>
<div class="timeline-content">
                    <small class="text-muted font-weight-bold biji-tit">'. $key_y .' 年 <em>( '. $y_i .' 篇文章 )</em></small>'; //输出年份
			$output .= $y_output;
			$output .= '</div>';  
		}

		$output .= '</div>';
		update_option('zww_db_cache_archives_list', $output);
	}
	echo $output;
}
function clear_db_cache_archives_list() {
	update_option('zww_db_cache_archives_list', ''); // 清空 zww_archives_list
}
add_action('save_post', 'clear_db_cache_archives_list'); // 新发表文章/修改文章时