<?php
//=======安全設定，阻止直接存取主題檔案=======
if (!defined('ABSPATH')) {
    echo '想幹嘛呢？';
    exit;
}
//=========================================

function optionsframework_option_name() {
    return 'options-framework-theme';
}

function optionsframework_options() {

    // 取得所有分類到陣列
    $options_categories = array();
    $options_categories_obj = get_categories();
    foreach ($options_categories_obj as $category) {
        $options_categories[$category->cat_ID] = $category->cat_name;
    }

    // 取得所有標籤到陣列
    $options_tags = array();
    $options_tags_obj = get_tags();
    foreach ($options_tags_obj as $tag) {
        $options_tags[$tag->term_id] = $tag->name;
    }

    // 取得所有頁面到陣列
    $options_pages = array();
    $options_pages_obj = get_pages('sort_column=post_parent,menu_order');
    $options_pages[''] = 'Select a page:';
    foreach ($options_pages_obj as $page) {
        $options_pages[$page->ID] = $page->post_title;
    }

    // 如果要使用圖片單選按鈕，設定圖片資料夾路徑
    $imagepath = get_template_directory_uri() . '/assets/images/';
    $webhome   = 'http://www.boxmoe.com';
    $VERSION   = THEME_VERSION;

    $options = array();

    //-----------------------------------------------------------
    $options[] = array(
        'name' => __('佈局特效', 'ui_boxmoe_com'),
        'icon' => 'dashicons-grid-view',
        'type' => 'heading'
    );
    $options[] = array(
        'name' => __('部落格佈局', 'ui_boxmoe_com'),
        'id'   => 'blog_layout',
        'std'  => 'one',
        'type' => 'radio',
        'options' => array(
            'one' => __('單欄佈局', 'ui_boxmoe_com'),
            'two' => __('雙欄佈局', 'ui_boxmoe_com')
        )
    );
    $options[] = array(
        'name' => __('佈局邊框', 'ui_boxmoe_com'),
        'id'   => 'blog_layout_border',
        'std'  => 'default',
        'type' => 'radio',
        'options' => array(
            'default' => __('無邊框效果', 'ui_boxmoe_com'),
            'border'  => __('線條邊框效果', 'ui_boxmoe_com'),
            'shadow'  => __('陰影邊框效果', 'ui_boxmoe_com')
        )
    );
    $options[] = array(
        'name' => __('頁面過場動畫', 'ui_boxmoe_com'),
        'id'   => 'boxmoe_preloader',
        'desc' => __('（開關）', 'ui_boxmoe_com'),
        'type' => 'checkbox',
        'std'  => true,
    );
    $options[] = array(
        'name' => __('啟用網頁櫻花飄落', 'ui_boxmoe_com'),
        'id'   => 'sakura',
        'type' => 'checkbox',
        'std'  => false,
    );
    $options[] = array(
        'name' => __('悼念模式', 'ui_boxmoe_com'),
        'id'   => 'boxmoe_body_grey',
        'desc' => __('（全站變灰）', 'ui_boxmoe_com'),
        'type' => 'checkbox',
        'std'  => false,
    );
    $options[] = array(
        'name' => __('節日紅燈籠', 'ui_boxmoe_com'),
        'id'   => 'lantern',
        'type' => 'checkbox',
        'std'  => false,
    );
    $options[] = array(
        'name'  => __('燈籠文字(1)', 'ui_boxmoe_com'),
        'id'    => 'lanternfont1',
        'std'   => '新',
        'class' => 'mini hidden',
        'type'  => 'text'
    );
    $options[] = array(
        'name'  => __('燈籠文字(2)', 'ui_boxmoe_com'),
        'id'    => 'lanternfont2',
        'std'   => '春',
        'class' => 'mini hidden',
        'type'  => 'text'
    );
    $options[] = array(
        'name'  => __('燈籠文字(3)', 'ui_boxmoe_com'),
        'id'    => 'lanternfont3',
        'std'   => '快',
        'class' => 'mini hidden',
        'type'  => 'text'
    );
    $options[] = array(
        'name'  => __('燈籠文字(4)', 'ui_boxmoe_com'),
        'id'    => 'lanternfont4',
        'std'   => '樂',
        'class' => 'mini hidden',
        'type'  => 'text'
    );

    //-----------------------------------------------------------
    $options[] = array(
        'name' => __('全站設定', 'ui_boxmoe_com'),
        'type' => 'heading'
    );
    $options[] = array(
        'name' => __('LOGO設定', 'ui_boxmoe_com'),
        'id'   => 'logo_src',
        'desc' => __(' ', 'ui_boxmoe_com'),
        'std'  => $imagepath . 'logo.png',
        'type' => 'upload'
    );
    $options[] = array(
        'name' => __('Favicon位址', 'ui_boxmoe_com'),
        'id'   => 'favicon_src',
        'std'  => $imagepath . 'favicon.ico',
        'type' => 'upload'
    );
    $options[] = array(
        'name' => __('分類連結移除 category 標識', 'ui_boxmoe_com'),
        'desc' => __('（需主機偽靜態，開關都需要後台導覽的「設定 > 固定連結」點一下儲存）', 'ui_boxmoe_com'),
        'id'   => 'no_categoty',
        'type' => 'checkbox',
        'std'  => false,
    );
    $options[] = array(
        'name' => __('網頁右側看板開關，附帶點擊回到頂部功能', 'ui_boxmoe_com'),
        'id'   => 'lolijump',
        'type' => 'checkbox',
        'std'  => false,
    );
    $options[] = array(
        'name' => __('選擇前端看板角色', 'ui_boxmoe_com'),
        'id'   => 'lolijumpsister',
        'type' => 'radio',
        'std'  => 'lolisister1',
        'class' => 'hidden',
        'options' => array(
            'lolisister1' => __('看板蘿莉 - 姐姐', 'ui_boxmoe_com'),
            'lolisister2' => __('看板蘿莉 - 妹妹', 'ui_boxmoe_com'),
            'dance'       => __('看板娘 - 舞娘娘', 'ui_boxmoe_com'),
            'meow'        => __('看板娘 - 喵小娘', 'ui_boxmoe_com'),
            'lemon'       => __('看板妹 - 檸檬妹', 'ui_boxmoe_com'),
            'bear'        => __('看板熊 - 熊寶寶', 'ui_boxmoe_com')
        )
    );

    //-----------------------------------------------------------
    $options[] = array(
        'name' => __('底部設定', 'options_framework_theme'),
        'icon' => 'dashicons-image-rotate-right',
        'type' => 'heading'
    );
    $options[] = array(
        'name' => __('底部顯示頁面執行時間', 'ui_boxmoe_com'),
        'desc' => __('（預設關閉，啟用後底部將顯示頁面執行時間）', 'ui_boxmoe_com'),
        'id'   => 'boxmoedataquery',
        'type' => 'checkbox',
        'std'  => false,
    );
    $options[] = array(
        'name' => __('網站底部導覽連結', 'ui_boxmoe_com'),
        'id'   => 'footer_seo',
        'std'  => '<li class="nav-item"><a href="' . site_url('/sitemap.xml') . '" target="_blank" class="nav-link">網站地圖</a></li>' . "\n",
        'desc' => __('（網站地圖可自行使用 sitemap 外掛自動生成）', 'ui_boxmoe_com'),
        'settings' => array('rows' => 3),
        'type' => 'textarea'
    );
    $options[] = array(
        'name' => __('網站底部自訂資訊（如備案號，支援HTML程式碼）', 'ui_boxmoe_com'),
        'id'   => 'footer_info',
        'std'  => '本站使用Wordpress創作' . "\n",
        'settings' => array('rows' => 3),
        'type' => 'textarea'
    );
    $options[] = array(
        'name' => __('統計程式碼', 'ui_boxmoe_com'),
        'desc' => __('（底部放置第三方流量統計程式碼）', 'ui_boxmoe_com'),
        'id'   => 'trackcode',
        'std'  => '統計程式碼',
        'settings' => array('rows' => 3),
        'type' => 'textarea'
    );
    $options[] = array(
        'name' => __('自訂程式碼', 'ui_boxmoe_com'),
        'desc' => __('（可用於自訂CSS、JS程式碼並在底部載入）', 'ui_boxmoe_com'),
        'id'   => 'diy_code_footer',
        'std'  => '',
        'settings' => array('rows' => 3),
        'type' => 'textarea'
    );

    //==========================================================================================
    $options[] = array(
        'name' => __('Banner設定', 'ui_boxmoe_com'),
        'icon' => 'dashicons-format-image',
        'desc' => __('（導覽列下方的圖片設定）', 'ui_boxmoe_com'),
        'type' => 'heading'
    );
    $options[] = array(
        'name' => __('Banner歡迎語', 'ui_boxmoe_com'),
        'desc' => __('（留空則不顯示）', 'ui_boxmoe_com'),
        'id'   => 'banner_font',
        'std'  => 'Hello! 歡迎來到盒子萌！',
        'class' => '',
        'type' => 'text'
    );
    $options[] = array(
        'name' => __('Banner 一言開關', 'ui_boxmoe_com'),
        'desc' => __('（顯示於Banner）', 'ui_boxmoe_com'),
        'id'   => 'hitokoto_on',
        'type' => 'checkbox',
        'std'  => false,
    );
    $hitokoto_array = array(
        'a' => __('動畫', 'ui_boxmoe_com'),
        'b' => __('漫畫', 'ui_boxmoe_com'),
        'c' => __('遊戲', 'ui_boxmoe_com'),
        'd' => __('文學', 'ui_boxmoe_com'),
        'e' => __('原創', 'ui_boxmoe_com'),
        'f' => __('來自網路', 'ui_boxmoe_com'),
        'g' => __('其他', 'ui_boxmoe_com'),
        'h' => __('影視', 'ui_boxmoe_com'),
        'i' => __('詩詞', 'ui_boxmoe_com'),
        'j' => __('網易雲', 'ui_boxmoe_com'),
        'k' => __('哲學', 'ui_boxmoe_com'),
    );
    $options[] = array(
        'name' => __('Banner 一言句子分類', 'ui_boxmoe_com'),
        'id'   => 'hitokoto_text',
        'std'  => 'lolinet',
        'type' => 'select',
        'class' => 'hidden',
        'options' => $hitokoto_array
    );
    $options[] = array(
        'name'        => __('【PC端】Banner高度', 'ui_boxmoe_com'),
        'desc'        => __('（預設580，如留空則使用預設值）', 'ui_boxmoe_com'),
        'id'          => 'banner_height',
        'group'       => 'start',
        'group_title' => 'Banner高度自訂設定',
        'std'         => '',
        'class'       => 'mini',
        'type'        => 'text'
    );
    $options[] = array(
        'name'  => __('【手機端】Banner高度', 'ui_boxmoe_com'),
        'desc'  => __('（預設480，如留空則使用預設值）', 'ui_boxmoe_com'),
        'id'    => 'm_banner_height',
        'std'   => '',
        'class' => 'mini',
        'group' => 'end',
        'type'  => 'text'
    );
    $options[] = array(
        'name' => __('（固定）Banner背景圖', 'ui_boxmoe_com'),
        'id'   => 'banner_url',
        'std'  => $imagepath . 'banner/1.jpg',
        'type' => 'upload'
    );
    $options[] = array(
        'name' => __('（隨機）Banner背景圖', 'ui_boxmoe_com'),
        'desc' => __('（啟用後，上方↑固定圖片將失效。請將圖片放置於主題 /assets/images/banner/ 下，並使用數字命名）', 'ui_boxmoe_com'),
        'id'   => 'banner_rand',
        'type' => 'checkbox',
        'std'  => false,
    );
    $options[] = array(
        'name' => __('Banner隨機圖片數量', 'ui_boxmoe_com'),
        'id'   => 'banner_rand_n',
        'std'  => 12,
        'desc' => __('（圖片命名為1.jpg、2.jpg... 直到 x.jpg；x=1~此處設定的數量）', 'ui_boxmoe_com'),
        'class' => 'hidden mini',
        'type' => 'text'
    );
    $options[] = array(
        'name' => __('使用外部API Banner圖片', 'ui_boxmoe_com'),
        'desc' => __('（啟用後，以上所有圖片功能失效）', 'ui_boxmoe_com'),
        'id'   => 'banner_api_on',
        'type' => 'checkbox',
        'std'  => false,
    );
    $options[] = array(
        'name'  => __('圖片外部API連結', 'ui_boxmoe_com'),
        'id'    => 'banner_api_url',
        'std'   => '',
        'class' => 'hidden',
        'type'  => 'text'
    );

    //==========================================================================================
    $options[] = array(
        'name' => __('SEO設定', 'ui_boxmoe_com'),
        'desc' => __('（主題對搜尋引擎的SEO優化）', 'ui_boxmoe_com'),
        'icon' => 'dashicons-admin-site',
        'type' => 'heading'
    );
    $options[] = array(
        'name' => __('全站標題連接符', 'ui_boxmoe_com'),
        'desc' => __('（「-」或「_」一般設定後不要隨意修改，會影響SEO）', 'ui_boxmoe_com'),
        'id'   => 'connector',
        'std'  => get_boxmoe('connector') ? get_boxmoe('connector') : '-',
        'class' => 'mini',
        'type' => 'text'
    );
    $options[] = array(
        'name' => __('百度文章發布主動推送', 'ui_boxmoe_com'),
        'id'   => 'baidutuisong',
        'type' => 'checkbox',
        'std'  => false,
    );
    $options[] = array(
        'name' => __('百度文章發布主動推送key', 'ui_boxmoe_com'),
        'id'   => 'baidutuisongkey',
        'std'  => '',
        'type' => 'text',
        'class' => 'hidden',
        'desc' => __('如果推送成功，文章會新增自訂欄位 Baidusubmit，值為1', 'ui_boxmoe_com'),
    );
    $options[] = array(
        'name' => __('首頁關鍵字(keywords)', 'ui_boxmoe_com'),
        'id'   => 'keywords',
        'std'  => 'WordPress',
        'desc' => __('多個關鍵字請使用英文逗號隔開', 'ui_boxmoe_com'),
        'settings' => array('rows' => 3),
        'type' => 'textarea'
    );
    $options[] = array(
        'name' => __('網站描述(description)', 'ui_boxmoe_com'),
        'id'   => 'description',
        'std'  => '又是一個部落格',
        'settings' => array('rows' => 3),
        'type' => 'textarea'
    );
    $options[] = array(
        'name' => __('分類關鍵字', 'ui_boxmoe_com'),
        'desc' => __('（啟用後，將自動從「圖像描述」中取得關鍵字和描述，請用「::::::」6個英文冒號分隔關鍵字與描述，例如：關鍵字1,關鍵字2::::::描述文字）', 'ui_boxmoe_com'),
        'id'   => 'cat_keyworks_s',
        'type' => 'checkbox',
        'std'  => false,
    );
    $options[] = array(
        'name' => __('網站自動添加關鍵字與描述', 'ui_boxmoe_com'),
        'desc' => __('（啟用後，所有頁面將自動使用本主題中的關鍵字與描述）', 'ui_boxmoe_com'),
        'id'   => 'site_keywords_description_s',
        'type' => 'checkbox',
        'std'  => true,
    );
    $options[] = array(
        'name' => __('自訂文章關鍵字與描述', 'ui_boxmoe_com'),
        'desc' => __('（啟用後，你需要在編輯文章時填寫，如果留空則自動使用主題設定的關鍵字與描述；但要先啟用上方「網站自動添加關鍵字與描述」）', 'ui_boxmoe_com'),
        'id'   => 'post_keywords_description_s',
        'type' => 'checkbox',
        'std'  => false,
    );

    //==========================================================================================
    $options[] = array(
        'name' => __('文章設定', 'ui_boxmoe_com'),
        'icon' => 'dashicons-format-aside',
        'desc' => __('（與文章相關的設定項）', 'ui_boxmoe_com'),
        'type' => 'heading'
    );
    $options[] = array(
        'name' => __('文章相關模組漸進動態效果', 'ui_boxmoe_com'),
        'id'   => 'wow_on',
        'type' => 'checkbox',
        'std'  => false,
    );
    $options[] = array(
        'name' => __('文章隨機縮圖數量', 'ui_boxmoe_com'),
        'id'   => 'thumbnail_rand_n',
        'std'  => 10,
        'class' => 'mini',
        'desc' => __('（圖片放在主題 boxmoe/assets/images/rand/ 底下，命名為 N.jpg，N=1~此處設定）', 'ui_boxmoe_com'),
        'type' => 'text'
    );
    $options[] = array(
        'name' => __('啟用API隨機縮圖', 'ui_boxmoe_com'),
        'id'   => 'thumbnail_api',
        'type' => 'checkbox',
        'std'  => false,
    );
    $options[] = array(
        'name'  => __('自訂API隨機縮圖URL', 'ui_boxmoe_com'),
        'id'    => 'thumbnail_api_url',
        'std'   => '',
        'class' => 'hidden',
        'type'  => 'text'
    );
    $options[] = array(
        'name' => __('在新視窗開啟文章', 'ui_boxmoe_com'),
        'desc' => __('（啟用後，文章連結會於新視窗開啟）', 'ui_boxmoe_com'),
        'id'   => 'target_blank',
        'type' => 'checkbox',
        'std'  => false,
    );
    $options[] = array(
        'name' => __('文章列表分頁模式', 'ui_boxmoe_com'),
        'id'   => 'paging_type',
        'std'  => 'multi',
        'type' => 'radio',
        'options' => array(
            'next'  => __('上一頁、下一頁', 'ui_boxmoe_com'),
            'multi' => __('頁碼 1 2 3 ...', 'ui_boxmoe_com')
        )
    );
    $options[] = array(
        'name' => __('正文底部相關文章', 'ui_boxmoe_com'),
        'id'   => 'post_related_s',
        'type' => 'checkbox',
        'std'  => false,
    );
    $options[] = array(
        'name' => __('相關文章顯示方式', 'ui_boxmoe_com'),
        'id'   => 'post_related_model',
        'type' => 'radio',
        'std'  => 'thumb',
        'options' => array(
            'thumb' => __('圖文模式', 'ui_boxmoe_com')
            // 'text' => __('文字連結模式', 'ui_boxmoe_com')
        )
    );
    $options[] = array(
        'name'  => __('相關文章 - 顯示文章數量', 'ui_boxmoe_com'),
        'id'    => 'post_related_n',
        'std'   => 3,
        'class' => 'mini',
        'desc'  => __('建議使用 3 / 6 / 9 / 12 排版', 'ui_boxmoe_com'),
        'type'  => 'text'
    );
    $options[] = array(
        'name' => __('文章作者資訊框', 'ui_boxmoe_com'),
        'desc' => __('（位於文章內容底部）', 'ui_boxmoe_com'),
        'id'   => 'open_author_info',
        'type' => 'checkbox',
        'std'  => false,
    );
    $options[] = array(
        'name'     => __('文章作者資訊', 'ui_boxmoe_com'),
        'desc'     => __('（聯絡圖示可在社交設定中填寫）', 'ui_boxmoe_com'),
        'id'       => 'authorinfo',
        'settings' => array('rows' => 3),
        'class'    => 'hidden',
        'std'      => '作者資訊模組... 後台面板填寫內容...',
        'type'     => 'textarea'
    );

    //==========================================================================================
    $options[] = array(
        'name' => __('評論設定', 'ui_boxmoe_com'),
        'icon' => 'dashicons-format-status',
        'type' => 'heading'
    );
    $options[] = array(
        'name' => __('關閉全站評論', 'ui_boxmoe_com'),
        'id'   => 'comments_off',
        'type' => 'checkbox',
        'std'  => false,
    );
    $options[] = array(
        'name' => __('自訂「傳送評論」按鈕文字', 'ui_boxmoe_com'),
        'id'   => 'diy_comment_btn',
        'std'  => '傳送評論',
        'class' => 'mini',
        'desc' => __('留空則使用預設文字「傳送評論」', 'ui_boxmoe_com'),
        'type' => 'text'
    );
    $options[] = array(
        'name' => __('自訂評論框內文字', 'ui_boxmoe_com'),
        'id'   => 'diy_comment_text',
        'std'  => '你可以在這裡輸入評論內容...',
        'desc' => __('留空則使用預設文字', 'ui_boxmoe_com'),
        'type' => 'text'
    );
    $options[] = array(
        'name' => __('攔截非會員純英文與純日文評論', 'ui_boxmoe_com'),
        'id'   => 'false_enjp_comment',
        'type' => 'checkbox',
        'std'  => false,
    );
    $options[] = array(
        'name'  => __('評論：管理員標籤命名', 'ui_boxmoe_com'),
        'id'    => 'comnanes',
        'std'   => '博主',
        'class' => 'mini',
        'desc'  => __('管理員發表或回覆評論的標籤', 'ui_boxmoe_com'),
        'type'  => 'text'
    );
    $options[] = array(
        'name'  => __('評論：註冊會員標籤命名', 'ui_boxmoe_com'),
        'id'    => 'comnanesu',
        'std'   => '會員',
        'class' => 'mini',
        'desc'  => __('註冊會員發表或回覆評論的標籤', 'ui_boxmoe_com'),
        'type'  => 'text'
    );
    $options[] = array(
        'name'  => __('評論：訪客標籤命名', 'ui_boxmoe_com'),
        'id'    => 'comnaness',
        'std'   => '訪客',
        'class' => 'mini',
        'desc'  => __('訪客發表或回覆評論的標籤', 'ui_boxmoe_com'),
        'type'  => 'text'
    );

    //==========================================================================================
    $options[] = array(
        'name' => __('會員設定', 'ui_boxmoe_com'),
        'icon' => 'dashicons-admin-users',
        'desc' => __('（會員系統需搭配外掛 erphpdown 使用）', 'ui_boxmoe_com'),
        'type' => 'heading'
    );
    $options[] = array(
        'name' => __('啟用導覽列的會員註冊連結', 'ui_boxmoe_com'),
        'id'   => 'sign_f',
        'type' => 'checkbox',
        'std'  => false,
    );
    $options[] = array(
        'name' => __('會員註冊支援中文', 'ui_boxmoe_com'),
        'id'   => 'sign_zhcn',
        'type' => 'checkbox',
        'std'  => false,
        'class' => 'hidden',
    );
    $options[] = array(
        'name'        => __('會員登入頁面', 'ui_boxmoe_com'),
        'desc'        => __('（新增一個頁面並選擇「會員登入」樣板）', 'ui_boxmoe_com'),
        'id'          => 'users_login',
        'group'       => 'start',
        'group_title' => '會員相關頁面設定',
        'type'        => 'select',
        'class'       => 'hidden',
        'options'     => $options_pages
    );
    $options[] = array(
        'name' => __('會員註冊頁面', 'ui_boxmoe_com'),
        'desc' => __('（新增一個頁面並選擇「會員註冊」樣板）', 'ui_boxmoe_com'),
        'id'   => 'users_reg',
        'type' => 'select',
        'class' => 'hidden',
        'options' => $options_pages
    );
    $options[] = array(
        'name' => __('重設密碼頁面', 'ui_boxmoe_com'),
        'desc' => __('（新增一個頁面並選擇「重設密碼」樣板）', 'ui_boxmoe_com'),
        'id'   => 'users_reset',
        'type' => 'select',
        'class' => 'hidden',
        'options' => $options_pages
    );
    $options[] = array(
        'name' => __('會員中心頁面', 'ui_boxmoe_com'),
        'desc' => __('（新增一個頁面並選擇「會員中心」樣板，需要搭配 erphpdown 外掛）', 'ui_boxmoe_com'),
        'id'   => 'users_page',
        'type' => 'select',
        'class' => 'hidden',
        'options' => $options_pages
    );
    $options[] = array(
        'name' => __('註冊成功後跳轉頁面', 'ui_boxmoe_com'),
        'id'   => 'regto',
        'std'  => $webhome,
        'class' => 'hidden',
        'type' => 'text'
    );
    $options[] = array(
        'name' => __('登入成功後跳轉頁面', 'ui_boxmoe_com'),
        'id'   => 'loginto',
        'std'  => $webhome,
        'class' => 'hidden',
        'group' => 'end',
        'type' => 'text'
    );
    $options[] = array(
        'name' => __('前端儲值卡購買連結', 'ui_boxmoe_com'),
        'id'   => 'czcard_src',
        'std'  => '',
        'class' => 'hidden',
        'type' => 'text'
    );

    //==========================================================================================
    $options[] = array(
        'name' => __('社交設定', 'ui_boxmoe_com'),
        'type' => 'heading'
    );
    // $options[] = array(
    //   'name' => __('文章打賞QR Code'),
    //   'desc' => __('（日後可能更新，留空不顯示）', 'ui_boxmoe_com'),
    //   'id'   => 'boxmoe_dayegivemesomemoney',
    //   'std'  => $imagepath.'dayegivemesomemoney.jpg',
    //   'type' => 'upload'
    // );
    $options[] = array(
        'name' => __('QQ連絡'),
        'desc' => __('直接輸入QQ號，留空則不顯示', 'ui_boxmoe_com'),
        'id'   => 'boxmoe_qq',
        'std'  => '10000',
        'class' => 'mini',
        'type' => 'text'
    );
    $options[] = array(
        'name' => __('微信QR Code'),
        'desc' => __('上傳圖片，留空則不顯示。', 'ui_boxmoe_com'),
        'id'   => 'boxmoe_wechat',
        'std'  => $imagepath . 'wechat.jpg',
        'type' => 'upload'
    );
    $options[] = array(
        'name' => __('Email 信箱'),
        'desc' => __('直接輸入信箱，留空則不顯示。', 'ui_boxmoe_com'),
        'id'   => 'boxmoe_mail',
        'class' => 'mini',
        'type' => 'text'
    );
    $options[] = array(
        'name' => __('Github'),
        'desc' => __('直接輸入連結，留空則不顯示', 'ui_boxmoe_com'),
        'id'   => 'boxmoe_github',
        'std'  => 'https://www.boxmoe.com',
        'type' => 'text'
    );
    $options[] = array(
        'name' => __('微博'),
        'desc' => __('直接輸入連結，留空則不顯示', 'ui_boxmoe_com'),
        'id'   => 'boxmoe_weibo',
        'std'  => 'https://www.boxmoe.com',
        'type' => 'text'
    );

    //==========================================================================================
    $options[] = array(
        'name' => __('機器人設定', 'ui_boxmoe_com'),
        'icon' => 'dashicons-universal-access',
        'type' => 'heading'
    );
    $options[] = array(
        'name' => __('啟用機器人功能', 'ui_boxmoe_com'),
        'id'   => 'bot_api',
        'type' => 'checkbox',
        'std'  => false,
    );
    $options[] = array(
        'name' => __('1. 選擇機器人通道', 'ui_boxmoe_com'),
        'id'   => 'bot_api_server',
        'std'  => 'boe_api_qq',
        'type' => 'radio',
        'options' => array(
            'boe_api_qq' => __('QQ機器人', 'ui_boxmoe_com'),
            'boe_api_dd' => __('釘釘機器人', 'ui_boxmoe_com'),
        )
    );
    $options[] = array(
        'name' => __('2. 機器人 API 位址'),
        'desc' => __('QQ機器人 API 位址 或 釘釘機器人 Webhook (https://oapi.dingtalk.com/robot/send?access_token=xxxx)', 'ui_boxmoe_com'),
        'id'   => 'bot_api_url',
        'std'  => 'http://127.0.0.1:5700',
        'type' => 'text'
    );
    $options[] = array(
        'name'  => __('2-1 接收QQ機器人訊息的QQ號碼', 'ui_boxmoe_com'),
        'id'    => 'bot_api_qqnum',
        'class' => 'mini',
        'std'   => '504888738',
        'type'  => 'text'
    );
    $options[] = array(
        'name'  => __('2-2 釘釘機器人加簽金鑰', 'ui_boxmoe_com'),
        'id'    => 'bot_api_ddkey',
        'class' => 'mini',
        'std'   => '',
        'type'  => 'text'
    );
    $options[] = array(
        'name'  => __('新評論訊息推送', 'ui_boxmoe_com'),
        'id'    => 'bot_api_comment',
        'type'  => 'checkbox',
        'group' => 'start',
        'group_title' => '機器人訊息推送設定',
        'std'   => false,
        'desc'  => __('啟用新評論訊息推送', 'ui_boxmoe_com'),
    );
    $options[] = array(
        'name' => __('新會員註冊通知', 'ui_boxmoe_com'),
        'id'   => 'bot_api_reguser',
        'type' => 'checkbox',
        'group' => 'end',
        'std'  => false,
        'desc' => __('啟用新會員註冊通知', 'ui_boxmoe_com'),
    );

    //==========================================================================================
    $options[] = array(
        'name' => __('郵件設定', 'ui_boxmoe_com'),
        'icon' => 'dashicons-email-alt',
        'type' => 'heading'
    );
    $options[] = array(
        'name' => __('啟用SMTP寄件功能', 'ui_boxmoe_com'),
        'id'   => 'smtpmail',
        'type' => 'checkbox',
        'std'  => false,
    );
    $options[] = array(
        'name'        => __('寄件人', 'ui_boxmoe_com'),
        'id'          => 'fromnames',
        'std'         => '盒子萌',
        'group'       => 'start',
        'group_title' => 'SMTP伺服器設定',
        'class'       => 'mini hidden',
        'type'        => 'text'
    );
    $options[] = array(
        'name'  => __('伺服器', 'ui_boxmoe_com'),
        'id'    => 'smtphost',
        'std'   => 'smtp.boxmoe.com',
        'class' => 'mini hidden',
        'type'  => 'text'
    );
    $options[] = array(
        'name'  => __('加密 SSL', 'ui_boxmoe_com'),
        'desc'  => __('若留空，下方埠號請填25', 'ui_boxmoe_com'),
        'id'    => 'smtpsecure',
        'std'   => 'ssl',
        'class' => 'mini hidden',
        'type'  => 'text'
    );
    $options[] = array(
        'name' => __('服務埠號', 'ui_boxmoe_com'),
        'desc' => __('SSL一般為465，普通為25', 'ui_boxmoe_com'),
        'id'   => 'smtpprot',
        'std'  => '465',
        'class' => 'mini hidden',
        'type' => 'text'
    );
    $options[] = array(
        'name'  => __('信箱帳號', 'ui_boxmoe_com'),
        'id'    => 'smtpusername',
        'std'   => 'sys@boxmoe.com',
        'class' => 'mini hidden',
        'type'  => 'text'
    );
    $options[] = array(
        'name'  => __('信箱密碼', 'ui_boxmoe_com'),
        'id'    => 'smtppassword',
        'std'   => 'boxmoe',
        'class' => 'mini hidden',
        'group' => 'end',
        'type'  => 'password'
    );

    //==========================================================================================
    $options[] = array(
        'name' => __('系統優化', 'ui_boxmoe_com'),
        'type' => 'heading'
    );
    $options[] = array(
        'name' => __('禁止非管理員進入後台', 'ui_boxmoe_com'),
        'id'   => 'boxmoe_admin_off',
        'type' => 'checkbox',
        'std'  => false,
    );
    $options[] = array(
        'name' => __('關閉古騰堡編輯器', 'ui_boxmoe_com'),
        'id'   => 'gutenberg_off',
        'type' => 'checkbox',
        'std'  => true,
    );
    $options[] = array(
        'name' => __('WordPress頁首優化', 'ui_boxmoe_com'),
        'id'   => 'wpheader_on',
        'type' => 'checkbox',
        'std'  => false,
        'desc' => __('移除頁首無用的程式碼', 'ui_boxmoe_com'),
    );
    $options[] = array(
        'name' => __('移除頁首Feed並關閉Feed防採集', 'ui_boxmoe_com'),
        'id'   => 'feed_off',
        'type' => 'checkbox',
        'std'  => false,
    );
    $options[] = array(
        'name' => __('移除Emoji', 'ui_boxmoe_com'),
        'id'   => 'emoji_off',
        'type' => 'checkbox',
        'std'  => false,
    );
    $options[] = array(
        'name' => __('移除dns-refresh', 'ui_boxmoe_com'),
        'id'   => 'remove_dns_refresh',
        'type' => 'checkbox',
        'std'  => false,
        'desc' => __('WP 系統預設的 DNS 預加載，看需求決定是否移除', 'ui_boxmoe_com'),
    );
    $options[] = array(
        'name' => __('停用文章自動儲存', 'ui_boxmoe_com'),
        'id'   => 'autosaveop',
        'type' => 'checkbox',
        'std'  => false,
    );
    $options[] = array(
        'name' => __('停用文章修訂版本', 'ui_boxmoe_com'),
        'id'   => 'revisions_to_keepop',
        'type' => 'checkbox',
        'std'  => false,
    );
    $options[] = array(
        'name' => __('移除RSS訂閱', 'ui_boxmoe_com'),
        'id'   => 'rss_off',
        'type' => 'checkbox',
        'std'  => false,
    );
    $options[] = array(
        'name' => __('禁止Pingback以阻擋部分垃圾評論', 'ui_boxmoe_com'),
        'id'   => 'Pingback_off',
        'type' => 'checkbox',
        'std'  => false,
    );
    $options[] = array(
        'name' => __('關閉embeds加速載入', 'ui_boxmoe_com'),
        'id'   => 'embeds_off',
        'type' => 'checkbox',
        'std'  => false,
    );

    //==========================================================================================
    $options[] = array(
        'name' => __('前端加速', 'ui_boxmoe_com'),
        'icon' => 'dashicons-dashboard',
        'desc' => __('（提高 JS、CSS、頭像載入速度）', 'ui_boxmoe_com'),
        'type' => 'heading'
    );
    $gravatar_array = array(
        'cravatar' => __('Cravatar 伺服器', 'ui_boxmoe_com'),
        'lolinet'  => __('蘿莉 伺服器', 'ui_boxmoe_com'),
        'qiniu'    => __('七牛 伺服器', 'ui_boxmoe_com'),
        'geekzu'   => __('極客 伺服器', 'ui_boxmoe_com'),
        // 'v2excom' => __('v2ex 伺服器', 'ui_boxmoe_com'),
        'cn'       => __('官方 CN 伺服器', 'ui_boxmoe_com'),
        'ssl'      => __('官方 SSL 伺服器', 'ui_boxmoe_com'),
    );
    $options[] = array(
        'name'        => __('Gravatar 頭像', 'ui_boxmoe_com'),
        'desc'        => __('（可透過鏡像伺服器加速 Gravatar 頭像）', 'ui_boxmoe_com'),
        'id'          => 'gravatar_url',
        'group'       => 'start',
        'group_title' => '前端頭像加速伺服器',
        'std'         => 'lolinet',
        'type'        => 'select',
        'class'       => 'mini',
        'options'     => $gravatar_array
    );
    $qqravatar_array = array(
        'Q1' => __('QQ 官方伺服器1', 'ui_boxmoe_com'),
        'Q2' => __('QQ 官方伺服器2', 'ui_boxmoe_com'),
        'Q3' => __('QQ 官方伺服器3', 'ui_boxmoe_com'),
        'Q4' => __('QQ 官方伺服器4', 'ui_boxmoe_com'),
    );
    $options[] = array(
        'name'    => __('QQ 頭像', 'ui_boxmoe_com'),
        'desc'    => __('（若使用者為QQ信箱，則調用QQ頭像）', 'ui_boxmoe_com'),
        'id'      => 'qqavatar_url',
        'group'   => 'end',
        'std'     => 'Q2',
        'type'    => 'select',
        'class'   => 'mini',
        'options' => $qqravatar_array
    );
    $options[] = array(
        'name' => __('選擇前端外部 CSS/JS/圖片載入節點', 'ui_boxmoe_com'),
        'id'   => 'ui_cdn',
        'std'  => 'local',
        'type' => 'radio',
        'options' => array(
            'local'   => __('本地（預設）', 'ui_boxmoe_com'),
            'diy_cdn' => __('自建節點', 'ui_boxmoe_com')
        )
    );
    $options[] = array(
        'name'     => __('自建節點連結', 'ui_boxmoe_com'),
        'id'       => 'diy_cdn_src',
        'std'      => '',
        'settings' => array('rows' => 1),
        'desc'     => __('將主題下的 assets 資料夾上傳到你自建的加速節點並在此填入 (如 https://domain.com/lolimeow/assets )，連結末端請勿加「/」', 'ui_boxmoe_com'),
        'type'     => 'textarea'
    );

    //==========================================================================================
    $options[] = array(
        'name' => __('全站音樂', 'ui_boxmoe_com'),
        'type' => 'heading'
    );
    $options[] = array(
        'name' => __('說明', 'ui_boxmoe_com'),
        'desc' => __('音樂功能介面已失效，目前暫無替代方案，請關閉此功能', 'ui_boxmoe_com'),
        'type' => 'info'
    );
    $options[] = array(
        'name' => __('全站底部音樂播放器開關', 'ui_boxmoe_com'),
        'id'   => 'music_on',
        'type' => 'checkbox',
        'std'  => false,
    );
    $options[] = array(
        'name' => __('★選擇音樂服務供應商', 'ui_boxmoe_com'),
        'id'   => 'music_server',
        'std'  => 'netease',
        'type' => 'radio',
        'options' => array(
            'netease' => __('1. 網易雲', 'ui_boxmoe_com'),
            'tencent' => __('2. QQ音樂', 'ui_boxmoe_com'),
            'kugou'   => __('3. 酷狗', 'ui_boxmoe_com'),
            'xiami'   => __('4. 虾米', 'ui_boxmoe_com'),
            'baidu'   => __('5. 百度', 'ui_boxmoe_com')
        )
    );
    $options[] = array(
        'name' => __('歌單ID', 'ui_boxmoe_com'),
        'desc' => __('（請避免使用超過100首的歌單，以免API伺服器回傳錯誤）', 'ui_boxmoe_com'),
        'id'   => 'music_id',
        'std'  => '2765798464',
        'type' => 'text'
    );
    $options[] = array(
        'name' => __('★歌單列表播放順序', 'ui_boxmoe_com'),
        'id'   => 'music_order',
        'std'  => 'list',
        'type' => 'radio',
        'options' => array(
            'list'   => __('1. 順序播放', 'ui_boxmoe_com'),
            'random' => __('2. 隨機播放', 'ui_boxmoe_com'),
        )
    );

    $options[] = array(
        'name' => __('關於主題', 'ui_boxmoe_com'),
        'type' => 'heading'
    );
    $options[] = array(
        'name' => __('開源協定', 'ui_boxmoe_com'),
        'id'   => 'banquan',
        'desc' => __(
            '
            <p>1. 本主題基於 GPL V3.0 授權協定，如果不接受此協定，請立即刪除。</p>
            <p>2. 請遵守開源協定，保留主題頁尾版權資訊，如果不接受此協定，請立即刪除。</p>
            ',
            'ui_boxmoe_com'
        ),
        'type' => 'info'
    );
    $options[] = array(
        'name' => __('使用規範 / 注意事項', 'ui_boxmoe_com'),
        'id'   => 'shiyong',
        'desc' => __(
            '
            <p>1. 本主題僅供部落格愛好者合法建站使用！嚴禁用於違法用途！若無法遵守請立即刪除。</p>
            <p>2. 嚴禁利用本主題嚴重侵犯他人隱私權，若無法遵守請立即刪除。</p>
            <p>3. 使用主題時請遵守網站伺服器所在地及站長所在地相關法律，若無法遵守請立即刪除。</p>
            <p>4. 本主題不支援任何非法或違規用途站點，若無法遵守請立即刪除。</p>
            <p>5. 主題開放源碼，並無任何加密檔案；若因使用者使用本主題導致自身或他人隱私洩露、任何不良後果，均由使用者自行承擔，作者不承擔任何責任。</p>
            <p>6. 主題為共享下載，若使用者自行下載使用，即表示使用者自願並接受本協定所有條款。若無法接受請立即刪除。</p>
            ',
            'ui_boxmoe_com'
        ),
        'type' => 'info'
    );
    $options[] = array(
        'name' => __('主題資訊', 'ui_boxmoe_com'),
        'id'   => 'banquan',
        'desc' => __(
            '
            <p>目前版本：' . $VERSION . '</p>
            <p>最新版本：<span id="vbox"></span></p>
            <p>查看主題：<a href="https://www.boxmoe.com/468.html" target="_blank" rel="external nofollow" class="url">更新日誌</a></p>
            <p>主題 QQ 群：<a href="http://qm.qq.com/cgi-bin/qm/qr?_wv=1027&k=YLb_jw14jGMh1q8cMwga9UZcWp6JDPsS&authKey=x8YpdYVOU%2BIyiJ8uSJ2gT9UJ%2B%2BByQjnaHTTaTjMAu9YIERV20NnM%2F7tfBB%2B39peo&noverify=0&group_code=24847519" target="_blank" rel="external nofollow" class="url">24847519</a></p>
            ',
            'ui_boxmoe_com'
        ),
        'type' => 'info'
    );

    // 拓展區結束 =====================================================================================
    //-----------------------------------------------------------
    return $options;
}
