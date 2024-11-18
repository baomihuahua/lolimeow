<?php
/**
 * @link https://www.boxmoe.com
 * @package lolimeow
 */
//列表翻页
if ( ! function_exists( 'boxmoe_paging' ) ) :
function boxmoe_paging() {
    $p = 3;
    if ( is_singular() ) return;
    global $wp_query, $paged;
    $max_page = $wp_query->max_num_pages;
    if ( $max_page == 1 ) return; 
    echo '<div class="col-lg-12 col-md-12 pagenav">
                  <nav class="d-flex justify-content-center">
                    <ul class="pagination">';
    if ( empty( $paged ) ) $paged = 1;
   if( get_boxmoe('paging_type') == 'multi' && $paged !== 1 ) p_link(0);
    // echo '<span class="pages">Page: ' . $paged . ' of ' . $max_page . ' </span> '; 
    if( get_boxmoe('paging_type') == 'next' ){echo '<li class="page-item">'; previous_posts_link(__('«', 'boxmoe-com')); echo '</li>';}

    if( get_boxmoe('paging_type') == 'multi' ){
        if ( $paged > $p + 1 ) p_link( 1, '<li class="page-item"><a class=\"page-link\">'.__('1', 'boxmoe-com').'</a></li>' );
        if ( $paged > $p + 2 ) echo "<li class=\"page-item\"><a class=\"page-link\">···</a></li>";
        for( $i = $paged - $p; $i <= $paged + $p; $i++ ) { 
            if ( $i > 0 && $i <= $max_page ) $i == $paged ? print "<li class=\"page-item active\"><a class=\"page-link\" href=\"#\">{$i}</a></li>" : p_link( $i );
        }
        if ( $paged < $max_page - $p - 1 ) echo "<li class=\"page-item\"><a class=\"page-link\">···</a></li>";
    }
    //if ( $paged < $max_page - $p ) p_link( $max_page, '&raquo;' );
   // echo '<li class="page-item">'; next_posts_link(__('Next', 'boxmoe-com')); echo '</li>';
   
    if( get_boxmoe('paging_type') == 'next' ){echo '<li class="page-item">'; next_posts_link(__('»', 'boxmoe-com')); echo '</li>';}
    if( get_boxmoe('paging_type') == 'multi' && $paged < $max_page ) p_link($max_page, '', 1);

    echo '</ul>
                </nav>
              </div>';
}
function p_link( $i, $title = '', $w='' ) {
    if ( $title == '' ) $title = __('页', 'boxmoe-com')." {$i}";
    $itext = $i;
    if( $i == 0 ){
        $itext = __('<i class="fa fa-angle-double-left"></i>', 'boxmoe-com');
    }
    if( $w ){
        $itext = __('<i class="fa fa-angle-double-right"></i>', 'boxmoe-com');
    }
    echo "<li class=\"page-item\"><a class=\"page-link\" href='", esc_html( get_pagenum_link( $i ) ), "'>{$itext}</a></li>";
}
endif;

//文章新窗口打开
function _post_target_blank(){return get_boxmoe('target_blank') ? ' target="_blank"' : '';}
//开启支持文章日志形式
add_theme_support( 'post-formats', array( 'aside','status') );
//缩略图设置
add_theme_support('post-thumbnails');
set_post_thumbnail_size(380, 220, true );

//缩略图逻辑
function boxmoe_rand_thumbnail(){
	if( get_boxmoe('thumbnail_api')&& !empty(get_boxmoe('thumbnail_api_url'))) {
		$return_thumbnail	=	get_boxmoe('thumbnail_api_url').'?'.boxmoe_token(5);
	}elseif( get_boxmoe('thumbnail_rand_n')) {
		$thumbnail_num=get_boxmoe('thumbnail_rand_n');
		$thumbnail_rand_num=mt_rand(1,$thumbnail_num).'.jpg?'.boxmoe_token($thumbnail_num);
		$return_thumbnail = boxmoe_themes_dir().'/assets/images/rand/'.$thumbnail_rand_num;
	}else{
		$return_thumbnail = boxmoe_themes_dir().'/assets/images/rand/'.mt_rand(1,8).'.jpg';
	}
	return $return_thumbnail;	
}

