document.addEventListener('DOMContentLoaded', function() {
    const commentForm = document.getElementById('commentform');
    if (commentForm) {
        commentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const messageArea = document.querySelector('.message-content');
            const submitBtn = this.querySelector('.submit-btn');
            const submitBtnIcon = submitBtn.querySelector('i');
            
            // 更改按钮状态为提交中
            submitBtn.disabled = true;
            submitBtnIcon.className = 'fa fa-spinner fa-spin';
            submitBtn.innerHTML = `${submitBtnIcon.outerHTML} 正在发表...`;

            // 添加AJAX请求参数
            formData.append('action', 'ajax_comment');
            formData.append('security', document.querySelector('#comment_nonce_field').value);

            fetch(ajax_object.ajaxurl, {
                method: 'POST',
                body: formData,
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // 清空输入框
                    this.querySelector('textarea').value = '';
                    
                    // 更新用户信息显示
                    const userNameElement = document.querySelector('.user-info .user-name');
                    const userEmailElement = document.querySelector('.user-info .user-email');
                    if (userNameElement && !ajax_object .is_user_logged_in) {
                        userNameElement.textContent = formData.get('author');
                    }
                    if (userEmailElement && !ajax_object .is_user_logged_in) {
                        userEmailElement.textContent = formData.get('email');
                    }
                    
                    // 获取新评论容器
                    const commentNew = document.querySelector('.comment-new');
                    const newContent = commentNew.querySelector('.new-content');
                    
                    // 插入新评论
                    const newComment = createCommentElement(data.data.comment);
                    newContent.insertAdjacentElement('afterbegin', newComment);
                    
                    // 显示新评论容器并添加动画效果
                    commentNew.style.display = 'block';
                    void commentNew.offsetWidth;
                    commentNew.classList.add('show');
                    
                    // 初始化新评论中的懒加载图片
                    const lazyImages = newComment.querySelectorAll('img.lazy');
                    lazyImages.forEach(img => {
                        const imageObserver = new IntersectionObserver((entries, observer) => {
                            entries.forEach(entry => {
                                if (entry.isIntersecting) {
                                    img.src = img.dataset.src;
                                    img.classList.remove('lazy');
                                    observer.unobserve(img);
                                }
                            });
                        });
                        imageObserver.observe(img);
                    });
                    
                    // 更新评论计数
                    updateCommentCount();
                    
                    showMessage(data.data.message || '评论提交成功！', 'success');
                } else {
                    showMessage(data.data || '提交失败，请检查输入！', 'error');
                }
            })
            .catch(error => {
                console.error('评论提交错误:', error);
                showMessage('网络错误，请重试！', 'error');
            })
            .finally(() => {
                // 恢复按钮状态
                submitBtn.disabled = false;
                submitBtnIcon.className = 'fa fa-paper-plane';
                submitBtn.innerHTML = `${submitBtnIcon.outerHTML} 发表评论`;
            });
        });
    }

    // 创建评论元素
    function createCommentElement(comment) {
        // 使用临时div包裹处理空格问题
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = comment.trim();
        return tempDiv.firstElementChild;
    }

    // 更新评论数量
    function updateCommentCount() {
        const countElement = document.querySelector('.post-comments h2');
        const currentCount = parseInt(countElement.textContent.match(/\d+/)[0]);
        countElement.textContent = countElement.textContent.replace(/\d+/, currentCount + 1);
    }

    // 回复按钮处理
    document.body.addEventListener('click', function(e) {
        if (e.target.closest('.comment-reply-link')) {
            e.preventDefault();
            const replyLink = e.target.closest('.comment-reply-link');
            const commentId = replyLink.dataset.commentid;
            document.querySelector('#comment_parent').value = commentId;
            document.getElementById('cancel-comment-reply-link').style.display = 'inline';
        }
    });
});

