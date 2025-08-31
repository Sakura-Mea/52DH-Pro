<?php
require('../includes/common.php');
require('../includes/lang.class.php');

$act = _get('act');
if ($act == 'login') {
    $user     = _post('user');
    $password = _post('password') ? hash('sha256', _post('password')) : '';
    @header('Content-Type: application/json; charset=UTF-8');
    if (empty($user)) {
        exit('{"code":-1,"msg":"用户名不能为空！"}');
    }
    if (empty($password)) {
        exit('{"code":-1,"msg":"密码不能为空！"}');
    }
    if (_post('remember')) {
        // 有效期30天
        $expire = time() + 3600 * 24 * 30;
    } else {
        // 有效期24小时
        $expire = time() + 3600 * 24;
    }
    if ($user == $conf['admin_user'] && $password == $conf['admin_pwd']) {
        $session = md5($user . $password . $password_hash);
        $token = authcode("{$user}\t{$session}", 'ENCODE', SYS_KEY);
        setcookie("admin_token", $token, $expire);
        exit('{"code":0,"msg":"登录成功！"}');
    } elseif ($user != $conf['admin_user'] || $password != $conf['admin_pwd']) {
        exit('{"code":-1,"msg":"用户名或密码不正确！"}');
    }
    exit('{"code":-4,"msg":"No Act"}');
}
?>
<html>
<head>
    <title>我爱导航系统管理中心</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" href="../favicon.ico" />
    <link rel="stylesheet" href="<?php echo $site_cdnpublic; ?>twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/css/admin.css" />
    <style>
        /* 全局样式 */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            /* 自定义背景图片 */
            background-image: url(../assets/images/beijing.jpg);
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px 0;
        }
        
        /* 登录容器样式 */
        .login-page {
            margin-top: 8%;
        }
        
        .login-container {
            background: rgba(255, 255, 255, 0.85);
            /* 磨玻璃效果 */
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 30px 40px;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
        
        /* 标题样式 */
        .login-title {
            color: #165DFF;
            text-align: center;
            margin-bottom: 25px;
            font-weight: 600;
            font-size: 24px;
        }
        
        /* 表单元素样式 */
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #E1E5EB;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
            background-color: rgba(255, 255, 255, 0.9);
        }
        
        .form-control:focus {
            border-color: #165DFF;
            box-shadow: 0 0 0 3px rgba(22, 93, 255, 0.1);
            outline: none;
        }
        
        /* 复选框样式 */
        #remember-my-information {
            margin-right: 8px;
        }
        
        label[for="remember-my-information"] {
            color: #666;
            font-size: 13px;
            cursor: pointer;
        }
        
        /* 按钮样式 */
        .btn-primary {
            background-color: #165DFF;
            border-color: #165DFF;
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background-color: #0E42D2;
            border-color: #0E42D2;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(22, 93, 255, 0.25);
        }
        
        .btn-primary:active {
            transform: translateY(0);
        }
        
        /* 链接样式 */
        .nav-links {
            text-align: center;
            margin-top: 15px;
        }
        
        .nav-links a {
            color: #165DFF;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease;
        }
        
        .nav-links a:hover {
            color: #0E42D2;
            text-decoration: underline;
        }
        
        /* 页脚样式 */
        .login-footer {
            margin-top: 30px;
            text-align: center;
            color: rgba(255, 255, 255, 0.8);
        }
        
        .login-footer p {
            margin-bottom: 5px;
            font-size: 13px;
        }
        
        .login-footer a {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
        }
        
        .login-footer a:hover {
            color: white;
            text-decoration: underline;
        }
        
        /* 响应式调整 */
        @media (max-width: 768px) {
            .login-container {
                padding: 25px 20px;
            }
            
            .login-page {
                margin-top: 20%;
            }
        }
    </style>
</head>

<body>
    <div class="container login-page">
        <div class="row">
            <div class="col-md-offset-4 col-md-4 col-sm-offset-3 col-sm-6">
                <div class="login-container">
                    <form id="form-login" onsubmit="return loginSubmit()" method="post">
                        <h3 class="login-title">我爱导航系统管理中心</h3>
                        <hr style="border-color: rgba(0,0,0,0.05); margin-bottom: 25px;"/>
                        
                        <div class="form-group">
                            <label class="form-label required">用户名</label>
                            <input type="text" name="user" class="form-control" placeholder="请输入用户名">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label required">密码</label>
                            <input type="password" name="password" class="form-control" placeholder="请输入密码">
                        </div>
                        
                        <div class="form-group">
                            <input type="checkbox" name="remember" value="1" id="remember-my-information">
                            <label for="remember-my-information">记住账号</label>
                        </div>
                        
                        <button class="btn btn-primary" name="login">登录</button>
                    </form>
                    
                    <div class="nav-links">
                        <a href="resetpwd.php">忘记密码</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="login-footer">
        <p>Copyright &copy; 我爱导航. All Rights Reserved.</p>
        <p>Powered by <a href="https://crogram.com" target="_blank">CROGRAM</a></p>
    </div>

    <script src="<?php echo $site_cdnpublic; ?>jquery/1.12.4/jquery.min.js"></script>
    <script src="<?php echo $site_cdnpublic; ?>twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="<?php echo $site_cdnpublic; ?>layer/3.1.1/layer.js"></script>

    <script>
        function loginSubmit() {
            if (!$('input[name="user"]').val()) {
                layer.alert('请输入用户名！', { icon: 2 });
                return false;
            }
            if (!$('input[name="password"]').val()) {
                layer.alert('请输入密码！', { icon: 2 });
                return false;
            }
            var ii = layer.load(2);
            $.ajax({
                type: 'POST',
                url: 'login.php?act=login',
                data: $("#form-login").serialize(),
                dataType: 'json',
                success: function(data) {
                    layer.close(ii);
                    if (data.code == 0) {
                        $('[name="login"]').addClass('btn-success');
                        $('[name="login"]').text('登录成功，跳转中...');
                        $('[name="login"]').attr('disabled', true);
                        layer.msg(data.msg || '登录成功', {
                            time: 500,
                            end: function () {
                                window.location.assign('index.php');
                            }
                        });
                    } else {
                        layer.alert(data.msg, {
                            icon: 2
                        });
                    }
                },
                error: function(data) {
                    layer.close(ii);
                    layer.msg(data.msg || '服务器错误');
                }
            });
            return false;
        }
    </script>
</body>

</html>