<?php
session_start();
include_once 'Nav.php';

// 开启错误报告
error_reporting(E_ALL);
ini_set('display_errors', 1);

$id = $_GET['id'];
include_once 'connect.php';
$loveImg = "SELECT * FROM loveImg WHERE id=$id LIMIT 1";
$resImg = mysqli_query($connect, $loveImg);
$Imglist = mysqli_fetch_array($resImg);
?>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3 size_18">修改相册—— ID：<?php echo $Imglist['id'] ?></h4>

                <form class="needs-validation" id="editForm" method="post" novalidate>
                    <div class="form-group mb-3">
                        <label for="validationCustom01">日期</label>
                        <input class="form-control col-sm-4" id="example-date" type="date" name="imgDatd" class="form-control" placeholder="日期" value="<?php echo $Imglist['imgDatd'] ?>" required>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="validationCustom01">图片描述<span class="margin_left badge badge-success-lighten">尽量控制在25个字符以内 (数据库极限200字符)</span></label>
                        <input name="imgText" type="text" class="form-control" placeholder="请输入图片描述" value="<?php echo htmlspecialchars_decode($Imglist['imgText']) ?>" required>
                    </div>

                    <div class="form-group mb-3" id="img_url">
                        <label for="validationCustom01">图片URL（多个URL用分号;分隔）</label>
                        <textarea name="imgUrl" class="form-control" placeholder="请输入图片URL地址，多个URL用分号;分隔(可使用相对路径均,例如'./Style/img/Love-album/*****.png')" rows="3" required><?php echo htmlspecialchars_decode($Imglist['imgUrl']) ?></textarea>
                        <small class="form-text text-muted">每行一个URL或用分号;分隔多个URL(可使用相对路径均,例如'./Style/img/Love-album/*****.png')</small>
                    </div>
                    
                    <div class="form-group mb-3 text_right">
                        <input name="id" value="<?php echo $id ?>" type="hidden">
                        <button class="btn btn-primary" type="button" id="ImgUpdaPost">修改相册</button>
                        <div id="loadingSpinner" class="spinner-border text-primary ml-2" role="status" style="display: none;">
                            <span class="sr-only">加载中...</span>
                        </div>
                    </div>
                    
                    <div id="messageAlert" class="alert" role="alert" style="display: none;"></div>
                </form>

            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div> <!-- end col-->
</div>

<script>
    function check() {
        let title = document.getElementsByName('imgText')[0].value.trim();
        if (title.length == 0) {
            alert("描述不能为空");
            return false;
        }
        
        if (title.length > 25) {
            alert("描述长度尽量控制在25个字符以内(数据库极限200字符)");
            return false;
        }
        
        let imgUrl = document.getElementsByName('imgUrl')[0].value.trim();
        if (imgUrl.length == 0) {
            alert("图片URL不能为空");
            return false;
        }
        
        // 验证URL格式（基本验证）
        let urls = imgUrl.split(';').map(url => url.trim()).filter(url => url !== '');
        if (urls.length === 0) {
            alert("请输入有效的图片URL");
            return false;
        }
        
        for (let i = 0; i < urls.length; i++) {
            if (!isValidUrl(urls[i])) {
                alert("第" + (i + 1) + "个URL格式不正确: " + urls[i]);
                return false;
            }
        }
        
        return true;
    }
    
    function isValidUrl(string) {
        try {
            // 允许相对路径和绝对路径
            if (string.startsWith('/') || string.startsWith('./') || string.startsWith('../')) {
                return true;
            }
            
            // 检查是否是有效的URL
            new URL(string);
            return true;
        } catch (_) {
            return false;
        }
    }

    // AJAX提交表单
    document.addEventListener('DOMContentLoaded', function() {
        const updateButton = document.getElementById('ImgUpdaPost');
        const loadingSpinner = document.getElementById('loadingSpinner');
        const messageAlert = document.getElementById('messageAlert');
        
        if (updateButton) {
            updateButton.addEventListener('click', function() {
                if (check()) {
                    // 显示加载中
                    updateButton.disabled = true;
                    loadingSpinner.style.display = 'inline-block';
                    messageAlert.style.display = 'none';
                    
                    const form = document.getElementById('editForm');
                    const formData = new FormData(form);
                    
                    fetch('ImgUpdaPost.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => {
                        // 首先检查响应状态
                        if (!response.ok) {
                            throw new Error('网络响应不正常');
                        }
                        return response.text();
                    })
                    .then(data => {
                        console.log('服务器返回:', data); // 调试信息
                        
                        // 去除可能的空白字符
                        data = data.trim();
                        
                        if (data === '1') {
                            showAlert('修改成功！', 'success');
                        } else {
                            showAlert('修改失败，请重试！服务器返回: ' + data, 'danger');
                            updateButton.disabled = false;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showAlert('网络错误，请重试！', 'danger');
                        updateButton.disabled = false;
                    })
                    .finally(() => {
                        loadingSpinner.style.display = 'none';
                    });
                }
            });
        }
        
        function showAlert(message, type) {
            messageAlert.textContent = message;
            messageAlert.className = `alert alert-${type}`;
            messageAlert.style.display = 'block';
            
            // 5秒后自动隐藏提示
            setTimeout(() => {
                messageAlert.style.display = 'none';
            }, 5000);
        }
    });
</script>

<style>
    .spinner-border {
        width: 1.5rem;
        height: 1.5rem;
    }
    
    .ml-2 {
        margin-left: 0.5rem;
    }
</style>

<?php
include_once 'Footer.php';
?>