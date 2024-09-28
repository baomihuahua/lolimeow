/**
 * WordPress jQuery-Ajax-Comments 
 */
$(document).ready(function() {
    ajaxComt();
});

function ajaxComt() { 
    var i = 0, got = -1, len = document.getElementsByTagName('script').length;
    while (i <= len && got == -1) {
        var js_url = document.getElementsByTagName('script')[i].src,
            got = js_url.indexOf('comments.js'); i++;
    }
    var edit_mode = '1', // 再编辑模式( '1'=打开; '0'=关闭 )
        ajax_php_url = js_url.replace('comments.js','../../module/core/comments-ajax.php').replace(/^https?:\/\/.+\/wp-content/, location.origin+"/wp-content"),
        wp_url = js_url.substr(0, js_url.indexOf('wp-content')),
        pic_sb = wp_url + 'wp-admin/images/wpspin_light.gif', // 提交 icon
        pic_no = '<i class="fa fa-meh-o"></i>',      // 错误 icon
        pic_ys = '<i class="fa fa-smile-o"></i>',     // 成功 icon
        txt1 = '<div id="comment_loading"><i class="fa fa-spinner fa-spin"></i> 正在提交, 请稍候...</div>',
        txt2 = '<div id="error">#</div>',
        txt3 = '"> <div id="edita" class="alert alert-info"><strong>提交成功！</strong>',
        edt1 = '刷新页面之前您可以<a rel="nofollow" class="comment-reply-link_a" href="#edit" onclick=\'return addComment.moveForm("',
        edt2 = ')\'>&nbsp;&nbsp;重新编辑</a></div> ',
        cancel_edit = '取消编辑',
        edit, num = 1, comm_array=[]; comm_array.push('');

    jQuery(document).ready(function($) {
        $comments = $('#comments-title'); // 评论数据的 ID
        $cancel = $('#cancel-comment-reply-link'); cancel_text = $cancel.text();
        $submit = $('#commentform #submit'); $submit.attr('disabled', false);
        $('.comment-text-form').after(txt1 + txt2); $('#comment_loading').hide(); $('#error').hide();
        $body = (window.opera) ? (document.compatMode == "CSS1Compat" ? $('html') : $('body')) : $('html,body');

        /** submit */
        $('#commentform').submit(function(e) {
            e.preventDefault(); // 阻止表单默认提交行为
            $('#comment_loading').slideDown();
            $submit.attr('disabled', true).fadeTo('slow', 0.5);
            if (edit) $('#comment').after('<input type="text" name="edit_id" id="edit_id" value="' + edit + '" style="display:none;" />');

            /** Ajax */
            $.ajax({
                url: ajax_php_url,
                data: $(this).serialize(),
                type: $(this).attr('method'),

                error: function(request) {
                    $('#comment_loading').slideUp();
                    $('#error').slideDown().html(pic_no + request.responseText);
                    setTimeout(function() {$submit.attr('disabled', false).fadeTo('slow', 1); $('#error').slideUp();}, 3000);
                },

                success: function(data) {
                    $('#comment_loading').hide();
                    comm_array.push($('#comment').val());
                    $('textarea').each(function() { this.value = '' });
                    var t = addComment, cancel = t.I('cancel-comment-reply-link'), temp = t.I('wp-temp-form-div'), respond = t.I(t.respondId), post = t.I('comment_post_ID').value, parent = t.I('comment_parent').value;

                    // 更新评论数量
                    if (!edit && $comments.length) {
                        var n = parseInt($comments.text().match(/\d+/));
                        $comments.text($comments.text().replace(n, n + 1));
                    }

                    // 生成新评论的 HTML 结构
                    var new_comm_id = 'new_comm_' + num; // 新评论 ID
                    var new_comm_html = '<li id="' + new_comm_id + '" class="comment">';

                    // 插入评论位置修正
                    if (parent === '0') {
                        // 顶级评论插入到评论列表的末尾
                        $('#respond_com').before(new_comm_html);
                    } else {
                        // 子评论插入到被回复评论的下方
                        if ($('#comment-' + parent).children('.children').length) {
                            $('#comment-' + parent + ' .children:first').append(new_comm_html);
                        } else {
                            $('#comment-' + parent).append('<ul class="children">' + new_comm_html + '</ul>');
                        }
                    }

                    // 添加评论内容和编辑链接
                    var ok_html = '<div id="success_' + num + txt3;
                    if (edit_mode === '1') {
                        var div_ = (document.body.innerHTML.indexOf('div-comment-') === -1) ? '' : ((document.body.innerHTML.indexOf('li-comment-') === -1) ? 'div-' : '');
                        ok_html += edt1 + div_ + 'comment-' + parent + '", "' + parent + '", "respond", "' + post + '", ' + num + edt2;
                    }
                    ok_html += '</div>';

                    // 将新评论内容追加到 HTML 中
                    $('#' + new_comm_id).hide().append(data);
                    $('#' + new_comm_id).append(ok_html); // 确保编辑链接插入到评论内容中
                    $('#' + new_comm_id).fadeIn(4000);

                    // 滚动到新评论位置
                    $body.animate({ scrollTop: $('#' + new_comm_id).offset().top - 200 }, 900);
                    countdown();
                    num++; // 增加评论计数器
                    edit = '';
                    $('*').remove('#edit_id');
                    cancel.style.display = 'none';
                    cancel.onclick = null;
                    t.I('comment_parent').value = '0';
                    if (temp && respond) {
                        temp.parentNode.insertBefore(respond, temp);
                        temp.parentNode.removeChild(temp);
                    }
                }
            }); // end Ajax
            return false;
        }); // end submit

        /** comment-reply.dev.js */
        addComment = {
            moveForm: function(commId, parentId, respondId, postId, num) {
                var t = this, div, comm = t.I(commId), respond = t.I(respondId), cancel = t.I('cancel-comment-reply-link'), parent = t.I('comment_parent'), post = t.I('comment_post_ID');
                if (edit) exit_prev_edit();
                num ? (
                    t.I('comment').value = comm_array[num],
                    edit = t.I('new_comm_' + num).innerHTML.match(/(comment-)(\d+)/)[2],
                    $new_sucs = $('#success_' + num ), $new_sucs.hide(),
                    $new_comm = $('#new_comm_' + num ), $new_comm.hide(),
                    $cancel.text(cancel_edit)
                ) : $cancel.text(cancel_text);

                t.respondId = respondId;
                postId = postId || false;

                if (!t.I('wp-temp-form-div')) {
                    div = document.createElement('div');
                    div.id = 'wp-temp-form-div';
                    div.style.display = 'none';
                    respond.parentNode.insertBefore(div, respond);
                }

                !comm ? ( 
                    temp = t.I('wp-temp-form-div'),
                    t.I('comment_parent').value = '0',
                    temp.parentNode.insertBefore(respond, temp),
                    temp.parentNode.removeChild(temp)
                ) : comm.parentNode.insertBefore(respond, comm.nextSibling);

                $body.animate({ scrollTop: $('#respond').offset().top - 180 }, 400);

                if (post && postId) post.value = postId;
                parent.value = parentId;
                cancel.style.display = '';

                cancel.onclick = function() {
                    if (edit) exit_prev_edit();
                    var t = addComment, temp = t.I('wp-temp-form-div'), respond = t.I(t.respondId);

                    t.I('comment_parent').value = '0';
                    if (temp && respond) {
                        temp.parentNode.insertBefore(respond, temp);
                        temp.parentNode.removeChild(temp);
                    }
                    this.style.display = 'none';
                    this.onclick = null;
                    return false;
                };

                try { t.I('comment').focus(); }
                catch(e) {}

                return false;
            },

            I: function(e) {
                return document.getElementById(e);
            }
        }; // end addComment

        function exit_prev_edit() {
            $new_comm.show(); $new_sucs.show();
            $('textarea').each(function() { this.value = ''; });
            edit = '';
        }

        var wait = 8, submit_val = $submit.val();
        function countdown() {
            if (wait > 0) {
                $submit.val(wait); wait--; setTimeout(countdown, 1000);
            } else {
                $submit.val(submit_val).attr('disabled', false).fadeTo('slow', 1);
                wait = 8;
            }
        }
    });
}