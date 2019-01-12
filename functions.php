<?php
define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/modules/inc/' );
require_once dirname( __FILE__ ) . '/modules/inc/options-framework.php';
$optionsfile = locate_template( 'options.php' );
load_template( $optionsfile );
add_action( 'optionsframework_custom_scripts', 'optionsframework_custom_scripts' );
function optionsframework_custom_scripts() { ?>
<script type="text/javascript">
jQuery(document).ready(function() {

	jQuery('#example_showhidden').click(function() {
  		jQuery('#section-example_text_hidden').fadeToggle(400);
	});

	if (jQuery('#example_showhidden:checked').val() !== undefined) {
		jQuery('#section-example_text_hidden').show();
	}

});
</script>

<?php
}
require_once get_stylesheet_directory() . '/modules/fun-opzui.php';     
require_once get_stylesheet_directory() . '/modules/fun-bootstrap.php'; 
require_once get_stylesheet_directory() . '/modules/fun-comments.php';
require_once get_stylesheet_directory() . '/modules/fun-admin.php';
require_once get_stylesheet_directory() . '/modules/fun-article.php';
require_once get_stylesheet_directory() . '/modules/fun-user.php';
require_once get_stylesheet_directory() . '/modules/fun-seo.php';
require_once get_stylesheet_directory() . '/modules/fun-mail.php';
if( meowdata('no_categoty') ) require_once get_stylesheet_directory() . '/modules/fun-no-category.php';


function md_version() {
    $versions = '1.5';   
    echo  $versions;
}
// 注册导航
if (function_exists('register_nav_menus')){
    register_nav_menus( array(
    'nav' => __('顶部主导航', 'meowdataui'),
    ));
}
function md_nav_menu($location='nav',$dropdowns='dropdown'){
    echo ''.str_replace("</ul></div>", "", preg_replace("/<div[^>]*><ul[^>]*>/", "", wp_nav_menu(array('theme_location' => $location,'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback','menu_class' => $dropdowns,'walker' => new wp_bootstrap_navwalker(),'echo' => false)) )).''; 
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
        $output .= '<div class="btn btn-success col-md-12 ml-auto mr-auto ">
  博主与以下 <span class="badge badge-danger">' . count($bookmarks) . '</span> 位大佬存在 <span class="badge badge-default">Jian情</span> 排名不分先后
</div><div class="userItems mt30"><div class="row">';
        foreach ($bookmarks as $bookmark) {
			if(($bookmark->link_notes)){
            $output .= '<div class="col-md-6 col-lg-3 mb-5 mb-lg-0">
		  <a class="link-item-inner effect-apollo" href="' . $bookmark->link_url . '" target="_blank">
            <div class="px-4">
              <img src="'.get_template_directory_uri().'/assets/images/avatar.jpg" class="rounded-circle img-center img-fluid shadow shadow-lg--hover" style="width:80px;">
              <div class="text-center">
                <h5 class="title">
                  <span class="d-block mb-1">' . $bookmark->link_name . '</span>
                </h5>
              </div>
            </div>
			</a>
          </div>';
			 }else if($bookmark->link_image){
				 $output .= '<div class="col-md-6 col-lg-3 mb-5 mb-lg-0">
		  <a class="link-item-inner effect-apollo" href="' . $bookmark->link_url . '" target="_blank">
            <div class="px-4">
              <img src="'. $bookmark->link_image .'" alt="' . $bookmark->link_name . '" class="rounded-circle img-center img-fluid shadow shadow-lg--hover" style="width:80px;">
              <div class="text-center">
                <h5 class="title">
                  <span class="d-block mb-1">' . $bookmark->link_name . '</span>
                </h5>
              </div>
            </div>
			</a>
          </div>';
		 }
            else{$output .= '<div class="col-md-6 col-lg-3 mb-5 mb-lg-0">
		  <a class="link-item-inner effect-apollo" href="' . $bookmark->link_url . '" target="_blank">
            <div class="px-4">
              <img src="'.get_template_directory_uri().'/assets/images/avatar.jpg" class="rounded-circle img-center img-fluid shadow shadow-lg--hover" style="width:80px;">
              <div class="text-center">
                <h5 class="title">
                  <span class="d-block mb-1">' . $bookmark->link_name . '</span>
                </h5>
              </div>
            </div>
			</a>
          </div>';
		}

			
        }
        $output .= '</div>';
    }
    return $output;
}


function get_the_link_items_index($id = null){
	$bookmarks = get_bookmarks('orderby=date&category=' . $id);
    $output    = '';
    if (!empty($bookmarks)) {
        $output .= '<div class="container wow fadeInUp animated"><div class="row"><div class="col-lg-12 col-md-12"><div class="card mt40"><div class="card-body"><a href="'.meowdata('yqlinks').'" class="btn btn-danger btn-sm justify-content-center" target="_blank" data-toggle="tooltip" data-original-title="点击进入申请友情链接"><span>'.meowdata('yqlinksname').'</span><span class="badge badge-white">' . count($bookmarks) . '</span></a>';
        foreach ($bookmarks as $bookmark) {
            $output .= '<a href="' . $bookmark->link_url . '" class="badge badge-secondary" style="margin-right: 15px;" target="_blank">' . $bookmark->link_name . '</a>';	
        }
        $output .= '</div></div></div></div></div>';
    }
    return $output;
}

