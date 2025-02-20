<?php
/**
 * @link https://www.boxmoe.com
 * @package lolimeow
 */
//boxmoe.com===安全设置=阻止直接访问主题文件
if(!defined('ABSPATH')){echo'Look your sister';exit;}
get_header(); ?>
		<div class="container fadein-bottom">
					<div class="site-search">
						<h1 class="search-title">
						<i class="fa fa-search"></i>
						<span>搜索:<strong>[<?php echo htmlspecialchars($s); ?>]</strong>关键词<?php global $wp_query;echo ' 共' . $wp_query->found_posts . ' 篇文章';?></span></h1>
                </div>
		</div>
<?php get_template_part('page/template/blog-list');
get_sidebar();
get_footer();
?>