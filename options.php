<?php
function optionsframework_option_name() {
	return 'options-framework-theme';
}
function optionsframework_options() {
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
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
		$options_pages[$page->ID] = $page->post_title;
	}

	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri() . '/assets/images/';
	$webhome = 'http://www.boxmoe.com';
	$VERSION = THEME_VERSION;

	$options = array();
//-----------------------------------------------------------
	$options[] = array(
		'name' => __('全局设置', 'ui_boxmoe_com'),
		'type' => 'heading');
		$options[] = array(
			'name' => __('说明', 'ui_boxmoe_com'),
			'desc' => __('网站的通用设置大部分在此页面，可以根据需求进行开关、切换、设置', 'ui_boxmoe_com'),
			'type' => 'info');
		$options[] = array(
			'name' => __('★ 博客布局', 'ui_boxmoe_com'),
			'id' => 'blog_layout',
			'std' => "one",
			'type' => "radio",
			'options' => array(
				'one' => __('单栏布局', 'ui_boxmoe_com'),
				'two' => __('双栏布局', 'ui_boxmoe_com')
			));			
		$options[] = array(
			'name' => __('★ 布局边框', 'ui_boxmoe_com'),
			'id' => 'blog_layout_border',
			'std' => "default",
			'type' => "radio",
			'options' => array(
				'default' => __('无边框效果', 'ui_boxmoe_com'),
				'border' => __('线条边框效果', 'ui_boxmoe_com'),
				'shadow' => __('阴影边框效果', 'ui_boxmoe_com')
			));
	
	$options[] = array(
		'name' => __('页面过度动画', 'ui_boxmoe_com'),
		'id' => 'boxmoe_preloader',
		'desc' => __('（开关）', 'ui_boxmoe_com'),
		'type' => "checkbox",
		'std' => true,
		);
	$options[] = array(
		'name' => __('★ 开启网页樱花飘落', 'ui_boxmoe_com'),
		'id' => 'sakura',
		'type' => "checkbox",
		'std' => false,
		);									
	$options[] = array(
		'name' => __('悼念模式', 'ui_boxmoe_com'),
		'id' => 'boxmoe_body_grey',
		'desc' => __('（全站变灰）', 'ui_boxmoe_com'),
		'type' => "checkbox",
		'std' => false,
		);
	$options[] = array(
		'name' => __('节日红灯笼', 'ui_boxmoe_com'),
		'id' => 'lantern',
		'type' => "checkbox",
		'std' => false,
		);
	$options[] = array(
		'name' => __( '灯笼文字(1)', 'ui_boxmoe_com' ),
		'id' => 'lanternfont1',
		'std' => '新',
		'class' => 'mini hidden',
		'type' => 'text');
	$options[] = array(
		'name' => __( '灯笼文字(2)', 'ui_boxmoe_com' ),
		'id' => 'lanternfont2',
		'std' => '春',
		'class' => 'mini hidden',
		'type' => 'text');
	$options[] = array(
		'name' => __( '灯笼文字(3)', 'ui_boxmoe_com' ),
		'id' => 'lanternfont3',
		'std' => '快',
		'class' => 'mini hidden',
		'type' => 'text');
	$options[] = array(
		'name' => __( '灯笼文字(4)', 'ui_boxmoe_com' ),
		'id' => 'lanternfont4',
		'std' => '乐',
		'class' => 'mini hidden',
		'type' => 'text');
$options[] = array(
		'name' => __( '★ LOGO设置', 'ui_boxmoe_com' ),
		'id' => 'logo_src',
		'desc' => __(' ', 'ui_boxmoe_com'),
		'std' => $imagepath.'logo.png',
		'type' => 'upload');
	$options[] = array(
		'name' => __( '★ Favicon地址', 'ui_boxmoe_com' ),
		'id' => 'favicon_src',
		'std' => $imagepath.'favicon.ico',
		'type' => 'upload');
	$options[] = array(
		'name' => __('★ 分类链接去除category标识', 'ui_boxmoe_com'),
		'desc' => __('（需主机伪静态，开关都需要 后台导航的 设置>固定链接 点保存一次）', 'ui_boxmoe_com'),
		'id' => 'no_categoty',
		'type' => "checkbox",
		'std' => false,
		);	
	$options[] = array(
		'name' => __('★ 网页右侧看板开关，附带点击回到顶部功能', 'ui_boxmoe_com'),
		'id' => 'lolijump',
		'type' => "checkbox",
		'std' => false,
		); 
	$options[] = array(
		'name' => __('★ 选择前端看板形象', 'ui_boxmoe_com'),
		'id' => 'lolijumpsister',
		'type' => "radio",
		'std' => 'lolisister1',
		'class' => 'hidden',
		'options' => array(
			'lolisister1' => __(' 看板萝莉-姐姐 ', 'ui_boxmoe_com'),
			'lolisister2' => __(' 看板萝莉-妹妹', 'ui_boxmoe_com'),
			'dance' => __(' 看板娘-舞娘娘', 'ui_boxmoe_com'),
			'meow' => __(' 看板娘-喵小娘', 'ui_boxmoe_com'),
			'lemon' => __(' 看板妹-柠檬妹', 'ui_boxmoe_com'),			
			'bear' => __(' 看板熊-熊宝宝', 'ui_boxmoe_com')
		));

