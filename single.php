<?php get_header(); ?>
<section class="section-profile-cover section-blog-cover section-shaped my-0 " <?php if( meowdata('banneron') ) {echo md_banner();} ?>>
      <div class="shape shape-style-1 shape-primary alpha-4">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
      </div>
      <div class="separator separator-bottom separator-skew" >
        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none">
          <polygon class="fill-white" points="2560 0 2560 100 0 100"></polygon>
        </svg>
      </div>
    </section> 		
<main class="meowblog">
 <div class="main-container">
<div class="container">
                               

                        <div class="row">
                              <div class="col-lg-10 col-md-10 ml-auto mr-auto"><?php while (have_posts()) : the_post(); ?><?php setPostViews(get_the_ID()); ?>
                                    <div class="post-single">
                                          <div class="entry-header single-entry-header">
                                                <h2 class="entry-title wow swing  animated"><?php the_title(); echo get_the_subtitle(); ?></h2>
                                                <div class="post-meta author-box wow bounceInRight">
                                                      <div class="thw-autohr-bio-img">
                                                            <div class="thw-img-border">
                                                                  <img src="<?php echo meowdata('gravatar_url'); ?><?php echo esc_attr(md5(get_the_author_meta('user_email'))) ;?>?s=60" class="img-fluid" alt="<?php the_author(); ?>">
                                                            </div>
                                                      </div>
                                                      <div class="post-meta-content">													  
                                                            <span class="list-post-date"><i class="fa fa-calendar"></i> Post on <?php echo get_the_time('Y-m-d'); ?></span>
                                                            <span class="post-author"><i class="fa fa-user-circle"></i> <?php the_author(); ?></span>
                                                            <span class="post-author"><i class="fa fa-comments-o"></i> <a href="#comments"><?php echo get_comments_number('0', '1', '%') ?> Comments</a></span>
															<span class="list-post-views"><i class="fa fa-street-view"></i> <?php echo getPostViews(get_the_ID()); ?></span>
                                                            <?php edit_post_link('['.__('<span>编辑仅作者可见</span>', 'meowdata').']'); ?>
                                                      </div>
                                                </div>
                                          </div>
                                          

                                          <div class="entry-content wow bounceInLeft"> 
										  <?php the_content(); ?>
										  </div>
                                    </div>
                                    <div class="post-footer clearfix wow bounceInDown">
                                          <div class="post-tags">
                                            <div class="article-categories"><?php the_tags('','',''); ?></div>
                                          </div>
                                    </div>

                              <div class="thw-author-box author-box thw-sept wow rollIn"> 
                                    <div class="thw-autohr-bio-img">
                                          <div class="thw-img-border">
                                                <img src="<?php echo meowdata('gravatar_url'); ?><?php echo esc_attr(md5(get_the_author_meta('user_email'))) ;?>?s=80" class="img-fluid" alt="<?php the_author(); ?>">
                                          </div>
                                    </div>
                                    <div class="author-info">
                                          <h4><?php the_author(); ?></h4>
                                          <p><?php echo meowdata('authorinfo');  ?></p>
                                    </div>
                              </div> 
							  <?php $categories = get_the_category();$categoryIDS = array();foreach ($categories as $category) {
                               array_push($categoryIDS, $category->term_id);}$categoryIDS = implode(",", $categoryIDS);?>
                              <nav class="post-navigation thw-sept wow bounceInUp">
                                    <div class="post-previous">
									<?php if (get_next_post($categoryIDS)) { next_post_link('%link','<span><i class="fa fa-angle-left"></i> Previous Post</span><h4>%title</h4>',true);} else { echo '<span><i class="fa fa-angle-left"></i> Previous Post </span><h4>已是最新文章';} ?>									      
                                    </div>
                                    <div class="post-next">
									<?php if (get_previous_post($categoryIDS)) { previous_post_link('%link','<span>Next Post <i class="fa fa-angle-right"></i></span> <h4>%title</h4>',true);}else { echo '<span>Next Post <i class="fa fa-angle-right"></i></span> <h4>已是最后文章</h4>';} ?>
                                    </div>       
                              </nav>
<?php endwhile;  ?>                           							  
<?php comments_template('', true); ?>
</div>


<?php if( meowdata('post_related_s') ) {?> 	

                    <div class="row wow fadeInUp animated">
 <div class="col-lg-12">	
<h3 class="title-normal thw-sept text-center"><?php echo meowdata('related_title')?></h3>	 </div>						
<?php if( meowdata('post_related_s') ) md_posts_related( meowdata('related_title'), meowdata('post_related_n'), (meowdata('post_related_model') ? meowdata('post_related_model') : 'thumb') ) ?>
	
                    </div>		
			<?php }	?>
				
					
</div>
</div> 					  
</div>     
</main>	

<?php get_footer(); ?>