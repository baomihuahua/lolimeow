<?php
//全站布局
function sidebaron( ) {	
if(get_boxmoe('sidebar_on') == 'col-1' ){$sidebar='10 mx-auto';}
if(get_boxmoe('sidebar_on') == 'col-2'){$sidebar='8';}
return  $sidebar;	
}	
//载入前端资源
function boxmoe_load_style() {
	$src = get_boxmoe('style_src');
	if( get_boxmoe('style_src_onoff')& !empty($src) ) {
		$styleurlload = get_boxmoe('style_src');
	} else {
		$styleurlload = get_template_directory_uri() ;
	}
	return $styleurlload;
}
//logo地址
function boxmoe_logo(){
if( get_boxmoe('logo_src') ) {
$src = '<img src="'.get_boxmoe('logo_src').'" alt="'. get_bloginfo('name') .'" class="headerlogo">';	
}else{
$src = '';
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
	$banner_dir = 'style="background-image: url(\''.get_boxmoe('banner_api_url').'\');"';
	}	
	else if( !empty($banner_rand) ) {
	$banner_no = get_boxmoe('banner_rand_n');
	$temp_no = rand(1,$banner_no);		
	$banner_dir = 'style="background-image: url(\''.boxmoe_load_style().'/assets/images/banner/'.$temp_no.'.jpg\');" ';
	}
	else if	( get_boxmoe('banner_url') ) {
	$banner_dir = 'style="background-image: url(\''.get_boxmoe('banner_url').'\');"';}	
	else {	
	$banner_dir = 'style="background-image: url(\''.boxmoe_load_style().'/assets/images/banner/1.jpg\');"';
	}		
return  $banner_dir;
}
//导航&侧栏部分
if (function_exists('register_nav_menus')) {
	register_nav_menus( array(
	    'navs' => __('顶部主导航', 'boxmoe-com'),
	    ));
}
function boxmoe_nav_menu($location='navs',$dropdowns='dropdown'){
    echo ''.str_replace("</ul></div>", "", preg_replace("/<div[^>]*><ul[^>]*>/", "", wp_nav_menu(array('theme_location' => $location,'fallback_cb'       => 'bootstrap_5_wp_nav_menu_walker::fallback','depth' => 2,'menu_class' => $dropdowns,'walker' => new bootstrap_5_wp_nav_menu_walker(),'echo' => false)) )).''; 
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
		if(get_boxmoe('blog_border') == 'border1' ){$boxmoeborder='blog-border';}
		if(get_boxmoe('blog_border') == 'border2'){$boxmoeborder='blog-card';}
		if(get_boxmoe('blog_border') == 'border3'){$boxmoeborder='';}
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
function get_yqlinks_index(){
if (get_boxmoe('yqlinks')){
	$result='<a href="'.get_boxmoe('yqlinks').'" target="_blank" title="点击进入申请友情链接"><span>'.get_boxmoe('yqlinksname').'</span></a>'	;	
		}else {
			$result='<span>'.get_boxmoe('yqlinksname').'</span>';
			}
return $result;			
}
function get_the_link_items_index(){
	$id= get_boxmoe('yqlinksid');
	$bookmarks = get_bookmarks('orderby=date&category=' . $id);
    $output    = '';
    if (!empty($bookmarks)) {
			
        $output .= '<section class="section index-links"><div class="container"><div class="section-head ">' .get_yqlinks_index(). '   </div><div class="row"> <div class="col-md-12"> <ul class="footer_links">';
        if (get_boxmoe('diylinks_open')){
			$output .= 	get_boxmoe('diylinks_con');
			}else {
		foreach ($bookmarks as $bookmark) {					
            $output .= '<li><a href="' . $bookmark->link_url . '"  target="_blank"><i class="fa fa-globe fa-spin fa-fw"></i>' . $bookmark->link_name . '</a></li>';	
        }
		}
        $output .= '</ul></div></div></div> </section>';
    }
    return $output;
}

function get_link_items(){
	$bookmarks = get_bookmarks('orderby=date&category=' . $id);
    $linkcats = get_terms('link_category');
    if (!empty($linkcats)) {
        foreach ($linkcats as $linkcat) {
            $result .= '<div class="link-title wow rollIn">'.$linkcat->name.'</div>';
            $result .= '<ul class="readers-list clearfix">'.get_the_link_items($linkcat->term_id).'</ul>';
        }
    } else {
		$result .= '<div class="link-title wow rollIn">未分类</div>';
        $result = '<ul class="readers-list clearfix">'.get_the_link_items().'</ul>';
    }
    return $result;
}