//-----------------------------------------------------------
	$options[] = array(
		'name' => __('底部设置', 'options_framework_theme'),
		'type' => 'heading');
	$options[] = array(
		'name' => __('★ 底部显示页面执行时间', 'ui_boxmoe_com'),
		'desc' => __('（默认关闭，开启后底部显示页面执行时间）', 'ui_boxmoe_com'),
		'id' => 'boxmoedataquery',
		'type' => "checkbox",
		'std' => false,
		);
	$options[] = array(
		'name' => __('★ 建站统计', 'ui_boxmoe_com'),
		'id' => 'footer_time',
		'std' => "本博客已萌萌哒运行 {{2016-9-19}} (●'◡'●)ﾉ♥",
		'desc' => __('（留空则不显示,请按示例格式填写时间. {{2016-9-19}}）', 'ui_boxmoe_com'),
		'settings' => array('rows' => 3),
		'type' => 'text');
	$options[] = array(
		'name' => __('★ 网站底部导航链接', 'ui_boxmoe_com'),
		'id' => 'footer_seo',
		'std' => '<li class="nav-item"><a href="'.site_url('/sitemap.xml').'" target="_blank" class="nav-link">网站地图</a></li>'."\n",
		'desc' => __('（网站地图可自行使用sitemap插件自动生成）', 'ui_boxmoe_com'),
		'settings' => array('rows' => 3),
		'type' => 'textarea');
	$options[] = array(
		'name' => __('★ 网站底部自定义信息（如备案号支持HTML代码）', 'ui_boxmoe_com'),
		'id' => 'footer_info',
		'std' => '本站使用Wordpress创作'."\n",
		'settings' => array('rows' => 3),
		'type' => 'textarea');	
    $options[] = array(
		'name' => __('★ 统计代码', 'ui_boxmoe_com'),
		'desc' => __('（底部第三方流量数据统计代码）', 'ui_boxmoe_com'),
		'id' => 'trackcode',
		'std' => '统计代码',
		'settings' => array('rows' => 3),
		'type' => 'textarea');
	$options[] = array(
		'name' => __('★ 自定义代码', 'ui_boxmoe_com'),
		'desc' => __('（适用于自定义如css js代码置于底部加载）', 'ui_boxmoe_com'),
		'id' => 'diy_code_footer',
		'std' => '',
		'settings' => array('rows' => 3),
		'type' => 'textarea');
