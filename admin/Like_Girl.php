<?php
session_start();
include_once 'Nav.php';

$url = 'https://www.kikiw.cn/Love/likev5.php';
$lines_array = file($url);
$lines_string = implode('', $lines_array);

$userurl = 'https://www.kikiw.cn/Love/userLikeGirl.php';
$userarray = file($userurl);
$userstring = implode('', $userarray);

?>

<style>
    .btn-success {
        border-radius: 10px;
        border: 2px solid #fff;
    }

    .btn-success:hover {
        background-color: 0;
        border-color: 0;
        opacity: 0.7;
    }
    
    /* 社区版简介CSS */
    .info-card {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 25px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.5);
        position: relative;
        overflow: hidden;
    }
    
    .info-card::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.4) 0%, rgba(255,255,255,0) 60%);
        transform: rotate(30deg);
    }
    
    .info-card h4 {
        color: #4a5568;
        margin-bottom: 15px;
        font-weight: 600;
        border-bottom: 2px solid rgba(255, 255, 255, 0.7);
        padding-bottom: 10px;
    }
    
    .info-card p {
        color: #2d3748;
        margin-bottom: 12px;
        font-size: 15px;
        line-height: 1.5;
    }
    
    .info-card .highlight {
        background: linear-gradient(120deg, rgba(255,255,255,0.4) 0%, rgba(255,255,255,0) 80%);
        padding: 8px 12px;
        border-radius: 8px;
        margin: 10px 0;
        border-left: 3px solid #4299e1;
    }
    
    .info-card .download-info {
        background-color: rgba(255, 255, 255, 0.6);
        padding: 15px;
        border-radius: 10px;
        margin-top: 15px;
        position: relative;
    }
    
    .info-card .footer-note {
        text-align: center;
        margin-top: 20px;
        font-size: 13px;
        color: #718096;
        border-top: 1px solid rgba(255, 255, 255, 0.5);
        padding-top: 15px;
    }
    
    .version-identifier {
        background: linear-gradient(45deg, #ff6b6b, #ff9e7d);
        color: white;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        margin-left: 10px;
    }
    
    /* 前往按钮CSS */
    .link-button {
        display: inline-block;
        background: linear-gradient(45deg, #4facfe 0%, #00f2fe 100%);
        color: white;
        padding: 8px 16px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 500;
        margin-top: 10px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(50, 50, 93, 0.11), 0 1px 3px rgba(0, 0, 0, 0.08);
        margin-right: 10px;
    }
    
    .link-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 7px 14px rgba(50, 50, 93, 0.1), 0 3px 6px rgba(0, 0, 0, 0.08);
        color: white;
        text-decoration: none;
    }
    
    .link-button i {
        margin-right: 5px;
    }
    
    /* 反馈CSS */
    .feedback-button {
        display: inline-block;
        background: linear-gradient(45deg, #ff6b6b 0%, #ff9e7d 100%);
        color: white;
        padding: 8px 16px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 500;
        margin-top: 10px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(50, 50, 93, 0.11), 0 1px 3px rgba(0, 0, 0, 0.08);
    }
    
    .feedback-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 7px 14px rgba(50, 50, 93, 0.1), 0 3px 6px rgba(0, 0, 0, 0.08);
        color: white;
        text-decoration: none;
    }
    
    .feedback-button i {
        margin-right: 5px;
    }
    
    .button-group {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
</style>

<!-- 
 * @Version：Like Girl 5.2.1-Stable
 * @Author: Ki.
 * @Date: 2025-09-03 00:00:00
 * @LastEditTime: 2025-09-03
 * @Description: 愿得一心人 白头不相离
 * @Document：https://blog.kikiw.cn/index.php/archives/52/
 * @Copyright (c) 2023 - 2025 by Ki All Rights Reserved. 
 * @Warning：禁止以任何方式出售本项目 如有发现一切后果自行负责
 * @Warning：禁止以任何方式出售本项目 如有发现一切后果自行负责
 * @Warning：禁止以任何方式出售本项目 如有发现一切后果自行负责
 * @Message：开发不易 版权信息请保留 （删除/更改版权的无耻之人请勿使用 查到一个挂一个）
 * @Message：开发不易 版权信息请保留 （删除/更改版权的无耻之人请勿使用 查到一个挂一个）
 * @Message：开发不易 版权信息请保留 （删除/更改版权的无耻之人请勿使用 查到一个挂一个）
 * @Description: 本页面对前端无任何影响 请保留
 * @Description: 如更改后则无法获取最新版本内容等信息
 * @Description: 删除或更改本页信息 无法享用更新版本服务 请慎重考虑！
 -->

<div class="row">
    
    <!-- 社区版简介 -->
    <div class="col-md-12">
        <div class="info-card">
            <h4>Like Girl CE 情侣小站社区维护版 <span class="version-identifier">CE-1.0.0-Beta</span></h4>
            
            <p>基于LikeGirl v5.2.1版本维护以及二创更新</p>
            
            <div class="highlight">
                <strong>维护者联系方式/反馈：</strong><br>
                QQ: 3593853319<br>
                邮箱: shifengshua@outlook.com
            </div>
            
            <p>原项目作者: Ki.</p>
            
            <p>二创/社区版维护: ShiFengShuA (是枫书啊)</p>
            
            <p>本社区版项目完全免费，禁止以任何方式出售！</p>
            
            <div class="download-info">
                <strong>社区版GitHub下载：</strong><br>
                开源地址: https://github.com/ShiFengShuA/LikeGirl-CE<br>
                <div class="button-group">
                    <a href="https://github.com/ShiFengShuA/LikeGirl-CE" target="_blank" class="link-button">
                        <i class="fas fa-external-link-alt"></i>前往GitHub
                    </a>
                    <a href="https://github.com/ShiFengShuA/LikeGirl-CE/issues" target="_blank" class="feedback-button">
                        <i class="fas fa-comment-dots"></i>反馈
                    </a>
                </div>
            </div>
            
            <div class="download-info">
                <strong>社区版Gitee下载：</strong><br>
                开源地址: https://gitee.com/ShiFengShuA/LikeGirl-CE<br>
                <div class="button-group">
                    <a href="https://gitee.com/ShiFengShuA/LikeGirl-CE" target="_blank" class="link-button">
                        <i class="fas fa-external-link-alt"></i>前往Gitee
                    </a>
                    <a href="https://gitee.com/ShiFengShuA/LikeGirl-CE/issues" target="_blank" class="feedback-button">
                        <i class="fas fa-comment-dots"></i>反馈
                    </a>
                </div>
            </div>
            
            <div class="download-info">
                <strong>官方版Gitee下载：</strong><br>
                开源地址: https://gitee.com/kiCode111/likegirl-stable<br>
                <div class="button-group">
                    <a href="https://gitee.com/kiCode111/likegirl-stable" target="_blank" class="link-button">
                        <i class="fas fa-external-link-alt"></i>前往官方版
                    </a>
                </div>
            </div>
            
            <div class="footer-note">
                原项目地址: https://gitee.com/kiCode111/likegirl-stable
            </div>
            
            <div class="footer-note">
                下方内容为Like Girl v5.2.1原作者及官方版日志信息
            </div>
        </div>
    </div>
    
    
    <div class="col-sm-12">
        <?php echo ($userstring); ?>
    </div>
    
    <div class="col-md-12">
        <?php echo ($lines_string); ?>
    </div>

</div>


<?php
include_once 'Footer.php';
?>

</body>

</html>