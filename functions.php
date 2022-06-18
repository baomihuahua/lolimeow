<?php
/*——————————————————————————女神保佑，代码无bug——————————————————————
*        ´´´´´´´´██´´´´´´´
*        ´´´´´´´████´´´´´´
*        ´´´´´████████´´´´
*        ´´`´███▒▒▒▒███´´´´´
*        ´´´███▒●▒▒●▒██´´´
*        ´´´███▒▒▒▒▒▒██´´´´´
*        ´´´███▒▒▒▒██´                      作者： 专收爆米花
*        ´´██████▒▒███´´´´´                 官网： boxmoe.com
*        ´██████▒▒▒▒███´´                   主题： Lolimeow
*        ██████▒▒▒▒▒▒███´´´´                提示： 主题代码全部开源无加密，如存在加密文件说明非原版
*        ´´▓▓▓▓▓▓▓▓▓▓▓▓▓▒´´                 
*        ´´▒▒▒▒▓▓▓▓▓▓▓▓▓▒´´´´´                     
*        ´.▒▒▒´´▓▓▓▓▓▓▓▓▒´´´´´              主题仅供博客爱好者建站交流！！
*        ´.▒▒´´´´▓▓▓▓▓▓▓▒                   请勿使用于非法用途！！
*        ..▒▒.´´´´▓▓▓▓▓▓▓▒                  请遵守当地相关法律！！
*        ´▒▒▒▒▒▒▒▒▒▒▒▒                      主题属于开源分享，不支持任何作为非法违规用途站点！！
*        ´´´´´´´´´███████´´´´´              
*        ´´´´´´´´████████´´´´´´´
*        ´´´´´´´█████████´´´´´´
*        ´´´´´´██████████´´´´             
*        ´´´´´´██████████´´´                     
*        ´´´´´´´█████████´´
*        ´´´´´´´█████████´´´
*        ´´´´´´´´████████´´´´´
*        ________▒▒▒▒▒
*        _________▒▒▒▒
*        _________▒▒▒▒
*        ________▒▒_▒▒
*        _______▒▒__▒▒
*        _____ ▒▒___▒▒
*        _____▒▒___▒▒
*        ____▒▒____▒▒
*        ___▒▒_____▒▒
*        __███____ ▒▒
*        _████____███
*        _█ _███_ _█_███
*——————————————————————————女神保佑，代码无bug——————————————————————*/
$themedata = wp_get_theme();$themeversion = $themedata['Version'];
define('THEME_VERSION', $themeversion);
define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/module/theme_panel_set/' );
require_once dirname( __FILE__ ) . '/module/theme_panel_set/options-framework.php';
require_once dirname( __FILE__ ) . '/module/theme_panel_set/panel-js.php';
$optionsfile = locate_template( 'options.php' );load_template( $optionsfile );
require_once get_stylesheet_directory() . '/module/config/fun-navwalker.php';
require_once get_stylesheet_directory() . '/module/config/fun-optimize.php';
require_once get_stylesheet_directory() . '/module/config/fun-global.php';
require_once get_stylesheet_directory() . '/module/config/fun-mail.php';
require_once get_stylesheet_directory() . '/module/config/fun-user.php';
require_once get_stylesheet_directory() . '/module/config/fun-seo.php';
require_once get_stylesheet_directory() . '/module/config/fun-comments.php';
require_once get_stylesheet_directory() . '/module/config/fun-admin.php';
require_once get_stylesheet_directory() . '/module/config/fun-article.php';
require_once get_stylesheet_directory() . '/module/config/fun-shortcode.php';
require_once get_stylesheet_directory() . '/module/config/fun-bot.php';
if( get_boxmoe('no_categoty') ) require_once get_stylesheet_directory() . '/module//config/fun-no-category.php';

//自定义代码写在下方，主题更新注意自行备份自定义代码
