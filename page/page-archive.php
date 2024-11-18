<?php
/**
 * Template Name: Boxmoe文章归档
 * Description: 自定义文章归档页面，展示所有文章的年份和月份归档信息
 * @link https://MoeJue.cn
 * @author 阿珏酱
 * @package lolimeow
 */
get_header();
?>

<div class="container mt-5">
    <section class="section-blog-breadcrumb container">
        <div class="breadcrumb-head">
          <span>
            <i class="fa fa-home"></i>Page</span>
        </div>
    </section>
    <h2 class="text-center mb-4"><i class="fa fa-archive"></i> 文章归档</h2>
    <div class="accordion" id="archive-accordion">
        <?php
        // 获取所有年份的归档数据
        $years_html = wp_get_archives(array(
            'type'            => 'yearly',
            'format'          => 'custom',
            'before'          => '',
            'after'           => '',
            'show_post_count' => false,
            'echo'            => 0,
        ));

        // 使用正则表达式提取年份信息
        preg_match_all("/<a href='.*?'>(\d{4})<\/a>/", $years_html, $matches);
        $years_list = $matches[1];

        if ($years_list) :
            foreach ($years_list as $year) :
                ?>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading-<?php echo $year; ?>">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo $year; ?>" aria-expanded="false" aria-controls="collapse-<?php echo $year; ?>">
                            <?php echo $year; ?>年
                        </button>
                    </h2>
                    <div id="collapse-<?php echo $year; ?>" class="accordion-collapse collapse" aria-labelledby="heading-<?php echo $year; ?>" data-bs-parent="#archive-accordion">
                        <div class="accordion-body">
                            <!-- 手动获取该年份下的所有月份和文章数量 -->
                            <div class="accordion" id="year-accordion-<?php echo $year; ?>">
                                <?php
                                // 手动获取该年份下的所有文章
                                $posts_in_year = get_posts(array(
                                    'year'      => $year,
                                    'post_type' => 'post',
                                    'post_status' => 'publish',
                                    'numberposts' => -1,
                                    'orderby'   => 'date',
                                    'order'     => 'DESC',
                                ));

                                // 统计每个月份的文章数量
                                $months_count = array();
                                foreach ($posts_in_year as $post) {
                                    $month = date('n', strtotime($post->post_date)); // 获取月份（1 - 12）
                                    if (!isset($months_count[$month])) {
                                        $months_count[$month] = 0;
                                    }
                                    $months_count[$month]++;
                                }

                                // 遍历每个月份并显示
                                foreach ($months_count as $month => $post_count) :
                                    ?>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading-<?php echo $year . '-' . $month; ?>">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo $year . '-' . $month; ?>" aria-expanded="false" aria-controls="collapse-<?php echo $year . '-' . $month; ?>">
                                                <?php echo $year . '年 ' . $month . '月'; ?>（<?php echo $post_count; ?> 篇文章）
                                            </button>
                                        </h2>
                                        <!-- 移除 data-bs-parent 属性以防止与年份折叠互相影响 -->
                                        <div id="collapse-<?php echo $year . '-' . $month; ?>" class="accordion-collapse collapse" aria-labelledby="heading-<?php echo $year . '-' . $month; ?>">
                                            <div class="accordion-body">
                                                <ul class="list-group">
                                                    <?php
                                                    // 获取该月份的所有文章
                                                    $posts_in_month = get_posts(array(
                                                        'year'      => $year,
                                                        'monthnum'  => $month,
                                                        'post_type' => 'post',
                                                        'post_status' => 'publish',
                                                        'orderby'   => 'date',
                                                        'order'     => 'DESC',
                                                        'numberposts' => -1
                                                    ));
                                                    if ($posts_in_month) :
                                                        foreach ($posts_in_month as $post) :
                                                            ?>
                                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                <a href="<?php echo get_permalink($post->ID); ?>" target="_blank"><?php echo $post->post_title; ?></a>
                                                                <span class="badge bg-primary rounded-pill"><?php echo get_the_date('Y-m-d', $post->ID); ?></span>
                                                            </li>
                                                            <?php
                                                        endforeach;
                                                    else :
                                                        ?>
                                                        <li class="list-group-item">没有文章。</li>
                                                    <?php endif; ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="alert alert-info">暂无文章。</div>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>