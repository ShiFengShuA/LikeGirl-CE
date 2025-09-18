<?php
session_start();
$file = $_SERVER['PHP_SELF'];
include_once 'connect.php';

// 开启错误报告
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 设置内容类型为纯文本
header('Content-Type: text/plain; charset=utf-8');

// 设置响应头，避免缓存
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

// 检查会话和权限
if (!isset($_SESSION['loginadmin']) || empty($_SESSION['loginadmin'])) {
    echo "0 - 未授权访问";
    exit;
}

// 检查请求方法
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo "0 - 非法请求方法";
    exit;
}

// 检查必需字段
if (!isset($_POST['imgDatd']) || !isset($_POST['imgText']) || !isset($_POST['imgUrl'])) {
    echo "0 - 缺少必需字段";
    exit;
}

// 获取并清理数据
$imgText = isset($_POST['imgText']) ? htmlspecialchars(trim($_POST['imgText']), ENT_QUOTES) : '';
$imgDatd = isset($_POST['imgDatd']) ? trim($_POST['imgDatd']) : '';
$imgUrl = isset($_POST['imgUrl']) ? htmlspecialchars(trim($_POST['imgUrl']), ENT_QUOTES) : '';

// 验证数据
if (empty($imgDatd) || empty($imgText) || empty($imgUrl)) {
    echo "0 - 字段不能为空";
    exit;
}

// 清理URL格式：去除多余空格，确保用分号分隔
$urls = array_map('trim', explode(';', $imgUrl));
$imgUrl = implode(';', array_filter($urls)); // 移除空值

// 防止SQL注入
$imgDatd = mysqli_real_escape_string($connect, $imgDatd);
$imgText = mysqli_real_escape_string($connect, $imgText);
$imgUrl = mysqli_real_escape_string($connect, $imgUrl);

// 检查数据库连接
if (!$connect) {
    echo "0 - 数据库连接失败";
    exit;
}

// 执行插入操作
$charu = "INSERT INTO loveImg (imgDatd, imgText, imgUrl) VALUES ('$imgDatd', '$imgText', '$imgUrl')";
$result = mysqli_query($connect, $charu);

if ($result) {
    echo "1";
} else {
    $error = mysqli_error($connect);
    error_log("SQL插入错误: " . $error);
    echo "0 - 数据库错误: " . $error;
}

// 关闭连接
mysqli_close($connect);
?>