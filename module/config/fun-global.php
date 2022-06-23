<?php
//全站布局
	function sidebaron() {
		$sidebar_on = get_boxmoe('sidebar_on');	
			if(!empty($sidebar_on)) {
				if(get_boxmoe('sidebar_on') == 'col-1' ){
					$sidebar='10 mx-auto';
					}else{
						$sidebar='8';
					}
				}else{
					$sidebar = '10 mx-auto';
				}	
				return  $sidebar;	
	}
//文章列表边框形式切换
	function boxmoe_border($border='blog-border') {
		if(get_boxmoe('sidebar_on') == 'col-1' ){		
			if(get_boxmoe('blog_border') == 'border1' ){
				if(is_singular(array('post','page'))){				
					$border = null;
				}else{
					$border='blog-border';	
				}
			}
			if(get_boxmoe('blog_border') == 'border2'){
				if(is_singular(array('post','page'))){				
					$border = null;
				}else{
					$border='blog-card';
				}
			}
		}else if(get_boxmoe('sidebar_on') == 'col-2' ){
			if(get_boxmoe('blog_border') == 'border1' ){
				$border='blog-border';
				}
			if(get_boxmoe('blog_border') == 'border2'){
				$border='blog-card';
				}
		}else if(is_singular(array('post','page'))){	
			$border = null;
		}
			
		return  $border;	
	}

	function single_border() {
		if(is_singular(array('post','page'))){
			if(get_boxmoe('sidebar_on') == 'col-1' ){
				$single_border = 'singlepage';	
			}
		}else{
			$single_border = null;
		}	
	return  $single_border;	
	}
//随机字符串
function boxmoe_token($length){
		$str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
		$randStr = str_shuffle($str);
		$rands= substr($randStr,0,$length);
		return $rands;
}	
//前端资源路径选择
function boxmoe_load_style() {
	if(get_boxmoe('ui_cdn')){
		if(get_boxmoe('ui_cdn') == 'local'){
			$styleurlload = get_template_directory_uri();
		}
		//ym68_cdn 由 www.ym68.cc 闲云博客赞助提供，Ufile存储桶并使用国内cdn加速，博客访客群体在国内很香，速度很快
		if(get_boxmoe('ui_cdn') == 'ym68_cdn'){
			$styleurlload = 'https://file.api.ym68.cc/boxmoe/lolimeow';
		}
		if(get_boxmoe('ui_cdn') == 'diy_cdn' && !empty(get_boxmoe('diy_cdn_src')) ){
			$styleurlload = get_boxmoe('diy_cdn_src');
		}else{
			$styleurlload = get_template_directory_uri();
		}
	}else {
		$styleurlload = get_template_directory_uri();
	}
	return $styleurlload;
	}

//前端主题图片路径
function boxmoe_pic_src() {
	if(get_boxmoe('ui_cdn') == 'local'){
		$picurlload=get_template_directory_uri();
	}
	$ym68_cdn_pic_src=get_boxmoe('ym68_cdn_pic_src','');
	if(get_boxmoe('ui_cdn') == 'ym68_cdn'){
		if(!empty($ym68_cdn_pic_src)){
			$picurlload=$ym68_cdn_pic_src;		
		}else{
			$picurlload='https://file.api.ym68.cc/boxmoe/lolimeow';
		}
	}	
	$diy_cdn_src=get_boxmoe('diy_cdn_src','');
	if(get_boxmoe('ui_cdn') == 'diy_cdn'){
		if(!empty($diy_cdn_src)){
			$picurlload=$diy_cdn_src;	
		}else{
			$picurlload=get_template_directory_uri();
		}
	}		
	return $picurlload;
	}