//==========================================================================================
	$options[] = array(
		'name' => __( 'Banner设置', 'ui_boxmoe_com' ),
		'desc' => __( '（导航下的图片设置）', 'ui_boxmoe_com' ),
		'type' => 'heading'
	);
	$options[] = array(
		'name' => __( '★ Banner欢迎语', 'ui_boxmoe_com' ),
		'desc' => __('（留空则不显示）', 'ui_boxmoe_com'),
		'id' => 'banner_font',
		'std' => 'Hello! 欢迎来到盒子萌！',
		'class' => '',
		'type' => 'text');
		$options[] = array(
			'name' => __('★ banner一言开关', 'ui_boxmoe_com'),
			'desc' => __('（banner）', 'ui_boxmoe_com'),
			'id' => 'hitokoto_on',
			'type' => "checkbox",
			'std' => false,
			);	
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
			'name' => __('★ banner一言句子分类', 'ui_boxmoe_com'),
			'id' => 'hitokoto_text',
			'std' => 'lolinet',
			'type' => 'select',
			'class' => 'hidden', //mini, tiny, small
			'options' => $hitokoto_array);				
	$options[] = array(
		'name' => __( '★ 自定义【PC端】Banner高度', 'ui_boxmoe_com' ),
		'desc' => __('（默认580高度,留空则默认）', 'ui_boxmoe_com'),
		'id' => 'banner_height',
		'std' => '',
		'class' => 'mini',
		'type' => 'text');
	$options[] = array(
		'name' => __( '★ 自定义【手机端】Banner高度', 'ui_boxmoe_com' ),
		'desc' => __('（默认480高度,留空则默认）', 'ui_boxmoe_com'),
		'id' => 'm_banner_height',
		'std' => '',
		'class' => 'mini',
		'type' => 'text');	
	$options[] = array(
		'name' => __('★ （固定）Banner背景图', 'ui_boxmoe_com'),
		'id' => 'banner_url',
		'std' => $imagepath.'banner/1.jpg',
		'type' => 'upload');    
    $options[] = array(
		'name' => __('★ （随机）Banner背景图', 'ui_boxmoe_com'),
		'desc' => __('（开启后上方↑图片失效，在主题/assets/images/banner/下加入图片并命名即可）', 'ui_boxmoe_com'),		
		'id' => 'banner_rand',
		'type' => "checkbox",
		'std' => false,
		);	 
	$options[] = array(
		'name' => __('★ Banner随机图片数量', 'ui_boxmoe_com'),
		'id' => 'banner_rand_n',
		'std' => 12,
		'desc' => __('（图片命名为1.jpg 2.jpg...x.jpg ，x=1-你上面设置的数量，格式JPG） ', 'ui_boxmoe_com'),
		'class' => 'hidden mini',
		'type' => 'text');
    $options[] = array(
		'name' => __('★ 使用外链APi-Banner图片', 'ui_boxmoe_com'),
		'desc' => __('（开启后上方图片功能全失效）', 'ui_boxmoe_com'),		
		'id' => 'banner_api_on',
		'type' => "checkbox",
		'std' => false,
		);
	$options[] = array(
		'name' => __('★ 图片外链APi链接', 'ui_boxmoe_com'),
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
		'name' => __( '★ 全站标题连接符', 'ui_boxmoe_com' ),
		'desc' => __('（“-”或“_”一般设置就不要去修改它，会影响SEO）', 'ui_boxmoe_com'),
		'id' => 'connector',
		'std' => get_boxmoe('connector') ? get_boxmoe('connector') : '-',
		'class' => 'mini',
		'type' => 'text');

	$options[] = array(
		'name' => __('★ 百度文章发布主动推送', 'ui_boxmoe_com'),
		'id' => 'baidutuisong',
		'type' => "checkbox",
		'std' => false,
		); 
	 
	$options[] = array(
		'name' => __( '百度文章发布主动推送key', 'ui_boxmoe_com' ),
		'id' => 'baidutuisongkey',
		'std' =>'',
		'type' => 'text',
		'class' => 'hidden',
		'desc' => __('如果推送成功则在文章新增自定义栏目Baidusubmit，值为1', 'ui_boxmoe_com'),
	);	 
	 
	$options[] = array(
		'name' => __('★ 首页关键字(keywords)', 'ui_boxmoe_com'),
		'id' => 'keywords',
		'std' => 'WordPress',
		'desc' => __('用英文逗号隔开', 'ui_boxmoe_com'),
		'settings' => array(
			'rows' => 3
		),
		'type' => 'textarea');

	$options[] = array(
		'name' => __('★ 网站描述(description)', 'ui_boxmoe_com'),
		'id' => 'description',
		'std' => '又是一个博客',
		'settings' => array(
		'rows' => 3),
		'type' => 'textarea');

	$options[] = array(
		'name' => __('★ 分类关键字', 'ui_boxmoe_com'),
		'desc' => __('（开启后分类的关键字将自动获取分类中的“图像描述”中的一部分，请用“::::::”6个英文冒号隔开关键字和描述，比如：关键字1,关键字2::::::描述描述）', 'ui_boxmoe_com'),
		'id' => 'cat_keyworks_s',
		'type' => "checkbox",
		'std' => false,
		
		);

	$options[] = array(
		'name' => __('★ 网站自动添加关键字和描述', 'ui_boxmoe_com'),
		'desc' => __('（开启后所有页面将自动使用主题配置的关键字和描述）', 'ui_boxmoe_com'),
		'id' => 'site_keywords_description_s',
		'type' => "checkbox",
		'std' => true,
		);

	$options[] = array(
		'name' => __('★ 自定义文章关键字和描述', 'ui_boxmoe_com'),
		'desc' => __('（开启后你需要在编辑文章的时候书写关键字和描述，如果为空，将自动使用主题配置的关键字和描述；开启这个必须开启上面的“网站自动添加关键字和描述”开关）', 'ui_boxmoe_com'),
		'id' => 'post_keywords_description_s',
		'type' => "checkbox",
		'std' => false,
		);	
//==========================================================================================
$options[] = array(
	'name' => __( '文章设置', 'ui_boxmoe_com' ),
	'desc' => __( '（有关文章的地方设置项）', 'ui_boxmoe_com' ),
	'type' => 'heading'
);	
$options[] = array(
	'name' => __('★ 文章相关模块渐进动态效果', 'ui_boxmoe_com'),
	'id' => 'wow_on',
	'type' => "checkbox",
	'std' => false,
	);		
