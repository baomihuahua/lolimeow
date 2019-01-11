<?php
/**
 *Used for index/archive/search/author/catgory/tag.
 *Meowdata.com 
 *
 */
?>
<div class="entry-blog wow fadeInUp" >
<div class="entry-blog-listing clearfix">
<div class="post-standard-view">
<div class="entry-blog-list-left">
<div class="entry-format">
<div class="featured-image" > <a <?php echo _post_target_blank() ?> href="<?php echo get_permalink() ?>" title="<?php echo get_the_title().get_the_subtitle(false).md_connector().get_bloginfo('name')?>" >
<img class="img-fluid" <?php echo _get_post_thumbnail() ?> ></a>
</div>
</div>
</div>
<div class="entry-blog-list-right"> 
<div class="post-content"> 
<div class="post-header"> 
<span class="category-meta">
 <?php $category = get_the_category();if($category[0]){ echo '<a href="'.get_category_link($category[0]->term_id ).'" title="查看《'.$category[0]->cat_name.'》下的所有文章 " rel="category tag" '. _post_target_blank().' >
<i class="fa fa-folder-o"></i> '.$category[0]->cat_name.'</a>'; };?>
</span>
<h2 class="entry-post-title">
<a href="<?php echo get_permalink() ?>"><?php echo get_the_title().get_the_subtitle() ?></a>
</h2>
</div>
<div class="post-intro-text">
<?php echo _get_excerpt() ?>
</div>
<div class="post-btn">
<a href="<?php echo get_permalink() ?>"  <?php echo _post_target_blank() ?>  title="查看更多：<?php echo get_the_title().get_the_subtitle(false) ?>" class="btn btn-sm btn-outline-danger">
<i class="fa fa-folder-open-o"></i> Read More </a>
</div>
<div class="post-meta-list pt20">
<span class="list-post-author">
<i class="fa fa-user-circle"></i> <?php the_author(); ?></span>
<span class="list-post-date">
<i class="fa fa-calendar"></i>  <?php echo get_the_time('Y-m-d') ?>
</span>
<span class="list-post-Views">
<i class="fa fa-street-view"></i>  <?php echo getPostViews(get_the_ID()) ?>
</span>
<span class="list-post-comment">
<i class="fa fa-comments-o"></i>  <?php echo get_comments_number('0', '1', '%') ?> Comments
</span>
</div> 
</div>
</div>
</div>
</div>
</div>
