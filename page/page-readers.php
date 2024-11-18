<?php
/**
 * Template Name: Boxmoe读者墙
 * Description: 自定义评论榜单页面，展示前30名评论最多的用户，带头像、个人网址、前三名独立显示
 * @link https://MoeJue.cn
 * @author 阿珏酱
 * @package lolimeow
 */
get_header();
?>

<section class="section-blog-breadcrumb container">
    <div class="breadcrumb-head">
        <span>
            <i class="fa fa-home"></i>Page</span>
    </div>
</section>

<section id="boxmoe_theme_container">
    <div class="container">
        <div class="row">
            <div class="blog-single col-lg-12 mx-auto fadein-bottom">
                <div class="post-single <?php echo boxmoe_border()?>">
                    <h1 class="single-title">读者墙</h1>
                    <hr class="horizontal dark">
                    <div class="single-content">
                        <?php the_content(); ?>
                        <?php
                        global $wpdb;

                        // 获取前30名评论最多的用户
                        $top_commenters = $wpdb->get_results("
                            SELECT COUNT(comment_ID) AS comment_count, comment_author, comment_author_email, comment_author_url
                            FROM $wpdb->comments
                            WHERE comment_approved = 1 AND comment_author_email != ''
                            GROUP BY comment_author_email
                            ORDER BY comment_count DESC
                            LIMIT 39
                        ");

                        if ($top_commenters) :
                            echo '<div class="row justify-content-center">';

                            // 处理前三名用户
                            $medal_titles = array("金牌读者", "银牌读者", "铜牌读者");
                            $medal_colors = array("#FFCC00", "#C0C0C0", "#CD7F32"); // 金、银、铜的颜色
                            foreach ($top_commenters as $index => $commenter) :
                                if ($index < 3) :
                                    $author_name = $commenter->comment_author;
                                    $comment_count = $commenter->comment_count;
                                    $author_email = $commenter->comment_author_email;
                                    $author_url = $commenter->comment_author_url;
                                    $avatar = get_avatar($author_email, 80); 
                                    $medal_title = $medal_titles[$index];
                                    $medal_color = $medal_colors[$index];
                                    $display_url = $author_url ? esc_url($author_url) : '#';
                                    ?>
                                    <div class="col-md-4 mb-4 text-center">
                                        <div class="p-3" style="background-color: #f8f9fa; border-radius: 8px;">
                                            <div class="medal-title" style="color: <?php echo $medal_color; ?>;">
                                                【<?php echo $medal_title; ?>】
                                            </div>
                                            <div class="mt-2">
                                                <a href="<?php echo $display_url; ?>" target="_blank" title="【第<?php echo $index + 1; ?>名】评论: <?php echo $comment_count; ?>">
                                                    <?php echo $avatar; ?>
                                                </a>
                                            </div>
                                            <div class="mt-2"><?php echo esc_html($author_name); ?></div>
                                            <div class="text-muted">评论: <?php echo esc_html($comment_count); ?></div>
                                        </div>
                                    </div>
                                    <?php
                                endif;
                            endforeach;

                            echo '</div>'; 

                            echo '<div class="row justify-content-center mt-4">';
                            foreach ($top_commenters as $index => $commenter) :
                                if ($index >= 3) :
                                    $author_name = $commenter->comment_author;
                                    $comment_count = $commenter->comment_count;
                                    $author_email = $commenter->comment_author_email;
                                    $author_url = $commenter->comment_author_url;
                                    $avatar = get_avatar($author_email, 64);
                                    $display_url = $author_url ? esc_url($author_url) : '#';
                                    ?>
                                    <div class="col-6 col-sm-4 col-md-3 col-lg-1 mb-4 text-center">
                                        <a href="<?php echo $display_url; ?>" target="_blank" title="第<?php echo $index + 1; ?>名，评论数: <?php echo $comment_count; ?>">
                                            <?php echo $avatar; ?>
                                        </a>
                                        <div class="mt-2"><?php echo esc_html($author_name); ?></div>
                                    </div>
                                    <?php
                                endif;
                            endforeach;
                            echo '</div>';
                        else :
                            echo '<div class="alert alert-info text-center">暂无评论数据。</div>';
                        endif;
                        ?>
                    </div>

                    <?php if (!get_boxmoe('comments_off')): ?>
                        <div class="thw-sept"></div>
                        <?php comments_template('', true); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
get_footer();
?>