function get_link_items(){
    $linkcats = get_terms('link_category');
    if (!empty($linkcats)) {
        foreach ($linkcats as $linkcat) {
            $result .= '
            <h3 class="catalog-title">' . $linkcat->name . '</h3><div class="catalog-description">' . $linkcat->description . '</div>
            ';
            $result .= get_the_link_items($linkcat->term_id);
        }
    } else {
        $result = get_the_link_items();
    }
    return $result;
}
//全站链接字符
function md_connector(){return meowdata('connector') ? meowdata('connector') : '-';}


//开启替换头像为cdn地址
//if( meowdata('gravatar_cdn') ) {
//function md_get_avatar( $avatar ) {
//$avatarcnd = meowdata('gravatar_url');	
//$avatar = preg_replace( '/http:\/\/(www|\d).gravatar.com/','https://gravatar.loli.net/',$avatar );
//return $avatar;
//}
//add_filter( 'get_avatar', 'md_get_avatar' );
//}


//logo地址
function md_logo() {
    $src = meowdata('logosrc');
    if( !empty($src) ){
        $src = '<img src="'.$src.'" alt="'. get_bloginfo('name') .'" class="headerlogo">';
    }    
    echo  $src;
}
//Favicon地址
function md_favicon() {
    $src = meowdata('favicon_src');
    if( !empty($src) ){
        $src = '<link rel="shortcut icon" href="'.$src.'" />';
    }    
    echo ''.$src.'';
}




//翻页
if ( ! function_exists( 'md_paging' ) ) :
function md_paging() {
    $p = 3;
    if ( is_singular() ) return;
    global $wp_query, $paged;
    $max_page = $wp_query->max_num_pages;
    if ( $max_page == 1 ) return; 
    echo '<div class="paging wow swing "><ul class="pagination justify-content-center">';
    if ( empty( $paged ) ) $paged = 1;
   if( meowdata('paging_type') == 'multi' && $paged !== 1 ) p_link(0);
    // echo '<span class="pages">Page: ' . $paged . ' of ' . $max_page . ' </span> '; 
    if( meowdata('paging_type') == 'next' ){echo '<li>'; previous_posts_link(__('上一页', 'meowdataui')); echo '</li>';}

    if( meowdata('paging_type') == 'multi' ){
        if ( $paged > $p + 1 ) p_link( 1, '<li><a class=\"paging-link\">'.__('第一页', 'meowdataui').'</a></li>' );
        if ( $paged > $p + 2 ) echo "<li><a class=\"paging-link\">···</a></li>";
        for( $i = $paged - $p; $i <= $paged + $p; $i++ ) { 
            if ( $i > 0 && $i <= $max_page ) $i == $paged ? print "<li class=\"active\"><a class=\"paging-link\" href=\"#\">{$i}</a></li>" : p_link( $i );
        }
        if ( $paged < $max_page - $p - 1 ) echo "<li><a class=\"paging-link\"> ... </a></li>";
    }
    //if ( $paged < $max_page - $p ) p_link( $max_page, '&raquo;' );
   // echo '<li class="page-item">'; next_posts_link(__('Next', 'meowdataui')); echo '</li>';
   
    if( meowdata('paging_type') == 'next' ){echo '<li>'; next_posts_link(__('下一页', 'mogu')); echo '</li>';}
    if( meowdata('paging_type') == 'multi' && $paged < $max_page ) p_link($max_page, '', 1);

    echo '</ul></div>';
}
function p_link( $i, $title = '', $w='' ) {
    if ( $title == '' ) $title = __('页', 'meowdataui')." {$i}";
    $itext = $i;
    if( $i == 0 ){
        $itext = __('首页', 'meowdataui');
    }
    if( $w ){
        $itext = __('尾页', 'meowdataui');
    }
    echo "<li><a class=\"paging-link\" href='", esc_html( get_pagenum_link( $i ) ), "'>{$itext}</a></li>";
}
endif;

//防止代码转义
function meow_prettify_esc_html($content){
    $regex = '/(<pre\s+[^>]*?class\s*?=\s*?[",\'].*?prettyprint.*?[",\'].*?>)(.*?)(<\/pre>)/sim';
    return preg_replace_callback($regex, 'meow_prettify_esc_callback', $content);}
function meow_prettify_esc_callback($matches){
    $tag_open = $matches[1];
    $content = $matches[2];
    $tag_close = $matches[3];
    $content = esc_html($content);
    return $tag_open . $content . $tag_close;}
add_filter('the_content', 'meow_prettify_esc_html', 2);
add_filter('comment_text', 'meow_prettify_esc_html', 2);
//强制兼容
function meow_prettify_replace($text){
	$replace = array( '<pre>' => '<pre class="prettyprint linenums" >' );
	$text = str_replace(array_keys($replace), $replace, $text);
	return $text;}
add_filter('the_content', 'meow_prettify_replace');


function md_banner() {
$banner_no = meowdata('banner_rand_n');
$temp_no = rand(1,$banner_no);		
$banner_dir = 'style="background-image: url(\''.meowdata('style_src').'/assets/images/banner/banner('.$temp_no.').jpg\');" ';
if( meowdata('banner_rand') ) {
echo $banner_dir ;	
}else{
echo  'style="background-image: url(\''.meowdata('banner_url').'\');"';	 
}
		
}	
	
