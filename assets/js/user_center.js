document.addEventListener('DOMContentLoaded', function() {

    const profileForm = document.getElementById('profileUpdateForm');
    if (profileForm) {
        profileForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const submitButton = this.querySelector('#profileUpdateButton');
            const originalButtonText = submitButton.innerHTML;
            
            // 表单验证
            if (!this.checkValidity()) {
                e.stopPropagation();
                this.classList.add('was-validated');
                return;
            }

            submitButton.disabled = true;
            submitButton.innerHTML = `
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                保存中...
            `;

            const formData = new FormData();
            formData.append('action', 'update_user_profile');
            formData.append('display_name', document.getElementById('display_name').value);
            formData.append('user_url', document.getElementById('user_url').value);
            formData.append('description', document.getElementById('user_description').value);
            formData.append('nonce', ajax_object.nonce);

            try {
                const response = await fetch(ajax_object.ajaxurl, {
                    method: 'POST',
                    body: formData,
                    credentials: 'same-origin'
                });

                const data = await response.json();

                if (data.success) {
                    showToast(data.data.message);
                } else {
                    showToast(data.data.message, false);
                }
            } catch (error) {
                showToast('保存失败，请重试', false);
            } finally {
                submitButton.disabled = false;
                submitButton.innerHTML = originalButtonText;
            }
        });
    }

    // 密码更新表单处理
    const passwordForm = document.getElementById('passwordUpdateForm');
    if (passwordForm) {
        passwordForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const submitButton = this.querySelector('#passwordUpdateButton');
            const originalButtonText = submitButton.innerHTML;
            
            // 表单验证
            if (!this.checkValidity()) {
                e.stopPropagation();
                this.classList.add('was-validated');
                return;
            }

            // 获取密码输入
            const oldPassword = document.getElementById('securityOldPasswordInput').value;
            const newPassword = document.getElementById('securityNewPasswordInput').value;
            const confirmPassword = document.getElementById('securityConfirmPasswordInput').value;

            // 验证新密码匹配
            if (newPassword !== confirmPassword) {
                showToast('新密码与确认密码不匹配', false);
                return;
            }

            // 验证新密码长度
            if (newPassword.length < 6) {
                showToast('新密码长度至少需要6个字符', false);
                return;
            }

            submitButton.disabled = true;
            submitButton.innerHTML = `
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                保存中...
            `;

            const formData = new FormData();
            formData.append('action', 'update_user_password');
            formData.append('old_password', oldPassword);
            formData.append('new_password', newPassword);
            formData.append('confirm_password', confirmPassword);
            formData.append('nonce', ajax_object.nonce);

            try {
                const response = await fetch(ajax_object.ajaxurl, {
                    method: 'POST',
                    body: formData,
                    credentials: 'same-origin'
                });

                const data = await response.json();

                if (data.success) {
                    showToast(data.data.message);
                    this.reset();
                    this.classList.remove('was-validated');
                } else {
                    showToast(data.data.message, false);
                }
            } catch (error) {
                showToast('保存失败，请重试', false);
            } finally {
                submitButton.disabled = false;
                submitButton.innerHTML = originalButtonText;
            }
        });
    }

    // 头像上传处理
    const avatarForm = document.getElementById('avatarForm');
    const avatarInput = document.getElementById('avatarInput');
    const uploadButton = document.getElementById('uploadAvatarButton');

    if (avatarForm && avatarInput && uploadButton) {
        uploadButton.addEventListener('click', (e) => {
            e.preventDefault();
            avatarInput.click();
        });

        avatarInput.addEventListener('change', async (e) => {
            if (!e.target.files.length) return;

            const file = e.target.files[0];
            if (file.size > 1024 * 1024) {
                showToast('文件大小不能超过1MB', false);
                return;
            }

            const originalButtonText = uploadButton.innerHTML;
            uploadButton.disabled = true;
            uploadButton.innerHTML = `
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                上传中...
            `;

            const formData = new FormData();
            formData.append('action', 'upload_avatar');
            formData.append('avatar', file);
            formData.append('nonce', ajax_object.nonce);

            try {
                const response = await fetch(ajax_object.ajaxurl, {
                    method: 'POST',
                    body: formData,
                    credentials: 'same-origin'
                });

                const data = await response.json();

                if (data.success) {
                    showToast(data.data.message);
                    // 可以在这里添加刷新头像显示的代码
                    location.reload(); // 或者更新特定的头像元素
                } else {
                    showToast(data.data.message, false);
                }
            } catch (error) {
                showToast('上传失败，请重试', false);
            } finally {
                uploadButton.disabled = false;
                uploadButton.innerHTML = originalButtonText;
                avatarInput.value = '';
            }
        });
    }

    // 处理删除收藏
    const deleteFavoriteButtons = document.querySelectorAll('.delete-favorite');
    if (deleteFavoriteButtons.length) {
        // 添加模态框到页面
        document.body.insertAdjacentHTML('beforeend', `
            <div class="modal fade" id="confirmDeleteModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">确认取消收藏</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>确定要取消这个收藏吗？</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                            <button type="button" class="btn btn-danger" id="confirmDelete">确定删除</button>
                        </div>
                    </div>
                </div>
            </div>
        `);

        const confirmModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
        let currentPostId = null;
        let currentRow = null;

        deleteFavoriteButtons.forEach(button => {
            button.addEventListener('click', function() {
                currentPostId = this.dataset.postId;
                currentRow = this.closest('tr');
                confirmModal.show();
            });
        });

        document.getElementById('confirmDelete').addEventListener('click', async function() {
            confirmModal.hide();
            
            const formData = new FormData();
            formData.append('action', 'delete_favorite');
            formData.append('post_id', currentPostId);
            formData.append('nonce', ajax_object.nonce);

            try {
                const response = await fetch(ajax_object.ajaxurl, {
                    method: 'POST',
                    body: formData,
                    credentials: 'same-origin'
                });

                const data = await response.json();

                if (data.success) {
                    showToast(data.data.message);
                    currentRow.remove();
                                        const tbody = document.querySelector('tbody');
                    if (tbody.querySelectorAll('tr').length === 0) {
                        tbody.innerHTML = `
                            <tr>
                                <td colspan="3" class="text-center">
                                    <span>没有收藏</span>
                                </td>
                            </tr>
                        `;
                    }
                } else {
                    showToast(data.data.message, false);
                }
            } catch (error) {
                showToast('操作失败，请重试', false);
            }
        });
    }

    // 卡密充值表单处理
    const cardForm = document.getElementById('card-form');
    if (cardForm) {
        cardForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData();
            formData.append('action', 'boxmoe_form_money_card');
            formData.append('epdcardnum', document.getElementById('epdcardnum').value);
            formData.append('epdcardpass', document.getElementById('epdcardpass').value);

            try {
                const response = await fetch(ajax_object.ajaxurl, {
                    method: 'POST',
                    body: formData,
                    credentials: 'same-origin'
                });

                const data = await response.json();

                if (data.success) {
                    showToast(data.data.message);
                    this.reset(); // 重置表单
                } else {
                    showToast(data.data.message, false);
                }
            } catch (error) {
                showToast('请求失败，请稍后重试', false);
            }
        });
    }

    // 在线充值表单处理
    const onlineForm = document.getElementById('online-form');
    if (onlineForm) {
        onlineForm.addEventListener('submit', function(event) {
            event.preventDefault();

            // 获取 ice_money 的值
            const iceMoneyInput = document.querySelector('input[name="ice_money"]');
            const iceMoney = iceMoneyInput.value;
            
            // 验证 ice_money 是否是有效的数字
            if (!iceMoney || isNaN(iceMoney) || parseFloat(iceMoney) <= 0) {
                showToast('请填写一个有效的正数金额', false);
                return;
            }

            const formData = new FormData();
            formData.append('action', 'boxmoe_form_money_online');
            formData.append('paytype', document.querySelector('select[name="paytype"]').value);
            formData.append('ice_money', iceMoney);

            fetch(ajax_object.ajaxurl, {
                method: 'POST',
                body: formData,
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.open(data.data.url, '_blank');
                } else {
                    showToast(data.data, false);
                }
            })
            .catch(error => {
                showToast('提交失败，请稍后重试', false);
                console.error('Error:', error);
            });
        });
    }

    // 签到功能
    const checkinButton = document.getElementById('boxmoe-checkin-today');
    if (checkinButton) {
        checkinButton.addEventListener('click', async function(e) {
            e.preventDefault();
            
            if (!this.classList.contains('disabled')) {
                this.classList.add('disabled');
                
                if (!this.classList.contains('active')) {
                    this.textContent = '签到中...';
                    
                    const formData = new FormData();
                    formData.append('action', 'epd_checkin');
                    
                    try {
                        const response = await fetch(ajax_object.ajaxurl, {
                            method: 'POST',
                            body: formData,
                            credentials: 'same-origin'
                        });
                        
                        const result = await response.json();
                        
                        if (result.status == 200) {
                            this.classList.add('active');
                            this.textContent = '签到成功';
                            showToast('签到成功');
                        } else {
                            this.textContent = '今日签到';
                            showToast(result.msg, false);
                        }
                    } catch (error) {
                        this.textContent = '今日签到';
                        showToast('签到失败，请重试', false);
                    }
                }
            }
        });
    }

    // 添加确认升级会员的模态框到页面
    document.body.insertAdjacentHTML('beforeend', `
        <div class="modal fade" id="confirmVIPModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">确认升级会员</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>你确定要进行会员升级吗？</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                        <button type="button" class="btn btn-primary" id="confirmVIPUpgrade">确定升级</button>
                    </div>
                </div>
            </div>
        </div>
    `);

    // 初始化模态框
    const confirmVIPModal = new bootstrap.Modal(document.getElementById('confirmVIPModal'));
    let selectedVipLevel = null;
    
    // 监听VIP升级按钮点击事件
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('btn-upgrade')) {
            event.preventDefault();
            selectedVipLevel = event.target.getAttribute('data-level');
            confirmVIPModal.show();
        }
    });

    // 监听确认升级按钮点击事件
    document.getElementById('confirmVIPUpgrade').addEventListener('click', async function() {
        if (!selectedVipLevel) {
            showToast('请选择要升级的会员类型', false);
            return;
        }

        // 禁用确认按钮并显示加载状态
        const confirmButton = this;
        const originalText = confirmButton.textContent;
        confirmButton.disabled = true;
        confirmButton.innerHTML = `
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            处理中...
        `;

        const formData = new FormData();
        formData.append('action', 'upgrade_vip');
        formData.append('userType', selectedVipLevel);
        formData.append('nonce', ajax_object.nonce);

        try {
            const response = await fetch(ajax_object.ajaxurl, {
                method: 'POST',
                body: formData,
                credentials: 'same-origin'
            });

            const data = await response.json();

            if (data.success) {
                showToast(data.data.message);
                confirmVIPModal.hide();
                // 可选：成功后刷新页面或更新UI
                setTimeout(() => {
                    if (document.referrer) {
                        window.location.href = document.referrer;
                    } else {
                        window.location.href = '/';
                    }
                }, 1000);
            } else {
                showToast(data.data.message || '升级失败，请重试', false);
            }
        } catch (error) {
            showToast('请求失败，请稍后重试', false);
            console.error('Error:', error);
        } finally {
            // 恢复按钮状态
            confirmButton.disabled = false;
            confirmButton.textContent = originalText;
        }
    });


});
