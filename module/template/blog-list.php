<?php
/**
 * @link https://www.boxmoe.com
 * @package lolimeow
 */
?>
<article class="post-list list-one row boxmoe-bg <?php echo boxmoe_border()?> <?php if (is_sticky()) { echo 'sticky-post'; } ?>">
  <?php if (is_sticky()) : ?>
    <div class="ribbon">置顶</div>
  <?php endif; ?>
  <div class="post-list-img col-lg-5 col-xl-5 col-md-12 col-12">
    <figure class="mb-4 mb-lg-0 zoom-img">
      <a <?php echo _post_target_blank() ?> href="<?php echo get_permalink() ?>" title="<?php echo get_the_title().get_the_subtitle(false).boxmoe_connector().get_bloginfo('name')?>">
        <img src="<?php echo _get_post_thumbnail() ?>" alt="<?php echo get_the_title().get_the_subtitle(false).boxmoe_connector().get_bloginfo('name')?>" class="img-fluid rounded-3"></a>
    </figure>
  </div>
  <div class="post-list-content col-lg-7 col-xl-7 col-md-12 col-12">
    <div class="category">
      <div class="tags">
        <?php $category = get_the_category(); if($category[0]) { echo '
        <a href="'.get_category_link($category[0]->term_id ).'" title="查看《'.$category[0]->cat_name.'》下的所有文章 " rel="category tag" '. _post_target_blank().'>
        <i class="tagfa fa fa-dot-circle-o"></i>'.$category[0]->cat_name.'</a>'; };?>
      </div>
    </div>
    <div class="mt-2 mb-2">
      <h3 class="post-title h4">
        <a <?php echo _post_target_blank() ?> href="<?php echo get_permalink() ?>" title="<?php echo get_the_title().get_the_subtitle(false).boxmoe_connector().get_bloginfo('name')?>" class="text-reset"><?php echo get_the_title().get_the_subtitle() ?></a>
      </h3>
      <p class="post-content"><?php echo _get_excerpt() ?></p>
    </div>
    <div class="post-meta align-items-center">
      <div class="post-list-avatar">
        <?php echo get_avatar(get_the_author_meta('ID'),60); ?>
      </div> 
      <div class="post-meta-info">               
        <span class="list-post-author ms-3">
          <i class="fa fa-at"></i><?php the_author(); ?><span class="dot"></span><i class="fa fa-clock-o"></i><?php echo get_the_time('Y-m-d') ?></span>
        <span class="list-post-view ms-3">
          <i class="fa fa-street-view"></i><?php echo getPostViews(get_the_ID()) ?></span>
        <span class="list-post-comment ms-3">
          <i class="fa fa-comments-o"></i><?php echo get_comments_number('0', '1', '%') ?></span>
      </div>
    </div>  
  </div>
</article>