$options[] = array(
	'name' => __('★ 文章随机缩略图数量', 'ui_boxmoe_com'),
	'id' => 'thumbnail_rand_n',
	'std' => 10,
	'class' => 'mini',
	'desc' => __('（图片放在在主题boxmoe/assets/images/rand/N.jpg，N=1-你设置的数量）', 'ui_boxmoe_com'),
	'type' => 'text');
$options[] = array(
	'name' => __('★ 开启API随机缩略图', 'ui_boxmoe_com'),
	'id' => 'thumbnail_api',
	'type' => "checkbox",
	'std' => false,
	);		
$options[] = array(
	'name' => __('★ 自定义api随机缩图URL', 'ui_boxmoe_com'),
	'id' => 'thumbnail_api_url',
	'std' => '',
	'class' => 'hidden',
	'type' => 'text');			
$options[] = array(
	'name' => __('★ 新窗口打开文章', 'ui_boxmoe_com'),
	'desc' => __('（开启后文章链接都是新窗口打开）', 'ui_boxmoe_com'),
	'id' => 'target_blank',
	'type' => "checkbox",
	'std' => false,
	);	
$options[] = array(
	'name' => __('★ 文章列表分页模式', 'ui_boxmoe_com'),
	'id' => 'paging_type',
	'std' => "multi",
	'type' => "radio",
	'options' => array(
		'next' => __(' 上一页 和 下一页', 'ui_boxmoe_com'),
		'multi' => __('页码  1 2 3 ', 'ui_boxmoe_com')
	));
$options[] = array(
	'name' => __('★ 正文底部相关文章', 'ui_boxmoe_com'),
	'id' => 'post_related_s',
	'type' => "checkbox",
	'std' => false,
	);
$options[] = array(
	'name' => __('★ 相关文章显示方式', 'ui_boxmoe_com'),
	'id' => 'post_related_model',
	'type' => "radio",
	'std' => 'thumb',
	'options' => array(
		'thumb' => __(' 图文模式 ', 'ui_boxmoe_com')
//		'text' => __(' 文字链模式 ', 'ui_boxmoe_com')
	));
$options[] = array(
	'name' => __('★ 相关文章-显示文章数量', 'ui_boxmoe_com'),
	'id' => 'post_related_n',
	'std' => 3,
	'class' => 'mini',
	'desc' => __('建议使用3 6 9 12这样排版', 'ui_boxmoe_com'),
	'type' => 'text');		
$options[] = array(
	'name' => __('★ 文章作者信息框', 'ui_boxmoe_com'),
	'desc' => __('（位于文章内容下方）', 'ui_boxmoe_com'),		
	'id' => 'open_author_info',
	'type' => "checkbox",
	'std' => false,
	);	
$options[] = array(
	'name' => __('★ 文章头部广告位', 'ui_boxmoe_com'),
	'id' => 'ads_top',
	'std' => '<a href="https://moekoe.cn/" target="_blank"><img src="https://cloudflare.cdnjson.com/images/2024/11/01/3333.png" style="border-radius: 10px;"></a>',
	'type' => 'textarea'
	);	
$options[] = array(
	'name' => __('★ 文章底部广告位', 'ui_boxmoe_com'),
	'id' => 'ads_bottom',
	'std' => '<a href="https://moekoe.cn/" target="_blank"><img src="https://cloudflare.cdnjson.com/images/2024/11/01/3333.png" style="border-radius: 10px;"></a>',
	'type' => 'textarea'
	);
$options[] = array(
	'name' => __('★ 文章作者信息', 'ui_boxmoe_com'),
	'desc' => __('（关于联系图标在社交设置里填写就可以）', 'ui_boxmoe_com'),	
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
	'name' => __('★ 关闭全站评论', 'ui_boxmoe_com'),
	'id' => 'comments_off',
	'type' => "checkbox",
	'std' => false,
	);
$options[] = array(
		'name' => __('★ 自定义发送评论按钮文字', 'ui_boxmoe_com'),
		'id' => 'diy_comment_btn',
		'std' => '发送评论',
		'class' => 'mini',
		'desc' => __('留空则默认文字 发送评论', 'ui_boxmoe_com'),
		'type' => 'text');	
$options[] = array(
		'name' => __('★ 自定义评论框内文字', 'ui_boxmoe_com'),
		'id' => 'diy_comment_text',
		'std' => '你可以在这里输入评论内容...',
		'desc' => __('留空则默认文字', 'ui_boxmoe_com'),
		'type' => 'text');		
$options[] = array(
	'name' => __('★ 屏蔽非会员纯英文评论和纯日文评论', 'ui_boxmoe_com'),	
	'id' => 'false_enjp_comment',
	'type' => "checkbox",
	'std' => false,
	);	
