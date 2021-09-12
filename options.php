<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 */
function optionsframework_option_name() {
	// Change this to use your theme slug
	$option_name = get_option( 'stylesheet' );
    $option_name = preg_replace( "/\W/", "_", strtolower( $option_name ) );
    return $option_name;
}

/** 
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'ui_boxmoe_com'
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */

function optionsframework_options() {

	// Test data
	$test_array = array(
		'one' => __( 'One', 'ui_boxmoe_com' ),
		'two' => __( 'Two', 'ui_boxmoe_com' ),
		'three' => __( 'Three', 'ui_boxmoe_com' ),
		'four' => __( 'Four', 'ui_boxmoe_com' ),
		'five' => __( 'Five', 'ui_boxmoe_com' )
	);

	// Multicheck Array
	$multicheck_array = array(
		'one' => __( 'French Toast', 'ui_boxmoe_com' ),
		'two' => __( 'Pancake', 'ui_boxmoe_com' ),
		'three' => __( 'Omelette', 'ui_boxmoe_com' ),
		'four' => __( 'Crepe', 'ui_boxmoe_com' ),
		'five' => __( 'Waffle', 'ui_boxmoe_com' )
	);

	// Multicheck Defaults
	$multicheck_defaults = array(
		'one' => '1',
		'five' => '1'
	);

	// Background Defaults
	$background_defaults = array(
		'color' => '',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top center',
		'attachment'=>'scroll' );

	// Typography Defaults
	$typography_defaults = array(
		'size' => '15px',
		'face' => 'georgia',
		'style' => 'bold',
		'color' => '#bada55' );

	// Typography Options
	$typography_options = array(
		'sizes' => array( '6','12','14','16','20' ),
		'faces' => array( 'Helvetica Neue' => 'Helvetica Neue','Arial' => 'Arial' ),
		'styles' => array( 'normal' => 'Normal','bold' => 'Bold' ),
		'color' => false
	);

	// Pull all the categories into an array
	$options_categories = array();
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}

	// Pull all tags into an array
	$options_tags = array();
	$options_tags_obj = get_tags();
	foreach ( $options_tags_obj as $tag ) {
		$options_tags[$tag->term_id] = $tag->name;
	}


	// Pull all the pages into an array
	$options_pages = array();
	$options_pages_obj = get_pages( 'sort_column=post_parent,menu_order' );
	$options_pages[''] = '选择一个页面:';
	foreach ($options_pages_obj as $page) {
		$options_pages[$page->ID] = $page->post_title;
	}

	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri() . '/assets/images/';
	$webhome = 'http://www.boxmoe.com';
	$options = array();
