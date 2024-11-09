<?php
/**
 * @link https://www.boxmoe.com
 * @package lolimeow
 */
//随机字符串
function boxmoe_token($length){
    $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
    $randStr = str_shuffle($str);
    $rands= substr($randStr,0,$length);
    return $rands;
}

//主题资源路径
function boxmoe_themes_dir() {
    $themes_dir='';
    $ui_cdn = get_boxmoe('ui_cdn');
    $diy_cdn_src = get_boxmoe('diy_cdn_src');
    if ( !empty($src) && !empty($diy_cdn_src) ){
        $themes_dir =  $diy_cdn_src;
    }else{
        $themes_dir = get_template_directory_uri();
    }
    return $themes_dir;
}

//全站链接字符
function boxmoe_connector() {
	return get_boxmoe('connector') ? ' ' . get_boxmoe('connector'). ' ' : ' - ';
}
//全站标题
function boxmoe_title() {
	global $new_title;
	if( $new_title ) return $new_title;
	global $paged;
	$html = '';
	$t = trim(wp_title('', false));
	if( (is_single() || is_page()) && get_the_subtitle(false) ){
		$t .= get_the_subtitle(false);
	}
	if ($t) {
		$html .= $t . boxmoe_connector();
	}
	$html .= get_bloginfo('name');
	if (is_home()) {
		if ($paged > 1) {
			$html .= boxmoe_connector() . '最新发布';
		}else{
			$html .= boxmoe_connector() . get_option('blogdescription');
		}
	}
	if ($paged > 1) {
		$html .= boxmoe_connector() . '第' . $paged . '页';
	}
	return $html;
}

function get_the_subtitle($span=true){
    global $post;
    $post_ID = $post->ID;
    $subtitle = get_post_meta($post_ID, 'subtitle', true);

    if( !empty($subtitle) ){
    	if( $span ){
        	return ' <span>'.$subtitle.'</span>';
        }else{
        	return ' '.$subtitle;
        }
    }else{
        return false;
    }
}
/* 
 * post meta keywords
 * ====================================================
*/
$postmeta_keywords_description = array(
    array(
        "name" => "keywords",
        "std" => "",
        "title" => __('关键字', 'boxmoe').'：'
    ),
    array(
        "name" => "description",
        "std" => "",
        "title" => __('描述', 'boxmoe').'：'
        )
);
if( get_boxmoe('post_keywords_description_s') ){
    add_action('admin_menu', 'boxmoe_postmeta_keywords_description_create');
    add_action('save_post', 'boxmoe_postmeta_keywords_description_save');
}

function boxmoe_postmeta_keywords_description() {
    global $post, $postmeta_keywords_description;
    foreach($postmeta_keywords_description as $meta_box) {
        $meta_box_value = get_post_meta($post->ID, $meta_box['name'], true);
        if($meta_box_value == "")
            $meta_box_value = $meta_box['std'];
        echo'<p>'.$meta_box['title'].'</p>';
        if( $meta_box['name'] == 'keywords' ){
            echo '<p><input type="text" style="width:98%" value="'.$meta_box_value.'" name="'.$meta_box['name'].'"></p>';
        }else{
            echo '<p><textarea style="width:98%" name="'.$meta_box['name'].'">'.$meta_box_value.'</textarea></p>';
        }
    }
   
    echo '<input type="hidden" name="post_newmetaboxes_noncename" id="post_newmetaboxes_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';
}

function boxmoe_postmeta_keywords_description_create() {
    global $theme_name;
    if ( function_exists('add_meta_box') ) {
        add_meta_box( 'postmeta_keywords_description_boxes', __('自定义关键字和描述', 'boxmoe'), 'boxmoe_postmeta_keywords_description', 'post', 'normal', 'high' );
        add_meta_box( 'postmeta_keywords_description_boxes', __('自定义关键字和描述', 'boxmoe'), 'boxmoe_postmeta_keywords_description', 'page', 'normal', 'high' );
    }
}

function boxmoe_postmeta_keywords_description_save( $post_id ) {
    global $postmeta_keywords_description;
   
    if ( !wp_verify_nonce( isset($_POST['post_newmetaboxes_noncename'])?$_POST['post_newmetaboxes_noncename']:'', plugin_basename(__FILE__) ))
        return;
   
    if ( !current_user_can( 'edit_posts', $post_id ))
        return;
                   
    foreach($postmeta_keywords_description as $meta_box) {
        $data = $_POST[$meta_box['name']];
        if(get_post_meta($post_id, $meta_box['name']) == "")
            add_post_meta($post_id, $meta_box['name'], $data, true);
        elseif($data != get_post_meta($post_id, $meta_box['name'], true))
            update_post_meta($post_id, $meta_box['name'], $data);
        elseif($data == "")
            delete_post_meta($post_id, $meta_box['name'], get_post_meta($post_id, $meta_box['name'], true));
    }
}