$options[] = array(
		'name' => __('★ 评论:管理员标志命名', 'ui_boxmoe_com'),
		'id' => 'comnanes',
		'std' => '博主',
		'class' => 'mini',
		'desc' => __('管理员发表回复评论的标志', 'ui_boxmoe_com'),
		'type' => 'text');
$options[] = array(
		'name' => __('★ 评论:注册会员标志命名', 'ui_boxmoe_com'),
		'id' => 'comnanesu',
		'std' => '会员',
		'class' => 'mini',
		'desc' => __('注册会员发表回复评论的标志', 'ui_boxmoe_com'),
		'type' => 'text');
$options[] = array(
		'name' => __('★ 评论:游客标志命名', 'ui_boxmoe_com'),
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
	'name' => __('★ 开启导航会员注册链接', 'ui_boxmoe_com'),
	'id' => 'sign_f',
	'type' => "checkbox",
	'std' => false,
	
);
//$options[] = array(
//	'name' => __( '添加注册验证答案', 'ui_boxmoe_com' ),
//	'desc' => __( '（留空默认关闭验证）', 'ui_boxmoe_com' ),
//	'id' => 'reg_question',
//	'type' => 'text',
//	'class' => 'hidden mini',
//	'std' => ''
//);
$options[] = array(
	'name' => __( '★ 会员中心信息面板Banner图', 'ui_boxmoe_com' ),
	'id' => 'user_banner_src',
	'desc' => __(' ', 'ui_boxmoe_com'),
	'std' => $imagepath.'banner/1.jpg',
	'class' => 'hidden',
	'type' => 'upload');
