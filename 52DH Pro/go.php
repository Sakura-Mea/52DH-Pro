<?php
$t_url = $_GET['url'];
if (!empty($t_url)) {
    preg_match('/(http|https):\/\//', $t_url, $matches);
    if ($matches) {
        $url = $t_url;
        $title = '页面跳转中，请稍候……';
    } else {
        preg_match('/\./i', $t_url, $matche);
        if ($matche) {
            $url = 'http://' . $t_url;
            $title = '页面跳转中，请稍候……';
        } else {
            $url = '../';
            $title = '链接错误，正在返回……';
        }
    }
} else {
    $title = '链接错误，正在返回……';
    $url = '../';
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
    <meta http-equiv="refresh" content="5;url='<?php echo $url; ?>';">
    <title><?php echo $title; ?></title>
    <style type="text/css">
        /* 基础样式重置 */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            width: 100%;
            height: 100%;
            font-family: 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
            overflow: hidden;
        }

        /* 背景渐变与装饰 */
        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: rgba(79, 70, 229, 0.1);
            filter: blur(80px);
            top: -150px;
            left: -150px;
            z-index: 0;
        }

        body::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: rgba(30, 41, 59, 0.3);
            filter: blur(100px);
            bottom: -200px;
            right: -200px;
            z-index: 0;
        }

        /* 容器样式 */
        .container {
            text-align: center;
            padding: 2rem;
            border-radius: 16px;
            background: rgba(30, 41, 59, 0.5);
            backdrop-filter: blur(10px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            max-width: 90%;
            width: 500px;
            position: relative;
            z-index: 1;
        }

        /* Logo样式 */
        .logo {
            margin-bottom: 2rem;
        }

        .logo img {
            height: 60px;
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));
            transition: transform 0.3s ease;
        }

        .logo img:hover {
            transform: scale(1.05);
        }

        /* 动画元素容器 */
        .animation-container {
            margin-bottom: 2rem;
            position: relative;
            height: 150px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* 加载动画 */
        .pulse-loader {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: rgba(79, 70, 229, 0.2);
            position: relative;
            animation: pulse 2s infinite;
        }

        .pulse-loader::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: rgba(79, 70, 229, 0.4);
            animation: pulse-inner 2s infinite;
        }

        .pulse-loader::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(79, 70, 229, 0.6);
        }

        @keyframes pulse {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(79, 70, 229, 0.7);
            }
            70% {
                transform: scale(1);
                box-shadow: 0 0 0 15px rgba(79, 70, 229, 0);
            }
            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(79, 70, 229, 0);
            }
        }

        @keyframes pulse-inner {
            0% { transform: translate(-50%, -50%) scale(0.9); }
            50% { transform: translate(-50%, -50%) scale(1.1); }
            100% { transform: translate(-50%, -50%) scale(0.9); }
        }

        /* 文本样式 */
        .message {
            margin-bottom: 1.5rem;
        }

        .message h1 {
            color: #e2e8f0;
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .message p {
            color: #94a3b8;
            font-size: 1rem;
        }

        /* 倒计时进度条 */
        .progress-container {
            width: 100%;
            height: 4px;
            background: rgba(148, 163, 184, 0.2);
            border-radius: 2px;
            overflow: hidden;
            margin-bottom: 1.5rem;
        }

        .progress-bar {
            height: 100%;
            background: linear-gradient(90deg, #6366f1, #8b5cf6);
            width: 100%;
            border-radius: 2px;
            animation: progress 5s linear forwards; /* 进度条动画改为5秒 */
        }

        @keyframes progress {
            0% { width: 100%; }
            100% { width: 0; }
        }

        /* 跳转按钮 */
        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
        }

        .btn {
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            border: none;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 0.9rem;
        }

        .btn-primary {
            background: #ff7f00; /* 使用系统主色调橙色突出立即跳转按钮 */
            color: white;
            box-shadow: 0 4px 6px rgba(255, 127, 0, 0.3);
            padding: 0.7rem 2rem; /* 加大立即跳转按钮尺寸 */
            font-size: 1rem;
        }

        .btn-primary:hover {
            background: #e67300;
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(255, 127, 0, 0.4);
        }

        .btn-secondary {
            background: rgba(148, 163, 184, 0.2);
            color: #e2e8f0;
        }

        .btn-secondary:hover {
            background: rgba(148, 163, 184, 0.3);
            transform: translateY(-2px);
        }

        /* 页脚信息 */
        .footer {
            position: absolute;
            bottom: 1rem;
            color: #94a3b8;
            font-size: 0.8rem;
            z-index: 1;
        }

        .footer a {
            color: #94a3b8;
            text-decoration: none;
            transition: color 0.2s;
        }

        .footer a:hover {
            color: #e2e8f0;
        }

        /* 响应式调整 */
        @media (max-width: 480px) {
            .container {
                padding: 1.5rem;
            }

            .message h1 {
                font-size: 1.2rem;
            }

            .btn {
                padding: 0.5rem 1rem;
                font-size: 0.8rem;
            }
            
            .btn-primary {
                padding: 0.6rem 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- 网站Logo -->
        <div class="logo">
            <img src="../assets/images/logo.png" alt="我爱导航">
        </div>

        <!-- 加载动画 -->
        <div class="animation-container">
            <div class="pulse-loader"></div>
        </div>

        <!-- 提示信息 -->
        <div class="message">
            <h1><?php echo $title; ?></h1>
            <p>将在 <span id="countdown">5</span> 秒后自动跳转，若未跳转请点击下方按钮</p>
        </div>

        <!-- 倒计时进度条 -->
        <div class="progress-container">
            <div class="progress-bar"></div>
        </div>

        <!-- 操作按钮 -->
        <div class="action-buttons">
            <a href="<?php echo $url; ?>" class="btn btn-primary">立即跳转</a> <!-- 明确标注立即跳转 -->
            <a href="../" class="btn btn-secondary">返回首页</a>
        </div>
    </div>

    <!-- 页脚信息 -->
    <div class="footer">
        我爱导航 © 2025 | <a href="./about.php">关于我们</a>
    </div>

    <script>
        // 倒计时功能改为5秒
        let countdown = 5;
        const countdownEl = document.getElementById('countdown');
        const countdownInterval = setInterval(() => {
            countdown--;
            countdownEl.textContent = countdown;
            if (countdown <= 0) {
                clearInterval(countdownInterval);
            }
        }, 1000);
    </script>
</body>
</html>