/* 
 * keywords
 * ====================================================
*/
function boxmoe_keywords() {
  global $s, $post;
  $keywords = '';
  if ( is_singular() ) {
    if ( get_the_tags( $post->ID ) ) {
      foreach ( get_the_tags( $post->ID ) as $tag ) $keywords .= $tag->name . ', ';
    }
    foreach ( get_the_category( $post->ID ) as $category ) $keywords .= $category->cat_name . ', ';
    if(get_boxmoe('post_keywords_description_s') ) {
        $the = trim(get_post_meta($post->ID, 'keywords', true));
        if( $the ) $keywords = $the;
    }else{
        $keywords = substr_replace( $keywords , '' , -2);
    }
    
  } elseif ( is_home () )    { $keywords =get_boxmoe('keywords');
  } elseif ( is_tag() )      { $keywords = single_tag_title('', false);
  } elseif ( is_category() ) { $keywords = single_cat_title('', false);

    if(get_boxmoe('cat_keyworks_s') ){
        $description = trim(strip_tags(category_description()));
        if( $description && strstr($description, '::::::') ){
            $desc = explode('::::::', $description);
            if( $desc[0] && !empty($desc[0]) ) {
                $keywords = trim($desc[0]);
            }
        }
    }

  } elseif ( is_search() )   { $keywords = esc_html( $s, 1 );
  } else { $keywords = trim( wp_title('', false) );
  }
  if ( $keywords ) {
    echo "<meta name=\"keywords\" content=\"$keywords\">\n";
  }
}
/* 
 * description
 * ====================================================
*/
function boxmoe_description() {
  global $s, $post;
  $description = '';
  $blog_name = get_bloginfo('name');
  if ( is_singular() ) {
    if( !empty( $post->post_excerpt ) ) {
      $text = $post->post_excerpt;
    } else {
      $text = $post->post_content;
    }
    $description = trim( str_replace( array( "\r\n", "\r", "\n", "　", " "), " ", str_replace( "\"", "'", strip_tags( $text ) ) ) );
    if ( !( $description ) ) $description = $blog_name . "-" . trim( wp_title('', false) );
    if(get_boxmoe('post_keywords_description_s') ) {
        $the = trim(get_post_meta($post->ID, 'description', true));
        if( $the ) $description = $the;
    }
  } elseif ( is_home () )    { $description =get_boxmoe('description');
  } elseif ( is_tag() )      { $description = $blog_name . "'" . single_tag_title('', false) . "'";
  } elseif ( is_category() ) { 

    $description = trim(strip_tags(category_description()));

    if(get_boxmoe('cat_keyworks_s') && $description && strstr($description, '::::::') ){
        $desc = explode('::::::', $description);
        $description = trim($desc[1]);
    }

  } elseif ( is_archive() )  { $description = $blog_name . "'" . trim( wp_title('', false) ) . "'";
  } elseif ( is_search() )   { $description = $blog_name . ": '" . esc_html( $s, 1 ) . "' ".__('的搜索結果', 'boxmoe');
  } else { $description = $blog_name . "'" . trim( wp_title('', false) ) . "'";
  }
  $description = mb_substr( $description, 0, 80, 'utf-8' );
  echo "<meta name=\"description\" itemprop=\"description\" itemprop=\"name\" content=\"$description\">\n";
}

//Favicon地址
function boxmoe_favicon() {
	$src = get_boxmoe('favicon_src');
	if( !empty($src) ) {
		$src = '<link rel="shortcut icon" href="'.$src.'" />';
	}else{
        $src = '<link rel="shortcut icon" href="'.get_template_directory_uri().'/assets/images/favicon.ico" />';
    }
	echo $src;
}
//节日灯笼
function boxmoe_load_lantern() {
	if (get_boxmoe('lantern') ){?>
<div id="wp"class="wp"><div class="xnkl"><div class="deng-box2"><div class="deng"><div class="xian"></div><div class="deng-a"><div class="deng-b"><div class="deng-t"><?php echo get_boxmoe('lanternfont2','度')?></div></div></div><div class="shui shui-a"><div class="shui-c"></div><div class="shui-b"></div></div></div></div><div class="deng-box3"><div class="deng"><div class="xian"></div><div class="deng-a"><div class="deng-b"><div class="deng-t"><?php echo get_boxmoe('lanternfont1','欢')?></div></div></div><div class="shui shui-a"><div class="shui-c"></div><div class="shui-b"></div></div></div></div><div class="deng-box1"><div class="deng"><div class="xian"></div><div class="deng-a"><div class="deng-b"><div class="deng-t"><?php echo get_boxmoe('lanternfont4','春')?></div></div></div><div class="shui shui-a"><div class="shui-c"></div><div class="shui-b"></div></div></div></div><div class="deng-box"><div class="deng"><div class="xian"></div><div class="deng-a"><div class="deng-b"><div class="deng-t"><?php echo get_boxmoe('lanternfont3','新')?></div></div></div><div class="shui shui-a"><div class="shui-c"></div><div class="shui-b"></div></div></div></div></div>
	<?php }else{}
}