//==========================================================================================
	$options[] = array(
		'name' => __( '全局设置', 'ui_boxmoe_com' ),
		'desc' => __( '（LOGO Favicon 其他影响全站的开关设置）', 'ui_boxmoe_com' ),
		'type' => 'heading'
	);
	$options[] = array(
		'name' => "★全站布局(侧栏/无侧栏切换)[模块边框在文章设置里设置]",
		'id' => "sidebar_on",
		'std' => "col-1",
		'type' => "images",
		'options' => array(
			'col-1' => $imagepath . 'col-1.png',
			'col-2' => $imagepath . 'col-2.png'
		)
	);
	$options[] = array(
		'name' => __('★文章列表边框/全站模块边框', 'ui_boxmoe_com'),
		'id' => 'blog_border',
		'std' => "border1",
		'type' => "radio",
		'options' => array(
			'border1' => __('线条边框', 'ui_boxmoe_com'),
			'border2' => __('阴影模块', 'ui_boxmoe_com'),
			'border3' => __('去除边框', 'ui_boxmoe_com')
		));	
	$options[] = array(
		'name' => __( '（1）LOGO设置', 'ui_boxmoe_com' ),
		'id' => 'logo_src',
		'desc' => __(' ', 'ui_boxmoe_com'),
		'std' => $imagepath.'logo.png',
		'type' => 'upload');
	$options[] = array(
		'name' => __( '（2）Favicon地址', 'ui_boxmoe_com' ),
		'id' => 'favicon_src',
		'std' => $imagepath.'favicon.ico',
		'type' => 'upload');	
	$options[] = array(
		'name' => __('（3）使用外链加载前端资源CSS JS', 'ui_boxmoe_com'),
		'instructions' => __('（开启后将外部链接填写在下方才能生效[assets里的静态文件]）', 'ui_boxmoe_com'),
		'id' => 'style_src_onoff',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启', 'ui_boxmoe_com'),);		
	$options[] = array(
	    'name' => __('（3-1）将主题中“assets”文件上传到七牛 OSS之类加速前端加载，链接结尾不带/', 'ui_boxmoe_com'), 
		'id' => 'style_src',
		'std' => '',
		'settings' => array('rows' => 2),
		'class' => 'hidden',
		'type' => 'textarea');	
	$gravatar_array = array(
	    'lolinet' => __('萝莉服务器（荐）', 'ui_boxmoe_com'),
		'qiniu' => __('七牛服务器（荐）', 'ui_boxmoe_com'),
		'geekzu' => __('极客服务器（荐）', 'ui_boxmoe_com'),
		'v2excom' => __('v2ex服务器', 'ui_boxmoe_com'),
		'cn' => __('官方CN服务器', 'ui_boxmoe_com'),
		'ssl' => __('官方SSL服务器', 'ui_boxmoe_com'),		
	);
	$options[] = array(
		'name' => __('（4）Gravatar头像加速服务器', 'ui_boxmoe_com'),
		'instructions' => __('（通过镜像服务器可对gravatar头像进行加速）', 'ui_boxmoe_com'),
		'id' => 'gravatar_url',
		'std' => 'lolinet',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => $gravatar_array);	
	$options[] = array(
		'name' => __('（5）分类链接去除category标识', 'ui_boxmoe_com'),
		'instructions' => __('（需要开启伪静态/固定链接需要保存一次 wordpress的设置 → 固定链接）', 'ui_boxmoe_com'),
		'id' => 'no_categoty',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启', 'ui_boxmoe_com'),);	
    $options[] = array(
		'name' => __('（6）导航搜索功能开启', 'ui_boxmoe_com'),
		'id' => 'sousuo',
		'type' => "checkbox",
		'std' => true,
		'desc' => __('开启', 'ui_boxmoe_com')); 
	$options[] = array(
		'name' => __('（7）网页右侧小萝莉开关，附带back to top 回到顶部功能', 'ui_boxmoe_com'),
		'id' => 'lolijump',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启', 'ui_boxmoe_com')); 
	$options[] = array(
		'name' => __('（7-1）选择前端小萝莉展现形象', 'ui_boxmoe_com'),
		'id' => 'lolijumpsister',
		'type' => "radio",
		'std' => 'lolisister1',
		'class' => 'hidden',
		'options' => array(
			'lolisister1' => __(' 萝莉姐姐 ', 'ui_boxmoe_com'),
			'lolisister2' => __(' 萝莉妹妹', 'ui_boxmoe_com'),
			'meow' => __(' 喵小娘', 'ui_boxmoe_com'),
			'bear' => __(' 熊宝宝', 'ui_boxmoe_com')
		));			
	$hitokoto_array = array(
	    'a' => __('动画', 'ui_boxmoe_com'),
		'b' => __('漫画', 'ui_boxmoe_com'),
		'c' => __('游戏', 'ui_boxmoe_com'),
		'd' => __('文学', 'ui_boxmoe_com'),
		'e' => __('原创', 'ui_boxmoe_com'),
		'f' => __('来自网络', 'ui_boxmoe_com'),	
		'g' => __('其他', 'ui_boxmoe_com'),
		'h' => __('影视', 'ui_boxmoe_com'),
		'i' => __('诗词', 'ui_boxmoe_com'),
		'j' => __('网易云', 'ui_boxmoe_com'),
		'k' => __('哲学', 'ui_boxmoe_com'),
	);
	$options[] = array(
		'name' => __('（8）首页一言句子分类', 'ui_boxmoe_com'),
		'instructions' => __('（首页博客文章上方）', 'ui_boxmoe_com'),
		'id' => 'hitokoto_text',
		'std' => 'lolinet',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => $hitokoto_array);	

	$options[] = array(
		'name' => __('（9）网站底部导航链接', 'ui_boxmoe_com'),
		'id' => 'footer_seo',
		'std' => '<a href="'.site_url('/sitemap.xml').'" target="_blank" class="me-xl-5 me-3 mb-sm-0 mb-2">网站地图</a>'."\n",
		'instructions' => __('（网站地图可自行使用sitemap插件自动生成）', 'ui_boxmoe_com'),
		'settings' => array('rows' => 3),
		'type' => 'textarea');
	$options[] = array(
		'name' => __('（10）网站底部版权后自定义信息（支持HTML）', 'ui_boxmoe_com'),
		'id' => 'footer_info',
		'std' => '| 本站使用Wordpress创作'."\n",
		'settings' => array('rows' => 3),
		'type' => 'textarea');	
	$options[] = array(
		'name' => __('（11）底部显示页面执行时间', 'ui_boxmoe_com'),
		'instructions' => __('（默认关闭，开启后底部显示页面执行时间）', 'ui_boxmoe_com'),
		'id' => 'boxmoedataquery',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启', 'ui_boxmoe_com'));	
    $options[] = array(
		'name' => __('（12）统计代码', 'ui_boxmoe_com'),
		'instructions' => __('（底部第三方流量数据统计代码）', 'ui_boxmoe_com'),
		'id' => 'trackcode',
		'std' => '统计代码',
		'settings' => array('rows' => 3),
		'type' => 'textarea');		
//==========================================================================================
	$options[] = array(
		'name' => __( 'Banner设置', 'ui_boxmoe_com' ),
		'desc' => __( '（导航下的图片设置）', 'ui_boxmoe_com' ),
		'type' => 'heading'
	);
	$options[] = array(
		'name' => __('页面Banner背景图', 'ui_boxmoe_com'),
		'id' => 'banner_url',
		'std' => $imagepath.'banner/1.jpg',
		'type' => 'upload');    
    $options[] = array(
		'name' => __('Banner随机背景图', 'ui_boxmoe_com'),
		'instructions' => __('（开启后上方↑图片失效，在主题boxmoe/assets/images/banner/下加入图片即可）', 'ui_boxmoe_com'),		
		'id' => 'banner_rand',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启', 'ui_boxmoe_com'),);	 
	$options[] = array(
		'name' => __('Banner随机图片数量', 'ui_boxmoe_com'),
		'id' => 'banner_rand_n',
		'std' => 12,
		'instructions' => __('（图片命名为1.jpg ...x.jpg ，x=1-你上面设置的数量，格式JPG） ', 'ui_boxmoe_com'),
		'class' => 'hidden mini',
		'type' => 'text');
    $options[] = array(
		'name' => __('开启APi随机图片', 'ui_boxmoe_com'),
		'instructions' => __('（开启后上方图片功能全失效）', 'ui_boxmoe_com'),		
		'id' => 'banner_api_on',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启', 'ui_boxmoe_com'),);
	$options[] = array(
		'name' => __('图片APi链接', 'ui_boxmoe_com'),
		'id' => 'banner_api_url',
		'std' => "",
		'class' => 'hidden',
		'type' => 'text');	
//==========================================================================================
	$options[] = array(
		'name' => __( 'SEO设置', 'ui_boxmoe_com' ),
		'desc' => __( '（主题对搜索引擎SEO优化）', 'ui_boxmoe_com' ),
		'type' => 'heading'
	);	
    $options[] = array(
		'name' => __( '全站标题连接符', 'ui_boxmoe_com' ),
		'instructions' => __('（“-”或“_”一般设置就不要去修改它，会影响SEO）', 'ui_boxmoe_com'),
		'id' => 'connector',
		'std' => get_boxmoe('connector') ? get_boxmoe('connector') : '-',
		'class' => 'mini',
		'type' => 'text');

	$options[] = array(
		'name' => __('百度文章发布主动推送', 'ui_boxmoe_com'),
		'id' => 'baidutuisong',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启', 'ui_boxmoe_com')); 
	 
	$options[] = array(
		'name' => __( '百度文章发布主动推送key', 'ui_boxmoe_com' ),
		'id' => 'baidutuisongkey',
		'std' =>'',
		'type' => 'text',
		'class' => 'hidden',
		'desc' => __('如果推送成功则在文章新增自定义栏目Baidusubmit，值为1', 'ui_boxmoe_com'),
	);	 
	 
	$options[] = array(
		'name' => __('首页关键字(keywords)', 'ui_boxmoe_com'),
		'id' => 'keywords',
		'std' => 'WordPress',
		'desc' => __('用英文逗号隔开', 'ui_boxmoe_com'),
		'settings' => array(
			'rows' => 3
		),
		'type' => 'textarea');

	$options[] = array(
		'name' => __('网站描述(description)', 'ui_boxmoe_com'),
		'id' => 'description',
		'std' => '又是一个博客',
		'settings' => array(
		'rows' => 3),
		'type' => 'textarea');

	$options[] = array(
		'name' => __('分类关键字', 'ui_boxmoe_com'),
		'instructions' => __('（开启后分类的关键字将自动获取分类中的“图像描述”中的一部分，请用“::::::”6个英文冒号隔开关键字和描述，比如：关键字1,关键字2::::::描述描述）', 'ui_boxmoe_com'),
		'id' => 'cat_keyworks_s',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启', 'ui_boxmoe_com')
		);

	$options[] = array(
		'name' => __('网站自动添加关键字和描述', 'ui_boxmoe_com'),
		'instructions' => __('（开启后所有页面将自动使用主题配置的关键字和描述）', 'ui_boxmoe_com'),
		'id' => 'site_keywords_description_s',
		'type' => "checkbox",
		'std' => true,
		'desc' => __('开启', 'ui_boxmoe_com'));

	$options[] = array(
		'name' => __('自定义文章关键字和描述', 'ui_boxmoe_com'),
		'instructions' => __('（开启后你需要在编辑文章的时候书写关键字和描述，如果为空，将自动使用主题配置的关键字和描述；开启这个必须开启上面的“网站自动添加关键字和描述”开关）', 'ui_boxmoe_com'),
		'id' => 'post_keywords_description_s',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启', 'ui_boxmoe_com'));	
//==========================================================================================
	$options[] = array(
		'name' => __( '文章设置', 'ui_boxmoe_com' ),
		'desc' => __( '（有关文章的地方设置项）', 'ui_boxmoe_com' ),
		'type' => 'heading'
	);
	$options[] = array(
		'name' => __('关闭全站文章评论', 'ui_boxmoe_com'),
		'id' => 'comments_off',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启', 'ui_boxmoe_com'));	
	$options[] = array(
		'name' => __('文章相关模块渐进动态效果', 'ui_boxmoe_com'),
		'id' => 'wow_on',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启', 'ui_boxmoe_com'));		
	$options[] = array(
		'name' => __('文章随机缩略图数量', 'ui_boxmoe_com'),
		'id' => 'thumbnail_rand_n',
		'std' => 5,
		'class' => 'mini',
		'instructions' => __('（图片放在在主题boxmoe/assets/images/rand/N.jpg，N=1-你设置的数量）', 'ui_boxmoe_com'),
		'type' => 'text');	
    $options[] = array(
		'name' => __('新窗口打开文章', 'ui_boxmoe_com'),
		'instructions' => __('（开启后文章链接都是新窗口打开）', 'ui_boxmoe_com'),
		'id' => 'target_blank',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启', 'ui_boxmoe_com'));	
	$options[] = array(
		'name' => __('文章列表分页模式', 'ui_boxmoe_com'),
		'id' => 'paging_type',
		'std' => "multi",
		'type' => "radio",
		'options' => array(
			'next' => __(' 上一页 和 下一页', 'ui_boxmoe_com'),
			'multi' => __('页码  1 2 3 ', 'ui_boxmoe_com')
		));
	$options[] = array(
		'name' => __('正文底部相关文章', 'ui_boxmoe_com'),
		'id' => 'post_related_s',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启', 'ui_boxmoe_com'));
    $options[] = array(
		'name' => __('相关文章显示方式', 'ui_boxmoe_com'),
		'id' => 'post_related_model',
		'type' => "radio",
		'std' => 'thumb',
		'options' => array(
			'thumb' => __(' 图文模式 ', 'ui_boxmoe_com')
	//		'text' => __(' 文字链模式 ', 'ui_boxmoe_com')
		));
	$options[] = array(
		'name' => __('相关文章-显示文章数量', 'ui_boxmoe_com'),
		'id' => 'post_related_n',
		'std' => 3,
		'class' => 'mini',
		'desc' => __('建议使用3 6 9 12这样排版', 'ui_boxmoe_com'),
		'type' => 'text');		
	$options[] = array(
		'name' => __('文章作者信息框', 'ui_boxmoe_com'),
		'instructions' => __('（位于文章内容下方）', 'ui_boxmoe_com'),		
		'id' => 'open_author_info',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启', 'ui_boxmoe_com'));	
	$options[] = array(
		'name' => __('文章作者信息', 'ui_boxmoe_com'),
		'instructions' => __('（关于联系图标在社交设置里填写就可以）', 'ui_boxmoe_com'),	
		'id' => 'authorinfo',
		'settings' => array(
		'rows' => 3),
		'class' => 'hidden',
		'std' => '作者信息模块...后台面板填写内容...',
		'type' => 'textarea');		
//==========================================================================================
	$options[] = array(
		'name' => __( '评论设置', 'ui_boxmoe_com' ),
		'type' => 'heading'
	);
	$options[] = array(
		'name' => __('屏蔽非会员纯英文评论和纯日文评论', 'ui_boxmoe_com'),	
		'id' => 'false_enjp_comment',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启', 'ui_boxmoe_com'));	
	$options[] = array(
			'name' => __('评论:管理员标志命名', 'ui_boxmoe_com'),
			'id' => 'comnanes',
			'std' => '博主',
			'class' => 'mini',
			'desc' => __('管理员发表回复评论的标志', 'ui_boxmoe_com'),
			'type' => 'text');
    $options[] = array(
			'name' => __('评论:注册会员标志命名', 'ui_boxmoe_com'),
			'id' => 'comnanesu',
			'std' => '会员',
			'class' => 'mini',
			'desc' => __('注册会员发表回复评论的标志', 'ui_boxmoe_com'),
			'type' => 'text');
	$options[] = array(
			'name' => __('评论:游客标志命名', 'ui_boxmoe_com'),
			'id' => 'comnaness',
			'std' => '游客',
			'class' => 'mini',
			'desc' => __('管理员发表回复评论的标志', 'ui_boxmoe_com'),
			'type' => 'text');		
//==========================================================================================
	$options[] = array(
		'name' => __( '会员设置', 'ui_boxmoe_com' ),
		'desc' => __( '（会员系统需要配合插件erphpdown才能使用）', 'ui_boxmoe_com' ),
		'type' => 'heading'
	);	
	$options[] = array(
		'name' => __('开启导航会员注册链接', 'ui_boxmoe_com'),
		'instructions' => __( '（需要配合erphpdown插件）', 'ui_boxmoe_com' ),
		'id' => 'sign_f',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启', 'ui_boxmoe_com')
	);
	//$options[] = array(
	//	'name' => __( '添加注册验证答案', 'ui_boxmoe_com' ),
	//	'instructions' => __( '（留空默认关闭验证）', 'ui_boxmoe_com' ),
	//	'id' => 'reg_question',
	//	'type' => 'text',
	//	'class' => 'hidden mini',
	//	'std' => ''
	//);
	$options[] = array(
		'name' => __( '会员中心信息面板Banner图', 'ui_boxmoe_com' ),
		'id' => 'user_banner_src',
		'desc' => __(' ', 'ui_boxmoe_com'),
		'std' => $imagepath.'banner/1.jpg',
		'class' => 'hidden',
		'type' => 'upload');
    $options[] = array(
		'name' => __('注册会员支持中文', 'ui_boxmoe_com'),
		'id' => 'sign_zhcn',
		'type' => "checkbox",
		'std' => false,
		'class' => 'hidden',
		'desc' => __('开启', 'ui_boxmoe_com')
	);
	$options[] = array(
		'name' => __( '会员登录页面', 'ui_boxmoe_com' ),
		'desc' => __( '选择前端会员登录页面，新建一个页面选择会员登录模板', 'ui_boxmoe_com' ),
		'id' => 'users_login',
		'type' => 'select',
		'class' => 'hidden',
		'options' => $options_pages
	);
	$options[] = array(
		'name' => __( '会员注册页面', 'ui_boxmoe_com' ),
		'desc' => __( '选择前端会员注册页面，新建一个页面选择会员注册模板', 'ui_boxmoe_com' ),
		'id' => 'users_reg',
		'type' => 'select',
		'class' => 'hidden',
		'options' => $options_pages
	);
	$options[] = array(
		'name' => __( '重置密码页面', 'ui_boxmoe_com' ),
		'desc' => __( '选择前端重置密码页面，新建一个页面选择重置密码模板', 'ui_boxmoe_com' ),
		'id' => 'users_reset',
		'type' => 'select',
		'class' => 'hidden',
		'options' => $options_pages
	);
	$options[] = array(
		'name' => __( '会员中心页面', 'ui_boxmoe_com' ),
		'desc' => __( '选择前端会员中心页面，新建一个页面选择会员中心模板【需要配合erphpdown插件】', 'ui_boxmoe_com' ),
		'id' => 'users_page',
		'type' => 'select',
		'class' => 'hidden',
		'options' => $options_pages
	);	
    $options[] = array(
		'name' => __( '注册成功后会员跳转页面', 'ui_boxmoe_com' ),
		'id' => 'regto',
		'std' => $webhome,
		'class' => 'hidden',
		'type' => 'text'
	);	
    $options[] = array(
		'name' => __( '登录成功后会员跳转页面', 'ui_boxmoe_com' ),
		'id' => 'loginto',
		'std' => $webhome,
		'class' => 'hidden',
		'type' => 'text'
	);
	$options[] = array(
	    'name' => __('前端充值卡购买链接', 'ui_boxmoe_com'), 
		'id' => 'czcard_src',
		'std' => '',
		'class' => 'hidden',
		'type' => 'text');		 
//==========================================================================================
	$options[] = array(
		'name' => __( '社交设置', 'ui_boxmoe_com' ),
		'type' => 'heading'
	);	
	//$options[] = array(
	//	'name' => __('文章打赏二维码'),
	//	'instructions' => __('（先记着下版出，直接上传图片，留空不展现）', 'ui_boxmoe_com'),
	//	'id' => 'boxmoe_dayegivemesomemoney',
	//	'std' => $imagepath.'dayegivemesomemoney.jpg',
	//	'type' => 'upload');
	$options[] = array(
		'name' => __('QQ联系'),
		'instructions' => __('直接输入QQ号，留空不展现', 'ui_boxmoe_com'),
		'id' => 'boxmoe_qq',
		'std' => '10000',
		'class' => 'mini',
		'type' => 'text');	
	$options[] = array(
		'name' => __('微信二维码'),
		'instructions' => __('直接上传图片，留空不展现。', 'ui_boxmoe_com'),
		'id' => 'boxmoe_wechat',
		'std' => $imagepath.'wechat.jpg',
		'type' => 'upload');		
    $options[] = array(
		'name' => __('Email邮箱'),
		'instructions' => __('直接输入邮箱，留空不展现。', 'ui_boxmoe_com'),
		'id' => 'boxmoe_mail',
		'class' => 'mini',
		'type' => 'text');	
	$options[] = array(
		'name' => __('Github'),
		'instructions' => __('直接输入链接，留空不展现', 'ui_boxmoe_com'),
		'id' => 'boxmoe_github',
		'std' => 'https://www.boxmoe.com',
		'type' => 'text');
    $options[] = array(
		'name' => __('微博'),
		'instructions' => __('直接输入链接，留空不展现', 'ui_boxmoe_com'),
		'id' => 'boxmoe_weibo',
		'std' => 'https://www.boxmoe.com',
		'type' => 'text');
//==========================================================================================
	$options[] = array(
		'name' => __( '友链设置', 'ui_boxmoe_com' ),
		'type' => 'heading'
	);	
	$options[] = array(
		'name' => __('首页友链待添加前端UI，目前开启无效', 'ui_boxmoe_com'),
		'id' => 'indexlinks',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启', 'ui_boxmoe_com'),);
	//$options[] = array(
	//	'name' => __('首页友情链接申请地址'),
	//	'desc' => __('填写自己站点的友情链接申请地址', 'ui_boxmoe_com'),
	//	'id' => 'yqlinks',
	//	'std' => 'https://boxmoe.com',
	//	'type' => 'text');	
	//$options[] = array(
	//	'name' => __('首页友情链接命名'),
	//	'desc' => __('自己想怎么取就怎么取', 'ui_boxmoe_com'),
	//	'id' => 'yqlinksname',
	//	'std' => '友情链接',
	//	'type' => 'text');
	//$options[] = array(
	//	'name' => __('友情链接分类目录ID'),
	//	'desc' => __('填写首页要显示的分类目录id，留空全部显示', 'ui_boxmoe_com'),
	//	'id' => 'yqlinksid',
	//	'class' => 'mini',
	//	'std' => 'null',
	//	'type' => 'text');		
//==========================================================================================
	$options[] = array(
		'name' => __( '邮件设置', 'ui_boxmoe_com' ),
		'type' => 'heading'
	);
	$options[] = array(
		'name' => __('开启SMTP发件功能', 'ui_boxmoe_com'),
		'instructions' => __('（开启后下面也要设置好才生效）', 'ui_boxmoe_com'),
		'id' => 'smtpmail',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启', 'ui_boxmoe_com'),);	
	$options[] = array(
		'name' => __( '发件人', 'ui_boxmoe_com' ),
		'id' => 'fromnames',
		'std' => '盒子萌',
		'class' => 'mini hidden',
		'type' => 'text'
	);		
	$options[] = array(
		'name' => __( 'SMTP服务器', 'ui_boxmoe_com' ),
		'id' => 'smtphost',
		'std' => 'smtp.boxmoe.com',
		'class' => 'mini hidden',
		'type' => 'text'
	);
    $options[] = array(
		'name' => __( '加密SSL，如果留空下方端口填写25', 'ui_boxmoe_com' ),
		'id' => 'smtpsecure',
		'std' => 'ssl',
		'class' => 'mini hidden',
		'type' => 'text'
	);		
    $options[] = array(
		'name' => __( 'SMTP端口(SSL一般为465，普通为25)', 'ui_boxmoe_com' ),
		'id' => 'smtpprot',
		'std' => '465',
		'class' => 'mini hidden',
		'type' => 'text'
	);	
	$options[] = array(
		'name' => __( '邮箱账户', 'ui_boxmoe_com' ),
		'id' => 'smtpusername',
		'std' => 'sys@boxmoe.com',
		'class' => 'mini hidden',
		'type' => 'text'
	);	
	$options[] = array(
		'name' => __( '邮箱密码', 'ui_boxmoe_com' ),
		'id' => 'smtppassword',
		'std' => 'boxmoe',
		'class' => 'mini hidden',
		'type' => 'password'
	);
 
//==========================================================================================
	$options[] = array(
		'name' => __('优化设置', 'ui_boxmoe_com'),
		'type' => 'heading');
	$options[] = array(
		'name' => __('关闭古腾堡移除前端加载样式', 'ui_boxmoe_com'),
		'id' => 'gutenberg_off',
		'type' => "checkbox",
		'std' => true,
		'desc' => __('开启 （5.0版本后使用，可关闭新编辑器和前端样式）', 'ui_boxmoe_com'));		 	
	$options[] = array(
		'name' => __('Wordpress头部优化', 'ui_boxmoe_com'),
		'id' => 'wpheader_on',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启 （移除feed WordPress版本号等等没用东西，如果个别和插件有冲突报错可直接注释掉某行）', 'ui_boxmoe_com'),);	
	$options[] = array(
		'name' => __('移除头部feed', 'ui_boxmoe_com'),
		'id' => 'feed_off',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启', 'ui_boxmoe_com'),);			
	$options[] = array(
		'name' => __('移除头部emoji表情的 dns-refresh 功能', 'ui_boxmoe_com'),
		'id' => 'remove_dns_refresh',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启', 'ui_boxmoe_com'),);	
	$options[] = array( 
		'name' => __('禁用文章自动保存', 'ui_boxmoe_com'),
		'id' => 'autosaveop',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启', 'ui_boxmoe_com'),);
	$options[] = array(
		'name' => __('禁用文章修订版本', 'ui_boxmoe_com'),
		'id' => 'revisions_to_keepop',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启', 'ui_boxmoe_com'),);
	$options[] = array(
		'name' => __('移除Emoji', 'ui_boxmoe_com'),
		'id' => 'emoji_off',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启', 'ui_boxmoe_com'),);		
	$options[] = array(
		'name' => __('移除RSS订阅', 'ui_boxmoe_com'),
		'id' => 'rss_off',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启', 'ui_boxmoe_com'),);		
	$options[] = array(
		'name' => __('禁止Pingback', 'ui_boxmoe_com'),
		'id' => 'Pingback_off',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启', 'ui_boxmoe_com'),);		
	$options[] = array(
		'name' => __('关闭embeds', 'ui_boxmoe_com'),
		'id' => 'embeds_off',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启', 'ui_boxmoe_com'),);	
	
//==========================================================================================
	$options[] = array(
		'name' => __('其他拓展', 'ui_boxmoe_com'),
		'desc' => __( '（主题功能拓展区，未来一些待开发新功能）', 'ui_boxmoe_com' ),
		'type' => 'heading');
//拓展区===================================================================================
	$options[] = array(
		'name' => __('全站底部音乐播放器开关', 'ui_boxmoe_com'),

		'id' => 'music_on',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启', 'ui_boxmoe_com'),);	
	$options[] = array(
		'name' => __( '网易云歌单ID', 'ui_boxmoe_com' ),
		'instructions' => __('（music.163.com/#/playlist?id=* 链接后面的ID）', 'ui_boxmoe_com'),		
		'id' => '163_music_id',
		'std' => '2765798464',
		'class' => 'mini hidden',
		'type' => 'text'
	);






//拓展区结束=====================================================================================
	return $options;
}