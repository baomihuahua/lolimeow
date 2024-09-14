jQuery(document).ready(function($) {
    $(document).on("pjax:complete", function () {
        userjs();
      });
var userjs = function () {  
    $("#doprofile").click(function(event) {
        var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/;
        if ($("#mm_name").val().trim().length == 0) {
         Swal.fire('Oops...','请输入昵称', 'error');
        } else if ($("#mm_name").val().trim().length < 4) {
         Swal.fire('Oops...','昵称长度至少为4位', 'error');
        } else if (!reg.test($("#mm_mail").val().trim())) {
         Swal.fire('Oops...','请输入正确邮箱，以免忘记密码时无找回', 'error');
        } else {
            $("#doprofile").val("保存信息中...");
            $.ajax({
                type: "post",
                //async: false,
                url: erpurl,
                data: "do=profile&mm_name=" + $("#mm_name").val() + "&mm_mail=" + $("#mm_mail").val() + "&mm_url=" + $("#mm_url").val() + "&mm_desc=" + $("#mm_desc").val(),
                //contentType: "application/json; charset=utf-8",
                dataType: "text",
                success: function(data) {
                  Swal.fire('WoW','信息已经完成更新', 'success');
                $("#doprofile").val("保存设置");
                },
                error: function() {
                  Swal.fire('Oops...','抱歉修改失败', 'error');
                    $("#doprofile").val("保存设置");
                }
            });
        }
    });

    $('#card-form').on('submit', function(e) {
        e.preventDefault(); 
        var data = {
            action: 'boxmoe_form_money_card', 
            epdcardnum: $('#epdcardnum').val(),
            epdcardpass: $('#epdcardpass').val(),
        };
        $.ajax({
            url: ajaxurl, 
            type: 'POST',
            data: data,
            success: function(response) {
                if (response.success) {
                  Swal.fire('成功',response.data.message, 'success');
                } else {
                  Swal.fire('Sorry',response.data.message, 'error');
                }
            },
            error: function() {
                alert('请求失败，请稍后重试');
            }
        });
    });
$('#online-form').on('submit', function(event) {
    event.preventDefault();

    // 获取 ice_money 的值
    var ice_money = $('input[name="ice_money"]').val();
    
    // 验证 ice_money 是否是有效的数字
    if (!ice_money || isNaN(ice_money) || parseFloat(ice_money) <= 0) {
        // 使用 SweetAlert 提示用户
        Swal.fire({
            title: "输入错误",
            text: "请填写一个有效的正数金额。",
            icon: "warning",
            button: "确定"
        });
        return; // 不执行 AJAX 请求
    }

    $.ajax({
        url: ajaxurl,
        type: 'POST',
        data: {
            action: 'boxmoe_form_money_online',
            paytype: $('select[name="paytype"]').val(),
            ice_money: ice_money
        },
        success: function(response) {
            if (response.success) {
                window.open(response.data.url, '_blank');
            } else {
                Swal.fire({
                    title: "失败",
                    text: '提交失败: ' + response.data,
                    icon: "error",
                    button: "确定"
                });
            }
        },
        error: function(xhr, status, error) {
            Swal.fire({
                title: "错误",
                text: '提交失败!',
                icon: "error",
                button: "确定"
            });
            console.log(xhr.responseText);
        }
    });
});
$("body").on("click", ".boxmoe-checkin", function(){
    var that = $(this);
    if(!that.hasClass("disabled")){
        that.addClass("disabled");
        if(!that.hasClass("active")){
            that.text("签到中...");
            $.post(ajaxurl, {
                "action": "epd_checkin"
            }, function(result) {
                
                if( result.status == 200 ){
                    that.addClass("active").text("签到成功");
                    Swal.fire('Wow！','签到成功', 'success');
                }else{
                    that.text("今日签到");
                    Swal.fire('Wow！',result.msg, 'error');
                }
            }, 'json'); 
        }
    }
    return false;
});

$('#avatar-upload').on('change', function() {
    var fileInput = $('#avatar-upload')[0];
    var file = fileInput.files[0];
    if (!file) {
        alert('请先选择一个文件');
        return;
    }
    var formData = new FormData();
    formData.append('file', file);
    formData.append('action', 'upload_avatar');
    $('#avatar-preview').find('.avatar').addClass('spinner-border');
    $.ajax({
        url: posturl,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
           if (response.success) {
                       $('#avatar-preview').find('.avatar').removeClass('spinner-border');
                       $('#avatar-preview').find('img').remove();
                       $('#avatar-preview').html(response.data.url);
                       Swal.fire({
                        title: '成功',
                        text: '头像上传成功，已更新',
                        icon: 'success',
                        buttons: {
                            confirm: '确定'
                        },
                        dangerMode: false,
                    }).then((willRefresh) => {
                        if (willRefresh) {
                            location.reload(); // 刷新网页
                        }
                    });
                    } else {
                       Swal.fire('Oops...',response.data.message, 'error');
                       $('#avatar-preview').find('.avatar').removeClass('spinner-border');
                    }
                },
                error: function(xhr, status, error) {
                    alert('上传失败，请重试。');
                    $('#avatar-preview').find('.avatar').removeClass('spinner-border');
                }
           });
     });

     $("body").on("click", "#VIPSubmit", function(){    
        event.preventDefault();

        Swal.fire({
            title: '确认升级会员?',
            text: "你确定要进行会员升级吗？",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '确定',
            cancelButtonText: '取消'
        }).then((result) => {
            if (result.isConfirmed) {
                // 直接提交表单
                document.getElementById('vipform').submit();
            }
        });
    });

    $('#change-password-form').on('submit', function(event) {
        event.preventDefault();

        var currentPassword = $('#current_password').val();
        var newPassword = $('#new_password').val();
        var confirmPassword = $('#confirm_password').val();
        


        var passwordStrengthRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/;
        if (!passwordStrengthRegex.test(newPassword)) {
            Swal.fire('错误', '密码必须至少8个字符长，并包含至少一个大写字母、一个小写字母和一个数字', 'error');
            return;
        }

        if (newPassword !== confirmPassword) {
            Swal.fire('错误', '新密码与确认密码不一致', 'error');
            return;
        }

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'change_password',
                current_password: currentPassword,
                new_password: newPassword,
                confirm_password:confirmPassword
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire('成功', response.data.message, 'success');
                } else {
                    Swal.fire('错误', response.data.message, 'error');
                }
            },
            error: function() {
                Swal.fire('错误', '请求失败，请稍后再试', 'error');
            }
        });
    });


}
});