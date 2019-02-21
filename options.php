<?php
function optionsframework_option_name() {
	// Change this to use your theme slug
	return 'options-framework-theme';
}

function optionsframework_options() {

	// Test data
	$test_array = array(
		'one' => __( 'One', 'theme-textdomain' ),
		'two' => __( 'Two', 'theme-textdomain' ),
		'three' => __( 'Three', 'theme-textdomain' ),
		'four' => __( 'Four', 'theme-textdomain' ),
		'five' => __( 'Five', 'theme-textdomain' )
	);

	// Multicheck Array
	$multicheck_array = array(
		'one' => __( 'French Toast', 'theme-textdomain' ),
		'two' => __( 'Pancake', 'theme-textdomain' ),
		'three' => __( 'Omelette', 'theme-textdomain' ),
		'four' => __( 'Crepe', 'theme-textdomain' ),
		'five' => __( 'Waffle', 'theme-textdomain' )
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
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
		$options_pages[$page->ID] = $page->post_title;
	}

	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri() . '/assets/images/';
	$style= get_template_directory_uri();
	$webhome= get_option('home');
    $rrr = ' / ';
	$nnn = ' / ';
	$options = array();
	
	
	
//==============================================================================
    $options[] = array(
		'name' => __( '全局', 'meowdataui' ),
		'type' => 'heading'
	);
	
	$options[] = array(
		'name' => __( 'LOGO设置', 'meowdataui' ),
		'id' => 'logosrc',
		'desc' => __(' ', 'meowdataui'),
		'std' => $imagepath.'logo.png',
		'type' => 'upload');
		
	$options[] = array(
		'name' => __( 'Favicon地址', 'meowdataui' ),
		'id' => 'favicon_src',
		'std' => $imagepath.'favicon.ico',
		'type' => 'upload');	
		
	$options[] = array(
		'name' => __( '前端静态CSS JS链接', 'meowdataui' ),
		'desc' => __( '不带/', 'meowdataui' ),
		'id' => 'style_src',
		'std' => $style,
		'settings' => array('rows' => 1),
		'type' => 'textarea');
			
	//$options[] = array(
		//'name' => __( '开启Gravatar头像CDN加速', 'meowdataui' ),
		//'desc' => __( '开启', 'meowdataui' ),
		//'id' => 'gravatar_cdn',
		//'type' => 'checkbox'
	//);

	$options[] = array(
		'name' => __('Gravatar头像链接', 'meowdataui'),
		'id' => 'gravatar_url',
		'std' => "https://gravatar.loli.net/avatar/",
		'desc' => __( '备用：https://cdn.v2ex.com/gravatar/', 'meowdataui' ),
		'settings' => array('rows' => 1),
		'type' => 'textarea');

	$options[] = array(
		'name' => __('分类去除category', 'meowdataui'),
		'id' => 'no_categoty',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启  （需要开启伪静态/固定链接需要保存一次 Settings → 固定链接）', 'meowdataui'),);	

	$options[] = array(
		'name' => __('关闭古腾堡移除前端加载样式', 'meowdataui'),
		'id' => 'gutenbergoff',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启 （5.0版本后使用，可关闭新编辑器和前端样式）', 'meowdataui'));	
	
	$options[] = array(
		'name' => __('开启自定义CSS', 'meowdataui'),
		'id' => 'diystyles',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启 （启用后在主题目录/assets/css/diystyle.css 里添加自己的CSS前端会生效）', 'meowdataui'));	

	$options[] = array(
		'name' => __('网站底部导航链接', 'meowdataui'),
		'id' => 'footer_seo',
		'std' => '<li class="nav-item"><a href="'.site_url('/sitemap.xml').'" class="nav-link" target="_blank">'.__('网站地图', 'meowdataui').'</a></li>'."\n",
		'desc' => __('网站地图可自行使用sitemap插件自动生成', 'meowdataui'),
		'type' => 'textarea');
	$options[] = array(
		'name' => __('网站底部版权后自定义信息', 'meowdataui'),
		'id' => 'footer_info',
		'std' => '本站使用Wordpress创作'."\n",
		'type' => 'textarea');	
    $options[] = array(
		'name' => __('网站统计代码', 'meowdataui'),
		'desc' => __('底部第三方流量数据统计代码,默认主题隐藏统计代码，具体查看前端源码', 'meowdataui'),
		'id' => 'trackcode',
		'std' => '统计代码',
		'type' => 'textarea');	

     
    /* 
	 * Banner
	 * ====================================================================================================
	 */	
	$options[] = array(
		'name' => __('Banner', 'meowdata'),
		'type' => 'heading');
		
		$options[] = array(
		'name' => __('Banner加入背景图', 'meowdataui'),
		'id' => 'banneron',
		'type' => "checkbox",
		'std' => true,
		'desc' => __('开启  （导航下方背景图）', 'meowdataui'),);

    $options[] = array(
		'name' => __('Banner背景图', 'meowdataui'),
		'id' => 'banner_url',
		'std' => $imagepath.'banner/banner(1).jpg',
		'type' => 'upload');
    
    $options[] = array(
		'name' => __('Banner随机背景图（开启后上方↑图片失效）', 'meowdataui'),
		'id' => 'banner_rand',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启  （开启后在主题/assets/images/banner/加入图片即可）', 'meowdataui'),);	 
	$options[] = array(
		'name' => __('Banner随机图片数', 'meowdata'),
		'id' => 'banner_rand_n',
		'std' => 12,
		'class' => 'mini',
		'desc' => __('banner(N).jpg文件夹中的图片这么命名N=1-你设置的数量 ', 'meowdata'),
		'type' => 'text');	 
	 
    /* 
	 * SEO
	 * ====================================================================================================
	 */		
	$options[] = array(
		'name' => __('SEO', 'meowdata'),
		'type' => 'heading');
		
    $options[] = array(
		'name' => __( '全站连接符', 'meowdataui' ),
		'desc' => __( '“-”或“_”一般设置就不要去修改它', 'meowdataui' ),
		'id' => 'connector',
		'std' => meowdata('connector') ? meowdata('connector') : '-',
		'class' => 'mini',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('百度文章发布主动推送', 'meowdata'),
		'id' => 'baidutuisong',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启', 'meowdata')); 
	 
	$options[] = array(
		'name' => __( '百度文章发布主动推送key', 'meowdata' ),
		'id' => 'baidutuisongkey',
		'std' =>'',
		'class' =>'mini',
		'type' => 'text',
		'desc' => __('如果推送成功则在文章新增自定义栏目Baidusubmit，值为1', 'meowdata'),
	);	 
	 
	$options[] = array(
		'name' => __('首页关键字(keywords)', 'meowdata'),
		'id' => 'keywords',
		'std' => 'WordPress,WordPress插件,WordPress主题,whmcs主题,whmcs插件,html模板,免费资源,优惠分享,数据喵',
		'desc' => __('用英文逗号隔开', 'meowdata'),
		'settings' => array(
			'rows' => 2
		),
		'type' => 'textarea');

	$options[] = array(
		'name' => __('首页描述(description)', 'meowdata'),
		'id' => 'description',
		'std' => '数据喵是一个基于内容分享,善于折腾WordPress,whmcs主题,html模板笔记博客',
		'desc' => __('网站描述', 'meowdata'),
		'settings' => array(
			'rows' => 3
		),
		'type' => 'textarea');

	$options[] = array(
		'name' => __('分类关键字', 'meowdata'),
		'id' => 'cat_keyworks_s',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启', 'meowdata').__(' 开启后分类的关键字将自动获取分类中的“图像描述”中的一部分，请用“::::::”6个英文冒号隔开关键字和描述，比如：<br>关键字1,关键字2<br>::::::<br>描述描述描述描述描述描述描述', 'meowdata'));

	$options[] = array(
		'name' => __('网站自动添加关键字和描述', 'meowdata'),
		'id' => 'site_keywords_description_s',
		'type' => "checkbox",
		'std' => true,
		'desc' => __('开启', 'meowdata').__('（开启后所有页面将自动使用主题配置的关键字和描述）', 'meowdata'));

	$options[] = array(
		'name' => __('文章关键字和描述自定义', 'meowdata'),
		'id' => 'post_keywords_description_s',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启', 'meowdata').__('（开启后你需要在编辑文章的时候书写关键字和描述，如果为空，将自动使用主题配置的关键字和描述；开启这个必须开启上面的“网站自动添加关键字和描述”开关）', 'meowdata'));
	

	/* 
	 * 文章
	 * ====================================================================================================
	 */		
	$options[] = array(
		'name' => __('文章', 'meowdata'),
		'type' => 'heading');
    $options[] = array(
		'name' => __('新窗口打开文章', 'meowdataui'),
		'id' => 'target_blank',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启', 'meowdataui'));		
	$options[] = array(
		'name' => __('文章代码高亮开关', 'meowdataui'),
		'id' => 'codept',
		'type' => "checkbox",
		'std' => true,
		'desc' => __('开启', 'meowdataui'));	
	$options[] = array(
		'name' => __('分页模式', 'meowdata'),
		'id' => 'paging_type',
		'std' => "multi",
		'type' => "radio",
		'options' => array(
			'next' => __(' 上一页 和 下一页', 'meowdata'),
			'multi' => __('页码 首页 1 2 3 尾页', 'meowdata')
		));
	
	$options[] = array(
		'name' => __('相关文章', 'meowdata'),
		'id' => 'post_related_s',
		'type' => "checkbox",
		'std' => true,
		'desc' => __('开启', 'meowdata'));

	$options[] = array(
		'name' => __('相关文章', 'meowdata').$rrr.__('模式', 'meowdata'),
		'id' => 'post_related_model',
		'type' => "radio",
		'std' => 'thumb',
		'options' => array(
			'thumb' => __(' 图文模式 ', 'meowdata'),
			'text' => __(' 文字链模式 ', 'meowdata')
		));

	$options[] = array(
		'name' => __('相关文章', 'meowdata').$rrr.__('显示数量', 'meowdata'),
		'id' => 'post_related_n',
		'std' => 3,
		'class' => 'mini',
		'desc' => __('建议使用3 6 9 12这样排版', 'meowdata'),
		'type' => 'text');
	$options[] = array(
		'name' => __('相关文章', 'meowdata').$rrr.__('标题', 'meowdata'),
		'id' => 'related_title',
		'std' => __('相关推荐', 'meowdata'),
		'class' => 'mini',
		'type' => 'text');	
	$options[] = array(
		'name' => __('文章作者信息', 'meowdata'),
		'desc' => __('位于文章内容标签下方', 'meowdata'),
		'id' => 'authorinfo',
		'std' => '文章作者信息...',
		'type' => 'textarea');
	/* 
	 * 评论
	 * ====================================================================================================
	 */	
	$options[] = array(
		'name' => __('评论', 'meowdata'),
		'type' => 'heading'); 
	$options[] = array(
			'name' => __('评论:管理员标志命名', 'meowdata'),
			'id' => 'comnanes',
			'std' => '博主',
			'class' => 'mini',
			'desc' => __('管理员发表回复评论的标志', 'meowdata'),
			'type' => 'text');
    $options[] = array(
			'name' => __('评论:注册会员标志命名', 'meowdata'),
			'id' => 'comnanesu',
			'std' => '会员',
			'class' => 'mini',
			'desc' => __('注册会员发表回复评论的标志', 'meowdata'),
			'type' => 'text');
	$options[] = array(
			'name' => __('评论:游客标志命名', 'meowdata'),
			'id' => 'comnaness',
			'std' => '游客',
			'class' => 'mini',
			'desc' => __('管理员发表回复评论的标志', 'meowdata'),
			'type' => 'text');		
	$options[] = array(
		'name' => __('评论者网址开启go跳转模式', 'meowdata'),
		'id' => 'comnanesgo',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启（其实没必要，已经加了nofollow不影响权重）', 'meowdata'));		
	$options[] = array(
		'name' => __('站内链接GO跳转到评论者网站', 'meowdataui'),
		'id' => 'comnanesgo_url',
		'std' => $webhome.'/go?url=',
		'desc' => __( '需要在【页面】新建一个GO链接的页面', 'meowdataui' ),
		'settings' => array('rows' => 1),
		'type' => 'textarea');
	/* 
	 * 会员中心
	 * ====================================================================================================
	 */		
	$options[] = array(
		'name' => __('会员', 'meowdata'),
		'type' => 'heading');
    $options[] = array(
		'name' => __('注册会员支持中文', 'meowdata'),
		'id' => 'sign_zhcn',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启', 'meowdata'));	
    $options[] = array(
		'name' => __( '注册成功后会员跳转页面', 'meowdata' ),
		'id' => 'regto',
		'std' => $webhome,
		'type' => 'text'
	);	
    $options[] = array(
		'name' => __( '登录成功后会员跳转页面', 'meowdata' ),
		'id' => 'loginto',
		'std' => $webhome,
		'type' => 'text'
	);	
	$options[] = array(
		'name' => __('导航登录注册链接', 'meowdata'),
		'id' => 'sign_f',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启', 'meowdata'));
	$options[] = array(
		'name' => __( '会员相关链接设置（如 https://mkm.st/user  那么就填写user）', 'meowdata' ),
		'desc' => __( '会员中心user页面链接不需要带/ 先在页面创建需要配合erphpdown插件', 'meowdata' ),
		'id' => 'users_page',
		'std' => 'user',
		'class' => 'mini',
		'type' => 'text'
	);	
	$options[] = array(
		'desc' => __( '注册页面reg页面链接不需要带/ 先在页面创建', 'meowdata' ),
		'id' => 'users_reg',
		'std' => 'reg',
		'class' => 'mini',
		'type' => 'text'
	);	
	$options[] = array(
		'desc' => __( '登录页面login页面链接不需要带/ 先在页面创建', 'meowdata' ),
		'id' => 'users_login',
		'std' => 'login',
		'class' => 'mini',
		'type' => 'text'
		
	);		
	/* 
	 * 社交设置
	 * ====================================================================================================
	 */		
	$options[] = array(
		'name' => __('社交', 'meowdata'),
		'type' => 'heading');				
	$options[] = array(
		'name' => __('QQ'),
		'desc' => __('直接输入QQ号，留空不展现', 'meowdata'),
		'id' => 'social_qq',
		'std' => '504888738',
		'type' => 'text');	
	$options[] = array(
		'name' => __('微信二维码'),
		'desc' => __('直接上传图片，留空不展现。', 'meowdata'),
		'id' => 'social_wechat',
		'std' => $imagepath.'mgwechat.jpg',
		'type' => 'upload');	
    $options[] = array(
		'name' => __('Email邮箱'),
		'desc' => __('直接输入邮箱，留空不展现。', 'meowdata'),
		'id' => 'social_mail',
		'type' => 'text');	
    /* 
	 * 友链设置
	 * ====================================================================================================
	 */	
    $options[] = array(
		'name' => __('友链', 'meowdata'),
		'type' => 'heading');	
    
    	$options[] = array(
		'name' => __('首页开启友链', 'meowdataui'),
		'id' => 'indexlinks',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启', 'meowdataui'),);
	$options[] = array(
		'name' => __('首页友情链接申请地址'),
		'desc' => __('填写自己站点的友情链接申请地址', 'meowdata'),
		'id' => 'yqlinks',
		'std' => 'https://mkm.st/links',
		'type' => 'text');	
	$options[] = array(
		'name' => __('首页友情链接命名'),
		'desc' => __('自己想怎么取就怎么取', 'meowdata'),
		'id' => 'yqlinksname',
		'std' => '友情关照',
		'type' => 'text');	
	/* 
	 * SMTP发件
	 * ====================================================================================================
	 */
	$options[] = array(
		'name' => __('SMTP', 'meowdata'),
		'type' => 'heading');	 
	$options[] = array(
		'name' => __('开启SMTP发件功能', 'meowdata'),
		'id' => 'smtpmail',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('勾选开启 （开启后下面也要设置好才生效）', 'meowdata'),);	
	$options[] = array(
		'name' => __( '发件人', 'meowdata' ),
		'id' => 'fromnames',
		'std' => '喵数据',
		'class' => 'mini',
		'type' => 'text'
	);		
	$options[] = array(
		'name' => __( 'SMTP服务器', 'meowdata' ),
		'id' => 'smtphost',
		'std' => 'smtp.mxhichina.com',
		'class' => 'mini',
		'type' => 'text'
	);
    $options[] = array(
		'name' => __( '加密SSL，如果留空下方端口填写25', 'meowdata' ),
		'id' => 'smtpsecure',
		'std' => 'ssl',
		'class' => 'mini',
		'type' => 'text'
	);		
    $options[] = array(
		'name' => __( 'SMTP端口(SSL一般为465，普通为25)', 'meowdata' ),
		'id' => 'smtpprot',
		'std' => '465',
		'class' => 'mini',
		'type' => 'text'
	);	
	$options[] = array(
		'name' => __( '邮箱账户', 'meowdata' ),
		'id' => 'smtpusername',
		'std' => 'sys@mogupapapa.com',
		'class' => 'mini',
		'type' => 'text'
	);	
	$options[] = array(
		'name' => __( '邮箱密码', 'meowdata' ),
		'id' => 'smtppassword',
		'std' => '你的邮箱密码',
		'class' => 'mini',
		'type' => 'text'
	);



//==============================================================================


	return $options;
}