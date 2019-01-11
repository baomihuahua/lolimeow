<?php
// WordPress发布文章主动推送到百度，加快收录保护原创【WordPress通用方式】
if( meowdata('baidutuisong') ){
if(!function_exists('Baidu_Submit')){
    function Baidu_Submit($post_ID) {
        $WEB_TOKEN  = meowdata('baidutuisongkey');  //这里请换成你的网站的百度主动推送的token值
        $WEB_DOMAIN = get_option('home');
        //已成功推送的文章不再推送
        if(get_post_meta($post_ID,'Baidusubmit',true) == 1) return;
        $url = get_permalink($post_ID);
        $api = 'http://data.zz.baidu.com/urls?site='.$WEB_DOMAIN.'&token='.$WEB_TOKEN;
        $request = new WP_Http;
        $result = $request->request( $api , array( 'method' => 'POST', 'body' => $url , 'headers' => 'Content-Type: text/plain') );
        $result = json_decode($result['body'],true);
        //如果推送成功则在文章新增自定义栏目Baidusubmit，值为1
        if (array_key_exists('success',$result)) {
            add_post_meta($post_ID, 'Baidusubmit', 1, true);
        }
    }
    add_action('publish_post', 'Baidu_Submit', 0);
}
}


//全站标题 md_title()
function md_title() {
	global $new_title;
	if( $new_title ) return $new_title;

	global $paged;

	$html = '';
	$t = trim(wp_title('', false));

	if( (is_single() || is_page()) && get_the_subtitle(false) ){
		$t .= get_the_subtitle(false);
	}

	if ($t) {
		$html .= $t . md_connector();
	}

	$html .= get_bloginfo('name');

	if (is_home()) {
		if ($paged > 1) {
			$html .= md_connector() . '最新发布';
		}else{
			$html .= md_connector() . get_option('blogdescription');
		}
	}

	if ($paged > 1) {
		$html .= md_connector() . '第' . $paged . '页';
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
 * custom code
 * ====================================================
*/
add_action('wp_head', 'meowdata_wp_head');
function meowdata_wp_head() { 
    if( meowdata('site_keywords_description_s') ){
        md_keywords();
        md_description();
    }

    if( meowdata('headcode') ) echo "<!--ADD_CODE_HEADER_START-->\n".meowdata('headcode')."\n<!--ADD_CODE_HEADER_END-->\n";
}

add_action('wp_footer', 'ttm_wp_footer');
function ttm_wp_footer() { 
    if( meowdata('footcode') ) echo "<!--ADD_CODE_FOOTER_START-->\n".meowdata('footcode')."\n<!--ADD_CODE_FOOTER_END-->\n";
}




/* 
 * post meta keywords
 * ====================================================
*/
$postmeta_keywords_description = array(
    array(
        "name" => "keywords",
        "std" => "",
        "title" => __('关键字', 'meowdata').'：'
    ),
    array(
        "name" => "description",
        "std" => "",
        "title" => __('描述', 'meowdata').'：'
        )
);
if( meowdata('post_keywords_description_s') ){
    add_action('admin_menu', 'md_postmeta_keywords_description_create');
    add_action('save_post', 'md_postmeta_keywords_description_save');
}

function md_postmeta_keywords_description() {
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

function md_postmeta_keywords_description_create() {
    global $theme_name;
    if ( function_exists('add_meta_box') ) {
        add_meta_box( 'postmeta_keywords_description_boxes', __('自定义关键字和描述', 'meowdata'), 'md_postmeta_keywords_description', 'post', 'normal', 'high' );
        add_meta_box( 'postmeta_keywords_description_boxes', __('自定义关键字和描述', 'meowdata'), 'md_postmeta_keywords_description', 'page', 'normal', 'high' );
    }
}

function md_postmeta_keywords_description_save( $post_id ) {
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
function md_keywords() {
  global $s, $post;
  $keywords = '';
  if ( is_singular() ) {
    if ( get_the_tags( $post->ID ) ) {
      foreach ( get_the_tags( $post->ID ) as $tag ) $keywords .= $tag->name . ', ';
    }
    foreach ( get_the_category( $post->ID ) as $category ) $keywords .= $category->cat_name . ', ';
    if(meowdata('post_keywords_description_s') ) {
        $the = trim(get_post_meta($post->ID, 'keywords', true));
        if( $the ) $keywords = $the;
    }else{
        $keywords = substr_replace( $keywords , '' , -2);
    }
    
  } elseif ( is_home () )    { $keywords =meowdata('keywords');
  } elseif ( is_tag() )      { $keywords = single_tag_title('', false);
  } elseif ( is_category() ) { $keywords = single_cat_title('', false);

    if(meowdata('cat_keyworks_s') ){
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
function md_description() {
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
    if(meowdata('post_keywords_description_s') ) {
        $the = trim(get_post_meta($post->ID, 'description', true));
        if( $the ) $description = $the;
    }
  } elseif ( is_home () )    { $description =meowdata('description');
  } elseif ( is_tag() )      { $description = $blog_name . "'" . single_tag_title('', false) . "'";
  } elseif ( is_category() ) { 

    $description = trim(strip_tags(category_description()));

    if(meowdata('cat_keyworks_s') && $description && strstr($description, '::::::') ){
        $desc = explode('::::::', $description);
        $description = trim($desc[1]);
    }

  } elseif ( is_archive() )  { $description = $blog_name . "'" . trim( wp_title('', false) ) . "'";
  } elseif ( is_search() )   { $description = $blog_name . ": '" . esc_html( $s, 1 ) . "' ".__('的搜索結果', 'meowdata');
  } else { $description = $blog_name . "'" . trim( wp_title('', false) ) . "'";
  }
  $description = mb_substr( $description, 0, 80, 'utf-8' );
  echo "<meta name=\"description\" itemprop=\"description\" itemprop=\"name\" content=\"$description\">\n";
}