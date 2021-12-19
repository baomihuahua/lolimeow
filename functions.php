<?php
define( 'THEME_VERSION'  , '6.0' );
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
if( get_boxmoe('no_categoty') ) require_once get_stylesheet_directory() . '/module//config/fun-no-category.php';
