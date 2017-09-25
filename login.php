<?php
session_start();
include('conn.php');        //需要放置在mysql_real_escape_string();之前，因为mysql_real_escape_string();需要先连接数据库。本地测试通过但vestacp不通过，原因未知。
//注销登录
if(@$_GET['action'] == "logout"){
	unset($_SESSION['userid']);
	unset($_SESSION['username']);
	echo '注销登录成功！点击此处 <a href="login.html">登录</a>';
	exit;
}

//登录
if(!isset($_POST['submit'])){
	exit('非法访问!');
}
$username = htmlspecialchars($_POST['username']);
$password = MD5($_POST['password']);
$username = mysql_real_escape_string($username);
$password = mysql_real_escape_string($password);
//包含数据库连接文件
//include('conn.php');
//检测用户名及密码是否正确
$check_query = mysql_query("select uid from user where username='$username' and password='$password' limit 1");
if($result = mysql_fetch_array($check_query)){
	//登录成功
	$_SESSION['username'] = $username;
	$_SESSION['userid'] = $result['uid'];
	echo "<meta http-equiv=\"refresh\" content=\"1;url=index.php\">";
	echo $username,' 欢迎你！进入 <a href="./index.php">用户中心</a><br />';
	echo '点击此处 <a href="login.php?action=logout">注销</a> 登录！<br />';
	exit;
} else {
	exit('登录失败！点击此处 <a href="javascript:history.back(-1);">返回</a> 重试');
}
?>