//logo地址
function boxmoe_logo(){
    if( get_boxmoe('logo_src') ) {
    $src = '<img src="'.get_boxmoe('logo_src').'" alt="'. get_bloginfo('name') .'" class="logo">';	
    }else{
    $src = bloginfo('name');
    }    
    return  $src;
    }

// 前端载入
function boxmoe_load_scripts_and_styles() {
    wp_enqueue_style('theme-style', boxmoe_themes_dir() . '/assets/css/style.css', array(), null, false);
    wp_enqueue_style('theme-emoji-style', boxmoe_themes_dir() . '/assets/emoji/src/css/jquery.emoji.css', array(), null, false);
    wp_enqueue_script('custom-jquery', boxmoe_themes_dir() . '/assets/js/lib/jquery.min.js', array(), null, false);
    wp_enqueue_script('pjax', boxmoe_themes_dir() . '/assets/js/lib/jquery.pjax.min.js', array('custom-jquery'), null, false);
}
add_action('wp_enqueue_scripts', 'boxmoe_load_scripts_and_styles', 100);

function boxmoe_load_footer() {?>       
        <script src="<?php echo boxmoe_themes_dir();?>/assets/js/lib/theme.min.js" type="text/javascript"></script>
        <script src="<?php echo boxmoe_themes_dir();?>/assets/emoji/src/js/jquery.emoji.js" type="text/javascript"></script>
        <script src="<?php echo boxmoe_themes_dir();?>/assets/emoji/src/js/emoji.list.js" type="text/javascript"></script>
        <script src="<?php echo get_template_directory_uri();?>/assets/js/comments.js" type="text/javascript"></script>
        <script src="<?php echo boxmoe_themes_dir();?>/assets/js/boxmoe.js" type="text/javascript" id="boxmoe_script"></script>	
        <?php if (get_boxmoe('sakura')): ?>
<script src="<?php echo boxmoe_themes_dir();?>/assets/js/lib/sakura.js"></script>
        <?php endif; ?>
        <?php if (get_boxmoe('hitokoto_on')): ?>
<script type="text/javascript">
                    var hitokoto = function () {
                    $.get("https://v1.hitokoto.cn/?c=<?php echo get_boxmoe('hitokoto_text')?>", {},
                        function (data) {
                            document.getElementById("hitokoto").innerHTML = data.hitokoto;
                        });
                    };
                    if ($("#hitokoto").length) {
                        hitokoto();
                        $(document).on("pjax:complete", function () { hitokoto();initEmoji(); });
                    }
                    var initEmoji = function () {
                        $("#btn").click(function () {
                            $("#comment").emoji({
                                button: '#btn',
                                showTab: true,
                                animation: 'fade',
                                basePath: '<?php echo boxmoe_themes_dir();?>/assets/images/emoji',
                                icons: emojiLists
                            });
                        });
                    };initEmoji();
                    <?php if( get_boxmoe('footer_time') ) {
                    echo 'displayRunningTime("'.get_boxmoe('footer_time','').'")';}?>
                </script>
    <?php endif; ?>
    <?php }   
//底部链接输出
function boxmoe_footer_seo() {
	if( get_boxmoe('footer_seo') ) {
	echo '<ul class="nav flex-row align-items-center mt-sm-0 justify-content-center nav-footer">';
	echo get_boxmoe('footer_seo');
	echo '</ul>';
	}else{
		
	}	
}
//底部社交输出
function boxmoe_footer_social() {
	if(get_boxmoe('boxmoe_qq')){
		echo '<a href="https://wpa.qq.com/msgrd?v=3&amp;uin='.get_boxmoe('boxmoe_qq').'&amp;site=qq&amp;menu=yes" data-bs-toggle="tooltip" data-bs-placement="top" title="博主QQ" target="_blank" class="text-reset btn btn-social btn-icon">
          <i class="fa fa-qq"></i></a>';
		}
	if(get_boxmoe('boxmoe_wechat')){
		echo '<a href="'.get_boxmoe('boxmoe_wechat').'" data-bs-toggle="tooltip" data-bs-placement="top" title="博主微信" data-fancybox="gallery" class="text-reset btn btn-social btn-icon">
          <i class="fa fa-wechat"></i></a>';
		}	
	if(get_boxmoe('boxmoe_weibo')){
		echo '<a href="'.get_boxmoe('boxmoe_weibo').'" data-bs-toggle="tooltip" data-bs-placement="top" title="博主微博" target="_blank" class="text-reset btn btn-social btn-icon">
          <i class="fa fa-weibo"></i></a>';
		}
	if(get_boxmoe('boxmoe_github')){
		echo '<a href="'.get_boxmoe('boxmoe_github').'" data-bs-toggle="tooltip" data-bs-placement="top" title="博主Github" target="_blank" class="text-reset btn btn-social btn-icon">
          <i class="fa fa-github"></i></a>';
		}
	if(get_boxmoe('boxmoe_mail')){
		echo '<a href="http://mail.qq.com/cgi-bin/qm_share?t=qm_mailme&email='.get_boxmoe('boxmoe_mail').'" data-bs-toggle="tooltip" data-bs-placement="top" title="博主邮箱" target="_blank" class="text-reset btn btn-social btn-icon">
          <i class="fa fa-envelope"></i></a>';
		}		
}
function boxmoe_load_footerlogo() {?>
    <a class="mb-4 mb-lg-0 d-block" href="<?php echo home_url(); ?>">
    <?php echo boxmoe_logo(); ?></a>
    <?php }
