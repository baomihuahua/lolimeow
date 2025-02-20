<?php
/**
 * @link https://www.boxmoe.com
 * @package lolimeow
 */

//boxmoe.com===安全设置=阻止直接访问主题文件
if(!defined('ABSPATH')){
    echo'Look your sister';
    exit;
}
if(get_boxmoe('boxmoe_smtp_mail_switch')){
    // 添加管理菜单
    add_action('admin_menu', 'boxmoe_smtp_menu');
    
    // 添加SMTP设置菜单
    function boxmoe_smtp_menu() {
        add_menu_page(
            'SMTP设置', 
            'SMTP设置', 
            'manage_options', 
            'boxmoe-smtp-settings', 
            'boxmoe_smtp_settings_page',
            'dashicons-email',
            100
        );

    }
    
    // SMTP设置页面内容
    function boxmoe_smtp_settings_page() {
        if(isset($_POST['boxmoe_smtp_save'])) {
            update_option('boxmoe_smtp_host', sanitize_text_field($_POST['smtp_host']));
            update_option('boxmoe_smtp_port', sanitize_text_field($_POST['smtp_port']));
            update_option('boxmoe_smtp_user', sanitize_text_field($_POST['smtp_user']));
            update_option('boxmoe_smtp_pass', sanitize_text_field($_POST['smtp_pass']));
            update_option('boxmoe_smtp_from', sanitize_text_field($_POST['smtp_from']));
            update_option('boxmoe_smtp_name', sanitize_text_field($_POST['smtp_name']));
            echo '<div class="updated"><p>设置已保存！</p></div>';
        }

        // 添加测试邮件发送功能
        if(isset($_POST['boxmoe_smtp_test'])) {
            $to = sanitize_email($_POST['test_email']);
            $subject = '测试邮件 - ' . get_bloginfo('name');
            $message = '这是一封测试邮件，如果您收到这封邮件，说明SMTP配置正确。';
            $headers = array('Content-Type: text/html; charset=UTF-8');
            
            $result = wp_mail($to, $subject, $message, $headers);
            
            if($result) {
                echo '<div class="updated"><p>测试邮件发送成功！请检查收件箱。</p></div>';
            } else {
                echo '<div class="error"><p>测试邮件发送失败，请检查SMTP配置。</p></div>';
            }
        }
        ?>
        <div class="wrap">
            <h2>SMTP邮件设置</h2>
            <form method="post">
                <table class="form-table">
                    <tr>
                        <th>SMTP服务器</th>
                        <td><input type="text" name="smtp_host" value="<?php echo esc_attr(get_option('boxmoe_smtp_host')); ?>" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th>SMTP端口</th>
                        <td><input type="text" name="smtp_port" value="<?php echo esc_attr(get_option('boxmoe_smtp_port')); ?>" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th>邮箱账号</th>
                        <td><input type="text" name="smtp_user" value="<?php echo esc_attr(get_option('boxmoe_smtp_user')); ?>" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th>邮箱密码</th>
                        <td><input type="password" name="smtp_pass" value="<?php echo esc_attr(get_option('boxmoe_smtp_pass')); ?>" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th>发件人邮箱</th>
                        <td><input type="text" name="smtp_from" value="<?php echo esc_attr(get_option('boxmoe_smtp_from')); ?>" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th>发件人名称</th>
                        <td><input type="text" name="smtp_name" value="<?php echo esc_attr(get_option('boxmoe_smtp_name')); ?>" class="regular-text"></td>
                    </tr>
                </table>
                <p class="submit">
                    <input type="submit" name="boxmoe_smtp_save" class="button-primary" value="保存设置">
                </p>
            </form>

            <!-- 添加测试邮件表单 -->
            <h3>测试邮件发送</h3>
            <form method="post">
                <table class="form-table">
                    <tr>
                        <th>测试收件邮箱</th>
                        <td>
                            <input type="email" name="test_email" class="regular-text" required>
                            <p class="description">请输入用于测试的收件邮箱地址</p>
                        </td>
                    </tr>
                </table>
                <p class="submit">
                    <input type="submit" name="boxmoe_smtp_test" class="button-secondary" value="发送测试邮件">
                </p>
            </form>
        </div>
        <?php
    }
    
    // 配置WordPress邮件发送
    add_action('phpmailer_init', 'boxmoe_smtp_config');
    function boxmoe_smtp_config($phpmailer) {
        $phpmailer->isSMTP();
        $phpmailer->Host = get_option('boxmoe_smtp_host');
        $phpmailer->SMTPAuth = true;
        $phpmailer->Port = get_option('boxmoe_smtp_port');
        $phpmailer->Username = get_option('boxmoe_smtp_user');
        $phpmailer->Password = get_option('boxmoe_smtp_pass');
        $phpmailer->From = get_option('boxmoe_smtp_from');
        $phpmailer->FromName = get_option('boxmoe_smtp_name');
        $phpmailer->SMTPSecure = 'ssl';
    }
}
