<?php
// 获取表单提交的数据
$db_address   = $_POST['db_address']   ?? '';
$db_username  = $_POST['db_username']  ?? '';
$db_password  = $_POST['db_password']  ?? '';
$db_name      = $_POST['db_name']      ?? '';
$like_code    = $_POST['like_code']    ?? '';

// 写入配置文件
$config_path = dirname(__FILE__, 1) . '/../Config_DB.php';

$config_content = <<<PHP
<?php
/*
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
 */

header("Content-Type:text/html; charset=utf8");

//localhost 为数据库地址 一般使用默认的即可 或 (127.0.0.1)
\$db_address = "{$db_address}";

//数据库用户名
\$db_username = "{$db_username}";

//数据库密码
\$db_password = "{$db_password}";

//数据库名称 (表名) (默认与数据库用户名相同)
\$db_name = "{$db_name}";

//敏感信息修改安全码 建议设置复杂一些
\$Like_Code = "{$like_code}";

//版本号
\$version = 20251105;

PHP;

// 保存配置
if (file_put_contents($config_path, $config_content) === false) {
    die("写入配置文件！");
}

// 尝试连接数据库
$conn = new mysqli($db_address, $db_username, $db_password, $db_name);
if ($conn->connect_error) {
    die("数据库连接失败：" . $conn->connect_error);
}

// 导入 SQL 文件
$sql_file = __DIR__ . '/likegirl-cd_db.sql';
if (!file_exists($sql_file)) {
    die("找不到 likegirl-cd_db.sql 文件！");
}

$sql = file_get_contents($sql_file);
if (!$conn->multi_query($sql)) {
    die("SQL导入失败：" . $conn->error);
}

// 清理所有结果
do {
    if ($result = $conn->store_result()) {
        $result->free();
    }
} while ($conn->more_results() && $conn->next_result());

$conn->close();

// 跳转到登录页面
header("Location: ../login.php");
exit;
?>