<?php

define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/modules/inc/' );
require_once dirname( __FILE__ ) . '/modules/inc/options-framework.php';
$optionsfile = locate_template( 'options.php' );
load_template( $optionsfile );
add_action( 'optionsframework_custom_scripts', 'optionsframework_custom_scripts' );
require_once get_stylesheet_directory() . '/modules/fun-panel.php';  
require_once get_stylesheet_directory() . '/modules/fun-opzui.php';    
require_once get_stylesheet_directory() . '/modules/fun-bootstrap.php'; 
require_once get_stylesheet_directory() . '/modules/fun-comments.php';
require_once get_stylesheet_directory() . '/modules/fun-admin.php';
require_once get_stylesheet_directory() . '/modules/fun-article.php';
require_once get_stylesheet_directory() . '/modules/fun-user.php';
require_once get_stylesheet_directory() . '/modules/fun-seo.php';
require_once get_stylesheet_directory() . '/modules/fun-mail.php';
require_once get_stylesheet_directory() . '/modules/fun-global.php';
if( meowdata('no_categoty') ) require_once get_stylesheet_directory() . '/modules/fun-no-category.php';
function md_version() {$versions = '1.6';   echo  $versions;}

//以下可以自定义fun函数