//载入主题前端头部静态资源
function boxmoe_load_header() {?>
	<link id="theme-style" href="<?php echo boxmoe_load_style();?>/assets/css/themes.css?<?php echo THEME_VERSION ?>" rel="stylesheet" />
	<link id="theme-style" href="<?php echo boxmoe_load_style();?>/assets/css/style.css?<?php echo THEME_VERSION ?>" rel="stylesheet" />
	<script type="text/javascript" src="<?php echo boxmoe_load_style();?>/assets/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo boxmoe_load_style();?>/assets/js/jquery.pjax.min.js"></script>
<?php if (get_boxmoe('body_grey') ){?>
<style type="text/css">html{ filter: grayscale(100%); -webkit-filter: grayscale(100%); -moz-filter: grayscale(100%); -ms-filter: grayscale(100%); -o-filter: grayscale(100%); filter: url("data:image/svg+xml;utf8,#grayscale"); filter:progid:DXImageTransform.Microsoft.BasicImage(grayscale=1); -webkit-filter: grayscale(1);} </style><?php } ?>
<?php }
//载入主题前端底部静态资源
function boxmoe_load_footer() {?>
<?php if (get_boxmoe('lolijump') ){?><div id="lolijump"><img src="<?php echo boxmoe_load_style(); ?>/assets/images/top/<?php echo get_boxmoe('lolijumpsister'); ?>.gif"></div><?php } ?>
	
	<script src="<?php echo boxmoe_load_style();?>/assets/js/theme.js" type="text/javascript"></script>
	<script src="<?php echo get_template_directory_uri();?>/assets/js/comments.js" type="text/javascript"></script>
    <script src="<?php echo boxmoe_load_style();?>/assets/js/lolimeow.js" type="text/javascript" id="boxmoe_script"></script>	
<?php if (get_boxmoe('music_on') ){?>
    <script src="<?php echo boxmoe_load_style();?>/assets/js/APlayer.min.js" type="text/javascript"></script>
	<meting-js server="<?php echo get_boxmoe('music_server','netease')?>" type="playlist" id="<?php echo get_boxmoe('music_id','2765798464')?>" fixed="true" order="<?php echo get_boxmoe('music_order','list')?>" preload="auto" list-folded="ture" lrc-type="1"></meting-js><?php } ?>	
<?php if (get_boxmoe('sakura') ){?>
	<script src="<?php echo boxmoe_load_style();?>/assets/js/sakura.js"></script><?php } ?>
<?php }

//节日灯笼
function boxmoe_load_lantern() {
	if (get_boxmoe('lantern') ){?>
<div id="wp"class="wp"><div class="xnkl"><div class="deng-box2"><div class="deng"><div class="xian"></div><div class="deng-a"><div class="deng-b"><div class="deng-t"><?php echo get_boxmoe('lanternfont2','度')?></div></div></div><div class="shui shui-a"><div class="shui-c"></div><div class="shui-b"></div></div></div></div><div class="deng-box3"><div class="deng"><div class="xian"></div><div class="deng-a"><div class="deng-b"><div class="deng-t"><?php echo get_boxmoe('lanternfont1','欢')?></div></div></div><div class="shui shui-a"><div class="shui-c"></div><div class="shui-b"></div></div></div></div><div class="deng-box1"><div class="deng"><div class="xian"></div><div class="deng-a"><div class="deng-b"><div class="deng-t"><?php echo get_boxmoe('lanternfont4','春')?></div></div></div><div class="shui shui-a"><div class="shui-c"></div><div class="shui-b"></div></div></div></div><div class="deng-box"><div class="deng"><div class="xian"></div><div class="deng-a"><div class="deng-b"><div class="deng-t"><?php echo get_boxmoe('lanternfont3','新')?></div></div></div><div class="shui shui-a"><div class="shui-c"></div><div class="shui-b"></div></div></div></div></div>
	<?php }else{}
}
//logo地址
function boxmoe_logo(){
if( get_boxmoe('logo_src') ) {
$src = '<img src="'.get_boxmoe('logo_src').'" alt="'. get_bloginfo('name') .'" class="headerlogo">';	
}else{
$src = bloginfo('name');
}    
return  $src;
}
//Favicon地址
function boxmoe_favicon() {
	$src = get_boxmoe('favicon_src');
	if( !empty($src) ) {
		$src = '<link rel="shortcut icon" href="'.$src.'" />';
	}
	echo $src;
}