//缩略图获取post_thumbnail
function _get_post_thumbnail( $single=true, $must=true ) {  
    global $post;
    $html = '';	
	//如果有特色图片则取特色图片
	if ( has_post_thumbnail() ){
		$domsxe = get_the_post_thumbnail();
        preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $domsxe, $strResult, PREG_PATTERN_ORDER);  
        $images = $strResult[1];
        foreach($images as $src){
			$html = sprintf('%s', $src);
            break;
		}
	}else{		
		$content = $post->post_content;
		preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $content, $strResult, PREG_PATTERN_ORDER);
		$images = count($strResult[1]);
		if($images > 0){//没有设置特色图片则取文章第一张图片		
			$html = sprintf (''.$strResult[1][0].'');
		}else{//既没有设置特色图片、文章内又没图片则取默认图片
		$html = sprintf (''.boxmoe_rand_thumbnail().'');
		}
	}
	return $html;
	}

//随机图片
function randpic(){
$ospic = boxmoe_themes_dir();	
$thumbnail_no = get_boxmoe('thumbnail_rand_n','8');	
$temp_no = mt_rand(1,$thumbnail_no);
return $html = ''.$ospic.'/assets/images/rand/'.$temp_no.'.jpg';
}
//文章点击数换算K
function restyle_text($number){
  if ($number >= 1000) {
                return round($number / 1000, 2) . 'k';
            } else {
                return $number;
            }
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
    return restyle_text($count);
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

//修剪标记
function _str_cut($str, $start, $width, $trimmarker) {
	$output = preg_replace('/^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,' . $start . '}((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,' . $width . '}).*/s', '\1', $str);
	return $output . $trimmarker;
}

//自定义段长度
function custom_excerpt_length( $length ){
return 200;
}
add_filter( 'excerpt_length', 'custom_excerpt_length');

//文章、评论内容缩短
function _get_excerpt($limit = 60, $after = '...') { 
	$excerpt = get_the_excerpt();
	if (mb_strlen($excerpt) > $limit) {
		return _str_cut(strip_tags($excerpt), 0, $limit, $after);
	} else {
		return $excerpt;
	}
}

// fancybox
add_filter('the_content', 'lightbox_gall_replace', 99);
function lightbox_gall_replace ($content) {
	global $post;
	$pattern = "/<a(.*?)href=('|\")([A-Za-z0-9\/_\.\~\:-]*?)(\.bmp|\.gif|\.jpg|\.jpeg|\.png)('|\")([^\>]*?)>/i";
	$replacement = '<a$1href=$2$3$4$5$6 class="fancybox" data-fancybox="images" data-fancybox-group="button">';
	$content = preg_replace($pattern, $replacement, $content);
	return $content;
}

// fancybox comment_text
// add_filter( 'comment_text' , 'lightbox_comment', 20, 2);  
// function lightbox_comment ($content) {
// 	global $post;
// 	$pattern = "/<img(.*?)src=('|\")([A-Za-z0-9\/_\.\~\:-]*?)(\.bmp|\.gif|\.jpg|\.jpeg|\.png)('|\")([^\>]*?)>/i";
// 	$replacement = '<a$1href=$2$3$4$5$6 class="fancybox" data-fancybox="images" data-fancybox-group="button"><img$1src=$2$3$4$5$6 alt="评论图片">';
// 	$content = preg_replace($pattern, $replacement, $content);
// 	return $content;
// }
// fancybox-erphpdown
//add_filter('the_content', 'erphpdownbuy_replace', 99);
function erphpdownbuy_replace ($content) {
	global $post;
	$pattern = "/<a(.*?)class=\"erphpdown-iframe erphpdown-buy\"(.*?)>/i";
	$replacement = '<a$1$2$3$4$5$6 class="fancybox" data-fancybox data-type="iframe" class="erphpdown-buy">';
	$content = preg_replace($pattern, $replacement, $content);
	return $content;
}


//会员查看内容
function login_to_read($atts, $content=null) {
extract(shortcode_atts(array("notice" => '
<div class="alerts error"><strong>该段内容只有登录才可以查看</strong></div>'), $atts));
if ( is_user_logged_in() && !is_null( $content ) && !is_feed() )
                return $content;
        return $notice;
}
add_shortcode('userreading', 'login_to_read');


//post related

function boxmoe_posts_related($title='', $limit=6, $model='thumb'){
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
            echo '<div class="col-lg-4 col-md-6"><div class="card border-0 shadow-sm h-100 card-lift">'; 

            if( $model == 'thumb' ){
             echo '<figure><a'._post_target_blank().' href="'.get_permalink().'"><img class="card-img-top" src="'._get_post_thumbnail().'"></a></figure>';
            }
            echo '<div class="card-body h-100 d-flex align-items-start flex-column border rounded-bottom-3 border-top-0">';
			echo'<h4><a '._post_target_blank().' href="'.get_permalink().'" title="'.get_the_title().'"class="text-info icon-move-right">'.mb_strimwidth(get_the_title(), 0, 30, '…').'<i class="fa fa-arrow-right text-sm ms-1"></i></a></h4>';
			echo'</div></div></div>'; 

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
            echo '<div class="col-lg-4 col-md-6"><div class="card border-0 shadow-sm h-100 card-lift">'; 

            if( $model == 'thumb' ){
             echo '<figure><a'._post_target_blank().' href="'.get_permalink().'"><img class="card-img-top" src="'._get_post_thumbnail().'"></a></figure>';
            }
            echo '<div class="card-body h-100 d-flex align-items-start flex-column border rounded-bottom-3 border-top-0">';
			echo'<h4><a '._post_target_blank().' href="'.get_permalink().'" title="'.get_the_title().'"class="text-info icon-move-right">'.mb_strimwidth(get_the_title(), 0, 30, '…').'<i class="fa fa-arrow-right text-sm ms-1"></i></a></h4>';
			echo'</div></div></div>';  
            $i ++;
        };
        wp_reset_query();
    }
    if ( $i == 0 ){
        echo '<div class="col-md-12 text-center">暂无相关文章内容！</div>';
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



//防止代码转义
function boxmoe_prettify_esc_html($content){
    $regex = '/(<pre\s+[^>]*?class\s*?=\s*?[",\'].*?prettyprint.*?[",\'].*?>)(.*?)(<\/pre>)/sim';
    return preg_replace_callback($regex, 'boxmoe_prettify_esc_callback', $content);}
function boxmoe_prettify_esc_callback($matches){
    $tag_open = $matches[1];
    $content = $matches[2];
    $tag_close = $matches[3];
    $content = esc_html($content);
    return $tag_open . $content . $tag_close;}
add_filter('the_content', 'boxmoe_prettify_esc_html', 2);
add_filter('comment_text', 'boxmoe_prettify_esc_html', 2);
//强制兼容
function boxmoe_prettify_replace($text){
	$replace = array( '<pre>' => '<pre class="prettyprint linenums" >','<pre class="prettyprint">' => '<pre class="prettyprint linenums" >' );
	$text = str_replace(array_keys($replace), $replace, $text);
	return $text;}
add_filter('the_content', 'boxmoe_prettify_replace');


function boxmoe_table_replace($text){
	$replace = array( '<table>' => '<div class="table-responsive"><table class="table" >','</table>' => '</table></div>' );
	$text = str_replace(array_keys($replace), $replace, $text);
	return $text;}
add_filter('the_content', 'boxmoe_table_replace');

// 自适应图片
function boxmoe_remove_width_height($content) {
    preg_match_all('/<[img|IMG].*?src=[\'|"](.*?(?:[\.gif|\.jpg|\.png\.bmp]))[\'|"].*?[\/]?>/', $content, $images);
    if (!empty($images)) {
        foreach ($images[0] as $index => $value) {
            $new_img = preg_replace('/(width|height)="\d*"\s/', "", $images[0][$index]);
            $content = str_replace($images[0][$index], $new_img, $content);
        }
    }
    return $content;
}
add_filter('the_content', 'boxmoe_remove_width_height', 99);