//底部信息输出
function boxmoe_footer_info() {
	echo '<p class="mb-0 copyright">';
	echo 'Copyright © 2016 <a href="'.home_url().'" target="_blank">'.get_bloginfo( 'name' ).'</a>. All Rights Reserved. <br> Powered by Wordpress | Theme by
                <a href="https://www.boxmoe.com" target="_blank">LoLiMeow</a>';				
	if( get_boxmoe('footer_info') ) {
	echo '<br>'.get_boxmoe('footer_info','');	
	}
    if( get_boxmoe('footer_time') ) {
    echo '<br><span id="runningTime"></span>';	
    }
	if( get_boxmoe('boxmoedataquery') ) {
	echo '<br>'.get_num_queries().' queries in '.timer_stop().' s';	
	}
	if( get_boxmoe('trackcode') ) {
	echo '<div style="display:none;">'.get_boxmoe('trackcode').'</div>';	
	}
	echo '</p>'."\n";
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
	$banner_dir = 'style="background-image: url(\''.boxmoe_themes_dir().'/assets/images/banner/'.$temp_no.'.jpg\');" ';
	}
	else if	( get_boxmoe('banner_url') ) {
	$banner_dir = 'style="background-image: url(\''.get_boxmoe('banner_url').'\');"';}	
	else {	
	$banner_dir = 'style="background-image: url(\''.boxmoe_themes_dir().'/assets/images/banner/1.jpg\');"';
	}		
return  $banner_dir;
}

//全站布局
function boxmoe_blog_layout() {
    $sidebar ='col-lg-10 mx-auto';
    $blog_layout = get_boxmoe('blog_layout');	
        if(!empty($blog_layout)) {
            if(get_boxmoe('blog_layout') == 'two' ){
                $sidebar='col-lg-8';
                }elseif(get_boxmoe('blog_layout') == 'one' ){
                    $sidebar = 'col-lg-10 mx-auto';
                }
            }
    return  $sidebar;	
}

//布局边框
function boxmoe_border(){
    $border='';
    $border_layout= get_boxmoe('blog_layout_border');
    if(!empty($border_layout)) {
        if(get_boxmoe('blog_layout_border') == 'default' ){
            $border='';
            }elseif(get_boxmoe('blog_layout_border') == 'border' ){
                $border = 'blog-border';
            }elseif(get_boxmoe('blog_layout_border') == 'shadow' ){
                $border = 'blog-shadow';
            }
        }
        return  $border;
}



//widgets
if( get_boxmoe('blog_layout') !== 'one' ){

    if (function_exists('register_sidebar')){
        $widgets = array(
            'sitesidebar' => __('全站侧栏', 'boxmoe-com'),
            'sidebar' => __('首页侧栏', 'boxmoe-com'),
            'postsidebar' => __('文章页侧栏', 'boxmoe-com'),
            'pagesidebar' => __('页面侧栏', 'boxmoe-com'),
        );
		$boxmoeborder='';
		if(get_boxmoe('blog_layout_border') == 'default' ){
			$boxmoeborder='blog-border';
			}elseif(get_boxmoe('blog_layout_border') == 'border'){
			$boxmoeborder='blog-border';
			}elseif(get_boxmoe('blog_layout_border') == 'shadow'){
			$boxmoeborder='blog-shadow';}
        foreach ($widgets as $key => $value) {
            register_sidebar(array(
                'name'          => $value,
                'id'            => 'widget_'.$key,
                'before_widget' => '<div class="widget '.$boxmoeborder.' %2$s">',
                'after_widget'  => '</div>',
                'before_title'  => '<h4 class="widget-title">',
                'after_title'   => '</h4>'
            ));
        }
    }
    require_once get_template_directory() . '/module/template/widget-set.php';
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