//banner参数
function boxmoe_banner() {
	$banner_rand = get_boxmoe('banner_rand');
	$banner_api_on =  get_boxmoe('banner_api_on');
	if( !empty($banner_api_on)) {	
	$banner_dir = 'style="background-image: url(\''.get_boxmoe('banner_api_url').'?'.boxmoe_token(6).'\');"';
	}	
	else if( !empty($banner_rand) ) {
	$banner_no = get_boxmoe('banner_rand_n');
	$temp_no = rand(1,$banner_no);		
	$banner_dir = 'style="background-image: url(\''.boxmoe_pic_src().'/assets/images/banner/'.$temp_no.'.jpg\');" ';
	}
	else if	( get_boxmoe('banner_url') ) {
	$banner_dir = 'style="background-image: url(\''.get_boxmoe('banner_url').'\');"';}	
	else {	
	$banner_dir = 'style="background-image: url(\''.boxmoe_pic_src().'/assets/images/banner/1.jpg\');"';
	}		
return  $banner_dir;
}

//底部链接输出
function boxmoe_footer_seo() {
	if( get_boxmoe('footer_seo') ) {
	echo '<ul class="nav flex-row align-items-center mt-sm-0 justify-content-center nav-footer">';
	echo get_boxmoe('footer_seo');
	echo '</ul>';
	}else{
		
	}	
}
//底部信息输出
function boxmoe_footer_info() {
	echo '<p class="mb-0 copyright">';
	echo 'Copyright © '.date('Y').' <a href="'.home_url().'" target="_blank">'.get_bloginfo( 'name' ).'</a> | Theme by
                <a href="https://www.boxmoe.com" target="_blank">LoLiMeow</a>';				
	if( get_boxmoe('footer_info') ) {
	echo '<br>'.get_boxmoe('footer_info','本站使用Wordpress创作');	
	}
	if( get_boxmoe('boxmoedataquery') ) {
	echo '<br>'.get_num_queries().' queries in '.timer_stop().' s';	
	}
	if( get_boxmoe('trackcode') ) {
	echo '<div style="display:none;">'.get_boxmoe('trackcode').'</div>';	
	}
	echo '</p>'."\n";
}
//底部社交输出
function boxmoe_footer_qq() {
	echo '<div class="col-lg-3 text-end">'."\n";
	if(get_boxmoe('boxmoe_qq')){
		echo '<a href="https://wpa.qq.com/msgrd?v=3&amp;uin='.get_boxmoe('boxmoe_qq').'&amp;site=qq&amp;menu=yes" data-bs-toggle="tooltip" data-bs-placement="top" title="博主QQ" target="_blank" class="text-secondary me-xl-4 me-4">
          <i class="fa fa-qq"></i></a>';
		}
	if(get_boxmoe('boxmoe_wechat')){
		echo '<a href="'.get_boxmoe('boxmoe_wechat').'" data-bs-toggle="tooltip" data-bs-placement="top" title="博主微信" data-fancybox="images" data-fancybox-group="button" class="text-secondary me-xl-4 me-4">
          <i class="fa fa-wechat"></i></a>';
		}	
	if(get_boxmoe('boxmoe_weibo')){
		echo '<a href="'.get_boxmoe('boxmoe_weibo').'" data-bs-toggle="tooltip" data-bs-placement="top" title="博主微博" target="_blank" class="text-secondary me-xl-4 me-4">
          <i class="fa fa-weibo"></i></a>';
		}
	if(get_boxmoe('boxmoe_github')){
		echo '<a href="'.get_boxmoe('boxmoe_github').'" data-bs-toggle="tooltip" data-bs-placement="top" title="博主Github" target="_blank" class="text-secondary me-xl-4 me-4">
          <i class="fa fa-github"></i></a>';
		}
	if(get_boxmoe('boxmoe_mail')){
		echo '<a href="http://mail.qq.com/cgi-bin/qm_share?t=qm_mailme&email='.get_boxmoe('boxmoe_mail').'" data-bs-toggle="tooltip" data-bs-placement="top" title="博主邮箱" target="_blank" class="text-secondary me-xl-4 me-4">
          <i class="fa fa-envelope"></i></a>';
		}		
	echo '</div>'."\n";
}