$options[] = array(
	'name' => __('★ 注册会员支持中文', 'ui_boxmoe_com'),
	'id' => 'sign_zhcn',
	'type' => "checkbox",
	'std' => false,
	'class' => 'hidden',
	
);
$options[] = array(
	'name' => __( '★ 会员登录页面', 'ui_boxmoe_com' ),
	'desc' => __( '（如果使用会员中心需要配合erphpdown插件）', 'ui_boxmoe_com' ),
	'desc' => __( '选择前端会员登录页面，新建一个页面选择会员登录模板', 'ui_boxmoe_com' ),
	'id' => 'users_login',
	'type' => 'select',
	'class' => 'hidden',
	'options' => $options_pages
);
$options[] = array(
	'name' => __( '★ 会员注册页面', 'ui_boxmoe_com' ),
	'desc' => __( '选择前端会员注册页面，新建一个页面选择会员注册模板', 'ui_boxmoe_com' ),
	'id' => 'users_reg',
	'type' => 'select',
	'class' => 'hidden',
	'options' => $options_pages
);
$options[] = array(
	'name' => __( '★ 重置密码页面', 'ui_boxmoe_com' ),
	'desc' => __( '选择前端重置密码页面，新建一个页面选择重置密码模板', 'ui_boxmoe_com' ),
	'id' => 'users_reset',
	'type' => 'select',
	'class' => 'hidden',
	'options' => $options_pages
);
$options[] = array(
	'name' => __( '★ 会员中心页面', 'ui_boxmoe_com' ),
	'desc' => __( '选择前端会员中心页面，新建一个页面选择会员中心模板【需要配合erphpdown插件】', 'ui_boxmoe_com' ),
	'id' => 'users_page',
	'type' => 'select',
	'class' => 'hidden',
	'options' => $options_pages
);	
$options[] = array(
	'name' => __( '★ 注册成功后会员跳转页面', 'ui_boxmoe_com' ),
	'id' => 'regto',
	'std' => $webhome,
	'class' => 'hidden',
	'type' => 'text'
);	
$options[] = array(
	'name' => __( '★ 登录成功后会员跳转页面', 'ui_boxmoe_com' ),
	'id' => 'loginto',
	'std' => $webhome,
	'class' => 'hidden',
	'type' => 'text'
);
$options[] = array(
	'name' => __('★ 前端充值卡购买链接', 'ui_boxmoe_com'), 
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
//	'name' => __('★ 文章打赏二维码'),
//	'desc' => __('（先记着下版出，直接上传图片，留空不展现）', 'ui_boxmoe_com'),
//	'id' => 'boxmoe_dayegivemesomemoney',
//	'std' => $imagepath.'dayegivemesomemoney.jpg',
//	'type' => 'upload');
$options[] = array(
	'name' => __('★ QQ联系'),
	'desc' => __('直接输入QQ号，留空不展现', 'ui_boxmoe_com'),
	'id' => 'boxmoe_qq',
	'std' => '10000',
	'class' => 'mini',
	'type' => 'text');	
$options[] = array(
	'name' => __('★ 微信二维码'),
	'desc' => __('直接上传图片，留空不展现。', 'ui_boxmoe_com'),
	'id' => 'boxmoe_wechat',
	'std' => $imagepath.'wechat.jpg',
	'type' => 'upload');		
$options[] = array(
	'name' => __('★ Email邮箱'),
	'desc' => __('直接输入邮箱，留空不展现。', 'ui_boxmoe_com'),
	'id' => 'boxmoe_mail',
	'class' => 'mini',
	'type' => 'text');	
$options[] = array(
	'name' => __('★ Github'),
	'desc' => __('直接输入链接，留空不展现', 'ui_boxmoe_com'),
	'id' => 'boxmoe_github',
	'std' => 'https://www.boxmoe.com',
	'type' => 'text');
$options[] = array(
	'name' => __('★ 微博'),
	'desc' => __('直接输入链接，留空不展现', 'ui_boxmoe_com'),
	'id' => 'boxmoe_weibo',
	'std' => 'https://www.boxmoe.com',
	'type' => 'text');
//==========================================================================================
$options[] = array(
	'name' => __( '机器人设置', 'ui_boxmoe_com' ),
	'type' => 'heading'
);	
$options[] = array(
	'name' => __('★ 开启机器人功能', 'ui_boxmoe_com'),
	'id' => 'bot_api',
	'type' => "checkbox",
	'std' => false,
	);
$options[] = array(
	'name' => __('★ 1.选择机器人通道', 'ui_boxmoe_com'),
	'desc' => __('QQ机器人仅支持go-cqhttp需要自建，建议使用钉钉机器人无需自建', 'ui_boxmoe_com'),
	'id' => 'bot_api_server',
	'std' => "boe_api_qq",
	'type' => "radio",
	'options' => array(
		'boe_api_qq' => __('QQ机器人', 'ui_boxmoe_com'),
		'boe_api_dd' => __('钉钉机器人', 'ui_boxmoe_com'),
	));
$options[] = array(
	'name' => __('★ 2.配置机器人API地址'),
	'desc' => __('填写自己的go-cqhttp QQ机器人api地址 或者 钉钉机器人Webhook(https://oapi.dingtalk.com/robot/send?access_token=xxxx)', 'ui_boxmoe_com'),
	'id' => 'bot_api_url',
	'std' => 'http://127.0.0.1:5700',
	'type' => 'text');	
$options[] = array(
	'name' => __('★ 2-1接收QQ机器人消息的QQ号码'),
	'id' => 'bot_api_qqnum',
	'class' => 'mini',
	'std' => '504888738',
	'type' => 'text');
$options[] = array(
	'name' => __('★ 2-2钉钉机器人加签秘钥'),
	'id' => 'bot_api_ddkey',
	'class' => 'mini',
	'std' => '',
	'type' => 'text');	
$options[] = array(
	'name' => __('★ 新评论消息推送', 'ui_boxmoe_com'),
	'id' => 'bot_api_comment',
	'type' => "checkbox",
	'std' => false,
	'desc' => __('开启新评论消息推送', 'ui_boxmoe_com'),);
$options[] = array(
	'name' => __('★ 新会员注册通知', 'ui_boxmoe_com'),
	'id' => 'bot_api_reguser',
	'type' => "checkbox",
	'std' => false,
	'desc' => __('开启新会员注册通知', 'ui_boxmoe_com'),);
	
//==========================================================================================
$options[] = array(
	'name' => __( '邮件设置', 'ui_boxmoe_com' ),
	'type' => 'heading'
);
$options[] = array(
	'name' => __('★ 开启SMTP发件功能', 'ui_boxmoe_com'),
	//'desc' => __('（开启后下面也要设置好才生效）', 'ui_boxmoe_com'),
	'id' => 'smtpmail',
	'type' => "checkbox",
	'std' => false,
	);	
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
	'name' => __('系统优化', 'ui_boxmoe_com'),
	'type' => 'heading');
	$options[] = array(
		'name' => __('★ 非管理员禁止进入后台', 'ui_boxmoe_com'),
		'id' => 'boxmoe_admin_off',
		'type' => "checkbox",
		'std' => false,
		);		
$options[] = array(
	'name' => __('★ 关闭古腾堡编辑器', 'ui_boxmoe_com'),
	'id' => 'gutenberg_off',
	'type' => "checkbox",
	'std' => true,
	);		 	
$options[] = array(
	'name' => __('★ Wordpress头部优化', 'ui_boxmoe_com'),
	'id' => 'wpheader_on',
	'type' => "checkbox",
	'std' => false,
	'desc' => __('移除Head头部没用的代码', 'ui_boxmoe_com'),);
