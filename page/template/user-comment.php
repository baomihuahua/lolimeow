<?php
/**
 * @link https://www.boxmoe.com
 * @package lolimeow
 */
//boxmoe.com===安全设置=阻止直接访问主题文件
if(!defined('ABSPATH')){echo'Look your sister';exit;}

?>
<p class="fs-6 mb-2 text-muted">你的历史评论内容将在这里呈现</p>
<?php 
    $current_user = wp_get_current_user();
    $paged = get_query_var('paged') ? get_query_var('paged') : 1;
    $comments_per_page = 20;
    $offset = ($paged - 1) * $comments_per_page;

    $comments = get_comments(array(
        'user_id' => $current_user->ID,
        'status'  => 'approve',
        'number'  => $comments_per_page,
        'offset'  => $offset,
    ));

    $total_comments = get_comments(array(
        'user_id' => $current_user->ID,
        'status'  => 'approve',
        'count'   => true,
    ));

    // 统计被回复的总数量
    $total_replies = 0;
    foreach ($comments as $comment) {
        $total_replies += get_comments(array(
            'parent' => $comment->comment_ID,
            'count'  => true,
        ));
    }
	$total_pages = ceil($total_comments / $comments_per_page);

	$output = '';
	$output .= '<div class="row gx-4">';
	$output .= '<div class="col-lg-6">';
	$output .= '   <div class="card border-0 mb-4 mb-lg-0 bg-light-subtle">';
	$output .= '	  <div class="card-body py-lg-3 px-lg-4">';
	$output .= '		 <div class="mb-1">';
	$output .= '			<h6>发出评论数</h6>';
	$output .= '			<h4>' . $total_comments . '条</h4>';
	$output .= '		 </div>';
	$output .= '	  </div>';
	$output .= '   </div>';
	$output .= '</div>';
	$output .= '<div class="col-lg-6">';
	$output .= '   <div class="card border-0 mb-4 mb-lg-0 bg-light-subtle">';
	$output .= '	  <div class="card-body py-lg-3 px-lg-4">';
	$output .= '		 <div class="mb-1">';
	$output .= '			<h6>被回复评论数</h6>';
	$output .= '			<h4>' . $total_replies . '条</h4>';
	$output .= '		 </div>';
	$output .= '	  </div>';
	$output .= '   </div>';
	$output .= '</div>';
	$output .= '</div>';
	$output .= '<div class="table-responsive border mt-4 mb-4 rounded-3 px-4 py-3">';
	$output .= '<table class="table table-hover">';
  	$output .= '<thead>';
    $output .= '<tr>';
    $output .= '  <th scope="col">评论内容</th>';
    $output .= '  <th scope="col">被回复数</th>';
    $output .= '  <th scope="col">查看原文</th>';
    $output .= '</tr>';
  	$output .= '</thead>';
  	$output .= '<tbody>';
	if (empty($comments)) {
	$output .= '  <tr>';
    $output .= '  <td colspan="3" align="center">你暂时还没有发出评论！</td>';
    $output .= '</tr>';        
    }else{
		foreach ($comments as $comment) {
			$replies_count = get_comments(array(
				'parent' => $comment->comment_ID,
				'count'  => true,
			));
			$comment_content = wp_trim_words($comment->comment_content, 10, '...');
			$comment_post_url = get_permalink($comment->comment_post_ID);
			$output .= '<tr>';
			$output .= '<td>' . esc_html($comment_content) . '</td>';
			$output .= '<td>' . intval($replies_count) . '</td>';
			$output .= '<td><a href="' . esc_url($comment_post_url) . '">查看原文</a></td>';
			$output .= '</tr>';
		}
	}
  	$output .= '</tbody>';
	$output .= '</table>';
	$output .= '</div>';
	$output .= '<div class="mt-4">';
	$output .= '<nav>';
	$output .= '<ul class="pagination justify-content-center pagination-sm">';

	$current_page = max(1, get_query_var('paged', 1));

	// 计算显示的页码范围
	$start = max(1, min($current_page - 2, $total_pages - 4));
	$end = min($total_pages, max(5, $current_page + 2));

	// 显示第一页和省略号
	if ($start > 1) {
		$output .= '<li class="page-item"><a href="' . esc_url(add_query_arg('paged', 1)) . '" class="page-link">1</a></li>';
		if ($start > 2) {
			$output .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
		}
	}

	// 显示中间的页码
	for ($i = $start; $i <= $end; $i++) {
		$class = ($i === $current_page) ? ' active' : '';
		$output .= '<li class="page-item' . $class . '"><a href="' . esc_url(add_query_arg('paged', $i)) . '" class="page-link">' . $i . '</a></li>';
	}

	// 显示最后一页和省略号
	if ($end < $total_pages) {
		if ($end < $total_pages - 1) {
			$output .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
		}
		$output .= '<li class="page-item"><a href="' . esc_url(add_query_arg('paged', $total_pages)) . '" class="page-link">' . $total_pages . '</a></li>';
	}

	$output .= '</ul>';
	$output .= '</nav>';
	$output .= '</div>';	
    echo $output;

?>