//导航&侧栏部分
if (function_exists('register_nav_menus')) {
	register_nav_menus( array(
	    'navs' => __('顶部主导航', 'boxmoe-com'),
	    ));
}
function boxmoe_nav_menu($location='navs',$dropdowns='dropdown'){
    echo ''.str_replace("</ul></div>", "", preg_replace("/<div[^>]*><ul[^>]*>/", "", 
	wp_nav_menu(array(
	'theme_location' => $location,
	'fallback_cb' => 'bootstrap_5_wp_nav_menu_walker::fallback',
	'depth' => 0,
	'menu_class' => $dropdowns,
	'walker' => new bootstrap_5_wp_nav_menu_walker(),
	'echo' => false)) )).'';
}

//widgets
if( get_boxmoe('sidebar_on') !== 'col-1' ){

    if (function_exists('register_sidebar')){
        $widgets = array(
            'sitesidebar' => __('全站侧栏', 'boxmoe-com'),
            'sidebar' => __('首页侧栏', 'boxmoe-com'),
            'postsidebar' => __('文章页侧栏', 'boxmoe-com'),
            'pagesidebar' => __('页面侧栏', 'boxmoe-com'),
        );
		$boxmoeborder='';
		if(get_boxmoe('blog_border') == 'border1' ){$boxmoeborder='blog-border';}
		if(get_boxmoe('blog_border') == 'border2'){$boxmoeborder='blog-card';}
        foreach ($widgets as $key => $value) {
            register_sidebar(array(
                'name'          => $value,
                'id'            => 'widget_'.$key,
                'before_widget' => '<div class="mb-5 sidebar-border '.$boxmoeborder.' %2$s">',
                'after_widget'  => '</div>',
                'before_title'  => '<h3 class="widget-title">',
                'after_title'   => '</h3>'
            ));
        }
    }
    require_once get_template_directory() . '/component/widget-set.php';
}

//搜索结果排除所有页面
function search_filter_page($query) {
    if ($query->is_search) {
        $query->set('post_type', 'post');
    }
    return $query;
}
add_filter('pre_get_posts','search_filter_page');

// 开启友情链接
add_filter( 'pre_option_link_manager_enabled', '__return_true' );
function get_the_link_items($id = null){
	$bookmarks = get_bookmarks('orderby=date&category=' . $id);
	$output    = '';
    if (!empty($bookmarks)) {	
    foreach ($bookmarks as $bookmark) {
	if (!empty($bookmark->link_notes)) {
	$notes= $bookmark->link_notes;
	}else{
	$notes='这站长太懒了什么也没留下';
	}
	if (!empty($bookmark->link_image)){
	$linkimage=	'<img src="'. $bookmark->link_image .'" alt="' . $bookmark->link_name . '">';
	}else{
	$linkimage='<img src="'.get_template_directory_uri().'/assets/images/avatar.jpg" alt="' . $bookmark->link_name . '">';
	}
	$output .= '<li class="wow slideInUp"><a rel="'.$bookmark->link_rel.'" title="'.$bookmark->link_notes.'" target="_blank"  href="'.$bookmark->link_url.'"><div>'.$linkimage.''.$bookmark->link_name.'</div><div>'.$notes.'</div></a></li>';  	
	}
}
return $output;
}

function get_link_items(){
	$result = null;
    $linkcats = get_terms('link_category');
    if (!empty($linkcats)) {
        foreach ($linkcats as $linkcat) {
            $result .= '<div class="link-title wow rollIn">'.$linkcat->name.'</div>';
            $result .= '<ul class="readers-list clearfix">'.get_the_link_items($linkcat->term_id).'</ul>';
        }
    } else {
		$result .= '<div class="link-title wow rollIn">未分类</div>';
        $result .= '<ul class="readers-list clearfix">'.get_the_link_items().'</ul>';

    }
    return $result;
}