$options[] = array(
	'name' => __('★ 移除头部feed防采集', 'ui_boxmoe_com'),
	'id' => 'feed_off',
	'type' => "checkbox",
	'std' => false,
	'desc' => __('移除头部的Feed输出和关闭的Feed防采集', 'ui_boxmoe_com'),);
$options[] = array(
	'name' => __('★ 移除Emoji', 'ui_boxmoe_com'),
	'id' => 'emoji_off',
	'type' => "checkbox",
	'std' => false,
	);	
$options[] = array(
	'name' => __('★ 移除dns-refresh', 'ui_boxmoe_com'),
	'id' => 'remove_dns_refresh',
	'type' => "checkbox",
	'std' => false,
	'desc' => __('WP系统默认的DNS预加载，看自己需求', 'ui_boxmoe_com'),);	
$options[] = array( 
	'name' => __('★ 禁用文章自动保存', 'ui_boxmoe_com'),
	'id' => 'autosaveop',
	'type' => "checkbox",
	'std' => false,
	);
$options[] = array(
	'name' => __('★ 禁用文章修订版本', 'ui_boxmoe_com'),
	'id' => 'revisions_to_keepop',
	'type' => "checkbox",
	'std' => false,
	);			
$options[] = array(
	'name' => __('★ 移除RSS订阅', 'ui_boxmoe_com'),
	'id' => 'rss_off',
	'type' => "checkbox",
	'std' => false,
	);		
$options[] = array(
	'name' => __('★ 禁止Pingback屏蔽一些垃圾评论', 'ui_boxmoe_com'),
	'id' => 'Pingback_off',
	'type' => "checkbox",
	'std' => false,
	);		
$options[] = array(
	'name' => __('★ 关闭embeds加速加载', 'ui_boxmoe_com'),
	'id' => 'embeds_off',
	'type' => "checkbox",
	'std' => false,
	);	
//==========================================================================================
$options[] = array(
	'name' => __('前端加速', 'ui_boxmoe_com'),
	'desc' => __( '（提高JS CSS 头像加载速度）', 'ui_boxmoe_com' ),
	'type' => 'heading');
$gravatar_array = array(
	'cravatar' => __('cravatar服务器', 'ui_boxmoe_com'),
	'lolinet' => __('萝莉服务器', 'ui_boxmoe_com'),
	'qiniu' => __('七牛服务器', 'ui_boxmoe_com'),
	'geekzu' => __('极客服务器', 'ui_boxmoe_com'),
	//'v2excom' => __('v2ex服务器', 'ui_boxmoe_com'),
	'cn' => __('官方CN服务器', 'ui_boxmoe_com'),
	'ssl' => __('官方SSL服务器', 'ui_boxmoe_com'),		
);
$options[] = array(
	'name' => __('★ Gravatar头像加速服务器', 'ui_boxmoe_com'),
	'desc' => __('（通过镜像服务器可对gravatar头像进行加速）', 'ui_boxmoe_com'),
	'id' => 'gravatar_url',
	'std' => 'lolinet',
	'type' => 'select',
	'class' => 'mini', //mini, tiny, small
	'options' => $gravatar_array);
$qqravatar_array = array(
	'Q1' => __('QQ官方服务器1', 'ui_boxmoe_com'),
	'Q2' => __('QQ官方服务器2', 'ui_boxmoe_com'),
	'Q3' => __('QQ官方服务器3', 'ui_boxmoe_com'),
	'Q4' => __('QQ官方服务器4', 'ui_boxmoe_com'),	
);
$options[] = array(
	'name' => __('★ QQ头像服务器节点', 'ui_boxmoe_com'),
	'desc' => __('（如果用户是QQ邮箱则调用QQ头像）', 'ui_boxmoe_com'),
	'id' => 'qqavatar_url',
	'std' => 'Q2',
	'type' => 'select',
	'class' => 'mini', //mini, tiny, small
	'options' => $qqravatar_array);				
$options[] = array(
	'name' => __('★ 选择前端外链CSS JS 图片加载节点', 'ui_boxmoe_com'),
	'id' => 'ui_cdn',
	'std' => "local",
	'type' => "radio",
	//'desc' => __('注：如果你主机网络够快,带宽也不小默认是可以的', 'ui_boxmoe_com'),
	'options' => array(
		'local' => __('本地（默认）', 'ui_boxmoe_com'),
		'diy_cdn' => __('自建节点', 'ui_boxmoe_com')
	));
$options[] = array(
	'name' => __('★ 自建节点链接', 'ui_boxmoe_com'), 
	'id' => 'diy_cdn_src',
	'std' => '',
	'settings' => array('rows' => 1),
	'desc' => __('把主题下的assets文件夹传到你自建的加速节点上填写上(如https://domain.com/lolimeow/assets)，链接结尾不要带“/”  ', 'ui_boxmoe_com'),
	'type' => 'textarea');	






	
