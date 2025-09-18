<?php
session_start();
$file = $_SERVER['PHP_SELF'];
include_once 'connect.php';

// 开启错误报告
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 设置内容类型为纯文本
header('Content-Type: text/plain; charset=utf-8');

if (isset($_SESSION['loginadmin']) && $_SESSION['loginadmin'] <> '') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // 检查必需字段
        if (!isset($_POST['id']) || !isset($_POST['imgDatd']) || !isset($_POST['imgText']) || !isset($_POST['imgUrl'])) {
            echo "0 - 缺少必需字段";
            exit;
        }
        
        $id = intval(trim($_POST['id']));
        $imgText = htmlspecialchars(trim($_POST['imgText']), ENT_QUOTES);
        $imgDatd = trim($_POST['imgDatd']);
        $imgUrl = htmlspecialchars(trim($_POST['imgUrl']), ENT_QUOTES);
        
        // 清理URL格式：去除多余空格，确保用分号分隔
        $urls = array_map('trim', explode(';', $imgUrl));
        $imgUrl = implode(';', array_filter($urls)); // 移除空值
        
        // 防止SQL注入
        $id = mysqli_real_escape_string($connect, $id);
        $imgDatd = mysqli_real_escape_string($connect, $imgDatd);
        $imgText = mysqli_real_escape_string($connect, $imgText);
        $imgUrl = mysqli_real_escape_string($connect, $imgUrl);
        
        $sql = "UPDATE loveImg SET imgText = '$imgText', imgDatd = '$imgDatd', imgUrl = '$imgUrl' WHERE id = '$id'";
        $result = mysqli_query($connect, $sql);
        
        if ($result) {
            echo "1";
        } else {
            echo "0 - " . mysqli_error($connect);
            error_log("SQL更新错误: " . mysqli_error($connect));
        }
    } else {
        echo "0 - 非法请求方法";
    }
} else {
    echo "0 - 未授权访问";
}
?>