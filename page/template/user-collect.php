<?php
/**
 * @link https://www.boxmoe.com
 * @package lolimeow
 */
//boxmoe.com===安全设置=阻止直接访问主题文件
if(!defined('ABSPATH')){echo'Look your sister';exit;}

$current_user_id = get_current_user_id();
$posts_per_page = 10;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$favorites = get_user_meta($current_user_id, 'user_favorites', true);
$favorites = $favorites ? $favorites : array();
$total_posts = count($favorites);
$total_pages = ceil($total_posts / $posts_per_page);
$current_page_posts = array_slice($favorites, ($paged-1) * $posts_per_page, $posts_per_page);
?>
                        <div class="table-responsive border mt-4 mb-4 rounded-3 px-4 py-3">
                           <table class="table table-hover">
                              <thead>
                              <tr>
                              <th scope="col" colspan="2">收藏文章</th>
                              <th scope="col">操作</th>
                              </tr>
                              </thead>
                              <tbody>
                              <?php if (!empty($current_page_posts)) : ?>
                                    <?php foreach ($current_page_posts as $post_id) : 
                                        $post = get_post($post_id);
                                        if ($post && $post->post_status == 'publish') : ?>
                                        <tr>
                                            <td colspan="2">
                                                <a href="<?php echo get_permalink($post_id); ?>" target="_blank"><?php echo get_the_title($post_id); ?></a>
                                            </td>
                                            <td>
                                                <a href="javascript:;" class="btn btn-sm btn-outline-primary delete-favorite" data-post-id="<?php echo $post_id; ?>">取消收藏</a>
                                            </td>
                                        </tr>
                                        <?php endif;
                                    endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            <span>没有收藏</span>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                           </tbody>
                           </table>
                        </div>
                           <?php if ($total_pages > 1) : ?>
                           <nav class="mt-5">
                                <ul class="pagination justify-content-center">
                                    <?php
                                    $prev_page = $paged - 1;
                                    $next_page = $paged + 1;
                                    ?>
                                    <li class="page-item <?php echo ($paged <= 1) ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="<?php echo get_pagenum_link($prev_page); ?>" <?php echo ($paged <= 1) ? 'tabindex="-1" aria-disabled="true"' : ''; ?>>Previous</a>
                                    </li>
                                    <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                                        <li class="page-item <?php echo ($paged == $i) ? 'active' : ''; ?>">
                                            <a class="page-link" href="<?php echo get_pagenum_link($i); ?>"><?php echo $i; ?></a>
                                        </li>
                                    <?php endfor; ?>
                                    <li class="page-item <?php echo ($paged >= $total_pages) ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="<?php echo get_pagenum_link($next_page); ?>" <?php echo ($paged >= $total_pages) ? 'tabindex="-1" aria-disabled="true"' : ''; ?>>Next</a>
                                    </li>
                                </ul>
                            </nav>
                            <?php endif; ?>
                            