//==========================================================================================
$options[] = array(
	'name' => __('全站音乐', 'ui_boxmoe_com'),
	'type' => 'heading');
	$options[] = array(
		'name' => __('说明', 'ui_boxmoe_com'),
		'desc' => __('音乐功能接口已失效，目前暂时没有替代品请关闭', 'ui_boxmoe_com'),
		'type' => 'info');	
$options[] = array(
	'name' => __('★ 全站底部音乐播放器开关', 'ui_boxmoe_com'),
	'id' => 'music_on',
	'type' => "checkbox",
	'std' => false,
	);
$options[] = array(
	'name' => __('★选择运营商', 'ui_boxmoe_com'),
	'id' => 'music_server',
	'std' => "netease",
	'type' => "radio",
	'options' => array(
		'netease' => __('1.网易云', 'ui_boxmoe_com'),
		'tencent' => __('2.QQ音乐', 'ui_boxmoe_com'),			
		'kugou' => __('3.酷狗', 'ui_boxmoe_com'),
		'xiami' => __('4.虾米', 'ui_boxmoe_com'),
		'baidu' => __('5.百度', 'ui_boxmoe_com')
	));	
$options[] = array(
	'name' => __( '★ 歌单ID', 'ui_boxmoe_com' ),
	'desc' => __('（歌单尽量不要那种超过100首的,API服务器可能会500）', 'ui_boxmoe_com'),		
	'id' => 'music_id',
	'std' => '2765798464',
	'type' => 'text'
);
$options[] = array(
	'name' => __('★歌单列表播放顺序', 'ui_boxmoe_com'),
	'id' => 'music_order',
	'std' => "list",
	'type' => "radio",
	'options' => array(
		'list' => __('1.顺序播放', 'ui_boxmoe_com'),
		'random' => __('2.随机播放', 'ui_boxmoe_com'),			
	));

	$options[] = array(
		'name' => __('关于主题', 'ui_boxmoe_com'),
		'type' => 'heading');

	$options[] = array(
	    'name' => __('★ 开源协议', 'ui_boxmoe_com'), 
		'id' => 'banquan',
		'desc' => __('
		 <p>1.主题依托于开源协议 GPL V3.0，如果不接受本协议，请立即删除</p>
		 <p>2.请遵循开源协议，保留主题底部版权信息，如果不接受本协议，请立即删除；</p>		
		', 'ui_boxmoe_com'),
		'type' => 'info');
	$options[] = array(
	    'name' => __('★ 使用协议/注意事项', 'ui_boxmoe_com'), 
		'id' => 'shiyong',
		'desc' => __('
		 <p>1.主题仅供博客爱好者合法建站交流！禁止使用于违法用途！如如主题使用者不能遵守此规定，请立即删除；</p>
		 <p>2.严禁利用本主题严重侵犯他人隐私权，如主题使用者不能遵守此规定，请立即删除；</p>
		 <p>3.使用主题请遵守网站服务器当地相关法律和站长当地相关法律，如不能遵守请立即删除；</p>
		 <p>4.主题不支持任何作为非法违规用途站点！如不能遵守请立即删除；</p>
		 <p>5.主题开源无任何加密文件，对于因用户使用本主题而造成自身或他人隐私泄露，等任何不良后果，均由用户自行承担，主题作者不负任何责任；</p>
		 <p>6.本主题共享下载，如果用户自行下载使用，即表明用户自愿并接受本协议所有条款。 如果用户不接受本协议，请立即删除；</p>
		', 'ui_boxmoe_com'),
		'type' => 'info');		
	$options[] = array(
	    'name' => __('★ 主题信息', 'ui_boxmoe_com'), 
		'id' => 'banquan',
		'desc' => __('
		 <p>当前版本：'.$VERSION.'</p>
		 <p>最新版本：<span id="vbox"></span></p>
		 <p>查看主题：<a href="https://www.boxmoe.com/468.html" target="_blank" rel="external nofollow" class="url">更新日志</a></p>		
		 <p>主题QQ群：<a href="http://qm.qq.com/cgi-bin/qm/qr?_wv=1027&k=YLb_jw14jGMh1q8cMwga9UZcWp6JDPsS&authKey=x8YpdYVOU%2BIyiJ8uSJ2gT9UJ%2B%2BByQjnaHTTaTjMAu9YIERV20NnM%2F7tfBB%2B39peo&noverify=0&group_code=24847519" target="_blank" rel="external nofollow" class="url">24847519</a></p>
		', 'ui_boxmoe_com'),
		'type' => 'info');			

//拓展区结束=====================================================================================




//-----------------------------------------------------------
	return $options;
}