// 评论工具栏功能初始化
function initCommentToolbar() {
    const commentTextarea = document.querySelector('#comment');
    const emojiBtn = document.querySelector('.emoji-btn');
    const uploadBtn = document.querySelector('.upload-btn');
    const codeBtn = document.querySelector('.code-btn');
    const emojiPanel = document.querySelector('.emoji-panel');
    const codePanel = document.querySelector('.code-panel');
    const uploadInput = document.querySelector('.upload-input');
    
    if(emojiBtn && emojiPanel) {
        emojiBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            // 添加元素存在性检查
            const isVisible = emojiPanel && emojiPanel.style.display === 'block';
            if(emojiPanel) {
                emojiPanel.style.display = isVisible ? 'none' : 'block';
                codePanel && (codePanel.style.display = 'none');
            }
            
            if(emojiPanel && !isVisible) {
                const firstTab = emojiPanel.querySelector('.emoji-tabs span');
                if(firstTab) {
                    firstTab.click();
                }
            }
        });

        const emojis = {
            emoji: [
                '😀','😁','😂','🤣','😃','😄',
                '😅','😆','😉','😊','😋','😎',
                '😍','🥰','😘','😗','😙','😚',
                '😛','😝','🤗','🤔','🤨','😐',
                '😑','😶','🙄','😏','😣','😥',
                '😮','🤤','😴','😪','😵','😵',
                '😵','🤯','🤠','🤡','🤥','🤫',
                '🤔','🤨','😐','😑','😶','🙄',
            ],
            custom: ['(⌒▽⌒)', '(￣▽￣)', '(=・ω・=)', '(｀・ω・´)', 
                '(〜￣△￣)〜', '(･∀･)', '(°∀°)ﾉ', '(￣3￣)', '╮(￣▽￣)╭',
                '(*>.<*)', '( ˃̶͈◡˂̶͈ ) hi!','⚆_⚆？', '⚆_⚆', '(｡•ˇ‸ˇ•｡)'
            ]        
        };

        const emojiContent = emojiPanel.querySelector('.emoji-content');
        const emojiTabs = emojiPanel.querySelectorAll('.emoji-tabs span');
                emojiTabs.forEach(tab => {
            tab.addEventListener('click', () => {
                const type = tab.dataset.tab;
                emojiTabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
                emojiContent.innerHTML = '';
                emojis[type].forEach(emoji => {
                    const span = document.createElement('span');
                    span.textContent = emoji;
                    span.addEventListener('click', () => {
                        insertAtBoxmoe(commentTextarea, emoji);
                        emojiPanel.style.display = 'none';
                    });
                    emojiContent.appendChild(span);
                });
            });
            
            // 默认激活emoji标签
            if(tab.classList.contains('active')) {
                tab.click();
            }
        });
    }

    // 图片上传功能
    if(uploadBtn && uploadInput) {
        uploadBtn.addEventListener('click', () => {
            uploadInput.click();
        });

        uploadInput.addEventListener('change', async (e) => {
            const file = e.target.files[0];
            if(file) {
                if(file.size > 2 * 1024 * 1024) { // 2MB限制
                    showMessage('图片大小不能超过2MB', 'error');
                    return;
                }
                
                try {
                    const imgUrl = await uploadImage(file);
                    insertAtBoxmoe(commentTextarea, `![${file.name}](${imgUrl})`);
                } catch(err) {
                    showMessage('图片上传失败', 'error');
                }
            }
        });
    }

    // pl代码高亮插入功能
    if(codeBtn && codePanel) {
        const closeBtn = codePanel.querySelector('.close-btn');
        const insertBtn = codePanel.querySelector('.insert-code-btn');
        const codeInput = codePanel.querySelector('.code-input');
        const langSelect = codePanel.querySelector('.code-language');

        // 初始化代码面板位置
        codePanel.style.display = 'none';
        
        codeBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            codePanel.style.display = codePanel.style.display === 'none' ? 'block' : 'none';
            emojiPanel && (emojiPanel.style.display = 'none');
            if(codePanel.style.display === 'block') {
                codeInput.focus();
            }
        });

        closeBtn.addEventListener('click', () => {
            codePanel.style.display = 'none';
        });

        insertBtn.addEventListener('click', () => {
            const code = codeInput.value.trim();
            if(code) {
                // 修改为WordPress兼容的pre+code标签格式
                const codeBlock = `\n<pre><code class="language-">\n${code}\n</code></pre>\n`;
                insertAtBoxmoe(commentTextarea, codeBlock);
                codeInput.value = '';
                codePanel.style.display = 'none';
            }
        });

        // 回车键提交支持
        codeInput.addEventListener('keydown', (e) => {
            if(e.key === 'Enter' && (e.ctrlKey || e.metaKey)) {
                insertBtn.click();
            }
        });
    }

    document.addEventListener('click', (e) => {
        // 添加元素存在性检查
        if(emojiPanel && emojiBtn) {
            if(!emojiPanel.contains(e.target) && !emojiBtn.contains(e.target)) {
                emojiPanel.style.display = 'none';
            }
        }
        if(codePanel && codeBtn) {
            if(!codePanel.contains(e.target) && !codeBtn.contains(e.target)) {
                codePanel.style.display = 'none';
            }
        }
    });
}
// 评论回复初始化
function initCommentReply() {
    const commentForm = document.getElementById('respond');
    const cancelReply = document.getElementById('cancel-comment-reply-link');
    const commentList = document.querySelector('.comments-list');
    if (!commentForm || !cancelReply || !commentList) return;
    let originalPosition = null; 
    document.querySelectorAll('.comment-reply-link').forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            if (!commentForm) return;        
            if (!originalPosition) {
                originalPosition = commentForm.parentNode;
            }
            const commentItem = link.closest('.comment-item');
            const commentContent = commentItem?.querySelector('.comment-content');               
            if (!commentContent) return;         
            cancelReply.style.display = 'inline-block';
            commentContent.appendChild(commentForm);
            commentForm.scrollIntoView({ behavior: 'smooth', block: 'center' });
            commentForm.querySelector('#comment')?.focus();
        });
    });
    if(cancelReply) {
        cancelReply.addEventListener('click', (e) => {
            e.preventDefault();
            cancelReply.style.display = 'none';
            if (originalPosition) {
                originalPosition.appendChild(commentForm);
            }
            commentForm?.scrollIntoView({ behavior: 'smooth', block: 'center' });
        });
    }
}

