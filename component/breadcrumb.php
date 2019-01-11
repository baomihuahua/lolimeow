<?php
/**
 * The default template for breadcrumb
 */
?>

<ol class="breadcrumb">    
<li class="breadcrumb-item">
<i class="fa fa-home">
</i><a href="<?php echo home_url(); ?>">Home</a></li>   
 <?php if(!is_page()){?> <li class="breadcrumb-item"><?php the_category(' / '); ?></li><?php  }?>    
<li class="breadcrumb-item active" aria-current="page"><?php the_title(); echo get_the_subtitle(); ?></li>  
</ol>