// 评论消息初始化
function showMessage(message, type = 'success') {
    const messageEl = document.querySelector('.comment-message');
    const contentEl = messageEl.querySelector('.message-content');
    
    messageEl.className = 'comment-message ' + type;
    contentEl.textContent = message;
    messageEl.classList.add('show');

    setTimeout(() => {
        messageEl.classList.remove('show');
    }, 5000);
}

//编辑器辅助函数
function insertAtBoxmoe(textarea, text) {
    const start = textarea.selectionStart;
    const end = textarea.selectionEnd;
    const value = textarea.value;
    
    textarea.value = value.substring(0, start) + text + value.substring(end);
    textarea.selectionStart = textarea.selectionEnd = start + text.length;
    textarea.focus();
}

// 评论列表显示/隐藏功能初始化
function initCommentsToggle() {
    const toggle = document.querySelector('.comments-toggle');
    const commentsList = document.querySelector('.comments-list');
    
    if (!toggle || !commentsList) return;
    
    // 从localStorage获取状态
    const isOpen = localStorage.getItem('commentsListOpen') === 'true';
    
    // 初始化状态
    if (isOpen) {
        toggle.classList.add('active');
        toggle.querySelector('span').textContent = '收起评论列表';
        commentsList.classList.add('show');
    }
    
    toggle.addEventListener('click', () => {
        const isActive = toggle.classList.toggle('active');
        toggle.querySelector('span').textContent = isActive ? '收起评论列表' : '查看评论列表';
        commentsList.classList.toggle('show');
        
        // 保存状态到localStorage
        localStorage.setItem('commentsListOpen', isActive);
    });
}

document.addEventListener("DOMContentLoaded", () => {
    initCommentReply();
    initCommentToolbar();
    initCommentsToggle();
});